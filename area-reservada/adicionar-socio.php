<?php
session_start();
include "./generals/config.php";
$mysqli = new mysqli($bd_host, $bd_user, $bd_password, $bd_database);

if ($mysqli->connect_error) {
    die('Erro: (' . $mysqli->connect_errno . ') ' . $mysqli->connect_error);
}
if (empty($_SESSION["session_id"]) && empty($_POST["login"]) && empty($_POST["user"]) && empty($_POST["password"]) || $_SESSION["type"] != 3) {
    header("Location: ../index.php");
    exit;
}

function inserirSocio($conexao, $nome, $morada1, $morada2, $nif)
{
    $query = "INSERT INTO socios (nome, morada1, morada2, nif) VALUES ('$nome', '$morada1', '$morada2', $nif)";
    if (mysqli_query($conexao, $query)) {
        echo "Novo sócio inserido com sucesso.";
    } else {
        echo "Erro ao inserir o sócio: " . mysqli_error($conexao);
    }
}

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Inserir Sócio</title>
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
        <h2 class="mt-5 text-center">Formulário de Inserção de Sócio</h2>
        <form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="post">
            <div class="mb-3">
                <label for="nome" class="form-label">Nome:</label>
                <input type="text" id="nome" name="nome" class="form-control" required>
            </div>

            <div class="mb-3">
                <label for="morada1" class="form-label">Morada:</label>
                <input type="text" id="morada1" name="morada1" class="form-control" required>
            </div>

            <div class="mb-3">
                <label for="morada2" class="form-label">Morada (Continuação):</label>
                <input type="text" id="morada2" name="morada2" class="form-control" required>
            </div>

            <div class="mb-3">
                <label for="nif" class="form-label">NIF:</label>
                <input type="number" id="nif" name="nif" class="form-control" required min="0">
            </div>

            <button style="background-color: #00631b; border-color: black;" type="submit" class="btn btn-primary">Inserir Sócio</button>
        </form>

        <?php if ($_SERVER['REQUEST_METHOD'] === 'POST') : ?>
            <div class="alert alert-success mt-4">
                <?php
                // Recupere os valores do formulário
                $nome = $_POST['nome'];
                $morada1 = $_POST['morada1'];
                $morada2 = $_POST['morada2'];
                $nif = $_POST['nif'];

                // Chame a função para inserir o sócio no banco de dados
                inserirSocio($mysqli, $nome, $morada1, $morada2, $nif);
                ?>
            </div>
        <?php endif; ?>
    </div>
</body>

</html>

<?php
include "footer-reservado.php";
?>