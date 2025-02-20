<?php
session_start();
include "./generals/config.php";
$mysqli = new mysqli($bd_host, $bd_user, $bd_password, $bd_database);

if ($mysqli->connect_error) {
    die('Erro na conexão: (' . $mysqli->connect_errno . ') ' . $mysqli->connect_error);
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $user = $_POST['user'];
    $id_mes = $_POST['id_mes'];
    $data_pagamento = date('Y-m-d'); // Data atual

    // Verificar se já existe um registro para este usuário e mês
    $checkQuery = "SELECT * FROM mensalidades_alunos WHERE user = '$user' AND id_mes = '$id_mes'";
    $resultCheck = $mysqli->query($checkQuery);

    if ($resultCheck && $resultCheck->num_rows > 0) {
        // Pagamento já foi efetuado para este usuário e mês
        echo json_encode(['success' => false, 'message' => 'Pagamento já efetuado']);
    } else {
        // Inserir novo registro de pagamento na tabela mensalidades_alunos
        $insertQuery = "INSERT INTO mensalidades_alunos (user, id_mes, data_pagamento) VALUES ('$user', '$id_mes', '$data_pagamento')";
        $resultInsert = $mysqli->query($insertQuery);

        if ($resultInsert) {
            // Pagamento inserido com sucesso
            echo json_encode(['success' => true, 'message' => 'Pagamento registrado com sucesso']);
        } else {
            // Erro ao inserir o pagamento
            echo json_encode(['success' => false, 'message' => 'Erro ao registrar o pagamento']);
        }
    }
} else {
    // Requisição inválida
    echo json_encode(['success' => false, 'message' => 'Requisição inválida']);
}
?>
