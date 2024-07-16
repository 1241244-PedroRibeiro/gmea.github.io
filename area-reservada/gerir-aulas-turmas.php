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
    $result = $mysqli->query("SELECT user, nome, estado FROM users1 WHERE type = 1 AND estado=1");
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

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $alunoOuTurma = $_POST["cod_turma"];
    $disciplina = $_POST["disciplina_turma"];
    $horaInicio = $_POST["horaInicio"];
    $horaFim = $_POST["horaFim"];
    $diaDaSemana = $_POST["diaDaSemana"];

    // Obter o professor responsável selecionado
    $professor_responsavel = $_POST["professor_responsavel"];

    // Verifique se é uma aula de turma
    if (!empty($_POST["alunos_selecionados"])) {
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
                           VALUES ('$alunoOuTurma', '$professor_responsavel', '$disciplina', '$nome_turma')";

            if (adicionarTurma($alunoOuTurma, $professor_responsavel, $disciplina, $nome_turma) && mysqli_query($mysqli, $queryTurma)) {
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
        $queryAula = "INSERT INTO aulas (userOuTurma, cod_dis, hora_inicio, hora_fim, dia_semana, prof)
                      VALUES ('$alunoOuTurma', '$disciplina', '$horaInicio', '$horaFim', '$diaDaSemana', '$professor_responsavel')";

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

    <?php
        $alunos = getAllAlunos();

        echo '<div class="container mt-4">';
        echo '<h3>Criar Turma</h3>';
        echo '<form method="post" action="">';
        echo '<div class="mb-3">';
        echo '<label for="cod_turma" class="form-label">Código da Turma:</label>';
        $nextCodTurma = getNextTurmaCode();
        echo '<input type="text" class="form-control" id="cod_turma" name="cod_turma" value="' . $nextCodTurma . '" readonly>';
        echo '</div>';
        echo '<div class="mb-3">';
        echo '<label for="professor_responsavel" class="form-label">Prof da Turma:</label>';
        echo '<select class="form-select" id="professor_responsavel" name="professor_responsavel">';
        foreach ($professores as $prof_user => $prof_nome) {
            echo '<option value="' . $prof_user . '">' . $prof_nome . '</option>';
        }
        echo '</select>';
        echo '</div>';
        echo '<div class="mb-3">';
        echo '<label for="disciplina_turma" class="form-label">Disciplina da Turma:</label>';
        echo '<select class="form-select" id="disciplina_turma" name="disciplina_turma">';
        foreach ($disciplinas as $cod_dis => $nome_dis) {
            echo '<option value="' . $cod_dis . '">' . $nome_dis . '</option>';
        }
        echo '</select>';
        echo '</div>';
        echo '<div class="mb-3">';
        echo '<label for="nome" class="form-label">Título da Turma:</label>';
        echo '<input type="text" class="form-control" id="nome" name="nome" required>';
        echo '</div>';
        ?>
        <div class="mb-3">
            <label for="horaInicio" class="form-label">Hora Início:</label>
            <input type="time" class="form-control" id="horaInicio" name="horaInicio" required>
        </div>
        <div class="mb-3">
            <label for="horaFim" class="form-label">Hora Fim:</label>
            <input type="time" class="form-control" id="horaFim" name="horaFim" required>
        </div>
            <div class="mb-3">
                <label for="diaDaSemana" class="form-label">Dia da Semana:</label>
                <select name="diaDaSemana" id="diaDaSemana" class="form-select" required>
                    <option value="1">Segunda</option>
                    <option value="2">Terça</option>
                    <option value="3">Quarta</option>
                    <option value="4">Quinta</option>
                    <option value="5">Sexta</option>
                    <option value="6">Sábado</option>
                    <option value="7">Domingo</option>
                </select>
        </div>
        <?php

        echo '<div class="mb-3">';
        echo '<label class="form-label">Selecione os Alunos:</label>';
        echo '<select class="form-select" multiple name="alunos_selecionados[]" id="selectAlunos">';
        foreach ($alunos as $user => $aluno_nome) {
            echo '<option value="' . $user . '">' . $aluno_nome . '</option>';
        }
        echo '</select>';
        echo '</div>';
        echo '<button type="button" class="btn btn-primary" id="adicionarAluno">Adicionar Aluno</button>';
        echo '<table class="table mt-3">';
        echo '<thead><tr><th>User</th><th>Nome</th><th>Ação</th></tr></thead>';
        echo '<tbody id="alunosAdicionadosTable"></tbody>';
        echo '</table>';
        echo '<input type="hidden" id="alunosSelecionadosJSON" name="alunos_selecionados_json">';
        echo '<button type="submit" class="btn btn-primary" name="create_turma">Criar Turma</button>';
        echo '</form>';
    echo '</div>';    
    ?>

<script>
    $(document).ready(function() {
        var alunosSelecionados = [];
        var alunosTurma = [];

        $("#adicionarAluno").click(function() {
            var selectedAlunos = $("#selectAlunos option:selected");

            selectedAlunos.each(function() {
                var user = $(this).val();
                var nome = $(this).text();
                alunosSelecionados.push({ user: user, nome: nome });
                alunosTurma.push({ user: user });

                $(this).remove();
            });

            updateAlunosAdicionadosTable();
        });

        function updateAlunosAdicionadosTable() {
            var table = $("#alunosAdicionadosTable");
            table.empty();

            for (var i = 0; i < alunosSelecionados.length; i++) {
                var aluno = alunosSelecionados[i];
                var row = '<tr><td>' + aluno.user + '</td><td>' + aluno.nome + '</td>';
                row += '<td><button type="button" class="btn btn-danger" onclick="removerAluno(' + i + ')">Remover</button></td></tr>';
                table.append(row);
            }

            // Atualize o campo hidden com os alunos selecionados em JSON
            $("#alunosSelecionadosJSON").val(JSON.stringify(alunosTurma));
        }

        function removerAluno(index) {
            var alunoRemovido = alunosSelecionados.splice(index, 1)[0];
            // Adicione de volta o aluno removido à lista de seleção de alunos
            $("#selectAlunos").append('<option value="' + alunoRemovido.user + '">' + alunoRemovido.nome + '</option>');
            
            // Remova o aluno da lista de alunos da turma
            for (var i = 0; i < alunosTurma.length; i++) {
                if (alunosTurma[i].user === alunoRemovido.user) {
                    alunosTurma.splice(i, 1);
                    break;
                }
            }

            updateAlunosAdicionadosTable();
        }

        window.removerAluno = removerAluno;
    });
</script>

</body>

</html>