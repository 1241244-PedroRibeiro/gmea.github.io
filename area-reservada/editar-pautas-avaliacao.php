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

?>

<!DOCTYPE html>
<html lang="pt">
<head>
    <meta charset="UTF-8">
    <title>Edição de Avaliações</title>
    <script src="https://use.fontawesome.com/releases/v6.3.0/js/all.js" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.3.1/jquery.min.js" crossorigin="anonymous"></script>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js"></script>
    <link href="https://netdna.bootstrapcdn.com/font-awesome/3.2.1/css/font-awesome.css" rel="stylesheet">
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
        if ($_SESSION["type"] == 3) { // Mostrar cabeçalho para professores
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
    <h2>Edição de Avaliações</h2>
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


    <div id="resultados-container" class="mt-4 row">
        <!-- Aqui serão inseridos os cards dinamicamente -->
    </div>

    <!-- Botão para Atualizar os Dados -->
    <div class="mt-4">
        <button type="button" id="btnAtualizar" class="btn btn-primary">Atualizar Dados</button>
    </div>

</div>

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
$(document).ready(function() {
    var cardElement = $('.custom-card');
        // Esconder o botão ao carregar a página
        $('#btnAtualizar').hide();

    function calcularEAtualizarSugestaoNivel(card) {
        var aproveitamento = parseInt(card.find('select[name="aproveitamento"]').val()) || 0;
        var atitudes = parseInt(card.find('select[name="atitudes"]').val()) || 0;
        var empenho = parseInt(card.find('select[name="empenho"]').val()) || 0;
        var media = parseFloat(card.find('input[name="media"]').val()) || 0;

        var sugestaoNivel = (aproveitamento * 5) + (atitudes * 5) + (empenho * 5) + ((media * 25) / 200);
        sugestaoNivel = Math.round(sugestaoNivel * 10) / 10;

        var escala = parseInt(card.find('select[name="escala"]').val());
        var nivelValue;

        if (escala === 1) {
            nivelValue = Math.round((sugestaoNivel * 5) / 100);
        } else if (escala === 2) {
            nivelValue = Math.round(sugestaoNivel / 5);
        }

        card.find('input[name="sugestao_nivel"]').val(nivelValue);
    }

    cardElement.each(function() {
        var card = $(this);
        calcularEAtualizarSugestaoNivel(card);
    });

    $(document).on('change', 'select[name="aproveitamento"], select[name="atitudes"], select[name="empenho"], input[name="media"], select[name="escala"]', function() {
        var card = $(this).closest('.custom-card');
        calcularEAtualizarSugestaoNivel(card);
    });

    $('#selecaoForm').submit(function(event) {
        event.preventDefault();

        var selectedUser = $('select[name="selecao"]').val();
        var selectedDisciplina = $('select[name="selecao_disciplina"]').val();
        var selectedTipoAvaliacao = $('select[name="selecao_tipo_avaliacao"]').val();

        $.ajax({
            url: 'obter_pautas_avaliacao.php',
            method: 'POST',
            data: {
                userOuTurma: selectedUser,
                disciplina: selectedDisciplina,
                tipoAvaliacao: selectedTipoAvaliacao
            },
            dataType: 'html',
            success: function(response) {
                $('#resultados-container').html(response);
                var cards = $('.custom-card');
                carregarAvaliacoes(cards);

                // Após carregar os resultados e preparar os cards, mostrar o botão se houver uma seleção válida
                if (selectedUser !== '') {
                    $('#btnAtualizar').show();
                }
            },
            error: function(xhr, status, error) {
                console.error(error);
            }
        });
    });

    $('#selecao').change(function() {
        var selectedUser = $(this).val();

        $.ajax({
            url: 'obter_disciplinas.php',
            method: 'POST',
            data: { selectedUser: selectedUser },
            dataType: 'json',
            success: function(response) {
                var selecaoDisciplina = $('#selecao_disciplina');
                selecaoDisciplina.empty();

                selecaoDisciplina.append($('<option>', {
                    value: '',
                    text: 'Selecionar Disciplina'
                }));

                $.each(response, function(index, item) {
                    selecaoDisciplina.append($('<option>', {
                        value: item.cod_dis,
                        text: '(' + item.cod_dis + ') ' + item.nome_dis
                    }));
                });
            },
            error: function(xhr, status, error) {
                console.error(error);
            }
        });
    });

    function carregarAvaliacoes(cards) {
        cards.each(function() {
            var card = $(this);
            var user = card.find('.card-title').text().split(' - ')[0];
            var disciplina = $('select[name="selecao_disciplina"]').val();

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

                            num += tipoAvaliacao;
                        }
                    });

                    var finalMedia = (num > 0) ? (media / num) : 0;
                    finalMedia = Math.round(finalMedia * 10) / 10;

                    card.find('input[name="media"]').val(finalMedia);
                    calcularEAtualizarSugestaoNivel(card);
                },
                error: function(xhr, status, error) {
                    console.error(error);
                }
            });
        });
    }

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

console.log('aa');
    $(document).on('click', '#btnAtualizar', function() {
        var cards = $('.custom-card');

        cards.each(function() {
            var card = $(this);
            var user = card.find('.card-title').text().split(' - ')[0];
            var idPauta = card.find('input[name="id_pauta"]').val();
            var aproveitamento = card.find('select[name="aproveitamento"]').val();
            var atitudes = card.find('select[name="atitudes"]').val();
            var empenho = card.find('select[name="empenho"]').val();
            var observacoes = card.find('textarea[name="observacoes"]').val();
            var nivel = card.find('select[name="nivel"]').val();

            if (nivel !== null) {
                // Fazer requisição AJAX para o script PHP que irá processar a atualização
                $.ajax({
                    url: 'atualizar_pautas_avaliacao.php',
                    method: 'POST',
                    data: {
                        user: user,
                        id_pauta: idPauta,
                        aproveitamento: aproveitamento,
                        atitudes: atitudes,
                        empenho: empenho,
                        observacoes: observacoes,
                        nivel: nivel
                    },
                    dataType: 'json',
                    success: function(response) {
                        try {
                            var data = JSON.parse(response);
                            if (data.success) {
                                console.log('Dados atualizados com sucesso:', data);
                                location.reload();
                            } else {
                                console.error('Erro ao atualizar dados:', data.message);
                                location.reload();
                            }
                        } catch (error) {
                            console.error('Erro ao processar resposta:', error);
                            location.reload();
                        }
                    },
                    error: function(xhr, status, error) {
                        console.error('Erro ao atualizar dados:', error);
                        location.reload();
                    }
                });
            }
            else {
                // Fazer requisição AJAX para o script PHP que irá processar a atualização
                $.ajax({
                    url: 'atualizar_pautas_avaliacao.php',
                    method: 'POST',
                    data: {
                        user: user,
                        id_pauta: idPauta,
                        aproveitamento: aproveitamento,
                        atitudes: atitudes,
                        empenho: empenho,
                        observacoes: observacoes
                    },
                    dataType: 'json',
                    success: function(response) {
                        try {
                            var data = JSON.parse(response);
                            if (data.success) {
                                console.log('Dados atualizados com sucesso:', data);
                                location.reload();
                            } else {
                                console.error('Erro ao atualizar dados:', data.message);
                                location.reload();
                            }
                        } catch (error) {
                            console.error('Erro ao processar resposta:', error);
                            location.reload();
                        }
                    },
                    error: function(xhr, status, error) {
                        console.error('Erro ao atualizar dados:', error);
                        location.reload();
                    }
                });
            }
        });
    });


});


</script>


</body>
</html>

<?php include 'footer-reservado.php' ?>