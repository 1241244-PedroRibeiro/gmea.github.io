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

$user = ''; // Initialize the $user variable

if (isset($_POST['aluno'])) {
    $user = $_POST['aluno'];

    $query = "SELECT regime, tipo_regime, dur1, dur2, cod_fm, cod_orq, cod_coro, in_alg, irmaos, mem_bs, num_fatura FROM alunos WHERE user='$user'";
    $result = $mysqli->query($query);

    if ($result) {
        $row = $result->fetch_assoc(); // Obtém a primeira linha do resultado
        if ($row) {
            $regime = $row['regime'];
            $tipo_regime = $row['tipo_regime'];
            $dur1 = $row['dur1'];
            $dur2 = $row['dur2'];
            $cod_fm = $row['cod_fm'];
            $cod_orq = $row['cod_orq'];
            $cod_coro = $row['cod_coro'];
            $in_alg = $row['in_alg'];
            $irmaos = $row['irmaos'];
            $mem_bs = $row['mem_bs'];
            $num_fatura = $row['num_fatura'];
        } else {
            echo "O $user ainda não tem informações definidas.";
        }
    } else {
        echo "Erro na consulta: " . $mysqli->error;
    }

    $query = "SELECT nome, morada1, morada2, nif, email FROM users1 WHERE user='$user'";
    $result = $mysqli->query($query);

    if ($result) {
        $row = $result->fetch_assoc(); // Obtém a primeira linha do resultado
        if ($row) {
            $nome = $row['nome'];
            $morada1 = $row['morada1'];
            $morada2 = $row['morada2'];
            $nif = $row['nif'];
            $email = $row['email'];
        } else {
            echo "O $user ainda não tem informações definidas.";
        }
    } else {
        echo "Erro na consulta: " . $mysqli->error;
    }
    
    $propina = 0; // Initialize the $propina variable

    if ($regime == 1) {
        // Add your code for regime 1 here
    }
    else if ($regime == 2) {
        if ($tipo_regime == 1) {
            $propina = 60;
            if ($mem_bs == 1) {
                $propina = $propina * 0.8575;
            }
            if ($irmaos == 1) {
                $propina = $propina - 3;
            }
        }
        else if ($tipo_regime == 2) {
            // Add your code for regime 2 and tipo_regime 2 here
        }
    }
    else if ($regime == 3) {
        if ($tipo_regime == 1) {
            $propina = 60;
            if ($irmaos == 1) {
                $propina = $propina * 0.8575;
            }
            if ($mem_bs == 1) {
                $propina = $propina - 3;
            }
        }
    }

    if (isset($_POST['tipo_mes'])) {
        if ($_POST['tipo_mes'] == 2) {
            $propina = $propina * 0.5;
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
include "header-direcao.php";
?>

<div class="container">
    <h2>Gerar Faturas - Mensalidades dos Alunos <?php echo (isset($_POST['aluno'])) ? '(' . $user . ' - ' . $nome . ')' : ''; ?></h2>
    <div class="mb-3" id="formini">
        <form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="get" class="mb-3">
            <div class="input-group">
                <input type="text" class="form-control" placeholder="Pesquisar aluno por nome" name="search">
                <button style="background-color: #00631b; border-color: black;" class="btn btn-primary" type="submit">Pesquisar</button>
            </div>
        </form>
        <h3>Selecione um aluno:</h3>
        <div class="mb-3">
            <form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="post">
                <select id="aluno" name="aluno" class="form-select" required>
                    <option value="">Selecione um aluno</option>
                    <?php foreach ($alunos as $aluno): ?>
                        <option value="<?php echo $aluno['user']; ?>" data-user="<?php echo $aluno['user']; ?>">
                            <?php echo $aluno['user'] . ' - ' . $aluno['nome']; ?>
                        </option>
                    <?php endforeach; ?>
                </select>
                <br>
                <button style="background-color: #00631b; border-color: black;" class="btn btn-primary" type="submit">Selecionar</button>
            </form>
        </div>
    </div>
    <?php if (!empty($user)): ?>
    <div id="formulario">
        <h3>Formulário de Dados do Aluno</h3>
        <form action="./generals/generate-pdf.php" method="post">
            <input type="hidden" name="user" id="user" value="<?php echo $user; ?>">
            <input type="hidden" name="nome" id="nome" value="">
            <div class="mb-3">
                <label for="tipo_mes" class="form-label">Tipo Mês</label>
                <select name="tipo_mes" id="tipo_mes" class="form-select" required>
                    <option value="0">Selecione o tipo de mês</option>
                    <option value="1">Mês Completo</option>
                    <option value="2">Meio mês</option>
                </select>
            </div>
            <div class="mb-3">
                <label for="nome" class="form-label">Nome:</label>
                <input type="text" name="nome" id="nome" class="form-control" readonly value="<?php echo $nome; ?>">
            </div>
            <div class="mb-3">
                <label for="morada1" class="form-label">Morada:</label>
                <input type="text" name="morada1" id="morada1" class="form-control" readonly value="<?php echo $morada1; ?>">
            </div>
            <div class="mb-3">
                <label for="morada2" class="form-label">Morada (Continuação):</label>
                <input type="text" name="morada2" id="morada2" class="form-control" readonly value="<?php echo $morada2; ?>">
            </div>
            <div class="mb-3">
                <label for="nif" class="form-label">NIF:</label>
                <input type="text" name="nif" id="nif" class="form-control" readonly value="<?php echo $nif; ?>">
            </div>
            <div class="mb-3">
                <label for="email" class="form-label">E-mail:</label>
                <input type="text" name="email" id="email" class="form-control" readonly value="<?php echo $email; ?>">
            </div>
            <div class="mb-3">
                <label for="propina" class="form-label">Valor da propina:</label>
                <input type="text" name="propina" id="propina" class="form-control" readonly value="<?php echo $propina; ?>">
            </div>
            <div class="mb-3">
                <label for="obs" class="form-label">Observações:</label>
                <input type="text" name="obs" id="obs" class="form-control">
            </div>
            <input type="hidden" name="num_fatura" value="<?php echo $num_fatura; ?>">
            <div class="mb-3">
                <button style="background-color: #00631b; border-color: black;" class="btn btn-primary" id="atualizar-formulario">Atualizar Formulário</button>
                <button style="background-color: #00631b; border-color: black;" class="btn btn-primary" type="submit">Gerar Fatura</button>
            </div>
        </form>
    </div>
    <?php endif; ?>
</div>

<?php
include "footer-reservado.php";
?>

<script>
    const alunoSelect = document.getElementById('aluno');
    const formulario = document.getElementById('formulario');
    const tipoMesSelect = document.getElementById('tipo_mes');
    const propinaInput = document.getElementById('propina');
    const atualizarFormularioButton = document.getElementById('atualizar-formulario');

    alunoSelect.addEventListener('change', function() {
        if (alunoSelect.value === '') {
            formulario.style.display = 'none';
        } else {
            formulario.style.display = 'block';
        }
    });

    atualizarFormularioButton.addEventListener('click', function() {
        if (tipoMesSelect.value === '0') {
            propinaInput.value = 'Selecione primeiro o tipo de mês';
        } else if (tipoMesSelect.value === '1') {
            // Calculate propina for Mês Completo
            let propina = 60;
            if (irmaos === 1) {
                propina = propina * 0.8575;
            }
            if (mem_bs === 1) {
                propina = propina - 3;
            }
            propinaInput.value = propina + '€';
        } else if (tipoMesSelect.value === '2') {
            // Calculate propina for Meio mês
            let propina = 60;
            if (irmaos === 1) {
                propina = propina * 0.8575;
            }
            if (mem_bs === 1) {
                propina = propina - 3;
            }
            propina = propina / 2;
            propinaInput.value = propina + '€';
        }
    });
</script>


</body>
</html>