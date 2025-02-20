<?php
session_start();
include "./generals/config.php";
$mysqli = new mysqli($bd_host, $bd_user, $bd_password, $bd_database);


if ($mysqli->connect_error) {
    die('Erro: (' . $mysqli->connect_errno . ') ' . $mysqli->connect_error);
}

// Processar seleção quando o formulário é enviado
if (isset($_POST['selecao'])) {
    $selecao = $_POST['selecao'];

    // Verificar se é uma turma ou aluno
    if (strpos($selecao, 't') === 0) {
        $alunos_query = "SELECT user FROM turmas_alunos WHERE cod_turma = '$selecao'";
        $alunos_result = $mysqli->query($alunos_query);

        if ($alunos_result) {
            $user_conditions = array();
            while ($aluno = $alunos_result->fetch_assoc()) {
                $aluno_user = $aluno['user'];

                // Obter todas as turmas dos alunos (exceto a turma atual)
                $outras_turmas_query = "SELECT cod_turma FROM turmas_alunos WHERE user = '$aluno_user' AND cod_turma != '$selecao'";
                $outras_turmas_result = $mysqli->query($outras_turmas_query);

                if ($outras_turmas_result) {
                    $outras_turmas = array();
                    while ($outra_turma = $outras_turmas_result->fetch_assoc()) {
                        $outras_turmas[] = "'" . $outra_turma['cod_turma'] . "'";
                    }

                    // Filtrar e garantir que cada turma aparece apenas uma vez
                    $outras_turmas = array_unique($outras_turmas);

                    // Construir a condição para incluir os eventos das outras turmas dos alunos
                    $outras_turmas_condition = implode(', ', $outras_turmas);

                    if (!empty($outras_turmas_condition)) {
                        $user_conditions[] = "userOuTurma IN ($outras_turmas_condition)";
                    }
                }

                // Incluir também os eventos dos alunos da turma atual
                $user_conditions[] = "userOuTurma = '$aluno_user'";
            }

            // Construir a parte da consulta para incluir os eventos dos alunos da turma
            $user_condition = implode(' OR ', $user_conditions);
            $query_events = "SELECT * FROM calendario WHERE ($user_condition) OR userOuTurma = '$selecao'";
        }
    } elseif (strpos($selecao, 'a') === 0) {
        // É um aluno, buscar todas as turmas associadas ao aluno

        // Obter todas as turmas do aluno
        $turmas_query = "SELECT cod_turma FROM turmas_alunos WHERE user = '$selecao'";
        $turmas_result = $mysqli->query($turmas_query);

        if ($turmas_result) {
            $turma_conditions = array();
            while ($turma = $turmas_result->fetch_assoc()) {
                $turma_cod = $turma['cod_turma'];

                // Incluir apenas turmas diferentes da turma atual do aluno
                if ($turma_cod != $selecao) {
                    $turma_conditions[] = "userOuTurma = '$turma_cod'";
                }
            }

            // Construir a parte da consulta para incluir os eventos das turmas do aluno
            $turma_condition = implode(' OR ', $turma_conditions);
            $query_events = "SELECT * FROM calendario WHERE ($turma_condition) OR userOuTurma = '$selecao'";
        }
    } else {
        // Seleção padrão (não é turma nem aluno), consultar apenas eventos diretos
        $query_events = "SELECT * FROM calendario WHERE userOuTurma = '$selecao'";
    }

    // Adicionar eventos gerais
    $query_events .= " UNION SELECT * FROM calendario WHERE userOuTurma = '0' OR userOuTurma = '1'";

    $events_result = $mysqli->query($query_events);

    if (!$events_result) {
        die('Erro na consulta de eventos: ' . $mysqli->error);
    }

    $events = array();

    while ($row = $events_result->fetch_assoc()) {
        $events[] = array(
            'id' => $row['id_evento'], // Adicionar o ID do evento
            'title' => $row['titulo'],
            'start' => $row['inicio'], // Data inicial do evento
            'end' => $row['fim'], // Data final do evento (se houver)
            'description' => $row['notas'],
            'destinatario' => $row['userOuTurma'],
            'disciplina' => $row['cod_dis'],
            'tipo_evento' => $row['tipo_evento'],
            'criadorEvento' => $row['criador']
        );
    }
}



// Obter opções para o select com base no tipo de usuário
if ($_SESSION["type"] == 3 || $_SESSION["type"] == 4) { // Administrador
    $options_query = "SELECT user, nome FROM users1 WHERE type = 1";
    $options_query .= " UNION ";
    $options_query .= "SELECT cod_turma, CONCAT('Turma de: ', nome_turma) AS nome FROM turmas WHERE nome_turma <> '' AND prof_turma <> ''";    
} elseif ($_SESSION["type"] == 2) { // Professor
    $username = $_SESSION["username"];
    $options_query = "SELECT a.user, u.nome FROM alunos a ";
    $options_query .= "INNER JOIN users1 u ON a.user = u.user ";
    $options_query .= "WHERE a.prof_in1 = '$username' OR a.prof_in2 = '$username'";
    $options_query .= " UNION ";
    $options_query .= "SELECT cod_turma, CONCAT('Turma de: ', nome_turma) AS nome_turma FROM turmas WHERE prof_turma = '$username'";
}

$options_result = $mysqli->query($options_query);

if (!$options_result) {
    die('Erro na consulta de opções: ' . $mysqli->error);
}

?>

<!DOCTYPE html>
<html lang="pt">
<head>
    <meta charset="UTF-8">
    <title>Gestão de Agenda</title>
    <link href='generals/vendor/fullcalendar/packages/core/main.css' rel='stylesheet' />
    <link href='generals/vendor/fullcalendar/packages/daygrid/main.css' rel='stylesheet' />
    <link href='generals/vendor/fullcalendar/packages/timegrid/main.css' rel='stylesheet' />
    <link href='generals/vendor/fullcalendar/packages/list/main.css' rel='stylesheet' />
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
if ($_SESSION["type"] == 2) { // Mostrar cabeçalho para professores
    include "header-profs.php";
}
if ($_SESSION["type"] == 3) { // Mostrar cabeçalho para professores
    include "header-direcao.php";
}
if ($_SESSION["type"] == 4) { // Mostrar cabeçalho para professores
    include "header-professor-direcao.php";
}
?>

<div class="container mt-4">
    <h2>Selecione o aluno ou turma para agendar eventos:</h2>
    <form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="post" class="form-inline">
        <div class="form-group mr-2">
            <select name="selecao" class="form-control">
                <option value="">Selecionar</option>
                <?php if ($_SESSION["type"] == 3 || $_SESSION["type"] == 4) : ?>
                    <option value="0">(0) Geral</option>
                    <option value="1">(1) Alunos</option>
                    <option value="2">(2) Professores</option>
                    <option value="3">(3) Direção</option>
                <?php endif; ?>
                <?php
                while ($row = $options_result->fetch_assoc()) {
                    echo '<option value="' . $row["user"] . '">(' . $row["user"] . ') ' .$row["nome"] . '</option>';
                }
                ?>
            </select>
        </div>
        <br/>
        <button type="submit" name="prosseguir" class="btn btn-primary">Prosseguir</button>
    </form>
    <input type="hidden" name="selecao" id="selecao" value="<?php echo htmlspecialchars($selecao); ?>">

    <div id='calendar' class="mt-4"></div>
</div>

<!-- Modal para adicionar evento -->
<div class="modal fade" id="eventoModal" tabindex="-1" role="dialog" aria-labelledby="eventoModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <form id="formEvento">
                <div class="modal-header">
                    <h5 class="modal-title" id="eventoModalLabel">Adicionar Evento</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Fechar">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="form-group">
                        <label for="tipo_evento">Tipo de Marcação:</label>
                        <select name="tipo_evento" id="tipo_evento" class="form-control">
                            <option value="">Selecionar</option>
                            <option value="1">Avaliação Intercalar</option>
                            <option value="2">Provas</option>
                            <option value="3">Audições</option>
                            <option value="4">Workshop</option>
                            <option value="5">Outro</option>
                            <?php if ($_SESSION["type"] == 3) : ?>
                                <option value="6">Interrupção Letiva</option>
                                <option value="7">Evento</option>
                                <option value="8">Reunião</option>
                            <?php endif; ?>
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="notas">Título:</label>
                        <input type="text" name="title" id="title" class="form-control" required>
                    </div>
                    <div class="form-group">
                        <label for="notas">Nota:</label>
                        <input type="text" name="nota" id="nota" class="form-control" required>
                    </div>
                    <div class="form-group">
                        <label for="inicio">Início:</label>
                        <input type="datetime-local" name="inicio" id="inicio" class="form-control" required>
                    </div>
                    <div class="form-group">
                        <label for="fim">Fim:</label>
                        <input type="datetime-local" name="fim" id="fim" class="form-control" required>
                    </div>
                    <div class="form-group">
                        <label for="disciplina">Disciplina:</label>
                        <select name="disciplina" id="disciplina" class="form-control">
                            <option value="">Selecionar</option>
                            <option value="0">(0) Geral</option>
                            <option value="1">(1) Alunos</option>
                            <option value="2">(2) Professores</option>
                            <option value="3">(3) Direção</option>
                            <?php
                            // Aqui você deve obter opções de disciplinas da sua tabela
                            // Substitua o exemplo abaixo pela consulta correta
                            $disciplinas_query = "SELECT cod_dis, nome_dis FROM cod_dis";
                            $disciplinas_result = $mysqli->query($disciplinas_query);

                            if ($disciplinas_result) {
                                while ($disciplina = $disciplinas_result->fetch_assoc()) {
                                    echo '<option value="' . $disciplina["cod_dis"] . '">' . '(' . $disciplina["cod_dis"] . ') ' . $disciplina["nome_dis"] . '</option>';
                                }
                            }
                            ?>
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="destinatario">Destinatário:</label>
                        <select name="destinatario" id="destinatario" class="form-control" readonly disabled>
                            <?php
                            // Opções de destinatários já obtidos anteriormente
                            if ($_SESSION["type"] == 3) {
                                echo' <option value="0">(0) Geral</option>';
                                echo' <option value="1">(1) Alunos</option>';
                                echo' <option value="2">(2) Professores</option>';
                                echo' <option value="3">(3) Direção</option>';
                             }
                            $options_result->data_seek(0);
                            while ($row = $options_result->fetch_assoc()) {
                                echo '<option value="' . $row["user"] . '"';
                                if ($_POST["selecao"] == $row["user"]) {
                                    echo ' selected';
                                }
                                echo '>(' . $row["user"] . ') ' .$row["nome"] . '</option>';
                            }
                            ?>
                        </select>
                        <input type="hidden" name="destinatario" id="destinatarioHidden" value="<?php echo htmlspecialchars($_POST['selecao']); ?>">
                    </div>
                </div>
                <div class="modal-footer">
                    <input type="hidden" name="id_evento" id="id_evento">
                    <button type="button" class="btn btn-danger float-left" id="btnExcluirEvento">Excluir Evento</button>
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Fechar</button>
                    <button type="submit" class="btn btn-primary" id="btnSalvarEvento">Salvar Evento</button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Modal de sucesso -->
<div class="modal fade" id="successModal" tabindex="-1" role="dialog" aria-labelledby="successModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="successModalLabel">Sucesso!</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Fechar">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <!-- Mensagem de sucesso aqui -->
            </div>
        </div>
    </div>
</div>

<!-- Modal de erro -->
<div class="modal fade" id="errorModal" tabindex="-1" role="dialog" aria-labelledby="errorModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="errorModalLabel">Erro!</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Fechar">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <!-- Mensagem de erro aqui -->
            </div>
        </div>
    </div>
</div>


<script src='generals/vendor/fullcalendar/packages/core/main.js'></script>
<script src='generals/vendor/fullcalendar/packages/interaction/main.js'></script>
<script src='generals/vendor/fullcalendar/packages/daygrid/main.js'></script>
<script src='generals/vendor/fullcalendar/packages/timegrid/main.js'></script>
<script src='generals/vendor/fullcalendar/packages/list/main.js'></script>
<script src='https://unpkg.com/popper.js/dist/umd/popper.min.js'></script>
<script src='https://unpkg.com/tooltip.js/dist/umd/tooltip.min.js'></script>
<!-- jQuery e Bootstrap JS -->
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
<script src='https://cdnjs.cloudflare.com/ajax/libs/fullcalendar/5.9.0/locales/pt-br.js'></script>


<script>
document.addEventListener('DOMContentLoaded', function() {
    var calendarEl = document.getElementById('calendar');

    var calendar = new FullCalendar.Calendar(calendarEl, {
        plugins: ['interaction', 'dayGrid', 'timeGrid', 'list'],
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
        locale: 'pt-br', // Definir o idioma como português do Brasil
        editable: true, // Permitir edição no calendário
        events: <?php echo json_encode($events); ?>,
        eventRender: function(info) {
            var tipoEvento = info.event.extendedProps.tipo_evento;
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
        },
        // Função para abrir o modal ao clicar em um dia
        dateClick: function(info) {
            var existingEvents = calendar.getEvents().filter(function(event) {
                return event.start.toDateString() === info.date.toDateString();
            });

            if (existingEvents.length > 0) {
                // Já existe evento neste dia, mostrar modal de confirmação
                if (!confirm('Já existe algo agendado para este dia. Quer prosseguir?')) {
                    return;
                }
            }

            $('#eventoModal').modal('show'); // Mostrar o modal

            // Definir a data inicial no modal (manter as horas em "--:--")
            var dataInicio = info.dateStr.split('T')[0];
            $('#inicio').val(dataInicio + 'T00:00');

            // Preencher data fim com a mesma data de início (manter as horas em "--:--")
            $('#fim').val(dataInicio + 'T00:00');

            // Ocultar o botão de exclusão
            $('#btnExcluirEvento').hide();

            // Limpar valores do modal ao fechar
            $('#eventoModal').on('hidden.bs.modal', function() {
                $('#tipo_evento').val('');
                $('#inicio').val('');
                $('#fim').val('');
                $('#disciplina').val('');
                // Definir o valor do destinatário com base no userOuTurma do evento
                var userOuTurmaEvento = evento.extendedProps.destinatario;
                $('#destinatario').val(userOuTurmaEvento);

                // Atualizar o campo oculto com o valor atual do destinatário
                $('#destinatarioHidden').val(userOuTurmaEvento);
            });
        },

        // Função para abrir o modal ao clicar em um evento existente
        eventClick: function(info) {
            var evento = info.event;

            $('#eventoModal').modal('show'); // Mostrar o modal

            // Preencher campos do modal com os dados do evento clicado
            $('#id_evento').val(evento.id);
            $('#title').val(evento.title);
            $('#tipo_evento').val(evento.extendedProps.tipo_evento);
            $('#nota').val(evento.extendedProps.description);

            // Adicionando uma unidade à parte das horas em 'inicio'
            var inicio = new Date(evento.start);
            inicio.setHours(inicio.getHours() + 1); // Adiciona 1 hora à data de início
            var inicioFormatado = inicio.toISOString().slice(0, 16); // Formato YYYY-MM-DDTHH:mm
            $('#inicio').val(inicioFormatado);

            // Verificar se há uma data de término e preencher o campo Fim
            if (evento.end) {
                var fim = new Date(evento.end);
                fim.setHours(fim.getHours() + 1); // Adiciona 1 hora à data de término
                var fimFormatado = fim.toISOString().slice(0, 16); // Formato YYYY-MM-DDTHH:mm
                $('#fim').val(fimFormatado);
            }


            // Preencher campo Disciplina com base no cod_dis do evento
            var codDisEvento = evento.extendedProps.disciplina;
            $('#disciplina').val(codDisEvento);

            // Preencher campo Destinatário com base no userOuTurma do evento
            var userOuTurmaEvento = evento.extendedProps.destinatario;
            $('#destinatario').val(userOuTurmaEvento);

            // Atualizar o campo oculto com o valor atual do destinatário
            $('#destinatarioHidden').val(userOuTurmaEvento);
            // Preencher o campo oculto com o id_evento do evento clicado
            $('#id_evento').val(evento.id);

            // Mostrar ou ocultar botão de exclusão com base no tipo de usuário e evento
            var tipoEvento = evento.extendedProps.tipo_evento;
            var userRole = <?php echo $_SESSION["type"]; ?>;
            var criadorEvento = evento.extendedProps.criadorEvento;

            if (userRole === 2 && criadorEvento !== '<?php echo $_SESSION["username"]; ?>') {
                // Usuário é tipo 2 (Professor) mas não é o criador do evento
                $('#tipo_evento').prop('disabled', true);
                $('#title').prop('readonly', true);
                $('#nota').prop('readonly', true);
                $('#inicio').prop('disabled', true);
                $('#fim').prop('disabled', true);
                $('#disciplina').prop('disabled', true);
                $('#btnExcluirEvento').hide();
                $('#btnSalvarEvento').hide();
            } else {
                // Usuário é tipo 2 e é o criador do evento ou é tipo 3 (Administrador)
                $('#tipo_evento').prop('disabled', false);
                $('#title').prop('readonly', false);
                $('#nota').prop('readonly', false);
                $('#inicio').prop('disabled', false);
                $('#fim').prop('disabled', false);
                $('#disciplina').prop('disabled', false);
                $('#btnExcluirEvento').show();
                $('#btnSalvarEvento').show();
            }

            // Limpar valores do modal ao fechar
            $('#eventoModal').on('hidden.bs.modal', function() {
                $('#tipo_evento').val('');
                $('#title').val('');
                $('#nota').val('');
                $('#id_evento').val('');
                $('#tipo_evento').val('');
                $('#inicio').val('');
                $('#fim').val('');
                $('#disciplina').val('');
                // Definir o valor do destinatário com base no campo oculto
                var selecao = $('#selecao').val(); // Obter o valor da seleção inicial
                $('#destinatario').val(selecao); // Preencher o campo de destinatário com o valor da seleção

                // Habilitar todos os campos novamente ao fechar o modal
                $('#tipo_evento').prop('disabled', false);
                $('#title').prop('readonly', false);
                $('#nota').prop('readonly', false);
                $('#inicio').prop('disabled', false);
                $('#fim').prop('disabled', false);
                $('#disciplina').prop('disabled', false);
            });
        }
    });

    calendar.render();

    // Enviar dados do evento ao formulário de processamento
    $('#formEvento').submit(function(e) {
        e.preventDefault();

        var formData = $(this).serialize(); // Obter dados do formulário
        formData += '&destinatario=' + $('#destinatario').val(); // Adicionar o valor correto do destinatário

        $.post('processar_evento.php', formData, function(response) {
            // Substituir o alert por um modal de sucesso
            $('#eventoModal').modal('hide'); // Ocultar o modal de evento
            $('#successModal .modal-body').text(response); // Definir mensagem de sucesso no modal
            $('#successModal').modal('show'); // Mostrar modal de sucesso
        }).fail(function(xhr, status, error) {
            // Em caso de falha, exibir modal de erro
            $('#errorModal .modal-body').text("Ocorreu um erro ao processar o evento: " + xhr.responseText);
            $('#errorModal').modal('show');
        });
    });

    // Excluir evento ao clicar no botão de exclusão
    $('#btnExcluirEvento').click(function() {
        var idEvento = $('#id_evento').val();

        $.post('processar_evento.php', { id_evento: idEvento, acao: 'excluir' }, function(response) {
            // Substituir o alert por um modal de sucesso
            $('#eventoModal').modal('hide'); // Ocultar o modal de evento
            $('#successModal .modal-body').text(response); // Definir mensagem de sucesso no modal
            $('#successModal').modal('show'); // Mostrar modal de sucesso
        }).fail(function(xhr, status, error) {
            // Em caso de falha, exibir modal de erro
            $('#errorModal .modal-body').text("Ocorreu um erro ao excluir o evento: " + xhr.responseText);
            $('#errorModal').modal('show');
        });
    });

    // Evento acionado quando o modal de sucesso é fechado
    $('#successModal').on('hidden.bs.modal', function () {
        // Recarregar os eventos no calendário após adicionar/editar
        calendar.refetchEvents();
        location.reload();
    });

    // Evento acionado quando o modal de erro é fechado
    $('#errorModal').on('hidden.bs.modal', function () {
        // Recarregar os eventos no calendário após adicionar/editar
        calendar.refetchEvents();
        location.reload();
    });



});
</script>


</body>
</html>

<?php
$mysqli->close();
?>

<?php include 'footer-reservado.php' ?>