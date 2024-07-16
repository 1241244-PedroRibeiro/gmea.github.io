<?php
    session_start();
    include "./generals/config.php";
    $mysqli = new mysqli($bd_host, $bd_user, $bd_password, $bd_database);

    if ($mysqli->connect_error) {
        die('Erro: (' . $mysqli->connect_errno . ') ' . $mysqli->connect_error);
    }
    if (empty($_SESSION["session_id"]) && empty($_POST["login"]) && empty($_POST["user"]) && empty($_POST["password"]) || $_SESSION["type"]<3) {
        header("Location: ../index.php");
        exit;
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
    <div class="container mb-3">
        <label for="acao" class="form-label">Selecione uma ação:</label>
        <select name="acao" id="acao" class="form-select">
            <option value="">Selecione</option>
            <option value="adicionar">Adicionar Inventário</option>
            <option value="editar">Editar Informações de Inventário</option>
            <option value="consultar">Consultar Inventário</option>
            <option value="atribuir">Atribuir Inventário</option>
            <option value="eliminar">Eliminar Inventário</option>
        </select>
    </div>


    <div class="container mt-5">
        <h2 class="mt-5 text-center">Escolha uma opção:</h2>
        <form method="POST" action="">
            <div class="form-group">
                <select name="opcao" class="form-select" onchange="mostrarFormulario()">
                    <option value="">Selecione</option>
                    <option value="instrumento">Instrumento</option>
                    <option value="farda">Farda</option>
                </select>
            </div>

            <div id="formulario" class="mt-4"></div>

            <div class="mt-4">
                <input style="background-color: #00631b; border-color: black;" type="submit" class="btn btn-primary" value="Submeter">
            </div>
        </form>
    </div>

    <script>
        function mostrarFormulario() {
            var opcao = document.getElementsByName("opcao")[0].value;
            var formulario = document.getElementById("formulario");
            formulario.innerHTML = "";

            if (opcao === "instrumento") {
                formulario.innerHTML = `
                    <div class="form-group">
                        <label for="instrumento">Escolha um instrumento:</label>
                        <select name="instrumento" class="form-select">
                            <option value="">Selecione</option>
                            <option value="Clarinete">Clarinete</option>
                            <option value="Clarinete Baixo">Clarinete Baixo</option>
                            <option value="Requinta">Requinta</option>
                            <option value="Flauta Transversal">Flauta Transversal</option>
                            <option value="Flautim">Flautim</option>
                            <option value="Violino">Violino</option>
                            <option value="Viola d'Arco">Viola d'Arco</option>
                            <option value="Violoncelo">Violoncelo</option>
                            <option value="Contrabaixo">Contrabaixo</option>
                            <option value="Guitarra">Guitarra</option>
                            <option value="Saxofone Alto">Saxofone Alto</option>
                            <option value="Saxofone Soprano">Saxofone Soprano</option>
                            <option value="Saxofone Tenor">Saxofone Tenor</option>
                            <option value="Saxofone Barítono">Saxofone Barítono</option>
                            <option value="Tuba">Tuba</option>
                            <option value="Trombone">Trombone</option>
                            <option value="Trompete">Trompete</option>
                            <option value="Trompa">Trompa</option>
                            <option value="Fagote">Fagote</option>
                            <option value="Baixo Elétrico">Baixo Elétrico</option>
                            <option value="Guitarra Elétrica">Guitarra Elétrica</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="des">Descrição:</label>
                        <input type="text" name="des" class="form-control">
                    </div>
                </div>
            `;
        } else if (opcao === "farda") {
            formulario.innerHTML = `
                <div class="form-group">
                    <label for="tipoFarda">Escolha o tipo de peça da farda:</label>
                    <select name="tipoFarda" class="form-select">
                        <option value="">Selecione</option>
                        <option value="Chapéu">Chapéu</option>
                        <option value="Casaco">Casaco</option>
                        <option value="Camisa">Camisa</option>
                        <option value="Calças">Calças</option>
                    </select>
                </div>
                <div class="form-group">
                    <label for="genero">Escolha o género:</label>
                    <select name="genero" class="form-select">
                        <option value="">Selecione</option>
                        <option value="Homem">Homem</option>
                        <option value="Mulher">Mulher</option>
                    </select>
                </div>
                <div class="form-group">
                    <label for="tamanho">Tamanho:</label>
                    <input type="number" name="tamanho" class="form-control">
                </div>
            `;
        }
    }
            // Adiciona um listener para o evento de mudança no select de ação
            document.getElementById("acao").addEventListener("change", function() {
            var acao = this.value;

            // Redireciona para a página correspondente
            if (acao === 'adicionar') {
                window.location.href = "adicionar-inventario.php";
            } else if (acao === 'editar') {
                window.location.href = "editar-inventario.php";
            } else if (acao === 'consultar') {
                window.location.href = "consultar-inventario.php";
            } else if (acao === 'atribuir') {
                window.location.href = "atribuir-inventario.php";
            } else if (acao === 'eliminar') {
                window.location.href = "eliminar-inventario.php";
            }
        });
    </script>

<?php
// Verifica se o formulário foi enviado
if ($_SERVER["REQUEST_METHOD"] === "POST") {
    // Obtém os valores enviados do formulário
    $opcao = $_POST["opcao"];

    $conn = new mysqli($bd_host, $bd_user, $bd_password, $bd_database);

    // Verifica se houve um erro na conexão
    if ($conn->connect_error) {
        die("Erro na conexão com o banco de dados: " . $conn->connect_error);
    }

    // Insere os dados na tabela correspondente
    if ($opcao === "instrumento") {
        $instrumento = $_POST["instrumento"];
        $des = $_POST["des"];
        if (!empty($instrumento)) {
            $sql = "INSERT INTO instrumentos (cat, des) VALUES ('$instrumento', '$des')";
            if ($conn->query($sql) === TRUE) {
                echo '<div style="width: 70%; margin: auto;" class="alert alert-success mt-4">Dados do instrumento inseridos com sucesso!</div>';
            } else {
                echo '<div style="width: 70%; margin: auto;" class="alert alert-danger mt-4">Erro ao inserir dados do instrumento: ' . $conn->error . '</div>';
            }
        }
    } elseif ($opcao === "farda") {
        $tipoFarda = $_POST["tipoFarda"];
        $genero = $_POST["genero"];
        $tamanho = $_POST["tamanho"];
        if (!empty($tipoFarda) && !empty($genero) && !empty($tamanho)) {
            $sql = "INSERT INTO fardas (tipo, genero, tamanho) VALUES ('$tipoFarda', '$genero', $tamanho)";
            if ($conn->query($sql) === TRUE) {
                echo '<div style="width: 70%; margin: auto;" class="alert alert-success mt-4">Dados da farda inseridos com sucesso!</div>';
            } else {
                echo '<div style="width: 70%; margin: auto;" class="alert alert-danger mt-4">Erro ao inserir dados da farda: ' . $conn->error . '</div>';
            }
        }
    }
    $conn->close();
}
?>

<?php
    include "footer-reservado.php";
?>

</body>
</html>
