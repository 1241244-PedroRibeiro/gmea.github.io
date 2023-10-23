<?php
session_start();
require_once("generals/config.php");

$mysqli = new mysqli($bd_host, $bd_user, $bd_password, $bd_database);

if ($mysqli->connect_error) {
    die('Erro: (' . $mysqli->connect_errno . ') ' . $mysqli->connect_error);
}

if (empty($_SESSION["session_id"]) && empty($_POST["login"]) && empty($_POST["user"]) && empty($_POST["password"])) {
    header("Location: ../index.php");
    exit;
}

$user = $_SESSION["username"];

// Consulta SQL para obter as informações do usuário logado
$query = "SELECT nome, user, cc, data_nas, email, foto FROM users1 WHERE user = '$user'";
$result = $mysqli->query($query);
$row = $result->fetch_assoc();

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
    if ($_SESSION["type"] == 1) {
        include "header-alunos.php";
    }
    if ($_SESSION["type"] == 2) {
    }
    if ($_SESSION["type"] == 3) {
        include "header-direcao.php";
    }
    ?>

  <div class="container">
      <div class="row">
          <div class="col-6">
              <table class="table">
                  <tbody>
                      <tr>
                          <th>Nome:</th>
                          <td><?php echo $row['nome']; ?></td>
                      </tr>
                      <tr>
                          <th>Número:</th>
                          <td><?php echo substr($row['user'], 1); ?></td>
                      </tr>
                      <tr>
                          <th>Número do CC:</th>
                          <td><?php echo $row['cc']; ?></td>
                      </tr>
                      <tr>
                          <th>Data de Nascimento:</th>
                          <td><?php echo $row['data_nas']; ?></td>
                      </tr>
                      <tr>
                          <th>Email:</th>
                          <td><?php echo $row['email']; ?></td>
                      </tr>
                  </tbody>
              </table>
          </div>
          <div class="col-6" style="position: relative;">
              <div style="position: absolute; top: 0; bottom: 0; left: 0; right: 0; display: flex; justify-content: center; align-items: center;">
                  <img src="<?php echo $row['foto']; ?>" alt="Foto" style="max-height: 100%; max-width: 100%; object-fit: contain;">
              </div>
          </div>
      </div>
  </div>


    <?php
    include "footer-reservado.php";
    ?>

</body>

</html>