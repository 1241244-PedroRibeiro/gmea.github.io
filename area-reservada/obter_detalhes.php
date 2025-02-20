<?php
session_start();
include "./generals/config.php";
$mysqli = new mysqli($bd_host, $bd_user, $bd_password, $bd_database);

if ($mysqli->connect_error) {
    die('Erro na conexão: (' . $mysqli->connect_errno . ') ' . $mysqli->connect_error);
}

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["selecionado"])) {
    $selecionado = $mysqli->real_escape_string($_POST["selecionado"]);

    // Verifica se o selecionado é um aluno ou turma
    if (substr($selecionado, 0, 1) === 'a') {
        // É um aluno
        $query = "SELECT u.user, u.nome, u.foto FROM users1 u WHERE u.user = '$selecionado'";
    } elseif (substr($selecionado, 0, 1) === 't') {
        // É uma turma
        $query = "SELECT u.user, u.nome, u.foto FROM users1 u INNER JOIN turmas_alunos ta ON u.user = ta.user WHERE ta.cod_turma = '$selecionado'";
    }

    $result = $mysqli->query($query);

    if ($result && $result->num_rows > 0) {
        $detalhes = array();
        while ($row = $result->fetch_assoc()) {
            $detalhes[] = array(
                'user' => $row['user'],
                'nome' => $row['nome'],
                'foto' => $row['foto']
            );
        }
        echo json_encode($detalhes);
    } else {
        echo json_encode(array()); // Retorna um array vazio se não houver resultados
    }

    $result->free();
}

$mysqli->close();
?>
