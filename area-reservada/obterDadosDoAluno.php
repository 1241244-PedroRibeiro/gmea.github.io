<?php
// obter_dados_aluno.php

session_start();
include "./generals/config.php";
$mysqli = new mysqli($bd_host, $bd_user, $bd_password, $bd_database);

if ($mysqli->connect_error) {
    die('Erro: (' . $mysqli->connect_errno . ') ' . $mysqli->connect_error);
}

if (isset($_POST['user'])) {
    $user = $_POST['user'];
    
    $query = "SELECT * FROM alunos WHERE user = ?";
    $stmt = $mysqli->prepare($query);

    if ($stmt) {
        $stmt->bind_param("s", $user);
        if ($stmt->execute()) {
            $result = $stmt->get_result();
            if ($result->num_rows > 0) {
                $alunoData = $result->fetch_assoc();
            }
        }
        $stmt->close();
    }

    $queryirmaos = "SELECT * FROM irmaos WHERE user_1 = ?";
    $stmtirmaos = $mysqli->prepare($queryirmaos);

    $irmaosData = array();
    if ($stmtirmaos) {
        $stmtirmaos->bind_param("s", $user);
        if ($stmtirmaos->execute()) {
            $resultirmaos = $stmtirmaos->get_result();
            while ($irmao = $resultirmaos->fetch_assoc()) {
                // Obter o nome do irmão da tabela 'users1'
                $queryNomeIrmao = "SELECT nome FROM users1 WHERE user = ?";
                $stmtNomeIrmao = $mysqli->prepare($queryNomeIrmao);
                if ($stmtNomeIrmao) {
                    $stmtNomeIrmao->bind_param("s", $irmao['user_1_irmao']);
                    if ($stmtNomeIrmao->execute()) {
                        $resultNomeIrmao = $stmtNomeIrmao->get_result();
                        if ($resultNomeIrmao->num_rows > 0) {
                            $nomeIrmao = $resultNomeIrmao->fetch_assoc()['nome'];
                            $irmao['nome'] = $nomeIrmao; // Adiciona o nome ao array do irmão
                        }
                    }
                    $stmtNomeIrmao->close();
                }
                $irmaosData[] = $irmao;
            }
        }
        $stmtirmaos->close();
    }

    // Combine aluno data and irmaos data into one array
    $response = array(
        'aluno' => $alunoData,
        'irmaos' => $irmaosData
    );

    echo json_encode($response);
}
?>
