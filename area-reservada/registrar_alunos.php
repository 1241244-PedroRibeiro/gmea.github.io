<?php
session_start();
include "./generals/config.php";
$mysqli = new mysqli($bd_host, $bd_user, $bd_password, $bd_database);

if ($mysqli->connect_error) {
    die('Erro: (' . $mysqli->connect_errno . ') ' . $mysqli->connect_error);
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $idAula = $_POST['id_aula'];
    $alunosSelecionados = json_decode($_POST['alunos_selecionados'], true);

    // Verifica se os dados foram recebidos corretamente
    if (empty($idAula) || empty($alunosSelecionados)) {
        echo json_encode(['status' => 'error', 'message' => 'Dados inválidos.']);
        exit;
    }

    // Debug: log dos dados recebidos
    error_log("ID Aula: $idAula");
    error_log("Alunos Selecionados: " . print_r($alunosSelecionados, true));

    // Obtém o usuário ou turma associado à aula
    $query = "SELECT userOuTurma FROM aulas WHERE id_aula = ?";
    $stmt = $mysqli->prepare($query);
    $stmt->bind_param("i", $idAula);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        $turma = $row['userOuTurma'];
        $stmt->close();

        // Apaga todos os alunos associados à turma
        $deleteQuery = "DELETE FROM turmas_alunos WHERE cod_turma = ?";
        $stmt = $mysqli->prepare($deleteQuery);
        $stmt->bind_param("s", $turma);
        if (!$stmt->execute()) {
            echo json_encode(['status' => 'error', 'message' => 'Erro ao remover alunos antigos: ' . $mysqli->error]);
            exit;
        }
        $stmt->close();

        // Insere os novos alunos
        $insertQuery = "INSERT INTO turmas_alunos (cod_turma, user) VALUES (?, ?)";
        $stmt = $mysqli->prepare($insertQuery);

        foreach ($alunosSelecionados as $aluno) {
            $user = $aluno['user'];
            $stmt->bind_param("ss", $turma, $user);

            if (!$stmt->execute()) {
                echo json_encode(['status' => 'error', 'message' => 'Erro ao registrar alunos: ' . $stmt->error]);
                $stmt->close();
                exit;
            }
        }
        $stmt->close();

        echo json_encode(['status' => 'success', 'message' => 'Alunos registrados com sucesso.']);
    } else {
        echo json_encode(['status' => 'error', 'message' => 'Turma não encontrada para a aula especificada.']);
    }
}
?>
