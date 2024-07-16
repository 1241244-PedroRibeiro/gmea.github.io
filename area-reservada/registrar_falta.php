<?php
session_start();
include "./generals/config.php";
$mysqli = new mysqli($bd_host, $bd_user, $bd_password, $bd_database);

if ($mysqli->connect_error) {
    die('Erro na conexão: (' . $mysqli->connect_errno . ') ' . $mysqli->connect_error);
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $idAula = $_POST['id_aula'];
    $user = $_POST['user'];
    $indiceAula = $_POST['indice_aula'];
    $tipoFalta = $_POST['tipo_falta'];
    $dia = $_POST['dia'];
    $cod_dis = $_POST['cod_dis'];

    // Inserir nova falta na tabela 'faltas'
    $insertQuery = "INSERT INTO faltas (id_aula, user, indice_aula, tipo_falta, dia, cod_dis) 
                    VALUES ('$idAula', '$user', '$indiceAula', '$tipoFalta', '$dia', '$cod_dis')";

    if ($mysqli->query($insertQuery) === TRUE) {
        echo 'Falta registrada com sucesso!';
    } else {
        echo 'Erro ao registrar falta: ' . $mysqli->error;
    }
}
?>
