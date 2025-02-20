<?php
error_reporting(0);
session_start();
require_once("generals/config.php");

$mysqli = new mysqli($bd_host, $bd_user, $bd_password, $bd_database);

if ($mysqli->connect_error) {
    die('Erro: (' . $mysqli->connect_errno . ') ' . $mysqli->connect_error);
}

if (empty($_SESSION["session_id"]) && empty($_POST["login"]) && empty($_POST["user"]) && empty($_POST["password"])) {
    header("Location: ../index.php");
    exit;
}

$user = $_SESSION["username"];
$obs = '';

// Obter todos os meses disponíveis para seleção
$queryMeses = "SELECT id_mes, nome_mes FROM meses";
$resultMeses = $mysqli->query($queryMeses);

$meses = [];
if ($resultMeses) {
    while ($rowMes = $resultMeses->fetch_assoc()) {
        $meses[$rowMes['id_mes']] = $rowMes['nome_mes'];
    }
} else {
    echo "Erro na consulta dos meses: " . $mysqli->error;
}

if (isset($_POST['mes'])) {
    $mes = $_POST['mes'];

    // Verificar se a mensalidade já foi paga para este mês
    $queryVerificarPagamento = "SELECT * FROM mensalidades_alunos WHERE user = '$user' AND id_mes = '$mes'";
    $resultVerificarPagamento = $mysqli->query($queryVerificarPagamento);

    $pagamentoRealizado = false;
    if ($resultVerificarPagamento && $resultVerificarPagamento->num_rows > 0) {
        $pagamentoRealizado = true;
    }
}

$query = "SELECT regime, tipo_regime, dur1, dur2, cod_fm, cod_orq, cod_coro, desc_irmaos, mem_bs, num_fatura FROM alunos WHERE user='$user'";
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
        $desc_irmaos = $row['desc_irmaos'];
        $mem_bs = $row['mem_bs'];
        $num_fatura = $row['num_fatura'];
    } else {
        echo "O $user ainda não tem informações definidas.";
    }
} else {
    echo "Erro na consulta: " . $mysqli->error;
}

$query = "SELECT nome, morada1, morada2, nif, email FROM users1 WHERE user='$user' and estado=1";
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



if ($tipo_regime == 1) {
    if ($dur1 == 20) {
        $propina = 40;
    } else if ($dur1 == 30) {
        $propina = 50;
    } else if ($dur1 == 50) {
        $propina = 60;
    }

    if ($dur2 == 20) {
        $propina += 40;
    } else if ($dur2 == 30) {
        $propina += 50;
    } else if ($dur2 == 50) {
        $propina += 60;
    }

    if ($mem_bs == 1) {
        $propina = $propina - 3;
    }

    if ($desc_irmaos == 1) {
        $propina = $propina * .85;
    } else if ($desc_irmaos == 2) {
        $propina = $propina * .90;
    }

    if ($mem_bs != 1) {
        $query = "SELECT codigo FROM instrumentos WHERE user = '$user'";
        $result = $mysqli->query($query);

        if ($result && $result->num_rows > 0) {
            $row = $result->fetch_assoc();
            $propina = $propina + 5;
        }
    }

    $valor = $propina;

    if ($mes == 1) {
        $valor = $valor / 2;
        $obs = 'Em setembro apenas se realizou meio mês de aulas.';
    }

    $propina = $valor . '€';
}

if ($tipo_regime == 2) {
    if ($dur1 == 20) {
        $propina = 40;
    } else if ($dur1 == 30) {
        $propina = 50;
    } else if ($dur1 == 50) {
        $propina = 65;
    }

    if ($dur2 == 20) {
        $propina += 40;
    } else if ($dur2 == 30) {
        $propina += 50;
    } else if ($dur2 == 50) {
        $propina += 65;
    }

    if ($cod_fm != 0) {
        $propina += 40;
    }

    if ($mem_bs == 1) {
        $propina = $propina - 3;
    }

    if ($desc_irmaos == 1) {
        $propina = $propina * .85;
    } else if ($desc_irmaos == 2) {
        $propina = $propina * .90;
    }

    if ($mem_bs != 1) {
        $query = "SELECT codigo FROM instrumentos WHERE user = '$user'";
        $result = $mysqli->query($query);

        if ($result && $result->num_rows > 0) {
            $row = $result->fetch_assoc();
            $propina = $propina + 5;
        }
    }

    $valor = $propina;

    if ($mes == 1) {
        $valor = $valor / 2;
        $obs = 'Em setembro apenas se realizou meio mês de aulas.';
    }

    $propina = $valor . '€';
}

if (isset($mes)) {
    // Obter todos os meses disponíveis para seleção
    $queryMeses = "SELECT nome_mes FROM meses WHERE id_mes = '$mes'";
    $resultMeses = $mysqli->query($queryMeses);

    if ($resultMeses) {
        while ($rowMes = $resultMeses->fetch_assoc()) {
            $nomemesselecionado = $rowMes['nome_mes'];
        }
    } else {
        echo "Erro na consulta dos meses: " . $mysqli->error;
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
    <script src="https://www.paypal.com/sdk/js?client-id=AXRyMsLxnyB52QnwyfG7xNIFbvazOZ6Gg4s4W4wbBp_GZuUrwqBiPfAxu6ZgtC4eJa2PAhs0tUxyAqNr&currency=EUR"></script>

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

        .estado-pagamento {
            font-size: smaller;
            padding: 0.2rem 0.5rem;
            display: inline-block;
        }

        /* Estilo adicional para alinhar à direita */
        .paypal-container {
            display: flex;
            justify-content: flex-end;
        }

        /* Estilo para aumentar o contêiner dos botões PayPal */
        #paypal-button-container {
            width: 100%; /* Defina a largura conforme necessário */
            text-align: center; /* Centralize os botões */
        }

        /* Estilo para ajustar o tamanho dos botões do PayPal */
        .paypal-button {
            min-width: 200px; /* Defina a largura mínima dos botões */
            padding: 15px 20px; /* Ajuste o preenchimento interno dos botões */
            font-size: 16px; /* Ajuste o tamanho da fonte dos botões */
        }
    </style>
</head>

<body>
    <div style="margin-top: 0;">
        <img style="width: 100%; height: auto;" src="./media/topAR.png" class="img-responsive">
    </div>

    <?php
    include "header-alunos.php";
    ?>

    <div class="container">
        <div class="row">
            <div class="col-sm">
                <form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="post">
                    <div class="mb-3">
                        <label for="mes" class="form-label">Selecione o mês:</label>
                        <select name="mes" id="mes" class="form-select" required>
                            <option value="">Selecione um mês</option>
                            <?php foreach ($meses as $id => $nomemes): ?>
                                <option value="<?php echo $id; ?>"><?php echo $nomemes; ?></option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                    <button type="submit" class="btn btn-primary">Selecionar</button>
                </form>
            </div>
        </div>
        <br>

        <div class="row">

        <?php if (!empty($user)): ?>
            <div hidden id="formulario">
                <h3>Formulário de Dados do Aluno</h3>
                <form action="./generals/pdf-mensalidades-alunos-consulta.php" method="post">
                    <input type="hidden" name="user" id="user" value="<?php echo $user; ?>">
                    <input type="hidden" name="nome" id="nome" value="">
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
                        <label for="propina" class="form-label">Valor base da propina:</label>
                        <input type="text" name="propina" id="propina" class="form-control" readonly value="<?php echo $propina; ?>">
                        <input type="hidden" name="meiapropina" value="<?php echo number_format((str_replace("€", "", $propina) / 2), 2); ?>">
                    </div>
                    <div class="mb-3">
                        <label for="obs" class="form-label">Observações:</label>
                        <input type="text" name="obs" id="obs" value="<?php echo isset($obs) ? $obs : ''; ?>" class="form-control">
                        <input type="hidden" name="mes" value="<?php echo $mes; ?>">
                    </div>
            </div>
        <?php endif; ?>

        <br><br>
        <div class="row">
            <?php if (isset($_POST['mes']) && isset($mes)): ?>
                <div class="col-sm mb-3">
                    <?php if ($pagamentoRealizado): ?>
                        <div class="alert alert-success estado-pagamento" role="alert">
                            PAGO
                        </div><br>
                        <input type="hidden" name="num_fatura" value="<?php echo $num_fatura; ?>">
                        <button class="btn btn-primary" type="submit">Fazer download da fatura (<?php print($nomemesselecionado); ?>)</button>
                    <?php else: ?>
                        <div class="alert alert-danger estado-pagamento" role="alert">
                            NÃO PAGO
                        </div><br>
                        <input type="hidden" name="num_fatura" value="<?php echo $num_fatura; ?>">
                        <button class="btn btn-primary" type="submit">Fazer download da fatura (<?php print($nomemesselecionado); ?>)</button>
                    <?php endif; ?>
                </div>

                <?php if (!$pagamentoRealizado): ?>
                    <div class="col-sm mb-3 paypal-container">
                        <div id="paypal-button-container"></div>
                    </div>
                <?php endif; ?>
            <?php endif; ?>
        </div>
    </div>

    <script>
        var paypalContainer = document.querySelector('.paypal-container');
        paypal.Buttons({
            createOrder: function (data, actions) {
                // Set up the transaction details
                return actions.order.create({
                    purchase_units: [{
                        amount: {
                            value: <?php echo json_encode(0.01); ?> // Set the value dynamically from your PHP variable
                        }
                    }]
                });
            },
            onApprove: function (data, actions) {
                // Capture the funds from the transaction
                return actions.order.capture().then(function (details) {
                    // Insert logic to handle a successful payment

                    // Use AJAX to update payment status on the server
                    $.ajax({
                        type: 'POST',
                        url: 'atualizar_pagamento.php',
                        data: { user: "<?php echo $user; ?>", mes: "<?php echo $mes; ?>" },
                        success: function(response) {
                            console.log('Resposta do servidor: ' + response);

                            // Atualize dinamicamente a etiqueta PAGO/NÃO PAGO
                            $(".estado-pagamento").text("PAGO").removeClass("alert-danger").addClass("alert-success");
                            paypalContainer.style.display = 'none';
                        },
                        error: function(error) {
                            console.error('Erro na requisição AJAX: ' + error.responseText);
                        }
                    });
                });
            }
        }).render('#paypal-button-container');
    </script>
    </div>

    <?php
    include "footer-reservado.php";
    ?>
</body>

</html>
