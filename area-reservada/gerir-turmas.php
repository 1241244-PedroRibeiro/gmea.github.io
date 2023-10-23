<?php
session_start();
include "./generals/config.php";
$mysqli = new mysqli($bd_host, $bd_user, $bd_password, $bd_database);

if ($mysqli->connect_error) {
    die('Erro: (' . $mysqli->connect_errno . ') ' . $mysqli->connect_error);
}

if (empty($_SESSION["session_id"]) || $_SESSION["type"] != 3) {
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
    $stmt->execute();
    $stmt->close();
}

function getAllAlunos()
{
    global $mysqli;
    $alunos = array();
    $result = $mysqli->query("SELECT user, nome FROM users1 WHERE type = 1");
    while ($row = $result->fetch_assoc()) {
        $alunos[$row['user']] = $row['user'] . " - " . $row['nome'];
    }
    return $alunos;
}

// Função para adicionar os alunos selecionados à tabela da turma
function adicionarAlunosTurma($table_name, $alunos_selecionados)
{
    global $mysqli;
    $values = array();
    foreach ($alunos_selecionados as $aluno) {
        $values[] = "('" . $mysqli->real_escape_string($aluno) . "')";
    }
    $values_str = implode(",", $values);
    $sql = "INSERT INTO $table_name (user) VALUES $values_str ON DUPLICATE KEY UPDATE user=user";
    $mysqli->query($sql);
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

    <?php include "header-direcao.php"; ?>

    <div class="container mt-4">
        <h2>Gestão de Turmas</h2>

        <!-- Dropdown para selecionar a ação desejada -->
        <form method="post" action=""> <!-- Adicionamos o formulário aqui -->
            <div class="mb-3">
                <label for="selectAcao" class="form-label">Selecione o que fazer:</label>
                <select class="form-select" id="selectAcao" name="action">
                    <option value="criar_turma">Criar Turma</option>
                    <option value="gerir_turma">Gerir Turma</option>
                    <option value="eliminar_turma">Eliminar Turma</option>
                </select>
            </div>
            <!-- Adicionamos um input hidden para armazenar a ação selecionada -->
            <input type="hidden" name="prosseguir" value="1">
            <button type="submit" class="btn btn-primary">Prosseguir</button>
        </form>

    </div>

    <?php
        // Verificar se a ação "Criar Turma" foi selecionada e mostrar formulário para adicionar alunos
        if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["action"]) && $_POST["action"] === "criar_turma") {
            // Obter todos os alunos existentes
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

            // Lista de alunos disponíveis para seleção
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
            echo '<button type="submit" class="btn btn-primary" name="create_turma">Criar Turma</button>';
            echo '</form>';
            echo '</div>';
        }

        
        // Verificar se o formulário de criação de turma foi submetido
        if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["create_turma"])) {
            $cod_turma = $_POST["cod_turma"];
            $prof_turma = $_POST["professor_responsavel"];
            $dis_turma = $_POST["disciplina_turma"];
            $nome_turma = $_POST["nome"];

            echo "Cod. Turma: " . $cod_turma . "<br>";
            echo "Prof. Turma: " . $prof_turma . "<br>";
            echo "Dis. Turma: " . $dis_turma . "<br>";
            echo "Nome Turma: " . $nome_turma . "<br>";
            echo "Alunos selecionados: ";

            // Verificar se a variável 'alunos_selecionados' está definida
            if (isset($_POST['alunos_selecionados'])) {
                // Se estiver definida, atribuir o valor a uma variável
                $alunos_selecionados = $_POST['alunos_selecionados'];
                print_r($alunos_selecionados);

                adicionarTurma($cod_turma, $prof_turma, $dis_turma, $nome_turma);

                // Adicionar alunos à turma
                if (!empty($alunos_selecionados)) {
                    $table_name = 't' . substr($cod_turma, 1); // Nome da tabela da turma (por exemplo, t001)

                    // Verificar se a tabela já existe antes de criar uma nova tabela
                    $check_table_sql = "SHOW TABLES LIKE '$table_name'";
                    $table_exists = $mysqli->query($check_table_sql)->num_rows > 0;

                    if (!$table_exists) {
                        $sql = "CREATE TABLE $table_name (user VARCHAR(255) PRIMARY KEY, nome VARCHAR(255))";
                        $mysqli->query($sql);
                    }

                    adicionarAlunosTurma($table_name, $_POST['alunos_selecionados']);
                    echo '<div class="alert alert-success mt-3">Turma criada com sucesso e alunos adicionados!</div>';
                }
            } else {
                // Se a variável 'alunos_selecionados' não estiver definida, inicializá-la como um array vazio
                $alunos_selecionados = array();
                print_r($alunos_selecionados);

                adicionarTurma($cod_turma, $prof_turma, $dis_turma, $nome_turma);
            }
        }

        ?>

        <script>
            $(document).ready(function() {
                var alunosSelecionados = [];

                $("#adicionarAluno").click(function() {
                    var selectedAlunos = $("#selectAlunos option:selected");

                    selectedAlunos.each(function() {
                        var user = $(this).val();
                        var nome = $(this).text();
                        alunosSelecionados.push({user: user, nome: nome});

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
                }

                function removerAluno(index) {
                    var alunoRemovido = alunosSelecionados.splice(index, 1)[0];
                    $("#selectAlunos").append('<option value="' + alunoRemovido.user + '">' + alunoRemovido.nome + '</option>');
                    updateAlunosAdicionadosTable();
                }

                window.removerAluno = removerAluno;
            });
        </script>


    <?php include "footer-reservado.php"; ?>

</body>

</html>