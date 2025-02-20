<?php
session_start();
ini_set('display_errors', 0);
include "./generals/config.php";
$mysqli = new mysqli($bd_host, $bd_user, $bd_password, $bd_database);

if ($mysqli->connect_error) {
    die('Erro: (' . $mysqli->connect_errno . ') ' . $mysqli->connect_error);
}

if (empty($_SESSION["session_id"]) || $_SESSION["type"] < 2) {
    header("Location: ../index.php");
    exit;
}

$user = $_SESSION["username"];

// Definir a quantidade máxima de notícias por página
$noticiasPorPagina = 10;

// Determinar a página atual
$paginaAtual = 1;
if (!empty($_GET["page"]) && is_numeric($_GET["page"])) {
    $paginaAtual = $_GET["page"];
}

// Processar o filtro de título
$filterTitle = "";
if (!empty($_GET["filter_title"])) {
    $filterTitle = $_GET["filter_title"];
}

// Calcular o offset para a consulta SQL com base na página atual
$offset = ($paginaAtual - 1) * $noticiasPorPagina;

// Recuperar notícias do banco de dados com limite e offset
$query = "SELECT n.id_noticia, nt.titulo_noticia FROM noticias_info n
          INNER JOIN noticias_titulo nt ON n.id_noticia = nt.id_noticia
          WHERE nt.titulo_noticia LIKE ? AND n.user = '$user'
          ORDER BY n.id_noticia DESC LIMIT ? OFFSET ?";
$statement = $mysqli->prepare($query);
$filterTitleParam = "%" . $filterTitle . "%";
$statement->bind_param("sii", $filterTitleParam, $noticiasPorPagina, $offset);
$statement->execute();
$result = $statement->get_result();
$noticias = $result->fetch_all(MYSQLI_ASSOC);

// Contar o total de notícias para calcular o número total de páginas
$queryTotal = "SELECT COUNT(*) AS total FROM noticias_info n
               INNER JOIN noticias_titulo nt ON n.id_noticia = nt.id_noticia
               WHERE nt.titulo_noticia LIKE ? AND n.user = '$user'";
$statementTotal = $mysqli->prepare($queryTotal);
$statementTotal->bind_param("s", $filterTitleParam);
$statementTotal->execute();
$resultTotal = $statementTotal->get_result();
$rowTotal = $resultTotal->fetch_assoc();
$totalNoticias = $rowTotal['total'];
$totalPaginas = ceil($totalNoticias / $noticiasPorPagina);

// Processar a edição da notícia
if (!empty($_GET["edit_id"])) {
    $idNoticiaEditar = $_GET["edit_id"];

    // Recuperar detalhes da notícia a partir do banco de dados
    $query = "SELECT nt.titulo_noticia, txt.texto_noticia 
              FROM noticias_titulo nt
              INNER JOIN noticias_texto txt ON nt.id_noticia = txt.id_noticia
              WHERE nt.id_noticia = ?";
    $statement = $mysqli->prepare($query);
    $statement->bind_param("i", $idNoticiaEditar);
    $statement->execute();
    $result = $statement->get_result();
    $noticiaEditar = $result->fetch_assoc();

    // Recuperar fotos da notícia a partir do banco de dados
    $queryFotos = "SELECT fotos_noticia FROM noticias_fotos WHERE id_noticia = ?";
    $statementFotos = $mysqli->prepare($queryFotos);
    $statementFotos->bind_param("i", $idNoticiaEditar);
    $statementFotos->execute();
    $resultFotos = $statementFotos->get_result();
    $fotosNoticia = $resultFotos->fetch_all(MYSQLI_ASSOC);

    // Verificar se a notícia foi editada e mostrar o modal de sucesso
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        $novoTitulo = $_POST["titulo"];
        $novoTexto = $_POST["texto"];

        // Atualizar o título da notícia na tabela noticias_titulo
        $query = "UPDATE noticias_titulo SET titulo_noticia = ? WHERE id_noticia = ?";
        $statement = $mysqli->prepare($query);
        $statement->bind_param("si", $novoTitulo, $idNoticiaEditar);
        $statement->execute();

        // Atualizar o texto da notícia na tabela noticias_texto
        $query = "UPDATE noticias_texto SET texto_noticia = ? WHERE id_noticia = ?";
        $statement = $mysqli->prepare($query);
        $statement->bind_param("si", $novoTexto, $idNoticiaEditar);
        $statement->execute();

        // Remover fotos selecionadas
        if (!empty($_POST["fotos_remover"])) {
            foreach ($_POST["fotos_remover"] as $fotoRemover) {
                // Remover a foto do banco de dados e do servidor
                $queryDeleteFoto = "DELETE FROM noticias_fotos WHERE id_noticia = ? AND fotos_noticia = ?";
                $statementDeleteFoto = $mysqli->prepare($queryDeleteFoto);
                $statementDeleteFoto->bind_param("is", $idNoticiaEditar, $fotoRemover);
                $statementDeleteFoto->execute();

                // Remover a foto do diretório
                $caminhoFoto = "../" . $fotoRemover;
                if (file_exists($caminhoFoto)) {
                    unlink($caminhoFoto);
                }
            }
        }

        // Lidar com o envio de novas fotos
        if (!empty($_FILES["fotos"]["tmp_name"][0])) {
            foreach ($_FILES["fotos"]["tmp_name"] as $key => $tmp_name) {
                $file_name = $_FILES["fotos"]["name"][$key];
                $file_tmp = $_FILES["fotos"]["tmp_name"][$key];

                if ($file_name) {
                    $extension = pathinfo($file_name, PATHINFO_EXTENSION);
                    $new_filename = uniqid() . '.' . $extension;
                    $destination = '../noticias-fotos/' . $new_filename;

                    // Mova o arquivo para o diretório de destino
                    move_uploaded_file($file_tmp, $destination);

                    // Caminho relativo da nova foto
                    $caminhoNovaFoto = "noticias-fotos/" . $new_filename;

                    // Insira a nova foto na tabela noticias_fotos
                    $queryInsert = "INSERT INTO noticias_fotos (id_noticia, fotos_noticia) VALUES (?, ?)";
                    $statementInsert = $mysqli->prepare($queryInsert);
                    $statementInsert->bind_param("is", $idNoticiaEditar, $caminhoNovaFoto);
                    $statementInsert->execute();
                }
            }
        }

        // Mostrar modal de sucesso
        echo '<script>$("#modalSucesso").modal("show");</script>';
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Editar Notícia</title>
    <link rel="shortcut icon" type="image/png" href="media/logo.png" />
    <script src="https://use.fontawesome.com/releases/v6.3.0/js/all.js" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.3.1/jquery.min.js" crossorigin="anonymous"></script>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js"></script>
    <link href="https://cdn.quilljs.com/1.3.6/quill.snow.css" rel="stylesheet">
</head>

<body>

    <div style="margin-top: 0;">
        <img style="width: 100%; height: auto;" src="./media/topAR.png" class="img-responsive">
    </div>

    <?php
    if ($_SESSION["type"] == 2) {
        include "header-profs.php";
    }
    if ($_SESSION["type"] == 3) {
        include "header-direcao.php";
    }
    if ($_SESSION["type"] == 4) { // Mostrar cabeçalho para professores
        include "header-professor-direcao.php";
    }
    ?>

    <div class="container">
        <h2>Editar Notícia</h2>
        <div class="mb-3">
            <form method="GET">
                <label for="filter_title" class="form-label">Filtrar por Título:</label>
                <input type="text" class="form-control" id="filter_title" name="filter_title" value="<?php echo $filterTitle; ?>">
                <button type="submit" class="btn btn-primary mt-2">Filtrar</button>
            </form>
        </div>
        <div class="table-responsive">
            <table class="table table-striped">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Título</th>
                        <th>Ações</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($noticias as $noticia) : ?>
                        <tr>
                            <td><?php echo $noticia['id_noticia']; ?></td>
                            <td><?php echo $noticia['titulo_noticia']; ?></td>
                            <td>
                                <a href="?edit_id=<?php echo $noticia['id_noticia']; ?>" class="btn btn-primary">Editar</a>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
        <nav aria-label="Page navigation example">
            <ul class="pagination">
                <?php if ($paginaAtual > 1) : ?>
                    <li class="page-item"><a class="page-link" href="?filter_title=<?php echo $filterTitle; ?>&page=<?php echo $paginaAtual - 1; ?>">Anterior</a></li>
                <?php endif; ?>
                <?php for ($i = 1; $i <= $totalPaginas; $i++) : ?>
                    <li class="page-item <?php if ($i == $paginaAtual) echo 'active'; ?>"><a class="page-link" href="?filter_title=<?php echo $filterTitle; ?>&page=<?php echo $i; ?>"><?php echo $i; ?></a></li>
                <?php endfor; ?>
                <?php if ($paginaAtual < $totalPaginas) : ?>
                    <li class="page-item"><a class="page-link" href="?filter_title=<?php echo $filterTitle; ?>&page=<?php echo $paginaAtual + 1; ?>">Próxima</a></li>
                <?php endif; ?>
            </ul>
        </nav>
        <?php if (!empty($noticiaEditar)) : ?>
            <h3>Editar Notícia</h3>
            <form method="POST" enctype="multipart/form-data" id="altNoticia">
                <div class="mb-3">
                    <label for="titulo" class="form-label">Título:</label>
                    <input type="text" class="form-control" id="titulo" name="titulo" value="<?php echo $noticiaEditar['titulo_noticia']; ?>" required>
                </div>
                <div class="mb-3">
                    <label for="editor-container" class="form-label">Texto:</label>
                    <?php 
                    // Converter o HTML recuperado em texto normal
                    $textoNormal = htmlspecialchars_decode($noticiaEditar['texto_noticia']);
                    ?>
                    <div id="editor-container" style="height: 300px;"><?php echo $textoNormal; ?></div>
                    <input type="hidden" id="texto" name="texto" value="<?php echo htmlspecialchars($noticiaEditar['texto_noticia']); ?>" required>
                </div>

                <div class="mb-3">
                    <label for="fotos" class="form-label">Fotos já existentes:</label>
                    <div class="row">
                        <?php 
                        // Exibir fotos existentes
                        foreach ($fotosNoticia as $foto) {
                            $caminhoFoto = $foto['fotos_noticia'];
                            echo '<div class="col-md-3 mb-3">';
                            echo '<a href="../' . $caminhoFoto . '" target="_blank"><img src="../' . $caminhoFoto . '" class="img-thumbnail" style="max-height: 150px;"></a>';
                            echo '<br/><input type="checkbox" name="fotos_remover[]" value="' . $caminhoFoto . '"> Remover';
                            echo '</div>';
                        }
                        ?>
                    </div>
                    <input type="file" class="form-control mt-3" id="fotos" name="fotos[]" multiple>
                </div>
                <button type="submit" class="btn btn-primary">Salvar Alterações</button>
            </form>
        <?php endif; ?>
    </div>



    <!-- Modal de Sucesso -->
    <div class="modal fade" id="modalSucesso" tabindex="-1" aria-labelledby="modalSucessoLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="modalSucessoLabel">Sucesso</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    A notícia foi editada com sucesso.
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Fechar</button>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.quilljs.com/1.3.6/quill.min.js"></script>
    <script>
        var quill = new Quill('#editor-container', {
            theme: 'snow'
        });

        document.addEventListener('DOMContentLoaded', function () {
            var form = document.querySelector('#altNoticia');
            console.log(form);

            form.addEventListener('submit', function (event) {
                event.preventDefault();

                // Obter o conteúdo HTML atual do editor Quill
                var editorContent = document.querySelector('#editor-container .ql-editor').innerHTML;
                document.querySelector('input[name="texto"]').value = editorContent;

                // Enviar o formulário após atribuir o conteúdo do editor ao campo oculto
                form.submit();
            });
        });



    </script>

    <script>
        $(document).ready(function () {
            // Oculta o modal ao carregar a página
            $('#modalSucesso').modal('hide');
        });

        // Redireciona para a página de edição de notícias após fechar o modal
        $('#modalSucesso').on('hidden.bs.modal', function () {
            window.location.href = 'editar-noticias.php';
        });

        // Mostra o modal de sucesso após a edição da notícia
        <?php if (!empty($noticiaEditar) && $_SERVER["REQUEST_METHOD"] == "POST") : ?>
            $(window).on('load', function () {
                $('#modalSucesso').modal('show');
            });
        <?php endif; ?>
    </script>

    <?php
    include "footer-reservado.php";
    ?>

</body>

</html>
