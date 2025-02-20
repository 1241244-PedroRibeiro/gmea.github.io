<?php
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
$type = $_SESSION["type"];

// Consulta SQL para obter as informações do usuário logado
$query = "SELECT nome, user, cc, data_nas, email, foto FROM users1 WHERE user = '$user' and estado=1";
$result = $mysqli->query($query);
$row = $result->fetch_assoc();

// Converte a data de nascimento para o formato dd-mm-yyyy
$data_nas_formatada = DateTime::createFromFormat('Y-m-d', $row['data_nas'])->format('d/m/Y');

if ($type == 1) {
    // Consulta SQL para obter as informações do usuário logado
    $queryAlunos = "SELECT turma FROM alunos WHERE user = '$user'";
    $resultAlunos = $mysqli->query($queryAlunos);
    $rowAluno = $resultAlunos->fetch_assoc();
    $turma = $rowAluno['turma'];

    $queryTurma = "SELECT nome_turma FROM turmas_gerais WHERE cod_turma = '$turma'";
    $resultTurma = $mysqli->query($queryTurma);
    $rowTurma = $resultTurma->fetch_assoc();
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

        .profile-photo-cell {
            vertical-align: middle;
            text-align: center;
        }

        .profile-photo {
            max-width: 100%;
            height: auto;
        }

    </style>

</head>

<body>

    <div style="margin-top: 0;">
        <img style="width: 100%; height: auto;" src="./media/topAR.png" class="img-responsive">
    </div>

    <?php
    if ($_SESSION["type"] == 1) {
        include "header-alunos.php";
    ?>
        <div class="container mt-4">
            <!-- Início da tabela adaptada -->
            <table class="table table-bordered">
                <thead class="thead-dark">
                <tr>
                    <th colspan="2">Dados Atuais</th>
                    <th class="text-center">Foto</th>
                </tr>
                </thead>
                <tbody>
                <tr>
                    <td bgcolor="#D6D6D6" width="22%"><strong>N.º do CC:</strong></td>
                    <td><?php echo $row['cc']; ?></td>
                    <td rowspan="5" class="profile-photo-cell">
                        <img src="<?php echo $row['foto']; ?>" class="profile-photo" alt="Foto">
                    </td>
                </tr>
                <!-- Adicione mais linhas conforme necessário -->
                <tr>
                    <td bgcolor="#D6D6D6" width="22%"><strong>Número:</strong></td>
                    <td><?php echo substr($row['user'], 1); ?></td>
                </tr>
                <tr>
                    <td bgcolor="#D6D6D6" width="22%"><strong>Nome:</strong></td>
                    <td><?php echo $row['nome']; ?></td>
                </tr>
                <tr>
                    <td bgcolor="#D6D6D6" width="22%"><strong>Data Nascimento:</strong></td>
                    <td><?php echo $data_nas_formatada; ?></td>
                </tr>
                <!--<tr>
                    <td bgcolor="#D6D6D6" width="22%"><strong>Ano:</strong></td>
                    <td><?php echo $row['ano']; ?></td>
                </tr> -->
                <tr>
                    <td bgcolor="#D6D6D6" width="22%"><strong>Turma:</strong></td>
                    <td><?php echo "Turma " . $rowTurma['nome_turma']; ?></td>
                </tr>
                </tbody>
            </table>
            <!-- Fim da tabela adaptada -->
        </div>
    <?php

    }
    if ($_SESSION["type"] == 2) {
        include "header-profs.php";
    ?>

        <div class="container mt-4">
            <!-- Início da tabela adaptada -->
            <table class="table table-bordered">
                <thead class="thead-dark">
                <tr>
                    <th colspan="2">Dados Atuais</th>
                    <th class="text-center">Foto</th>
                </tr>
                </thead>
                <tbody>
                <tr>
                    <td bgcolor="#D6D6D6" width="22%"><strong>N.º do CC:</strong></td>
                    <td><?php echo $row['cc']; ?></td>
                    <td rowspan="5" class="profile-photo-cell">
                        <img src="<?php echo $row['foto']; ?>" class="profile-photo" alt="Foto">
                    </td>
                </tr>
                <!-- Adicione mais linhas conforme necessário -->

                <tr>
                    <td bgcolor="#D6D6D6" width="22%"><strong>Número:</strong></td>
                    <td><?php echo substr($row['user'], 1); ?></td>
                </tr>
                <tr>
                    <td bgcolor="#D6D6D6" width="22%"><strong>Nome:</strong></td>
                    <td><?php echo $row['nome']; ?></td>
                </tr>
                <tr>
                    <td bgcolor="#D6D6D6" width="22%"><strong>Data Nascimento:</strong></td>
                    <td><?php echo $data_nas_formatada; ?></td>
                </tr>
                <!--<tr>
                    <td bgcolor="#D6D6D6" width="22%"><strong>Ano:</strong></td>
                    <td><?php echo $row['ano']; ?></td>
                </tr>
                <tr>
                    <td bgcolor="#D6D6D6" width="22%"><strong>Turma:</strong></td>
                    <td><?php echo $row['turma']; ?></td>
                </tr>
                <tr>
                    <td bgcolor="#D6D6D6" width="22%"><strong>Curso:</strong></td>
                    <td><?php echo $row['curso']; ?></td>
                </tr>
                <tr>
                    <td bgcolor="#D6D6D6" width="22%"><strong>Sexo:</strong></td>
                    <td><?php echo $row['sexo']; ?></td>
                </tr>

                <tr>
                    <td bgcolor="#D6D6D6" width="22%"><strong>Enc. Educação:</strong></td>
                    <td colspan="2"><?php echo $row['enc_educacao']; ?></td>
                </tr>

                <tr>
                    <td colspan="3" bgcolor=""></td>
                </tr>
                <tr>
                    <th colspan="3" class="thead-dark">Tutor do Aluno</th>
                </tr>
                <tr>
                    <td bgcolor="#D6D6D6" width="22%" valign="top"><strong>Nome:</strong></td>
                    <td colspan="2"><?php echo $row['tutor_nome']; ?></td>
                </tr>
                <tr>
                    <td bgcolor="#D6D6D6" width="22%" valign="top"><strong>e-Mail do Tutor:</strong></td>
                    <td colspan="2">
                        <a href="mailto:<?php echo $row['tutor_email']; ?>" target="_blank" style="color:orange;">
                            Clique aqui para contactar o Tutor.
                        </a>
                        (ou utilize o e-mail: <?php echo $row['tutor_email']; ?>)
                    </td>
                </tr> -->
                </tbody>
            </table>
            <!-- Fim da tabela adaptada -->
        </div>
    <?php

    }
    if ($_SESSION["type"] == 3) {
        include "header-direcao.php";

        ?>

        <div class="container mt-4">
            <!-- Início da tabela adaptada -->
            <table class="table table-bordered">
                <thead class="thead-dark">
                <tr>
                    <th colspan="2">Dados Atuais</th>
                    <th class="text-center">Foto</th>
                </tr>
                </thead>
                <tbody>
                <tr>
                    <td bgcolor="#D6D6D6" width="22%"><strong>N.º do CC:</strong></td>
                    <td><?php echo $row['cc']; ?></td>
                    <td rowspan="5" class="profile-photo-cell">
                        <img src="<?php echo $row['foto']; ?>" class="profile-photo" alt="Foto">
                    </td>
                </tr>
                <!-- Adicione mais linhas conforme necessário -->

                <tr>
                    <td bgcolor="#D6D6D6" width="22%"><strong>Número:</strong></td>
                    <td><?php echo substr($row['user'], 1); ?></td>
                </tr>
                <tr>
                    <td bgcolor="#D6D6D6" width="22%"><strong>Nome:</strong></td>
                    <td><?php echo $row['nome']; ?></td>
                </tr>
                <tr>
                    <td bgcolor="#D6D6D6" width="22%"><strong>Data Nascimento:</strong></td>
                    <td><?php echo $data_nas_formatada; ?></td>
                </tr>
                <!--<tr>
                    <td bgcolor="#D6D6D6" width="22%"><strong>Ano:</strong></td>
                    <td><?php echo $row['ano']; ?></td>
                </tr>
                <tr>
                    <td bgcolor="#D6D6D6" width="22%"><strong>Turma:</strong></td>
                    <td><?php echo $row['turma']; ?></td>
                </tr>
                <tr>
                    <td bgcolor="#D6D6D6" width="22%"><strong>Curso:</strong></td>
                    <td><?php echo $row['curso']; ?></td>
                </tr>
                <tr>
                    <td bgcolor="#D6D6D6" width="22%"><strong>Sexo:</strong></td>
                    <td><?php echo $row['sexo']; ?></td>
                </tr>

                <tr>
                    <td bgcolor="#D6D6D6" width="22%"><strong>Enc. Educação:</strong></td>
                    <td colspan="2"><?php echo $row['enc_educacao']; ?></td>
                </tr>

                <tr>
                    <td colspan="3" bgcolor=""></td>
                </tr>
                <tr>
                    <th colspan="3" class="thead-dark">Tutor do Aluno</th>
                </tr>
                <tr>
                    <td bgcolor="#D6D6D6" width="22%" valign="top"><strong>Nome:</strong></td>
                    <td colspan="2"><?php echo $row['tutor_nome']; ?></td>
                </tr>
                <tr>
                    <td bgcolor="#D6D6D6" width="22%" valign="top"><strong>e-Mail do Tutor:</strong></td>
                    <td colspan="2">
                        <a href="mailto:<?php echo $row['tutor_email']; ?>" target="_blank" style="color:orange;">
                            Clique aqui para contactar o Tutor.
                        </a>
                        (ou utilize o e-mail: <?php echo $row['tutor_email']; ?>)
                    </td>
                </tr> -->
                </tbody>
            </table>
            <!-- Fim da tabela adaptada -->
        </div>
    <?php

    }

        if ($_SESSION["type"] == 4) {
        include "header-professor-direcao.php";

        ?>

        <div class="container mt-4">
            <!-- Início da tabela adaptada -->
            <table class="table table-bordered">
                <thead class="thead-dark">
                <tr>
                    <th colspan="2">Dados Atuais</th>
                    <th class="text-center">Foto</th>
                </tr>
                </thead>
                <tbody>
                <tr>
                    <td bgcolor="#D6D6D6" width="22%"><strong>N.º do CC:</strong></td>
                    <td><?php echo $row['cc']; ?></td>
                    <td rowspan="5" class="profile-photo-cell">
                        <img src="<?php echo $row['foto']; ?>" class="profile-photo" alt="Foto">
                    </td>
                </tr>
                <!-- Adicione mais linhas conforme necessário -->

                <tr>
                    <td bgcolor="#D6D6D6" width="22%"><strong>Número:</strong></td>
                    <td><?php echo substr($row['user'], 1); ?></td>
                </tr>
                <tr>
                    <td bgcolor="#D6D6D6" width="22%"><strong>Nome:</strong></td>
                    <td><?php echo $row['nome']; ?></td>
                </tr>
                <tr>
                    <td bgcolor="#D6D6D6" width="22%"><strong>Data Nascimento:</strong></td>
                    <td><?php echo $data_nas_formatada; ?></td>
                </tr>
                <!--<tr>
                    <td bgcolor="#D6D6D6" width="22%"><strong>Ano:</strong></td>
                    <td><?php echo $row['ano']; ?></td>
                </tr>
                <tr>
                    <td bgcolor="#D6D6D6" width="22%"><strong>Turma:</strong></td>
                    <td><?php echo $row['turma']; ?></td>
                </tr>
                <tr>
                    <td bgcolor="#D6D6D6" width="22%"><strong>Curso:</strong></td>
                    <td><?php echo $row['curso']; ?></td>
                </tr>
                <tr>
                    <td bgcolor="#D6D6D6" width="22%"><strong>Sexo:</strong></td>
                    <td><?php echo $row['sexo']; ?></td>
                </tr>

                <tr>
                    <td bgcolor="#D6D6D6" width="22%"><strong>Enc. Educação:</strong></td>
                    <td colspan="2"><?php echo $row['enc_educacao']; ?></td>
                </tr>

                <tr>
                    <td colspan="3" bgcolor=""></td>
                </tr>
                <tr>
                    <th colspan="3" class="thead-dark">Tutor do Aluno</th>
                </tr>
                <tr>
                    <td bgcolor="#D6D6D6" width="22%" valign="top"><strong>Nome:</strong></td>
                    <td colspan="2"><?php echo $row['tutor_nome']; ?></td>
                </tr>
                <tr>
                    <td bgcolor="#D6D6D6" width="22%" valign="top"><strong>e-Mail do Tutor:</strong></td>
                    <td colspan="2">
                        <a href="mailto:<?php echo $row['tutor_email']; ?>" target="_blank" style="color:orange;">
                            Clique aqui para contactar o Tutor.
                        </a>
                        (ou utilize o e-mail: <?php echo $row['tutor_email']; ?>)
                    </td>
                </tr> -->
                </tbody>
            </table>
            <!-- Fim da tabela adaptada -->
        </div>
    <?php

    }
    ?>


    <?php
    include "footer-reservado.php";
    ?>

</body>

</html>
