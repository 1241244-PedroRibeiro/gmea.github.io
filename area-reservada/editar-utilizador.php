<?php
session_start();
include "./generals/config.php";
$mysqli = new mysqli($bd_host, $bd_user, $bd_password, $bd_database);

if ($mysqli->connect_error) {
    die('Erro: (' . $mysqli->connect_errno . ') ' . $mysqli->connect_error);
}

if (empty($_SESSION["session_id"]) && empty($_GET["search"]) && empty($_POST["aluno"]) || $_SESSION["type"] < 3) {
    header("Location: ../index.php");
    exit;
}

// Função para obter informações de um aluno pelo ID de usuário
function obterInformacoesAluno($conexao, $userID)
{
    $query = "SELECT * FROM users1 WHERE user = '$userID' and estado=1";
    $resultado = mysqli_query($conexao, $query);
    return mysqli_fetch_assoc($resultado);
}

// Inicializar variáveis para modais
$successModal = $errorModal = "";

// Check if the form is submitted and the "Guardar Alterações" button is clicked
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['guardar_alteracoes'])) {
    $alunoSelecionado = $_SESSION["selecionado_editar_user"];
    $informacoesAluno = obterInformacoesAluno($mysqli, $alunoSelecionado);

    if ($informacoesAluno) {
        // Processar as atualizações no banco de dados (se necessário)
        $nome = $_POST['nome'];
        $morada1 = $_POST['morada1'];
        $morada2 = $_POST['morada2'];
        $nif = $_POST['nif'];
        $cc = $_POST['cc'];
        $data_nas = $_POST['data_nas'];
        $email = $_POST['email'];
        $telef = $_POST['telef'];

        // Atualizar a foto se um novo arquivo for enviado
        if (!empty($_FILES['foto']['name'])) {
            $target_path = "fotos_perfil/";
            $target_file = $target_path . basename($_FILES['foto']['name']);
            $imageFileType = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));
            $target_file = $target_path . uniqid() . "." . $imageFileType;
            move_uploaded_file($_FILES['foto']['tmp_name'], $target_file);

            // Atualizar o caminho da foto na base de dados
            $queryUpdateFoto = "UPDATE users1 SET foto = '$target_file' WHERE user = '$alunoSelecionado'";
            mysqli_query($mysqli, $queryUpdateFoto);
        }

        // Atualizar as outras informações do aluno na base de dados
        $queryUpdateAluno = "UPDATE users1 SET nome = '$nome', morada1 = '$morada1', morada2 = '$morada2', nif = '$nif', cc = '$cc', data_nas = '$data_nas', email = '$email', telef = '$telef' WHERE user = '$alunoSelecionado'";
        if (mysqli_query($mysqli, $queryUpdateAluno)) {
            // Exibir modal de sucesso
            $successModal = '<div class="modal" tabindex="-1" role="dialog" id="successModal">
                                <div class="modal-dialog" role="document">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h5 class="modal-title">Sucesso!</h5>
                                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                        </div>
                                        <div class="modal-body">
                                            <p>Informações do aluno atualizadas com sucesso.</p>
                                        </div>
                                    </div>
                                </div>
                            </div>';
        } else {
            // Exibir modal de erro
            $errorModal = '<div class="modal" tabindex="-1" role="dialog" id="errorModal">
                                <div class="modal-dialog" role="document">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h5 class="modal-title">Erro!</h5>
                                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                        </div>
                                        <div class="modal-body">
                                            <p>Não foi possível atualizar as informações do aluno.</p>
                                        </div>
                                    </div>
                                </div>
                            </div>';
        }
    } else {
        // Exibir modal de erro se não encontrar informações para o aluno selecionado
        $errorModal = '<div class="modal" tabindex="-1" role="dialog" id="errorModal">
                            <div class="modal-dialog" role="document">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title">Erro!</h5>
                                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                    </div>
                                    <div class="modal-body">
                                        <p>Não foi possível encontrar informações para o aluno selecionado.</p>
                                    </div>
                                </div>
                            </div>
                        </div>';
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>GMEA - Editar Utilizador</title>
    <link rel="shortcut icon" type="image/png" href="media/logo.png" />
    <script src="https://use.fontawesome.com/releases/v6.3.0/js/all.js" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.3.1/jquery.min.js" crossorigin="anonymous"></script>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js"></script>
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
        <h2 class="mt-5 text-center">Edição de Utilizador</h2>

        <!-- Modal de Sucesso -->
        <?php echo $successModal; ?>

        <!-- Modal de Erro -->
        <?php echo $errorModal; ?>

        <form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="get" class="mb-3">
            <div class="input-group">
                <input type="text" class="form-control" placeholder="Pesquisar aluno por nome" name="search" value="<?php echo isset($_GET['search']) ? $_GET['search'] : ''; ?>">
                <button style="background-color: #00631b; border-color: black;" class="btn btn-primary" type="submit">Pesquisar</button>
            </div>
        </form>

        <h3>Selecione um aluno:</h3>

        <form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="post">
            <div class="mb-3">
                <select id="aluno" name="aluno" class="form-select" required>
                    <option value="">Selecione um aluno</option>
                    <?php
                    if (isset($_GET['search'])) {
                        // Pesquisar alunos com base no nome
                        $search = $_GET['search'];
                        $queryAlunos = "SELECT user, nome, estado FROM users1 WHERE estado=1 AND nome LIKE '%$search%' ORDER BY type";
                    } else {
                        // Se não houver pesquisa, obter todos os alunos
                        $queryAlunos = "SELECT user, nome, estado FROM users1 WHERE estado = 1 ORDER BY type";
                    }

                    $resultadoAlunos = mysqli_query($mysqli, $queryAlunos);

                    while ($aluno = mysqli_fetch_assoc($resultadoAlunos)) {
                        echo '<option value="' . $aluno['user'] . '" data-user="' . $aluno['user'] . '">';
                        echo $aluno['user'] . ' - ' . $aluno['nome'];
                        echo '</option>';
                    }

                    ?>
                </select>
            </div>
            <button style="background-color: #00631b; border-color: black;" type="submit" class="btn btn-primary">Prosseguir</button>
        </form>

        <?php
        if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['aluno'])) {
            $alunoSelecionado = $_POST['aluno'];
            $_SESSION["selecionado_editar_user"] = $_POST['aluno'];
            $informacoesAluno = obterInformacoesAluno($mysqli, $alunoSelecionado);

            if ($informacoesAluno) {
        ?>

                <!-- Formulário de edição com todas as informações -->
                <h3 class="mt-4">Informações do Aluno</h3>
                <form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="post" enctype="multipart/form-data">
                    <div class="mb-3">
                        <label for="nome" class="form-label">Nome:</label>
                        <input type="text" id="nome" name="nome" class="form-control" value="<?php echo $informacoesAluno['nome']; ?>" required>
                    </div>

                    <div class="mb-3">
                        <label for="morada1" class="form-label">Morada:</label>
                        <input type="text" id="morada1" name="morada1" class="form-control" value="<?php echo $informacoesAluno['morada1']; ?>" required>
                    </div>

                    <div class="mb-3">
                        <label for="morada2" class="form-label">Morada (Continuação):</label>
                        <input type="text" id="morada2" name="morada2" class="form-control" value="<?php echo $informacoesAluno['morada2']; ?>" required>
                    </div>

                    <div class="mb-3">
                        <label for="nif" class="form-label">NIF:</label>
                        <input type="number" id="nif" name="nif" class="form-control" value="<?php echo $informacoesAluno['nif']; ?>" required min="0">
                    </div>

                    <div class="mb-3">
                        <label for="cc" class="form-label">CC:</label>
                        <input type="number" id="cc" name="cc" class="form-control" value="<?php echo $informacoesAluno['cc']; ?>" required min="0">
                    </div>

                    <div class="mb-3">
                        <label for="data_nas" class="form-label">Data de Nascimento:</label>
                        <input type="date" id="data_nas" name="data_nas" class="form-control" value="<?php echo $informacoesAluno['data_nas']; ?>" required>
                    </div>

                    <div class="mb-3">
                        <label for="email" class="form-label">E-mail:</label>
                        <input type="text" id="email" name="email" class="form-control" value="<?php echo $informacoesAluno['email']; ?>" required>
                    </div>

                    <div class="mb-3">
                        <label for="telef" class="form-label">Telemóvel:</label>
                        <input type="text" id="telef" name="telef" class="form-control" value="<?php echo $informacoesAluno['telef']; ?>" required>
                    </div>

                    <div class="mb-3">
                        <label for="foto" class="form-label">Foto:</label>
                        <input type="file" id="foto" name="foto" accept="image/*" class="form-control">
                    </div>

                    <!-- Adicione outros campos do formulário conforme necessário -->

                    <button style="background-color: #00631b; border-color: black;" type="submit" name="guardar_alteracoes" class="btn btn-primary">Guardar Alterações</button>
                </form>

        <?php
            } else {
                // Exibir modal de erro se não encontrar informações para o aluno selecionado
                echo '<div class="modal" tabindex="-1" role="dialog" id="errorModal">
                            <div class="modal-dialog" role="document">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title">Erro!</h5>
                                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                    </div>
                                    <div class="modal-body">
                                        <p>Não foi possível encontrar informações para o aluno selecionado.</p>
                                    </div>
                                </div>
                            </div>
                        </div>';
            }
        }
        ?>
    </div>

    <!-- Adicione esta parte ao final do seu código -->
    <script>
        // Exibir modal de sucesso ao carregar a página
        $(document).ready(function() {
            $('#successModal').modal('show');
        });

        // Exibir modal de erro ao carregar a página
        $(document).ready(function() {
            $('#errorModal').modal('show');
        });

        // Adicione este script para redirecionar para test.php ao pressionar o botão no modal de sucesso
        $('#successModal').on('hidden.bs.modal', function(e) {
            window.location.href = 'gerir-utilizadores.php';
        });

        // Adicione este script para redirecionar para test.php ao pressionar o botão no modal de erro
        $('#errorModal').on('hidden.bs.modal', function(e) {
            window.location.href = 'gerir-utilizadores.php';
        });
    </script>

    <?php include "footer-reservado.php"; ?>

</body>

</html>
