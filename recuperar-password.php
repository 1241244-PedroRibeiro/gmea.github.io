<?php
session_start();
require_once("generals/config.php");

$mysqli = new mysqli($bd_host, $bd_user, $bd_password, $bd_database);

if ($mysqli->connect_error) {
    die('Erro: (' . $mysqli->connect_errno . ') ' . $mysqli->connect_error);
}

// Load Composer's autoloader
require 'generals/vendor/autoload.php';
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;
require 'generals/vendor/phpmailer/phpmailer/src/Exception.php';
require 'generals/vendor/phpmailer/phpmailer/src/PHPMailer.php';
require 'generals/vendor/phpmailer/phpmailer/src/SMTP.php';

$mail = new PHPMailer();
$mail->IsSMTP();
$mail->Mailer = "smtp";

$etapa = "recuperar";
$user = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (isset($_POST["recuperar"])) {
        // Etapa 1: Receber o 'user' do formulário
        $user = $_POST['user'];
        $_SESSION['user'] = $user;

        // Etapa 2: Obter o e-mail do usuário e gerar um código único
        // Conexão com o banco de dados

        // Verificar se o 'user' existe na tabela 'users1' e obter o e-mail associado
        $query = "SELECT nome, email FROM users1 WHERE user = '$user'";
        $result = $mysqli->query($query);

        if ($result->num_rows > 0) {
            $row = $result->fetch_assoc();
            $email = $row['email'];
            $nome = $row['nome'];

            // Verificar se existe um código de recuperação na sessão, caso contrário, gerar um novo

            $_SESSION['codigo_recuperacao'] = sprintf('%06d', mt_rand(1, 999999));

            // Server settings
            $mail->SMTPDebug = SMTP::DEBUG_OFF;
            $mail->isSMTP();
            $mail->Host = 'smtp.gmail.com';
            $mail->SMTPAuth = true;
            $mail->Username = 'gmeasuporte@gmail.com';
            $mail->Password = 'ylav npkg syjg hdiu';
            $mail->SMTPSecure = PHPMailer::ENCRYPTION_SMTPS;
            $mail->Port = 465;

            // Recipients
            $mail->setFrom('gmeasuporte@gmail.com', 'GMEA');
            $mail->addAddress($email, $nome);

            // Content
            $mail->isHTML(true);
            $mail->Subject = 'RECUPERAÇÃO DE PASSWORD - gmea.pt (GMEA)';
            $mail->Body = 'Olá, <b>' . $nome . '</b>! <br> Recebemos um pedido de recuperação de password da tua parte. Este é o código para o fazeres: <br> <b>' . $_SESSION['codigo_recuperacao'] . '</b> <br> Não foste tu? Então, basta ignorares este e-mail. Não forneças este código a ninguém. <br><br> Atentamente, <br><b>A equipa de suporte do GMEA</b>';
            $mail->AltBody = 'This is the body in plain text for non-HTML mail clients';

            $enviado = $mail->send();

            // E-mail foi enviado com sucesso, agora alteramos a etapa para "alterar"
            if ($enviado) {
                $etapa = "alterar";
                $query = "INSERT INTO recuperacao (user, confirmacao) VALUES ('$user', '" . $_SESSION['codigo_recuperacao'] . "')";
                $mysqli->query($query);
                echo '<script>document.getElementById("recuperar-form").style.display = "none";</script>';
                echo '<script>document.getElementById("alterar-form").style.display = "block";</script>';
            } else {
                echo '<script>document.getElementById("error-message").style.display = "block";</script>';
            }
        } else {
            echo '<script>document.getElementById("error-message").style.display = "block";</script>';
        }
    } elseif (isset($_POST["submeter"])) {
        // Etapa 3: Página de alteração de senha
        $entered_code = $_POST["codigo"];
        $nova_password = $_POST["nova_password"];
        $confirmar_password = $_POST["confirmar_password"];

        // Compare the entered code with the code stored in the session
        if ($entered_code === $_SESSION['codigo_recuperacao']) {
            if ($nova_password === $confirmar_password) {
                // Hash the new password
                $senha_hash = password_hash($nova_password, PASSWORD_BCRYPT);

                // Update the user's password in the 'users1' table
                $query = "UPDATE users1 SET password = '$senha_hash' WHERE user = '" . $_SESSION['user'] . "'";
                $mysqli->query($query);

                // Remove the record from the 'recuperacao' table (to avoid reusing the code)
                $query = "DELETE FROM recuperacao WHERE user = '$user' AND confirmacao = '" . $_SESSION['codigo_recuperacao'] . "'";
                $mysqli->query($query);

                // Unset the code from the session
                unset($_SESSION['codigo_recuperacao']);
                unset($_SESSION['user']);

                echo '<script>document.getElementById("alterar-form").style.display = "none";</script>';
                echo '<script>document.getElementById("success-message").style.display = "block";</script>';
            } else {
                echo '<script>document.getElementById("error-message").style.display = "block";</script>';
            }
        } else {
            echo '<script>document.getElementById("error-message").style.display = "block";</script>';
        }
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Recuperar Password</title>
    <link rel="shortcut icon" type="image/png" href="media/logo.png/"/>
    <script src="https://use.fontawesome.com/releases/v6.3.0/js/all.js" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.3.1/jquery.min.js" crossorigin="anonymous"></script>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js"></script>
</head>
<body>

<?php
include "header.php";
?>

<div class="container mt-5">
    <div class="row justify-content-center">
        <div class="col-md-6">
            <form style="display: <?php echo $etapa === 'recuperar' ? 'block' : 'none'; ?>" method="post" id="recuperar-form">
                <h2>Recuperar Password</h2>
                <div class="form-group">
                    <label for="user">Utilizador:</label>
                    <input type="text" class="form-control" name="user" id="user" required>
                </div>
                <br>
                <button style="background-color: #00631b;" type="submit" class="btn btn-primary" name="recuperar">Recuperar Password</button>
            </form>
            <form style="display: <?php echo $etapa === 'alterar' ? 'block' : 'none'; ?>" method="post" id="alterar-form">
                <h2>Alterar Password</h2>
                <div class="form-group">
                    <label for="codigo">Código:</label>
                    <input type="text" class="form-control" name="codigo" id="codigo" required>
                </div>
                <div class="form-group">
                    <label for="nova_password">Nova Password:</label>
                    <input type="password" class="form-control" name="nova_password" id="nova_password" required>
                </div>
                <div class="form-group">
                    <label for="confirmar_password">Confirmar Password:</label>
                    <input type="password" class="form-control" name="confirmar_password" id="confirmar_password" required>
                </div>
                <br>
                <button style="background-color: #00631b;" type="submit" class="btn btn-primary" name="submeter">Submeter</button>
            </form>
        </div>
    </div>
</div>


<script>
    const recuperarForm = document.getElementById("recuperar-form");
    const alterarForm = document.getElementById("alterar-form");

    <?php
    if ($etapa === "recuperar") {
        echo 'recuperarForm.style.display = "block";';
        echo 'alterarForm.style.display = "none";';
    } elseif ($etapa === "alterar") {
        echo 'recuperarForm.style.display = "none";';
        echo 'alterarForm.style.display = "block";';
    }
    ?>
</script>

</body>

<?php
include "footer.php";
?>

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
    const myModal = document.getElementById('myModal')
    const myInput = document.getElementById('myInput')

    myModal.addEventListener('shown.bs.modal', () => {
        myInput.focus()
    })
</script>