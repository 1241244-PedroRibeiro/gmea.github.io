<?php
session_start();
include "./generals/config.php";
$mysqli = new mysqli($bd_host, $bd_user, $bd_password, $bd_database);

if ($mysqli->connect_error) {
    die('Erro: (' . $mysqli->connect_errno . ') ' . $mysqli->connect_error);
}

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["indice_aula"])) {
    $indice_aula = $mysqli->real_escape_string($_POST["indice_aula"]);
    $tipo_falta = $mysqli->real_escape_string($_POST["tipo_falta"]);
    $user = $mysqli->real_escape_string($_POST["user"]);
    $id_aula = $mysqli->real_escape_string($_POST["id_aula"]);

    // Exemplo de consulta para remover a justificação com base no índice da aula
    $query = "DELETE FROM justificacao_faltas WHERE indice_aula = '$indice_aula' AND user = '$user' AND id_aula = '$id_aula'";
    $result = $mysqli->query($query);

    if ($result) {
        echo "Justificação recusada e removida com sucesso.";
    } else {
        echo "Erro ao recusar justificação: " . $mysqli->error;
    }
} else {
    echo "Erro: Requisição inválida.";
}
?>
