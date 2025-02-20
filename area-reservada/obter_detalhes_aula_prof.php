<?php
include "./generals/config.php";
$mysqli = new mysqli($bd_host, $bd_user, $bd_password, $bd_database);

if ($mysqli->connect_error) {
    die('Erro: (' . $mysqli->connect_errno . ') ' . $mysqli->connect_error);
}

if (isset($_POST['idAula'])) {
    $idAula = $_POST['idAula'];

    // Consulta para obter os detalhes da aula
    $query = "SELECT aulas.userOuTurma, aulas.hora_inicio, aulas.hora_fim, aulas.dia_semana, cod_dis.nome_dis
              FROM aulas
              JOIN cod_dis ON aulas.cod_dis = cod_dis.cod_dis
              WHERE aulas.id_aula = '$idAula'";

    $result = $mysqli->query($query);

    if ($result && $result->num_rows > 0) {
        $row = $result->fetch_assoc();
        $userOuTurma = $row['userOuTurma'];
        $nomeDis = $row['nome_dis'];
        $horaInicio = $row['hora_inicio'];
        $horaFim = $row['hora_fim'];
        $diaSemana = $row['dia_semana'];

        // Determinar se é aluno ('a') ou turma ('t')
        if (strtolower(substr($userOuTurma, 0, 1)) === 'a') {
            // É um aluno, buscar o nome na tabela 'users1'
            $queryUser = "SELECT nome FROM users1 WHERE user = '$userOuTurma'";
            $resultUser = $mysqli->query($queryUser);

            if ($resultUser && $resultUser->num_rows > 0) {
                $userData = $resultUser->fetch_assoc();
                $userTurmaNome = $userData['nome'];
            }
        } elseif (strtolower(substr($userOuTurma, 0, 1)) === 't') {
            // É uma turma, buscar o nome na tabela 'turmas'
            $queryTurma = "SELECT nome_turma FROM turmas WHERE cod_turma = '$userOuTurma'";
            $resultTurma = $mysqli->query($queryTurma);

            if ($resultTurma && $resultTurma->num_rows > 0) {
                $turmaData = $resultTurma->fetch_assoc();
                $userTurmaNome = $turmaData['nome_turma'];
            }
        }

        // Preparar os dados para retorno em JSON
        $response = [
            'success' => true,
            'userOuTurma' => $userTurmaNome,
            'nomeDis' => $nomeDis,
            'horaInicio' => $horaInicio,
            'horaFim' => $horaFim,
            'diaSemana' => $diaSemana
        ];

        echo json_encode($response);
    } else {
        echo json_encode(['success' => false]);
    }
}
?>
