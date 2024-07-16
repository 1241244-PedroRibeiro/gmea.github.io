<?php
session_start();
require_once("generals/config.php");
ini_set('display_errors', 0);

$mysqli = new mysqli($bd_host, $bd_user, $bd_password, $bd_database);

if ($mysqli->connect_error) {
    die('Erro: (' . $mysqli->connect_errno . ') ' . $mysqli->connect_error);
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

$contents = [];

$queryContent = "SELECT id, content FROM page_content";
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
    <title>GMEA</title>
    <link rel="shortcut icon" type="image/png" href="media/logo.png"/>
    <script src="https://use.fontawesome.com/releases/v6.3.0/js/all.js" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.3.1/jquery.min.js" crossorigin="anonymous"></script>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js"></script>
    <link href="https://cdn.quilljs.com/1.3.6/quill.snow.css" rel="stylesheet">

    <style>
        @keyframes fadeIn {
            0% { opacity: 0; }
            100% { opacity: 1; }
        }

        body {
            animation: 2s ease-out 0s 1 fadeIn;
        }

        a:hover {
            color: red;
        }

        #banner_header {
            position: relative;
            height: 306px;
            background: url('<?php echo $contents['banner_image'] ?? "default-image.jpg"; ?>') no-repeat center center;
            background-size: cover;
        }

        #banner_header .title {
            position: absolute;
            top: 80%;
            left: 50%;
            transform: translate(-50%, -50%);
            color: white;
            z-index: 2;
            font-size: 3em; /* Ajuste conforme necessário */
            text-shadow: 2px 2px 4px rgba(0, 0, 0, 0.7);
        }

        #cookies {
            background-color: #333;
            color: #fff;
            padding: 10px;
            position: fixed;
            bottom: 0;
            left: 0;
            width: 100%;
            text-align: center;
            z-index: 999;
        }

        #cookies button {
            background-color: #00631b;
            color: #fff;
            border: none;
            padding: 5px 10px;
            margin-left: 10px;
            cursor: pointer;
        }
    </style>
</head>
<body>
    <?php include "header.php"; ?>
    <!-- Header Section -->
    <div id="banner_header">
        <div class="mask"></div>
        <h1 id="banner_title" class="title"><?php echo $contents['banner_title'] ?? "Curso Secundário"; ?></h1>
    </div>

    <div class="container">
        <br>
        <h2 id="section1_title"><?php echo $contents['section1_title'] ?? "Seção 1"; ?></h2>
        <p id="section1_content"><?php echo $contents['section1_content'] ?? "Lorem ipsum..."; ?></p>

        <h2 id="section2_title"><?php echo $contents['section2_title'] ?? "Seção 2"; ?></h2>
        <p id="section2_content"><?php echo $contents['section2_content'] ?? "Lorem ipsum..."; ?></p>

        <h2 id="section3_title"><?php echo $contents['section3_title'] ?? "Seção 3"; ?></h2>
        <p id="section3_content"><?php echo $contents['section3_content'] ?? "Lorem ipsum..."; ?></p>

        <h2 id="section4_title"><?php echo $contents['section4_title'] ?? "Seção 4"; ?></h2>
        <p id="section4_content"><?php echo $contents['section4_content'] ?? "Lorem ipsum..."; ?></p>
    </div>

    <!-- Exibir a mensagem de cookies apenas se necessário -->
    <?php if ($showCookieMessage) { ?>
    <div id="cookies">
        Utilizamos cookies para adaptar conteúdos, oferecer funcionalidades personalizadas e analisar o tráfego do nosso site. Não partilhamos dados pessoais com terceiros, apenas informações sobre o uso do site. Consulte a nossa Política de Cookies e Aviso Legal para mais informações.
        <br><button onclick="acceptCookies()">Fechar</button>
    </div>
    <?php } ?>

    <?php include "footer.php"; ?>
</body>
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

        // Exibir modal de erro caso login falhe
        echo '
        <script>
            document.addEventListener("DOMContentLoaded", function() {
                const myModal = new bootstrap.Modal(document.getElementById("errorModal"));
                myModal.show();
            });
        </script>
        <div class="modal" tabindex="-1" id="errorModal">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">Erro</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        Utilizador ou Password incorreto(s).
                    </div>
                    <div class="modal-footer">
                        <a href="recuperar-password.php" class="btn btn-primary">Recuperar palavra-passe</a>
                    </div>
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
