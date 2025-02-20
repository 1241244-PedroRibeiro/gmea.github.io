<?php
session_start();
include "./generals/config.php";
$mysqli = new mysqli($bd_host, $bd_user, $bd_password, $bd_database);

if ($mysqli->connect_error) {
    die('Erro: (' . $mysqli->connect_errno . ') ' . $mysqli->connect_error);
}

// Obter o usuário logado
$username = $_SESSION["username"];

// Consultar aulas do professor
$query_professor_aulas = "SELECT aulas.userOuTurma, aulas.id_aula, aulas.hora_inicio, aulas.hora_fim, aulas.dia_semana, cod_dis.nome_dis,
                          CASE 
                              WHEN LOWER(SUBSTRING(aulas.userOuTurma, 1, 1)) = 'a' THEN users1.nome
                              WHEN LOWER(SUBSTRING(aulas.userOuTurma, 1, 1)) = 't' THEN turmas.nome_turma
                          END AS nome_aluno_turma
                          FROM aulas
                          JOIN cod_dis ON aulas.cod_dis = cod_dis.cod_dis
                          LEFT JOIN users1 ON LOWER(SUBSTRING(aulas.userOuTurma, 1, 1)) = 'a' AND users1.user = aulas.userOuTurma
                          LEFT JOIN turmas ON LOWER(SUBSTRING(aulas.userOuTurma, 1, 1)) = 't' AND turmas.cod_turma = aulas.userOuTurma
                          WHERE aulas.prof = '$username'
                          ORDER BY aulas.dia_semana, aulas.hora_inicio";


$result_professor_aulas = $mysqli->query($query_professor_aulas);
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
if ($_SESSION["type"] == 2) { // Mostrar cabeçalho para professores
    include "header-profs.php";
}
if ($_SESSION["type"] == 4) { // Mostrar cabeçalho para professores
    include "header-professor-direcao.php";
}
?>

<div class="container mt-5">
    <h2>Horário Semanal</h2>
    <p>Este é o horário das suas aulas como professor. Para consultar todos os detalhes acerca das aulas ou inserir o sumário, clique no bloco da aula.</p>
    
    <div class="d-flex justify-content-end mb-3">
        <button class="btn btn-secondary" id="imprimirHorario">Imprimir Horário</button>
    </div>

    <!-- Grade do horário -->
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
            // Loop para criar a grade do horário
            for ($hora = 8; $hora <= 23; $hora++) {
                echo "<div>$hora:00 - " . ($hora + 1) . ":00</div>";

                for ($diaSemana = 1; $diaSemana <= 7; $diaSemana++) {
                    echo "<div style='position:relative;'>"; // Adiciona posição relativa para posicionar o nome da aula absolutamente
                            
                    // Verifica se há aula para este dia e hora específicos
                    while ($row = $result_professor_aulas->fetch_assoc()) {
                        $horaIni = intval(explode(':', $row['hora_inicio'])[0]);
                        $minIni = intval(explode(':', $row['hora_inicio'])[1]);
                        $horaFim = intval(explode(':', $row['hora_fim'])[0]);
                        $minFim = intval(explode(':', $row['hora_fim'])[1]);
                            
                        if ($diaSemana == $row['dia_semana'] && $hora >= $horaIni && $hora < $horaFim) {
                            $inicioAulaMinutos = $horaIni * 60 + $minIni;
                            $inicioBlocoMinutos = ($hora * 60);
                            $alturaAulaMinutos = ($horaFim * 60 + $minFim) - $inicioAulaMinutos;
                            $alturaBlocoMinutos = 60;
                            $topPercent = (($inicioAulaMinutos - $inicioBlocoMinutos) / $alturaBlocoMinutos) * 100;
                            $alturaPercent = ($alturaAulaMinutos / $alturaBlocoMinutos) * 100;
                            
                            $corBloco = (strtolower(substr($row['userOuTurma'], 0, 1)) === 'a') ? 'green' : 'blue';
                            $style = "position: absolute; top: $topPercent%; left: 0; width: 100%; height: $alturaPercent%; background-color: $corBloco; border-radius: 5px; padding: 5px; z-index: 1;";
                            $id_aula = $row['id_aula'];
                            
                            // Exibir o nome do Aluno/Turma e a disciplina no bloco de aula
                            echo "<div class='aula-block $corBloco-label' style='$style' data-id-aula='$id_aula'>";
                            echo "<span style='display: flex; flex-direction: column; justify-content: center; align-items: center; height: 100%;'>";
                            echo "<strong>{$row['nome_dis']}</strong>"; // Disciplina em negrito
                            echo "<span style='font-size:9px;'>(" . $row['nome_aluno_turma'] . ")</span>"; // Nome do Aluno/Turma
                            echo "</span>";
                            echo "</div>";
                        }
                    }
                            
                    $result_professor_aulas->data_seek(0); // Reinicia o ponteiro para o início do resultado

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

<!-- Modal de detalhes da aula -->
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
                <button type="button" class="btn btn-primary" id="inserirSumarioBtn">Inserir Sumário</button>
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Fechar</button>
            </div>
        </div>
    </div>
</div>


</body>
</html>

<script>
$(document).ready(function() {
    // Função para obter detalhes da aula e exibir no modal
    $('.aula-block').click(function() {
        var idAula = $(this).data('id-aula');

        $.ajax({
            url: 'obter_detalhes_aula_prof.php',
            method: 'POST',
            data: { idAula: idAula },
            dataType: 'json',
            success: function(response) {
                if (response.success) {
                    var userOuTurma = response.userOuTurma;
                    var nomeDis = response.nomeDis;
                    var horaInicio = response.horaInicio;
                    var horaFim = response.horaFim;
                    var diaSemana = response.diaSemana;

                    var modalContent = `
                        <p><strong>Aluno/Turma:</strong> ${userOuTurma}</p>
                        <p><strong>Disciplina:</strong> ${nomeDis}</p>
                        <p><strong>Hora de Início:</strong> ${horaInicio}</p>
                        <p><strong>Hora de Fim:</strong> ${horaFim}</p>
                        <p><strong>Dia da Semana:</strong> ${obterDiaSemanaTexto(diaSemana)}</p>
                    `;

                    $('#detalhesAulaContent').html(modalContent);
                    $('#modalDetalhesAula').modal('show');

                    // Configurar o botão "Inserir Sumário" com os dados da aula atual
                    $('#inserirSumarioBtn').data({
                        'id-aula': idAula,
                        'hora-inicio': horaInicio,
                        'hora-fim': horaFim
                    });
                } else {
                    alert('Erro ao carregar detalhes da aula.');
                }
            },
            error: function() {
                alert('Erro ao carregar detalhes da aula.');
            }
        });
    });

    // Evento de clique no botão "Inserir Sumário"
    $('#inserirSumarioBtn').on('click', function() {
        // Obter dados da aula atual
        var idAula = $(this).data('id-aula');
        var horaInicio = $(this).data('hora-inicio');
        var horaFim = $(this).data('hora-fim');

        // Redirecionar para a página de inserção de sumário com parâmetros
        window.location.href = `sumarios.php?idAula=${idAula}`;
    });

    // Função para obter o nome do dia da semana a partir do número (1 a 7)
    function obterDiaSemanaTexto(numeroDia) {
        var diasSemana = ['Segunda-feira', 'Terça-feira', 'Quarta-feira', 'Quinta-feira', 'Sexta-feira', 'Sábado', 'Domingo'];
        return diasSemana[numeroDia - 1]; // Ajusta o índice para começar em 0
    }
});

$(document).ready(function() {
    // Ao clicar no botão "Imprimir Horário"
    $('#imprimirHorario').click(function() {
        // Requisição AJAX para carregar o conteúdo da página horarios_alunos.php
        $.ajax({
            url: './generals/horarios_profs.php',
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
