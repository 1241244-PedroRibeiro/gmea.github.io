<?php
session_start();
include "./generals/config.php";
$mysqli = new mysqli($bd_host, $bd_user, $bd_password, $bd_database);

if ($mysqli->connect_error) {
    die('Erro: (' . $mysqli->connect_errno . ') ' . $mysqli->connect_error);
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $idPauta = $mysqli->real_escape_string($_POST['id_pauta']);
    $user = $mysqli->real_escape_string($_POST['user']);
    $aproveitamento = $mysqli->real_escape_string($_POST['aproveitamento']);
    $atitudes = $mysqli->real_escape_string($_POST['atitudes']);
    $empenho = $mysqli->real_escape_string($_POST['empenho']);
    $observacoes = $mysqli->real_escape_string($_POST['observacoes']);
    $nivel = $mysqli->real_escape_string($_POST['nivel']);

    if ($nivel == '') {
        // Query para atualizar os dados na tabela de pautas de avaliação
        $query = "UPDATE pautas_avaliacao_intercalar SET par1 = '$aproveitamento', par2 = '$atitudes', par3 = '$empenho', notas = '$observacoes' WHERE id_pauta = '$idPauta' AND user = '$user'";
    } else {
        // Query para atualizar os dados na tabela de pautas de avaliação
        $query = "UPDATE pautas_avaliacao SET par1 = '$aproveitamento', par2 = '$atitudes', par3 = '$empenho', notas = '$observacoes', nivel = '$nivel' WHERE id_pauta = '$idPauta' AND user = '$user'";
    }


    if ($mysqli->query($query) === TRUE) {
        echo json_encode(array('success' => true, 'message' => 'Dados atualizados com sucesso.'));
    } else {
        echo json_encode(array('success' => false, 'message' => 'Erro ao atualizar dados: ' . $mysqli->error));
    }
}
?>
