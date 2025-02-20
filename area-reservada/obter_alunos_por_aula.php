<?php
// Incluir o arquivo de configuração e iniciar a sessão, se necessário
session_start();
include "./generals/config.php";
$mysqli = new mysqli($bd_host, $bd_user, $bd_password, $bd_database);

if ($mysqli->connect_error) {
    die('Erro: (' . $mysqli->connect_errno . ') ' . $mysqli->connect_error);
}

// Verificar se o ID da aula foi recebido via POST
if (isset($_POST["id_aula"])) {
    // Receber o ID da aula
    $idAula = $_POST["id_aula"];
    // Consulta SQL para obter os alunos associados a esta aula
    $query = "SELECT userOuTurma from aulas WHERE id_aula = $idAula";

    $result = $mysqli->query($query);

    // Verificar se há resultados da consulta
    if ($result->num_rows > 0) {
        // Construir o HTML da tabela de alunos
        while ($row = $result->fetch_assoc()) {
            $turma = $row['userOuTurma'];
        }
    }

    // Consulta SQL para obter os alunos associados a esta aula
    $query = "SELECT users1.user, users1.nome
        FROM turmas_alunos
        INNER JOIN users1 ON turmas_alunos.user = users1.user
        WHERE turmas_alunos.cod_turma = '$turma'";


    $result = $mysqli->query($query);

    // Inicializar um array para armazenar os dados dos alunos
    $alunos = array();

    // Verificar se há resultados da consulta
    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            // Adicionar os dados do aluno ao array
            $alunos[] = array(
                "user" => $row['user'],
                "nome" => $row['nome']
            );
        }
    }

    // Retornar os dados dos alunos como JSON
    echo json_encode($alunos);
} else {
    // Se o ID da aula não foi recebido, exiba uma mensagem de erro
    echo json_encode(array("error" => "ID da aula não recebido."));
}

?>
