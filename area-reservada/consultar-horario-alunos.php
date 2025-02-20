<?php
session_start();
include "./generals/config.php";
$mysqli = new mysqli($bd_host, $bd_user, $bd_password, $bd_database);

if ($mysqli->connect_error) {
    die('Erro: (' . $mysqli->connect_errno . ') ' . $mysqli->connect_error);
}

// Obter o usuário logado
$username = $_SESSION["username"];

// Função para obter o nome da disciplina
function obterNomeDisciplina($cod_dis, $mysqli) {
    $query = "SELECT nome_dis FROM cod_dis WHERE cod_dis = '$cod_dis'";
    $result = $mysqli->query($query);
    if ($result) {
        $row = $result->fetch_assoc();
        return $row['nome_dis'];
    }
    return "";
}

// Consultar aulas individuais do usuário
$query_individuais = "SELECT aulas.id_aula, aulas.hora_inicio, aulas.hora_fim, aulas.dia_semana, cod_dis.nome_dis
                      FROM aulas
                      JOIN cod_dis ON aulas.cod_dis = cod_dis.cod_dis
                      WHERE aulas.userOuTurma = '$username'
                      ORDER BY aulas.dia_semana, aulas.hora_inicio";

$result_individuais = $mysqli->query($query_individuais);

// Consultar turmas do usuário
$query_turmas = "SELECT cod_turma FROM turmas_alunos WHERE user = '$username'";
$result_turmas = $mysqli->query($query_turmas);

// Consultar aulas das turmas do usuário
$query_turmas_aulas = "SELECT aulas.id_aula, aulas.hora_inicio, aulas.hora_fim, aulas.dia_semana, cod_dis.nome_dis
                       FROM aulas
                       JOIN cod_dis ON aulas.cod_dis = cod_dis.cod_dis
                       WHERE aulas.userOuTurma IN (SELECT cod_turma FROM turmas_alunos WHERE user = '$username')
                       ORDER BY aulas.dia_semana, aulas.hora_inicio";

$result_turmas_aulas = $mysqli->query($query_turmas_aulas);

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>GMEA</title>
    <link rel="shortcut icon" type="image/png" href="media/logo.png" />
    <script src="https://use.fontawesome.com/releases/v6.3.0/js/all.js" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.3.1/jquery.min.js" crossorigin="anonymous"></script>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js"></script>
    <link href="https://netdna.bootstrapcdn.com/font-awesome/3.2.1/css/font-awesome.css" rel="stylesheet">

    <style>
        @keyframes fadeIn {
            0% {
                opacity: 0;
            }

            100% {
                opacity: 1;
            }
        }

        .contact-info {
            text-align: right;
        }

        .green-label {
            background-color: green;
            color: white;
            padding: 5px;
            border-radius: 5px;
            display: inline-flex; /* Altera para flex */
            justify-content: center; /* Centraliza horizontalmente */
            align-items: center; /* Centraliza verticalmente */
            text-align: center; /* Centraliza o texto horizontalmente */
        }

        .blue-label {
            background-color: blue;
            color: white;
            padding: 5px;
            border-radius: 5px;
            display: inline-flex; /* Altera para flex */
            justify-content: center; /* Centraliza horizontalmente */
            align-items: center; /* Centraliza verticalmente */
            text-align: center; /* Centraliza o texto horizontalmente */
        }

    .schedule {
        display: grid;
        grid-template-columns: repeat(8, 1fr);
        grid-template-rows: 50px; /* Apenas uma linha para os cabeçalhos */
        gap: 1px;
        background-color: #f3f3f3;
        position: relative;
        overflow: hidden;
    }

    /* Reduzindo a altura dos blocos de hora */
    .schedule div {
        border: 1px solid #ddd;
        padding: 3px; /* Reduzindo ainda mais o preenchimento */
        text-align: center;
    }

    .mini-block {
        background-color: #d4d4d4;
        border: 1px solid #bbb;
        border-top: none;
        height: 10px; /* Reduzindo a altura dos mini-blocos */
        width: 100%;
    }

        .mini-block-aula {
            background-color: #b3e6ff; /* Azul claro */
        }

        .mini-block-aula-start {
            border-top-left-radius: 5px;
            border-bottom-left-radius: 5px;
            background-color: #b3e6ff; /* Azul claro */
        }

        .mini-block-aula-end {
            border-top-right-radius: 5px;
            border-bottom-right-radius: 5px;
            background-color: #b3e6ff; /* Azul claro */
        }
    </style>
</head>
<body>

<div style="margin-top: 0;">
    <img style="width: 100%; height: auto;" src="./media/topAR.png" class="img-responsive">
</div>

<?php
    if ($_SESSION["type"] == 1) {
        include "header-alunos.php";
    }
?>

<div class="container mt-5">
    <h2>Horário Semanal</h2>
    <p>Este é o seu horário. Para consultar todos os detalhes acerca das aulas, como data exata de início e fim das aulas ou a sala, clique no bloco da aula.</p>
    
    <div class="d-flex justify-content-end mb-3">
        <button class="btn btn-secondary" id="imprimirHorario">Imprimir Horário</button>
    </div>

    <div class="schedule">
        <div></div>
        <div>Segunda-feira</div>
        <div>Terça-feira</div>
        <div>Quarta-feira</div>
        <div>Quinta-feira</div>
        <div>Sexta-feira</div>
        <div>Sábado</div>
        <div>Domingo</div>

        <?php

        // Inicializa a grade do horário
        for ($hora = 8; $hora <= 23; $hora++) {
            echo "<div>$hora:00 - " . ($hora + 1) . ":00</div>";

            for ($diaSemana = 1; $diaSemana <= 7; $diaSemana++) {
                echo "<div style='position:relative;'>"; // Adiciona posição relativa para que possamos posicionar o nome da aula absolutamente
                while ($row = $result_individuais->fetch_assoc()) {
                    $horaIni = intval(explode(':', $row['hora_inicio'])[0]);
                    $minIni = intval(explode(':', $row['hora_inicio'])[1]);
                    $horaFim = intval(explode(':', $row['hora_fim'])[0]);
                    $minFim = intval(explode(':', $row['hora_fim'])[1]);
                
                    // Verifica se a aula está dentro deste bloco de hora
                    if ($diaSemana == $row['dia_semana'] && $hora >= $horaIni && $hora <= $horaFim) {
                        // Calcula a altura do bloco de aula
                        $inicioAulaMinutos = $horaIni * 60 + $minIni;
                        $inicioBlocoMinutos = $hora * 60; // Corrigido aqui
                        $alturaAulaMinutos = ($horaFim * 60 + $minFim) - $inicioAulaMinutos;
                        $alturaBlocoMinutos = 60; // 60 minutos em um bloco horário
                        $topPercent = (($inicioAulaMinutos - $inicioBlocoMinutos) / $alturaBlocoMinutos) * 100;
                        $alturaPercent = ($alturaAulaMinutos / $alturaBlocoMinutos) * 100;
                
                        // Estiliza o bloco de aula
                        $style = "position: absolute; top: $topPercent%; left: 0; width: 100%; height: $alturaPercent%; background-color: green; border-radius: 5px; padding: 5px; z-index: 1;";
                        $id_aula = $row['id_aula']; // Obtenha o ID da aula
                        
                        // Adicione o ID da aula como um atributo data ao bloco de aula
                        echo "<div class='green-label' style='$style' data-id-aula='$id_aula'>$row[nome_dis]</div>";                        
                    }
                }
                
                $result_individuais->data_seek(0); // Reinicia o ponteiro para o início do resultado

                while ($row = $result_turmas_aulas->fetch_assoc()) {
                    $horaIni = intval(explode(':', $row['hora_inicio'])[0]);
                    $minIni = intval(explode(':', $row['hora_inicio'])[1]);
                    $horaFim = intval(explode(':', $row['hora_fim'])[0]);
                    $minFim = intval(explode(':', $row['hora_fim'])[1]);

                    // Verifica se a aula está dentro deste bloco de hora
                    if ($diaSemana == $row['dia_semana'] && $hora >= $horaIni && $hora < $horaFim) {
                        // Calcula a altura do bloco de aula
                        $inicioAulaMinutos = $horaIni * 60 + $minIni;
                        $inicioBlocoMinutos = ($hora * 60); // Corrigido aqui
                        $alturaAulaMinutos = ($horaFim * 60 + $minFim) - $inicioAulaMinutos;
                        $alturaBlocoMinutos = 60; // 60 minutos em um bloco horário
                        $topPercent = (($inicioAulaMinutos - $inicioBlocoMinutos) / $alturaBlocoMinutos) * 100;
                        $alturaPercent = ($alturaAulaMinutos / $alturaBlocoMinutos) * 100;

                        // Estiliza o bloco de aula
                        $style = "position: absolute; top: $topPercent%; left: 0; width: 100%; height: $alturaPercent%; background-color: blue; border-radius: 5px; padding: 5px; z-index: 1;";
                        $id_aula = $row['id_aula']; // Obtenha o ID da aula
                        
                        // Adicione o ID da aula como um atributo data ao bloco de aula
                        echo "<div class='blue-label' style='$style' data-id-aula='$id_aula'>$row[nome_dis]</div>";
                        
                    }
                }
                $result_turmas_aulas->data_seek(0); // Reinicia o ponteiro para o início do resultado

                // Cria os miniblocks para esta hora
                for ($miniHora = 0; $miniHora < 6; $miniHora++) {
                    echo "<div class='mini-block'></div>";
                }

                echo "</div>";
            }
        }
        ?>
    </div>
</div>
<br><br>

<!-- Tabela de disciplinas e professores -->
<div class="container mt-5">
    <h2>Professores das Aulas</h2>
    <table class="table">
        <thead>
            <tr>
                <th>Disciplina</th>
                <th>Professor</th>
            </tr>
        </thead>
        <tbody>
            <?php
            // Arrays para armazenar disciplinas de aulas individuais e em grupo/turma
            $disciplinasIndividuais = [];
            $disciplinasTurmas = [];

            // Iterar sobre as aulas individuais e agrupar as disciplinas
            while ($row = $result_individuais->fetch_assoc()) {
                $disciplina = $row['nome_dis'];
                $id_aula = $row['id_aula'];

                // Obter o nome do professor da aula individual
                $query_professor_individual = "SELECT users1.Nome AS nomeProfessor
                                               FROM aulas
                                               JOIN users1 ON aulas.prof = users1.user
                                               WHERE aulas.id_aula = '$id_aula'";
                $result_professor_individual = $mysqli->query($query_professor_individual);

                if ($result_professor_individual && $result_professor_individual->num_rows > 0) {
                    $professor_row = $result_professor_individual->fetch_assoc();
                    $nomeProfessor = $professor_row['nomeProfessor'];

                    // Armazenar disciplina de aula individual
                    $disciplinasIndividuais[] = ['disciplina' => $disciplina, 'professor' => $nomeProfessor];
                }
            }

            // Iterar sobre as aulas de turmas e agrupar as disciplinas
            while ($row = $result_turmas_aulas->fetch_assoc()) {
                $disciplina = $row['nome_dis'];
                $id_aula = $row['id_aula'];

                // Obter o nome do professor da aula de turma
                $query_professor_turma = "SELECT users1.Nome AS nomeProfessor
                                          FROM aulas
                                          JOIN users1 ON aulas.prof = users1.user
                                          WHERE aulas.id_aula = '$id_aula'";
                $result_professor_turma = $mysqli->query($query_professor_turma);

                if ($result_professor_turma && $result_professor_turma->num_rows > 0) {
                    $professor_row = $result_professor_turma->fetch_assoc();
                    $nomeProfessor = $professor_row['nomeProfessor'];

                    // Armazenar disciplina de aula em grupo/turma
                    $disciplinasTurmas[] = ['disciplina' => $disciplina, 'professor' => $nomeProfessor];
                }
            }

            // Função para exibir linhas da tabela com as disciplinas
            function exibirDisciplinas($disciplinas, $labelColor) {
                foreach ($disciplinas as $disciplinaInfo) {
                    $disciplina = $disciplinaInfo['disciplina'];
                    $nomeProfessor = $disciplinaInfo['professor'];

                    // Exibir linha com a disciplina e o professor
                    echo "<tr><td><span class='$labelColor'>$disciplina</span></td><td>$nomeProfessor</td></tr>";
                }
            }

            // Exibir disciplinas individuais (verde)
            exibirDisciplinas($disciplinasIndividuais, 'green-label');

            // Exibir disciplinas em grupo/turma (azul)
            exibirDisciplinas($disciplinasTurmas, 'blue-label');
            ?>
        </tbody>
    </table>
</div>


<!-- Modais -->
<div class="modal fade" id="modalDetalhesAula" tabindex="-1" aria-labelledby="modalDetalhesAulaLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="modalDetalhesAulaLabel">Detalhes da Aula</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body" id="detalhesAulaContent">
                <!-- Conteúdo dos detalhes da aula será inserido aqui dinamicamente -->
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Fechar</button>
            </div>
        </div>
    </div>
</div>


</body>
</html>

<script>
$(document).ready(function() {
    $('.green-label, .blue-label').click(function() {
        var idAula = $(this).data('id-aula');
        
        // Requisição AJAX para obter os detalhes da aula
        $.ajax({
            url: 'obter_detalhes_aula.php', // Arquivo PHP para processar a requisição
            method: 'POST',
            data: { idAula: idAula },
            dataType: 'json',
            success: function(response) {
                if (response.success) {
                    var nomeProfessor = response.nomeProfessor;
                    var disciplina = response.disciplina;
                    var horaInicio = response.horaInicio;
                    var horaFim = response.horaFim;
                    var diaSemana = response.diaSemana;

                    // Monta o conteúdo do modal com os detalhes da aula
                    var modalContent = `
                        <p><strong>Professor:</strong> ${nomeProfessor}</p>
                        <p><strong>Disciplina:</strong> ${disciplina}</p>
                        <p><strong>Hora de Início:</strong> ${horaInicio}</p>
                        <p><strong>Hora de Fim:</strong> ${horaFim}</p>
                        <p><strong>Dia da Semana:</strong> ${obterDiaSemanaTexto(diaSemana)}</p>
                    `;

                    // Atualiza o conteúdo do modal com os detalhes da aula
                    $('#detalhesAulaContent').html(modalContent);

                    // Abre o modal
                    $('#modalDetalhesAula').modal('show');
                } else {
                }
            },
            error: function() {
            }
        });
    });
});

// Função para obter o nome do dia da semana a partir do número (1 a 7)
function obterDiaSemanaTexto(numeroDia) {
    var diasSemana = ['Segunda-feira', 'Terça-feira', 'Quarta-feira', 'Quinta-feira', 'Sexta-feira', 'Sábado', 'Domingo'];
    return diasSemana[numeroDia - 1]; // Ajusta o índice para começar em 0
}


$(document).ready(function() {
    // Ao clicar no botão "Imprimir Horário"
    $('#imprimirHorario').click(function() {
        // Requisição AJAX para carregar o conteúdo da página horarios_alunos.php
        $.ajax({
            url: './generals/horarios_alunos.php',
            method: 'GET',
            success: function(response) {
                // Cria um iframe temporário com o conteúdo carregado
                var iframe = document.createElement('iframe');
                $(iframe).hide(); // Esconde o iframe
                $(iframe).attr('srcdoc', response); // Define o conteúdo do iframe como o HTML da página carregada
                $(document.body).append(iframe); // Adiciona o iframe ao corpo do documento

                // Espera um pouco antes de chamar a função de impressão para garantir que o conteúdo seja carregado
                setTimeout(function() {
                    iframe.contentWindow.print(); // Chama a função de impressão no contexto do iframe
                    $(iframe).remove(); // Remove o iframe após a impressão
                }, 1000); // Tempo em milissegundos antes de chamar a função de impressão (aqui definido como 1 segundo)
            },
            error: function() {
                // Trata erros de carregamento da página
                console.error('Erro ao carregar a página.');
            }
        });
    });
});


</script>

<?php
include "footer-reservado.php";
?>