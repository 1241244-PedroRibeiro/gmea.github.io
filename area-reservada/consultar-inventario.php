<?php
session_start();
include "./generals/config.php";
$mysqli = new mysqli($bd_host, $bd_user, $bd_password, $bd_database);

if ($mysqli->connect_error) {
    die('Erro: (' . $mysqli->connect_errno . ') ' . $mysqli->connect_error);
}
if (empty($_SESSION["session_id"]) && empty($_POST["login"]) && empty($_POST["user"]) && empty($_POST["password"]) || $_SESSION["type"] != 3) {
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
        include "header-direcao.php";
    ?>

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
                        <input type="text" name="instrumento" class="form-control">
                    </div>
                `;
            }
            else if (opcao === "farda") {
                formulario.innerHTML = `
                    <div class="form-group">
                        <label for="tipo">Tipo:</label>
                        <input type="text" name="tipo" class="form-control">
                    </div>
                    <div class="form-group">
                        <label for="genero">Género:</label>
                        <input type="text" name="genero" class="form-control">
                    </div>
                    <div class="form-group">
                        <label for="tamanho">Tamanho:</label>
                        <input type="text" name="tamanho" class="form-control">
                    </div>
                `;
            }
        }
    </script>

<?php
if (isset($_POST['opcao'])) {
    if ($_POST['opcao'] === 'instrumento' && isset($_POST['instrumento'])) {
        $filtro_instrumento = $_POST['instrumento'];

        $query = "SELECT cat, codigo FROM instrumentos WHERE cat = '$filtro_instrumento'";
        $result = $mysqli->query($query);

        if ($result) {
            echo '<div class="container mt-4">';
            if ($result->num_rows > 0) {
                echo '<table class="table">
                        <thead>
                            <tr>
                                <th scope="col">Categoria</th>
                                <th scope="col">Código</th>
                            </tr>
                        </thead>
                        <tbody>';

                while ($row = $result->fetch_assoc()) {
                    echo '<tr>
                            <td>' . $row['cat'] . '</td>
                            <td>' . $row['codigo'] . '</td>
                        </tr>';
                }

                echo '</tbody>
                    </table>';
            } else {
                echo '<div class="alert alert-warning" role="alert">Nenhum resultado encontrado.</div>';
            }
            echo '</div>';
        } else {
            echo '<div class="alert alert-danger" role="alert">Ocorreu um erro ao executar a consulta.</div>';
        }
    } elseif ($_POST['opcao'] === 'farda' && isset($_POST['tipo']) && isset($_POST['genero']) && isset($_POST['tamanho'])) {
        $filtro_tipo = $_POST['tipo'];
        $filtro_genero = $_POST['genero'];
        $filtro_tamanho = $_POST['tamanho'];

        $query = "SELECT tipo, genero, tamanho FROM fardas WHERE tipo = '$filtro_tipo' AND genero = '$filtro_genero' AND tamanho = '$filtro_tamanho'";
        $result = $mysqli->query($query);

        if ($result) {
            echo '<div class="container mt-4">';
            if ($result->num_rows > 0) {
                echo '<table class="table">
                        <thead>
                            <tr>
                                <th scope="col">Tipo</th>
                                <th scope="col">Género</th>
                                <th scope="col">Tamanho</th>
                            </tr>
                        </thead>
                        <tbody>';

                while ($row = $result->fetch_assoc()) {
                    echo '<tr>
                            <td>' . $row['tipo'] . '</td>
                            <td>' . $row['genero'] . '</td>
                            <td>' . $row['tamanho'] . '</td>
                        </tr>';
                }

                echo '</tbody>
                    </table>';
            } else {
                echo '<div class="alert alert-warning" role="alert">Nenhum resultado encontrado.</div>';
            }
            echo '</div>';
        } else {
            echo '<div class="alert alert-danger" role="alert">Ocorreu um erro ao executar a consulta.</div>';
        }
    }
}
?>

</body>
    <?php
        include "footer-reservado.php";
    ?>
</html>