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

$socios = array();

// Retrieve socios from the database
$query = "SELECT num_socio, nome FROM socios";

if (isset($_GET['search'])) {
    $search = $mysqli->real_escape_string($_GET['search']);
    $query .= " WHERE nome LIKE '%$search%'";
}

$resultado = $mysqli->query($query);

if ($resultado) {
    while ($row = $resultado->fetch_assoc()) {
        $socios[] = $row;
    }
} else {
    echo "Erro na consulta: " . $mysqli->error;
}

$selectedSocio = '';
$selectedAno = '';
$years = array();
$paymentStatus = 'unpaid';

if (isset($_POST['socio'])) {
    $selectedSocio = $mysqli->real_escape_string($_POST['socio']);
    $selectedAno = $mysqli->real_escape_string($_POST['year']);

    // Get the details of the selected socio
    $query = "SELECT nome, morada1, morada2, nif, DATE_FORMAT(data_added, '%Y') as ano_adicionado FROM socios WHERE num_socio='$selectedSocio'";
    $result = $mysqli->query($query);

    if ($result) {
        $row = $result->fetch_assoc();
        if ($row) {
            $nome = $row['nome'];
            $morada1 = $row['morada1'];
            $morada2 = $row['morada2'];
            $nif = $row['nif'];
            $ano_adicionado = $row['ano_adicionado'];
            $ano_atual = date('Y');

            // Generate years array from year added to current year
            for ($year = $ano_adicionado; $year <= $ano_atual; $year++) {
                $years[] = $year;
            }

            // Check payment status for the selected year
            $queryPayment = "SELECT * FROM quotas_socios WHERE num_socio='$selectedSocio' AND ano='$selectedAno'";
            $resultPayment = $mysqli->query($queryPayment);

            if ($resultPayment && $resultPayment->num_rows > 0) {
                $paymentStatus = 'paid';
            }
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
        if ($_SESSION["type"] == 3) { // Mostrar cabeçalho para professores
            include "header-direcao.php"; 
        } 
        if ($_SESSION["type"] == 4) { // Mostrar cabeçalho para professores
            include "header-professor-direcao.php";
        } 

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
                <select id="socio" name="socio" class="form-select" required onchange="fetchYears(this.value)">
                    <option value="">Selecione um sócio</option>
                    <?php foreach ($socios as $socio): ?>
                        <option value="<?php echo $socio['num_socio']; ?>" data-nome="<?php echo $socio['nome']; ?>">
                            <?php echo $socio['num_socio'] . ' - ' . $socio['nome']; ?>
                        </option>
                    <?php endforeach; ?>
                </select>
                <br>
                <div id="yearSection" style="display: none;">
                    <label for="year" class="form-label">Selecione o Ano:</label>
                    <select id="year" name="year" class="form-select" required onchange="checkPaymentStatus(this.value)">
                        <option value="">Selecione um ano</option>
                        <?php foreach ($years as $year): ?>
                            <option value="<?php echo $year; ?>"><?php echo $year; ?></option>
                        <?php endforeach; ?>
                    </select>
                </div>
                <br>
                <button style="background-color: #00631b; border-color: black;" class="btn btn-primary" type="submit">Selecionar</button>
            </form>
        </div>
    </div>
    <?php if (!empty($selectedSocio)): ?>
        <div id="formulario">
            <h3>Formulário de Faturas de Quotas</h3>
            <form id="generateInvoiceForm" action="generals/pdf-quotas-socios.php" method="post">
                <input type="hidden" name="socio" value="<?php echo $selectedSocio; ?>">
                <input type="hidden" name="ano" value="<?php echo $selectedAno; ?>">
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
                <button id="generateInvoiceButton" style="background-color: #00631b; border-color: black;" class="btn btn-primary" type="button">Gerar Fatura</button>
            </form>
            <br>
            <form id="confirmPaymentForm" method="post">
                <input type="hidden" name="socio" value="<?php echo $selectedSocio; ?>">
                <input type="hidden" name="year" value="<?php echo $selectedAno; ?>">
                <button id="confirmPaymentButton" style="background-color: <?php echo $paymentStatus == 'paid' ? 'gray' : '#428bca'; ?>; border-color: black;" class="btn btn-primary" type="button" <?php echo $paymentStatus == 'paid' ? 'disabled' : ''; ?>>
                    Confirmar pagamento
                </button>
                <span id="paymentMessage" class="text-danger" style="display: <?php echo $paymentStatus == 'paid' ? 'block' : 'none'; ?>;">O pagamento desta quota já foi realizado.</span>
            </form>
        </div>
    <?php endif; ?>
</div>

<?php
include "footer-reservado.php";
?>

<script>
function fetchYears(numSocio) {
    if (numSocio === '') {
        document.getElementById('yearSection').style.display = 'none';
        return;
    }

    $.ajax({
        url: 'fetch_years.php',
        method: 'POST',
        data: { num_socio: numSocio },
        success: function(response) {
            $('#year').html(response);
            document.getElementById('yearSection').style.display = 'block';
        }
    });
}


document.getElementById('generateInvoiceButton').addEventListener('click', function() {
    document.getElementById('generateInvoiceForm').submit();
});

document.getElementById('confirmPaymentButton').addEventListener('click', function() {
    const numSocio = document.querySelector('#confirmPaymentForm input[name="socio"]').value;
    const year = document.querySelector('#confirmPaymentForm input[name="year"]').value;

    if (numSocio === '' || year === '') {
        alert('Selecione um sócio e um ano primeiro.');
        return;
    }

    $.ajax({
        url: 'confirm_payment.php',
        method: 'POST',
        data: { num_socio: numSocio, year: year },
        success: function(response) {
            if (response === 'success') {
                document.getElementById('confirmPaymentButton').disabled = true;
                document.getElementById('confirmPaymentButton').style.backgroundColor = 'gray';
                document.getElementById('paymentMessage').style.display = 'block';
                // Submeter o formulário para gerar a fatura após a confirmação do pagamento
                document.getElementById('generateInvoiceForm').submit();
            } else {
                alert('Erro ao confirmar pagamento: ' + response);
            }
        }
    });
});
</script>

</body>
</html>
