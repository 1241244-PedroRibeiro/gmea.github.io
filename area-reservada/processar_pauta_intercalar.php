<?php
session_start();
include "./generals/config.php";
$mysqli = new mysqli($bd_host, $bd_user, $bd_password, $bd_database);

if ($mysqli->connect_error) {
    die('Erro: (' . $mysqli->connect_errno . ') ' . $mysqli->connect_error);
}

// Verificar se os dados foram recebidos por POST
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Receber e validar os dados enviados via POST
    $detailsArray = $_POST['detailsArray'];

    foreach ($detailsArray as $detail) {
        $userOuTurma = $detail['userOuTurma'];
        $disciplina = $detail['disciplina'];
        $semestre = $detail['semestre'];

        // Verificar se já existe um registro com os mesmos critérios
        $checkStmt = $mysqli->prepare("SELECT COUNT(*) AS count FROM pautas_avaliacao_intercalar WHERE userOuTurma = ? AND disciplina = ? AND semestre = ?");
        $checkStmt->bind_param("sii", $userOuTurma, $disciplina, $semestre);
        $checkStmt->execute();
        $checkResult = $checkStmt->get_result();
        $checkData = $checkResult->fetch_assoc();

        if ($checkData['count'] != 0) {
            // Se o método de requisição não for POST
            echo json_encode(array("success" => false, "error" => "Já existe um registo. Caso pretenda fazer alterações, seleccione a opção de editar."));
        }
        else {
            // Preparar e executar a inserção na tabela pautas_avaliacao
            $insertStmt = $mysqli->prepare("INSERT INTO pautas_avaliacao_intercalar (id_pauta, user, disciplina, par1, par2, par3, notas, prof, userOuTurma, semestre) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");
        }
    }        

    if ($insertStmt) {
        // Iterar sobre os detalhes recebidos e inserir cada registro na tabela
        foreach ($detailsArray as $detail) {
            $userOuTurma = $detail['userOuTurma'];
            $disciplina = $detail['disciplina'];
            $semestre = $detail['semestre'];

            // Verificar se já existe um registro com os mesmos critérios

                $aproveitamento = $detail['aproveitamento'];
                $atitudes = $detail['atitudes'];
                $empenho = $detail['empenho'];
                $observacoes = $detail['observacoes'];
                $prof = $detail['prof'];
                $user = $detail['user'];
                $id_pauta = $detail['id_pauta']; 

                $insertStmt->bind_param("isiiiisssi", $id_pauta, $user, $disciplina, $aproveitamento, $atitudes, $empenho, $observacoes, $prof, $userOuTurma, $semestre);
                $insertStmt->execute();
        }

        // Fechar o statement de inserção
        $insertStmt->close();

        // Responder ao cliente (JavaScript) com sucesso
        echo json_encode(array("success" => true));
    } else {
        // Se houver erro na preparação da query
        echo json_encode(array("success" => false, "error" => "Erro ao preparar a query."));
    }
} else {
    // Se o método de requisição não for POST
    echo json_encode(array("success" => false, "error" => "Método inválido."));
}

// Fechar a conexão com o banco de dados
$mysqli->close();
?>