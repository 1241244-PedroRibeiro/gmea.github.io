<?php
session_start();
include "./generals/config.php";
$mysqli = new mysqli($bd_host, $bd_user, $bd_password, $bd_database);

if ($mysqli->connect_error) {
    die('Erro: (' . $mysqli->connect_errno . ') ' . $mysqli->connect_error);
}

$username = $_SESSION["username"];

// Consultar justificações de faltas com estado = 0
$queryJustificacoes = "SELECT j.*, f.dia, f.tipo_falta, f.user AS user_falta_nome
                       FROM justificacao_faltas j
                       INNER JOIN faltas f ON j.indice_aula = f.indice_aula AND j.tipo_falta = f.tipo_falta AND j.user = f.user
                       WHERE j.estado = 0";
$resultJustificacoes = $mysqli->query($queryJustificacoes);

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Inserir Sócio</title>
    <link rel="shortcut icon" type="image/png" href="media/logo.png" />
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
        if ($_SESSION["type"] == 3) { // Mostrar cabeçalho para professores
            include "header-direcao.php"; 
        } 
        if ($_SESSION["type"] == 4) { // Mostrar cabeçalho para professores
            include "header-professor-direcao.php";
        } 

    ?>

<div style="width: 75%; margin: auto;" class="mt-5">
    <h2>Gestão de Justificações de Faltas</h2>

    <?php
    if ($resultJustificacoes && $resultJustificacoes->num_rows > 0) {
        while ($row = $resultJustificacoes->fetch_assoc()) {
            $indice_aula = $row['indice_aula'];
            $dia = date('d/m/Y', strtotime($row['dia']));
            $data_submetido = date('d/m/Y', strtotime($row['data_pedido']));
            $tipo_falta = $row['tipo_falta'];
            $user_falta_nome = $row['user_falta_nome'];
            $motivo = $row['motivo'];
            $anexo = $row['anexo'];
            $id_aula = $row['id_aula'];

            // Determinar a descrição do tipo de falta com base no número
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
                case 4:
                    $falta_descricao = 'Falta de Material';
                    break;
                case 5:
                    $falta_descricao = 'Falta Disciplinar';
                    break;
                default:
                    $falta_descricao = 'Tipo de Falta Desconhecido';
                    break;
            }

            // Consulta para obter o nome do usuário correspondente ao $user_falta na tabela 'users1'
            $queryNomeUsuario = "SELECT nome FROM users1 WHERE user = '$user_falta_nome'";
            $resultNomeUsuario = $mysqli->query($queryNomeUsuario);

            if ($resultNomeUsuario && $resultNomeUsuario->num_rows > 0) {
                $rowNomeUsuario = $resultNomeUsuario->fetch_assoc();
                $nome_usuario = $rowNomeUsuario['nome'];
            } else {
                $nome_usuario = "Nome não encontrado";
            }

            echo '<div class="row mt-3">';
            echo '<div class="col">';
            echo '<div class="dropdown border p-3 d-flex justify-content-between align-items-center">';

            // Informações básicas da falta em linha
            echo '<div>';
            echo '<p class="mb-0"><strong>Data:</strong> ' . $dia ;
            echo '&nbsp;&nbsp;&nbsp;<strong>Aluno:</strong> (' . $user_falta_nome . ') ' . $nome_usuario;
            echo '&nbsp;&nbsp;&nbsp;<strong>Tipo de Falta:</strong> ' . $falta_descricao;
            echo '&nbsp;&nbsp;&nbsp;<strong>Pedido de Justificação submetido a:</strong> ' . $data_submetido . '</p>';
            echo '</div>';

            // Botão de expansão para mais informações
            echo '<button class="btn btn-primary ml-2" type="button" onclick="toggleMaisInformacoes(' . $indice_aula . ')">';
            echo 'Mais Informações';
            echo '</button>';            

            echo '</div>'; // fechar dropdown com borda

            // Conteúdo expansível (detalhes da falta)
            echo '<div id="collapse_' . $indice_aula . '" class="collapse mt-2 p-3 bg-light">';

            // Detalhes da falta (expandido)
            echo '<p><strong>Motivo:</strong> ' . $motivo . '</p>';
            if (!empty($anexo)) {
                echo '<p><strong>Anexo:</strong> <a href="' . $anexo . '">Ver Anexo</a></p>';
            }

            // Botões de aceitar/recusar
            echo '<button class="btn btn-success mr-2" onclick="aceitarJustificacao(' . $indice_aula . ', ' . $id_aula . ', ' . $tipo_falta . ', \'' . $user_falta_nome . '\')">Aceitar</button>';
            echo '<button class="btn btn-danger" onclick="recusarJustificacao(' . $indice_aula . ', ' . $id_aula . ', ' . $tipo_falta . ', \'' . $user_falta_nome . '\')">Recusar</button>';

            echo '</div>'; // fechar collapse com detalhes

            echo '</div>'; // fechar coluna
            echo '</div>'; // fechar linha
        }
    } else {
        echo '<p>Nenhuma justificação pendente.</p>';
    }
    ?>
<br><br><br>
</div>

<!-- Adicione esses modais ao final do seu arquivo HTML -->
<!-- Modal de sucesso -->
<div class="modal fade" id="successModal" tabindex="-1" aria-labelledby="successModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="successModalLabel">Sucesso</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <!-- Mensagem de sucesso será exibida aqui -->
            </div>
        </div>
    </div>
</div>

<!-- Modal de erro -->
<div class="modal fade" id="errorModal" tabindex="-1" aria-labelledby="errorModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="errorModalLabel">Erro</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <!-- Mensagem de erro será exibida aqui -->
            </div>
        </div>
    </div>
</div>




<script>
    function aceitarJustificacao(indiceAula, idAula, tipoFalta, user) {
        $.ajax({
            url: 'processar_aceitar_justificacao.php',
            type: 'POST',
            data: {
                indice_aula: indiceAula,
                id_aula: idAula,
                tipo_falta: tipoFalta,
                user: user
            },
            success: function(response) {
                $('#successModal .modal-body').text('Justificação aceita com sucesso.');
                $('#successModal').modal('show');
            },
            error: function() {
                $('#errorModal .modal-body').text('Erro ao aceitar justificação.');
                $('#errorModal').modal('show');
            }
        });
    }

    function recusarJustificacao(indiceAula, idAula, tipoFalta, user) {
        $.ajax({
            url: 'processar_recusar_justificacao.php',
            type: 'POST',
            data: {
                indice_aula: indiceAula,
                id_aula: idAula,
                tipo_falta: tipoFalta,
                user: user
            },
            success: function(response) {
                $('#successModal .modal-body').text('Justificação recusada e removida com sucesso.');
                $('#successModal').modal('show');
            },
            error: function() {
                $('#errorModal .modal-body').text('Erro ao recusar justificação.');
                $('#errorModal').modal('show');
            }
        });
    }


    function toggleMaisInformacoes(indiceAula) {
        var targetId = '#collapse_' + indiceAula;
        $(targetId).collapse('toggle'); // Alternar a visibilidade da seção
    }

    // Evento acionado quando o modal de sucesso é fechado
    $('#successModal').on('hidden.bs.modal', function () {
        location.reload();
    });


</script>

</body>
</html>

<?php include 'footer-reservado.php' ?>