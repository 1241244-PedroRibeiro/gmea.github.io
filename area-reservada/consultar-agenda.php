<?php
session_start();
include "./generals/config.php";
$mysqli = new mysqli($bd_host, $bd_user, $bd_password, $bd_database);

if ($mysqli->connect_error) {
    die('Erro: (' . $mysqli->connect_errno . ') ' . $mysqli->connect_error);
}

// Determinar o tipo de usuário logado
$userType = $_SESSION["type"];
$username = $_SESSION["username"];

// Consulta de eventos baseada no tipo de usuário
if ($userType == 1) {
    // Usuário tipo 1 (aluno) - Consulta os eventos associados ao aluno
    $loggedInUser = $_SESSION["username"];

    // Obter todas as turmas do aluno
    $turmas_query = "SELECT cod_turma FROM turmas_alunos WHERE user = '$loggedInUser'";
    $turmas_result = $mysqli->query($turmas_query);

    if ($turmas_result) {
        $turma_conditions = array();
        while ($turma = $turmas_result->fetch_assoc()) {
            $turma_cod = $turma['cod_turma'];

            // Incluir apenas turmas diferentes da turma atual do aluno
            if ($turma_cod != $loggedInUser) {
                $turma_conditions[] = "userOuTurma = '$turma_cod'";
            }
        }

        // Construir a parte da consulta para incluir os eventos das turmas do aluno
        $turma_condition = implode(' OR ', $turma_conditions);
        $query_events = "SELECT * FROM calendario WHERE ($turma_condition) OR userOuTurma = '$loggedInUser'";
    }

    // Adicionar eventos gerais para alunos
    $query_events .= " UNION SELECT * FROM calendario WHERE userOuTurma = '0' OR userOuTurma = '1'";
} elseif ($userType == 2) {
    // Tipo 2 (professor): Consulta eventos criados pelo professor logado
    $query_events = "SELECT * FROM calendario WHERE criador = '$username'";

    // Adicionar eventos gerais
    $query_events .= " UNION SELECT * FROM calendario WHERE userOuTurma = '0' OR userOuTurma = '2'";
} elseif ($userType >= 3) {
    // Tipo 3 (admin): Consulta eventos criados pelo administrador logado
    $query_events = "SELECT * FROM calendario WHERE criador = '$username'";

    // Adicionar eventos gerais
    $query_events .= " UNION SELECT * FROM calendario WHERE userOuTurma = '0' OR userOuTurma = '3'";
}

$events_result = $mysqli->query($query_events);

if (!$events_result) {
    die('Erro na consulta de eventos: ' . $mysqli->error);
}

$events = array();

while ($row = $events_result->fetch_assoc()) {
    if ($row['tipo_evento'] == 1) {
        $tipo_evento = 'Avaliação Intercalar';
    }
    else if ($row['tipo_evento'] == 2) {
        $tipo_evento = 'Provas';
    }
    else if ($row['tipo_evento'] == 3) {
        $tipo_evento = 'Audições';
    }
    else if ($row['tipo_evento'] == 4) {
        $tipo_evento = 'Workshop';
    }
    else if ($row['tipo_evento'] == 5) {
        $tipo_evento = 'Outro';
    }
    else if ($row['tipo_evento'] == 6) {
        $tipo_evento = 'Interrupção Letiva';
    }
    else if ($row['tipo_evento'] == 7) {
        $tipo_evento = 'Evento';
    }
    else if ($row['tipo_evento'] == 8) {
        $tipo_evento = 'Reunião';
    }

    // Verificar se há uma disciplina específica associada ao evento
    if ($row['cod_dis'] == 0) {
        $disciplina = '(0) Geral';
    } else {
        // Consulta para obter o nome da disciplina com base no código
        $cod_dis = $row['cod_dis'];
        $query_disciplina = "SELECT nome_dis FROM cod_dis WHERE cod_dis = '$cod_dis'";
        $result_disciplina = $mysqli->query($query_disciplina);

        if ($result_disciplina && $result_disciplina->num_rows > 0) {
            $disciplina_data = $result_disciplina->fetch_assoc();
            $disciplina = '(' . $row['cod_dis'] . ') ' . $disciplina_data['nome_dis'];
        } else {
            // Em caso de falha na consulta, definir como desconhecido
            $disciplina = '(' . $row['cod_dis'] . ') Desconhecido';
        }
    }

    $criador = $row['criador'];
    $query_criador = "SELECT nome FROM users1 WHERE user = '$criador'";
    $result_criador = $mysqli->query($query_criador);

    if ($result_criador && $result_criador->num_rows > 0) {
        $criador_data = $result_criador->fetch_assoc();
        $criador = '(' . $row['criador'] . ') ' . $criador_data['nome'];
    } else {
        // Em caso de falha na consulta, definir como desconhecido
        $criador = '(' . $row['criador'] . ') Desconhecido';
    }


    $events[] = array(
        'id' => $row['id_evento'],
        'title' => $row['titulo'],
        'start' => $row['inicio'],
        'end' => $row['fim'],
        'description' => $row['notas'],
        'destinatario' => $row['userOuTurma'],
        'disciplina' => $disciplina,
        'tipo_evento' => $tipo_evento,
        'tipoEvento' => $row['tipo_evento'],
        'criadorEvento' => $criador
    );
}

$mysqli->close();
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
    <h2>Consulta de Eventos</h2>
    <div id='calendar' class="mt-4"></div>
</div>

<!-- Modal de Consulta de Evento -->
<div class="modal fade" id="eventoModal" tabindex="-1" role="dialog" aria-labelledby="eventoModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="eventoModalLabel">Detalhes do Evento</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Fechar">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="form-group">
                    <label for="tipo_evento">Tipo de Marcação:</label>
                    <input type="text" id="tipo_evento" class="form-control" readonly>
                </div>
                <div class="form-group">
                    <label for="titulo">Título:</label>
                    <input type="text" id="titulo" class="form-control" readonly>
                </div>
                <div class="form-group">
                    <label for="nota">Nota:</label>
                    <input type="text" id="nota" class="form-control" readonly>
                </div>
                <div class="form-group">
                    <label for="inicio">Início:</label>
                    <input type="text" id="inicio" class="form-control" readonly>
                </div>
                <div class="form-group">
                    <label for="fim">Fim:</label>
                    <input type="text" id="fim" class="form-control" readonly>
                </div>
                <div class="form-group">
                    <label for="disciplina">Disciplina:</label>
                    <input type="text" id="disciplina" class="form-control" readonly>
                </div>
                <div class="form-group">
                    <label for="criador">Adicionado por:</label>
                    <input type="text" id="criador" class="form-control" readonly>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal" id="closeModalBtn">Fechar</button>
            </div>
        </div>
    </div>
</div>


<script src='generals/vendor/fullcalendar/packages/core/main.js'></script>
<script src='generals/vendor/fullcalendar/packages/interaction/main.js'></script>
<script src='generals/vendor/fullcalendar/packages/daygrid/main.js'></script>
<script src='generals/vendor/fullcalendar/packages/timegrid/main.js'></script>
<script src='generals/vendor/fullcalendar/packages/list/main.js'></script>
<!-- jQuery e Bootstrap JS -->
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
<script src='https://cdnjs.cloudflare.com/ajax/libs/fullcalendar/5.9.0/locales/pt-br.js'></script>

<script>
document.addEventListener('DOMContentLoaded', function() {
    var calendarEl = document.getElementById('calendar');

    var calendar = new FullCalendar.Calendar(calendarEl, {
        plugins: ['dayGrid', 'timeGrid', 'list'],
        header: {
            left: 'prev,next today',
            center: 'title',
            right: 'dayGridMonth,timeGridWeek,timeGridDay,listWeek'
        },
        buttonText: {
            today: 'Hoje',
            month: 'Mês',
            week: 'Semana',
            day: 'Dia',
            list: 'Lista'
        },
        locale: 'pt-br',
        editable: false,
        events: <?php echo json_encode($events); ?>,
        eventClick: function(info) {
            var evento = info.event;
            $('#tipo_evento').val(evento.extendedProps.tipo_evento);
            $('#titulo').val(evento.title);
            $('#nota').val(evento.extendedProps.description);
            $('#inicio').val(evento.start.toLocaleString());
            $('#fim').val(evento.end.toLocaleString());
            $('#disciplina').val(evento.extendedProps.disciplina);
            $('#criador').val(evento.extendedProps.criadorEvento);

            // Abre o modal
            $('#eventoModal').modal('show');
        },
        eventRender: function(info) {
            var tipoEvento = info.event.extendedProps.tipoEvento;
            var color;

            switch (tipoEvento) {
                case '1':
                    color = 'blue';
                    break;
                case '2':
                    color = 'dark blue';
                    break;
                case '3':
                    color = 'green';
                    break;
                case '4':
                    color = 'pink';
                    break;
                case '5':
                    color = 'gray';
                    break;
                case '6':
                    color = 'red';
                    break;
                case '7':
                    color = 'darkgreen';
                    break;
                case '8':
                    color = 'orange';
                    break;
                default:
                    color = 'gray';
            }

            info.el.style.backgroundColor = color; // Aplicar cor de fundo
            info.el.style.borderColor = color; // Aplicar cor da borda
            info.el.style.color = 'white'; // Cor do texto
        }

    });

    calendar.render();

    document.getElementById('closeModalBtn').addEventListener('click', function() {
        $('#eventoModal').modal('hide');
    });
});
</script>


</body>
</html>

    <?php
    include "footer-reservado.php";
    ?>