<?php
session_start();
ini_set('display_errors', 0);
include "./generals/config.php";
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

function obterSocio($conexao, $numSocio)
{
    $query = "SELECT nome, morada1, morada2, nif FROM socios WHERE num_socio = $numSocio";
    $resultado = mysqli_query($conexao, $query);
    return mysqli_fetch_assoc($resultado);
}

function atualizarSocio($conexao, $numSocio, $nome, $morada1, $morada2, $nif)
{
    $query = "UPDATE socios SET nome = '$nome', morada1 = '$morada1', morada2 = '$morada2', nif = $nif WHERE num_socio = $numSocio";
    if (mysqli_query($conexao, $query)) {
        return "Informações do sócio atualizadas com sucesso.";
    } else {
        return "Erro ao atualizar informações do sócio: " . mysqli_error($conexao);
    }
}

$search = '';

if (isset($_POST['search'])) {
    $search = $_POST['search'];
}

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['submit'])) {
    $selectedSocio = $_POST['socio'];
    $socioInfo = obterSocio($mysqli, $selectedSocio);
}

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['salvar'])) {
    $selectedSocio = $_POST['num_socio'];

    // Recupera os novos valores do formulário
    $nome = $_POST['nome'];
    $morada1 = $_POST['morada1'];
    $morada2 = $_POST['morada2'];
    $nif = $_POST['nif'];

    // Atualiza as informações do sócio no banco de dados
    $resultadoAtualizacao = atualizarSocio($mysqli, $selectedSocio, $nome, $morada1, $morada2, $nif);
    if (strpos($resultadoAtualizacao, "sucesso") !== false) {
        $successMessage = $resultadoAtualizacao;
    } else {
        $errorMessage = $resultadoAtualizacao;
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Editar Informações de Sócio</title>
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
    <h2 class="mt-5 text-center">Editar Informações de Sócio</h2>
    <form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="post" class="mb-3">
        <div class="input-group">
            <input type="text" class="form-control" placeholder="Pesquisar sócio por nome" name="search" value="<?php echo $search; ?>">
            <button style="background-color: #00631b; border-color: black;" class="btn btn-primary" type="submit">Pesquisar</button>
        </div>
    </form>

    <h3>Selecione um sócio para editar suas informações:</h3>
    <form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="post">
        <div class="mb-3">
            <select id="socio" name="socio" class="form-select" required>
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

        <button style="background-color: #00631b; border-color: black;" type="submit" name="submit" class="btn btn-primary">Selecionar Sócio</button>
    </form>

    <?php if (!empty($socioInfo)) : ?>
        <h3>Editar Informações de <?php echo $socioInfo['nome']; ?>:</h3>
        <form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="post">
            <input type="hidden" name="num_socio" value="<?php echo $selectedSocio; ?>">
            <div class="mb-3">
                <label for="nome" class="form-label">Nome:</label>
                <input type="text" id="nome" name="nome" class="form-control" value="<?php echo isset($socioInfo['nome']) ? $socioInfo['nome'] : ''; ?>" required>
            </div>

            <div class="mb-3">
                <label for="morada1" class="form-label">Morada:</label>
                <input type="text" id="morada1" name="morada1" class="form-control" value="<?php echo isset($socioInfo['morada1']) ? $socioInfo['morada1'] : ''; ?>" required>
            </div>

            <div class="mb-3">
                <label for="morada2" class="form-label">Morada (Continuação):</label>
                <input type="text" id="morada2" name="morada2" class="form-control" value="<?php echo isset($socioInfo['morada2']) ? $socioInfo['morada2'] : ''; ?>" required>
            </div>

            <div class="mb-3">
                <label for="nif" class="form-label">NIF:</label>
                <input type="number" id="nif" name="nif" class="form-control" value="<?php echo isset($socioInfo['nif']) ? $socioInfo['nif'] : ''; ?>" required min="0">
            </div>

            <button style="background-color: #00631b; border-color: black;" type="submit" name="salvar" class="btn btn-primary">Salvar Alterações</button>
        </form>
    <?php endif; ?>

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
