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

// Processamento do formulário de inserir notícia
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["titulo"], $_POST["quill_content"], $_FILES["fotos"])) {
    // Obtenha os valores enviados pelo formulário
    $titulo = $_POST["titulo"];
    $currentDate = date("Y-m-d");
    $textoNoticia = $_POST["quill_content"];
    $fotos = $_FILES["fotos"]["tmp_name"];

    // Insira a notícia na tabela noticias_info
    $query = "INSERT INTO noticias_info (data_noticia, user) VALUES (?, ?)";
    $statement = $mysqli->prepare($query);
    $statement->bind_param("ss", $currentDate, $user);
    $statement->execute();

    // Obtenha o ID da notícia recém-inserida
    $idNoticia = $mysqli->insert_id;

    // Insira o título da notícia na tabela noticias_titulo
    $query = "INSERT INTO noticias_titulo (id_noticia, titulo_noticia) VALUES (?, ?)";
    $statement = $mysqli->prepare($query);
    $statement->bind_param("ss", $idNoticia, $titulo);
    $statement->execute();

    // Insira o texto da notícia na tabela noticias_texto
    $query = "INSERT INTO noticias_texto (id_noticia, texto_noticia) VALUES (?, ?)";
    $statement = $mysqli->prepare($query);
    $statement->bind_param("ss", $idNoticia, $textoNoticia);
    $statement->execute();

    // Lide com o envio das fotos
    if (!empty($fotos)) {
        foreach ($fotos as $foto) {
            // Nome do arquivo
            $nomeArquivo = uniqid() . ".jpg";
            // Caminho para o diretório de destino
            $caminhoDestino = "../noticias-fotos/" . $nomeArquivo;
            
            // Mova o arquivo para o diretório de destino
            move_uploaded_file($foto, $caminhoDestino);

            // Caminho relativo da foto
            $caminhoFoto = "noticias-fotos/" . $nomeArquivo;

            // Insira a foto na tabela noticias_fotos
            $query = "INSERT INTO noticias_fotos (id_noticia, fotos_noticia) VALUES (?, ?)";
            $statement = $mysqli->prepare($query);
            $statement->bind_param("ss", $idNoticia, $caminhoFoto);
            $statement->execute();

            // Verifique se a inserção da foto foi bem-sucedida
            if ($statement->affected_rows > 0) {
                $_SESSION["message"] = "Notícia inserida com sucesso.";
            } else {
                $_SESSION["message"] = "Erro ao inserir a notícia.";
            }
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>GMEA - Gerir Alunos</title>
    <link rel="shortcut icon" type="image/png" href="media/logo.png" />
    <link href="https://cdn.quilljs.com/1.3.6/quill.snow.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://use.fontawesome.com/releases/v6.3.0/js/all.js" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.3.1/jquery.min.js" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js"></script>
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
    if ($_SESSION["type"] == 4) {
        include "header-professor-direcao.php";
    }
    ?>

    <div class="container">
        <h2>Inserir Notícia</h2>
        <form method="POST" enctype="multipart/form-data">
            <div class="mb-3">
                <label for="titulo" class="form-label">Título:</label>
                <input type="text" class="form-control" id="titulo" name="titulo" required>
            </div>
            <div class="mb-3">
                <label for="editor" class="form-label">Texto:</label>
                <div id="editor" style="height: 300px;"></div>
                <input type="hidden" name="quill_content" id="quill_content">
            </div>
            <div class="mb-3">
                <label for="fotos" class="form-label">Fotos:</label>
                <input type="file" class="form-control" id="fotos" name="fotos[]" multiple required>
            </div>
            <button type="submit" class="btn btn-primary">Inserir</button>
        </form>
        <?php if (isset($_SESSION["message"])): ?>
            <div class="alert alert-<?php echo ($statement->affected_rows > 0 ? "success" : "danger"); ?>" role="alert">
                <?php echo $_SESSION["message"]; ?>
            </div>
            <?php unset($_SESSION["message"]); ?>
        <?php endif; ?>
    </div>

    <script src="https://cdn.quilljs.com/1.3.6/quill.min.js"></script>
    <script>
        var form = document.querySelector('form');
        var editor = new Quill('#editor', {
            theme: 'snow'
        });

        form.onsubmit = function() {
            var quillContent = document.querySelector('#editor .ql-editor').innerHTML;
            document.querySelector('#quill_content').value = quillContent;
        };
    </script>
</body>

</html>

<?php include 'footer-reservado.php'; ?>