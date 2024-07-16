<?php
// Incluir arquivo de configuração do banco de dados
include "./generals/config.php";

// Verificar se a requisição é do tipo POST e se o parâmetro `detailsArray` foi enviado
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['detailsArray'])) {
    // Conectar ao banco de dados
    $mysqli = new mysqli($bd_host, $bd_user, $bd_password, $bd_database);

    // Verificar a conexão
    if ($mysqli->connect_error) {
        die('Erro na conexão: (' . $mysqli->connect_errno . ') ' . $mysqli->connect_error);
    }

    // Extrair e decodificar o array de detalhes da requisição
    $detailsArray = json_decode($_POST['detailsArray'], true);

    // Preparar consulta SQL para atualizar cada registro
    $successCount = 0;
    $errorMessages = [];

    foreach ($detailsArray as $detail) {
        $idAvaliacao = $mysqli->real_escape_string($detail['id_avaliacao']);
        $escala = $mysqli->real_escape_string($detail['escala']);
        $nivel = $mysqli->real_escape_string($detail['nivel']);
        $observacoes = $mysqli->real_escape_string($detail['observacoes']); // Corrigir o nome do campo para 'observacoes'
        $dataAvaliacao = $mysqli->real_escape_string($detail['data_avaliacao']);
        $user = $mysqli->real_escape_string($detail['user']);

        // Consulta SQL para atualizar os dados da avaliação
        $updateQuery = "UPDATE avaliacoes SET escala = '$escala', nivel = '$nivel', notas = '$observacoes', data_avaliacao = '$dataAvaliacao' WHERE id_avaliacao = '$idAvaliacao' AND user = '$user'";

        // Executar a consulta de atualização
        if ($mysqli->query($updateQuery) === TRUE) {
            $successCount++;
        } else {
            $errorMessages[] = 'Erro na atualização para a avaliação com ID ' . $idAvaliacao . ': ' . $mysqli->error;
        }
    }

    // Fechar a conexão com o banco de dados
    $mysqli->close();

    // Verificar se todas as atualizações foram bem-sucedidas
    if ($successCount == count($detailsArray)) {
        // Responder com um JSON indicando sucesso
        echo json_encode(array('success' => true, 'message' => 'Avaliações atualizadas com sucesso.'));
    } else {
        // Responder com um JSON indicando falha nas atualizações e incluir mensagens de erro
        echo json_encode(array('success' => false, 'message' => 'Erro ao atualizar avaliações.', 'errors' => $errorMessages));
    }
} else {
    // Responder com um JSON indicando erro se os parâmetros necessários não foram recebidos
    echo json_encode(array('success' => false, 'message' => 'Parâmetros inválidos para atualização das avaliações.'));
}
?>
