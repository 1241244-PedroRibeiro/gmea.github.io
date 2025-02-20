<?php
session_start();
include "./generals/config.php";
$mysqli = new mysqli($bd_host, $bd_user, $bd_password, $bd_database);

if ($mysqli->connect_error) {
    die('Erro: (' . $mysqli->connect_errno . ') ' . $mysqli->connect_error);
}

if (empty($_SESSION["session_id"]) || $_SESSION["type"] < 3) {
    header("Location: ../index.php");
    exit;
}

// Função para obter os alunos com base no professor logado
function getAlunos($mysqli, $professor) {
    $query = "SELECT users1.user, users1.nome, users1.estado
                FROM alunos
                WHERE users1.estado=1
                INNER JOIN users1 ON alunos.user = users1.user";

    $result = $mysqli->query($query);

    $alunos = array();

    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            $alunos[] = $row;
        }
    }

    return $alunos;
}

// Função para obter as turmas com base no professor logado
function getTurmas($mysqli, $professor) {
    $query = "SELECT cod_turma, nome_turma FROM turmas";

    $result = $mysqli->query($query);

    $turmas = array();

    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            $turmas[] = $row;
        }
    }

    return $turmas;
}

function traduzirDiaSemana($dia) {
    switch ($dia) {
        case 1:
            return "Segunda";
            break;
        case 2:
            return "Terça";
            break;
        case 3:
            return "Quarta";
            break;
        case 4:
            return "Quinta";
            break;
        case 5:
            return "Sexta";
            break;
        case 6:
            return "Sábado";
            break;
        case 7:
            return "Domingo";
            break;
        default:
            return "Desconhecido";
            break;
    }
}


if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (isset($_POST["atualizarAula"])) {
        // Recupere os dados do formulário
        $idAula = $_POST["id_aula"];
        $userOuTurma = $_POST["userOuTurma"];
        $disciplina = $_POST["disciplina"];
        $horaInicio = $_POST["horaInicio"];
        $horaFim = $_POST["horaFim"];
        $diaDaSemana = $_POST["diaDaSemana"];

        // Atualize os dados na tabela aulas
        $updateAulaQuery = "UPDATE aulas SET userOuTurma = '$userOuTurma', cod_dis = '$disciplina', 
                            hora_inicio = '$horaInicio', hora_fim = '$horaFim', dia_semana = '$diaDaSemana'
                            WHERE id_aula = $idAula";

if ($mysqli->query($updateAulaQuery)) {
    // Atualize os dados na tabela alunos associados a esta aula
    if ($mysqli->query($updateAulaQuery)) {
        echo "<script>$('#mensagem-sucesso').show().html('Atualização bem-sucedida.');</script>";
    } else {
        echo "<script>$('#mensagem-erro').show().html('Erro ao atualizar alunos: " . $mysqli->error . "');</script>";
    }
} else {
    echo "<script>$('#mensagem-erro').show().html('Erro ao atualizar aula: " . $mysqli->error . "');</script>";
}


    }
}

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>GMEA - Gerir Alunos</title>
    <link rel="shortcut icon" type="image/png" href="media/logo.png" />
    <script src="https://use.fontawesome.com/releases/v6.3.0/js/all.js" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.3.1/jquery.min.js" crossorigin="anonymous"></script>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js"></script>
    <link href="https://netdna.bootstrapcdn.com/font-awesome/3.2.1/css/font-awesome.css" rel="stylesheet">
</head>

    <?php
$query = "SELECT DISTINCT aulas.id_aula, aulas.userOuTurma, aulas.cod_dis, aulas.hora_inicio, aulas.hora_fim, aulas.dia_semana,
                        turmas.nome_turma, cod_dis.nome_dis, users1.nome AS aluno_nome
                    FROM aulas
                    LEFT JOIN turmas ON aulas.userOuTurma = turmas.cod_turma
                    LEFT JOIN cod_dis ON aulas.cod_dis = cod_dis.cod_dis
                    LEFT JOIN users1 ON aulas.userOuTurma = users1.user";
$result = $mysqli->query($query);

$aulas = array();

if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $aulas[] = $row;
    }
}
?>

    <div class="container" id="tabela-aulas">
        <!-- Exibir a tabela de resultados -->
        <table class="table">
            <thead>
                <tr>
                    <th>ID Aula:</th>
                    <th>Turma/Aluno</th>
                    <th>Disciplina</th>
                    <th>Hora Início</th>
                    <th>Hora Fim</th>
                    <th>Dia da Semana</th>
                    <th>Ação</th>
                </tr>
            </thead>
            <tbody>
            <?php foreach ($aulas as $aula) : ?>
                <tr>
                    <!-- Adicione a seguinte linha para exibir o ID da Aula -->
                    <td><?php echo $aula['id_aula']; ?></td>

                    <td>
                        <?php
                        if (!empty($aula['nome_turma'])) {
                            echo $aula['userOuTurma'] . ' - ' . $aula['nome_turma'];
                        } elseif (!empty($aula['aluno_nome'])) {
                            echo $aula['userOuTurma'] . ' - ' . $aula['aluno_nome'];
                        } else {
                            echo $aula['userOuTurma'];
                        }
                        ?>
                    </td>
                    <td><?php echo $aula['nome_dis']; ?></td>
                    <td><?php echo $aula['hora_inicio']; ?></td>
                    <td><?php echo $aula['hora_fim']; ?></td>
                    <td><?php echo traduzirDiaSemana($aula['dia_semana']); ?></td>
                    <td>
                        <a href="#" class="btn btn-warning btn-editar" data-id="<?php echo $aula['id_aula']; ?>">Editar</a>
                    </td>
                </tr>
            <?php endforeach; ?>
            </tbody>
        </table>
  

    <form method="post" class="mb-3" id="formEdicaoAula" style="display: none;">
        <!-- Campos do formulário de edição aqui (semelhante ao formulário de criação) -->
        <input type="hidden" name="id_aula" id="id_aula">
        <div class="mb-3">
            <label for="alunoOuTurmaEdit" class="form-label">Aluno ou Turma:</label>
            <input type="text" class="form-control" id="userOuTurma" name="userOuTurma" required readonly>
        </div>
        <label for="disciplina" class="form-label">Disciplina:</label>
        <select class="form-select" name="disciplina" id="disciplina" required>
            <option value="" disabled selected>Selecione a disciplina...</option>

            <?php
            $query = "SELECT cod_dis, nome_dis FROM cod_dis";

            $result = $mysqli->query($query);

            if ($result->num_rows > 0) {
                while ($row = $result->fetch_assoc()) {
                    echo "<option value='" . $row['cod_dis'] . "'>" . $row['nome_dis'] . "</option>";
                }
            } else {
                echo "<option value='' disabled>Nenhuma disciplina encontrada</option>";
            }
            ?>
        </select>
        <div class="mb-3">
            <label for="horaInicioEdit" class="form-label">Hora Início:</label>
            <input type="time" class="form-control" id="horaInicioEdit" name="horaInicio" required>
        </div>
        <div class="mb-3">
            <label for="horaFimEdit" class="form-label">Hora Fim:</label>
            <input type="time" class="form-control" id="horaFimEdit" name="horaFim" required>
        </div>
        <div class="mb-3">
            <label for="diaDaSemanaEdit" class="form-label">Dia da Semana:</label>
            <select name="diaDaSemana" id="diaDaSemanaEdit" class="form-select" required>
                <option value="1">Segunda</option>
                <option value="2">Terça</option>
                <option value="3">Quarta</option>
                <option value="4">Quinta</option>
                <option value="5">Sexta</option>
                <option value="6">Sábado</option>
                <option value="7">Domingo</option>
            </select>
        </div>
        <button style="background-color: #00631b; border-color: black;" class="btn btn-primary" type="submit" name="atualizarAula">Atualizar Aula</button>
    </form>

    <div class="alert alert-success mt-3" id="mensagem-sucesso" style="display: none;">
    <!-- Mensagem de sucesso aqui -->
    </div>
    <div class="alert alert-warning mt-3" id="mensagem-aviso" style="display: none;">
        <!-- Mensagem de aviso aqui -->
    </div>
    <div class="alert alert-danger mt-3" id="mensagem-erro" style="display: none;">
        <!-- Mensagem de erro aqui -->
    </div>

    
</div>

</body>

</html>

<script>
    $(document).ready(function () {
        // Evento de clique no botão 'Editar'
        $(".btn-editar").click(function () {
            // Obter o ID da aula associada ao botão clicado
            var idAula = $(this).data("id");

            // Enviar uma solicitação AJAX para obter os detalhes da aula
            $.ajax({
                url: "obter_aula_por_id.php",
                method: "POST",
                data: { id_aula: idAula },
                dataType: "json",
                success: function (response) {
                    // Preencher os campos do formulário com os detalhes obtidos
                    $("#id_aula").val(response.id_aula);
                    $("#userOuTurma").val(response.userOuTurma); // Mudei para userOuTurma
                    $("#disciplina").val(response.cod_dis);
                    $("#horaInicioEdit").val(response.hora_inicio);
                    $("#horaFimEdit").val(response.hora_fim);
                    $("#diaDaSemanaEdit").val(response.dia_semana);

                    // Exibir o formulário de edição
                    $("#formEdicaoAula").show();
                },
                error: function () {
                    alert("Erro ao obter detalhes da aula. Por favor, tente novamente.");
                }
            });
        });
    });


</script>