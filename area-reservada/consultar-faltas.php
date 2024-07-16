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
<html lang="pt">
<head>
    <meta charset="UTF-8">
    <title>Consulta de Faltas</title>
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
    if ($_SESSION["type"] == 1) {
        include "header-alunos.php";
    }
?>

<div class="container mt-4">
    <h2>Consulta de Faltas</h2>

    <?php
// Exibir faltas por disciplina
foreach ($disciplinas as $cod_dis => $nome_disciplina) {
    echo '<h3>' . $nome_disciplina . '</h3>';
    echo '<table class="table table-bordered">';
    echo '<thead>';
    echo '<tr>';
    echo '<th>Data</th>';
    echo '<th>Número da Lição</th>';
    echo '<th>Tipo de Falta</th>';
    echo '<th>Ação</th>';
    echo '</tr>';
    echo '</thead>';
    echo '<tbody>';

    // Consultar faltas do aluno por disciplina
    $queryFaltas = "SELECT f.indice_aula, f.dia, f.tipo_falta, f.indice_falta, f.id_aula 
                    FROM faltas f 
                    JOIN aulas a ON f.id_aula = a.id_aula
                    WHERE a.cod_dis = '$cod_dis' AND f.user = '$username' AND f.tipo_falta > 0";
    $resultFaltas = $mysqli->query($queryFaltas);

    if ($resultFaltas && $resultFaltas->num_rows > 0) {
        while ($rowFalta = $resultFaltas->fetch_assoc()) {
            $data_formatada = date('d/m/Y', strtotime($rowFalta['dia']));
            $tipo_falta = $rowFalta['tipo_falta'];
            $indice_aula = $rowFalta['indice_aula'];
            $indice_falta = $rowFalta['indice_falta'];

            // Verificar o estado da justificação para esta falta
            $queryJustificacao = "SELECT estado FROM justificacao_faltas 
                                WHERE indice_aula = '$indice_aula' AND tipo_falta = '$tipo_falta' AND user = '$username'";
            $resultJustificacao = $mysqli->query($queryJustificacao);

            if ($resultJustificacao && $resultJustificacao->num_rows > 0) {
                $rowJustificacao = $resultJustificacao->fetch_assoc();
                $estado_justificacao = $rowJustificacao['estado'];

                if ($estado_justificacao == 0) {
                    // Justificação enviada para análise
                    $acao_botao = '<button class="btn btn-secondary" disabled>Já foi enviada um pedido de justificação para análise</button>';
                    // Ainda não foi enviada uma justificação, exibir o botão de justificar
                    switch ($tipo_falta) {
                        case 1:
                            $falta_descricao = 'Falta Injustificada';
                            break;
                        case 2:
                            $falta_descricao = 'Falta Justificada';
                            break;
                        case 3:
                            $falta_descricao = 'Falta de Atraso';
                            break;
                    }
                } elseif ($estado_justificacao == 1) {
                    // Falta já justificada
                    $acao_botao = '<button class="btn btn-secondary" disabled>Falta já justificada.</button>';
                    // Ainda não foi enviada uma justificação, exibir o botão de justificar
                    switch ($tipo_falta) {
                        case 1:
                            $falta_descricao = 'Falta Injustificada';
                            break;
                        case 2:
                            $falta_descricao = 'Falta Justificada';
                            break;
                        case 3:
                            $falta_descricao = 'Falta de Atraso';
                            break;
                    }
                }
            } else {
                // Ainda não foi enviada uma justificação, exibir o botão de justificar
                switch ($tipo_falta) {
                    case 1:
                        $falta_descricao = 'Falta Injustificada';
                        $acao_botao = '<button class="btn btn-danger btn-justificar" data-indice="' . $indice_aula . '" data-dia="' . $rowFalta['dia'] . '">Justificar</button>';
                        break;
                    case 2:
                        $falta_descricao = 'Falta Justificada';
                        $acao_botao = '<button class="btn btn-secondary" disabled>Falta já justificada.</button>';
                        break;
                    case 3:
                        $falta_descricao = 'Falta de Atraso';
                        $acao_botao = '<button class="btn btn-danger btn-justificar" data-indice="' . $indice_aula . '" data-dia="' . $rowFalta['dia'] . '">Justificar</button>';
                        break;
                    case 4:
                        $falta_descricao = 'Falta de Material';
                        $acao_botao = '';
                        break;
                    case 5:
                        $falta_descricao = '<b>Falta Disciplinar</b>';
                        $acao_botao = '';
                        break;
                }
            }

            echo '<tr>';
            echo '<td>' . $data_formatada . '</td>';
            echo '<td>' . $indice_aula . '</td>';
            echo '<td>' . $falta_descricao . '</td>';
            echo '<td>' . $acao_botao . '</td>';

            // Adicionar campos ocultos para enviar dados ao modal de justificação
            echo '<input type="hidden" class="indice-aula" value="' . $rowFalta['indice_aula'] . '">';
            echo '<input type="hidden" class="tipo-falta" value="' . $tipo_falta . '">';
            echo '<input type="hidden" class="indice-falta" value="' . $rowFalta['indice_falta'] . '">';
            echo '<input type="hidden" class="id-aula" value="' . $rowFalta['id_aula'] . '">';

            echo '</tr>';
        }
    } else {
        // Caso não haja faltas registradas para esta disciplina
        echo '<tr>';
        echo '<td colspan="4">Sem faltas registradas.</td>';
        echo '</tr>';
    }

    echo '</tbody>';
    echo '</table>';
}
    ?>

</div>


<!-- Modal de Justificação -->
<div class="modal fade" id="modalJustificar" tabindex="-1" aria-labelledby="modalJustificarLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="modalJustificarLabel">Justificar Falta</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form id="formJustificar" enctype="multipart/form-data">
                <div class="modal-body">
                    <div class="form-group">
                        <label for="tipoFalta">Tipo de Falta</label>
                        <input type="text" class="form-control" id="tipoFalta" name="tipoFalta" readonly>
                    </div>
                    <div class="form-group">
                        <label for="dataFalta">Dia</label>
                        <input type="text" class="form-control" id="dataFalta" name="dataFalta" readonly>
                    </div>
                    <div class="form-group">
                        <label for="motivo">Motivo da Justificação</label>
                        <textarea class="form-control" id="motivo" name="motivo" rows="3"></textarea>
                    </div>
                    <div class="form-group">
                        <label for="anexo">Anexo (PDF, Word, Imagem - Opcional)</label>
                        <input type="file" class="form-control-file" id="anexo" name="anexo" accept=".pdf,.doc,.docx,.jpg,.jpeg,.png">
                    </div>

                    <!-- Campos ocultos para enviar dados adicionais -->
                    <input type="hidden" id="indiceAula" name="indiceAula">
                    <input type="hidden" id="tipoFaltaHidden" name="tipoFaltaHidden">
                    <input type="hidden" id="indiceFalta" name="indiceFalta">
                    <input type="hidden" id="id_aula" name="id_aula">
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal" id="closeModalBtn">Fechar</button>
                    <button type="submit" class="btn btn-primary">Enviar Justificação</button>
                </div>
            </form>
        </div>
    </div>
</div>


<script>
    $(document).ready(function() {

        document.getElementById('closeModalBtn').addEventListener('click', function() {
            $('#modalJustificar').modal('hide');
        });
        document.getElementById('closeModalBtn2').addEventListener('click', function() {
            $('#modalSuccess').modal('hide');
        });
        // Mostrar modal ao clicar no botão de justificar falta
        $('.btn-justificar').click(function() {
            var indice = $(this).data('indice');
            var dia = $(this).data('dia');
            var tipoFalta = $(this).closest('tr').find('.tipo-falta').val();
            var indiceAula = $(this).closest('tr').find('.indice-aula').val();
            var indiceFalta = $(this).closest('tr').find('.indice-falta').val();
            var id_aula = $(this).closest('tr').find('.id-aula').val();

            console.log(indice);
            console.log(dia);
            console.log(tipoFalta);
            console.log(indiceAula);
            console.log(indiceFalta);
            console.log(id_aula);

            // Verificar se já foi enviada uma justificação para esta falta
            var justificacaoEnviada = $(this).closest('tr').find('.falta_descricao').text().includes('Justificação Enviada');
            if (justificacaoEnviada) {
                alert('Já foi enviada um pedido de justificação para análise.');
                return false; // Evitar abrir o modal se já houver justificação enviada
            }

            $('#tipoFalta').val(tipoFalta);
            $('#dataFalta').val(dia);
            $('#indiceAula').val(indiceAula);
            $('#tipoFaltaHidden').val(tipoFalta);
            $('#indiceFalta').val(indiceFalta);
            $('#id_aula').val(id_aula);

            $('#formJustificar').attr('action', 'processar_justificacao.php?indice=' + indice);
            $('#modalJustificar').modal('show');
        });

        // Processar envio do formulário de justificação
        $('#formJustificar').submit(function(event) {
            event.preventDefault();
            var formData = new FormData(this);

            $.ajax({
                url: $(this).attr('action'),
                type: 'POST',
                data: formData,
                cache: false,
                contentType: false,
                processData: false,
                success: function(response) {
                    // Exibir o modal de sucesso
                    $('#modalSuccessMessage').text(response);
                    $('#modalSuccess').modal('show');
                },
                error: function() {
                    alert('Erro ao processar a justificação.');
                }
            });
        });

        // Recarregar a página após fechar o modal de sucesso
        $('#modalSuccess').on('hidden.bs.modal', function (e) {
            location.reload();
        });
    });
</script>


</body>
</html>


<!-- Modal de Sucesso -->
<div class="modal fade" id="modalSuccess" tabindex="-1" aria-labelledby="modalSuccessLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="modalSuccessLabel">Sucesso</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <p>Justificação Enviada com Sucesso</p>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal" id="closeModalBtn2">Fechar</button>
            </div>
        </div>
    </div>
</div>

<?php include 'footer-reservado.php'; ?>