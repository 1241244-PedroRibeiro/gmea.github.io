<?php
// Conectar ao banco de dados (substitua pelos detalhes reais do seu banco)
$mysqli = new mysqli($bd_host, $bd_user, $bd_password, $bd_database);

// Verificar a conexão
if ($mysqli->connect_error) {
    die('Erro na Conexão: (' . $mysqli->connect_errno . ') ' . $mysqli->connect_error);
}

// Obter o ID da aula do POST
$aulaID = $_POST['aulaID'];

// Consultar o banco de dados para obter detalhes da aula
$query = "SELECT hora_inicio, hora_fim FROM aulas WHERE id = $aulaID";
$result = $mysqli->query($query);

if ($result) {
    $row = $result->fetch_assoc();

    // Criar um array associativo com os detalhes da aula
    $aulaDetails = array(
        'hora_inicio' => $row['hora_inicio'],
        'hora_fim' => $row['hora_fim']
        // Adicione outros campos conforme necessário
    );

    // Saída JSON
    echo json_encode($aulaDetails);
} else {
    // Em caso de erro na consulta
    echo json_encode(array('error' => 'Erro ao obter detalhes da aula.'));
}

// Fechar a conexão
$mysqli->close();
?>
