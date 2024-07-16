<?php
session_start();
include "./generals/config.php";
$mysqli = new mysqli($bd_host, $bd_user, $bd_password, $bd_database);

if ($mysqli->connect_error) {
    die('Erro na conexão: (' . $mysqli->connect_errno . ') ' . $mysqli->connect_error);
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $idAula = $_POST['id_aula'];
    $indiceAula = $_POST['indice_aula'];

    // Excluir faltas anteriores para esta aula e aluno
    $deleteQuery = "DELETE FROM faltas WHERE id_aula = '$idAula' AND indice_aula = '$indiceAula'";
    if (!$mysqli->query($deleteQuery)) {
        echo 'Erro ao excluir faltas anteriores: ' . $mysqli->error;
        exit;
    }
}
?>