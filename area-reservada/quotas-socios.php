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

$socios = array(); // Initialize the $socios variable as an empty array

// Code to retrieve socios from the database
$query = "SELECT num_socio, nome FROM socios";

if (isset($_GET['search'])) {
    $search = $_GET['search'];
    $query .= " WHERE nome LIKE '%$search%'";
}

$resultado = $mysqli->query($query);

if ($resultado) {
    // Loop to iterate through the results and add the socios to the $socios array
    while ($row = $resultado->fetch_assoc()) {
        $socios[] = $row;
    }
} else {
    // In case there is an error in the query, display an error message or handle it appropriately
    echo "Erro na consulta: " . $mysqli->error;
}

$selectedSocio = '';
$numQuotas = 1; // Initialize the number of quotas with a default value

if (isset($_POST['socio'])) {
    $selectedSocio = $_POST['socio'];

    // Get the details of the selected socio
    $query = "SELECT nome, morada1, morada2, nif FROM socios WHERE num_socio='$selectedSocio'";
    $result = $mysqli->query($query);

    if ($result) {
        $row = $result->fetch_assoc(); // Get the socio details
        if ($row) {
            $nome = $row['nome'];
            $morada1 = $row['morada1'];
            $morada2 = $row['morada2'];
            $nif = $row['nif'];
            $hoje = date('Y-m-d');
            $query = "UPDATE socios 
                        SET quota = 1, data_pagamento = '$hoje'
                        WHERE num_socio = '$selectedSocio'";
            $result = $mysqli->query($query);
        } else {
            echo "O sócio selecionado não tem informações definidas.";
        }
    } else {
        echo "Erro na consulta: " . $mysqli->error;
    }
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>GMEA - Gerar Faturas de Quotas</title>
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
    <h2>Gerar Faturas de Quotas</h2>
    <div class="mb-3">
        <form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="get" class="mb-3">
            <div class="input-group">
                <input type="text" class="form-control" placeholder="Pesquisar sócio por nome" name="search">
                <button style="background-color: #00631b; border-color: black;" class="btn btn-primary" type="submit">Pesquisar</button>
            </div>
        </form>
        <h3>Selecione um sócio:</h3>
        <div class="mb-3">
            <form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="post">
                <select id="socio" name="socio" class="form-select" required>
                    <option value="">Selecione um sócio</option>
                    <?php foreach ($socios as $socio): ?>
                        <option value="<?php echo $socio['num_socio']; ?>" data-nome="<?php echo $socio['nome']; ?>">
                            <?php echo $socio['num_socio'] . ' - ' . $socio['nome']; ?>
                        </option>
                    <?php endforeach; ?>
                </select>
                <br>
                <button style="background-color: #00631b; border-color: black;" class="btn btn-primary" type="submit">Selecionar</button>
            </form>
        </div>
    </div>
    <?php if (!empty($selectedSocio)): ?>
        <div id="formulario">
            <h3>Formulário de Faturas de Quotas</h3>
            <form action="generals/pdf-quotas-socios.php" method="post">
                <input type="hidden" name="socio" value="<?php echo $selectedSocio; ?>">
                <div class="mb-3">
                    <label for="num_quotas" class="form-label">Número de Quotas:</label>
                    <input type="number" name="num_quotas" id="num_quotas" class="form-control" value="<?php echo $numQuotas; ?>" required>
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
                    <label for="quota_base" class="form-label">Quota Base:</label>
                    <input type="text" name="quota_base" id="quota_base" class="form-control" readonly value="12€">
                </div>
                <div class="mb-3">
                    <label for="obs" class="form-label">Observações:</label>
                    <textarea name="obs" id="obs" class="form-control"></textarea>
                </div>
                <button style="background-color: #00631b; border-color: black;" class="btn btn-primary" type="submit" name="submit">Gerar Faturas</button>
            </form>
        </div>
    <?php endif; ?>
</div>

<?php
include "footer-reservado.php";
?>

<script>
    // JavaScript code to show/hide the form
    const socioSelect = document.getElementById('socio');
    const formulario = document.getElementById('formulario');

    socioSelect.addEventListener('change', function() {
        if (socioSelect.value === '') {
            formulario.style.display = 'none';
        } else {
            formulario.style.display = 'block';
        }
    });
</script>

</body>
</html>