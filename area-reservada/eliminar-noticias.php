<?php
session_start();
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
$type = $_SESSION["type"];

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

if ($type == 3) {
    // Recuperar notícias do banco de dados com limite e offset
    $query = "SELECT n.id_noticia, nt.titulo_noticia FROM noticias_info n
    INNER JOIN noticias_titulo nt ON n.id_noticia = nt.id_noticia
    WHERE nt.titulo_noticia LIKE ?
    ORDER BY n.id_noticia DESC LIMIT ? OFFSET ?";
}
else {
    // Recuperar notícias do banco de dados com limite e offset
    $query = "SELECT n.id_noticia, nt.titulo_noticia FROM noticias_info n
    INNER JOIN noticias_titulo nt ON n.id_noticia = nt.id_noticia
    WHERE nt.titulo_noticia LIKE ? AND user = '$user'
    ORDER BY n.id_noticia DESC LIMIT ? OFFSET ?";
}
$statement = $mysqli->prepare($query);
$filterTitleParam = "%" . $filterTitle . "%";
$statement->bind_param("sii", $filterTitleParam, $noticiasPorPagina, $offset);
$statement->execute();
$result = $statement->get_result();
$noticias = $result->fetch_all(MYSQLI_ASSOC);

// Contar o total de notícias para calcular o número total de páginas
if ($type == 3) {
    $queryTotal = "SELECT COUNT(*) AS total FROM noticias_info n
                   INNER JOIN noticias_titulo nt ON n.id_noticia = nt.id_noticia
                   WHERE nt.titulo_noticia LIKE ?";
} else {
    $queryTotal = "SELECT COUNT(*) AS total FROM noticias_info n
                   INNER JOIN noticias_titulo nt ON n.id_noticia = nt.id_noticia
                   WHERE nt.titulo_noticia LIKE ? AND n.user = ?";
}

$statementTotal = $mysqli->prepare($queryTotal);

if ($type == 3) {
    $statementTotal->bind_param("s", $filterTitleParam);
} else {
    $statementTotal->bind_param("ss", $filterTitleParam, $user);
}

$statementTotal->execute();
$resultTotal = $statementTotal->get_result();
$rowTotal = $resultTotal->fetch_assoc();
$totalNoticias = $rowTotal['total'];
$totalPaginas = ceil($totalNoticias / $noticiasPorPagina);


// Processar a exclusão da notícia
if (!empty($_POST["id_noticia"])) {
    $idNoticiaEliminar = $_POST["id_noticia"];

    // Excluir a notícia e suas informações relacionadas do banco de dados
    $queryDeleteInfo = "DELETE FROM noticias_info WHERE id_noticia = ?";
    $statementDeleteInfo = $mysqli->prepare($queryDeleteInfo);
    $statementDeleteInfo->bind_param("i", $idNoticiaEliminar);
    if ($statementDeleteInfo->execute()) {
        // Atraso de 1 segundo antes de exibir o modal de sucesso
        echo '<script>setTimeout(function() { $("#modalSucesso").modal("show"); }, 1);</script>';
    }
}
?>


<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Eliminar Notícia</title>
    <link rel="shortcut icon" type="image/png" href="media/logo.png" />
    <script src="https://use.fontawesome.com/releases/v6.3.0/js/all.js" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.3.1/jquery.min.js" crossorigin="anonymous"></script>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js"></script>
    <link href="https://netdna.bootstrapcdn.com/font-awesome/3.2.1/css/font-awesome.css" rel="stylesheet">
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
        <h2>Eliminar Notícia</h2>
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
                                <form method="POST">
                                    <input type="hidden" name="id_noticia" value="<?php echo $noticia['id_noticia']; ?>">
                                    <button type="button" class="btn btn-danger" data-bs-toggle="modal" data-bs-target="#modalEliminar<?php echo $noticia['id_noticia']; ?>">Eliminar</button>
                                </form>
                            </td>
                        </tr>
                        <!-- Modal de Confirmação de Eliminação -->
                        <div class="modal fade" id="modalEliminar<?php echo $noticia['id_noticia']; ?>" tabindex="-1" aria-labelledby="modalEliminarLabel<?php echo $noticia['id_noticia']; ?>" aria-hidden="true">
                            <div class="modal-dialog">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title" id="modalEliminarLabel<?php echo $noticia['id_noticia']; ?>">Eliminar Notícia</h5>
                                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                    </div>
                                    <div class="modal-body">
                                        Tem certeza que deseja eliminar esta notícia?
                                    </div>
                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                                        <form method="POST">
                                            <input type="hidden" name="id_noticia" value="<?php echo $noticia['id_noticia']; ?>">
                                            <button type="submit" class="btn btn-danger">Eliminar</button>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>
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
                    A notícia foi eliminada com sucesso.
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Fechar</button>
                </div>
            </div>
        </div>
    </div>

    <!-- Script para redirecionar após fechar o modal de sucesso -->

    <script>
        $('#modalSucesso').on('hidden.bs.modal', function (e) {
            window.location.href = 'eliminar-noticias.php';
        });
    </script>

<?php
include "footer-reservado.php";
?>


</body>

</html>
