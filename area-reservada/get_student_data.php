<?php
session_start();
include "./generals/config.php";
$mysqli = new mysqli($bd_host, $bd_user, $bd_password, $bd_database);

if ($mysqli->connect_error) {
    die('Erro: (' . $mysqli->connect_errno . ') ' . $mysqli->connect_error);
}

if (isset($_GET['user'])) {
    $user = $_GET['user'];

    // Retrieve the student's data from the database
    $query = "SELECT cod_instrumento AS instrumento, cod_formacao AS formacao, cod_orquestra AS orquestra, cod_coro AS coro FROM alunos WHERE user = '$user'";

    $result = $mysqli->query($query);

    if ($result && $result->num_rows > 0) {
        $row = $result->fetch_assoc();

        // Return the student's data as a JSON response
        echo json_encode($row);
    } else {
        // Return an empty response if the student's data is not found
        echo json_encode([]);
    }
}
?>