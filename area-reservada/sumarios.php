<?php
session_start();
include "./generals/config.php";
$mysqli = new mysqli($bd_host, $bd_user, $bd_password, $bd_database);

if ($mysqli->connect_error) {
    die('Erro: (' . $mysqli->connect_errno . ') ' . $mysqli->connect_error);
}

$user = $_SESSION['username'];

// Verifica se os dados da aula foram enviados via GET
if (isset($_GET['idAula'])) {
    $idAula = $_GET['idAula'];

    // Consulta para obter o próximo número da lição baseado no id_aula
    $queryHoras = "SELECT hora_inicio, hora_fim FROM aulas WHERE id_aula = $idAula";
    $resultHoras = $mysqli->query($queryHoras);
    if ($resultHoras) {
        $row = $resultHoras->fetch_assoc();
        if ($row) {
            $horaInicio = $row['hora_inicio'];
            $horaFim = $row['hora_fim'];
        } else {
            echo "Nenhuma linha encontrada para o id_aula = $idAula";
        }
        $resultHoras->free();
    } else {
        echo "Erro na consulta: " . $mysqli->error;
    }


    // Consulta para obter o próximo número da lição baseado no id_aula
    $queryMaxIndice = "SELECT MAX(indice_aula) AS max_indice FROM sumarios WHERE id_aula = $idAula";
    $resultMaxIndice = $mysqli->query($queryMaxIndice);
    $maxIndice = ($resultMaxIndice && $resultMaxIndice->num_rows > 0) ? intval($resultMaxIndice->fetch_assoc()['max_indice']) + 1 : 1;

    // Processar o formulário de inserção de sumário
    if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['submit'])) {
        $indiceAula = $_POST['indice_aula'];
        $textoSumario = $_POST['texto_sumario'];
        $horaInicioAula = $_POST['hora_inicio_aula'];
        $horaFimAula = $_POST['hora_fim_aula'];
        $data = $_POST['data_aula'];

        // Formatar a data no formato correto para inserção no MySQL (YYYY-MM-DD)
        $dataFormatada = date('Y-m-d', strtotime($data));

        // Verificar se existem registros de faltas para esta aula e número da lição
        $queryVerificarFaltas = "SELECT * FROM faltas WHERE id_aula = '$idAula' AND indice_aula = '$indiceAula'";
        $resultVerificarFaltas = $mysqli->query($queryVerificarFaltas);

        if ($resultVerificarFaltas->num_rows === 0) {
            // Se não houver registros de faltas, definir a variável para mostrar o aviso
            $mostrarAviso = true;
        }
        else {
            // Se houver registros de faltas, continuar com a inserção do sumário
            // Inserir o sumário na base de dados
            $queryInserirSumario = "INSERT INTO sumarios (id_aula, indice_aula, sumario_texto, data, hora_inicio, hora_fim, user)
                                    VALUES ('$idAula', '$indiceAula', '$textoSumario', '$dataFormatada', '$horaInicioAula', '$horaFimAula', '$user')";

            if ($mysqli->query($queryInserirSumario) === TRUE) {
                // Definir uma variável de sucesso para exibir o modal
                $insercaoSucesso = true;
            } else {
                echo "Erro ao inserir o sumário: " . $mysqli->error;
            }
        }

    }
} else {
    // Se os parâmetros não foram fornecidos corretamente, redirecionar para a página anterior
    header("Location: consultar-horario-prof.php");
    exit();
}

?>

<!DOCTYPE html>
<html lang="pt">
<head>
    <meta charset="UTF-8">
    <title>Consulta de Eventos</title>
    <script src="https://use.fontawesome.com/releases/v6.3.0/js/all.js" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.3.1/jquery.min.js" crossorigin="anonymous"></script>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js"></script>
    <link href="https://netdna.bootstrapcdn.com/font-awesome/3.2.1/css/font-awesome.css" rel="stylesheet">
    <link href="https://cdn.quilljs.com/1.3.6/quill.snow.css" rel="stylesheet">
    <script src="https://cdn.quilljs.com/1.3.6/quill.min.js"></script>
    <link href='generals/vendor/fullcalendar/packages/core/main.css' rel='stylesheet' />
    <link href='generals/vendor/fullcalendar/packages/daygrid/main.css' rel='stylesheet' />
    <link href='generals/vendor/fullcalendar/packages/timegrid/main.css' rel='stylesheet' />
    <link href='generals/vendor/fullcalendar/packages/list/main.css' rel='stylesheet' />
    <style>
        /* Estilos do calendário */
        body {
            font-family: Arial, Helvetica Neue, Helvetica, sans-serif;
            font-size: 14px;
        }

        #calendar {
            max-width: 1250px;
            margin: 40px auto;
            padding: 0 10px;
        }
    </style>
</head>
<body>

    <div style="margin-top: 0;">
        <img style="width: 100%; height: auto;" src="./media/topAR.png" class="img-responsive">
    </div>

    <?php
    if ($_SESSION["type"] == 2) {
        include "header-profs.php";
    }
    if ($_SESSION["type"] == 3) {
        include "header-direcao.php";
    }
    ?>
    <div class="container mt-5">
        <h2>Inserir Sumário</h2>
        <form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>?horaInicio=<?php echo urlencode($horaInicio); ?>&horaFim=<?php echo urlencode($horaFim); ?>&idAula=<?php echo urlencode($idAula); ?>">
            <div class="mb-3">
                <label for="indice_aula" class="form-label">Número da Lição:</label>
                <input type="text" class="form-control" id="indice_aula" name="indice_aula" value="<?php echo $maxIndice; ?>" readonly>
            </div>

            <?php
                $queryDisciplina = "SELECT cod_dis, nome_dis FROM cod_dis WHERE cod_dis IN (SELECT cod_dis FROM aulas WHERE id_aula = $idAula)";
                $resultDisciplina = $mysqli->query($queryDisciplina);

                if ($resultDisciplina && $resultDisciplina->num_rows > 0) {
                    $rowDisciplina = $resultDisciplina->fetch_assoc();
                    $codDis = $rowDisciplina['cod_dis'];
                    $nomeDis = $rowDisciplina['nome_dis'];

                    echo "<div class='mb-3'>";
                    echo "<label for='nome_disciplina' class='form-label'>Disciplina:</label>";
                    echo "<input type='text' class='form-control' id='nome_disciplina' name='nome_disciplina' value='($codDis) $nomeDis' readonly>";
                    echo "</div>";
                }
            ?>

            <div class="mb-3">
                <label for="editor_quill" class="form-label">Texto do Sumário:</label>
                <div id="editor_quill" style="height: 150px;"></div>
                <!-- Este div será usado pelo Quill como editor -->
                <input type="hidden" id="texto_sumario" name="texto_sumario">
            </div>

            <div class="mb-3">
                <label for="data_aula" class="form-label">Data da Aula:</label>
                <input type="text" class="form-control" id="data_aula" name="data_aula" value="<?php echo date('Y-m-d'); ?>">
            </div>

            <div class="mb-3">
                <label for="hora_inicio_aula" class="form-label">Hora de Início da Aula:</label>
                <input type="text" class="form-control" id="hora_inicio_aula" name="hora_inicio_aula" value="<?php echo $horaInicio; ?>">
            </div>

            <div class="mb-3">
                <label for="hora_fim_aula" class="form-label">Hora de Fim da Aula:</label>
                <input type="text" class="form-control" id="hora_fim_aula" name="hora_fim_aula" value="<?php echo $horaFim; ?>">
            </div>

            <a href="marcar_faltas.php?idAula=<?php echo urlencode($idAula); ?>&indiceAula=<?php echo urlencode($maxIndice); ?>" class="btn btn-danger">Marcar Faltas</a>
            <button type="submit" name="submit" class="btn btn-primary">Inserir Sumário</button>
        </form>
    </div>

    <script>
        // Configuração do editor Quill
        var quill = new Quill('#editor_quill', {
            theme: 'snow'
        });

        // Submeta o conteúdo do editor Quill como um campo de formulário
        var form = document.querySelector('form');
        form.onsubmit = function() {
            var textoSumario = document.querySelector('input[name="texto_sumario"]');
            textoSumario.value = quill.root.innerHTML;
        };
    </script>

    <!-- Exibir modal de sucesso após a inserção -->
    <?php if (isset($insercaoSucesso) && $insercaoSucesso === true) { ?>
        <script>
            $(document).ready(function(){
                $('#successModal').modal('show'); // Mostrar o modal de sucesso

                // Redirecionar após fechar o modal
                $('#successModal').on('hidden.bs.modal', function () {
                    window.location.href = 'consultar-horario-prof.php';
                });
            });
        </script>
    <?php } ?>
</body>
</html>

<!-- Modal de sucesso -->
<div class="modal fade" id="successModal" tabindex="-1" aria-labelledby="successModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="successModalLabel">Sumário Inserido com Sucesso!</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Fechar"></button>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-primary" data-bs-dismiss="modal">OK</button>
            </div>
        </div>
    </div>
</div>

<!-- Modal de aviso -->
<div class="modal fade" id="warningModal" tabindex="-1" aria-labelledby="warningModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="warningModalLabel">Aviso</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Fechar"></button>
            </div>
            <div class="modal-body">
                Não registrou as faltas.
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-primary" data-bs-dismiss="modal">OK</button>
            </div>
        </div>
    </div>
</div>


<?php include 'footer-reservado.php'; ?>

<script>
    <?php if (isset($mostrarAviso) && $mostrarAviso === true) { ?>
        $(document).ready(function(){
            $('#warningModal').modal('show'); // Mostrar o modal de aviso
        });
    <?php } ?>
</script>
