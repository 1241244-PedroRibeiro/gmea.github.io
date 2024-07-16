<?php
    session_start();
    ob_start();
    include "./generals/config.php";

    // Verifica se o usuário está logado
    if (empty($_SESSION["session_id"]) || $_SESSION["type"] < 2) {
        header("Location: ../index.php");
        exit;
    }
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>GMEA - Gestão de Notícias</title>
    <link rel="shortcut icon" type="image/png" href="media/logo.png" />
    <script src="https://use.fontawesome.com/releases/v6.3.0/js/all.js" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.3.1/jquery.min.js" crossorigin="anonymous"></script>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js"></script>
    <link href="https://netdna.bootstrapcdn.com/font-awesome/3.2.1/css/font-awesome.css" rel="stylesheet">
    <style>
    </style>
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

    <!-- Main Content -->
    <div class="container mt-5">
        <h1 class="mb-4">Gestão de Avaliações</h1>
        <form action="" method="POST">
            <div class="mb-3">
                <label for="acao" class="form-label">Selecione uma ação:</label>
                <select name="acao" id="acao" class="form-select">
                    <option value="">Selecione</option>
                    <option value="adicionar">Adicionar Avaliação</option>
                    <option value="editar">Alterar Avaliação</option>
                    <option value="eliminar">Eliminar Avaliação</option>
                </select>
            </div>
            <button type="submit" class="btn btn-primary">Ir</button>
        </form>

        <?php
            // Verifica se a ação foi selecionada
            if (isset($_POST['acao'])) {
                $acao = $_POST['acao'];

                // Redireciona para a página correspondente
                if ($acao === 'adicionar') {
                    header("Location: inserir-avaliacoes.php");
                    exit;
                } elseif ($acao === 'editar') {
                    header("Location: editar-avaliacoes.php");
                    exit;
                } elseif ($acao === 'eliminar') {
                    header("Location: eliminar-avaliacoes.php");
                    exit;
                }
            }
        ?>
    </div>

    <!-- Footer -->
    <?php include "footer-reservado.php"; ?>
</body>
</html>
