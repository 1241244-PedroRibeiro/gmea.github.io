<?php
session_start();
require_once("generals/config.php");

$mysqli = new mysqli($bd_host, $bd_user, $bd_password, $bd_database);

if ($mysqli->connect_error) {
    die('Erro: (' . $mysqli->connect_errno . ') ' . $mysqli->connect_error);
}

if (empty($_SESSION["session_id"])) {
    header("Location: ../index.php");
    exit;
}

// Obtém o nome de utilizador
$username = $_SESSION["username"];

// Function to get the date of the last password change
function getLastPasswordChangeDate($mysqli, $username) {
    $query = "SELECT data_alteracao FROM alteracoes_password WHERE user = '$username' ORDER BY data_alteracao DESC LIMIT 1";
    $result = $mysqli->query($query);

    // Verifica se a consulta foi bem-sucedida e se há resultados
    if ($result !== false && $result->num_rows > 0) {
        $row = $result->fetch_assoc();

        // Retorna um objeto DateTime
        return new DateTime($row['data_alteracao']);
    }

    // Retorna null se nenhum registro for encontrado
    return null;
}



// Função para atualizar a senha na tabela users1
function updatePassword($mysqli, $username, $newPassword) {
    $hashedPassword = password_hash($newPassword, PASSWORD_DEFAULT);
    $updateQuery = "UPDATE users1 SET password = '$hashedPassword' WHERE user = '$username'";
    return $mysqli->query($updateQuery);
}

// Função para inserir um novo registro de alteração de senha
function insertPasswordChangeRecord($mysqli, $username) {
    $insertQuery = "INSERT INTO alteracoes_password (user, data_alteracao) VALUES ('$username', NOW())";
    return $mysqli->query($insertQuery);
}

// Variáveis para modals
$message = ''; // Defina a mensagem conforme necessário
$modalClass = ''; // Defina 'success' ou 'danger' conforme necessário

// Processamento do formulário
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $currentPassword = $_POST['current_password'];
    $newPassword = $_POST['new_password'];
    $confirmPassword = $_POST['confirm_password'];

    // Verifica se a nova senha e a confirmação são iguais
    if ($newPassword === $confirmPassword) {
        // Verifica se a senha atual está correta
        $checkCurrentPasswordQuery = "SELECT password FROM users1 WHERE user = '$username'";
        $result = $mysqli->query($checkCurrentPasswordQuery);

        if ($result && $result->num_rows > 0) {
            $row = $result->fetch_assoc();
            $hashedPassword = $row['password'];

            // Verifica se a senha atual é correta
            if (password_verify($currentPassword, $hashedPassword)) {
                // Atualiza a senha na tabela users1
                if (updatePassword($mysqli, $username, $newPassword)) {
                    // Insere um novo registro de alteração de senha
                    insertPasswordChangeRecord($mysqli, $username);

                    // Configura a mensagem de sucesso
                    $message = 'Senha alterada com sucesso.';
                    $modalClass = 'success';
                } else {
                    // Configura a mensagem de erro
                    $message = 'Erro ao atualizar a senha.';
                    $modalClass = 'danger';
                }
            } else {
                // Configura a mensagem de erro
                $message = 'Senha atual incorreta.';
                $modalClass = 'danger';
            }
        } else {
            // Configura a mensagem de erro
            $message = 'Erro ao verificar a senha atual.';
            $modalClass = 'danger';
        }
    } else {
        // Configura a mensagem de erro
        $message = 'A nova senha e a confirmação não coincidem.';
        $modalClass = 'danger';
    }
}

// Obtém a data da última alteração
$lastChangeDate = getLastPasswordChangeDate($mysqli, $username);

// Verifica se a data é válida antes de exibi-la
if (is_null($lastChangeDate)) {
    $yearsDiff = 0;
    $lastChangeDateString = 'N/A';
} else {
    // Calculate the difference in years between the dates
    $yearsDiff = date_diff($lastChangeDate, new DateTime())->y;
    $lastChangeDateString = $lastChangeDate->format('Y-m-d');
}

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>GMEA - Alterar Password</title>
    <link rel="shortcut icon" type="image/png" href="media/logo.png" />
    <script src="https://use.fontawesome.com/releases/v6.3.0/js/all.js" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.3.1/jquery.min.js" crossorigin="anonymous"></script>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js"></script>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.8.0/font/bootstrap-icons.css" rel="stylesheet">
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
        include "header-profs.php";
    }
    if ($_SESSION["type"] == 3) {
        include "header-direcao.php";
    }
    if ($_SESSION["type"] == 4) { // Mostrar cabeçalho para professores
        include "header-professor-direcao.php";
    }
    ?>

<div class="container mt-4">
    <h2 class="mb-4">Alterar Password</h2>

    <form id="changePasswordForm" method="POST">
        <div class="mb-3">
            <label for="current_password" class="form-label">Senha Atual</label>
            <div class="input-group">
                <input type="password" class="form-control" id="current_password" name="current_password" required>
                <button type="button" class="btn btn-outline-secondary" id="toggleCurrentPassword">
                    <i class="bi bi-eye"></i>
                </button>
            </div>
        </div>
        <div class="mb-3">
            <label for="new_password" class="form-label">Nova Senha</label>
            <div class="input-group">
                <input type="password" class="form-control" id="new_password" name="new_password" required>
                <button type="button" class="btn btn-outline-secondary" id="toggleNewPassword">
                    <i class="bi bi-eye"></i>
                </button>
            </div>
        </div>
        <div class="mb-3">
            <label for="confirm_password" class="form-label">Confirmar Nova Senha</label>
            <div class="input-group">
                <input type="password" class="form-control" id="confirm_password" name="confirm_password" required>
                <button type="button" class="btn btn-outline-secondary" id="toggleConfirmPassword">
                    <i class="bi bi-eye"></i>
                </button>
            </div>
        </div>
        <button type="submit" class="btn btn-primary">Guardar Alterações</button>
    </form>

        <!-- Div que mostra a data da última alteração da password -->
        <div class="mt-4">
            <div class="alert <?php echo ($yearsDiff == 0 && $lastChangeDateString != 'N/A') ? 'alert-success' : (($yearsDiff == 1 && $lastChangeDateString != 'N/A') ? 'alert-warning' : 'alert-danger'); ?>" role="alert">
                <strong>Data da Última Alteração da Senha:</strong>
                <?php echo ($lastChangeDate) ? $lastChangeDate->format('Y-m-d') : 'Sem registo. Deve alterar a sua password.'; ?>
            </div>
        </div>
    </div>

    <!-- Modals -->
    <div class="modal fade" id="successModal" tabindex="-1" aria-labelledby="successModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="successModalLabel">Sucesso!</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <?php echo $message; ?>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Fechar</button>
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade" id="errorModal" tabindex="-1" aria-labelledby="errorModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="errorModalLabel">Erro!</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <?php echo $message; ?>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Fechar</button>
                </div>
            </div>
        </div>
    </div>

    <?php
    // Incluir o rodapé comum
    include "footer-reservado.php";
    ?>

    <script>
    $(document).ready(function () {
        <?php if (!empty($modalClass) && $modalClass === 'success') : ?>
            $('#successModal').modal('show');
        <?php elseif (!empty($modalClass) && $modalClass === 'danger') : ?>
            $('#errorModal').modal('show');
        <?php endif; ?>
    });
    document.getElementById('toggleCurrentPassword').addEventListener('click', function() {
    togglePasswordVisibility('current_password', this);
});

document.getElementById('toggleNewPassword').addEventListener('click', function() {
    togglePasswordVisibility('new_password', this);
});

document.getElementById('toggleConfirmPassword').addEventListener('click', function() {
    togglePasswordVisibility('confirm_password', this);
});

function togglePasswordVisibility(passwordId, button) {
    const passwordInput = document.getElementById(passwordId);
    const type = passwordInput.getAttribute('type') === 'password' ? 'text' : 'password';
    passwordInput.setAttribute('type', type);
    button.querySelector('i').classList.toggle('bi-eye');
    button.querySelector('i').classList.toggle('bi-eye-slash');
}
    </script>

</body>

</html>
