<?php
session_start();
include "./generals/config.php";
$mysqli = new mysqli($bd_host, $bd_user, $bd_password, $bd_database);

if ($mysqli->connect_error) {
    die('Erro: (' . $mysqli->connect_errno . ') ' . $mysqli->connect_error);
}

$user = $_SESSION['username'];

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $idAula = $_POST['id_aula'];
    $indiceAula = $_POST['indice_aula'];
    $novoTextoSumario = $_POST['texto_sumario'];

    // Atualizar o sumário na base de dados
    $queryAtualizar = "UPDATE sumarios SET sumario_texto = ? WHERE id_aula = ? AND indice_aula = ?";
    
    // Preparar a declaração SQL
    $stmt = $mysqli->prepare($queryAtualizar);
    
    if ($stmt) {
        // Vincular parâmetros e executar a declaração
        $stmt->bind_param("sss", $novoTextoSumario, $idAula, $indiceAula);
        $stmt->execute();

        if ($stmt->affected_rows > 0) {
            // Redirecionar de volta à página de edição com mensagem de sucesso
            header("Location: editar-sumarios.php?sucesso=true");
            exit();
        } else {
            echo "Erro ao atualizar o sumário. Por favor, tente novamente.";
        }

        // Fechar a declaração e a conexão
        $stmt->close();
    } else {
        echo "Erro na preparação da declaração SQL.";
    }
}

// Fechar a conexão com o banco de dados
$mysqli->close();
?>
