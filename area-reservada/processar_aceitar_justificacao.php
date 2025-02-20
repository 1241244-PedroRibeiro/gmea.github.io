<?php
session_start();
include "./generals/config.php";
$mysqli = new mysqli($bd_host, $bd_user, $bd_password, $bd_database);

if ($mysqli->connect_error) {
    die('Erro: (' . $mysqli->connect_errno . ') ' . $mysqli->connect_error);
}

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["indice_aula"])) {
    $indice_aula = $mysqli->real_escape_string($_POST["indice_aula"]);
    $tipo_falta = $mysqli->real_escape_string($_POST["tipo_falta"]);
    $user = $mysqli->real_escape_string($_POST["user"]);
    $id_aula = $mysqli->real_escape_string($_POST["id_aula"]);

    // Aqui você pode utilizar $user e $tipo_falta conforme necessário na sua lógica de atualização de banco de dados
    // Por exemplo, você pode verificar $tipo_falta e executar diferentes ações com base nisso

    if ($tipo_falta == 2) {
        // Exemplo de consulta para atualizar o tipo de falta na tabela 'faltas'
        $queryUpdateFaltas = "UPDATE faltas SET tipo_falta = '1' WHERE indice_aula = '$indice_aula' AND user = '$user' AND id_aula = '$id_aula'";
        $resultUpdateFaltas = $mysqli->query($queryUpdateFaltas);
    }

    // Exemplo de consulta para atualizar o estado da justificação na tabela 'justificacao_faltas'
    $queryUpdateJustificacao = "UPDATE justificacao_faltas SET estado = '1' WHERE indice_aula = '$indice_aula' AND user = '$user' AND id_aula = '$id_aula'";
    $resultUpdateJustificacao = $mysqli->query($queryUpdateJustificacao);

    if ($resultUpdateJustificacao) {
        echo "Justificação aceita com sucesso.";
    } else {
        echo "Erro ao aceitar justificação: " . $mysqli->error;
    }
} else {
    echo "Erro: Requisição inválida.";
}

?>
