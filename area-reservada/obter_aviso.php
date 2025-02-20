<?php
// obter_aviso.php

session_start();
include "./generals/config.php";
$mysqli = new mysqli($bd_host, $bd_user, $bd_password, $bd_database);

if ($mysqli->connect_error) {
    die('Erro: (' . $mysqli->connect_errno . ') ' . $mysqli->connect_error);
}

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["avisoID"])) {
    $avisoID = $_POST["avisoID"];

    // Consulta para obter informações do aviso
    $stmt = $mysqli->prepare("SELECT * FROM avisos WHERE id_aviso = ?");
    $stmt->bind_param("i", $avisoID);

    if ($stmt->execute()) {
        $result = $stmt->get_result();
        if ($row = $result->fetch_assoc()) {
            // Retorna as informações do aviso como JSON
            echo json_encode($row);
        } else {
            // Trate o caso em que nenhum aviso foi encontrado
            echo json_encode(['error' => 'Aviso não encontrado']);
        }
    } else {
        // Trate o caso em que ocorreu um erro na consulta
        echo json_encode(['error' => 'Erro na consulta: ' . $stmt->error]);
    }

    $stmt->close();
    $mysqli->close();
} else {
    // Trate o caso em que a requisição não é válida
    echo json_encode(['error' => 'Requisição inválida']);
}
?>
