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
        <h2 class="mt-5 text-center">Escolha uma opção:</h2>
        <form method="POST" action="">
            <div class="form-group">
                <select name="opcao" class="form-select">
                    <option value="">Selecione</option>
                    <option value="instrumento">Instrumento</option>
                    <option value="farda">Farda</option>
                </select>
            </div>
            <div class="mt-4">
                <input style="background-color: #00631b; border-color: black;" type="submit" class="btn btn-primary" name="submit" value="Submeter">
            </div>
        </form>

        <?php
        if (isset($_POST['opcao'])) {
            $opcao = $_POST['opcao'];

            if ($opcao === 'instrumento') {
                $query = "SELECT cat, des, codigo, estado, user FROM instrumentos";
                $result = $mysqli->query($query);
            
                if ($result) {
                    if ($result->num_rows > 0) {
                        echo '<div class="mt-4">
                                <table class="table">
                                    <thead>
                                        <tr>
                                            <th scope="col">Código</th>
                                            <th scope="col">Categoria</th>
                                            <th scope="col">Descrição</th>
                                            <th scope="col">Estado</th>
                                            <th scope="col">Ação</th>
                                        </tr>
                                    </thead>
                                    <tbody>';
            
                        while ($row = $result->fetch_assoc()) {
                            echo '<tr>
                                    <td>' . $row['codigo'] . '</td>
                                    <td>' . $row['cat'] . '</td>
                                    <td>' . $row['des'] . '</td>
                                    <td>' . (is_null($row['user']) ? 'Livre' : 'Instrumento alugado por: ' . $row['user']) . '</td>
                                    <td>
                                        <form method="POST" action="">
                                            <input type="hidden" name="opcao" value="editar-instrumento">
                                            <input type="hidden" name="codigo" value="' . $row['codigo'] . '">
                                            <button type="submit" class="btn btn-primary">Editar</button>
                                        </form>
                                    </td>
                                </tr>';
                        }
            
                        echo '</tbody>
                                </table>
                            </div>';
                    } else {
                        echo '<div class="alert alert-warning mt-4" role="alert">Nenhum resultado encontrado.</div>';
                    }
                } else {
                    echo '<div class="alert alert-danger mt-4" role="alert">Ocorreu um erro ao executar a consulta.</div>';
                }
            }
            elseif ($opcao === 'farda') {
                $query = "SELECT tipo, genero, tamanho, estado, membs, id_peca FROM fardas";
                $result = $mysqli->query($query);

                if ($result) {
                    if ($result->num_rows > 0) {
                        echo '<div class="mt-4">
                                <table class="table">
                                    <thead>
                                        <tr>
                                            <th scope="col">Tipo</th>
                                            <th scope="col">Género</th>
                                            <th scope="col">Tamanho</th>
                                            <th scope="col">Estado</th>
                                            <th scope="col">Membro da Banda Sinfónica</th>
                                            <th scope="col">Ação</th>
                                        </tr>
                                    </thead>
                                    <tbody>';

                        while ($row = $result->fetch_assoc()) {
                            echo '<tr>
                                    <td>' . $row['tipo'] . '</td>
                                    <td>' . $row['genero'] . '</td>
                                    <td>' . $row['tamanho'] . '</td>
                                    <td>' . $row['estado'] . '</td>
                                    <td>' . $row['membs'] . '</td>
                                    <td>
                                        <form method="POST" action="">
                                            <input type="hidden" name="opcao" value="editar-farda">
                                            <input type="hidden" name="id_peca" value="' . $row['id_peca'] . '">
                                            <button type="submit" class="btn btn-primary">Editar</button>
                                        </form>
                                    </td>
                                </tr>';
                        }

                        echo '</tbody>
                                </table>
                            </div>';
                    } else {
                        echo '<div class="alert alert-warning mt-4" role="alert">Nenhum resultado encontrado.</div>';
                    }
                } else {
                    echo '<div class="alert alert-danger mt-4" role="alert">Ocorreu um erro ao executar a consulta.</div>';
                }
            }
        }

        if (isset($_POST['opcao']) && $_POST['opcao'] === 'editar-instrumento' && isset($_POST['codigo'])) {
            // Código para editar o instrumento com o código fornecido
            $codigo = $_POST['codigo'];
        
            $query = "SELECT des FROM instrumentos WHERE codigo = $codigo";
            $result = $mysqli->query($query);
        
            if ($result && $result->num_rows > 0) {
                $row = $result->fetch_assoc();
                // Formulário para edição do instrumento
                echo '<div class="mt-4">
                        <form method="POST" action="">
                            <div class="form-group">
                                <label for="descricao">Descrição:</label>
                                <input type="text" name="descricao" class="form-control" value="' . $row['des'] . '">
                            </div>
                            <input type="hidden" name="opcao" value="submit-edicao-instrumento">
                            <input type="hidden" name="codigo" value="' . $codigo . '">
                            <br/>
                            <button type="submit" class="btn btn-primary">Submeter Edição</button>
                        </form>
                    </div>';
            } else {
                echo '<div class="alert alert-danger mt-4" role="alert">Erro ao obter informações do instrumento.</div>';
            }
        }
        
        if (isset($_POST['opcao']) && $_POST['opcao'] === 'submit-edicao-instrumento' && isset($_POST['codigo'])) {
            // Código para processar a submissão do formulário de edição do instrumento
            $codigo = $_POST['codigo'];
            $descricao = $_POST['descricao'];
        
            $query = "UPDATE instrumentos SET des='$descricao' WHERE codigo='$codigo'";
            $result = $mysqli->query($query);
        
            if ($result) {
                echo '<div class="alert alert-success mt-4" role="alert">Instrumento editado com sucesso.</div>';
            } else {
                echo '<div class="alert alert-danger mt-4" role="alert">Erro ao editar o instrumento.</div>';
            }
        }
        

        if (isset($_POST['opcao']) && $_POST['opcao'] === 'editar-farda' && isset($_POST['id_peca'])) {
            // Código para editar a farda com o id_peca fornecido
            $id_peca = $_POST['id_peca'];

            $query = "SELECT tipo, genero, tamanho, estado, membs FROM fardas WHERE id_peca = '$id_peca'";
            $result = $mysqli->query($query);

            if ($result && $result->num_rows > 0) {
                $row = $result->fetch_assoc();
                // Formulário para edição da farda
                echo '<div class="mt-4">
                        <form method="POST" action="">
                            <div class="form-group">
                                <label for="tipoFarda">Escolha o tipo de peça da farda:</label>
                                <select name="tipoFarda" class="form-select">
                                    <option value="">Selecione</option>
                                    <option value="Chapéu"' . ($row['tipo'] === 'Chapéu' ? ' selected' : '') . '>Chapéu</option>
                                    <option value="Casaco"' . ($row['tipo'] === 'Casaco' ? ' selected' : '') . '>Casaco</option>
                                    <option value="Camisa"' . ($row['tipo'] === 'Camisa' ? ' selected' : '') . '>Camisa</option>
                                    <option value="Calças"' . ($row['tipo'] === 'Calças' ? ' selected' : '') . '>Calças</option>
                                </select>
                            </div>
                            <div class="form-group">
                                <label for="genero">Escolha o género:</label>
                                <select name="genero" class="form-select">
                                    <option value="">Selecione</option>
                                    <option value="Homem"' . ($row['genero'] === 'Homem' ? ' selected' : '') . '>Homem</option>
                                    <option value="Mulher"' . ($row['genero'] === 'Mulher' ? ' selected' : '') . '>Mulher</option>
                                </select>
                            </div>
                            <div class="form-group">
                                <label for="tamanho">Tamanho:</label>
                                <input type="number" name="tamanho" class="form-control" value="' . $row['tamanho'] . '">
                            </div>
                            <input type="hidden" name="opcao" value="submit-edicao-farda">
                            <input type="hidden" name="id_peca" value="' . $id_peca . '">
                            <br/>
                            <button type="submit" class="btn btn-primary">Submeter Edição</button>
                        </form>
                    </div>';
            } else {
                echo '<div class="alert alert-danger mt-4" role="alert">Erro ao obter informações da farda.</div>';
            }
        }

        if (isset($_POST['opcao']) && $_POST['opcao'] === 'submit-edicao-farda' && isset($_POST['id_peca'])) {
            // Código para processar a submissão do formulário de edição da farda
            $id_peca = $_POST['id_peca'];
            $tipoFarda = $_POST['tipoFarda'];
            $genero = $_POST['genero'];
            $tamanho = $_POST['tamanho'];

            $query = "UPDATE fardas SET tipo='$tipoFarda', genero='$genero', tamanho='$tamanho' WHERE id_peca='$id_peca'";
            $result = $mysqli->query($query);

            if ($result) {
                echo '<div class="alert alert-success mt-4" role="alert">Farda editada com sucesso.</div>';
            } else {
                echo '<div class="alert alert-danger mt-4" role="alert">Erro ao editar a farda.</div>';
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