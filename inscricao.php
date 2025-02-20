<?php
session_start();
ini_set('display_errors', 0);
require_once("generals/config.php");

$mysqli = new mysqli($bd_host, $bd_user, $bd_password, $bd_database);

if ($mysqli->connect_error) {
    die('Erro: (' . $mysqli->connect_errno . ') ' . $mysqli->connect_error);
}

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["nome"])) {
    $nome = $_POST["nome"];
    $morada1 = $_POST["morada1"];
    $morada2 = $_POST["morada2"];
    $nif = $_POST["nif"];
    $cc = $_POST["cc"];
    $data_nas = $_POST["data_nas"];
    $email = $_POST["email"];
    $telef = $_POST["telef"];

    // Verifica se o arquivo foi enviado sem erros
    if (isset($_FILES["foto"]) && $_FILES["foto"]["error"] == UPLOAD_ERR_OK) {
        // Nome original do arquivo no cliente
        $nomeOriginal = $_FILES["foto"]["name"];
        
        // Nome temporário do arquivo no servidor
        $nomeTemporario = $_FILES["foto"]["tmp_name"];

        // Verifica se o arquivo é uma imagem
        $tipoArquivo = $_FILES["foto"]["type"];
        if ($tipoArquivo == "image/jpeg" || $tipoArquivo == "image/png") {
            // Define o diretório de destino para onde o arquivo será movido
            $diretorioDestino = "fotos-inscricoes/"; // Diretório onde deseja armazenar os uploads

            // Gera um novo nome único para o arquivo (opcional)
            $novoNome = uniqid() . '_' . $nomeOriginal;

            // Move o arquivo temporário para o diretório de destino com um novo nome
            if (move_uploaded_file($nomeTemporario, $diretorioDestino . $novoNome)) {
                echo "Arquivo enviado com sucesso.";

                // Agora $novoNome contém o nome do arquivo no servidor
                $caminhoCompleto = $diretorioDestino . $novoNome;
                
                // Você pode armazenar $caminhoCompleto no banco de dados ou usar conforme necessário
            } else {
                echo "Erro ao mover o arquivo para o diretório de destino.";
            }
        } else {
            echo "O arquivo enviado não é uma imagem válida (JPEG ou PNG).";
        }
    } else {
        echo "Erro ao receber o arquivo.";
    }

    // Inserção na tabela 'inscricoes'
    $query = "INSERT INTO inscricoes (nome, morada1, morada2, nif, cc, data_nas, email, telef, foto) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)";
    $statement = $mysqli->prepare($query);
    $statement->bind_param('sssiissss', $nome, $morada1, $morada2, $nif, $cc, $data_nas, $email, $telef, $caminhoCompleto);

    if ($statement->execute()) {
        // Inserção bem-sucedida
        header('Location: sucesso.php');
        exit; // É uma boa prática incluir exit após o redirecionamento para garantir que o script pare de ser executado
    } else {
        // Erro ao inserir
        header('Location: erro.php');
        exit;
    }    

    $statement->close();
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
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>GMEA</title>
    <link rel="shortcut icon" type="image/png" href="media/logo.png/"/>
    <script src="https://use.fontawesome.com/releases/v6.3.0/js/all.js" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.3.1/jquery.min.js" crossorigin="anonymous"></script>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js"></script>

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
    </style>

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

<div class="container">
    <h2 class="mt-5 text-center">Formulário de Pré-Inscrição do Aluno</h2>
    <form id="insertForm" action="<?php echo $_SERVER['PHP_SELF']; ?>" method="post" enctype="multipart/form-data">
        <div class="mb-3">
            <label for="nome" class="form-label">Nome:</label>
            <input type="text" id="nome" name="nome" class="form-control" required>
        </div>

        <div class="mb-3">
            <label for="morada1" class="form-label">Morada:</label>
            <input type="text" id="morada1" name="morada1" class="form-control" required>
        </div>

        <div class="mb-3">
            <label for="morada2" class="form-label">Morada (Continuação):</label>
            <input type="text" id="morada2" name="morada2" class="form-control" required>
        </div>

        <div class="mb-3">
            <label for="nif" class="form-label">NIF:</label>
            <input type="number" id="nif" name="nif" class="form-control" required min="0">
        </div>

        <div class="mb-3">
            <label for="cc" class="form-label">CC:</label>
            <input type="number" id="cc" name="cc" class="form-control" required min="0">
        </div>

        <div class="mb-3">
            <label for="data_nas" class="form-label">Data de Nascimento:</label>
            <input type="date" id="data_nas" name="data_nas" class="form-control" required>
        </div>

        <div class="mb-3">
            <label for="email" class="form-label">E-mail:</label>
            <input type="text" id="email" name="email" class="form-control" required>
        </div>

        <div class="mb-3">
            <label for="telef" class="form-label">Telemóvel:</label>
            <input type="text" id="telef" name="telef" class="form-control" required>
        </div>

        <div class="mb-3">
            <label for="foto" class="form-label">Foto (Tipo Passe):</label>
            <input type="file" id="foto" name="foto" accept="image/*" class="form-control" required>
        </div>

        <button style="background-color: #00631b;" type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#confirmModal">Confirmar Informações</button>
    </form>
</div>

<?php include "footer.php"; ?>

<!-- Modal de Confirmação -->
<div class="modal fade" id="confirmModal" tabindex="-1" aria-labelledby="confirmModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="confirmModalLabel">Confirmação</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                Tem certeza de que deseja enviar este pedido de pré-inscrição?
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Não</button>
                <button type="submit" class="btn btn-primary" id="confirmSubmit">Sim</button>
            </div>
        </div>
    </div>
</div>

<?php include "footer.php"; ?>

<?php if (isset($successMessage)) : ?>
    <div class="container mt-5">
        <div class="alert alert-success text-center" role="alert">
            <h2><?php echo $successMessage; ?></h2>
            <p><?php echo $infoMessage; ?></p>
        </div>
    </div>
<?php endif; ?>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        const confirmSubmitButton = document.querySelector('#confirmSubmit');

        confirmSubmitButton.addEventListener('click', function() {
            document.querySelector('#insertForm').submit(); // Enviar o formulário após confirmação
        });
    });
</script>

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