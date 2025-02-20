<?php
session_start();
include "./generals/config.php";
$mysqli = new mysqli($bd_host, $bd_user, $bd_password, $bd_database);

if ($mysqli->connect_error) {
    die('Erro: (' . $mysqli->connect_errno . ') ' . $mysqli->connect_error);
}

// Verifica se os dados foram recebidos via POST
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['detailsArray'])) {
    // Recebe os dados enviados
    $detailsArray = $_POST['detailsArray'];

    // Prepara a consulta de inserção
    $insertQuery = "INSERT INTO avaliacoes (id_avaliacao, tipo_avaliacao, escala, nivel, notas, data_avaliacao, data_inserido, prof, disciplina, user, userOuTurma) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";

    // Prepara a declaração SQL
    $stmt = $mysqli->prepare($insertQuery);

    if ($stmt) {
        // Itera sobre cada item do array de detalhes
        foreach ($detailsArray as $detail) {
            // Atribui os valores dos detalhes às variáveis
            $idAvaliacao = $detail['id_avaliacao'];
            $tipoAvaliacao = $detail['tipo_avaliacao'];
            $escala = $detail['escala'];
            $nivel = $detail['nivel'];
            $notas = $detail['notas'];
            $dataAvaliacao = $detail['data_avaliacao'];
            $dataInserido = date("Y/m/d");
            $prof = $detail['prof'];
            $disciplina = $detail['disciplina'];
            $user = $detail['user'];
            $userOuTurma = $detail['userOuTurma'];

            // Associa parâmetros à declaração SQL
            $stmt->bind_param("iiissssssss", $idAvaliacao, $tipoAvaliacao, $escala, $nivel, $notas, $dataAvaliacao, $dataInserido, $prof, $disciplina, $user, $userOuTurma);

            // Executa a declaração preparada para inserir os dados
            if (!$stmt->execute()) {
                // Em caso de erro, exibe mensagem de erro
                echo "Erro ao inserir avaliação: " . $stmt->error;
                break; // Encerra o loop em caso de erro
            }

            // Incrementa o ID da avaliação para o próximo
            $idAvaliacao++;
        }

        // Fecha a declaração SQL
        $stmt->close();

        // Retorna uma resposta de sucesso (pode ser adaptado conforme necessário)
        echo json_encode(array("success" => true, "message" => "Avaliações inseridas com sucesso!"));
    } else {
        // Em caso de falha na preparação da declaração SQL
        echo "Erro ao preparar a declaração SQL: " . $mysqli->error;
    }
} else {
    // Caso os dados não tenham sido recebidos via POST
    echo "Nenhum dado recebido para processamento.";
}

// Fecha a conexão com o banco de dados
$mysqli->close();
?>
