<?php
session_start();
require_once("generals/config.php");
ini_set('display_errors', 0);

$mysqli = new mysqli($bd_host, $bd_user, $bd_password, $bd_database);

if ($mysqli->connect_error) {
    die('Erro: (' . $mysqli->connect_errno . ') ' . $mysqli->connect_error);
}

$successMessage = $errorMessage = '';

// Check user session and permissions
if (empty($_SESSION["session_id"]) || $_SESSION["type"] < 3) {
    header("Location: index.php");
    exit;
}

// Handle form submission
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Upload da imagem do banner
    if ($_FILES['banner_image_sobre_nos']['error'] === UPLOAD_ERR_OK) {
        $targetDir = 'content/';
        $targetFile = $targetDir . basename($_FILES['banner_image_sobre_nos']['name']);
        $uploadSuccess = move_uploaded_file($_FILES['banner_image_sobre_nos']['tmp_name'], '../' . $targetFile);
        if ($uploadSuccess) {
            $contents['banner_image_sobre_nos'] = $targetFile;
            $query = "UPDATE page_content SET content=? WHERE id='banner_image_sobre_nos'";
            $statement = $mysqli->prepare($query);
            $statement->bind_param('s', $targetFile);
            if ($statement->execute()) {
                $successMessage = "Imagem do banner atualizada com sucesso.";
            } else {
                $errorMessage = "Erro ao atualizar imagem do banner: " . $statement->error;
            }
            $statement->close();
        } else {
            $errorMessage = "Erro ao fazer upload da imagem do banner.";
        }
    }

    // Atualizar outros conteúdos
    foreach ($_POST as $id => $content) {
        if ($id != 'submit' && $id != 'banner_image_sobre_nos') {
            $query = "UPDATE page_content SET content=? WHERE id=?";
            $statement = $mysqli->prepare($query);
            $statement->bind_param('ss', $content, $id);
            if ($statement->execute()) {
                $successMessage = "Conteúdo atualizado com sucesso.";
            } else {
                $errorMessage = "Erro ao atualizar conteúdo: " . $statement->error;
            }
            $statement->close();
        }
    }
}

// Retrieve current content
$contents = [];
$queryContent = "SELECT id, content FROM page_content WHERE id IN ('banner_image_sobre_nos', 'banner_title_sobre_nos', 'sobre_nos_content')";
$result = $mysqli->query($queryContent);

if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $contents[$row['id']] = $row['content'];
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Gerir Sobre Nós</title>
    <link rel="shortcut icon" type="image/png" href="media/logo.png"/>
    <link rel="shortcut icon" type="image/png" href="media/logo.png" />
    <script src="https://use.fontawesome.com/releases/v6.3.0/js/all.js" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.3.1/jquery.min.js" crossorigin="anonymous"></script>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js"></script>
    <link href="https://netdna.bootstrapcdn.com/font-awesome/3.2.1/css/font-awesome.css" rel="stylesheet">
    <link href="https://cdn.quilljs.com/1.3.6/quill.snow.css" rel="stylesheet">
</head>
<body>
        <!-- Banner -->
        <div style="margin-top: 0;">
            <img style="width: 100%; height: auto;" src="./media/topAR.png" class="img-responsive">
        </div>

        <!-- Header -->
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
<div class="container mt-5">
    <h2>Gerir Conteúdo da Página "Sobre Nós"</h2>

    <?php if ($successMessage): ?>
        <div class="alert alert-success"><?php echo $successMessage; ?></div>
    <?php endif; ?>
    <?php if ($errorMessage): ?>
        <div class="alert alert-danger"><?php echo $errorMessage; ?></div>
    <?php endif; ?>

    <form action="gerir-sobre-nos.php" method="post" enctype="multipart/form-data">
        <div class="mb-3">
            <label for="banner_image_sobre_nos" class="form-label">Imagem do Banner</label>
            <input type="file" class="form-control" id="banner_image_sobre_nos" name="banner_image_sobre_nos">
        </div>
        <div class="mb-3">
            <label for="banner_title_sobre_nos" class="form-label">Título do Banner</label>
            <input type="text" class="form-control" id="banner_title_sobre_nos" name="banner_title_sobre_nos" value="<?php echo htmlspecialchars($contents['banner_title_sobre_nos'] ?? '', ENT_QUOTES); ?>">
        </div>
        <div class="mb-3">
            <label for="sobre_nos_content" class="form-label">Conteúdo</label>
            <div id="sobre_nos_editor" style="height: 200px;"><?php echo $contents['sobre_nos_content'] ?? ''; ?></div>
            <input type="hidden" name="sobre_nos_content" id="sobre_nos_content_hidden" value="<?php echo htmlspecialchars($contents['sobre_nos_content'] ?? '', ENT_QUOTES); ?>">
        </div>
        <button type="submit" class="btn btn-primary" name="submit">Salvar Alterações</button>
    </form>
</div>
<script src="https://cdn.quilljs.com/1.3.6/quill.js"></script>
<script>
    var sobreNosEditor = new Quill('#sobre_nos_editor', {
        theme: 'snow',
        modules: {
            toolbar: [
                [{ 'font': [] }],
                [{ 'size': ['small', false, 'large', 'huge'] }],
                ['bold', 'italic', 'underline', 'strike'],
                [{ 'color': [] }],
                ['link', 'image', 'video'],
                [{ 'align': [] }],
                ['clean']
            ]
        }
    });

    // Inicializa o valor do campo oculto com o conteúdo atual do editor Quill
    document.getElementById('sobre_nos_content_hidden').value = sobreNosEditor.root.innerHTML;

    sobreNosEditor.on('text-change', function(delta, oldDelta, source) {
        var htmlContent = sobreNosEditor.root.innerHTML;
        document.getElementById('sobre_nos_content_hidden').value = htmlContent;
    });
</script>
</body>
</html>

    <!-- Footer -->
    <?php include "footer-reservado.php"; ?>
