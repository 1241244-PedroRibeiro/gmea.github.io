<?php
session_start();
require_once("generals/config.php");

$mysqli = new mysqli($bd_host, $bd_user, $bd_password, $bd_database);

if ($mysqli->connect_error) {
    die('Erro: (' . $mysqli->connect_errno . ') ' . $mysqli->connect_error);
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $user = $_POST['user'];
    $mes = $_POST['mes'];
    $data_pagamento = date('Y-m-d'); // Data atual
    
    
    // Inserir novo registro de pagamento na tabela mensalidades_alunos
    $insertQuery = "INSERT INTO mensalidades_alunos (user, id_mes, data_pagamento) VALUES ('$user', '$mes', '$data_pagamento')";
    $resultInsert = $mysqli->query($insertQuery);
    
    if ($mysqli->query($insertQuery)) {
        echo 'Atualização do pagamento bem-sucedida';
    } else {
        echo 'Erro na atualização do pagamento: ' . $mysqli->error;
    }
} else {
    echo 'Método de requisição inválido';
}
?>