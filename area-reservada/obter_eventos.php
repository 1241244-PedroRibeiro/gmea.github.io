<?php
// Inclua o arquivo de configuração e inicialize a conexão com o banco de dados
include "./generals/config.php";
$mysqli = new mysqli($bd_host, $bd_user, $bd_password, $bd_database);

// Verifique se a conexão com o banco de dados foi estabelecida com sucesso
if ($mysqli->connect_error) {
    die('Erro: (' . $mysqli->connect_errno . ') ' . $mysqli->connect_error);
}
// Inicializa a variável $events para armazenar os eventos do calendário
$events = array();

// Verifica se há uma seleção válida do formulário via método POST
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['selecionado'])) {
    $selecionado = $_POST['selecionado'];

    // Consulta para obter os eventos com base no aluno/turma selecionado
    $query = "SELECT * FROM calendario WHERE userOuTurma = '$selecionado' AND tipo_evento < 6";
    $result = $mysqli->query($query);

    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            // Cria um array para cada evento encontrado na consulta
            $events[] = array(
                'id' => $row['id_evento'],
                'title' => $row['titulo'],
                'start' => $row['inicio'],
                'end' => $row['fim'],
                'description' => $row['notas'],
                'destinatario' => $row['userOuTurma'],
                'disciplina' => $row['cod_dis'],
                'tipo_evento' => $row['tipo_evento'],
                'criadorEvento' => $row['criador']
            );
        }
    }
}

// Retorna os eventos em formato JSON
echo json_encode($events);
