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

$utilizadores = array();

$query = "SELECT user, nome FROM users1 WHERE type=2 and estado=1";
$resultado = mysqli_query($mysqli, $query);

if ($resultado) {
    while ($row = mysqli_fetch_assoc($resultado)) {
        $utilizadores[] = $row;
    }
} else {
    echo "Erro na consulta: " . mysqli_error($mysqli);
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
        .btn-remove {
            margin-right: 5px;
        }
    </style>

    <script>
        function removerDisciplina(user, cod_dis) {
            if (confirm('Tem certeza que deseja remover esta disciplina?')) {
                // Envia uma requisição AJAX para remover a disciplina
                $.ajax({
                    type: 'POST',
                    url: 'remover_disciplina.php',
                    data: { user: user, cod_dis: cod_dis },
                    success: function(response) {
                        // Atualize a tabela após a remoção bem-sucedida
                        location.reload();
                    },
                    error: function(error) {
                        console.error('Erro ao remover disciplina: ' + error.responseText);
                    }
                });
            }
        }
    </script>
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
        <?php if (!isset($_POST['user'])): ?>
            <h2>Selecione um professor</h2>
            <form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="post">
                <div class="mb-3">
                    <label for="user" class="form-label">Utilizador</label>
                    <select id="user" name="user" class="form-select" required>
                        <option value="">Selecione um utilizador</option>
                        <?php foreach ($utilizadores as $utilizador): ?>
                            <option value="<?php echo $utilizador['user']; ?>"><?php echo $utilizador['user'] . ' - ' . $utilizador['nome']; ?></option>
                        <?php endforeach; ?>
                    </select>
                </div>
                <button style="background-color: #00631b; border-color: #000000;" type="submit" class="btn btn-primary">Prosseguir</button>
            </form>
        <?php else: ?>
            <?php
                $selected_user = $_POST['user'];
                $nome = '';

                $query = "SELECT nome FROM users1 WHERE user = '$selected_user' and estado=1";
                $result = $mysqli->query($query);

                if ($result && $result->num_rows > 0) {
                    $row = $result->fetch_assoc();
                    $nome = $row['nome'];
                } else {
                    echo '<div class="alert alert-danger mt-3" role="alert">Utilizador não encontrado.</div>';
                    exit;
                }
            ?>

            <h2>Atribuição de Disciplina para <?php echo $selected_user; ?></h2>
            <form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="post">
                <input type="hidden" name="user" value="<?php echo $selected_user; ?>">
                <div class="mb-3">
                    <label for="disciplina" class="form-label">Disciplina</label>
                    <select id="disciplina" name="disciplina" class="form-select" required>
                        <option value="">Selecione uma disciplina</option>
                        <?php
                            $query = "SELECT cod_dis, nome_dis FROM cod_dis 
                                    WHERE cod_dis NOT IN (SELECT cod_dis FROM profs WHERE user = '$selected_user')";
                            $result = $mysqli->query($query);

                            if ($result && $result->num_rows > 0) {
                                while ($row = $result->fetch_assoc()) {
                                    echo '<option value="' . $row['cod_dis'] . '">' . $row['nome_dis'] . '</option>';
                                }
                            }
                        ?>
                    </select>
                </div>
                <button style="background-color: #00631b; border-color: #000000;" type="submit" class="btn btn-primary">Atribuir Disciplina</button>
            </form>

            <?php
                if ($_SERVER['REQUEST_METHOD'] === 'POST') {
                    if (isset($_POST['user']) && isset($_POST['disciplina'])) {
                        $selected_user = $_POST['user'];
                        $selected_disciplina = $_POST['disciplina'];

                        $query = "INSERT INTO profs (user, nome, cod_dis) VALUES ('$selected_user', '$nome', '$selected_disciplina')";

                        if ($mysqli->query($query) === TRUE) {
                            echo '<div class="alert alert-success mt-3" role="alert">Disciplina atribuída com sucesso.</div>';
                        } else {
                            echo '<div class="alert alert-danger mt-3" role="alert">Erro ao atribuir disciplina: ' . $mysqli->error . '</div>';
                        }
                    }
                }
            ?>

            <?php
                $query = "SELECT cod_dis.cod_dis, cod_dis.nome_dis FROM cod_dis LEFT JOIN profs ON profs.cod_dis = cod_dis.cod_dis WHERE profs.user = '$selected_user'";
                $result = $mysqli->query($query);

                echo '<h3>Disciplinas atribuídas a ' . $selected_user . ' - ' . $nome . '</h3>';
                echo '<table class="table table-striped">';
                echo '<thead>';
                echo '<tr>';
                echo '<th>Código da Disciplina</th>';
                echo '<th>Nome da Disciplina</th>';
                echo '<th>Ação</th>'; // Adiciona a nova coluna "Ação"
                echo '</tr>';
                echo '</thead>';
                echo '<tbody>';

                if ($result && $result->num_rows > 0) {
                    while ($row = $result->fetch_assoc()) {
                        echo '<tr>';
                        echo '<td>' . $row['cod_dis'] . '</td>';
                        echo '<td>' . $row['nome_dis'] . '</td>';
                        echo '<td><button class="btn btn-danger btn-sm btn-remove" onclick="removerDisciplina(\'' . $selected_user . '\', \'' . $row['cod_dis'] . '\')">Remover</button></td>'; // Adiciona o botão "Remover"
                        echo '</tr>';
                    }
                } else {
                    echo '<tr>';
                    echo '<td colspan="3">Nenhuma disciplina atribuída.</td>';
                    echo '</tr>';
                }

                echo '</tbody>';
                echo '</table>';
            ?>
        <?php endif; ?>
    </div>

    <?php include 'footer-reservado.php'; ?>

</body>

</html>
