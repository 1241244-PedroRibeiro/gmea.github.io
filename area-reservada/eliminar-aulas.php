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
              WHERE users1.estado = 1
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

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Verificar se a ação é "eliminarAula"
    if (isset($_POST["acao"]) && $_POST["acao"] == "eliminarAula") {
        $idAula = $_POST["id_aula_eliminar"];

        // Eliminar a aula da tabela aulas
        $deleteAulaQuery = "DELETE FROM aulas WHERE id_aula = $idAula";

        if ($mysqli->query($deleteAulaQuery)) {
            $mensagem_sucesso = "Aula eliminada com sucesso.";
        } else {
            $mensagem_erro = "Erro ao eliminar aula: " . $mysqli->error;
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>GMEA - Eliminar Aulas</title>
    <link rel="shortcut icon" type="image/png" href="media/logo.png" />
    <script src="https://use.fontawesome.com/releases/v6.3.0/js/all.js" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.3.1/jquery.min.js" crossorigin="anonymous"></script>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js"></script>
    <link href="https://netdna.bootstrapcdn.com/font-awesome/3.2.1/css/font-awesome.css" rel="stylesheet">
</head>

<body>
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
                        <td><?php echo $aula['dia_semana']; ?></td>
                        <td>
                            <form method="post" class="mb-3" style="display: inline-block;">
                                <input type="hidden" name="id_aula_eliminar" value="<?php echo $aula['id_aula']; ?>">
                                <input type="hidden" name="acao" value="eliminarAula"> <!-- Adicione esta linha -->
                                <button style="background-color: #d9534f; border-color: black;" class="btn btn-danger btn-eliminar" type="button" data-bs-toggle="modal" data-bs-target="#modalEliminar">Eliminar</button>
                            </form>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>

        <!-- Modal Bootstrap para confirmação de eliminação -->
        <div class="modal fade" id="modalEliminar" tabindex="-1" aria-labelledby="modalEliminarLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="modalEliminarLabel">Eliminar Aula</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        Tem certeza de que deseja eliminar esta aula? Esta ação é irreversível.
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                        <form method="post" style="display: inline-block;">
                            <input type="hidden" name="id_aula_eliminar" value="<?php echo $aula['id_aula']; ?>">
                            <input type="hidden" name="acao" value="eliminarAula">
                            <button type="submit" class="btn btn-danger">Eliminar</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
        <!-- Fim do Modal -->

        <!-- Restante do código HTML permanece inalterado -->
    </div>

    <div class="alert alert-success mt-3" id="mensagem-sucesso" style="display: <?php echo isset($mensagem_sucesso) ? 'block' : 'none'; ?>;">
        <?php echo isset($mensagem_sucesso) ? $mensagem_sucesso : ''; ?>
    </div>
    <div class="alert alert-warning mt-3" id="mensagem-aviso" style="display: none;">
        <!-- Mensagem de aviso aqui -->
    </div>
    <div class="alert alert-danger mt-3" id="mensagem-erro" style="display: <?php echo isset($mensagem_erro) ? 'block' : 'none'; ?>;">
        <?php echo isset($mensagem_erro) ? $mensagem_erro : ''; ?>
    </div>

    <script>
        $(document).ready(function () {
            // Evento de clique no botão 'Eliminar'
            $(".btn-eliminar").click(function (e) {
                e.preventDefault();
            });
        });
    </script>

</body>

</html>
