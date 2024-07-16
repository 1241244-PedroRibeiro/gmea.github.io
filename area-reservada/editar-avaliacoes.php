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

// Verificar se o formulário foi enviado
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['selecao']) && isset($_POST['selecao_disciplina']) && isset($_POST['selecao_tipo_avaliacao'])) {
    $selecao = $mysqli->real_escape_string($_POST['selecao']);
    $disciplina = $mysqli->real_escape_string($_POST['selecao_disciplina']);
    $tipo_avaliacao = $mysqli->real_escape_string($_POST['selecao_tipo_avaliacao']);

    // Consulta para obter as avaliações filtradas
    $queryAvaliacoes = "SELECT DISTINCT id_avaliacao, tipo_avaliacao, userOuTurma, data_inserido FROM avaliacoes ";
    $queryAvaliacoes .= "WHERE userOuTurma = '$selecao' AND disciplina = '$disciplina' AND tipo_avaliacao = '$tipo_avaliacao' ";
    $queryAvaliacoes .= "ORDER BY data_inserido DESC";

    $resultAvaliacoes = $mysqli->query($queryAvaliacoes);
}
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
        if ($_SESSION["type"] == 3) {
            include "header-direcao.php";
        }
        if ($_SESSION["type"] == 4) { // Mostrar cabeçalho para professores
            include "header-professor-direcao.php";
        } 

    ?>

    <div class="container mt-4">
        <!-- Main Content -->
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
    <h2>Edição de Avaliações</h2>
    <form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="post" class="row g-3 align-items-center">
        <div class="col-auto">
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
            <select id="selecao_disciplina" name="selecao_disciplina" class="form-select" required>
                <option value="">Selecionar Disciplina</option>
                <!-- Opções serão preenchidas dinamicamente pelo JavaScript -->
            </select>
        </div>
        <div class="col-auto">
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


    <?php if (isset($resultAvaliacoes) && $resultAvaliacoes->num_rows > 0): ?>
        <form method="post">
            <div class="form-group mt-4">
                <label for="selectAvaliacao">Selecione uma Avaliação:</label>
                <select id="selectAvaliacao" name="selectAvaliacao" class="form-control" required>
                    <option value="">Selecione</option>
                    <?php while ($row = $resultAvaliacoes->fetch_assoc()): ?>
                        <?php
                        // Determinar o tipo de avaliação com base no valor armazenado no banco
                        $tipoAvaliacaoLabel = ($row['tipo_avaliacao'] == 1) ? "Avaliação Intercalar" :
                                            ($row['tipo_avaliacao'] == 2 ? "Prova" :
                                            ($row['tipo_avaliacao'] == 3 ? "Trabalho" : "Outro"));

                        // Determinar se é aluno ou turma com base no valor de userOuTurma
                        $isAluno = (strtolower(substr($row['userOuTurma'], 0, 1)) === 'a');
                        
                        // Se for aluno, buscar o nome na tabela users1 usando o user
                        // Se for turma, buscar o nome_turma na tabela turmas usando o cod_turma
                        $nome = '';
                        if ($isAluno) {
                            $queryNome = "SELECT nome FROM users1 WHERE user = '{$row['userOuTurma']}'";
                            $resultNome = $mysqli->query($queryNome);
                            if ($resultNome && $resultNome->num_rows > 0) {
                                $nome = $resultNome->fetch_assoc()['nome'];
                            }
                        } else {
                            $queryNome = "SELECT nome_turma FROM turmas WHERE cod_turma = '{$row['userOuTurma']}'";
                            $resultNome = $mysqli->query($queryNome);
                            if ($resultNome && $resultNome->num_rows > 0) {
                                $nome = $resultNome->fetch_assoc()['nome_turma'];
                            }
                        }

                        // Montar a opção para o select
                        $optionLabel = "$tipoAvaliacaoLabel - ({$row['userOuTurma']}) $nome - Inserida a: {$row['data_inserido']}";
                        ?>
                        <option value="<?php echo $row['id_avaliacao']; ?>">
                            <?php echo $optionLabel; ?>
                        </option>
                    <?php endwhile; ?>
                </select>
            </div>
            <button type="submit" id="btnEditar" class="btn btn-primary">Editar Avaliação</button>
        </form>
    <?php elseif (isset($_POST['prosseguir'])): ?>
        <p class="mt-4">Nenhuma avaliação encontrada com os critérios selecionados.</p>
    <?php endif; ?>

    <!-- Container para exibir os detalhes da avaliação selecionada -->
    <div id="detalhes-container" class="row mt-4">
    <!-- Aqui serão inseridos os cards com os detalhes da avaliação -->
    </div>

</div>

<!-- Modal de sucesso -->
<div class="modal fade" id="successModal" tabindex="-1" aria-labelledby="successModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="successModalLabel">Sucesso!</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                Avaliação atualizada com sucesso.
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
                Ocorreu um erro ao atualizar a avaliação.
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Fechar</button>
            </div>
        </div>
    </div>
</div>


<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
$(document).ready(function() {
    var submeterButtonAdded = false;

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

    // Função para atualizar opções de nível com base na seleção da escala
    function atualizarOpcoesNivel(selectedElement) {
        var selectedValue = $(selectedElement).val();
        var parentCard = $(selectedElement).closest('.custom-card');
        var nivelContainer = parentCard.find('.nivel-container');
        var observacoesContainer = parentCard.find('.observacoes-container');

        // Limpar opções de nível existentes
        nivelContainer.empty();

        if (selectedValue === '1') {
            nivelContainer.html('<select class="form-control" name="nivel" required><option value="0">0</option><option value="1">1</option><option value="2">2</option><option value="3">3</option><option value="4">4</option><option value="5">5</option></select>');
        } else if (selectedValue === '2') {
            nivelContainer.html('<input type="number" class="form-control" name="nivel" min="0" max="100" required>');
        } else if (selectedValue === '3') {
            nivelContainer.html('<input type="number" class="form-control" name="nivel" min="0" max="200" required>');
        }

        nivelContainer.show(); // Mostrar o container de nível
        observacoesContainer.show(); // Mostrar o container de observações
    }

    $(document).on('click', '#btnEditar', function(event) {
        event.preventDefault(); // Evitar submissão tradicional do formulário

        var idAvaliacao = $('#selectAvaliacao').val(); // Obter o valor selecionado do select

        // Requisição AJAX para obter os detalhes da avaliação selecionada
        $.ajax({
            url: 'obter_detalhes_avaliacao.php',
            method: 'POST',
            data: { id_avaliacao: idAvaliacao },
            dataType: 'json',
            success: function(response) {
                console.log(response); // Verificar a resposta JSON no console

                $('#detalhes-container').empty(); // Limpar o container
                submeterButtonAdded = false; // Resetar flag para adicionar botão Submeter

                // Processar os detalhes da avaliação recebidos
                response.forEach(function(detalhes) {
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

                    // Verificar o valor da escala e exibir o campo de nível apropriado
                    if (detalhes.escala === '1') {
                        cardHtml += '<select class="form-control" name="nivel" required>' +
                            '<option value="0">0</option>' +
                            '<option value="1">1</option>' +
                            '<option value="2">2</option>' +
                            '<option value="3">3</option>' +
                            '<option value="4">4</option>' +
                            '<option value="5">5</option>' +
                            '</select>';
                    } else if (detalhes.escala === '2') {
                        cardHtml += '<input type="number" class="form-control" name="nivel" min="0" max="100" required>';
                    } else if (detalhes.escala === '3') {
                        cardHtml += '<input type="number" class="form-control" name="nivel" min="0" max="200" required>';
                    }

                    cardHtml += '</div>'; // Fechar nivel-container
                    cardHtml += '<div class="form-group mt-2 observacoes-container" style="display: none;">';
                    cardHtml += '<label for="observacoes">Observações:</label>';
                    cardHtml += '<textarea class="form-control" name="observacoes" rows="3" id="observacoes-' + detalhes.id + '"></textarea>';
                    cardHtml += '</div>'; // Fechar observacoes-container
                    cardHtml += '<input type="date" class="form-control mt-2 dataAvaliacao" name="dataAvaliacao" required>';
                    cardHtml += '</div>'; // Fechar card-body
                    cardHtml += '</div>'; // Fechar custom-card

                    $('#detalhes-container').append(cardHtml);

                    // Preencher o campo de escala se já estiver definido na resposta
                    if (detalhes.escala) {
                        $('#detalhes-container .selecao-escala:last').val(detalhes.escala);
                        atualizarOpcoesNivel($('#detalhes-container .selecao-escala:last')); // Atualizar opções de nível
                    }

                    // Preencher o campo de nível se já estiver definido na resposta
                    if (detalhes.nivel) {
                        var nivelContainer = $('#detalhes-container .nivel-container:last');

                        if (detalhes.escala === '1') {
                            // Escala de 0 a 5
                            nivelContainer.html('<select class="form-control" name="nivel" required>' +
                                '<option value="0">0</option>' +
                                '<option value="1">1</option>' +
                                '<option value="2">2</option>' +
                                '<option value="3">3</option>' +
                                '<option value="4">4</option>' +
                                '<option value="5">5</option>' +
                                '</select>');
                            nivelContainer.find('select[name="nivel"]').val(detalhes.nivel); // Selecionar o valor correto
                        } else if (detalhes.escala === '2') {
                            // Escala de 0 a 100
                            nivelContainer.html('<input type="number" class="form-control" name="nivel" min="0" max="100" required>');
                            nivelContainer.find('input[name="nivel"]').val(detalhes.nivel); // Preencher com o valor correto
                        } else if (detalhes.escala === '3') {
                            // Escala de 0 a 200
                            nivelContainer.html('<input type="number" class="form-control" name="nivel" min="0" max="200" required>');
                            nivelContainer.find('input[name="nivel"]').val(detalhes.nivel); // Preencher com o valor correto
                        }

                        nivelContainer.show(); // Mostrar o container de nível
                    }


                    // Preencher o campo de observações se já estiver definido na resposta
                    if (detalhes.observacoes) {
                        $('#detalhes-container #observacoes-' + detalhes.id).val(detalhes.observacoes);
                    }

                    // Preencher o campo de data da avaliação se já estiver definido na resposta
                    if (detalhes.data_avaliacao) {
                        $('#detalhes-container .dataAvaliacao:last').val(detalhes.data_avaliacao);
                    }
                });

                // Adicionar botão Submeter após adicionar os cards, se ainda não foi adicionado
                if (!submeterButtonAdded) {
                    $('#detalhes-container').after('<button class="btn btn-primary ml-auto mb-3" id="btn-submeter">Submeter</button>');
                    submeterButtonAdded = true;
                }
            },
            // Erro ao atualizar avaliação
            error: function(xhr, status, error) {
                $('#errorModal').modal('show').find('.modal-body').text('Erro ao rerceber dados.');
                console.error(xhr.responseText); // Exibir detalhes do erro no console
            },

        });
    });

    // Atualizar opções de nível quando a seleção da escala mudar
    $(document).on('change', '.selecao-escala', function() {
        atualizarOpcoesNivel(this);
    });

    // Processar submissão do formulário após preenchimento dos detalhes da avaliação
    $(document).on('click', '#btn-submeter', function() {
        var idAvaliacao = $('#selectAvaliacao').val(); // Obter o ID da avaliação selecionada

        var detailsArray = [];
        // Extrair os dados dos cards preenchidos
        $('.custom-card').each(function() {
            var card = $(this);
            var escala = card.find('select[name="escala"]').val();
            var nivel;
            
            // Verificar se a escala é uma seleção (tipo 1)
            if (escala === '1') {
                nivel = card.find('select[name="nivel"]').val(); // Obter o valor do select
            } else {
                nivel = card.find('input[name="nivel"]').val(); // Obter o valor do input
            }

            var observacoes = card.find('textarea[name="observacoes"]').val();
            var dataAvaliacao = card.find('input[name="dataAvaliacao"]').val();
            var user = card.find('.card-title').text().split(' - ')[0].trim();

            var detailObject = {
                id_avaliacao: idAvaliacao, // ID da avaliação selecionada
                escala: escala,
                nivel: nivel,
                observacoes: observacoes,
                data_avaliacao: dataAvaliacao,
                user: user
            };

            detailsArray.push(detailObject);
        });
        console.log(detailsArray);
        // Enviar os dados via AJAX para o servidor para atualização
        $.ajax({
            url: 'atualizar_avaliacao.php',
            method: 'POST',
            data: { detailsArray: JSON.stringify(detailsArray) },
            dataType: 'json',
            // Sucesso ao atualizar avaliação
            success: function(response) {
                if (response.success) {
                    $('#successModal').modal('show');
                    // Aqui você pode adicionar outras ações após a atualização bem-sucedida
                } else {
                    $('#errorModal').modal('show').find('.modal-body').text('Erro ao atualizar avaliação: ' + response.message);
                }
            },
            error: function(xhr, status, error) {
                console.error(xhr.responseText); // Exibir detalhes do erro no console
                $('#errorModal').modal('show').find('.modal-body').text('Erro ao atualizar avaliação');
            }
        });
    });

});


</script>



</body>
</html>
<?php include 'footer-reservado.php'; ?>