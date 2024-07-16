<?php
session_start();
include "./generals/config.php";
$mysqli = new mysqli($bd_host, $bd_user, $bd_password, $bd_database);

if ($mysqli->connect_error) {
    die('Erro: (' . $mysqli->connect_errno . ') ' . $mysqli->connect_error);
}

if (isset($_POST["id_aula"])) {
    $idAula = $_POST["id_aula"];

    $query = "SELECT id_aula, userOuTurma, cod_dis, hora_inicio, hora_fim, dia_semana FROM aulas WHERE id_aula = $idAula";

    $result = $mysqli->query($query);

    if ($result->num_rows == 1) {
        $aula = $result->fetch_assoc();
        echo json_encode($aula);
    } else {
        echo json_encode(array("error" => "Aula não encontrada."));
    }
} else {
    echo json_encode(array("error" => "ID da aula não fornecido."));
}
?>