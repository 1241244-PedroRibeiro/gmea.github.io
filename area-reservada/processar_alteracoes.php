<?php
session_start();
require_once("generals/config.php");

$mysqli = new mysqli($bd_host, $bd_user, $bd_password, $bd_database);

if ($mysqli->connect_error) {
    die('Erro: (' . $mysqli->connect_errno . ') ' . $mysqli->connect_error);
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Obtém o nome de utilizador
    $username = $_SESSION["username"];

    // Verifica se o email foi alterado
    if (isset($_POST['email'])) {
        $newEmail = $mysqli->real_escape_string($_POST['email']);
        $updateEmailQuery = "UPDATE users1 SET email = '$newEmail' WHERE user = '$username'";
        $mysqli->query($updateEmailQuery);
    }

    // Verifica se a foto foi alterada
    if (isset($_FILES['photo']['name']) && !empty($_FILES['photo']['name'])) {
        $target_path = "fotos_perfil/";
        $target_file = $target_path . uniqid() . "_" . basename($_FILES['photo']['name']);
        move_uploaded_file($_FILES['photo']['tmp_name'], $target_file);

        // Atualiza o caminho da foto na tabela
        $updatePhotoQuery = "UPDATE users1 SET foto = '$target_file' WHERE user = '$username'";
        $mysqli->query($updatePhotoQuery);
    }

    // Adicione mais verificações e atualizações para outros campos conforme necessário

    // Feche a conexão com o banco de dados
    $mysqli->close();

    // Chame a função para desabilitar a edição
    echo '<script>disableEdit("email", "'.$userInfo['email'].'");</script>';

    // Redireciona de volta para a página principal
    header("Location: index.php");
    exit();
} else {
    // Se alguém tentar acessar este script diretamente, redirecione para a página principal
    header("Location: index.php");
    exit();
}
?>
