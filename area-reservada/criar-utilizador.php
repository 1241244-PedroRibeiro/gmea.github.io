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
    </style>

</head>

<body>

    <?php

    // Função para obter o último usuário da categoria
    function obterUltimoUsuario($conexao, $tipo)
    {
        if ($tipo == 4 || $tipo == 5) {
            $tipo = 3;
        }
        $query = "SELECT MAX(user) FROM users1 WHERE type = $tipo";
        $resultado = mysqli_query($conexao, $query);
        $ultimoUsuario = mysqli_fetch_array($resultado)[0];
        return $ultimoUsuario;
    }

    // Função para inserir um novo usuário na categoria
    function inserirUsuario($conexao, $nome, $morada1, $morada2, $nif, $cc, $data_nas, $email, $telef, $tipo, $password, $foto)
    {
        $ultimoUsuario = obterUltimoUsuario($conexao, $tipo);
        if ($ultimoUsuario) {
            $ultimoNumero = intval(substr($ultimoUsuario, 1));
            $novoNumero = $ultimoNumero + 1;
        } else {
            $novoNumero = 100;
        }
        $letraTipo = obterLetraTipo($tipo);
        $novoUsuario = $letraTipo . $novoNumero;

        // Inserir na tabela 'users1'
        $query = "INSERT INTO users1 (user, nome, morada1, morada2, nif, cc, data_nas, email, telef, password, type, foto) VALUES ('$novoUsuario', '$nome', '$morada1', '$morada2', '$nif', '$cc', '$data_nas', '$email', '$telef', '$password', $tipo, '$foto')";
        mysqli_query($conexao, $query);

        if ($tipo === 1) { // Se for um aluno
            inserirAluno($conexao, $novoUsuario);
        }

        // Exibir a mensagem de sucesso em um modal
        echo "<script>
                $(document).ready(function() {
                    $('#successModal').modal('show');
                });
            </script>";
    }

    // Função para obter a letra correspondente ao tipo
    function obterLetraTipo($tipo)
    {
        switch ($tipo) {
            case 1:
                return 'a';
            case 2:
                return 'p';
            case 3:
                return 'd';
            case 4:
                return 'd';
            case 5:
                return 'd';
        }
    }

    // Função para inserir um novo aluno na tabela "alunos"
    function inserirAluno($conexao, $userID)
    {
        $queryAlunos = "INSERT INTO alunos (user, cod_in1, prof_in1, cod_in2, prof_in2, cod_fm, cod_orq, cod_coro, regime, tipo_regime, irmaos, mem_bs) VALUES ('$userID', 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0)";
        mysqli_query($conexao, $queryAlunos);
    }

    ?>

    <!-- Adicione esta parte no final do seu arquivo criar-utilizador.php -->
    <div class="modal fade" id="successModal" tabindex="-1" aria-labelledby="successModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="successModalLabel">Sucesso!</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    Utilizador inserido com sucesso!
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-primary" onclick="redirectBack()">OK</button>
                </div>
            </div>
        </div>
    </div>

    <script>
        function redirectBack() {
            window.location.href = 'gerir-utilizadores.php';
        }
    </script>

    <div class="container">
        <h2 class="mt-5 text-center">Formulário de Inserção de Utilizador</h2>
        <form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="post" enctype="multipart/form-data">
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

            <div class="mb-3">
                <label for="cc" class="form-label">CC:</label>
                <input type="number" id="cc" name="cc" class="form-control" required min="0">
            </div>

            <div class="mb-3">
                <label for="data_nas" class="form-label">Data de Nascimento:</label>
                <input type="date" id="data_nas" name="data_nas" class="form-control" required>
            </div>

            <div class="mb-3">
                <label for="email" class="form-label">E-mail:</label>
                <input type="text" id="email" name="email" class="form-control" required>
            </div>

            <div class="mb-3">
                <label for="telef" class="form-label">Telemóvel:</label>
                <input type="text" id="telef" name="telef" class="form-control" required>
            </div>

            <div class="mb-3">
                <label for="type" class="form-label">Tipo:</label>
                <select id="type" name="type" class="form-select" required>
                    <option value="1">Aluno</option>
                    <option value="2">Professor</option>
                    <option value="3">Membro da Direção</option>
                    <option value="4">Membro da Direção e Professor</option>
                    <option value="5">Secretaria</option>
                </select>
            </div>

            <div class="mb-3">
                <label for="foto" class="form-label">Foto:</label>
                <input type="file" id="foto" name="foto" accept="image/*" class="form-control" required>
            </div>

            <button style="background-color: #00631b; border-color: black;" type="submit" class="btn btn-primary">Inserir</button>
        </form>

        <?php if ($_SERVER['REQUEST_METHOD'] === 'POST') : ?>
            <div class="alert alert-success mt-4">
                <?php
                $nome = $_POST['nome'];
                $morada1 = $_POST['morada1'];
                $morada2 = $_POST['morada2'];
                $nif = $_POST['nif'];
                $cc = $_POST['cc'];
                $data_nas = $_POST['data_nas'];
                $email = $_POST['email'];
                $telef = $_POST['telef'];
                $type = $_POST['type'];
                $foto = $_FILES['foto']['name'];
                $hashedPassword = password_hash($cc, PASSWORD_DEFAULT);
                $target_path = "fotos_perfil/";
                $target_file = $target_path . basename($foto);

                $imageFileType = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));

                $target_file = $target_path . uniqid() . "." . $imageFileType;
                $foto = $target_file;

                // Verifica as categorias selecionadas
                if ($type === '1') {
                    inserirUsuario($conexao, $nome, $morada1, $morada2, $nif, $cc, $data_nas, $email, $telef, 1, $hashedPassword, $foto);
                } elseif ($type === '2') {
                    inserirUsuario($conexao, $nome, $morada1, $morada2, $nif, $cc, $data_nas, $email, $telef, 2, $hashedPassword, $foto);
                } elseif ($type === '3') {
                    inserirUsuario($conexao, $nome, $morada1, $morada2, $nif, $cc, $data_nas, $email, $telef, 3, $hashedPassword, $foto);
                } elseif ($type === '4') {
                    inserirUsuario($conexao, $nome, $morada1, $morada2, $nif, $cc, $data_nas, $email, $telef, 4, $hashedPassword, $foto);
                } elseif ($type === '5') {
                    inserirUsuario($conexao, $nome, $morada1, $morada2, $nif, $cc, $data_nas, $email, $telef, 5, $hashedPassword, $foto);
                }

                move_uploaded_file($_FILES['foto']['tmp_name'], $target_file);
                ?>
            </div>
        <?php endif; ?>
    </div>

</body>

</html>
