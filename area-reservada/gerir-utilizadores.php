<?php
ini_set('display_errors','Off');
ini_set('error_reporting', E_ALL );
define('WP_DEBUG', false);
define('WP_DEBUG_DISPLAY', false);
session_start();
include "./generals/config.php";
$mysqli = new mysqli($bd_host, $bd_user, $bd_password, $bd_database);

if ($mysqli->connect_error) {
    die('Erro: (' . $mysqli->connect_errno . ') ' . $mysqli->connect_error);
}

if (empty($_SESSION["session_id"]) || $_SESSION["type"] < 3) {
    header("Location: ../index.php");
    exit;
}

// Process form submission and insert data into the database
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $nome = $_POST['nome'];
        $morada1 = $_POST['morada1'];
        $morada2 = $_POST['morada2'];
        $nif = $_POST['nif'];
        $cc = $_POST['cc'];
        $data_nas = $_POST['data_nas'];
        $email = $_POST['email'];
        $telef = $_POST['telef'];
        $type = $_POST['type'];
        $foto = $_FILES['foto']['name'];
        $hashedPassword = password_hash($cc, PASSWORD_DEFAULT);
        $target_path = "fotos_perfil/";
        $target_file = $target_path . basename($foto);

        $imageFileType = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));

        $target_file = $target_path . uniqid() . "." . $imageFileType;
        $foto = $target_file;

        // Verifica as categorias selecionadas
        if ($type === '1') {
            inserirUsuario($conexao, $nome, $morada1, $morada2, $nif, $cc, $data_nas, $email, $telef, 1, $hashedPassword, $foto);
            $mensagem = "Utilizador inserido com sucesso";
        } elseif ($type === '2') {
            inserirUsuario($conexao, $nome, $morada1, $morada2, $nif, $cc, $data_nas, $email, $telef, 2, $hashedPassword, $foto);
            $mensagem = "Utilizador inserido com sucesso";
        } elseif ($type === '3') {
            inserirUsuario($conexao, $nome, $morada1, $morada2, $nif, $cc, $data_nas, $email, $telef, 3, $hashedPassword, $foto);
            $mensagem = "Utilizador inserido com sucesso";
        }

        move_uploaded_file($_FILES['foto']['tmp_name'], $target_file);
}




?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>GMEA</title>
    <link rel="shortcut icon" type="image/png" href="media/logo.png" />
    <script src="https://use.fontawesome.com/releases/v6.3.0/js/all.js" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.3.1/jquery.min.js" crossorigin="anonymous"></script>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js"></script>
    <link href="https://netdna.bootstrapcdn.com/font-awesome/3.2.1/css/font-awesome.css" rel="stylesheet">

    <style>
        @keyframes fadeIn {
            0% {
                opacity: 0;
            }

            100% {
                opacity: 1;
            }
        }

        .contact-info {
            text-align: right;
        }
    </style>
</head>

<body>
    <div style="margin-top: 0;">
        <img style="width: 100%; height: auto;" src="./media/topAR.png" class="img-responsive">
    </div>

    <?php
        if ($_SESSION["type"] == 3) { // Mostrar cabeçalho para professores
            include "header-direcao.php";
        }
        if ($_SESSION["type"] == 4) { // Mostrar cabeçalho para professores
            include "header-professor-direcao.php";
        } 
    ?>


    <!DOCTYPE html>

    <div class="container">

    <h2>Selecione uma opção:</h2>
    <select class="form-select" id="opcoes" onchange="mostrarOpcoes()">
        <option value="0">Selecione</option>
        <option value="criar">Adicionar Utilizador</option>
        <option value="editar">Editar Utilizador</option>
        <option value="eliminar">Desativar Utilizador</option>
    </select>

    <div id="opcoesContainer"></div>

    <script>
        function mostrarOpcoes() {
            var selecionado = document.getElementById("opcoes").value;
            var container = document.getElementById("opcoesContainer");

            if (selecionado === "criar") {

                    // Carregar conteúdo do arquivo inserir-aulas.php
                    fetch('criar-utilizador.php')
                    .then(response => response.text())
                    .then(data => {
                        container.innerHTML += data;
                        executaScripts(container); // Adicionar esta linha
                    });

            } else if (selecionado === "editar") {

                    // Carregar conteúdo do arquivo inserir-aulas.php
                    window.location.href = 'editar-utilizador.php';
                
            } else if (selecionado === "eliminar") {

                    // Carregar conteúdo do arquivo inserir-aulas.php
                    window.location.href = 'eliminar-utilizadores.php';

            } else {
                container.innerHTML = ""; // Limpar o conteúdo se não for "criar"
            }
        }

        function executaScripts(container) {
            // Extrai scripts da string HTML e os executa
            var scripts = container.getElementsByTagName('script');
            for (var i = 0; i < scripts.length; i++) {
                eval(scripts[i].innerText);
            }
        }

        
    </script>

                <?php
                    if (isset($mensagem)) {
                        print("<br/>");
                        echo "<div class='alert alert-info'>$mensagem</div>";
                    }
                ?>

    </div>


    <?php include "footer-reservado.php"; ?>



</body>

</html>