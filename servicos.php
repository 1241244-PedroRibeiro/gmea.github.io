<?php
session_start();
require_once("generals/config.php");

$mysqli = new mysqli($bd_host, $bd_user, $bd_password, $bd_database);

if ($mysqli->connect_error) {
    die('Erro: (' . $mysqli->connect_errno . ') ' . $mysqli->connect_error);
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>GMEA</title>
    <link rel="shortcut icon" type="image/png" href="media/logo.png"/>
    <script src="https://use.fontawesome.com/releases/v6.3.0/js/all.js" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.3.1/jquery.min.js" crossorigin="anonymous"></script>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js"></script>
    <style>
        @keyframes fadeIn {
            0% {
                opacity: 0;
            }
            100% {
                opacity: 1;
            }
        }

        body {
            animation: 2s ease-out 0s 1 fadeIn;
        }

        a:hover {
            color: red;
        }
    </style>
</head>
<body>
    <?php include "header.php"; ?>

    <div class="container mt-5">
        <h1 class="mb-4">Lista de Serviços</h1>
        <div class="table-responsive">
            <table class="table table-striped">
                <thead>
                    <tr>
                        <th>Tipo de Serviço</th>
                        <th>Data do Serviço</th>
                        <th>Hora do Serviço</th>
                        <th>Local do Serviço</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    $sql = "SELECT * FROM servicos";
                    $result = $mysqli->query($sql);

                    if ($result->num_rows > 0) {
                        while ($row = $result->fetch_assoc()) {
                            echo "<tr>";
                            echo "<td>" . $row['tipo_servico'] . "</td>";
                            echo "<td>" . $row['data_servico'] . "</td>";
                            echo "<td>" . $row['hora_servico'] . "</td>";
                            echo "<td>" . $row['local_servico'] . "</td>";
                            echo "</tr>";
                        }
                    } else {
                        echo "<tr><td colspan='4'>Nenhum serviço encontrado</td></tr>";
                    }
                    ?>
                </tbody>
            </table>
        </div>
    </div>

    <?php include "footer.php"; ?>
</body>
</html>

<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (isset($_POST["login"]) && isset($_POST["user"]) && isset($_POST["password"])) {
        $query = "SELECT password FROM users1 WHERE user=?";
        $statement = $mysqli->prepare($query);
        $statement->bind_param('s', $_POST["user"]);
        $statement->execute();
        $statement->bind_result($hashedPassword);

        if ($statement->fetch()) {
            $p = $_POST["password"];
            if (password_verify($p, $hashedPassword)) {
                // Fechar o resultado da primeira consulta
                $statement->close();

                // Executar a segunda consulta para obter o tipo de usuário
                $query = "SELECT type FROM users1 WHERE user=?";
                $statement = $mysqli->prepare($query);
                $statement->bind_param('s', $_POST["user"]);
                $statement->execute();
                $statement->bind_result($type);

                if ($statement->fetch()) {
                    $_SESSION["session_id"] = session_id();
                    $_SESSION["username"] = $_POST["user"];
                    $_SESSION["type"] = $type;
                    echo "<script>location.href='area-reservada/index.php';</script>";
                    exit;
                }
            }
        }

        echo '
        <script>
            document.addEventListener("DOMContentLoaded", function() {
                var body = document.getElementsByTagName("body")[0];
                body.classList.add("no-animations");

                var myModal = new bootstrap.Modal(document.getElementById("errorModal"));
                myModal.show();

                myModal.addEventListener("hidden.bs.modal", function() {
                    body.classList.remove("no-animations");
                });
            });
        </script>

        <div class="modal" tabindex="-1" id="errorModal">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">Erro</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <br>
                    <div style="width: 90%; margin: auto;" class="alert alert-danger">
                        <p style="text-align: center;">Utilizador ou Password incorreto(s).</p>
                    </div>
                    <br>
                    <a href="#" style="text-align: center; text-decoration: none; color: black;"><strong>Recuperar</strong> palavra-passe</a>
                    <br>
                </div>
            </div>
        </div>';

        $statement->close();
    }
}
?>

<script>
    const myModal = document.getElementById('myModal');
    const myInput = document.getElementById('myInput');

    myModal.addEventListener('shown.bs.modal', () => {
        myInput.focus();
    });
</script>