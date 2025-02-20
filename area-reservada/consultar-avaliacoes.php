<?php
session_start();
include "./generals/config.php";
$mysqli = new mysqli($bd_host, $bd_user, $bd_password, $bd_database);

if ($mysqli->connect_error) {
    die('Erro: (' . $mysqli->connect_errno . ') ' . $mysqli->connect_error);
}

$username = $_SESSION["username"];

// Função para obter o nome da disciplina com base no cod_dis
function getNomeDisciplina($mysqli, $cod_dis) {
    $query = "SELECT nome_dis FROM cod_dis WHERE cod_dis = '$cod_dis'";
    $result = $mysqli->query($query);
    if ($result && $result->num_rows > 0) {
        $row = $result->fetch_assoc();
        return $row['nome_dis'];
    }
    return "Disciplina não encontrada";
}

// Obter disciplinas do aluno através da tabela 'aulas'
$disciplinas = array();

// Consulta para obter disciplinas por 'userOuTurma' correspondente ao aluno
$queryAulas = "SELECT cod_dis FROM aulas WHERE userOuTurma = '$username'";
$resultAulas = $mysqli->query($queryAulas);

if ($resultAulas && $resultAulas->num_rows > 0) {
    while ($row = $resultAulas->fetch_assoc()) {
        $cod_dis = $row['cod_dis'];
        $nome_disciplina = getNomeDisciplina($mysqli, $cod_dis);
        $disciplinas[$cod_dis] = $nome_disciplina;
    }
}

// Obter disciplinas do aluno através da tabela 'turmas_alunos'
$queryTurmas = "SELECT cod_turma FROM turmas_alunos WHERE user = '$username'";
$resultTurmas = $mysqli->query($queryTurmas);

if ($resultTurmas && $resultTurmas->num_rows > 0) {
    while ($row = $resultTurmas->fetch_assoc()) {
        $cod_turma = $row['cod_turma'];
        // Consulta para obter 'cod_dis' correspondente à turma do aluno
        $queryTurmaAulas = "SELECT cod_dis FROM aulas WHERE userOuTurma = '$cod_turma'";
        $resultTurmaAulas = $mysqli->query($queryTurmaAulas);

        if ($resultTurmaAulas && $resultTurmaAulas->num_rows > 0) {
            while ($rowDis = $resultTurmaAulas->fetch_assoc()) {
                $cod_dis = $rowDis['cod_dis'];
                $nome_disciplina = getNomeDisciplina($mysqli, $cod_dis);
                $disciplinas[$cod_dis] = $nome_disciplina;
            }
        }
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

        .green-label {
            background-color: green;
            color: white;
            padding: 5px;
            border-radius: 5px;
            display: inline-flex; /* Altera para flex */
            justify-content: center; /* Centraliza horizontalmente */
            align-items: center; /* Centraliza verticalmente */
            text-align: center; /* Centraliza o texto horizontalmente */
        }

        .blue-label {
            background-color: blue;
            color: white;
            padding: 5px;
            border-radius: 5px;
            display: inline-flex; /* Altera para flex */
            justify-content: center; /* Centraliza horizontalmente */
            align-items: center; /* Centraliza verticalmente */
            text-align: center; /* Centraliza o texto horizontalmente */
        }

    .schedule {
        display: grid;
        grid-template-columns: repeat(8, 1fr);
        grid-template-rows: 50px; /* Apenas uma linha para os cabeçalhos */
        gap: 1px;
        background-color: #f3f3f3;
        position: relative;
        overflow: hidden;
    }

    /* Reduzindo a altura dos blocos de hora */
    .schedule div {
        border: 1px solid #ddd;
        padding: 3px; /* Reduzindo ainda mais o preenchimento */
        text-align: center;
    }

    .mini-block {
        background-color: #d4d4d4;
        border: 1px solid #bbb;
        border-top: none;
        height: 10px; /* Reduzindo a altura dos mini-blocos */
        width: 100%;
    }

        .mini-block-aula {
            background-color: #b3e6ff; /* Azul claro */
        }

        .mini-block-aula-start {
            border-top-left-radius: 5px;
            border-bottom-left-radius: 5px;
            background-color: #b3e6ff; /* Azul claro */
        }

        .mini-block-aula-end {
            border-top-right-radius: 5px;
            border-bottom-right-radius: 5px;
            background-color: #b3e6ff; /* Azul claro */
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
    }
?>

<div class="container mt-4">
    <h2>Avaliações por Disciplina</h2>

    <?php if (count($disciplinas) > 0): ?>
        <?php foreach ($disciplinas as $cod_dis => $nome_disciplina): ?>
            <div class="table-responsive">
                <table class="table table-bordered">
                    <thead>
                        <tr>
                            <td colspan="7" class="subtitulonoticias" style="background-color:#999; color:#FFF"><b><?php echo $nome_disciplina; ?></b></td>
                        </tr>
                        <tr class="textonoticias" style="background-color: #CCC">
                            <td width="14%"><strong>Data da avaliação</strong></td>
                            <td width="15%"><strong>Tipo</strong></td>
                            <td width="5%"><strong>Escala</strong></td>
                            <td width="10%"><strong>Nível</strong></td>
                            <td width="21%"><strong>Observações</strong></td>
                            <td width="20%"><strong>Professor</strong></td>
                            <td width="15%"><strong>Data de disponibilização</strong></td>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        // Consulta para obter as avaliações do aluno por disciplina
                        $queryAvaliacoes = "SELECT * FROM avaliacoes WHERE user = '$username' AND disciplina = '$cod_dis'";
                        $resultAvaliacoes = $mysqli->query($queryAvaliacoes);

                        if ($resultAvaliacoes && $resultAvaliacoes->num_rows > 0) {
                            while ($rowAvaliacao = $resultAvaliacoes->fetch_assoc()) {
                                echo '<tr>';
                                echo '<td>' . date('d/m/Y', strtotime($rowAvaliacao['data_avaliacao'])) . '</td>';
                                echo '<td>' . ($rowAvaliacao['tipo_avaliacao'] == 1 ? "Avaliação Intercalar" :
                                              ($rowAvaliacao['tipo_avaliacao'] == 2 ? "Prova" :
                                               ($rowAvaliacao['tipo_avaliacao'] == 3 ? "Trabalho" : "Outro"))) . '</td>';
                                echo '<td>' . ($rowAvaliacao['escala'] == 1 ? "5" :
                                               ($rowAvaliacao['escala'] == 2 ? "100" : "200")) . '</td>';
                                echo '<td> <b>';
                                if ($rowAvaliacao['escala'] == 1) {
                                    switch ($rowAvaliacao['nivel']) {
                                        case 0:
                                        case 1:
                                            echo "Fraco";
                                            break;
                                        case 2:
                                            echo "Insuficiente";
                                            break;
                                        case 3:
                                            echo "Suficiente";
                                            break;
                                        case 4:
                                            echo "Bom";
                                            break;
                                        case 5:
                                            echo "Muito Bom";
                                            break;
                                        default:
                                            echo "";
                                            break;
                                    }
                                } else {
                                    echo $rowAvaliacao['nivel'];
                                }
                                echo '</b></td>';
                                echo '<td>' . $rowAvaliacao['notas'] . '</td>';
                                echo '<td>';
                                $professor = $rowAvaliacao['prof'];
                                $queryProfessor = "SELECT nome FROM users1 WHERE user = '$professor'";
                                $resultProfessor = $mysqli->query($queryProfessor);
                                if ($resultProfessor && $resultProfessor->num_rows > 0) {
                                    $rowProfessor = $resultProfessor->fetch_assoc();
                                    echo '(' . $professor . ') ' . $rowProfessor['nome'];
                                }
                                echo '</td>';
                                echo '<td>' . date('d/m/Y', strtotime($rowAvaliacao['data_inserido'])) . '</td>';
                                echo '</tr>';
                            }
                        } else {
                            echo '<tr><td colspan="7" class="sem-registros"><i>Sem registos encontrados.</i></td></tr>';
                        }
                        ?>
                    </tbody>
                </table>
            </div>
        <?php endforeach; ?>
    <?php else: ?>
        <p class="sem-registros">Sem disciplinas disponíveis.</p>
    <?php endif; ?>

</div>

</body>
</html>

<?php
$mysqli->close();
include 'footer-reservado.php';
?>