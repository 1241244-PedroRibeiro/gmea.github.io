<?php
session_start();
include "./generals/config.php";
$mysqli = new mysqli($bd_host, $bd_user, $bd_password, $bd_database);

if ($mysqli->connect_error) {
    die('Erro: (' . $mysqli->connect_errno . ') ' . $mysqli->connect_error);
}

$username = $_SESSION["username"];

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
    <h2>Consulta de Pautas</h2>
    <form id="consultaForm" action="<?php echo $_SERVER['PHP_SELF']; ?>" method="post">
        <div class="form-group">
            <label for="tipoAvaliacao">Selecionar Tipo de Avaliação:</label>
            <select id="tipoAvaliacao" name="tipo_avaliacao" class="form-control" required>
                <option value="">Selecionar Tipo de Avaliação</option>
                <option value="1">Avaliação Intercalar - Primeiro Semestre</option>
                <option value="2">Avaliação Intercalar - Segundo Semestre</option>
                <option value="3">Avaliação - Primeiro Semestre</option>
                <option value="4">Avaliação - Segundo Semestre</option>
            </select>
        </div>
        <br>
        <button type="submit" class="btn btn-primary">Consultar</button>
    </form>
</div>

</body>
</html>

<?php

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['tipo_avaliacao'])) {
        $tipoAvaliacao = $_POST['tipo_avaliacao'];

        if ($tipoAvaliacao == 1 || $tipoAvaliacao == 2) {
            // Avaliação Intercalar - Primeiro ou Segundo Semestre
            $semestre = ($tipoAvaliacao == 1) ? 1 : 2;
            $table = 'pautas_avaliacao_intercalar';

            // Consultar os dados de Instrumentos
            $queryInstrumentos = "SELECT cod_in1, cod_in2 FROM alunos WHERE user = '$username'";
            $resultInstrumentos = $mysqli->query($queryInstrumentos);
            
            // Consultar pautas conforme o semestre e tipo de avaliação
            $query = "SELECT id_pauta, disciplina, semestre, estado, user, notas, par1, par2, par3 FROM $table WHERE semestre = $semestre AND estado = 1 AND user = '$username'";
            $result = $mysqli->query($query);

            echo '<div class="container mt-4">';
            echo '<div class="border p-3 mb-3">';
            echo '<h4>Instrumento(s)</h4>'; // Título para seção de Instrumentos
            if ($resultInstrumentos && $resultInstrumentos->num_rows > 0) {
                while ($rowInstrumentos = $resultInstrumentos->fetch_assoc()) {
                    echo '<div class="border p-3 mb-3">';
                    echo '<h5 style="background-color:#E6E6E6">1º Instrumento (';
                    $cod_in1 = $rowInstrumentos['cod_in1'];
                    $nome_in1 = ($cod_in1 != 0) ? getDisciplinaNome($cod_in1, $mysqli) : 'Não Aplicável';
                    echo $nome_in1 . ')</h5>';
                    // Consultar pautas conforme o semestre e tipo de avaliação
                    $query = "SELECT id_pauta, disciplina, semestre, estado, user, notas, par1, par2, par3 FROM $table WHERE semestre = $semestre AND estado = 1 AND user = '$username' AND disciplina = '$cod_in1'";
                    $result = $mysqli->query($query);
                    if ($result && $result->num_rows > 0) {
                        while ($row = $result->fetch_assoc()) {
                            echo '<p><strong>Aproveitamento:</strong> ' . getNivelAproveitamento($row['par1']) . '</p>';
                            echo '<p><strong>Atitudes e Valores:</strong> ' . getNivelAtitudes($row['par2']) . '</p>';
                            echo '<p><strong>Empenho e Cumprimento de Tarefas:</strong> ' . getNivelEmpenho($row['par3']) . '</p>';
                            echo '<p><strong>Observações:</strong> ' . $row['notas'] . '</p>';
                        }
                    }
                    else {
                        echo '<div class="container alert alert-warning mt-4"><i>Não foi encontrado nenhum registo.</i></div>';
                    }
                    echo '</div>';

                    echo '<div class="border p-3 mb-3">';
                    echo '<h5 style="background-color:#E6E6E6">2º Instrumento (';
                    $cod_in2 = $rowInstrumentos['cod_in2'];
                    $nome_in2 = ($cod_in2 != 0) ? getDisciplinaNome($cod_in2, $mysqli) : 'Não Aplicável';
                    echo $nome_in2 . ')</h5>';
                    // Consultar pautas conforme o semestre e tipo de avaliação
                    $query = "SELECT id_pauta, disciplina, semestre, estado, user, notas, par1, par2, par3 FROM $table WHERE semestre = $semestre AND estado = 1 AND user = '$username' AND disciplina = '$cod_in2'";
                    $result = $mysqli->query($query);
                    if ($result && $result->num_rows > 0) {
                        while ($row = $result->fetch_assoc()) {
                            echo '<div class="border p-3 mb-3" style="width: 65%;">';
                            echo '<p><strong>Aproveitamento:</strong> ' . getNivelAproveitamento($row['par1']) . '</p>';
                            echo '<p><strong>Atitudes e Valores:</strong> ' . getNivelAtitudes($row['par2']) . '</p>';
                            echo '<p><strong>Empenho e Cumprimento de Tarefas:</strong> ' . getNivelEmpenho($row['par3']) . '</p>';
                            echo '<p><strong>Observações:</strong> ' . $row['notas'] . '</p>';
                            echo '</div>';

                        }
                    }
                    else {
                        echo '<div class="container alert alert-warning mt-4"><i>Não foi encontrado nenhum registo.</i></div>';
                    }
                }
                echo '</div>';
            }
            echo '</div>';
            echo '</div>';

            // Consultar dados de Formação Musical
            $queryFM = "SELECT cod_fm FROM alunos WHERE user = '$username'";
            $resultFM = $mysqli->query($queryFM);
            echo '<div class="container mt-4">';
            echo '<div class="border p-3 mb-3">';
            if ($resultFM && $resultFM->num_rows > 0) {
                $rowFM = $resultFM->fetch_assoc();
                $cod_fm = $rowFM['cod_fm'];
                $nome_fm = ($cod_fm != 0) ? getDisciplinaNome($cod_fm, $mysqli) : 'Não Aplicável';
                echo '<h4 style="background-color:#E6E6E6">' . $nome_fm . '</h4>';
                // Consultar pautas conforme o semestre e tipo de avaliação
                $query = "SELECT id_pauta, disciplina, semestre, estado, user, notas, par1, par2, par3 FROM $table WHERE semestre = $semestre AND estado = 1 AND user = '$username' AND disciplina = '$cod_fm'";
                $result = $mysqli->query($query);
                if ($result && $result->num_rows > 0) {
                    while ($row = $result->fetch_assoc()) {
                        echo '<p><strong>Aproveitamento:</strong> ' . getNivelAproveitamento($row['par1']) . '</p>';
                        echo '<p><strong>Atitudes e Valores:</strong> ' . getNivelAtitudes($row['par2']) . '</p>';
                        echo '<p><strong>Empenho e Cumprimento de Tarefas:</strong> ' . getNivelEmpenho($row['par3']) . '</p>';
                        echo '<p><strong>Observações:</strong> ' . $row['notas'] . '</p>';
                    }
                }
                else {
                    echo '<div class="container alert alert-warning mt-4"><i>Não foi encontrado nenhum registo.</i></div>';
                }
                echo '</div>';
            }
            echo '</div>';
            echo '</div>';

            // Consultar dados de Classes de Conjunto (Coro e Orquestra)
            $queryCoro = "SELECT cod_coro FROM alunos WHERE user = '$username'";
            $resultCoro = $mysqli->query($queryCoro);
            echo '<div class="container mt-4">';
            echo '<div class="border p-3 mb-3">';
            echo '<h4 style="background-color:#E6E6E6">Classe de Conjunto</h4>'; // Título para seção de Classe de Conjunto
            if ($resultCoro && $resultCoro->num_rows > 0) {
                $rowCoro = $resultCoro->fetch_assoc();
                $cod_coro = $rowCoro['cod_coro'];
                $nome_coro = ($cod_coro != 0) ? getDisciplinaNome($cod_coro, $mysqli) : 'Não Aplicável';
                echo '<div class="border p-3 mb-3">';
                echo '<h5 style="background-color:#E6E6E6">Coro (';
                echo $nome_coro . ')</h5>';
                // Consultar pautas conforme o semestre e tipo de avaliação
                $query = "SELECT id_pauta, disciplina, semestre, estado, user, notas, par1, par2, par3 FROM $table WHERE semestre = $semestre AND estado = 1 AND user = '$username' AND disciplina = '$cod_coro'";
                $result = $mysqli->query($query);
                if ($result && $result->num_rows > 0) {
                    while ($row = $result->fetch_assoc()) {
                        echo '<p><strong>Aproveitamento:</strong> ' . getNivelAproveitamento($row['par1']) . '</p>';
                        echo '<p><strong>Atitudes e Valores:</strong> ' . getNivelAtitudes($row['par2']) . '</p>';
                        echo '<p><strong>Empenho e Cumprimento de Tarefas:</strong> ' . getNivelEmpenho($row['par3']) . '</p>';
                        echo '<p><strong>Observações:</strong> ' . $row['notas'] . '</p>';
                    }
                }
                else {
                    echo '<div class="container alert alert-warning mt-4"><i>Não foi encontrado nenhum registo.</i></div>';
                }
                echo '</div>';
            }

            $queryOrquestra = "SELECT cod_orq FROM alunos WHERE user = '$username'";
            $resultOrquestra = $mysqli->query($queryOrquestra);
            if ($resultOrquestra && $resultOrquestra->num_rows > 0) {
                $rowOrquestra = $resultOrquestra->fetch_assoc();
                $cod_orq = $rowOrquestra['cod_orq'];
                $nome_orq = ($cod_orq != 0) ? getDisciplinaNome($cod_orq, $mysqli) : 'Não Aplicável';
                echo '<div class="border p-3 mb-3">';
                echo '<h5 style="background-color:#E6E6E6">Orquestra (';
                echo $nome_orq . ')</h5>';
                // Consultar pautas conforme o semestre e tipo de avaliação
                $query = "SELECT id_pauta, disciplina, semestre, estado, user, notas, par1, par2, par3 FROM $table WHERE semestre = $semestre AND estado = 1 AND user = '$username' AND disciplina = '$cod_orq'";
                $result = $mysqli->query($query);
                if ($result && $result->num_rows > 0) {
                    while ($row = $result->fetch_assoc()) {
                        echo '<p><strong>Aproveitamento:</strong> ' . getNivelAproveitamento($row['par1']) . '</p>';
                        echo '<p><strong>Atitudes e Valores:</strong> ' . getNivelAtitudes($row['par2']) . '</p>';
                        echo '<p><strong>Empenho e Cumprimento de Tarefas:</strong> ' . getNivelEmpenho($row['par3']) . '</p>';
                        echo '<p><strong>Observações:</strong> ' . $row['notas'] . '</p>';
                    }
                }
                else {
                    echo '<div class="container alert alert-warning mt-4"><i>Não foi encontrado nenhum registo.</i></div>';
                }
                echo '</div>';
            }
            echo '</div>';
            echo '</div>';

        } elseif ($tipoAvaliacao == 3 || $tipoAvaliacao == 4) {
            // Avaliação - Primeiro ou Segundo Semestre
            $semestre = ($tipoAvaliacao == 3) ? 3 : 4;
            $table = 'pautas_avaliacao';

            // Consultar os dados de Instrumentos
            $queryInstrumentos = "SELECT cod_in1, cod_in2 FROM alunos WHERE user = '$username'";
            $resultInstrumentos = $mysqli->query($queryInstrumentos);
            
            // Consultar pautas conforme o semestre e tipo de avaliação
            $query = "SELECT id_pauta, disciplina, semestre, estado, user, notas, par1, par2, par3 FROM $table WHERE semestre = $semestre AND estado = 1 AND user = '$username'";
            $result = $mysqli->query($query);

            echo '<div class="container mt-4">';
            echo '<div class="border p-3 mb-3">';
            echo '<h4>Instrumento(s)</h4>'; // Título para seção de Instrumentos
            if ($resultInstrumentos && $resultInstrumentos->num_rows > 0) {
                while ($rowInstrumentos = $resultInstrumentos->fetch_assoc()) {
                    echo '<div class="border p-3 mb-3">';
                    echo '<h5 style="background-color:#E6E6E6">1º Instrumento (';
                    $cod_in1 = $rowInstrumentos['cod_in1'];
                    $nome_in1 = ($cod_in1 != 0) ? getDisciplinaNome($cod_in1, $mysqli) : 'Não Aplicável';
                    echo $nome_in1 . ')</h5>';
                    // Consultar pautas conforme o semestre e tipo de avaliação
                    $query = "SELECT id_pauta, disciplina, semestre, estado, user, notas, par1, par2, par3, nivel FROM $table WHERE semestre = $semestre AND estado = 1 AND user = '$username' AND disciplina = '$cod_in1'";
                    $result = $mysqli->query($query);
                    $queryFaltas = "SELECT tipo_falta FROM faltas WHERE user = '$username' AND cod_dis = '$cod_in1'";
                    $resultFaltas = $mysqli->query($queryFaltas);
                    $fi = 0;
                    $fj = 0;
                    if ($result && $result->num_rows > 0) {
                        while ($row = $result->fetch_assoc()) {
                            echo '<div class="border p-3 mb-3">';
                            echo '<p><strong>Aproveitamento:</strong> ' . getNivelAproveitamento($row['par1']) . '</p>';
                            echo '<p><strong>Atitudes e Valores:</strong> ' . getNivelAtitudes($row['par2']) . '</p>';
                            echo '<p><strong>Empenho e Cumprimento de Tarefas:</strong> ' . getNivelEmpenho($row['par3']) . '</p>';
                            echo '<p><strong>Observações:</strong> ' . $row['notas'] . '</p>';
                            
                            // Inicializa variáveis FI e FJ
                            $fi = 0;
                            $fj = 0;
                            
                            // Verifica se há resultados de faltas
                            if ($resultFaltas && $resultFaltas->num_rows > 0) {
                                // Conta os tipos de faltas
                                while ($rowFaltas = $resultFaltas->fetch_assoc()) {
                                    if ($rowFaltas['tipo_falta'] == 1) {
                                        $fj += 1;
                                    } elseif ($rowFaltas['tipo_falta'] == 2) {
                                        $fi += 1;
                                    }
                                }
                            }
                            

                            echo '<table class="table table-bordered">';
                            echo '<thead class="table-light">';
                            echo '<tr>';
                            echo '<th scope="col">Nível</th>';
                            echo '<th scope="col">Faltas Injustificadas</th>';
                            echo '<th scope="col">Faltas Justificadas</th>';
                            echo '</tr>';
                            echo '</thead>';
                            echo '<tbody>';
                            echo '<tr>';
                            echo '<td>' . $row['nivel'] . '</td>';
                            echo '<td>' . $fi . '</td>'; // Valor de FI
                            echo '<td>' . $fj . '</td>'; // Valor de FJ
                            echo '</tr>';
                            echo '</tbody>';
                            echo '</table>';

                            
                        }
                    }
                    else {
                        echo '<div class="container alert alert-warning mt-4"><i>Não foi encontrado nenhum registo.</i></div>';
                    }

                    echo '</div>';

                    echo '<div class="border p-3 mb-3">';
                    echo '<h5 style="background-color:#E6E6E6">2º Instrumento (';
                    $cod_in2 = $rowInstrumentos['cod_in2'];
                    $nome_in2 = ($cod_in2 != 0) ? getDisciplinaNome($cod_in2, $mysqli) : 'Não Aplicável';
                    echo $nome_in2 . ')</h5>';
                    // Consultar pautas conforme o semestre e tipo de avaliação
                    $query = "SELECT id_pauta, disciplina, semestre, estado, user, notas, par1, par2, par3, nivel FROM $table WHERE semestre = $semestre AND estado = 1 AND user = '$username' AND disciplina = '$cod_in2'";
                    $result = $mysqli->query($query);
                    $queryFaltas = "SELECT tipo_falta FROM faltas WHERE user = '$username' AND cod_dis = '$cod_in2'";
                    $resultFaltas = $mysqli->query($queryFaltas);
                    $fi = 0;
                    $fj = 0;
                    if ($result && $result->num_rows > 0) {
                        while ($row = $result->fetch_assoc()) {
                            echo '<div class="border p-3 mb-3">';
                            echo '<p><strong>Aproveitamento:</strong> ' . getNivelAproveitamento($row['par1']) . '</p>';
                            echo '<p><strong>Atitudes e Valores:</strong> ' . getNivelAtitudes($row['par2']) . '</p>';
                            echo '<p><strong>Empenho e Cumprimento de Tarefas:</strong> ' . getNivelEmpenho($row['par3']) . '</p>';
                            echo '<p><strong>Observações:</strong> ' . $row['notas'] . '</p>';
                            
                            // Inicializa variáveis FI e FJ
                            $fi = 0;
                            $fj = 0;
                            
                            // Verifica se há resultados de faltas
                            if ($resultFaltas && $resultFaltas->num_rows > 0) {
                                // Conta os tipos de faltas
                                while ($rowFaltas = $resultFaltas->fetch_assoc()) {
                                    if ($rowFaltas['tipo_falta'] == 1) {
                                        $fj += 1;
                                    } elseif ($rowFaltas['tipo_falta'] == 2) {
                                        $fi += 1;
                                    }
                                }
                            }
                            

                            echo '<table class="table table-bordered">';
                            echo '<thead class="table-light">';
                            echo '<tr>';
                            echo '<th scope="col">Nível</th>';
                            echo '<th scope="col">Faltas Injustificadas</th>';
                            echo '<th scope="col">Faltas Justificadas</th>';
                            echo '</tr>';
                            echo '</thead>';
                            echo '<tbody>';
                            echo '<tr>';
                            echo '<td>' . $row['nivel'] . '</td>';
                            echo '<td>' . $fi . '</td>'; // Valor de FI
                            echo '<td>' . $fj . '</td>'; // Valor de FJ
                            echo '</tr>';
                            echo '</tbody>';
                            echo '</table>';

                            
                        }
                    }
                    else {
                        echo '<div class="container alert alert-warning mt-4"><i>Não foi encontrado nenhum registo.</i></div>';
                    }
                }
                echo '</div>';
            }
            echo '</div>';
            echo '</div>';

            // Consultar dados de Formação Musical
            $queryFM = "SELECT cod_fm FROM alunos WHERE user = '$username'";
            $resultFM = $mysqli->query($queryFM);
            echo '<div class="container mt-4">';
            echo '<div class="border p-3 mb-3">';
            if ($resultFM && $resultFM->num_rows > 0) {
                $rowFM = $resultFM->fetch_assoc();
                $cod_fm = $rowFM['cod_fm'];
                $nome_fm = ($cod_fm != 0) ? getDisciplinaNome($cod_fm, $mysqli) : 'Não Aplicável';
                echo '<h4 style="background-color:#E6E6E6">' . $nome_fm . '</h4>';
                // Consultar pautas conforme o semestre e tipo de avaliação
                $query = "SELECT id_pauta, disciplina, semestre, estado, user, notas, par1, par2, par3, nivel FROM $table WHERE semestre = $semestre AND estado = 1 AND user = '$username' AND disciplina = '$cod_fm'";
                $result = $mysqli->query($query);
                $queryFaltas = "SELECT tipo_falta FROM faltas WHERE user = '$username' AND cod_dis = '$cod_fm'";
                $resultFaltas = $mysqli->query($queryFaltas);
                $fi = 0;
                $fj = 0;
                if ($result && $result->num_rows > 0) {
                    while ($row = $result->fetch_assoc()) {
                        echo '<div class="border p-3 mb-3">';
                        echo '<p><strong>Aproveitamento:</strong> ' . getNivelAproveitamento($row['par1']) . '</p>';
                        echo '<p><strong>Atitudes e Valores:</strong> ' . getNivelAtitudes($row['par2']) . '</p>';
                        echo '<p><strong>Empenho e Cumprimento de Tarefas:</strong> ' . getNivelEmpenho($row['par3']) . '</p>';
                        echo '<p><strong>Observações:</strong> ' . $row['notas'] . '</p>';
                        
                        // Inicializa variáveis FI e FJ
                        $fi = 0;
                        $fj = 0;
                        
                        // Verifica se há resultados de faltas
                        if ($resultFaltas && $resultFaltas->num_rows > 0) {
                            // Conta os tipos de faltas
                            while ($rowFaltas = $resultFaltas->fetch_assoc()) {
                                if ($rowFaltas['tipo_falta'] == 1) {
                                    $fj += 1;
                                } elseif ($rowFaltas['tipo_falta'] == 2) {
                                    $fi += 1;
                                }
                            }
                        }
                        

                        echo '<table class="table table-bordered">';
                        echo '<thead class="table-light">';
                        echo '<tr>';
                        echo '<th scope="col">Nível</th>';
                        echo '<th scope="col">Faltas Injustificadas</th>';
                        echo '<th scope="col">Faltas Justificadas</th>';
                        echo '</tr>';
                        echo '</thead>';
                        echo '<tbody>';
                        echo '<tr>';
                        echo '<td>' . $row['nivel'] . '</td>';
                        echo '<td>' . $fi . '</td>'; // Valor de FI
                        echo '<td>' . $fj . '</td>'; // Valor de FJ
                        echo '</tr>';
                        echo '</tbody>';
                        echo '</table>';

                        
                    }
                }
                else {
                    echo '<div class="container alert alert-warning mt-4"><i>Não foi encontrado nenhum registo.</i></div>';
                }
                echo '</div>';
                echo '</div>';
            }
            echo '</div>';
            echo '</div>';

            // Consultar dados de Classes de Conjunto (Coro e Orquestra)
            $queryCoro = "SELECT cod_coro FROM alunos WHERE user = '$username'";
            $resultCoro = $mysqli->query($queryCoro);
            echo '<div class="container mt-4">';
            echo '<div class="border p-3 mb-3">';
            echo '<h4 style="background-color:#E6E6E6">Classe de Conjunto</h4>'; // Título para seção de Classe de Conjunto
            if ($resultCoro && $resultCoro->num_rows > 0) {
                $rowCoro = $resultCoro->fetch_assoc();
                $cod_coro = $rowCoro['cod_coro'];
                $nome_coro = ($cod_coro != 0) ? getDisciplinaNome($cod_coro, $mysqli) : 'Não Aplicável';
                echo '<div class="border p-3 mb-3">';
                echo '<h5 style="background-color:#E6E6E6">Coro (';
                echo $nome_coro . ')</h5>';
                // Consultar pautas conforme o semestre e tipo de avaliação
                $query = "SELECT id_pauta, disciplina, semestre, estado, user, notas, par1, par2, par3, nivel FROM $table WHERE semestre = $semestre AND estado = 1 AND user = '$username' AND disciplina = '$cod_coro'";
                $result = $mysqli->query($query);
                $queryFaltas = "SELECT tipo_falta FROM faltas WHERE user = '$username' AND cod_dis = '$cod_coro'";
                $resultFaltas = $mysqli->query($queryFaltas);
                $fi = 0;
                $fj = 0;
                if ($result && $result->num_rows > 0) {
                    while ($row = $result->fetch_assoc()) {
                        echo '<div class="border p-3 mb-3">';
                        echo '<p><strong>Aproveitamento:</strong> ' . getNivelAproveitamento($row['par1']) . '</p>';
                        echo '<p><strong>Atitudes e Valores:</strong> ' . getNivelAtitudes($row['par2']) . '</p>';
                        echo '<p><strong>Empenho e Cumprimento de Tarefas:</strong> ' . getNivelEmpenho($row['par3']) . '</p>';
                        echo '<p><strong>Observações:</strong> ' . $row['notas'] . '</p>';
                        
                        // Inicializa variáveis FI e FJ
                        $fi = 0;
                        $fj = 0;
                        
                        // Verifica se há resultados de faltas
                        if ($resultFaltas && $resultFaltas->num_rows > 0) {
                            // Conta os tipos de faltas
                            while ($rowFaltas = $resultFaltas->fetch_assoc()) {
                                if ($rowFaltas['tipo_falta'] == 1) {
                                    $fj += 1;
                                } elseif ($rowFaltas['tipo_falta'] == 2) {
                                    $fi += 1;
                                }
                            }
                        }
                        

                        echo '<table class="table table-bordered">';
                        echo '<thead class="table-light">';
                        echo '<tr>';
                        echo '<th scope="col">Nível</th>';
                        echo '<th scope="col">Faltas Injustificadas</th>';
                        echo '<th scope="col">Faltas Justificadas</th>';
                        echo '</tr>';
                        echo '</thead>';
                        echo '<tbody>';
                        echo '<tr>';
                        echo '<td>' . $row['nivel'] . '</td>';
                        echo '<td>' . $fi . '</td>'; // Valor de FI
                        echo '<td>' . $fj . '</td>'; // Valor de FJ
                        echo '</tr>';
                        echo '</tbody>';
                        echo '</table>';

                        
                    }
                }
                else {
                    echo '<div class="container alert alert-warning mt-4"><i>Não foi encontrado nenhum registo.</i></div>';
                }
                echo '</div>';
            }

            $queryOrquestra = "SELECT cod_orq FROM alunos WHERE user = '$username'";
            $resultOrquestra = $mysqli->query($queryOrquestra);
            if ($resultOrquestra && $resultOrquestra->num_rows > 0) {
                $rowOrquestra = $resultOrquestra->fetch_assoc();
                $cod_orq = $rowOrquestra['cod_orq'];
                $nome_orq = ($cod_orq != 0) ? getDisciplinaNome($cod_orq, $mysqli) : 'Não Aplicável';
                echo '<div class="border p-3 mb-3">';
                echo '<h5 style="background-color:#E6E6E6">Orquestra (';
                echo $nome_orq . ')</h5>';
                // Consultar pautas conforme o semestre e tipo de avaliação
                $query = "SELECT id_pauta, disciplina, semestre, estado, user, notas, par1, par2, par3, nivel FROM $table WHERE semestre = $semestre AND estado = 1 AND user = '$username' AND disciplina = '$cod_orq'";
                $result = $mysqli->query($query);
                $queryFaltas = "SELECT tipo_falta FROM faltas WHERE user = '$username' AND cod_dis = '$cod_orq'";
                $resultFaltas = $mysqli->query($queryFaltas);
                $fi = 0;
                $fj = 0;
                if ($result && $result->num_rows > 0) {
                    while ($row = $result->fetch_assoc()) {
                        echo '<div class="border p-3 mb-3">';
                        echo '<p><strong>Aproveitamento:</strong> ' . getNivelAproveitamento($row['par1']) . '</p>';
                        echo '<p><strong>Atitudes e Valores:</strong> ' . getNivelAtitudes($row['par2']) . '</p>';
                        echo '<p><strong>Empenho e Cumprimento de Tarefas:</strong> ' . getNivelEmpenho($row['par3']) . '</p>';
                        echo '<p><strong>Observações:</strong> ' . $row['notas'] . '</p>';
                        
                        // Inicializa variáveis FI e FJ
                        $fi = 0;
                        $fj = 0;
                        
                        // Verifica se há resultados de faltas
                        if ($resultFaltas && $resultFaltas->num_rows > 0) {
                            // Conta os tipos de faltas
                            while ($rowFaltas = $resultFaltas->fetch_assoc()) {
                                if ($rowFaltas['tipo_falta'] == 1) {
                                    $fj += 1;
                                } elseif ($rowFaltas['tipo_falta'] == 2) {
                                    $fi += 1;
                                }
                            }
                        }
                        

                        echo '<table class="table table-bordered">';
                        echo '<thead class="table-light">';
                        echo '<tr>';
                        echo '<th scope="col">Nível</th>';
                        echo '<th scope="col">Faltas Injustificadas</th>';
                        echo '<th scope="col">Faltas Justificadas</th>';
                        echo '</tr>';
                        echo '</thead>';
                        echo '<tbody>';
                        echo '<tr>';
                        echo '<td>' . $row['nivel'] . '</td>';
                        echo '<td>' . $fi . '</td>'; // Valor de FI
                        echo '<td>' . $fj . '</td>'; // Valor de FJ
                        echo '</tr>';
                        echo '</tbody>';
                        echo '</table>';

                        
                    }
                }
                else {
                    echo '<div class="container alert alert-warning mt-4"><i>Não foi encontrado nenhum registo.</i></div>';
                }
                echo '</div>';
            }
            echo '</div>';
            echo '</div>';
        }
    }
}

// Função para obter o nome da disciplina com base no código
function getDisciplinaNome($cod_dis, $mysqli) {
    $query = "SELECT nome_dis FROM cod_dis WHERE cod_dis = $cod_dis";
    $result = $mysqli->query($query);
    if ($result && $result->num_rows > 0) {
        $row = $result->fetch_assoc();
        return $row['nome_dis'];
    } else {
        return 'Não Aplicável';
    }
}

// Funções para obter o nível de avaliação com base nos parâmetros
function getNivelAproveitamento($par1) {
    switch ($par1) {
        case 0:
            return 'Não existem dados suficientes para avaliar';
        case 1:
            return 'Apresenta um aproveitamento fraco';
        case 2:
            return 'Apresenta um mau aproveitamento';
        case 3:
            return 'Apresenta um aproveitamento razoável';
        case 4:
            return 'Apresenta um bom aproveitamento';
        case 5:
            return 'Apresenta um ótimo aproveitamento';
        default:
            return 'Não especificado';
    }
}

// Funções para obter o nível de avaliação com base nos parâmetros
function getNivelAtitudes($par2) {
    switch ($par2) {
        case 0:
            return 'Não existem dados suficientes para avaliar';
        case 1:
            return 'Revela um fraco comportamento';
        case 2:
            return 'Apresenta um mau comportamento';
        case 3:
            return 'Revela um comportamento razoável';
        case 4:
            return 'Revela um bom comportamento';
        case 5:
            return 'Demonstra um ótimo comportamento';
        default:
            return 'Não especificado';
    }
}

// Funções para obter o nível de avaliação com base nos parâmetros
function getNivelEmpenho($par3) {
    switch ($par3) {
        case 0:
            return 'Não existem dados suficientes para avaliar';
        case 1:
            return 'Não revela interesse nem demonstra boa compreensão de conceitos';
        case 2:
            return 'Revela pouco interesse e fraca compreensão de conceitos';
        case 3:
            return 'Revela algum interesse e razoável compreensão de conceitos';
        case 4:
            return 'Revela interesse e boa compreensão de conceitos';
        case 5:
            return 'Revela bastante interesse e ótima compreensão de conceitos';
        default:
            return 'Não especificado';
    }
}

include 'footer-reservado.php';
?>
