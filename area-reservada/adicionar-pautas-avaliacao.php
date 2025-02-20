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

// Consulta para obter o máximo id_pauta da tabela pautas_avaliacao
$sql1 = "SELECT MAX(id_pauta) AS max_id FROM pautas_avaliacao";
$result1 = $mysqli->query($sql1);
$row1 = $result1->fetch_assoc(); // Usando fetch_assoc() para obter o resultado como array associativo
$maxId1 = $row1['max_id'] + 1; // Incrementando o valor máximo em 1

// Consulta para obter o máximo id_pauta da tabela pautas_avaliacao_intercalar
$sql2 = "SELECT MAX(id_pauta) AS max_id FROM pautas_avaliacao_intercalar";
$result2 = $mysqli->query($sql2);
$row2 = $result2->fetch_assoc(); // Usando fetch_assoc() para obter o resultado como array associativo
$maxId2 = $row2['max_id'] + 1; // Incrementando o valor máximo em 1

// Aqui você pode usar $maxId1 e $maxId2 conforme necessário
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

<div class="container mt-4">
        <div class="row">
            <div class="col">
                <form id="acaoForm" action="acao_pautas.php" method="get" class="form-inline mb-4">
                    <div class="form-group mb-3">
                        <select id="acao" name="acao" class="form-control w-100">
                            <option value="">Selecionar</option>
                            <option value="inserir">Inserir Avaliação</option>
                            <option value="editar">Editar Avaliação</option>
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
    <h2>Selecione o aluno ou turma para gerir a pauta:</h2>
    <form id="selecaoForm" action="<?php echo $_SERVER['PHP_SELF']; ?>" method="post" class="row g-3 align-items-center">
        <div class="col-auto">
            <label for="selecao" class="visually-hidden">Selecionar</label>
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
            <label for="selecao_disciplina" class="visually-hidden">Selecionar Disciplina</label>
            <select id="selecao_disciplina" name="selecao_disciplina" class="form-select" required>
                <option value="">Selecionar Disciplina</option>
                <!-- Opções serão preenchidas dinamicamente pelo JavaScript -->
            </select>
        </div>
        <div class="col-auto">
            <label for="selecao_tipo_avaliacao" class="visually-hidden">Selecionar Tipo de Avaliação</label>
            <select id="selecao_tipo_avaliacao" name="selecao_tipo_avaliacao" class="form-select" required>
                <option value="">Selecionar Tipo de Avaliação</option>
                <option value="1">Avaliação Intercalar - Primeiro Semestre</option>
                <option value="2">Avaliação Intercalar - Segundo Semestre</option>
                <option value="3">Avaliação - Primeiro Semestre</option>
                <option value="4">Avaliação - Segundo Semestre</option>
            </select>
        </div>
        <div class="col-auto">
            <button type="submit" name="prosseguir" class="btn btn-primary">Prosseguir</button>
        </div>
    </form>


    <div id="detalhes-container" class="mt-4 row">
        <!-- Aqui serão inseridos os cards dinamicamente -->
    </div>
</div>


<div class="modal fade" id="successModal" tabindex="-1" aria-labelledby="successModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="successModalLabel">Sucesso!</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        Os dados da pauta foram registrados com sucesso!
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-primary" data-bs-dismiss="modal">Fechar</button>
      </div>
    </div>
  </div>
</div>

<div class="modal fade" id="errorModal" tabindex="-1" aria-labelledby="errorModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="errorModalLabel">Erro!</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        Já existem dados registados para esta pauta. Seleccione "Editar" caso pretenda alterá-los.
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-primary" data-bs-dismiss="modal">Fechar</button>
      </div>
    </div>
  </div>
</div>

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
$(document).ready(function() {
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


        detailsArray = []; // Limpar o array antes de preencher com os dados dos cards

        if (selecionado) {
            $.ajax({
                url: 'obter_detalhes.php',
                method: 'POST',
                data: { selecionado: selecionado },
                dataType: 'json',
                success: function(response) {
                    $('#detalhes-container').empty();

                    response.forEach(function(detalhes) {
                        var cardHtml = '<div class="custom-card card col-lg-4 col-md-6 mb-4">';
                        cardHtml += '<img src="' + detalhes.foto + '" class="card-img-top" alt="Foto">';
                        cardHtml += '<div class="card-body">';
                        cardHtml += '<h5 class="card-title">' + detalhes.user + ' - ' + detalhes.nome + '</h5>';

                        // Adicionar campos com base no tipo de avaliação selecionado
                        var tipoAvaliacao = $('select[name="selecao_tipo_avaliacao"]').val();
                        if (tipoAvaliacao == '1' || tipoAvaliacao == '2') {
                            cardHtml += '<div class="form-group">';
                            cardHtml += '<label for="aproveitamento">Aproveitamento:</label>';
                            cardHtml += '<select class="form-control" name="aproveitamento" required>';
                            cardHtml += '<option value="">Selecionar</option>';
                            cardHtml += '<option value="0">Nível 0 - Não existem dados suficientes para avaliar</option>';
                            cardHtml += '<option value="1">Nível 1 - Apresenta um aproveitamento fraco</option>';
                            cardHtml += '<option value="2">Nível 2 - Apresenta um mau aproveitamento</option>';
                            cardHtml += '<option value="3">Nível 3 - Apresenta um aproveitamento razoável</option>';
                            cardHtml += '<option value="4">Nível 4 - Apresenta um bom aproveitamento</option>';
                            cardHtml += '<option value="5">Nível 5 - Apresenta um ótimo aproveitamento</option>';
                            cardHtml += '</select>';
                            cardHtml += '</div>';

                            cardHtml += '<div class="form-group">';
                            cardHtml += '<label for="atitudes">Atitudes e Valores:</label>';
                            cardHtml += '<select class="form-control" name="atitudes" required>';
                            cardHtml += '<option value="">Selecionar</option>';
                            cardHtml += '<option value="0">Nível 0 - Não existem dados suficientes para avaliar</option>';
                            cardHtml += '<option value="1">Nível 1 - Revela um fraco comportamento</option>';
                            cardHtml += '<option value="2">Nível 2 - Apresenta um mau comportamento</option>';
                            cardHtml += '<option value="3">Nível 3 - Revela um comportamento razoável</option>';
                            cardHtml += '<option value="4">Nível 4 - Revela um bom comportamento</option>';
                            cardHtml += '<option value="5">Nível 5 - Demonstra um ótimo comportamento</option>';
                            cardHtml += '</select>';
                            cardHtml += '</div>';

                            cardHtml += '<div class="form-group">';
                            cardHtml += '<label for="empenho">Empenho e Cumprimento de Tarefas:</label>';
                            cardHtml += '<select class="form-control" name="empenho" required>';
                            cardHtml += '<option value="">Selecionar</option>';
                            cardHtml += '<option value="0">Nível 0 - Não existem dados suficientes para avaliar</option>';
                            cardHtml += '<option value="1">Nível 1 - Não revela interesse nem demonstra boa compreensão de conceitos</option>';
                            cardHtml += '<option value="2">Nível 2 - Revela pouco interesse e fraca compreensão de conceitos</option>';
                            cardHtml += '<option value="3">Nível 3 - Revela algum interesse e razoável compreensão de conceitos</option>';
                            cardHtml += '<option value="4">Nível 4 - Revela interesse e boa compreensão de conceitos</option>';
                            cardHtml += '<option value="5">Nível 5 - Revela bastante interesse e ótima compreensão de conceitos</option>';
                            cardHtml += '</select>';
                            cardHtml += '</div>';

                            cardHtml += '<div class="form-group">';
                            cardHtml += '<label for="observacoes">Observações:</label>';
                            cardHtml += '<textarea class="form-control" name="observacoes" rows="3"></textarea>';
                            cardHtml += '</div>';
                        } else if (tipoAvaliacao == '3' || tipoAvaliacao == '4') {

                            cardHtml += '<div class="form-group">';
                            cardHtml += '<label for="escala">Escala:</label>';
                            cardHtml += '<select class="form-control" name="escala" required>';
                            cardHtml += '<option value="">Selecionar</option>';
                            cardHtml += '<option value="1">0 a 5</option>';
                            cardHtml += '<option value="2">0 a 20</option>';
                            cardHtml += '</select>';
                            cardHtml += '</div>';
                            
                            cardHtml += '<div class="form-group">';
                            cardHtml += '<label for="aproveitamento">Aproveitamento:</label>';
                            cardHtml += '<select class="form-control" name="aproveitamento" required>';
                            cardHtml += '<option value="">Selecionar</option>';
                            cardHtml += '<option value="0">Nível 0 - Não existem dados suficientes para avaliar</option>';
                            cardHtml += '<option value="1">Nível 1 - Apresenta um aproveitamento fraco</option>';
                            cardHtml += '<option value="2">Nível 2 - Apresenta um mau aproveitamento</option>';
                            cardHtml += '<option value="3">Nível 3 - Apresenta um aproveitamento razoável</option>';
                            cardHtml += '<option value="4">Nível 4 - Apresenta um bom aproveitamento</option>';
                            cardHtml += '<option value="5">Nível 5 - Apresenta um ótimo aproveitamento</option>';
                            cardHtml += '</select>';
                            cardHtml += '</div>';

                            cardHtml += '<div class="form-group">';
                            cardHtml += '<label for="atitudes">Atitudes e Valores:</label>';
                            cardHtml += '<select class="form-control" name="atitudes" required>';
                            cardHtml += '<option value="">Selecionar</option>';
                            cardHtml += '<option value="0">Nível 0 - Não existem dados suficientes para avaliar</option>';
                            cardHtml += '<option value="1">Nível 1 - Revela um fraco comportamento</option>';
                            cardHtml += '<option value="2">Nível 2 - Apresenta um mau comportamento</option>';
                            cardHtml += '<option value="3">Nível 3 - Revela um comportamento razoável</option>';
                            cardHtml += '<option value="4">Nível 4 - Revela um bom comportamento</option>';
                            cardHtml += '<option value="5">Nível 5 - Demonstra um ótimo comportamento</option>';
                            cardHtml += '</select>';
                            cardHtml += '</div>';

                            cardHtml += '<div class="form-group">';
                            cardHtml += '<label for="empenho">Empenho e Cumprimento de Tarefas:</label>';
                            cardHtml += '<select class="form-control" name="empenho" required>';
                            cardHtml += '<option value="">Selecionar</option>';
                            cardHtml += '<option value="0">Nível 0 - Não existem dados suficientes para avaliar</option>';
                            cardHtml += '<option value="1">Nível 1 - Não revela interesse nem demonstra boa compreensão de conceitos</option>';
                            cardHtml += '<option value="2">Nível 2 - Revela pouco interesse e fraca compreensão de conceitos</option>';
                            cardHtml += '<option value="3">Nível 3 - Revela algum interesse e razoável compreensão de conceitos</option>';
                            cardHtml += '<option value="4">Nível 4 - Revela interesse e boa compreensão de conceitos</option>';
                            cardHtml += '<option value="5">Nível 5 - Revela bastante interesse e ótima compreensão de conceitos</option>';
                            cardHtml += '</select>';
                            cardHtml += '</div>';

                            cardHtml += '<div class="form-group">';
                            cardHtml += '<label for="observacoes">Observações:</label>';
                            cardHtml += '<textarea class="form-control" name="observacoes" rows="3"></textarea>';
                            cardHtml += '</div>';

                            cardHtml += '<div class="form-group">';
                            cardHtml += '<label for="media">Média das Avaliações:</label>';
                            cardHtml += '<input type="text" class="form-control" name="media" disabled>';
                            cardHtml += '</div>';

                            cardHtml += '<div class="form-group">';
                            cardHtml += '<label for="sugestao_nivel">Sugestão de Nível:</label>';
                            cardHtml += '<input type="text" class="form-control" name="sugestao_nivel" readonly value="0">';
                            cardHtml += '</div>';

                            cardHtml += '<div class="form-group">';
                            cardHtml += '<label for="nivel">Nível:</label>';
                            cardHtml += '<select class="form-control" name="nivel" required>';
                            cardHtml += '<option value="">Selecionar</option>';

                            cardHtml += '</select>';
                            cardHtml += '</div>';

                        }

                        cardHtml += '</div>';
                        cardHtml += '</div>';

                        $('#detalhes-container').append(cardHtml);

                        $('.custom-card').each(function() {
                            var card = $(this);

                            var aproveitamento = parseInt(card.find('select[name="aproveitamento"]').val()) || 0;
                            var atitudes = parseInt(card.find('select[name="atitudes"]').val()) || 0;
                            var empenho = parseInt(card.find('select[name="empenho"]').val()) || 0;
                            var media = parseFloat(card.find('input[name="media"]').val()) || 0;

                            // Cálculo da sugestão de nível
                            var sugestaoNivel = (aproveitamento * 5) + (atitudes * 5) + (empenho * 5) + ((media * 25) / 200);
                            sugestaoNivel = Math.round(sugestaoNivel * 10) / 10; // Arredonda para uma casa decimal

                            // Atualizar o campo de sugestão de nível no card atual
                            card.find('input[name="sugestao_nivel"]').val(sugestaoNivel);
                            
                            var user = card.find('.card-title').text().split(' - ')[0]; // Extrair o username
                            var disciplina = $('select[name="selecao_disciplina"]').val();
                            console.log(card);
                            console.log('Username atual:', user); // Verifique qual usuário está sendo usado nesta iteração
                            console.log(disciplina);

                            // Consultar avaliações relevantes para o usuário e disciplina
                            $.ajax({
                                url: 'obter_avaliacoes.php',
                                method: 'POST',
                                data: {
                                    user: user,
                                    disciplina: disciplina,
                                },
                                dataType: 'json',
                                success: function(response) {
                                    var media = 0;
                                    var num = 0;
                                    response.forEach(function(avaliacao) {
                                        if (avaliacao.user == user) {
                                            var escala = parseInt(avaliacao.escala);
                                            var nivel = parseInt(avaliacao.nivel);
                                            var tipoAvaliacao = parseInt(avaliacao.tipo_avaliacao);

                                            if (escala === 1) {
                                                media += (nivel * 40) * tipoAvaliacao;
                                            } else if (escala === 2) {
                                                media += (nivel * 2) * tipoAvaliacao;
                                            } else if (escala === 3) {
                                                media += nivel * tipoAvaliacao;
                                            }

                                            // Aplicar fator de multiplicação para o tipo de avaliação
                                            num = (num + tipoAvaliacao);
                                        }
                                    });

                                    // Calcular média final
                                    var finalMedia = (num > 0) ? (media / num) : 0;
                                    var finalMedia = Math.round(finalMedia * 10) / 10;

                                    // Atualizar o campo de texto "Média das Avaliações"
                                    card.find('input[name="media"]').val(finalMedia);
                                },
                                error: function(xhr, status, error) {
                                    console.error(error);
                                    // Lidar com erro, se necessário
                                }
                            });
                        });
                    });

                    if (!submeterButtonAdded) {
                        $('#detalhes-container').after('<button class="btn btn-primary ml-auto mb-3" id="btn-submeter">Submeter</button>');
                        submeterButtonAdded = true;
                    }
                }
            });
        } else {
            $('#detalhes-container').empty();
        }



    });

    // Lógica para submissão dos dados, igual ao seu código anterior
    $(document).on('click', '#btn-submeter', function() {
        // Coletar os detalhes de cada card e preparar para envio
        var detailsArray = [];
        var tipoAvaliacao = $('select[name="selecao_tipo_avaliacao"]').val();

        if (tipoAvaliacao == 1 || tipoAvaliacao == 2) {
            $('.custom-card').each(function() {
                var card = $(this);
                var user = card.find('.card-title').text().split(' - ')[0];
                var disciplina = $('select[name="selecao_disciplina"]').val();
                var aproveitamento = card.find('select[name="aproveitamento"]').val();
                var atitudes = card.find('select[name="atitudes"]').val();
                var empenho = card.find('select[name="empenho"]').val();
                var observacoes = card.find('textarea[name="observacoes"]').val();

                detailsArray.push({
                    user: user,
                    disciplina: disciplina,
                    aproveitamento: aproveitamento,
                    atitudes: atitudes,
                    empenho: empenho,
                    observacoes: observacoes,
                    semestre: $('select[name="selecao_tipo_avaliacao"]').val(),
                    userOuTurma: $('select[name="selecao"]').val(),
                    prof: '<?php print($username); ?>',
                    id_pauta: '<?php print($maxId2); ?>'
                });
                console.log(detailsArray);
            });

            // Enviar dados para processar_pauta.php via AJAX
            $.ajax({
                url: 'processar_pauta_intercalar.php',
                method: 'POST',
                data: { detailsArray: detailsArray },
                dataType: 'json',
                success: function(response) {
                    if (response.success) {
                        $('#successModal').on('hidden.bs.modal', function (e) {
                            location.reload();
                        }).modal('show');
                    } else {
                        $('#errorModal').modal('show');
                    }
                },
                error: function(xhr, status, error) {
                    console.error(error);
                    $('#errorModal').modal('show');
                }
            });

        } else if (tipoAvaliacao == 3 || tipoAvaliacao == 4) {
            $('.custom-card').each(function() {
                var card = $(this);
                var user = card.find('.card-title').text().split(' - ')[0];
                var disciplina = $('select[name="selecao_disciplina"]').val();
                var aproveitamento = card.find('select[name="aproveitamento"]').val();
                var escala = card.find('select[name="escala"]').val();
                var nivel = card.find('select[name="nivel"]').val();
                var atitudes = card.find('select[name="atitudes"]').val();
                var empenho = card.find('select[name="empenho"]').val();
                var observacoes = card.find('textarea[name="observacoes"]').val();
                var media = card.find('input[name="media"]').val();

                detailsArray.push({
                    user: user,
                    disciplina: disciplina,
                    aproveitamento: aproveitamento,
                    atitudes: atitudes,
                    empenho: empenho,
                    observacoes: observacoes,
                    escala: escala,
                    nivel: nivel,
                    semestre: $('select[name="selecao_tipo_avaliacao"]').val(),
                    userOuTurma: $('select[name="selecao"]').val(),
                    prof: '<?php print($username); ?>',
                    media: media,
                    id_pauta: '<?php print($maxId1); ?>'
                });
                console.log(detailsArray);
            });

            // Enviar dados para processar_pauta.php via AJAX
            $.ajax({
                url: 'processar_pauta.php',
                method: 'POST',
                data: { detailsArray: detailsArray },
                dataType: 'json',
                success: function(response) {
                    if (response.success) {
                        $('#successModal').on('hidden.bs.modal', function (e) {
                            location.reload();
                        }).modal('show');
                    } else {
                        $('#errorModal').modal('show');
                    }
                },
                error: function(xhr, status, error) {
                    console.error(error);
                    $('#errorModal').modal('show');
                }
            });
        }
    });


    $(document).on('change', 'select[name="escala"]', function() {
        var selectedValue = $(this).val();
        var nivelSelect = $(this).closest('.card-body').find('select[name="nivel"]');

        if (selectedValue == '1') {
            nivelSelect.empty();
            for (var i = 0; i <= 5; i++) {
                nivelSelect.append('<option value="' + i + '">' + i + '</option>');
            }

        } else if (selectedValue == '2') {
            nivelSelect.empty();
            for (var i = 0; i <= 20; i++) {
                nivelSelect.append('<option value="' + i + '">' + i + '</option>');
            }
        }
    });

    // Adicionar eventos para atualizar a sugestão de nível quando os campos forem alterados
    $(document).on('change', 'select[name="aproveitamento"], select[name="atitudes"], select[name="empenho"], input[name="media"]', function() {
        var card = $(this).closest('.custom-card');

        var aproveitamento = parseInt(card.find('select[name="aproveitamento"]').val()) || 0;
        var atitudes = parseInt(card.find('select[name="atitudes"]').val()) || 0;
        var empenho = parseInt(card.find('select[name="empenho"]').val()) || 0;
        var media = parseFloat(card.find('input[name="media"]').val()) || 0;

        // Cálculo da sugestão de nível
        var sugestaoNivel = (aproveitamento * 5) + (atitudes * 5) + (empenho * 5) + ((media * 25) / 200);
        sugestaoNivel = Math.round(sugestaoNivel * 10) / 10; // Arredonda para uma casa decimal

        var escala = parseInt(card.find('select[name="escala"]').val());
        if (escala === 1) {
            // Calcular e atualizar o valor do nível de acordo com a escala 0 a 5
            var nivelValue = Math.round((sugestaoNivel * 5) / 100);
            card.find('select[name="nivel"]').val(nivelValue);
            // Atualizar o campo de sugestão de nível no card atual
            card.find('input[name="sugestao_nivel"]').val(nivelValue);
        } else if (escala === 2) {
            // Calcular e atualizar o valor do nível de acordo com a escala 0 a 20
            var nivelValue = Math.round(sugestaoNivel / 5);
            card.find('select[name="nivel"]').val(nivelValue);
            // Atualizar o campo de sugestão de nível no card atual
            card.find('input[name="sugestao_nivel"]').val(nivelValue)
        }
    });
});
</script>



</body>
</html>

<?php include 'footer-reservado.php' ?>