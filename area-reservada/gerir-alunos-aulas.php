<?php
session_start();
include "./generals/config.php";
$mysqli = new mysqli($bd_host, $bd_user, $bd_password, $bd_database);

if ($mysqli->connect_error) {
    die('Erro: (' . $mysqli->connect_errno . ') ' . $mysqli->connect_error);
}

if (empty($_SESSION["session_id"]) || $_SESSION["type"] != 3) {
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


// Função para obter todos os alunos que não estão associados a nenhuma aula
function getAllAlunos($idAula)
{
    global $mysqli;
    $alunos = array();

    // Consulta SQL para obter a turma ou usuário associado à aula com o ID correspondente
    $query = "SELECT userOuTurma FROM aulas WHERE id_aula = $idAula";
    $result = $mysqli->query($query);

    if ($result->num_rows > 0) {
        // Obter o usuário ou turma associado à aula
        $row = $result->fetch_assoc();
        $turma = $row['userOuTurma'];

        // Consulta SQL para obter todos os alunos ativos
        $query_alunos = "SELECT user, nome, estado FROM users1 WHERE type = 1 AND estado = 1";

        $result_alunos = $mysqli->query($query_alunos);

        if ($result_alunos->num_rows > 0) {
            // Verificar quais alunos não estão associados a esta aula
            while ($row_aluno = $result_alunos->fetch_assoc()) {
                $user = $row_aluno['user'];

                // Consulta SQL para verificar se o aluno está associado a esta aula
                $query_associacao = "SELECT * FROM turmas_alunos WHERE cod_turma = '$turma' AND user = '$user'";
                $result_associacao = $mysqli->query($query_associacao);

                // Se não houver associação, adicione o aluno à lista
                if ($result_associacao->num_rows == 0) {
                    $alunos[$row_aluno['user']] = $row_aluno['nome'];
                }
            }
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

    <div style="margin-top: 0;">
        <img style="width: 100%; height: auto;" src="./media/topAR.png" class="img-responsive">
    </div>

    <?php
    include "header-direcao.php";
    ?>

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


                        <?php
                        if (!empty($aula['nome_turma'])) {
                            echo '<td>';
                            echo $aula['id_aula'];
                            echo '</td>';
                            echo '<td>';
                            echo $aula['userOuTurma'] . ' - ' . $aula['nome_turma'];

                        ?>
                    </td>
                    <td><?php echo $aula['nome_dis']; ?></td>
                    <td><?php echo $aula['hora_inicio']; ?></td>
                    <td><?php echo $aula['hora_fim']; ?></td>
                    <td><?php echo traduzirDiaSemana($aula['dia_semana']); ?></td>
                    <td>
                        <a href="#" class="btn btn-warning btn-editar" data-id="<?php echo $aula['id_aula']; ?>">Editar</a>
                    </td>
                    <?php
                        }
                    ?>
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
        <select class="form-select" name="disciplina" id="disciplina" required disabled readonly>
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
        <?php
        if (isset($_GET['id_aula'])){
            $idAula = $_GET['id_aula'];
            $alunos = getAllAlunos($idAula);
            echo '<div class="mb-3">';
            echo '<label class="form-label">Selecione os Alunos:</label>';
            echo '<select class="form-select" multiple name="alunos_selecionados[]" id="selectAlunos">';
            foreach ($alunos as $user => $aluno_nome) {
                echo '<option value="' . $user . '">' . $aluno_nome . '</option>';
            }
            echo '</select>';
            echo '</div>';
            echo '<button type="button" class="btn btn-primary" id="adicionarAluno">Adicionar Aluno</button>';
            echo '<table class="table mt-3">';
            echo '<thead><tr><th>User</th><th>Nome</th><th>Ação</th></tr></thead>';
            echo '<tbody id="alunosAdicionadosTable"></tbody>';
            echo '</table>';
            echo '<input type="hidden" id="alunosSelecionadosJSON" name="alunos_selecionados_json">';
        }
        ?>
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
    var alunosSelecionados = [];

    $(".btn-editar").click(function () {
        var idAula = $(this).data("id");
        window.location.href = "?id_aula=" + idAula;
    });

    function preencherFormulario(idAula) {
        $.ajax({
            url: "obter_aula_por_id.php",
            method: "POST",
            data: { id_aula: idAula },
            dataType: "json",
            success: function (response) {
                $("#id_aula").val(response.id_aula);
                $("#userOuTurma").val(response.userOuTurma);
                $("#disciplina").val(response.cod_dis);

                $.ajax({
                    url: "obter_alunos_por_aula.php",
                    method: "POST",
                    data: { id_aula: idAula },
                    dataType: "html",
                    success: function (response) {
                        var alunosData = JSON.parse(response);
                        alunosSelecionados = [];
                        alunosData.forEach(function (aluno) {
                            alunosSelecionados.push({ user: aluno.user, nome: aluno.nome });
                        });
                        atualizarTabelaAlunos();
                    },
                    error: function () {
                        alert("Erro ao obter alunos da aula. Por favor, tente novamente.");
                    }
                });

                $("#formEdicaoAula").show();
            },
            error: function () {
                alert("Erro ao obter detalhes da aula. Por favor, tente novamente.");
            }
        });
    }

    var urlParams = new URLSearchParams(window.location.search);
    var idAula = urlParams.get('id_aula');
    if (idAula) {
        preencherFormulario(idAula);
    }

    $("#adicionarAluno").click(function () {
        var selectedAlunos = $("#selectAlunos option:selected");

        selectedAlunos.each(function () {
            var user = $(this).val();
            var nome = $(this).text();
            alunosSelecionados.push({ user: user, nome: nome });

            $(this).remove();  // Remover da lista de seleção
        });

        atualizarTabelaAlunos();
        $("#alunosSelecionadosJSON").val(JSON.stringify(alunosSelecionados));
    });

    function atualizarTabelaAlunos() {
        $("#alunosAdicionadosTable").html("");
        alunosSelecionados.forEach(function (aluno) {
            var row = '<tr><td>' + aluno.user + '</td><td>' + aluno.nome + '</td>';
            row += '<td><button type="button" class="btn btn-danger" onclick="removerAluno(\'' + aluno.user + '\')">Remover</button></td></tr>';
            $("#alunosAdicionadosTable").append(row);
        });
    }

    function removerAluno(user) {
        var alunoRemovido = alunosSelecionados.find(function (aluno) {
            return aluno.user === user;
        });

        if (alunoRemovido) {
            alunosSelecionados = alunosSelecionados.filter(function (aluno) {
                return aluno.user !== user;
            });

            var option = '<option value="' + alunoRemovido.user + '">' + alunoRemovido.nome + '</option>';
            $("#selectAlunos").append(option);  // Adicionar de volta à lista de seleção
        }

        atualizarTabelaAlunos();
        $("#alunosSelecionadosJSON").val(JSON.stringify(alunosSelecionados));
    }

    window.removerAluno = removerAluno;

    $("#formEdicaoAula").submit(function (event) {
        event.preventDefault();
        var formData = {
            id_aula: $("#id_aula").val(),
            alunos_selecionados: $("#alunosSelecionadosJSON").val()
        };

        $.ajax({
            url: "registrar_alunos.php",
            method: "POST",
            data: formData,
            dataType: "json",
            success: function (response) {
                if (response.status === "success") {
                    $("#mensagem-sucesso").text(response.message).show();
                    $("#mensagem-erro").hide();
                    $("#mensagem-aviso").hide();
                } else {
                    $("#mensagem-erro").text(response.message).show();
                    $("#mensagem-sucesso").hide();
                    $("#mensagem-aviso").hide();
                }
            },
            error: function () {
                $("#mensagem-erro").text("Erro ao registrar alunos. Por favor, tente novamente.").show();
                $("#mensagem-sucesso").hide();
                $("#mensagem-aviso").hide();
            }
        });
    });
});
</script>

<?php include 'footer-reservado.php'; ?>