<?php
// eliminar_aviso.php

session_start();
include "./generals/config.php";
$mysqli = new mysqli($bd_host, $bd_user, $bd_password, $bd_database);

if ($mysqli->connect_error) {
    die('Erro: (' . $mysqli->connect_errno . ') ' . $mysqli->connect_error);
}

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["avisoID"])) {
    $avisoID = $_POST["avisoID"];

    // Defina a data_fim para o dia anterior ao atual
    $novaDataFim = date('Y-m-d', strtotime('-1 day'));

    // Atualize a tabela "avisos" com a nova data_fim
    $stmtEliminar = $mysqli->prepare("UPDATE avisos SET data_fim = ? WHERE id_aviso = ?");
    $stmtEliminar->bind_param("si", $novaDataFim, $avisoID);

    if ($stmtEliminar->execute()) {
        echo "Aviso eliminado com sucesso!";
    } else {
        echo "Erro ao eliminar aviso: " . $stmtEliminar->error;
    }

    $stmtEliminar->close();
    $mysqli->close();
} else {
    echo "Requisição inválida";
}
?>
