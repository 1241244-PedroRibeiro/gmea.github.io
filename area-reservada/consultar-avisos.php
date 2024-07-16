<?php
session_start();
require_once("generals/config.php");

$mysqli = new mysqli($bd_host, $bd_user, $bd_password, $bd_database);

if ($mysqli->connect_error) {
    die('Erro: (' . $mysqli->connect_errno . ') ' . $mysqli->connect_error);
}

if (empty($_SESSION["session_id"])) {
    header("Location: ../index.php");
    exit;
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Consulta de Avisos - GMEA</title>
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
    if ($_SESSION["type"] == 1) {
        include "header-alunos.php";
    }
    if ($_SESSION["type"] == 2) {
        include "header-profs.php";
    }
    if ($_SESSION["type"] == 3) {
        include "header-direcao.php";
    }
    if ($_SESSION["type"] == 4) {
        include "header-professor-direcao.php";
    }
    ?>

    <div class="container mt-4">
        <h2>Consulta de Avisos</h2>

        <?php
        $currentDate = date("Y-m-d");
        // Obtém o tipo de utilizador
        $userType = $_SESSION["type"];
        // Obtém o nome de utilizador
        $username = $_SESSION["username"];

        // Consulta para obter todos os avisos com base no tipo de utilizador
        if ($userType >= 3) {
            // Utilizador da direção - Mostra todos os avisos
            $query = "SELECT * FROM avisos WHERE data_fim >= '$currentDate'";
        } elseif ($userType == 2) {
            // Professor - Mostra avisos para todos, para professores e os próprios
            $query = "SELECT * FROM avisos WHERE data_fim >= '$currentDate' AND (destino = 'Todos' OR destino = 'Professores' OR criador = '$username')";
        } elseif ($userType == 1) {
            // Aluno - Mostra avisos para alunos, turmas e professores associados
            $query = "SELECT * FROM avisos WHERE data_fim >= '$currentDate' AND (";

            $query .= "(destino = 'Todos')";

            // Verificar o destino 'Alunos'
            $query .= "OR (destino = 'Alunos' AND '$username' IN (SELECT user FROM alunos WHERE user = '$username'))";

            // Verificar o destino 'turmas_t031'
            $query .= " OR (destino LIKE 'turmas_%' AND '$username' IN (SELECT user FROM turmas_alunos WHERE cod_turma = SUBSTRING(destino, 8)))";

            // Verificar o destino 'turmas_gerais_tg004'
            $query .= " OR (destino LIKE 'turmas_gerais_%' AND '$username' IN (SELECT user FROM alunos WHERE turma = SUBSTRING(destino, 15)))";

            // Verificar o destino 'alunos_professor_p110'
            $query .= " OR (destino LIKE 'alunos_professor_%' AND '$username' IN (SELECT user FROM alunos WHERE prof_in1 = SUBSTRING(destino, 18) OR prof_in2 = SUBSTRING(destino, 18)))";

            $query .= ")";
        }

            // Executar a consulta e obter os resultados
            $result = $mysqli->query($query);
            

            // Verificar se foram encontrados avisos
            if ($result->num_rows > 0) {
                // Arrays para armazenar avisos urgentes e normais
                $urgentAvisos = [];
                $normalAvisos = [];

                while ($row = $result->fetch_assoc()) {
                    // Define a classe da div com base no tipo de aviso
                    $alertClass = ($row['tipo_aviso'] == 2) ? 'alert-danger' : 'alert-warning';

                    // Consulta para obter o nome do criador
                    $queryNomeCriador = "SELECT nome FROM users1 WHERE user = '{$row['criador']}'";
                    $resultNomeCriador = $mysqli->query($queryNomeCriador);
                    $rowNomeCriador = $resultNomeCriador->fetch_assoc();
                    $nomeCriador = $rowNomeCriador['nome'];

                    // Adiciona o aviso ao array correspondente
                    if ($row['tipo_aviso'] == 2) {
                        $urgentAvisos[] = ['row' => $row, 'nomeCriador' => $nomeCriador];
                    } else {
                        $normalAvisos[] = ['row' => $row, 'nomeCriador' => $nomeCriador];
                    }
                }

                // Exibe primeiro os avisos urgentes
                foreach ($urgentAvisos as $avisos) {
                    $row = $avisos['row'];
                    $nomeCriador = $avisos['nomeCriador'];

                    echo "<div class='alert alert-danger'>";
                    echo "<strong>{$row['titulo']}</strong><br>";
                    echo "{$row['texto']}<br>";
                    echo "<small>Adicionado por: {$nomeCriador} | Destino: {$row['destino']} | Data Início: {$row['data_inicio']} | Data Fim: {$row['data_fim']}</small>";
                    echo "</div>";
                }

                // Em seguida, exibe os avisos normais
                foreach ($normalAvisos as $avisos) {
                    $row = $avisos['row'];
                    $nomeCriador = $avisos['nomeCriador'];

                    echo "<div class='alert alert-warning'>";
                    echo "<strong>{$row['titulo']}</strong><br>";
                    echo "{$row['texto']}<br>";
                    echo "<small>Adicionado por: {$nomeCriador} | Destino: {$row['destino']} | Data Início: {$row['data_inicio']} | Data Fim: {$row['data_fim']}</small>";
                    echo "</div>";
                }
            } else {
                // Caso nenhum aviso seja encontrado, exibe uma mensagem de sucesso
                echo "<div class='alert alert-success'>Não foram encontrados avisos.</div>";
            }
        ?>

    </div>

    <?php
    // Incluir o rodapé comum
    include "footer-reservado.php";
    ?>
</body>

</html>
