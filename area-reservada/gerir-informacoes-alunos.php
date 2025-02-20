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

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    if (isset($_POST['mem_bs'])) {
        $alunoPrincipal = $_POST['user'];
        $membs = $_POST['mem_bs'];
        
        $descIrmaos = null;
        if (isset($_POST['desc_irmaos'])) {
            $descIrmaos = $_POST['desc_irmaos'];
        }

        $stmt = $mysqli->prepare("UPDATE alunos SET mem_bs = ?, desc_irmaos = ? WHERE user = ?");
        $stmt->bind_param("sis", $membs, $descIrmaos, $alunoPrincipal);
        $stmt->execute();

        if (isset($_POST['alunos_selecionados_json'])) {
            $alunosSelecionados = json_decode($_POST['alunos_selecionados_json'], true);
            $stmtdel = $mysqli->prepare("DELETE FROM irmaos WHERE user_1 = ?");
            $stmtdel->bind_param("s", $alunoPrincipal);
            $stmtdel->execute();
            
            $numIrmao = 1;
            foreach ($alunosSelecionados as $aluno) {
                $userIrmao = $aluno['user'];
                $stmtInsertIrmao = $mysqli->prepare("INSERT INTO irmaos (user_1, user_1_irmao, num_irmao) VALUES (?, ?, ?)");
                $stmtInsertIrmao->bind_param("ssi", $alunoPrincipal, $userIrmao, $numIrmao);
                $stmtInsertIrmao->execute();
                $numIrmao++;
            }
            $successMessage = "Dados inseridos com sucesso.";
        } else {
            $errorMessage = "Nenhum irmão selecionado.";
        }
    } else {
        $errorMessage = "Dados de membro da Banda Sinfónica não recebidos.";
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
                    <label for="irmaos" class="form-label">Tem irmãos?</label>
                    <select name="irmaos" id="irmaos" class="form-select" required onchange="showSiblingSelect(this)">
                        <option value="0">Não</option>
                        <option value="1">Sim</option>
                    </select>
                </div>

                <div id="user_irmaos" style="display: none;" class="mb-3">
                    <div class="mb-3">
                        <label class="form-label">Selecione os Alunos:</label>
                        <select class="form-select" multiple name="alunos_selecionados[]" id="selectAlunos">
                            <?php foreach ($alunos as $aluno): ?>
                                <option value="<?php echo $aluno['user']; ?>"><?php echo $aluno['user'] . ' - ' . $aluno['nome']; ?></option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                    <button type="button" class="btn btn-primary" id="adicionarAluno">Adicionar Aluno</button>
                    <table class="table mt-3">
                        <thead>
                            <tr>
                                <th>User</th>
                                <th>Nome</th>
                                <th>Ação</th>
                            </tr>
                        </thead>
                        <tbody id="alunosAdicionadosTable"></tbody>
                    </table>
                    <input type="hidden" id="alunosSelecionadosJSON" name="alunos_selecionados_json">
                    <div id="desconto_irmaos" class="mt-3">
                        <label class="form-label">Elegível para Desconto:</label><br>
                        <input type="checkbox" id="desconto1" name="desc_irmaos" value="1" onclick="selecionarDesconto(this)">
                        <label for="desconto1">Sim - 1.º Irmão</label><br>
                        <input type="checkbox" id="desconto2" name="desc_irmaos" value="2" onclick="selecionarDesconto(this)">
                        <label for="desconto2">Sim - 2.º Irmão</label><br>
                        <input type="checkbox" id="desconto3" name="desc_irmaos" value="3" onclick="selecionarDesconto(this)">
                        <label for="desconto3">Não</label>
                    </div>
                </div>



                <div class="mb-3">
                    <label for="mem_bs" class="form-label">Membro da Banda Sinfónica:</label>
                    <select name="mem_bs" id="mem_bs" class="form-select" required>
                        <option value="0">Não</option>
                        <option value="1">Sim</option>
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

        function showSiblingSelect(user_irmaosSelect) {
            const siblingSelect = document.getElementById('user_irmaos');
            
            if (user_irmaosSelect.value === '1') {
                siblingSelect.style.display = 'block'; // Exibe o campo de seleção de irmãos
            } else {
                siblingSelect.style.display = 'none'; // Oculta o campo de seleção de irmãos
            }
        }

        $(document).ready(function() {
            var alunosSelecionados = [];

            $("#adicionarAluno").click(function() {
                var selectedAlunos = $("#selectAlunos option:selected");

                selectedAlunos.each(function() {
                    var user = $(this).val();
                    var nome = $(this).text();

                    // Construir a linha da tabela com o aluno selecionado
                    var row = '<tr><td>' + user + '</td><td>' + nome + '</td>';
                    row += '<td><button type="button" class="btn btn-danger" onclick="removerAluno(' + alunosSelecionados.length + ')">Remover</button></td></tr>';

                    // Adicionar o aluno selecionado ao array
                    alunosSelecionados.push({ user: user, nome: nome });

                    // Adicionar a linha à tabela de alunos adicionados
                    $("#alunosAdicionadosTable").append(row);

                    // Atualizar o campo hidden com os alunos selecionados em JSON
                    $("#alunosSelecionadosJSON").val(JSON.stringify(alunosSelecionados));
                });
            });

            function removerAluno(index) {
                const tableBody = document.getElementById('alunosAdicionadosTable');
                const rows = tableBody.rows;
                if (index < rows.length) {
                    tableBody.deleteRow(index);

                    // Atualize a array de alunos selecionados
                    const alunosSelecionados = [];
                    for (let i = 0; i < rows.length; i++) {
                        const cells = rows[i].cells;
                        alunosSelecionados.push({
                            user: cells[0].innerText,
                            nome: cells[1].innerText
                        });
                    }

                    // Atualize o campo escondido com a array de alunos selecionados
                    document.getElementById('alunosSelecionadosJSON').value = JSON.stringify(alunosSelecionados);
                }
            }


            window.removerAluno = removerAluno;

            function updateAlunosAdicionadosTable() {
                // Limpa a tabela
                $("#alunosAdicionadosTable").empty();

                // Preenche a tabela com os alunos selecionados
                alunosSelecionados.forEach(function(aluno, index) {
                    var row = '<tr><td>' + aluno.user + '</td><td>' + aluno.nome + '</td>';
                    row += '<td><button type="button" class="btn btn-danger" onclick="removerAluno(' + index + ')">Remover</button></td></tr>';
                    $("#alunosAdicionadosTable").append(row);
                });

                // Atualiza o campo hidden com os alunos selecionados em JSON
                $("#alunosSelecionadosJSON").val(JSON.stringify(alunosSelecionados));
            }
        });


        function carregarInformacoesAluno() {
            const alunoSelect = document.getElementById('aluno');
            const userField = document.getElementById('user');

            if (alunoSelect.value !== '') {
                $.ajax({
                    type: 'POST',
                    url: 'obterDadosDoAluno.php',
                    data: { user: alunoSelect.value },
                    success: function (data) {
                        const responseData = JSON.parse(data);
                        const alunoData = responseData.aluno;
                        const irmaosData = responseData.irmaos;

                        document.getElementById('irmaos').value = alunoData.irmaos;
                        document.getElementById('mem_bs').value = alunoData.mem_bs;

                        if (alunoData.desc_irmaos == 1) {
                            document.getElementById('desconto1').checked = true;
                        } else if (alunoData.desc_irmaos == 2) {
                            document.getElementById('desconto2').checked = true;
                        } else if (alunoData.desc_irmaos == 0) {
                            document.getElementById('desconto3').checked = true;
                        }

                        const alunosSelecionados = [];
                        if (irmaosData.length > 0) {
                            const tableBody = document.getElementById('alunosAdicionadosTable');
                            tableBody.innerHTML = ''; // Clear existing rows
                            irmaosData.forEach((irmao, index) => {
                                const row = `<tr>
                                    <td>${irmao.user_1_irmao}</td>
                                    <td>${irmao.nome}</td>
                                    <td><button type="button" class="btn btn-danger" onclick="removerAluno(${index})">Remover</button></td>
                                </tr>`;
                                tableBody.insertAdjacentHTML('beforeend', row);
                                alunosSelecionados.push({ user: irmao.user_1_irmao, nome: irmao.nome });
                            });
                            document.getElementById('user_irmaos').style.display = 'block';
                        }

                        document.getElementById('formulario').style.display = 'block';

                        // Atualize o campo escondido com a array de alunos selecionados
                        document.getElementById('alunosSelecionadosJSON').value = JSON.stringify(alunosSelecionados);
                    },
                    error: function () {
                        alert('Erro ao carregar as informações do aluno.');
                    }
                });
            }
        }



        function selecionarDesconto(selectedCheckbox) {
            const checkboxes = document.getElementsByName('desc_irmaos');
            checkboxes.forEach(checkbox => {
                if (checkbox !== selectedCheckbox) {
                    checkbox.checked = false;
                }
            });
        }

    </script>
</body>

<?php
include "footer-reservado.php";
?>

</html>
