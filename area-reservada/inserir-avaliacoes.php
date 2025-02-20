<?php
session_start();
include "./generals/config.php";
$mysqli = new mysqli($bd_host, $bd_user, $bd_password, $bd_database);

if ($mysqli->connect_error) {
    die('Erro: (' . $mysqli->connect_errno . ') ' . $mysqli->connect_error);
}


$username = $_SESSION["username"];
$options_query = "SELECT a.user, u.nome FROM alunos a ";
$options_query .= "INNER JOIN users1 u ON a.user = u.user ";
$options_query .= "WHERE a.prof_in1 = '$username' OR a.prof_in2 = '$username'";
$options_query .= " UNION ";
$options_query .= "SELECT cod_turma, CONCAT('Turma de: ', nome_turma) AS nome_turma FROM turmas WHERE prof_turma = '$username'";

// Consulta para obter o próximo ID de avaliação
$queryMaxId = "SELECT MAX(id_avaliacao) AS max_id FROM avaliacoes";
$resultMaxId = $mysqli->query($queryMaxId);
$row = $resultMaxId->fetch_assoc();
$maxId = $row['max_id'];
$idAvaliacao = ($maxId === null) ? 1 : $maxId + 1;

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
    <link href='generals/vendor/fullcalendar/packages/core/main.css' rel='stylesheet' />
    <link href='generals/vendor/fullcalendar/packages/daygrid/main.css' rel='stylesheet' />
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


<div class="container mt-4">

        <div class="row">
            <div class="col">
                <form id="acaoForm" action="acao_avaliacao.php" method="get" class="form-inline mb-4">
                    <div class="form-group mb-3">
                        <select id="acao" name="acao" class="form-control w-100">
                            <option value="">Selecionar</option>
                            <option value="inserir">Inserir Avaliação</option>
                            <option value="editar">Editar Avaliação</option>
                            <option value="eliminar">Eliminar Avaliação</option>
                        </select>
                    </div>
                </form>
            </div>
        </div>
        
        <!-- Botão na linha seguinte -->
        <div class="row">
            <div class="col">
                <button type="submit" form="acaoForm" class="btn btn-primary">Confirmar</button>
            </div>
        </div>
        <h2>Selecione o aluno ou turma para agendar eventos:</h2>
        <form id="selecaoForm" action="<?php echo $_SERVER['PHP_SELF']; ?>" method="post" class="row g-3 align-items-center">
            <div class="col-auto">
                <label for="selecao" class="visually-hidden">Seleção</label>
                <select id="selecao" name="selecao" class="form-select" required>
                    <option value="">Selecionar</option>
                    <?php
                    $options_result = $mysqli->query($options_query);
                    if ($options_result) {
                        while ($row = $options_result->fetch_assoc()) {
                            echo '<option value="' . $row["user"] . '">(' . $row["user"] . ') ' . $row["nome"] . '</option>';
                        }
                        $options_result->free();
                    }
                    ?>
                </select>
            </div>
            <div class="col-auto">
                <label for="selecao_disciplina" class="visually-hidden">Seleção Disciplina</label>
                <select id="selecao_disciplina" name="selecao_disciplina" class="form-select" required>
                    <option value="">Selecionar Disciplina</option>
                    <!-- Opções serão preenchidas dinamicamente pelo JavaScript -->
                </select>
            </div>
            <div class="col-auto">
                <label for="selecao_tipo_avaliacao" class="visually-hidden">Seleção Tipo de Avaliação</label>
                <select id="selecao_tipo_avaliacao" name="selecao_tipo_avaliacao" class="form-select" required>
                    <option value="">Selecionar Tipo de Avaliação</option>
                    <option value="1">Avaliação Intercalar</option>
                    <option value="2">Prova</option>
                    <option value="3">Trabalho</option>
                    <option value="4">Outro</option>
                </select>
            </div>
            <div class="col-auto">
                <button type="submit" name="prosseguir" class="btn btn-primary">Prosseguir</button>
            </div>
        </form>

    <div id="detalhes-container" class="mt-4 row">
        <!-- Aqui serão inseridos os cards dinamicamente -->
    </div>

    <div id='calendar'></div>

    <!-- Modal de sucesso -->
    <div class="modal fade" id="successModal" tabindex="-1" aria-labelledby="successModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
        <div class="modal-header">
            <h5 class="modal-title" id="successModalLabel">Sucesso!</h5>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">
            <!-- Mensagem de sucesso aqui -->
        </div>
        <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Fechar</button>
        </div>
        </div>
    </div>
    </div>

    <!-- Modal de erro -->
    <div class="modal fade" id="errorModal" tabindex="-1" aria-labelledby="errorModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
        <div class="modal-header">
            <h5 class="modal-title" id="errorModalLabel">Erro!</h5>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">
            <!-- Mensagem de erro aqui -->
        </div>
        <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Fechar</button>
        </div>
        </div>
    </div>
    </div>

</div>


<script src='generals/vendor/fullcalendar/packages/core/main.js'></script>
<script src='generals/vendor/fullcalendar/packages/daygrid/main.js'></script>
<script>
$(document).ready(function() {
    var calendar = null;
    var submeterButtonAdded = false;
    var detailsArray = [];

    $('#selecao').change(function() {
        var selectedUser = $(this).val();

        // Requisição AJAX para buscar disciplinas associadas ao aluno/turma selecionada
        $.ajax({
            url: 'obter_disciplinas.php',
            method: 'POST',
            data: { selectedUser: selectedUser },
            dataType: 'json',
            success: function(response) {
                var selecaoDisciplina = $('#selecao_disciplina');
                selecaoDisciplina.empty(); // Limpar as opções existentes

                // Adicionar opção padrão
                selecaoDisciplina.append($('<option>', {
                    value: '',
                    text: 'Selecionar Disciplina'
                }));

                // Adicionar as novas opções com base na resposta da requisição
                $.each(response, function(index, item) {
                    selecaoDisciplina.append($('<option>', {
                        value: item.cod_dis,
                        text: '(' + item.cod_dis + ') ' + item.nome_dis
                    }));
                });
            },
            error: function(xhr, status, error) {
                console.error(error);
                // Lidar com erro, se necessário
            }
        });
    });

    $('#selecaoForm').submit(function(event) {
        event.preventDefault();

        var selecionado = $('select[name="selecao"]').val();
        
        if (selecionado) {
            $.ajax({
                url: 'obter_detalhes.php',
                method: 'POST',
                data: { selecionado: selecionado },
                dataType: 'json',
                success: function(response) {
                    $('#detalhes-container').empty();

                    response.forEach(function(detalhes, index) {
                        var cardHtml = '<div class="custom-card card col-lg-4 col-md-6 mb-4">';
                        cardHtml += '<img src="' + detalhes.foto + '" class="card-img-top" alt="Foto">';
                        cardHtml += '<div class="card-body">';
                        cardHtml += '<h5 class="card-title">' + detalhes.user + ' - ' + detalhes.nome + '</h5>';
                        cardHtml += '<select class="form-control mt-2 selecao-escala" name="escala" required>';
                        cardHtml += '<option value="">Selecionar Escala</option>';
                        cardHtml += '<option value="1">0 a 5</option>';
                        cardHtml += '<option value="2">0 a 100</option>';
                        cardHtml += '<option value="3">0 a 200</option>';
                        cardHtml += '</select>';
                        cardHtml += '<div class="form-group mt-2 nivel-container" style="display: none;">';
                        cardHtml += '<label for="nivel">Nível:</label>';
                        cardHtml += '<select class="form-control" name="nivel"></select>';
                        cardHtml += '</div>';
                        cardHtml += '<div class="form-group mt-2 observacoes-container" style="display: none;">';
                        cardHtml += '<label for="observacoes">Observações:</label>';
                        cardHtml += '<textarea class="form-control" name="observacoes" rows="3" id="observacoes-' + index + '"></textarea>';
                        cardHtml += '</div>';
                        cardHtml += '<input type="date" class="form-control mt-2" name="dataAvaliacao" required>';
                        cardHtml += '</div>';
                        cardHtml += '</div>';

                        $('#detalhes-container').append(cardHtml);
                    });

                    if (!submeterButtonAdded) {
                        $('#detalhes-container').after('<button class="btn btn-primary ml-auto mb-3" id="btn-submeter">Submeter</button>');
                        submeterButtonAdded = true;
                    }
                }
            });

            $(document).on('click', '#btn-submeter', function() {
                detailsArray = []; // Limpar o array antes de preencher com os dados dos cards

                $('.custom-card').each(function() {
                    var card = $(this);
                    var escala = card.find('select[name="escala"]').val();
                    if (escala === '1') {
                        var nivel = card.find('select[name="nivel"]').val(); // Corrigido o seletor
                    } else {
                        var nivel = card.find('input[name="nivel"]').val(); // Corrigido o seletor
                    }
                    var observacoes = card.find('textarea[name="observacoes"]').val();
                    var dataAvaliacao = card.find('input[name="dataAvaliacao"]').val();
                    var user = card.find('.card-title').text().split(' - ')[0].trim();
                    var detailObject = {
                        id_avaliacao: '<?php print($idAvaliacao); ?>',
                        tipo_avaliacao: $('select[name="selecao_tipo_avaliacao"]').val(),
                        escala: escala,
                        nivel: nivel,
                        notas: observacoes,
                        data_avaliacao: dataAvaliacao,
                        data_inserido: new Date().toISOString().slice(0, 10), // Data atual no formato YYYY-MM-DD
                        prof: '<?php echo $username; ?>',
                        disciplina: $('select[name="selecao_disciplina"]').val(),
                        user: user,
                        userOuTurma: $('select[name="selecao"]').val()
                    };

                    detailsArray.push(detailObject);
                });

                // Enviar dados para o servidor
                $.ajax({
                    type: 'POST',
                    url: 'processar_avaliacoes.php',
                    data: { detailsArray: detailsArray },
                    dataType: 'json',
                    success: function(response) {
                        $('#successModal .modal-body').text('Avaliações inseridas com sucesso!');
                        $('#successModal').modal('show');
                    },
                    error: function(xhr, status, error) {
                        $('#errorModal .modal-body').text('Erro ao inserir as avaliações.');
                        $('#errorModal').modal('show');
                    }

                });
            });

            $.ajax({
                url: 'obter_eventos.php',
                method: 'POST',
                data: { selecionado: selecionado },
                dataType: 'json',
                success: function(response) {
                    if (calendar) {
                        calendar.getEventSources().forEach(function(eventSource) {
                            eventSource.remove();
                        });
                        calendar.addEventSource(response);
                    } else {
                        initializeCalendar(response);
                    }
                }
            });
        } else {
            $('#detalhes-container').empty();

            if (calendar) {
                calendar.destroy();
                calendar = null;
                $('#calendar').empty();
            }
        }
    });

    $(document).on('change', '.selecao-escala', function() {
        var selectedValue = $(this).val();
        var parentCard = $(this).closest('.custom-card');
        var nivelContainer = parentCard.find('.nivel-container');
        var observacoesContainer = parentCard.find('.observacoes-container');

        if (selectedValue === '1') {
            nivelContainer.html('<select class="form-control" name="nivel" required><option value="0">0</option><option value="1">1</option><option value="2">2</option><option value="3">3</option><option value="4">4</option><option value="5">5</option></select>');
        } else if (selectedValue === '2') {
            nivelContainer.html('<input type="number" class="form-control" name="nivel" min="0" max="100" required>');
        } else if (selectedValue === '3') {
            nivelContainer.html('<input type="number" class="form-control" name="nivel" min="0" max="200" required>');
        }

        nivelContainer.show();
        observacoesContainer.show();
    });

    function initializeCalendar(events) {
        var calendarEl = document.getElementById('calendar');
        calendar = new FullCalendar.Calendar(calendarEl, {
            plugins: ['dayGrid'],
            header: {
                left: 'prev,next today',
                center: 'title',
                right: 'dayGridMonth,timeGridWeek,timeGridDay'
            },
            buttonText: {
                today: 'Hoje',
                month: 'Mês',
                week: 'Semana',
                day: 'Dia'
            },
            events: events
        });
        calendar.render();
    }
});

$('#successModal').on('hidden.bs.modal', function (e) {
    location.reload();
});
</script>



</body>
</html>

<?php include 'footer-reservado.php' ?>