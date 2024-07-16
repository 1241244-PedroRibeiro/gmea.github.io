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

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $alunoOuTurma = $_POST["cod_turma"];
    $prof = $_POST["professor_responsavel"];
    $disciplina = $_POST["disciplina_turma"];
    $horaInicio = $_POST["horaInicio"];
    $horaFim = $_POST["horaFim"];
    $diaDaSemana = $_POST["diaDaSemana"];

    // Verifique se é uma aula de turma
    if (!empty($_POST["alunos_selecionados"])) {
        // É uma aula de turma
        // Adicione os alunos à tabela 'turmas_alunos'
        $alunos_selecionados_json = $_POST["alunos_selecionados_json"];
        $alunos_selecionados = json_decode($alunos_selecionados_json);

        if (!empty($alunos_selecionados)) {
            foreach ($alunos_selecionados as $aluno) {
                $user = $aluno->user;
                // Chame a função para adicionar cada aluno à tabela 'turmas_alunos'
                adicionarAlunosATurma($alunoOuTurma, $user);
            }
        }

        // Insira os dados da turma na tabela 'turmas' apenas se a turma não existir
        $queryCheckTurma = "SELECT * FROM turmas WHERE cod_turma = '$alunoOuTurma'";
        $resultCheckTurma = $mysqli->query($queryCheckTurma);

        if ($resultCheckTurma->num_rows === 0) {
            // Turma não existe, então crie
            $queryTurma = "INSERT INTO turmas (cod_turma, prof_turma, dis_turma, nome_turma)
                           VALUES ('$alunoOuTurma', '$prof_turma', '$disciplina', '$nome_turma')";

            if (adicionarTurma($alunoOuTurma, $prof_turma, $disciplina, $nome_turma) && mysqli_query($mysqli, $queryTurma)) {
                echo '<div class="alert alert-success mt-3">Turma criada com sucesso!</div>';
            } else {
                echo '<div class="alert alert-danger mt-3">Erro ao criar a turma!</div>';
            }
        } else {
            echo '<div class="alert alert-warning mt-3">A turma já existe!</div>';
        }
    } else {
        // É uma aula individual
        // Insira os dados da aula na tabela 'aulas'
        $queryAula = "INSERT INTO aulas (userOuTurma, prof, cod_dis, hora_inicio, hora_fim, dia_semana)
                      VALUES ('$alunoOuTurma', '$prof', '$disciplina', '$horaInicio', '$horaFim', '$diaDaSemana')";

        if (mysqli_query($mysqli, $queryAula)) {
            $mensagem = "Aula confirmada.";
        } else {
            $mensagem = "Erro na inserção da aula: " . mysqli_error($mysqli);
        }
    }
}





?>

<!DOCTYPE html>
<html lang="en">


        <div class="container" id="criar-aula">

            <h2>Criação de aulas individuais</h2>

            <form method="post" class="mb-3">
                <label for="alunoOuTurma" class="form-label">Escolha o Aluno ou Turma:</label>
                    <select class="form-select" name="cod_turma" id="alunoOuTurma" required>
                        <option value="" disabled selected>Selecione...</option>
                        <?php
                            // Consulta SQL para obter alunos
                            $query = "SELECT alunos.user, users1.nome, users1.estado FROM alunos INNER JOIN users1 ON alunos.user = users1.user WHERE users1.estado=1";
                            $result = $mysqli->query($query);

                            if ($result->num_rows > 0) {
                                while ($row = $result->fetch_assoc()) {
                                    echo "<option value='" . $row['user'] . "'>" . $row['user'] . " - " . $row['nome'] . "</option>";
                                }
                            }
                        ?>
                    </select>

                <label for="prof" class="form-label">Escolha Professor:</label>
                    <select class="form-select" name="prof" id="prof" required>
                        <option value="" disabled selected>Selecione...</option>
                        <?php
                            // Consulta SQL para obter alunos
                            $query = "SELECT users1.user, users1.nome, users1.estado FROM users1 WHERE users1.estado=1 AND users1.type=2";
                            $result = $mysqli->query($query);

                            if ($result->num_rows > 0) {
                                while ($row = $result->fetch_assoc()) {
                                    echo "<option value='" . $row['user'] . "'>" . $row['user'] . " - " . $row['nome'] . "</option>";
                                }
                            }
                        ?>
                    </select>
                    
                    <label for="disciplina" class="form-label">Disciplina:</label>
                        <select class="form-select" name="disciplina_turma" id="disciplina_turma" require_once>
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
                        <label for="horaInicio" class="form-label">Hora Início:</label>
                        <input type="time" class="form-control" id="horaInicio" name="horaInicio" required>
                    </div>
                    <div class="mb-3">
                        <label for="horaFim" class="form-label">Hora Fim:</label>
                        <input type="time" class="form-control" id="horaFim" name="horaFim" required>
                    </div>
                    <div class="mb-3">
                        <label for="diaDaSemana" class="form-label">Dia da Semana:</label>
                        <select name="diaDaSemana" id="diaDaSemana" class="form-select" required>
                            <option value="1">Segunda</option>
                            <option value="2">Terça</option>
                            <option value="3">Quarta</option>
                            <option value="4">Quinta</option>
                            <option value="5">Sexta</option>
                            <option value="6">Sábado</option>
                            <option value="7">Domingo</option>
                        </select>
                    </div>

                <button style="background-color: #00631b; border-color: black;" class="btn btn-primary" type="submit" name="create_turma">Inserir Dados</button>
            </form>

                <?php
                    if (isset($mensagem)) {
                        echo "<div class='alert alert-info'>$mensagem</div>";
                    }
                ?>

        </div>

</body>

</html>

<!-- Adicione isso no final da página, antes do fechamento do corpo (</body>) -->
<script>
        var alunos_selecionados = [];

    document.addEventListener("DOMContentLoaded", function() {
        // Função para mostrar ou ocultar o segmento do formulário com base na ação selecionada
        function toggleSegmentoFormulario() {
            var acaoAula = document.getElementById("acaoAula").value;
            var segmentoFormulario = document.getElementById("criar-aula");

            // Mostra ou oculta o segmento do formulário com base na ação selecionada
            segmentoFormulario.style.display = (acaoAula === "criar") ? "block" : "none";
        }

        // Adiciona um ouvinte de evento de alteração ao campo de seleção
        document.getElementById("acaoAula").addEventListener("change", toggleSegmentoFormulario);

        // Chama a função inicialmente para garantir que o segmento do formulário esteja corretamente configurado
        toggleSegmentoFormulario();
    });
</script>