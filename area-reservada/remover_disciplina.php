<?php
session_start();
include "./generals/config.php";
$mysqli = new mysqli($bd_host, $bd_user, $bd_password, $bd_database);

if ($mysqli->connect_error) {
    die('Erro: (' . $mysqli->connect_errno . ') ' . $mysqli->connect_error);
}

if (isset($_POST['user']) && isset($_POST['cod_dis'])) {
    $user = $_POST['user'];
    $cod_dis = $_POST['cod_dis'];

    // Executa a remoção da disciplina associada ao professor selecionado
    $query = "DELETE FROM profs WHERE user = '$user' AND cod_dis = '$cod_dis'";

    if ($mysqli->query($query) === TRUE) {
        echo 'Disciplina removida com sucesso.';
    } else {
        echo 'Erro ao remover disciplina: ' . $mysqli->error;
    }
} else {
    echo 'Parâmetros ausentes para remover disciplina.';
}
?>
