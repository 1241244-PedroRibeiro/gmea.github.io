<?php
session_start();
include "./generals/config.php";
$mysqli = new mysqli($bd_host, $bd_user, $bd_password, $bd_database);

if ($mysqli->connect_error) {
    die('Erro: (' . $mysqli->connect_errno . ') ' . $mysqli->connect_error);
}

if (empty($_SESSION["session_id"]) || $_SESSION["type"] != 3) {
    die('Acesso negado');
}

if (isset($_POST['num_socio']) && isset($_POST['year'])) {
    $num_socio = $mysqli->real_escape_string($_POST['num_socio']);
    $year = $mysqli->real_escape_string($_POST['year']);
    $data_pagamento = date('Y-m-d');

    $query = "INSERT INTO quotas_socios (num_socio, ano, data_pagamento) VALUES ('$num_socio', '$year', '$data_pagamento')";

    if ($mysqli->query($query)) {
        echo 'success';
    } else {
        echo 'Erro: ' . $mysqli->error;
    }
} else {
    echo 'Dados incompletos';
}
?>
