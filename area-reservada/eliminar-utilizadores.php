<!DOCTYPE html>
<html lang="en">

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

?>

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Eliminar Utilizadores</title>
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

    <?php include "header-direcao.php"; ?>

    <div class="container">
        <?php

        function excluirUsuario($usuario)
        {
            global $mysqli;

            $query = "DELETE FROM users1 WHERE user = ?";
            $stmt = $mysqli->prepare($query);
            $stmt->bind_param("s", $usuario);
            $resultado = $stmt->execute();

            if ($resultado) {
                return true;
            } else {
                echo "Erro ao excluir o usuário: " . $mysqli->error;
                return false;
            }
        }

        $tipos_membros = array(
            1 => 'Aluno',
            2 => 'Professor',
            3 => 'Membro da Direção'
        );

        $tipo_selecionado = isset($_POST['tipo']) ? $_POST['tipo'] : null;
        $search_nome = isset($_POST['search']) ? $_POST['search'] : null;
        $resultados = array();

        if ($tipo_selecionado && $search_nome) {
            $query = "SELECT user, nome FROM users1 WHERE type = $tipo_selecionado AND nome LIKE '%$search_nome%'";
            $resultado = $mysqli->query($query);

            if ($resultado) {
                while ($row = $resultado->fetch_assoc()) {
                    $resultados[] = $row;
                }
            } else {
                echo "Erro na consulta: " . $mysqli->error;
            }
        }

        ?>
        <div class="row">
            <div class="col-md-6">
                <form method="POST">
                    <div class="mb-3">
                        <label for="tipo" class="form-label">Tipo de membro:</label>
                        <select name="tipo" class="form-control">
                            <option value="">Selecione um tipo</option>
                            <?php
                            foreach ($tipos_membros as $tipo => $descricao) {
                                echo '<option value="' . $tipo . '"' . ($tipo_selecionado == $tipo ? ' selected' : '') . '>' . $descricao . '</option>';
                            }
                            ?>
                        </select>
                    </div>
                    <div class="mb-3">
                        <label for="search" class="form-label">Pesquisar por nome:</label>
                        <input type="text" name="search" class="form-control" placeholder="Digite o nome do aluno">
                    </div>
                    <div class="mb-3">
                        <button style="background-color: #00631b; border-color: black;" type="submit" class="btn btn-primary">Prosseguir</button>
                    </div>
                </form>
            </div>
            <div class="col-md-6">
                <?php
                if ($tipo_selecionado && $search_nome) {
                    if (count($resultados) > 0) {
                        ?>
                        <form method="POST">
                            <div class="mb-3">
                                <label for="user_dropdown" class="form-label">Usuário:</label>
                                <select name="user_dropdown" class="form-control">
                                    <option value="">Selecione um usuário</option>
                                    <?php
                                    foreach ($resultados as $usuario) {
                                        echo '<option value="' . $usuario['user'] . '">' . $usuario['user'] . ' - ' . $usuario['nome'] . '</option>';
                                    }
                                    ?>
                                </select>
                            </div>
                            <div class="mb-3">
                                <button type="submit" name="submit_excluir" class="btn btn-danger">Excluir</button>
                            </div>
                        </form>
                    <?php
                    } else {
                        echo '<div class="alert alert-info">Nenhum usuário encontrado.</div>';
                    }
                }
                ?>
            </div>
        </div>
    </div>
</body>

<?php

if (isset($_POST['submit_excluir'])) {
    $usuario_selecionado = $_POST['user_dropdown'];
    $exclusao_sucesso = excluirUsuario($usuario_selecionado);
    if ($exclusao_sucesso) {
        echo '<div style="width: 70%; margin: auto;" class="alert alert-success">Utilizador eliminado com sucesso!</div>';
    } else {
        echo '<div style="width: 70%; margin: auto;" class="alert alert-danger">Erro ao eliminar o utilizador.</div>';
    }
}

?>

<?php

    include "footer-reservado.php";

?>

</html>
