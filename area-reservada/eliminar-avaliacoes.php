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
    <title>Exclusão de Avaliações</title>
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

    <h2>Exclusão de Avaliações</h2>
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
                <label for="selectAvaliacao">Selecione uma Avaliação para Excluir:</label>
                <select id="selectAvaliacao" name="selectAvaliacao" class="form-control" required>
                    <option value="">Selecione</option>
                    <?php while ($row = $resultAvaliacoes->fetch_assoc()): ?>
                        <?php
                        $optionLabel = "Tipo: " . ($row['tipo_avaliacao'] == 1 ? "Avaliação Intercalar" :
                                        ($row['tipo_avaliacao'] == 2 ? "Prova" :
                                        ($row['tipo_avaliacao'] == 3 ? "Trabalho" : "Outro")))
                                        . " - (" . $row['userOuTurma'] . ") - Inserida em: " . $row['data_inserido'];
                        ?>
                        <option value="<?php echo $row['id_avaliacao']; ?>">
                            <?php echo $optionLabel; ?>
                        </option>
                    <?php endwhile; ?>
                </select>
            </div>
            <button type="submit" name="excluirAvaliacao" class="btn btn-danger">Excluir Avaliação</button>
        </form>
    <?php elseif (isset($_POST['prosseguir'])): ?>
        <p class="mt-4">Nenhuma avaliação encontrada com os critérios selecionados.</p>
    <?php endif; ?>

</div>

<?php
// Processar a exclusão da avaliação se o formulário de exclusão for enviado
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['excluirAvaliacao'])) {
    $id_avaliacao = $mysqli->real_escape_string($_POST['selectAvaliacao']);

    $deleteQuery = "DELETE FROM avaliacoes WHERE id_avaliacao = '$id_avaliacao';";

    if ($mysqli->multi_query($deleteQuery)) {
        // Exibindo modal de sucesso em vez do alerta
        echo '
        <div class="modal fade" id="modalSucesso" tabindex="-1" role="dialog" aria-labelledby="modalSucessoLabel" aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="modalSucessoLabel">Sucesso!</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        A avaliação e seus detalhes foram excluídos com sucesso.
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Fechar</button>
                    </div>
                </div>
            </div>
        </div>
        <script>
            $(document).ready(function(){
                $("#modalSucesso").modal("show");
            });
        </script>';
    } else {
        // Exibindo modal de erro em vez do alerta
        echo '
        <div class="modal fade" id="modalErro" tabindex="-1" role="dialog" aria-labelledby="modalErroLabel" aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="modalErroLabel">Erro!</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        Houve um erro ao excluir a avaliação. Por favor, tente novamente.
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Fechar</button>
                    </div>
                </div>
            </div>
        </div>
        <script>
            $(document).ready(function(){
                $("#modalErro").modal("show");
            });
        </script>';
    }
}
?>


<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
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
</script>

</div>
</body>
</html>

<?php include 'footer-reservado.php'; ?>