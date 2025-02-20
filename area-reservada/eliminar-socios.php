<?php
session_start();
include "./generals/config.php";
ini_set('display_errors', 0);
$mysqli = new mysqli($bd_host, $bd_user, $bd_password, $bd_database);

$successMessage = $errorMessage = $warningMessage = '';

if ($mysqli->connect_error) {
    die('Erro: (' . $mysqli->connect_errno . ') ' . $mysqli->connect_error);
}
if (empty($_SESSION["session_id"]) && empty($_POST["login"]) && empty($_POST["user"]) && empty($_POST["password"]) || $_SESSION["type"] < 3) {
    header("Location: ../index.php");
    exit;
}

// Verifique se o formulário foi enviado
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Obtenha os valores enviados pelo formulário
    $acao = $_POST["acao"];

    // Redireciona para a página correspondente
    if ($acao === 'adicionar') {
        header("Location: adicionar-socio.php");
        exit;
    } elseif ($acao === 'editar') {
        header("Location: editar-socio.php");
        exit;
    } elseif ($acao === 'eliminar') {
        header("Location: eliminar-socios.php");
        exit;
    }
}

function decrementarNumerosSocio($conexao, $numSocioSelecionado)
{
    $query = "UPDATE socios SET num_socio = num_socio - 1 WHERE num_socio > $numSocioSelecionado";
    if (mysqli_query($conexao, $query)) {
        return "Números de sócio atualizados com sucesso.";
    } else {
        return "Erro ao decrementar números de sócio: " . mysqli_error($conexao);
    }
}

if (isset($_POST['submit']) && isset($_POST['socio'])) {
    $socioSelecionado = $_POST['socio'];

    // Obtenha o número de sócio do sócio selecionado (substitua com sua própria consulta)
    $queryNumeroSocio = "SELECT num_socio FROM socios WHERE num_socio = $socioSelecionado";
    $resultadoNumeroSocio = mysqli_query($mysqli, $queryNumeroSocio);
    $rowNumeroSocio = mysqli_fetch_assoc($resultadoNumeroSocio);
    $numSocioSelecionado = $rowNumeroSocio['num_socio'];

    // Exclua o sócio selecionado (substitua com sua própria consulta)
    $queryExcluirSocio = "DELETE FROM socios WHERE num_socio = $socioSelecionado";
    if (mysqli_query($mysqli, $queryExcluirSocio)) {
        $successMessage = "Sócio excluído com sucesso.";
        // Agora, decremente os números de sócio de outros sócios
        $warningMessage = decrementarNumerosSocio($mysqli, $numSocioSelecionado);
    } else {
        $errorMessage = "Erro ao excluir sócio: " . mysqli_error($mysqli);
    }
}

$search = '';

if (isset($_POST['search'])) {
    $search = $_POST['search'];
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Eliminar Sócio</title>
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

<div class="mb-3 container">
        <form action="" method="POST">
            <div class="mb-3">
                <label for="acao" class="form-label">Selecione uma ação:</label>
                <select name="acao" id="acao" class="form-select">
                    <option value="">Selecione</option>
                    <option value="adicionar">Adicionar Sócio</option>
                    <option value="editar">Editar Sócio</option>
                    <option value="eliminar">Eliminar Sócio</option>
                </select>
            </div>
            <button type="submit" class="btn btn-primary">Ir</button>
        </form>
    </div>

<div class="container">
    <h2 class="mt-5 text-center">Eliminar Sócio</h2>
    <form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="post" class="mb-3">
        <div class="input-group">
            <input type="text" class="form-control" placeholder="Pesquisar sócio por nome" name="search" value="<?php echo $search; ?>">
            <button style="background-color: #00631b; border-color: black;" class="btn btn-primary" type="submit">Pesquisar</button>
        </div>
    </form>

    <h3>Selecione um sócio para eliminar:</h3>
    <form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="post">
        <div class="mb-3">
            <select id="aluno" name="socio" class="form-select" required>
                <option value="">Selecione um sócio</option>
                <?php
                // Substitua com sua própria consulta para listar os sócios
                $queryListarSocios = "SELECT num_socio, nome FROM socios WHERE nome LIKE '%$search%'";
                $resultadoListarSocios = mysqli_query($mysqli, $queryListarSocios);
                while ($row = mysqli_fetch_assoc($resultadoListarSocios)) {
                    echo '<option value="' . $row['num_socio'] . '">' . $row['nome'] . '</option>';
                }
                ?>
            </select>
        </div>

        <button style="background-color: #ff0000; border-color: black;" type="submit" name="submit" class="btn btn-danger">Eliminar Sócio</button>
    </form>

    <br>

    <?php
    if (!empty($successMessage)) {
        echo '<div class="alert alert-success" role="alert">' . $successMessage . '</div>';
    }
    if (!empty($errorMessage)) {
        echo '<div class="alert alert-danger" role="alert">' . $errorMessage . '</div>';
    }
    if (!empty($warningMessage)) {
        echo '<div class="alert alert-warning" role="alert">' . $warningMessage . '</div>';
    }
    ?>


</div>
</body>

</html>

<?php
include "footer-reservado.php";
?>