<?php
ini_set('display_errors','Off');
ini_set('error_reporting', E_ALL );
define('WP_DEBUG', false);
define('WP_DEBUG_DISPLAY', false);
session_start();
include "./generals/config.php";
$mysqli = new mysqli($bd_host, $bd_user, $bd_password, $bd_database);

if ($mysqli->connect_error) {
    die('Erro: (' . $mysqli->connect_errno . ') ' . $mysqli->connect_error);
}

if (empty($_SESSION["session_id"]) || $_SESSION["type"] < 3) {
    header("Location: ../../index.php");
    exit;
}

// Função para obter o próximo valor do código da turma
function getNextTurmaCode()
{
    global $mysqli;
    $stmt = $mysqli->query("SELECT MAX(cod_turma) AS max_cod FROM turmas");
    $row = $stmt->fetch_assoc();
    $maxCod = $row['max_cod'];

    // Extrair o número do código da turma
    $lastNumber = (int)substr($maxCod, 1);

    // Incrementar o número e formatar com a letra 't'
    $nextNumber = $lastNumber + 1;
    $nextCodTurma = 't' . str_pad($nextNumber, 3, '0', STR_PAD_LEFT);

    return $nextCodTurma;
}

// Função para adicionar uma nova turma
function adicionarTurma($cod_turma, $prof_turma, $dis_turma, $nome_turma)
{
    global $mysqli;
    $stmt = $mysqli->prepare("INSERT INTO turmas (cod_turma, prof_turma, dis_turma, nome_turma) VALUES (?, ?, ?, ?)");
    $stmt->bind_param("ssss", $cod_turma, $prof_turma, $dis_turma, $nome_turma);

    if ($stmt->execute()) {
        $stmt->close();
        return true;
    } else {
        // Tratamento de erro
        return false;
    }
}

// Função para adicionar alunos à tabela 'turmas_alunos'
function adicionarAlunosATurma($cod_turma, $user)
{
    global $mysqli;
    $table_name = 'turmas_alunos';
    $stmt = $mysqli->prepare("INSERT INTO $table_name (cod_turma, user) VALUES (?, ?)");

    if (!$stmt) {
        // Tratamento de erro
        return false;
    }

    if ($stmt->bind_param("ss", $cod_turma, $user) && $stmt->execute()) {
        $stmt->close();
        return true;
    } else {
        // Tratamento de erro
        return false;
    }
}

// Função para obter todos os alunos
function getAllAlunos()
{
    global $mysqli;
    $alunos = array();
    $result = $mysqli->query("SELECT user, nome FROM users1 WHERE type = 1 and estado=1");
    while ($row = $result->fetch_assoc()) {
        $alunos[$row['user']] = $row['user'] . " - " . $row['nome'];
    }
    return $alunos;
}

// Obter todos os professores existentes
$professores = array();
$result = $mysqli->query("SELECT user, nome FROM profs");
while ($row = $result->fetch_assoc()) {
    $professores[$row['user']] = $row['user'] . " - " . $row['nome'];
}

// Obter todas as disciplinas existentes
$disciplinas = array();
$result = $mysqli->query("SELECT cod_dis, nome_dis FROM cod_dis");
while ($row = $result->fetch_assoc()) {
    $disciplinas[$row['cod_dis']] = $row['nome_dis'];
}

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["create_turma"])) {
    $cod_turma = $_POST["cod_turma"];
    $prof_turma = $_POST["professor_responsavel"];
    $dis_turma = $_POST["disciplina_turma"];
    $nome_turma = $_POST["nome"];

    $queryTurma = "INSERT INTO turmas (cod_turma, prof_turma, dis_turma, nome_turma)
    VALUES ('$cod_turma', '$prof_turma', '$dis_turma', '$nome_turma')";

    if (mysqli_query($mysqli, $queryTurma)) {
        
    } else {
        
    }
    
    // Obtenha os alunos selecionados do campo JSON
    $alunos_selecionados_json = $_POST["alunos_selecionados_json"];
    $alunos_selecionados = json_decode($alunos_selecionados_json);

    if (!empty($alunos_selecionados)) {
        foreach ($alunos_selecionados as $aluno) {
            $user = $aluno->user; // Obtenha o valor do usuário
            // Chame a função para adicionar cada aluno à tabela 'turmas_alunos'
            adicionarAlunosATurma($cod_turma, $user);
        }
    }
}

// Função para obter os alunos com base no professor logado
function getAlunos($mysqli, $professor) {
    $query = "SELECT users1.user, users1.nome, users1.estado
              FROM alunos
              WHERE users1.estado=1
              INNER JOIN users1 ON alunos.user = users1.user";

    $result = $mysqli->query($query);

    $alunos = array();

    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            $alunos[] = $row;
        }
    }

    return $alunos;
}

// Função para obter as turmas com base no professor logado
function getTurmas($mysqli, $professor) {
    $query = "SELECT cod_turma, nome_turma FROM turmas";

    $result = $mysqli->query($query);

    $turmas = array();

    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            $turmas[] = $row;
        }
    }

    return $turmas;
}

// Process form submission and insert data into the database
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $alunoOuTurma = $_POST["cod_turma"];
    $prof = $_POST["prof"];
    $disciplina = $_POST["disciplina_turma"];
    $horaInicio = $_POST["horaInicio"];
    $horaFim = $_POST["horaFim"];
    $diaDaSemana = $_POST["diaDaSemana"];

    if (isset($_POST["atualizarAula"])) {

        // Recupere os dados do formulário
        $idAula = $_POST["id_aula"];
        $userOuTurma = $_POST["userOuTurma"];
        $disciplina = $_POST["disciplina"];
        $horaInicio = $_POST["horaInicio"];
        $horaFim = $_POST["horaFim"];
        $diaDaSemana = $_POST["diaDaSemana"];

        // Atualize os dados na tabela aulas
        $updateAulaQuery = "UPDATE aulas SET userOuTurma = '$userOuTurma', cod_dis = '$disciplina', prof = '$prof_turma'
                            hora_inicio = '$horaInicio', hora_fim = '$horaFim', dia_semana = '$diaDaSemana'
                            WHERE id_aula = $idAula";
        
        if ($mysqli->query($updateAulaQuery)) {
            // Atualize os dados na tabela alunos associados a esta aula
            if ($mysqli->query($updateAulaQuery)) {
                $mensagem = "Aula alterada com sucesso";
            } else {
                echo "<script>$('#mensagem-erro').show().html('Erro ao atualizar alunos: " . $mysqli->error . "');</script>";
            }
        } else {
            echo "<script>$('#mensagem-erro').show().html('Erro ao atualizar aula: " . $mysqli->error . "');</script>";
        }

    }

         // Verificar se a ação é "eliminarAula"
    else if (isset($_POST["acao"]) && $_POST["acao"] == "eliminarAula") {
        $idAula = $_POST["id_aula_eliminar"];

        // Eliminar a aula da tabela aulas
        $deleteAulaQuery = "DELETE FROM aulas WHERE id_aula = $idAula";

        if ($mysqli->query($deleteAulaQuery)) {
            $mensagem = "Aula eliminada com sucesso.";
        } else {
            $mensagem = "Houve um erro ao eliminar a aula.";
        }
    }

    // Verifique se é uma aula de turma
    else if (!empty($_POST["alunos_selecionados"])) {
        // É uma aula de turma
        // Adicione os alunos à tabela 'turmas_alunos'
        $alunos_selecionados_json = $_POST["alunos_selecionados_json"];
        $alunos_selecionados = json_decode($alunos_selecionados_json);

        if (!empty($alunos_selecionados)) {
            foreach ($alunos_selecionados as $aluno) {
                $user = $aluno->user;
                // Chame a função para adicionar cada aluno à tabela 'turmas_alunos'
                adicionarAlunosATurma($alunoOuTurma, $user);
            }
        }

        // Insira os dados da turma na tabela 'turmas' apenas se a turma não existir
        $queryCheckTurma = "SELECT * FROM turmas WHERE cod_turma = '$alunoOuTurma'";
        $resultCheckTurma = $mysqli->query($queryCheckTurma);

        if ($resultCheckTurma->num_rows === 0) {
            // Turma não existe, então crie
            $queryTurma = "INSERT INTO turmas (cod_turma, prof_turma, dis_turma, nome_turma)
                           VALUES ('$alunoOuTurma', '$prof_turma', '$disciplina', '$nome_turma')";

            if (adicionarTurma($alunoOuTurma, $prof_turma, $disciplina, $nome_turma) && mysqli_query($mysqli, $queryTurma)) {
                echo '<div class="alert alert-success mt-3">Turma criada com sucesso!</div>';
            } else {
                echo '<div class="alert alert-danger mt-3">Erro ao criar a turma!</div>';
            }
        } else {
            echo '<div class="alert alert-warning mt-3">A turma já existe!</div>';
        }
    } else {
        // É uma aula individual
        // Insira os dados da aula na tabela 'aulas'
        $prof = $_POST["prof"];
        if (isset($prof)) {
            $prof_turma = $prof;
        }
        $queryAula = "INSERT INTO aulas (userOuTurma, prof, cod_dis, hora_inicio, hora_fim, dia_semana)
                      VALUES ('$alunoOuTurma', '$prof_turma', '$disciplina', '$horaInicio', '$horaFim', '$diaDaSemana')";

        if (mysqli_query($mysqli, $queryAula)) {
            $mensagem = "Aula confirmada.";
        } else {
            $mensagem = "Erro na inserção da aula: " . mysqli_error($mysqli);
        }
    }
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

    <!DOCTYPE html>

    <div class="container">

    <h2>Selecione uma opção:</h2>
    <select class="form-select" id="opcoes" onchange="mostrarOpcoes()">
        <option value="0">Selecione</option>
        <option value="criar">Criar Aula</option>
        <option value="editar">Editar Aula</option>
        <option value="eliminar">Eliminar Aula</option>
    </select>

    <div id="opcoesContainer"></div>

    <script>
        function mostrarOpcoes() {
            var selecionado = document.getElementById("opcoes").value;
            var container = document.getElementById("opcoesContainer");

            if (selecionado === "criar") {
                container.innerHTML = ""; // Limpar o conteúdo se não for "criar"
                container.innerHTML = `
                    <h3>Selecione o tipo de aula a criar:</h3>
                    <select class="form-select" id="tipoAula" onchange="carregarPagina()">
                        <option value="0">Selecione</option>       
                        <option value="individual">Aulas Individuais</option>
                        <option value="grupo">Aulas de Grupo</option>
                    </select>
                `;
            } else if (selecionado === "editar") {
                container.innerHTML = ""; // Limpar o conteúdo se não for "criar"
                    // Carregar conteúdo do arquivo inserir-aulas.php
                    fetch('modificar-aulas.php')
                    .then(response => response.text())
                    .then(data => {
                        container.innerHTML += data;
                        executaScripts(container); // Adicionar esta linha
                    });
                
            } else if (selecionado === "eliminar") {
                container.innerHTML = ""; // Limpar o conteúdo se não for "criar"
                    // Carregar conteúdo do arquivo inserir-aulas.php
                    fetch('eliminar-aulas.php')
                    .then(response => response.text())
                    .then(data => {
                        container.innerHTML += data;
                        executaScripts(container); // Adicionar esta linha
                    });

            } else {
                container.innerHTML = ""; // Limpar o conteúdo se não for "criar"
            }
        }

        function carregarPagina() {
            var tipoAulaSelecionado = document.getElementById("tipoAula").value;
            var container = document.getElementById("opcoesContainer");

            if (tipoAulaSelecionado === "individual") {
                // Carregar conteúdo do arquivo inserir-aulas.php
                fetch('inserir-aulas.php')
                    .then(response => response.text())
                    .then(data => {
                        container.innerHTML += data;
                        executaScripts(container); // Adicionar esta linha
                    });
            } else if (tipoAulaSelecionado === "grupo") {
                // Carregar conteúdo do arquivo gerir-turmas.php
                fetch('gerir-aulas-turmas.php')
                    .then(response => response.text())
                    .then(data => {
                        container.innerHTML = data; // Change this line to replace innerHTML instead of appending
                        executaScripts(container); // Adicionar esta linha
                    });
            }

        }

        function executaScripts(container) {
            // Extrai scripts da string HTML e os executa
            var scripts = container.getElementsByTagName('script');
            for (var i = 0; i < scripts.length; i++) {
                eval(scripts[i].innerText);
            }
        }

        
    </script>

                <?php
                    if (isset($mensagem)) {
                        print("<br/>");
                        echo "<div class='alert alert-info'>$mensagem</div>";
                    }
                ?>

    </div>


    <?php include "footer-reservado.php"; ?>



</body>

</html>