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
    $regime = $_POST["regime"];
    $tipo_regime = $_POST["tipo_regime"];
    $instrumento1 = $_POST["instrumento1"];
    $prof_in1 = $_POST["prof_in1"];
    $dur1 = $_POST["dur1"];
    $instrumento2 = $_POST["instrumento2"];
    $prof_in2 = $_POST["prof_in2"];
    $dur2 = $_POST["dur2"];
    $formacao = $_POST["formacao"];
    $orquestra = $_POST["orquestra"];
    $coro = $_POST["coro"];
    $in_alg = $_POST["in_alg"];
    $desc_irmaos = $_POST["desc_irmaos"];
    $quotaee = isset($_POST["quotaee"]) ? $_POST["quotaee"] : "1";

    $adicionar_socio = isset($_POST["adicionar_socio"]) ? $_POST["adicionar_socio"] : 0;

    
    // Atualização da coluna "irmaos" com base na seleção do usuário
    $irmaos = ($_POST["irmaos"] == "1") ? 1 : 0;

    // Atualização da coluna "user_irmaos" com base na seleção do usuário
    $user_irmaos = ($_POST["irmaos"] == "1") ? $_POST["user_irmaos"] : null;

    $mem_bs = $_POST["mem_bs"];


    // Insert the data into the database
    $insert_query = "UPDATE alunos SET regime = ?, tipo_regime = ?, cod_in1 = ?, prof_in1 = ?, dur1 = ?, cod_in2 = ?, prof_in2 = ?, dur2 = ?, cod_fm = ?, cod_orq = ?, cod_coro = ?, in_alg = ?, irmaos = ?, user_irmaos = ?, desc_irmaos = ?, quota_socio = ?, mem_bs = ? WHERE user = ?";
    $stmt = $mysqli->prepare($insert_query);
    $insert_query = "UPDATE instrumentos SET estado = ?, user = ? WHERE codigo = ?";
    $stmti = $mysqli->prepare($insert_query);
    
    if ($stmt) {
        $stmt->bind_param("iiisiisiiiiiisiiis", $regime, $tipo_regime, $instrumento1, $prof_in1, $dur1, $instrumento2, $prof_in2, $dur2, $formacao, $orquestra, $coro, $in_alg, $irmaos, $user_irmaos, $desc_irmaos, $quotaee, $mem_bs, $user);

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

    if ($stmti) {
        $cre = 1;
        $stmti->bind_param("isi", $cre, $user, $in_alg);
    
        if ($stmti->execute()) {
            // Data inserted successfully, redirect to a success page or display a success message
            $successMessage = 'Dados atualizados com sucesso!';
        } else {
            // In case there is an error in the query, display an error message or handle it appropriately
            $errorMessage = 'Erro ao atualizar dados.';
        }
    
        $stmti->close();
    } else {
        // In case there is an error in the query, display an error message or handle it appropriately
        $errorMessage = 'Erro na preparação da declaração: ' . $mysqli->error;
    }
}

$instrumentos = array(); // Initialize the $instrumentos variable as an empty array

$query_ins = "SELECT i.cat, i.codigo, i.estado, i.user, u.nome
           FROM instrumentos i
           LEFT JOIN alunos a ON i.user = a.user
           LEFT JOIN users1 u ON i.user = u.user";

$resultado_ins = $mysqli->query($query_ins);

if ($resultado_ins) {
    // Loop to iterate through the results and add the instruments to the $instrumentos array
    while ($row = $resultado_ins->fetch_assoc()) {
        $instrumentos[] = $row;
    }
} else {
    // In case there is an error in the query, display an error message or handle it appropriately
    echo "Erro na consulta: " . $mysqli->error;
}


if ($adicionar_socio == "1") {
    // Adicionar como sócio
    $alunoData = obterDadosDoAluno($user);
    if ($alunoData) {
        // Insira os dados do aluno na tabela "socios"
        $inserirSocio = $mysqli->prepare("INSERT INTO socios (nome, morada1, morada2, nif) VALUES (?, ?, ?, ?)");
        $inserirSocio->bind_param("ssss", $alunoData["nome"], $alunoData["morada1"], $alunoData["morada2"], $alunoData["nif"]);
        if ($inserirSocio->execute()) {
            // Obter o último "num_socio" inserido na tabela "socios"
            $ultimoNumSocio = $mysqli->query("SELECT MAX(num_socio) FROM socios")->fetch_row()[0];
            // Inserir o valor de "num_socio" na tabela "alunos"
            $inserirNumSocio = $mysqli->prepare("UPDATE alunos SET num_socio = ? WHERE user = ?");
            $inserirNumSocio->bind_param("ss", $ultimoNumSocio, $user);
            if ($inserirNumSocio->execute()) {
                $k=1;
            } else {
                $k=1;
            }
        } else {
            $errorMessage = 'Erro ao adicionar aluno como sócio.';
        }
    } else {
        $errorMessage = 'Erro ao obter os dados do aluno.';
    }
}

if ($adicionar_socio == "2") {
    // Já é sócio
    $num_socio_selecionado = $_POST["num_socio_selecionado"];
    if (!empty($num_socio_selecionado)) {
        // Atualize o registro do aluno com o número de sócio selecionado
        $inserirNumSocio = $mysqli->prepare("UPDATE alunos SET num_socio = ? WHERE user = ?");
        $inserirNumSocio->bind_param("ss", $num_socio_selecionado, $user);
        if ($inserirNumSocio->execute()) {
            $k=1;
        } else {
            $k=1;
        }
    }
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
        include "header-direcao.php";
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
        <button style="background-color: #00631b; border-color: black;" id="prosseguir-btn" class="btn btn-primary">Prosseguir</button>
        <div id="formulario" style="display: none;">
            <h3>Formulário de Dados do Aluno</h3>
            <form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="post">
            <div class="mb-3">
                    <label for="regime" class="form-label">Regime</label>
                    <select name="regime" id="regime" class="form-select" required>
                        <option value="4">Pré-Iniciação</option>
                        <option value="1">Iniciação</option>
                        <option value="2">Básico</option>
                        <option value="3">Secundário</option>
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
                </div>
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
                </div>
                <div class="mb-3">
                    <label for="formacao" class="form-label">Formação Musical</label>
                    <select id="formacao" name="formacao" class="form-select" required>
                        <option value="0">Não Aplicável</option>
                        <option value="1">Sim</option>
                    </select>
                </div>
                <div class="mb-3">
                    <label for="orquestra" class="form-label">Orquestra</label>
                    <select id="orquestra" name="orquestra" class="form-select" required>
                        <option value="0">Não Aplicável</option>
                        <option value="11">Orquestra Juvenil</option>
                    </select>
                </div>
                <div class="mb-3">
                    <label for="coro" class="form-label">Coro</label>
                    <select id="coro" name="coro" class="form-select" required>
                        <option value="0">Não Aplicável</option>
                        <option value="9">Coro Infantil</option>
                        <option value="10">Coro Juvenil</option>
                    </select>
                </div>
                <div class="mb-3">
                    <label for="in_alg" class="form-label">Instrumento Alugado</label>
                    <select id="in_alg" name="in_alg" class="form-select" required>
                        <option value="0">Não Aplicável</option>
                        <?php foreach ($instrumentos as $instrumento): ?>
                            <option value="<?php echo $instrumento['codigo']; ?>">
                                <?php echo $instrumento['codigo'] . ' - ' . $instrumento['cat'];
                                if ($instrumento['estado'] == 1) {
                                    echo ' (' . $instrumento['user'] . ' - ' . $instrumento['nome'] . ')';
                                }
                                ?>
                            </option>
                        <?php endforeach; ?> 
                    </select>
                </div>
                <div class="mb-3">
                    <label for="irmaos" class="form-label">Tem irmãos?</label>
                    <select name="irmaos" id="irmaos" class="form-select" required onchange="showSiblingSelect(this)">
                        <option value="0">Não</option>
                        <option value="1">Sim</option>
                    </select>
                </div>

                <div id="user_irmaos" style="display: none;" class="mb-3">
                    <label for="user_irmaos" class="form-label">Selecionar irmão:</label>
                    <select name="user_irmaos" id="user_irmaos" class="form-select">
                        <option value="">Selecione o irmão</option>
                        <?php
                        // Loop through the $alunos array to populate sibling options
                        foreach ($alunos as $aluno) {
                            echo '<option value="' . $aluno['user'] . '">' . $aluno['user'] . ' - ' . $aluno['nome'] . '</option>';
                        }
                        ?>
                    </select>
                    <input type="checkbox" id="elegivel1" name="elegivel1" value="0" onchange="updateDescIrmaos()"/>
                    <label for="elegivel1"> Elegível para desconto irmãos? </label>
                    <input type="checkbox" id="elegivel2" name="elegivel2" value="0" onchange="updateDescIrmaos()"/>
                    <label for="elegivel2"> Desconto 2.º irmão? </label>
                    <input type="hidden" name="desc_irmaos" id="desc_irmaos" value="0">
                    <input type="checkbox" id="quotaee_input" name="quotaee" value="1" onchange="updateDescIrmaos()"/>
                    <label for="quotaee"> Paga quota juntamente com o E.E.? </label>
                </div>
                <div class="mb-3">
                    <label for="mem_bs" class="form-label">Membro da Banda Sinfónica:</label>
                    <select name="mem_bs" id="mem_bs" class="form-select" required>
                        <option value="0">Não</option>
                        <option value="1">Sim</option>
                    </select>
                </div>
                <div class="mb-3">
                    <label for="adicionar_socio" class="form-label">Adicionar como sócio?</label>
                    <select name="adicionar_socio" id="adicionar_socio" class="form-select">
                        <option value="1">Sim</option>
                        <option value="2">Já é sócio</option>
                    </select>
                </div>
                <div id="num_socio_selecionado_div" style="display: none;" class="mb-3">
                    <label for="num_socio_selecionado" class="form-label">Selecionar sócio existente:</label>
                    <select name="num_socio_selecionado" id="num_socio_selecionado" class="form-select">
                        <option value="">Selecione o sócio</option>
                        <?php
                        // Consulta a tabela "socios" para obter todos os sócios
                        $query_socios = "SELECT num_socio, nome FROM socios";
                        $resultado_socios = $mysqli->query($query_socios);
                        if ($resultado_socios) {
                            while ($row = $resultado_socios->fetch_assoc()) {
                                echo '<option value="' . $row['num_socio'] . '">' . $row['num_socio'] . ' - ' . $row['nome'] . '</option>';
                            }
                        }
                        ?>
                    </select>
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

        prosseguirBtn.addEventListener('click', function() {
            if (alunoSelect.value === '') {
                alert('Selecione um aluno antes de prosseguir.');
            } else {
                userField.value = alunoSelect.value;
                formulario.style.display = 'block'; // Exibir o formulário
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

            function showSiblingSelect(user_irmaosSelect) {
                const siblingSelect = document.getElementById('user_irmaos');
                
                if (user_irmaosSelect.value === '1') {
                    siblingSelect.style.display = 'block'; // Exibe o campo de seleção de irmãos
                } else {
                    siblingSelect.style.display = 'none'; // Oculta o campo de seleção de irmãos
                }
            }

            function updateDescIrmaos() {
                var descIrmaosInput = document.getElementById('desc_irmaos');
                var irmaos1Checkbox = document.getElementById('elegivel1');
                var irmaos2Checkbox = document.getElementById('elegivel2');

                if (irmaos1Checkbox.checked) {
                    descIrmaosInput.value = "1";
                } 
                else if (irmaos2Checkbox.checked) {
                    descIrmaosInput.value = "2";
                }
                else {
                    descIrmaosInput.value = "0";
                }

                var quotaeeInput = document.getElementById('quotaee_input');
                if (quotaeeInput.checked) {
                    quotaeeInput.value = "2"; // Define o valor como 2 quando a checkbox está selecionada
                } else {
                    quotaeeInput.value = "1"; // Define o valor como 1 quando a checkbox não está selecionada
                }
            }

            const adicionarSocioSelect = document.getElementById('adicionar_socio');
            const numSocioSelecionadoDiv = document.getElementById('num_socio_selecionado_div');

            adicionarSocioSelect.addEventListener('change', function() {
                if (adicionarSocioSelect.value === '2') {
                    numSocioSelecionadoDiv.style.display = 'block';
                } else {
                    numSocioSelecionadoDiv.style.display = 'none';
                }
            });

    </script>
</body>

<?php

    include "footer-reservado.php";

?>

</html>