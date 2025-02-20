<?php
session_start();
include "./generals/config.php";
$mysqli = new mysqli($bd_host, $bd_user, $bd_password, $bd_database);

if ($mysqli->connect_error) {
    die('Erro: (' . $mysqli->connect_errno . ') ' . $mysqli->connect_error);
}

// Verificar se foi recebido o parâmetro 'selectedUser' via POST
if (isset($_POST['selectedUser'])) {
    $selectedUser = $_POST['selectedUser'];

    // Consulta SQL para obter as disciplinas associadas ao aluno/turma selecionada e ao professor logado
    $query = "SELECT DISTINCT cd.cod_dis, cd.nome_dis
              FROM aulas a
              INNER JOIN cod_dis cd ON a.cod_dis = cd.cod_dis
              WHERE a.userOuTurma = '$selectedUser'
                AND cd.cod_dis IN (
                    SELECT cod_dis FROM profs WHERE user = '{$_SESSION["username"]}'
                )
              ORDER BY cd.cod_dis";

    $result = $mysqli->query($query);

    if ($result) {
        $disciplinas = array();

        // Construir array com os dados das disciplinas
        while ($row = $result->fetch_assoc()) {
            $disciplina = array(
                'cod_dis' => $row['cod_dis'],
                'nome_dis' => $row['nome_dis']
            );
            $disciplinas[] = $disciplina;
        }

        // Retornar os dados das disciplinas como resposta JSON
        echo json_encode($disciplinas);
    } else {
        // Caso ocorra um erro na consulta
        echo json_encode(array()); // Retornar um array vazio como resposta
    }

    $mysqli->close();
}
?>
