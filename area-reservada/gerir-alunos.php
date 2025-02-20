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

$alunos = array(); // Initialize the $alunos variable as an empty array

// Code to retrieve students from the database
$query = "SELECT user, nome FROM users1 WHERE type=1"; // Replace "users1" with the correct table name that contains the students

if (isset($_GET['search'])) {
    $search = $_GET['search'];
    $query .= " AND nome LIKE '%$search%'";
}

function obterDadosDoAluno($user) {
    global $mysqli;
    
    // Create a prepared statement to retrieve student data
    $query = "SELECT nome, morada1, morada2, nif FROM users1 WHERE user = ?";
    $stmt = $mysqli->prepare($query);
    
    if ($stmt) {
        $stmt->bind_param("s", $user);
        if ($stmt->execute()) {
            $result = $stmt->get_result();
            if ($result->num_rows > 0) {
                $alunoData = $result->fetch_assoc();
                $stmt->close();
                return $alunoData;
            }
        }
        $stmt->close();
    }

    return null;  // Return null if data retrieval fails
}


$resultado = $mysqli->query($query);

if ($resultado) {
    // Loop to iterate through the results and add the students to the $alunos array
    while ($row = $resultado->fetch_assoc()) {
        $alunos[] = $row;
    }
} else {
    // In case there is an error in the query, display an error message or handle it appropriately
    echo "Erro na consulta: " . $mysqli->error;
}

// Code to retrieve professors from the database
$professores = array(); // Initialize the $professores variable as an empty array

$query_prof = "SELECT u.user, u.nome, d.nome_dis
               FROM users1 u
               INNER JOIN profs p ON u.user = p.user
               INNER JOIN cod_dis d ON p.cod_dis = d.cod_dis
               WHERE u.type = 2";

$resultado_prof = $mysqli->query($query_prof);

if ($resultado_prof) {
    // Loop to iterate through the results and add the professors to the $professores array
    while ($row = $resultado_prof->fetch_assoc()) {
        $professores[] = $row;
    }
} else {
    // In case there is an error in the query, display an error message or handle it appropriately
    echo "Erro na consulta: " . $mysqli->error;
}

$adicionar_socio = 0; // Defina um valor padrão para $adicionar_socio

// Process form submission and insert data into the database
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $user = $_POST["user"];
    $turma = $_POST["turma"];
    $tipo_regime = $_POST["tipo_regime"];
    $instrumento1 = $_POST["instrumento1"];
    $prof_in1 = $_POST["prof_in1"];
    $dur1 = $_POST["dur1"];
    $instrumento2 = $_POST["instrumento2"];
    $prof_in2 = $_POST["prof_in2"];
    $dur2 = $_POST["dur2"];
    $formacao = $_POST["formacao"];
    $orquestra = $_POST["orquestra"];
    $instrumento_orq = $_POST["instrumento_orq"];
    $coro = $_POST["coro"];

    $grau_instrumento1 = $_POST["grau_instrumento1"];
    $grau_instrumento2 = $_POST["grau_instrumento2"];
    $grau_formacao = $_POST["grau_formacao"];
    $grau_orq = $_POST["grau_orq"];
    $grau_coro = $_POST["grau_coro"];





    // Insert the data into the database
    $insert_query = "UPDATE alunos SET turma = ?, tipo_regime = ?, cod_in1 = ?, prof_in1 = ?, dur1 = ?, cod_in2 = ?, prof_in2 = ?, dur2 = ?, cod_fm = ?, cod_orq = ?, cod_in_orq = ?, cod_coro = ?, grau_in1 = ?, grau_in2 = ?, grau_fm = ?, grau_orq = ?, grau_coro = ? WHERE user = ?";
    $stmt = $mysqli->prepare($insert_query);

    if ($stmt) {
        $stmt->bind_param("siisiisiiiiiiiiiis", $turma, $tipo_regime, $instrumento1, $prof_in1, $dur1, $instrumento2, $prof_in2, $dur2, $formacao, $orquestra, $instrumento_orq, $coro, $grau_instrumento1, $grau_instrumento2, $grau_formacao, $grau_orq, $grau_coro, $user);

        if ($stmt->execute()) {
            // Data inserted successfully, redirect to a success page or display a success message
            $successMessage = 'Dados atualizados com sucesso!';
        } else {
            // In case there is an error in the query, display an error message or handle it appropriately
            $errorMessage = 'Erro ao atualizar dados.';
        }

        $stmt->close();
    } else {
        // In case there is an error in the query, display an error message or handle it appropriately
        $errorMessage = 'Erro na preparação da declaração: ' . $mysqli->error;
    }
}

$trumas = array(); // Initialize the $instrumentos variable as an empty array

$query_turmas = "SELECT * from turmas_gerais";

$resultado_turmas = $mysqli->query($query_turmas);

if ($resultado_turmas) {
    // Loop to iterate through the results and add the instruments to the $instrumentos array
    while ($row = $resultado_turmas->fetch_assoc()) {
        $turmas[] = $row;
    }
} else {
    // In case there is an error in the query, display an error message or handle it appropriately
    echo "Erro na consulta: " . $mysqli->error;
}

// Consulta para obter os graus da tabela "graus"
$query_graus = "SELECT id_grau, nome_grau FROM graus";
$resultado_graus = $mysqli->query($query_graus);

// Array para armazenar os graus
$graus = array();

if ($resultado_graus) {
    // Loop para iterar pelos resultados e adicionar os graus ao array
    while ($row = $resultado_graus->fetch_assoc()) {
        $graus[] = $row;
    }
} else {
    // Em caso de erro na consulta, exibe uma mensagem de erro
    echo "Erro na consulta de graus: " . $mysqli->error;
}


?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>GMEA - Gerir Alunos</title>
    <link rel="shortcut icon" type="image/png" href="media/logo.png" />
    <script src="https://use.fontawesome.com/releases/v6.3.0/js/all.js" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.3.1/jquery.min.js" crossorigin="anonymous"></script>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js"></script>
    <link href="https://netdna.bootstrapcdn.com/font-awesome/3.2.1/css/font-awesome.css" rel="stylesheet">
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

    <div class="container">
        <h2>Gerir Alunos</h2>
        <form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="get" class="mb-3">
            <div class="input-group">
                <input type="text" class="form-control" placeholder="Pesquisar aluno por nome" name="search">
                <button style="background-color: #00631b; border-color: black;" class="btn btn-primary" type="submit">Pesquisar</button>
            </div>
        </form>
        <h3>Selecione um aluno:</h3>
        <div class="mb-3">
        <select id="aluno" name="aluno" class="form-select" required>
            <option value="">Selecione um aluno</option>
            <?php foreach ($alunos as $aluno): ?>
                <option value="<?php echo $aluno['user']; ?>" data-user="<?php echo $aluno['user']; ?>">
                    <?php echo $aluno['user'] . ' - ' . $aluno['nome']; ?>
                </option>
            <?php endforeach; ?>
        </select>
        </div>
        <button style="background-color: #00631b; border-color: black;" id="prosseguir-btn" class="btn btn-primary" onclick="carregarInformacoesAluno()">Prosseguir</button>
        <div id="formulario" style="display: none;">
            <h3>Formulário de Dados do Aluno</h3>
            <form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="post">
            <div class="mb-3">
                <label for="turma" class="form-label">Turma</label>
                <select id="turma" name="turma" class="form-select" required>
                    <option value="0">Não Aplicável</option>
                    <?php foreach ($turmas as $turma): ?>
                        <option value="<?php echo $turma['cod_turma']; ?>">
                            <?php echo $turma['cod_turma'] . ' - ' . $turma['nome_turma'];?>
                        </option>
                    <?php endforeach; ?> 
                </select>
            </div>
            <div class="mb-3">
                    <label for="tipo_regime" class="form-label">Regime</label>
                    <select name="tipo_regime" id="tipo_regime" class="form-select" required>
                        <option value="1">Normal</option>
                        <option value="2">Livre</option>
                        <option value="3">Orquestra</option>
                        <option value="4">Coro</option>
                        <option value="5">Ensemble</option>
                        <option value="6">Orquestra e Ensemble</option>
                        <option value="7">Orquestra e Coro</option>
                        <option value="8">Coro e Ensemble</option>
                    </select>
            </div>
            <br>
                <div class="mb-3">
                    <label for="instrumento1" class="form-label">1.º Instrumento</label>
                    <select id="instrumento1" name="instrumento1" class="form-select" required>
                        <option value="0">Não Aplicável</option>
                        <option value="3">Clarinete</option>
                        <option value="4">Saxofone</option>
                        <option value="5">Tuba</option>
                        <option value="6">Trombone</option>
                        <option value="7">Trompa</option>
                        <option value="8">Percussão</option>
                        <option value="12">Violino</option>
                        <option value="13">Viola d'Arco</option>
                        <option value="14">Violoncelo</option>
                        <option value="15">Piano</option>
                        <option value="16">Guitarra</option>
                        <option value="17">Flauta Transversal</option>
                        <option value="18">Trompete</option>
                        <option value="19">Contrabaixo</option>
                        <option value="20">Bombardino</option>
                        <option value="21">Canto</option>
                    </select>
                    <div id="instrumento_1_div" style="display: none;">
                        <label for="prof_in1" class="form-label">Professor 1.º Instrumento</label>
                        <select id="prof_in1" name="prof_in1" class="form-select" required>
                            <option value="0">Não Aplicável</option>
                            <?php foreach ($professores as $professor): ?>
                                <option value="<?php echo $professor['user']; ?>">
                                    <?php echo $professor['user'] . ' - ' . $professor['nome'] . ' (' . $professor['nome_dis'] . ')'; ?>
                                </option>
                            <?php endforeach; ?>
                        </select>
                        <label for="dur1" class="form-label">Duração da Aula (1.º Instrumento)</label>
                        <input type="number" name="dur1" id="dur1" class="form-control" min="0">
                        <label for="grau_instrumento1" class="form-label">Grau</label>
                        <select id="grau_instrumento1" name="grau_instrumento1" class="form-select">
                            <option value="0">Não Aplicável</option>
                            <!-- Loop para iterar pelos graus e criar as opções do select -->
                            <?php foreach ($graus as $grau): ?>
                                <option value="<?php echo $grau['id_grau']; ?>">
                                    <?php echo $grau['nome_grau']; ?>
                                </option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                </div>
                <br>
                <div class="mb-3">
                    <label for="instrumento2" class="form-label">2.º Instrumento</label>
                    <select id="instrumento2" name="instrumento2" class="form-select" required>
                        <option value="0">Não Aplicável</option>
                        <option value="3">Clarinete</option>
                        <option value="4">Saxofone</option>
                        <option value="5">Tuba</option>
                        <option value="6">Trombone</option>
                        <option value="7">Trompa</option>
                        <option value="8">Percussão</option>
                        <option value="12">Violino</option>
                        <option value="13">Viola d'Arco</option>
                        <option value="14">Violoncelo</option>
                        <option value="15">Piano</option>
                        <option value="16">Guitarra</option>
                        <option value="17">Flauta Transversal</option>
                        <option value="18">Trompete</option>
                        <option value="19">Contrabaixo</option>
                        <option value="20">Bombardino</option>
                    </select>
                    <div id="instrumento_2_div" style="display: none;">
                        <label for="prof_in2" class="form-label">Professor 2.º Instrumento</label>
                        <select id="prof_in2" name="prof_in2" class="form-select" required>
                            <option value="0">Não Aplicável</option>
                            <?php foreach ($professores as $professor): ?>
                                <option value="<?php echo $professor['user']; ?>">
                                    <?php echo $professor['user'] . ' - ' . $professor['nome'] . ' (' . $professor['nome_dis'] . ')'; ?>
                                </option>
                            <?php endforeach; ?>
                        </select>
                        <label for="dur2" class="form-label">Duração da Aula (2.º Instrumento)</label>
                        <input type="number" name="dur2" id="dur2" class="form-control" min="0">
                        <label for="grau_instrumento2" class="form-label">Grau</label>
                        <select id="grau_instrumento2" name="grau_instrumento2" class="form-select">
                            <option value="0">Não Aplicável</option>
                            <!-- Loop para iterar pelos graus e criar as opções do select -->
                            <?php foreach ($graus as $grau): ?>
                                <option value="<?php echo $grau['id_grau']; ?>">
                                    <?php echo $grau['nome_grau']; ?>
                                </option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                </div>
                <br>
                <div class="mb-3">
                    <label for="formacao" class="form-label">Formação Musical</label>
                    <select id="formacao" name="formacao" class="form-select" required>
                        <option value="0">Não Aplicável</option>
                        <option value="1">Sim (Iniciação)</option>
                        <option value="2">Sim</option>
                    </select>
                    <div id="formacao-div">
                        <label for="grau_formacao" class="form-label">Grau</label>
                        <select id="grau_formacao" name="grau_formacao" class="form-select">
                            <option value="0">Não Aplicável</option>
                            <!-- Loop para iterar pelos graus e criar as opções do select -->
                            <?php foreach ($graus as $grau): ?>
                                <option value="<?php echo $grau['id_grau']; ?>">
                                    <?php echo $grau['nome_grau']; ?>
                                </option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                </div>
                <div class="mb-3">
                    <label for="orquestra" class="form-label">Orquestra</label>
                    <select id="orquestra" name="orquestra" class="form-select" required>
                        <option value="0">Não Aplicável</option>
                        <option value="11">Orquestra Juvenil</option>
                    </select>
                    <div id="instrumento_orq_div" style="display: none;">
                        <label for="instrumento_orq" class="form-label">Instrumento Orquestra</label>
                        <select id="instrumento_orq" name="instrumento_orq" class="form-select">
                            <option value="0">Não Aplicável</option>
                            <option value="3">Clarinete</option>
                            <option value="4">Saxofone</option>
                            <option value="5">Tuba</option>
                            <option value="6">Trombone</option>
                            <option value="7">Trompa</option>
                            <option value="8">Percussão</option>
                            <option value="12">Violino</option>
                            <option value="13">Viola d'Arco</option>
                            <option value="14">Violoncelo</option>
                            <option value="15">Piano</option>
                            <option value="16">Guitarra</option>
                            <option value="17">Flauta Transversal</option>
                            <option value="18">Trompete</option>
                            <option value="19">Contrabaixo</option>
                            <option value="20">Bombardino</option>
                        </select>
                        <label for="grau_orq" class="form-label">Grau</label>
                        <select id="grau_orq" name="grau_orq" class="form-select">
                            <option value="0">Não Aplicável</option>
                            <!-- Loop para iterar pelos graus e criar as opções do select -->
                            <?php foreach ($graus as $grau): ?>
                                <option value="<?php echo $grau['id_grau']; ?>">
                                    <?php echo $grau['nome_grau']; ?>
                                </option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                </div>
                <div class="mb-3">
                    <label for="coro" class="form-label">Coro</label>
                    <select id="coro" name="coro" class="form-select" required>
                        <option value="0">Não Aplicável</option>
                        <option value="9">Coro Infantil</option>
                        <option value="10">Coro Juvenil</option>
                    </select>
                    <div id="coro-div">
                        <label for="grau_coro" class="form-label">Grau</label>
                        <select id="grau_coro" name="grau_coro" class="form-select">
                            <option value="0">Não Aplicável</option>
                            <!-- Loop para iterar pelos graus e criar as opções do select -->
                            <?php foreach ($graus as $grau): ?>
                                <option value="<?php echo $grau['id_grau']; ?>">
                                    <?php echo $grau['nome_grau']; ?>
                                </option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                </div>
                <input type="hidden" name="user" id="user">
                <button style="background-color: #00631b; border-color: black;" class="btn btn-primary" type="submit">Inserir Dados</button>
            </form>
        </div>
        <?php
        echo '<br>';
        if (isset($successMessage)) {
            print('<br>');
            echo '<div class="alert alert-success" role="alert">' . $successMessage . '</div>';
        }
        
        if (isset($errorMessage)) {
            print('<br>');
            echo '<div class="alert alert-danger" role="alert">' . $errorMessage . '</div>';
        }
    ?>
    </div>

    <script>
        // JavaScript code to show/hide the form based on the selected student
        const alunoSelect = document.getElementById('aluno');
        const userField = document.getElementById('user');
        const prosseguirBtn = document.getElementById('prosseguir-btn');
        const formulario = document.getElementById('formulario');
        const orquestraSelect = document.getElementById('orquestra');
        const instrumento1Select = document.getElementById('instrumento1');
        const instrumentoOrqDiv = document.getElementById('instrumento_orq_div');
        const instrumento1Div = document.getElementById('instrumento_1_div');

        prosseguirBtn.addEventListener('click', function() {
            if (alunoSelect.value === '') {
                alert('Selecione um aluno antes de prosseguir.');
            } else {
                userField.value = alunoSelect.value;
                carregarInformacoesAluno(); // Carregar informações do aluno ao clicar em "Prosseguir"
            }
        });

        function mostrarDuracao(selectElement) {
            var duracaoDiv = document.getElementById("duracaoAula");
            if (selectElement.value !== "0") {
                duracaoDiv.style.display = "block";
            } else {
                duracaoDiv.style.display = "none";
            }
        }

        orquestraSelect.addEventListener('change', function() {
            if (this.value === '11') {
                instrumentoOrqDiv.style.display = 'block';
            } else {
                instrumentoOrqDiv.style.display = 'none';
            }
        });

        instrumento1Select.addEventListener('change', function() {
            if (this.value !== '0') {
                instrumento1Div.style.display = 'block';
            } else {
                instrumento1Div.style.display = 'none';
            }
        });

        const instrumento2Select = document.getElementById('instrumento2');
        const instrumento2Div = document.getElementById('instrumento_2_div');

        instrumento2Select.addEventListener('change', function() {
            if (this.value !== '0') {
                instrumento2Div.style.display = 'block';
            } else {
                instrumento2Div.style.display = 'none';
            }
        });

        // Adicione isso ao final do script JavaScript existente
        const formacaoSelect = document.getElementById('formacao');
        const formacaoDiv = document.getElementById('formacao-div');
        const coroSelect = document.getElementById('coro');
        const coroDiv = document.getElementById('coro-div');

        formacaoSelect.addEventListener('change', function() {
            if (this.value !== '0') {
                formacaoDiv.style.display = 'block';
            } else {
                formacaoDiv.style.display = 'none';
            }
        });

        coroSelect.addEventListener('change', function() {
            if (this.value !== '0') {
                coroDiv.style.display = 'block';
            } else {
                coroDiv.style.display = 'none';
            }
        });



        function carregarInformacoesAluno() {
            const alunoSelect = document.getElementById('aluno');
            const userField = document.getElementById('user');

            // Verifica se um aluno foi selecionado
            if (alunoSelect.value !== '') {
                // Faz uma requisição AJAX para obter as informações do aluno
                $.ajax({
                    type: 'POST',
                    url: 'obterDadosDoAluno1.php', // Substitua pelo caminho do arquivo que irá processar a requisição
                    data: { user: alunoSelect.value },
                    success: function (data) {
                        // Preenche os campos do formulário com as informações do aluno
                        const alunoData = JSON.parse(data);

                        // Preenche os campos do formulário
                        document.getElementById('turma').value = alunoData.turma;
                        document.getElementById('tipo_regime').value = alunoData.tipo_regime;
                        document.getElementById('instrumento1').value = alunoData.cod_in1;
                        document.getElementById('prof_in1').value = alunoData.prof_in1;
                        document.getElementById('dur1').value = alunoData.dur1;
                        document.getElementById('instrumento2').value = alunoData.cod_in2;
                        document.getElementById('prof_in2').value = alunoData.prof_in2;
                        document.getElementById('dur2').value = alunoData.dur2;
                        document.getElementById('formacao').value = alunoData.cod_fm;
                        document.getElementById('orquestra').value = alunoData.cod_orq;
                        document.getElementById('instrumento_orq').value = alunoData.cod_in_orq;
                        document.getElementById('coro').value = alunoData.cod_coro;
                        document.getElementById('grau_instrumento1').value = alunoData.grau_in1;
                        document.getElementById('grau_instrumento2').value = alunoData.grau_in2;
                        document.getElementById('grau_formacao').value = alunoData.grau_fm;
                        document.getElementById('grau_orq').value = alunoData.grau_orq;
                        document.getElementById('grau_coro').value = alunoData.grau_coro;

                        // Verifica o valor de cod_orq e exibe/esconde o campo "Instrumento Orquestra" conforme necessário
                        if (alunoData.cod_orq == '11') { // Use '==' para comparação de valor
                            instrumentoOrqDiv.style.display = 'block';
                        } else {
                            instrumentoOrqDiv.style.display = 'none';
                        }

                        // Verifica o valor de instrumento1 e exibe/esconde o campo do primeiro instrumento conforme necessário
                        if (alunoData.cod_in1 != '0') { // Use '==' para comparação de valor
                            instrumento1Div.style.display = 'block';
                        } else {
                            instrumento1Div.style.display = 'none';
                        }

                        // Verifica o valor de instrumento1 e exibe/esconde o campo do primeiro instrumento conforme necessário
                        if (alunoData.cod_in2 != '0') { // Use '==' para comparação de valor
                            instrumento2Div.style.display = 'block';
                        } else {
                            instrumento2Div.style.display = 'none';
                        }

                        // Lógica para mostrar ou ocultar a subdivisão do coro
                        if (alunoData.cod_coro != '0') {
                            coroDiv.style.display = 'block';
                        } else {
                            coroDiv.style.display = 'none';
                        }

                        // Lógica para mostrar ou ocultar a subdivisão da formação musical
                        if (alunoData.cod_fm != '0') {
                            formacaoDiv.style.display = 'block';
                        } else {
                            formacaoDiv.style.display = 'none';
                        }

                        // Exibe o formulário após carregar as informações
                        formulario.style.display = 'block';
                    },
                    error: function () {
                        alert('Erro ao carregar as informações do aluno.');
                    }
                });
            }
        }

    </script>


</body>

<?php

    include "footer-reservado.php";

?>

</html>