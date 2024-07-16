<?php
// Configurações de conexão com o banco de dados
include "./generals/config.php";
$mysqli = new mysqli($bd_host, $bd_user, $bd_password, $bd_database);

// Verificar conexão
if ($mysqli->connect_error) {
    die('Erro na conexão: (' . $mysqli->connect_errno . ') ' . $mysqli->connect_error);
}

// Obter parâmetros da solicitação AJAX
$user = $_POST['user'];
$disciplina = $_POST['disciplina'];

// Consulta SQL para obter as avaliações relevantes
$query = "SELECT escala, nivel, tipo_avaliacao, user FROM avaliacoes ";
$query .= "WHERE user = '$user' AND disciplina = '$disciplina'";

$result = $mysqli->query($query);

if ($result) {
    $avaliacoes = [];
    while ($row = $result->fetch_assoc()) {
        $avaliacoes[] = $row;
    }
    echo json_encode($avaliacoes); // Retornar os resultados como JSON
} else {
    echo json_encode([]); // Retornar um array vazio em caso de erro ou nenhum resultado
}

// Fechar a conexão com o banco de dados
$mysqli->close();
?>
