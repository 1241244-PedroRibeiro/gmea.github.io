<?php
session_start();
include "./generals/config.php";
$mysqli = new mysqli($bd_host, $bd_user, $bd_password, $bd_database);

if ($mysqli->connect_error) {
    die('Erro: (' . $mysqli->connect_errno . ') ' . $mysqli->connect_error);
}

$username = $_SESSION["username"];

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $indice_aula = $_POST['indiceAula'];
    $tipo_falta = $_POST['tipoFaltaHidden'];
    $indice_falta = $_POST['indiceFalta'];
    $motivo = $_POST['motivo'];
    $id_aula = $_POST['id_aula'];

    // Verifica se um arquivo foi enviado
    if (isset($_FILES["anexo"]) && $_FILES["anexo"]["error"] === UPLOAD_ERR_OK) {
        $targetDir = "anexos-justificacoes-faltas/";
        $fileName = basename($_FILES["anexo"]["name"]);
        $targetFilePath = $targetDir . $fileName;
        $fileType = pathinfo($targetFilePath, PATHINFO_EXTENSION);

        // Move o arquivo para o diretório de destino
        if (move_uploaded_file($_FILES["anexo"]["tmp_name"], $targetFilePath)) {
            $anexo = $targetFilePath;
        } else {
            echo "Erro ao fazer upload do anexo.";
            exit; // Encerra o script em caso de falha no upload
        }
    } else {
        $anexo = ""; // Define como vazio se nenhum arquivo foi enviado
    }

    // Inserir dados na tabela de justificacao_faltas
    $queryInsert = "INSERT INTO justificacao_faltas (indice_falta, tipo_falta, user, id_aula, indice_aula, data_pedido, motivo, anexo) 
                    VALUES ('$indice_falta', '$tipo_falta', '$username', $id_aula, '$indice_aula', NOW(), '$motivo', '$anexo')";

    if ($mysqli->query($queryInsert)) {
        // Construir a resposta de sucesso em formato JSON
        $response = array(
            'success' => true,
            'message' => 'Justificação enviada com sucesso!'
        );
    } else {
        // Construir a resposta de erro em formato JSON
        $response = array(
            'success' => false,
            'message' => 'Erro ao enviar justificação: ' . $mysqli->error
        );
    }

    // Enviar resposta como JSON de volta para o JavaScript
    header('Content-Type: application/json');
    echo json_encode($response);
}

?>
