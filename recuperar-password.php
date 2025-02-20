<?php
session_start();
require_once("generals/config.php");
ini_set('display_errors', 0);

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
        // Etapa 1: Receber o 'user' e o 'email' do formulário
        $user = $_POST['user'];
        $email = $_POST['email'];
        $_SESSION['user'] = $user;

        // Etapa 2: Verificar se o 'user' existe na tabela 'users1' e se o e-mail corresponde
        $query = "SELECT nome, email FROM users1 WHERE user = '$user' AND email = '$email' AND estado=1";
        $result = $mysqli->query($query);

        if ($result->num_rows > 0) {
            $row = $result->fetch_assoc();
            $nome = $row['nome'];
        
            // Gerar um código único de recuperação
            $_SESSION['codigo_recuperacao'] = sprintf('%06d', mt_rand(99999, 999999));
    

            // Configurações do servidor de e-mail
            $mail->SMTPDebug = SMTP::DEBUG_OFF;
            $mail->isSMTP();
            $mail->Host = 'smtp.gmail.com';
            $mail->SMTPAuth = true;
            $mail->Username = 'gmeasuporte@gmail.com';
            $mail->Password = 'ylav npkg syjg hdiu';
            $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
            $mail->Port = 587;
            $mail->SMTPOptions = array(
                'ssl' => array(
                    'verify_peer' => false,
                    'verify_peer_name' => false,
                    'allow_self_signed' => true
                )
            );

            // Destinatário
            $mail->setFrom('gmeasuporte@gmail.com', 'GMEA');
            $mail->addAddress($email, $nome);

            // Conteúdo do e-mail
            $mail->isHTML(true);
            $mail->CharSet = 'UTF-8';
            $mail->Subject = 'RECUPERAÇÃO DE PASSWORD - gmea.pt (GMEA)';
            $mail->Body = 'Olá, <b>' . $nome . '</b>! <br> Recebemos um pedido de recuperação de password da tua parte. Este é o código para o fazeres: <br> <b>' . $_SESSION['codigo_recuperacao'] . '</b> <br> Não foste tu? Então, basta ignorares este e-mail. Não forneças este código a ninguém. <br><br> Atentamente, <br><b>A equipa de suporte do GMEA</b>';
            $mail->AltBody = 'This is the body in plain text for non-HTML mail clients';

            // Envio do e-mail
            $enviado = $mail->send();

            // Se o e-mail foi enviado com sucesso, altera a etapa para "alterar"
            if ($enviado) {
                $etapa = "alterar";
                // Obter a data e hora atual
                $currentDateTime = date('Y-m-d H:i:s');
            
                // Inserir o registro na tabela 'recuperacao' com a data e hora atual
                $query = "INSERT INTO recuperacao (user, confirmacao, data_hora) VALUES ('$user', '" . $_SESSION['codigo_recuperacao'] . "', '$currentDateTime')";
                $mysqli->query($query);
                echo '<script>document.getElementById("recuperar-form").style.display = "none";</script>';
                echo '<script>document.getElementById("alterar-form").style.display = "block";</script>';
            } else {
                echo '<script>document.getElementById("error-message").style.display = "block";</script>';
                echo 'Erro: ' . $mail->ErrorInfo;
            }
        } else {
            echo '<script>document.getElementById("error-message").style.display = "block";</script>';
            echo 'Erro: Usuário ou e-mail incorreto(s)';
        }
    } elseif (isset($_POST["submeter"])) {
        // Etapa 3: Página de alteração de senha
        $entered_code = $_POST["codigo"];
        $nova_password = $_POST["nova_password"];
        $confirmar_password = $_POST["confirmar_password"];

        // Comparar o código inserido com o código armazenado na sessão
        if ($entered_code === $_SESSION['codigo_recuperacao']) {
            if ($nova_password === $confirmar_password) {
                // Hash da nova senha
                $senha_hash = password_hash($nova_password, PASSWORD_BCRYPT);

                // Atualizar a senha do usuário na tabela 'users1'
                $query = "UPDATE users1 SET password = '$senha_hash' WHERE user = '" . $_SESSION['user'] . "' and estado=1";
                $mysqli->query($query);

                // Remover o registro da tabela 'recuperacao' (para evitar reutilização do código)
                $query = "DELETE FROM recuperacao WHERE user = '$user' AND confirmacao = '" . $_SESSION['codigo_recuperacao'] . "'";
                $mysqli->query($query);

                // Remover o código da sessão
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

// Obter o endereço IP do usuário
$ip = gethostbyaddr($_SERVER['REMOTE_ADDR']);

// Consultar se o IP já existe na tabela de cookies
$currentDateTime = date('Y-m-d H:i:s'); // Obtém a data e hora atual no formato 'Y-m-d H:i:s'
$queryCheckIP = "SELECT COUNT(*) AS ip_count FROM cookies WHERE ip_address = ? AND expiry_date > ?";
$statementCheckIP = $mysqli->prepare($queryCheckIP);
$statementCheckIP->bind_param('ss', $ip, $currentDateTime);
$statementCheckIP->execute();
$statementCheckIP->bind_result($ipCount);
$statementCheckIP->fetch();
$statementCheckIP->close();

// Verificar se o IP já existe na base de dados
$ipExists = ($ipCount > 0);

// Definir se a mensagem de cookies deve ser exibida com base na existência do IP na base de dados
$showCookieMessage = !$ipExists;

if (!$ipExists) {
    // Cookie a ser armazenado no banco de dados (por exemplo, 'cookieConsent')
    $cookieName = 'cookieConsent';

    // Data de expiração do cookie no formato Unix timestamp
    $expiry = time() + (14 * 24 * 60 * 60); // Expira em duas semanas

    // Armazena o cookie no banco de dados
    $query = "INSERT INTO cookies (cookie_name, ip_address, expiry_date) VALUES (?, ?, ?)";
    $statement = $mysqli->prepare($query);
    $expiryDateTime = date('Y-m-d H:i:s', $expiry);
    $statement->bind_param('sss', $cookieName, $ip, $expiryDateTime);

    $statement->execute();
    $statement->close();
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
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.8.0/font/bootstrap-icons.css" rel="stylesheet">
</head>
<body>

<!-- Exibir a mensagem de cookies apenas se necessário -->
<?php if ($showCookieMessage) { ?>
<div id="cookies" style="background-color: #333; color: #fff; padding: 10px; position: fixed; bottom: 0; left: 0; width: 100%; text-align: center; z-index: 999;">
    Utilizamos cookies para adaptar conteúdos, oferecer funcionalidades personalizadas e analisar o tráfego do nosso site. Não partilhamos dados pessoais com terceiros, apenas informações sobre o uso do site. Consulte a nossa Política de Cookies e Aviso Legal para mais informações.
    <br><button onclick="acceptCookies()" style="background-color: #00631b; color: #fff; border: none; padding: 5px 10px; margin-left: 10px; cursor: pointer;">Fechar</button>
</div>
<?php } ?>

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
                <div class="form-group">
                    <label for="email">E-mail:</label>
                    <input type="email" class="form-control" name="email" id="email" required>
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
                    <div class="input-group">
                        <input type="password" class="form-control" name="nova_password" id="nova_password" required>
                        <button type="button" class="btn btn-outline-secondary" id="toggleNovaPassword">
                            <i class="bi bi-eye"></i>
                        </button>
                    </div>
                </div>
                <div class="form-group">
                    <label for="confirmar_password">Confirmar Password:</label>
                    <div class="input-group">
                        <input type="password" class="form-control" name="confirmar_password" id="confirmar_password" required>
                        <button type="button" class="btn btn-outline-secondary" id="toggleConfirmarPassword">
                            <i class="bi bi-eye"></i>
                        </button>
                    </div>
                </div>
                <br>
                <button style="background-color: #00631b;" type="submit" class="btn btn-primary" name="submeter">Submeter</button>
            </form>
        </div>
    </div>
</div>

<script>
    document.getElementById('toggleNovaPassword').addEventListener('click', function() {
        togglePasswordVisibility('nova_password', this);
    });

    document.getElementById('toggleConfirmarPassword').addEventListener('click', function() {
        togglePasswordVisibility('confirmar_password', this);
    });

    function togglePasswordVisibility(passwordId, button) {
        const passwordInput = document.getElementById(passwordId);
        const type = passwordInput.getAttribute('type') === 'password' ? 'text' : 'password';
        passwordInput.setAttribute('type', type);
        button.querySelector('i').classList.toggle('bi-eye');
        button.querySelector('i').classList.toggle('bi-eye-slash');
    }
</script>



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
<br><br><br><br><br>
<?php
include "footer.php";
?>

</html>



<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (isset($_POST["login"]) && isset($_POST["user"]) && isset($_POST["password"])) {
        $query = "SELECT password FROM users1 WHERE user=? and estado=1";
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
                $query = "SELECT type FROM users1 WHERE user=? and estado=1";
                $statement = $mysqli->prepare($query);
                $statement->bind_param('s', $_POST["user"]);
                $statement->execute();
                $statement->bind_result($type);

                if ($statement->fetch()) {
                    $_SESSION["session_id"] = session_id();
                    $_SESSION["username"] = $_POST["user"];
                    $_SESSION["type"] = $type;
                    $_SESSION["ano_letivo"] = "2023/24";
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
          <a href="recuperar-password.php" style="text-align: center; text-decoration: none; color: black;"><strong>Recuperar</strong> palavra-passe</a>
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

        function acceptCookies() {
        // Armazene o consentimento do usuário em um cookie com uma data de expiração
        document.cookie = "cookieConsent=accepted; expires=Fri, 31 Dec 9999 23:59:59 GMT; path=/";

        // Oculte a notificação de cookies
        document.getElementById('cookies').style.display = 'none';
    }

    // Verifique se o usuário já aceitou os cookies
    function checkCookies() {
        if (document.cookie.indexOf('cookieConsent=accepted') === -1) {
            // Se não houver consentimento, exiba a notificação
            document.getElementById('cookie-notification').style.display = 'block';
        }
    }

    // Verificar cookies assim que a página for carregada
    document.addEventListener('DOMContentLoaded', function() {
        checkCookies();
    });

</script>