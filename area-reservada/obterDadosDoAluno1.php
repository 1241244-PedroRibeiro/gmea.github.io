<?php
// obter_dados_aluno.php

session_start();
include "./generals/config.php";
$mysqli = new mysqli($bd_host, $bd_user, $bd_password, $bd_database);

if ($mysqli->connect_error) {
    die('Erro: (' . $mysqli->connect_errno . ') ' . $mysqli->connect_error);
}

if (isset($_POST['user'])) {
    $user = $_POST['user'];
    
    $query = "SELECT * FROM alunos WHERE user = ?";
    $stmt = $mysqli->prepare($query);

    if ($stmt) {
        $stmt->bind_param("s", $user);
        if ($stmt->execute()) {
            $result = $stmt->get_result();
            if ($result->num_rows > 0) {
                $alunoData = $result->fetch_assoc();
                echo json_encode($alunoData);
            }
        }
        $stmt->close();
    }
}
?>
