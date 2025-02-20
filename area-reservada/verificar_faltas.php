<?php
include "./generals/config.php";
$mysqli = new mysqli($bd_host, $bd_user, $bd_password, $bd_database);

if ($mysqli->connect_error) {
    die('Erro na conexão: (' . $mysqli->connect_errno . ') ' . $mysqli->connect_error);
}

$idAula = $_POST['id_aula'];
$indiceAula = $_POST['indice_aula'];

$faltasQuery = "SELECT * FROM faltas WHERE id_aula = '$idAula' AND indice_aula = '$indiceAula'";
$resultFaltas = $mysqli->query($faltasQuery);

if ($resultFaltas && $resultFaltas->num_rows > 0) {
    echo 'faltas_existem';
} else {
    echo 'sem_faltas';
}

$mysqli->close();
?>
