<?php
session_start();
include "./generals/config.php";
$mysqli = new mysqli($bd_host, $bd_user, $bd_password, $bd_database);

if ($mysqli->connect_error) {
    die('Erro: (' . $mysqli->connect_errno . ') ' . $mysqli->connect_error);
}

if (empty($_SESSION["session_id"]) && empty($_POST["login"]) && empty($_POST["user"]) && empty($_POST["password"]) || $_SESSION["type"] < 3) {
    header("Location: ../index.php");
    exit;
}

// Adicionar usuário associado aos instrumentos
if (isset($_POST['opcao']) && $_POST['opcao'] === 'adicionar-user' && isset($_POST['codigo'])) {
    $codigo = $_POST['codigo'];
    $user = $_POST['user'];

    $query = "UPDATE instrumentos SET user='$user', estado=1 WHERE codigo='$codigo'";
    $result = $mysqli->query($query);

    if ($result) {
        echo '<div class="alert alert-success mt-4" role="alert">Usuário atribuído com sucesso ao instrumento.</div>';
    } else {
        echo '<div class="alert alert-danger mt-4" role="alert">Erro ao atribuir usuário ao instrumento.</div>';
    }
}

// Remover usuário associado aos instrumentos
if (isset($_POST['opcao']) && $_POST['opcao'] === 'remover-user' && isset($_POST['codigo'])) {
    $codigo = $_POST['codigo'];

    $query = "UPDATE instrumentos SET user=NULL, estado=0 WHERE codigo='$codigo'";
    $result = $mysqli->query($query);

    if ($result) {
        echo '<div class="alert alert-success mt-4" role="alert">Usuário removido com sucesso do instrumento.</div>';
    } else {
        echo '<div class="alert alert-danger mt-4" role="alert">Erro ao remover usuário do instrumento.</div>';
    }
}


// Adicionar membro associado às fardas
if (isset($_POST['opcao']) && $_POST['opcao'] === 'adicionar-membs' && isset($_POST['id_peca'])) {
    $id_peca = $_POST['id_peca'];
    $membs = $_POST['membs'];

    $query = "UPDATE fardas SET membs='$membs', estado=1 WHERE id_peca='$id_peca'";
    $result = $mysqli->query($query);

    if ($result) {
        echo '<div class="alert alert-success mt-4" role="alert">Membro atribuído com sucesso à farda.</div>';
    } else {
        echo '<div class="alert alert-danger mt-4" role="alert">Erro ao atribuir membro à farda.</div>';
    }
}

// Remover membro associado às fardas
if (isset($_POST['opcao']) && $_POST['opcao'] === 'remover-membs' && isset($_POST['id_peca'])) {
    $id_peca = $_POST['id_peca'];

    $query = "UPDATE fardas SET membs=NULL, estado=0 WHERE id_peca='$id_peca'";
    $result = $mysqli->query($query);

    if ($result) {
        echo '<div class="alert alert-success mt-4" role="alert">Membro removido com sucesso da farda.</div>';
    } else {
        echo '<div class="alert alert-danger mt-4" role="alert">Erro ao remover membro da farda.</div>';
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

        <div class="container mb-3">
            <label for="acao" class="form-label">Selecione uma ação:</label>
            <select name="acao" id="acao" class="form-select">
                <option value="">Selecione</option>
                <option value="adicionar">Adicionar Inventário</option>
                <option value="editar">Editar Informações de Inventário</option>
                <option value="consultar">Consultar Inventário</option>
                <option value="atribuir">Atribuir Inventário</option>
                <option value="eliminar">Eliminar Inventário</option>
            </select>
        </div>

    <div class="container mt-5">
        <h2 class="mt-5 text-center">Gestão de Atribuição de Inventário</h2>
        <form method="POST" action="">
            <div class="form-group">
                <select name="opcao" class="form-select">
                    <option value="">Selecione</option>
                    <option value="adicionar-user">Adicionar Usuário a Instrumento</option>
                    <option value="remover-user">Remover Usuário de Instrumento</option>
                    <option value="adicionar-membs">Adicionar Membro a Farda</option>
                    <option value="remover-membs">Remover Membro de Farda</option>
                </select>
            </div>
            <div class="mt-4">
                <input style="background-color: #00631b; border-color: black;" type="submit" class="btn btn-primary" name="submit" value="Submeter">
            </div>
        </form>

        <!-- Formulário para adicionar/remover usuário associado aos instrumentos -->
        <?php
        if (isset($_POST['opcao']) && ($_POST['opcao'] === 'adicionar-user')) {
            $query = "SELECT codigo, cat, des FROM instrumentos where estado = 0";
            $result = $mysqli->query($query);

            if ($result && $result->num_rows > 0) {
                echo '<div class="mt-4">
                        <form method="POST" action="">
                            <div class="form-group">
                                <label for="codigo">Selecione o Código do Instrumento:</label>
                                <select name="codigo" class="form-select">';
                while ($row = $result->fetch_assoc()) {
                    echo '<option value="' . $row['codigo'] . '">' . $row['codigo'] . ' - ' . $row['cat'] .  ' - ' . $row['des'] . '</option>';
                }
                echo '</select>
                            </div>';

                if ($_POST['opcao'] === 'adicionar-user') {
                    // Lista de usuários para seleção
                    $query_users = "SELECT user, nome FROM users1 WHERE type = 1";
                    $result_users = $mysqli->query($query_users);

                    if ($result_users && $result_users->num_rows > 0) {
                        echo '<div class="form-group">
                                <label for="user">Selecione o Usuário:</label>
                                <select name="user" class="form-select">';
                        while ($row_user = $result_users->fetch_assoc()) {
                            echo '<option value="' . $row_user['user'] . '">' . $row_user['user'] . ' - ' . $row_user['nome'] . '</option>';
                        }
                        echo '</select>
                            </div>';
                    } else {
                        echo '<div class="alert alert-warning mt-4" role="alert">Nenhum usuário disponível.</div>';
                    }
                }

                echo '<input type="hidden" name="opcao" value="' . $_POST['opcao'] . '">
                            <br/>
                            <button type="submit" class="btn btn-primary">Submeter</button>
                        </form>
                    </div>';
            } else {
                echo '<div class="alert alert-warning mt-4" role="alert">Nenhum instrumento disponível.</div>';
            }
        }
        else if (isset($_POST['opcao']) && $_POST['opcao'] === 'remover-user') {
            $query = "SELECT codigo, cat, des, user FROM instrumentos where estado = 1";
            $result = $mysqli->query($query);
        
            if ($result && $result->num_rows > 0) {
                echo '<div class="mt-4">
                        <form method="POST" action="">
                            <div class="form-group">
                                <label for="codigo">Selecione o Código do Instrumento:</label>
                                <select name="codigo" class="form-select">';
                while ($row = $result->fetch_assoc()) {
                    $querynome = "SELECT nome FROM users1 WHERE user = '" . $row['user'] . "'";
                    $resultado_nome = $mysqli->query($querynome);
        
                    if ($resultado_nome && $resultado_nome->num_rows > 0) {
                        // Obtenha o nome do usuário associado ao instrumento
                        $rownome = $resultado_nome->fetch_assoc();
                        $nome_user = $rownome['nome'];
                    } else {
                        // Se não houver nome de usuário associado, defina como vazio
                        $nome_user = "";
                    }
        
                    echo '<option value="' . $row['codigo'] . '">' . $row['codigo'] . ' - ' . $row['cat'] .  ' - ' . $row['user'] . ' - ' . $nome_user . '</option>';
                }
                echo '</select>
                            </div>';
        
                echo '<input type="hidden" name="opcao" value="' . $_POST['opcao'] . '">
                            <br/>
                            <button type="submit" class="btn btn-primary">Submeter</button>
                        </form>
                    </div>';
            } else {
                echo '<div class="alert alert-warning mt-4" role="alert">Nenhum instrumento disponível.</div>';
            }
        }        
        ?>

        <!-- Formulário para adicionar/remover membro associado às fardas -->
        <?php
        if (isset($_POST['opcao']) && ($_POST['opcao'] === 'adicionar-membs')) {
            $query = "SELECT id_peca, tipo, genero, tamanho FROM fardas where estado = 0";
            $result = $mysqli->query($query);

            if ($result && $result->num_rows > 0) {
                echo '<div class="mt-4">
                        <form method="POST" action="">
                            <div class="form-group">
                                <label for="id_peca">Selecione o ID da Peça de Farda:</label>
                                <select name="id_peca" class="form-select">';
                while ($row = $result->fetch_assoc()) {
                    echo '<option value="' . $row['id_peca'] . '">' . $row['id_peca'] . ' - ' . $row['tipo'] . ' - ' . $row['genero'] . ' - ' . $row['tamanho'] . '</option>';
                }
                echo '</select>
                            </div>
                            <div class="form-group">
                                <label for="membs">Nome do Membro:</label>
                                <input type="text" name="membs" class="form-control">
                            </div>
                            <input type="hidden" name="opcao" value="' . $_POST['opcao'] . '">
                            <br/>
                            <button type="submit" class="btn btn-primary">Submeter</button>
                        </form>
                    </div>';
            } else {
                echo '<div class="alert alert-warning mt-4" role="alert">Nenhuma farda disponível.</div>';
            }
        }
        else if (isset($_POST['opcao']) && $_POST['opcao'] === 'remover-membs') {
            $query = "SELECT id_peca, tipo, genero, tamanho, membs FROM fardas where estado = 1";
            $result = $mysqli->query($query);

            if ($result && $result->num_rows > 0) {
                echo '<div class="mt-4">
                        <form method="POST" action="">
                            <div class="form-group">
                                <label for="id_peca">Selecione o ID da Peça de Farda:</label>
                                <select name="id_peca" class="form-select">';
                while ($row = $result->fetch_assoc()) {
                    echo '<option value="' . $row['id_peca'] . '">' . $row['id_peca'] . ' - ' . $row['tipo'] . ' - ' . $row['genero'] . ' - ' . $row['tamanho'] . ' - Atribuido a: ' . $row['membs'] . '</option>';
                }
                echo '</select>
                            </div>
                            <input type="hidden" name="opcao" value="' . $_POST['opcao'] . '">
                            <br/>
                            <button type="submit" class="btn btn-primary">Submeter</button>
                        </form>
                    </div>';
            } else {
                echo '<div class="alert alert-warning mt-4" role="alert">Nenhuma farda disponível.</div>';
            }
        }
        ?>
    </div>

    <?php
    include "footer-reservado.php";
    ?>

</body>

</html>

<script>
                // Adiciona um listener para o evento de mudança no select de ação
                document.getElementById("acao").addEventListener("change", function() {
            var acao = this.value;

            // Redireciona para a página correspondente
            if (acao === 'adicionar') {
                window.location.href = "adicionar-inventario.php";
            } else if (acao === 'editar') {
                window.location.href = "editar-inventario.php";
            } else if (acao === 'consultar') {
                window.location.href = "consultar-inventario.php";
            } else if (acao === 'atribuir') {
                window.location.href = "atribuir-inventario.php";
            } else if (acao === 'eliminar') {
                window.location.href = "eliminar-inventario.php";
            }
        });
</script>
