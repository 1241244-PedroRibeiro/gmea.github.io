<?php
session_start();
include "./generals/config.php";
$mysqli = new mysqli($bd_host, $bd_user, $bd_password, $bd_database);

if ($mysqli->connect_error) {
    die('Erro: (' . $mysqli->connect_errno . ') ' . $mysqli->connect_error);
}

if (empty($_SESSION["session_id"]) || $_SESSION["type"] < 3) {
    header("Location: ../index.php");
    exit;
}

// Função para obter o próximo valor do código da turma
function getNextTurmaCode()
{
    global $mysqli;
    $stmt = $mysqli->query("SELECT MAX(cod_turma) AS max_cod FROM turmas_gerais");
    $row = $stmt->fetch_assoc();
    $maxCod = $row['max_cod'];

    // Extrair o número do código da turma
    $lastNumber = (int)substr($maxCod, 2);

    // Incrementar o número e formatar com a letra 't'
    $nextNumber = $lastNumber + 1;
    $nextCodTurma = 'tg' . str_pad($nextNumber, 3, '0', STR_PAD_LEFT);

    return $nextCodTurma;
}

// Função para adicionar uma nova turma
function adicionarTurma($cod_turma, $nome_turma)
{
    global $mysqli;
    $stmt = $mysqli->prepare("INSERT INTO turmas_gerais (cod_turma, nome_turma) VALUES (?, ?)");
    $stmt->bind_param("ss", $cod_turma, $nome_turma);

    if ($stmt->execute()) {
        $stmt->close();
        return true;
    } else {
        // Tratamento de erro
        return false;
    }
}

// Função para atualizar o nome da turma
function atualizarNomeTurma($cod_turma, $novo_nome)
{
    global $mysqli;
    $stmt = $mysqli->prepare("UPDATE turmas_gerais SET nome_turma = ? WHERE cod_turma = ?");
    $stmt->bind_param("ss", $novo_nome, $cod_turma);

    if ($stmt->execute()) {
        $stmt->close();
        return true;
    } else {
        // Tratamento de erro
        return false;
    }
}

// Função para eliminar uma turma
function eliminarTurma($cod_turma)
{
    global $mysqli;
    $stmt = $mysqli->prepare("DELETE FROM turmas_gerais WHERE cod_turma = ?");
    $stmt->bind_param("s", $cod_turma);

    if ($stmt->execute()) {
        $stmt->close();
        return true;
    } else {
        // Tratamento de erro
        return false;
    }
}

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["create_turma"])) {
    $cod_turma = $_POST["cod_turma"];
    $nome_turma = $_POST["nome"];
}

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>GMEA</title>
    <link rel="shortcut icon" type="image/png" href="media/logo.png" />
    <script src="https://use.fontawesome.com/releases/v6.3.0/js/all.js" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.3.1/jquery.min.js" crossorigin="anonymous"></script>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js"></script>
    <link href="https://netdna.bootstrapcdn.com/font-awesome/3.2.1/css/font-awesome.css" rel="stylesheet">

    <style>
        @keyframes fadeIn {
            0% {
                opacity: 0;
            }

            100% {
                opacity: 1;
            }
        }

        .contact-info {
            text-align: right;
        }
    </style>
</head>

<body>
    <div style="margin-top: 0;">
        <img style="width: 100%; height: auto;" src="./media/topAR.png" class="img-responsive">
    </div>

    <?php 
        if ($_SESSION["type"] == 3) { // Mostrar cabeçalho para professores
            include "header-direcao.php"; 
        } 
        if ($_SESSION["type"] == 4) { // Mostrar cabeçalho para professores
            include "header-professor-direcao.php";
        } 

    ?>

    <div class="container mt-4">
        <h2>Gestão de Turmas</h2>

        <!-- Dropdown para selecionar a ação desejada -->
        <form method="post" action="">
            <div class="mb-3">
                <label for="selectAcao" class="form-label">Selecione o que fazer:</label>
                <select class="form-select" id="selectAcao" name="action">
                    <option value="criar_turma">Criar Turma</option>
                    <option value="gerir_turma">Gerir Turma</option>
                    <option value="eliminar_turma">Eliminar Turma</option>
                </select>
            </div>
            <input type="hidden" name="prosseguir" value="1">
            <button type="submit" class="btn btn-primary">Prosseguir</button>
        </form>
    </div>

    <?php
    // Verificar se a ação "Criar Turma" foi selecionada e mostrar formulário para adicionar alunos
    if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["action"]) && $_POST["action"] === "criar_turma") {
        echo '<div class="container mt-4">';
        echo '<h3>Criar Turma</h3>';
        echo '<form method="post" action="">';
        echo '<div class="mb-3">';
        echo '<label for="cod_turma" class="form-label">Código da Turma:</label>';
        $nextCodTurma = getNextTurmaCode();
        echo '<input type="text" class="form-control" id="cod_turma" name="cod_turma" value="' . $nextCodTurma . '" readonly>';
        echo '</div>';
        echo '<div class="mb-3">';
        echo '<label for="nome" class="form-label">Título da Turma:</label>';
        echo '<input type="text" class="form-control" id="nome" name="nome" required>';
        echo '</div>';
        echo '<button type="submit" class="btn btn-primary" name="create_turma">Criar Turma</button>';
        echo '</form>';
        echo '</div>';
    }
// Verificar se a ação "Gerir Turma" foi selecionada e mostrar formulário para editar o nome da turma
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["action"]) && $_POST["action"] === "gerir_turma") {
    echo '<div class="container mt-4">';
    echo '<h3>Editar Nome da Turma</h3>';
    echo '<form method="post" action="">';
    echo '<div class="mb-3">';
    echo '<label for="cod_turma_edit" class="form-label">Selecione a Turma:</label>';
    echo '<select class="form-select" id="cod_turma_edit" name="cod_turma_edit">';
    // Buscar todas as turmas gerais da base de dados e preencher as opções do select
    $result = $mysqli->query("SELECT cod_turma, nome_turma FROM turmas_gerais");
    while ($row = $result->fetch_assoc()) {
        echo '<option value="' . $row['cod_turma'] . '">' . $row['nome_turma'] . '</option>';
    }
    echo '</select>';
    echo '</div>';
    echo '<div class="mb-3">';
    echo '<label for="novo_nome" class="form-label">Novo Título da Turma:</label>';
    echo '<input type="text" class="form-control" id="novo_nome" name="novo_nome" required>';
    echo '</div>';
    echo '<button type="submit" class="btn btn-primary" name="editar_turma">Salvar Alterações</button>';
    echo '</form>';
    echo '</div>';
}

// Verificar se a ação "Eliminar Turma" foi selecionada e mostrar formulário de confirmação
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["action"]) && $_POST["action"] === "eliminar_turma") {
    echo '<div class="container mt-4">';
    echo '<h3>Eliminar Turma</h3>';
    echo '<form method="post" action="">';
    echo '<div class="mb-3">';
    echo '<label for="cod_turma_eliminar" class="form-label">Selecione a Turma:</label>';
    echo '<select class="form-select" id="cod_turma_eliminar" name="cod_turma_eliminar">';
    // Buscar todas as turmas gerais da base de dados e preencher as opções do select
    $result = $mysqli->query("SELECT cod_turma, nome_turma FROM turmas_gerais");
    while ($row = $result->fetch_assoc()) {
        echo '<option value="' . $row['cod_turma'] . '">' . $row['nome_turma'] . '</option>';
    }
    echo '</select>';
    echo '</div>';
    echo '<button type="submit" class="btn btn-danger" name="eliminar_turma_confirma">Confirmar Eliminação</button>';
    echo '</form>';
    echo '</div>';
}

    
        // Verificar se o formulário de edição de turma foi submetido
        if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["editar_turma"])) {
            // Aqui você precisa obter o código da turma e o novo nome da turma do formulário
            $cod_turma = $_POST["cod_turma_edit"];
            $novo_nome_turma = $_POST["novo_nome"];
        
            if (atualizarNomeTurma($cod_turma, $novo_nome_turma)) {
                echo '<div class="alert alert-success mt-3">Nome da turma atualizado com sucesso!</div>';
            } else {
                echo '<div class="alert alert-danger mt-3">Erro ao atualizar o nome da turma!</div>';
            }
        }
    
        // Verificar se o formulário de eliminação de turma foi submetido
        if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["eliminar_turma_confirma"])) {
            // Aqui você precisa obter o código da turma a ser eliminada do formulário
            $cod_turma_eliminar = $_POST["cod_turma_eliminar"];
        
            if (eliminarTurma($cod_turma_eliminar)) {
                echo '<div class="alert alert-success mt-3">Turma eliminada com sucesso!</div>';
            } else {
                echo '<div class="alert alert-danger mt-3">Erro ao eliminar a turma!</div>';
            }
        }
        ?>
            <?php include "footer-reservado.php"; ?>
    </body>

</html>