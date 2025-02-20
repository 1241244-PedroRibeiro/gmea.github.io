<?php
session_start();
include "./generals/config.php";
$mysqli = new mysqli($bd_host, $bd_user, $bd_password, $bd_database);

if ($mysqli->connect_error) {
    die(json_encode(['success' => false]));
}

if (isset($_POST['idAula'])) {
    $idAula = $_POST['idAula'];

    // Consulta para obter os detalhes da aula
    $query = "SELECT aulas.hora_inicio, aulas.hora_fim, aulas.dia_semana, cod_dis.nome_dis, users1.Nome AS nomeProfessor
              FROM aulas
              JOIN cod_dis ON aulas.cod_dis = cod_dis.cod_dis
              JOIN users1 ON aulas.prof = users1.user
              WHERE aulas.id_aula = '$idAula'";

    $result = $mysqli->query($query);

    if ($result && $result->num_rows > 0) {
        $row = $result->fetch_assoc();
        $horaInicio = $row['hora_inicio'];
        $horaFim = $row['hora_fim'];
        $diaSemana = $row['dia_semana'];
        $disciplina = $row['nome_dis'];
        $nomeProfessor = $row['nomeProfessor'];

        // Retorna os detalhes da aula como JSON
        echo json_encode([
            'success' => true,
            'horaInicio' => $horaInicio,
            'horaFim' => $horaFim,
            'diaSemana' => $diaSemana,
            'disciplina' => $disciplina,
            'nomeProfessor' => $nomeProfessor
        ]);
    } else {
        echo json_encode(['success' => false]);
    }
} else {
    echo json_encode(['success' => false]);
}

$mysqli->close();
?>
