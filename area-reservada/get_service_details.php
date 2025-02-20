<?php
session_start();
include "./generals/config.php";
$mysqli = new mysqli($bd_host, $bd_user, $bd_password, $bd_database);

// Verificar a conexão com o banco de dados
if ($mysqli->connect_error) {
    die('Erro na conexão: (' . $mysqli->connect_errno . ') ' . $mysqli->connect_error);
}

// Verificar se a sessão está ativa e o usuário tem permissão
if (empty($_SESSION["session_id"]) || $_SESSION["type"] != 3) {
    header("Location: ../index.php");
    exit;
}

// Verificar se é uma solicitação GET e se o parâmetro 'id' está presente
if ($_SERVER["REQUEST_METHOD"] == "GET" && isset($_GET["id"])) {
    $serviceId = $_GET["id"];

    // Consulta para obter os detalhes do serviço com base no id_servico fornecido
    $query = "SELECT * FROM servicos WHERE id_servico = '$serviceId'";
    $result = $mysqli->query($query);

    if ($result && $result->num_rows > 0) {
        // Se encontrar o serviço, retornar os detalhes como um objeto JSON
        $serviceDetails = $result->fetch_assoc();
        echo json_encode($serviceDetails);
    } else {
        // Se nenhum serviço for encontrado, retornar null
        echo json_encode(null);
    }
}

// Fechar a conexão com o banco de dados
$mysqli->close();
?>
