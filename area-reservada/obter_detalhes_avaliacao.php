<?php
session_start();
include "./generals/config.php";
$mysqli = new mysqli($bd_host, $bd_user, $bd_password, $bd_database);

if ($mysqli->connect_error) {
    die('Erro na conexão com o banco de dados: ' . $mysqli->connect_error);
}

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['id_avaliacao'])) {
    $idAvaliacao = $mysqli->real_escape_string($_POST['id_avaliacao']);

    // Consulta para obter os detalhes da avaliação
    $queryDetalhes = "SELECT * FROM avaliacoes WHERE id_avaliacao = '$idAvaliacao'";
    $resultDetalhes = $mysqli->query($queryDetalhes);

    $detalhesAvaliacoes = array();

    if ($resultDetalhes && $resultDetalhes->num_rows > 0) {
        while ($row = $resultDetalhes->fetch_assoc()) {
            $user = $row['user'];
            $queryNome = "SELECT nome, foto FROM users1 WHERE user = '$user'";
            $resultNome = $mysqli->query($queryNome);
            if ($resultNome && $resultNome->num_rows > 0) {
                while ($rowNome = $resultNome->fetch_assoc()) {
                    $nome = $rowNome['nome'];
                    $foto = $rowNome['foto'];
                }
            }
            // Aqui você pode ajustar os detalhes conforme necessário
            $detalhes = array(
                'user' => $user,
                'foto' => $foto,
                'nome' => $nome,
                'escala' => $row['escala'],
                'nivel' => $row['nivel'],
                'observacoes' => $row['notas'],
                'data_avaliacao' => $row['data_avaliacao']
            );
            $detalhesAvaliacoes[] = $detalhes;
        }

        echo json_encode($detalhesAvaliacoes);
    } else {
        echo json_encode($detalhesAvaliacoes);
    }

    $resultDetalhes->free();
}

$mysqli->close();
?>
