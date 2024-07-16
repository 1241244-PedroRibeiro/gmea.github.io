<?php
session_start();
include "./generals/config.php";
$mysqli = new mysqli($bd_host, $bd_user, $bd_password, $bd_database);

if ($mysqli->connect_error) {
    die('Erro: (' . $mysqli->connect_errno . ') ' . $mysqli->connect_error);
}

$user = $_SESSION['username'];

// Consultar todas as aulas ordenadas pelo ID
$queryAulas = "SELECT id_aula, userOuTurma, cod_dis FROM aulas WHERE prof = '$user' ORDER BY id_aula";
$resultAulas = $mysqli->query($queryAulas);


// Processar o formulário de seleção de aula e lição
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $idAula = $_POST['id_aula'];

    // Consultar as lições desta aula
    $queryLicoes = "SELECT indice_aula FROM sumarios WHERE id_aula = $idAula ORDER BY indice_aula";
    $resultLicoes = $mysqli->query($queryLicoes);
}
?>

<!DOCTYPE html>
<html lang="pt">
<head>
    <meta charset="UTF-8">
    <title>Gestão de Agenda</title>
    <script src="https://use.fontawesome.com/releases/v6.3.0/js/all.js" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.3.1/jquery.min.js" crossorigin="anonymous"></script>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js"></script>
    <link href="https://netdna.bootstrapcdn.com/font-awesome/3.2.1/css/font-awesome.css" rel="stylesheet">
    <style>
        /* Estilos do calendário */
        body {
            font-family: Arial, Helvetica Neue, Helvetica, sans-serif;
            font-size: 14px;
        }

        /* Estilos para os cards */
        .custom-card {
            width: calc(33.33% - 20px); /* Ajusta a largura dos cards em telas maiores */
            margin-bottom: 20px; /* Espaço abaixo dos cards */
            padding: 15px;
            box-shadow: 0 4px 8px rgba(0,0,0,0.1);
            background-color: #fff;
        }

        @media (max-width: 992px) {
            .custom-card {
                width: calc(50% - 20px); /* Ajusta a largura dos cards em telas médias */
            }
        }

        @media (max-width: 576px) {
            .custom-card {
                width: 100%; /* Cards ocupam 100% da largura em telas menores */
            }
        }


        .card-img-top {
            max-width: 100%;
            height: auto;
        }
    </style>
</head>
<body>

    <!-- Banner -->
    <div style="margin-top: 0;">
        <img style="width: 100%; height: auto;" src="./media/topAR.png" class="img-responsive">
    </div>

    <!-- Header -->
    <?php
        if ($_SESSION["type"] == 2) {
            include "header-profs.php";
        }
        if ($_SESSION["type"] == 3) {
            include "header-direcao.php";
        }
        if ($_SESSION["type"] == 4) { // Mostrar cabeçalho para professores
            include "header-professor-direcao.php";
        } 

    ?>
    <div class="container mt-5">
        <h2>Editar Sumário</h2>
        <form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
            <div class="mb-3">
                <label for="id_aula" class="form-label">Selecione a Aula:</label>
                <select class="form-select" id="id_aula" name="id_aula" onchange="this.form.submit()">
                    <option value="">Selecione...</option>
                    <?php
                    if ($resultAulas && $resultAulas->num_rows > 0) {
                        while ($rowAula = $resultAulas->fetch_assoc()) {
                            // Obter nome do aluno/turma ou nome da disciplina
                            $nomeAlunoTurma = '';
                            $cod_dis = $rowAula['cod_dis'];

                            if (substr($rowAula['userOuTurma'], 0, 1) === 'a') {
                                // É um aluno, obter nome do aluno da tabela 'users1'
                                $queryNomeAluno = "SELECT nome FROM users1 WHERE user = '{$rowAula['userOuTurma']}'";
                                $resultNomeAluno = $mysqli->query($queryNomeAluno);

                                if ($resultNomeAluno && $resultNomeAluno->num_rows > 0) {
                                    $nomeAlunoTurma = $resultNomeAluno->fetch_assoc()['nome'];
                                }
                            } elseif (substr($rowAula['userOuTurma'], 0, 1) === 't') {
                                // É uma turma, obter nome da turma da tabela 'turmas'
                                $queryNomeTurma = "SELECT nome_turma FROM turmas WHERE cod_turma = '{$rowAula['userOuTurma']}'";
                                $resultNomeTurma = $mysqli->query($queryNomeTurma);

                                if ($resultNomeTurma && $resultNomeTurma->num_rows > 0) {
                                    $nomeAlunoTurma = $resultNomeTurma->fetch_assoc()['nome_turma'];
                                }
                            }

                            // Obter nome da disciplina da tabela 'cod_dis'
                            $queryNomeDis = "SELECT nome_dis FROM cod_dis WHERE cod_dis = '{$rowAula['cod_dis']}'";
                            $resultNomeDis = $mysqli->query($queryNomeDis);

                            $nomeDisciplina = ($resultNomeDis && $resultNomeDis->num_rows > 0) ? $resultNomeDis->fetch_assoc()['nome_dis'] : '';

                            echo "<option value='{$rowAula['id_aula']}'>{$rowAula['id_aula']} - {$nomeAlunoTurma} ({$nomeDisciplina})</option>";
                        }
                    }
                    ?>
                </select>
            </div>
        </form>

        <?php if (isset($idAula) && $idAula != "") { ?>
            <form method="post" action="editar_sumario_process.php">
                <div class="mb-3">
                    <label for="indice_aula" class="form-label">Selecione a Lição:</label>
                    <select class="form-select" id="indice_aula" name="indice_aula">
                        <option value="">Selecione...</option>
                        <?php
                        if ($resultLicoes && $resultLicoes->num_rows > 0) {
                            while ($rowLicao = $resultLicoes->fetch_assoc()) {
                                echo "<option value='{$rowLicao['indice_aula']}'>Lição {$rowLicao['indice_aula']}</option>";
                            }
                        }
                        ?>
                    </select>
                </div>
                <input type="hidden" name="id_aula" value="<?php echo $idAula; ?>">
                <button type="submit" class="btn btn-primary">Editar Sumário</button>
            </form>
        <?php } ?>
    </div>

</body>
</html>

<?php 
$sucesso = isset($_GET['sucesso']) && $_GET['sucesso'] == 'true';

// Exibir mensagem de sucesso se necessário
if ($sucesso) {
    echo "<div class='container alert alert-success' role='alert'>";
    echo "O sumário foi atualizado com sucesso!";
    echo "</div>";
}
?>

<?php include 'footer-reservado.php'; ?>