<?php
session_start();
include "./generals/config.php";
$mysqli = new mysqli($bd_host, $bd_user, $bd_password, $bd_database);

// Verificar conexão
if ($mysqli->connect_error) {
    die('Erro na conexão: (' . $mysqli->connect_errno . ') ' . $mysqli->connect_error);
}

$alunos = [];
$faltas = [];
if (isset($_GET['idAula'])) {
    $idAula = $_GET['idAula'];
    $obterDisciplinaQuery = "SELECT cod_dis FROM aulas WHERE id_aula = $idAula";
    $resultObterDisciplina = $mysqli->query($obterDisciplinaQuery);

    if ($resultObterDisciplina && $resultObterDisciplina->num_rows > 0) {
        $rowDis = $resultObterDisciplina->fetch_assoc();
        $disciplina = $rowDis['cod_dis'];
    }

    if (isset($_GET['indiceAula'])) {
        $indiceAula = $_GET['indiceAula'];
    }

    $userOuTurmaQuery = "SELECT userOuTurma FROM aulas WHERE id_aula = $idAula";
    $resultUserOuTurma = $mysqli->query($userOuTurmaQuery);

    if ($resultUserOuTurma && $resultUserOuTurma->num_rows > 0) {
        $row = $resultUserOuTurma->fetch_assoc();
        $userOuTurma = $row['userOuTurma'];

        if (substr($userOuTurma, 0, 1) === 'a') {
            $alunoQuery = "SELECT u.user, u.nome, u.foto FROM users1 u JOIN aulas a ON u.user = a.userOuTurma WHERE a.id_aula = $idAula";
            $resultAlunos = $mysqli->query($alunoQuery);

            if ($resultAlunos && $resultAlunos->num_rows > 0) {
                while ($rowAluno = $resultAlunos->fetch_assoc()) {
                    $alunos[] = $rowAluno;
                }
            }
        } elseif (substr($userOuTurma, 0, 1) === 't') {
            $turmaQuery = "SELECT user FROM turmas_alunos WHERE cod_turma = '$userOuTurma'";
            $resultTurmaAlunos = $mysqli->query($turmaQuery);

            if ($resultTurmaAlunos && $resultTurmaAlunos->num_rows > 0) {
                while ($rowTurmaAluno = $resultTurmaAlunos->fetch_assoc()) {
                    $user = $rowTurmaAluno['user'];
                    $alunoQuery = "SELECT user, nome, foto FROM users1 WHERE user = '$user'";
                    $resultAluno = $mysqli->query($alunoQuery);

                    if ($resultAluno && $resultAluno->num_rows > 0) {
                        $rowAluno = $resultAluno->fetch_assoc();
                        $alunos[] = $rowAluno;
                    }
                }
            }
        }

        $faltasQuery = "SELECT user, tipo_falta FROM faltas WHERE id_aula = $idAula AND indice_aula = $indiceAula";
        $resultFaltas = $mysqli->query($faltasQuery);

        if ($resultFaltas && $resultFaltas->num_rows > 0) {
            while ($rowFalta = $resultFaltas->fetch_assoc()) {
                $faltas[$rowFalta['user']] = $rowFalta['tipo_falta'];
            }
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Marcação de Faltas</title>
    <script src="https://use.fontawesome.com/releases/v6.3.0/js/all.js" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.3.1/jquery.min.js" crossorigin="anonymous"></script>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js"></script>
    <link href="https://netdna.bootstrapcdn.com/font-awesome/3.2.1/css/font-awesome.css" rel="stylesheet">
    <link href="https://cdn.quilljs.com/1.3.6/quill.snow.css" rel="stylesheet">
    <script src="https://cdn.quilljs.com/1.3.6/quill.min.js"></script>
    <style>
        .modal-content {
            max-width: 800px;
            margin: 0 auto;
        }
        .card {
            margin-bottom: 20px;
            padding: 10px;
        }
        .card-img-top {
            max-width: 100%;
            height: auto;
        }
        .btn-group {
            display: flex;
            flex-wrap: wrap;
            justify-content: center;
        }
    </style>
</head>
<body>
        <div style="margin-top: 0;">
            <img style="width: 100%; height: auto;" src="./media/topAR.png" class="img-responsive">
        </div>

        <?php
        if ($_SESSION["type"] == 2) {
            include "header-profs.php";
        }
        if ($_SESSION["type"] == 3) {
            include "header-direcao.php";
        }
        ?>
    <div class="container mt-5">
        <h2>Marcação de Faltas</h2>
        <div class="row row-cols-1 row-cols-lg-5 g-4">
            <?php foreach ($alunos as $aluno): ?>
                <div class="col">
                    <div class="card h-100 text-center">
                        <?php $caminhoFoto = $aluno['foto']; ?>
                        <img src="<?php echo $caminhoFoto; ?>" class="card-img-top" alt="Foto do Aluno">
                        <div class="card-body d-flex flex-column justify-content-between align-items-center">
                            <h5 class="card-title"><?php echo $aluno['user']; ?> - <?php echo $aluno['nome']; ?></h5>
                            <p class="card-text">Selecione o tipo de falta:</p>
                            <div class="btn-group" role="group" aria-label="Tipo de Faltas">
                                <?php
                                    $tiposFalta = ['P', 'FI', 'FJ', 'FA', 'FM', 'FD'];
                                    foreach ($tiposFalta as $tipo):
                                        $isActive = isset($faltas[$aluno['user']]) && $faltas[$aluno['user']] == array_search($tipo, $tiposFalta) ? 'btn-danger' : 'btn-outline-danger';
                                ?>
                                    <button style="width: 60px; margin-bottom: 10px;" type="button" class="btn <?php echo $isActive; ?> toggle-btn" data-aluno="<?php echo $aluno['user']; ?>" data-tipo="<?php echo $tipo; ?>"><?php echo $tipo; ?></button>
                                <?php endforeach; ?>
                            </div>
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
    </div>
    <div class="text-center mt-4">
        <button id="submitFaltasBtn" class="btn btn-primary">Registrar Faltas</button>
    </div>

    <div class="modal fade" id="confirmModal" tabindex="-1" aria-labelledby="confirmModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="confirmModalLabel">Confirmação</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Fechar"></button>
                </div>
                <div class="modal-body">
                    Deseja realmente registrar as faltas selecionadas?
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                    <button type="button" id="confirmFaltasBtn" class="btn btn-primary">Registrar Faltas</button>
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade" id="warningModal" tabindex="-1" aria-labelledby="warningModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="warningModalLabel">Aviso</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Fechar"></button>
                </div>
                <div class="modal-body">
                    Cada aluno deve ter pelo menos um tipo de falta (P, FJ ou FI) selecionado para registrar.
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-primary" data-bs-dismiss="modal">OK</button>
                </div>
            </div>
        </div>
    </div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const toggleButtons = document.querySelectorAll('.toggle-btn');

    function disableNonPButtons() {
        toggleButtons.forEach(button => {
            const aluno = button.dataset.aluno;
            const tipoFalta = button.dataset.tipo;
            if (['FA', 'FM', 'FD'].includes(tipoFalta)) {
                const buttonsP = Array.from(document.querySelectorAll(`.toggle-btn[data-aluno="${aluno}"][data-tipo="P"]`));
                const buttonPSelected = buttonsP.some(btn => btn.classList.contains('btn-danger'));
                button.disabled = !buttonPSelected;
                if (!buttonPSelected) {
                    button.classList.remove('btn-danger');
                    button.classList.add('btn-outline-danger');
                }
            }
        });
    }

    disableNonPButtons();

    toggleButtons.forEach(button => {
        button.addEventListener('click', function() {
            const aluno = button.dataset.aluno;
            const tipoFalta = button.dataset.tipo;
            const tipoFaltasExclusivas = ['P', 'FI', 'FJ'];
            if (tipoFaltasExclusivas.includes(tipoFalta)) {
                const buttonsForAluno = document.querySelectorAll(`.toggle-btn[data-aluno="${aluno}"]`);
                buttonsForAluno.forEach(btn => {
                    if (btn !== button && tipoFaltasExclusivas.includes(btn.dataset.tipo)) {
                        btn.classList.remove('btn-danger');
                        btn.classList.add('btn-outline-danger');
                    }
                });
                const nonExclusiveButtons = ['FA', 'FM', 'FD'];
                nonExclusiveButtons.forEach(type => {
                    const btn = Array.from(buttonsForAluno).find(btn => btn.dataset.tipo === type);
                    if (btn) {
                        btn.disabled = tipoFalta !== 'P';
                        if (tipoFalta !== 'P') {
                            btn.classList.remove('btn-danger');
                            btn.classList.add('btn-outline-danger');
                        }
                    }
                });
            }
            if (button.classList.contains('btn-danger')) {
                button.classList.remove('btn-danger');
                button.classList.add('btn-outline-danger');
            } else {
                button.classList.remove('btn-outline-danger');
                button.classList.add('btn-danger');
            }
            disableNonPButtons();
        });
    });

    document.getElementById('submitFaltasBtn').addEventListener('click', function() {
        const faltasSelecionadas = [];
        let todosCardsComSelecaoValida = true;
        toggleButtons.forEach(btn => {
            if (btn.classList.contains('btn-danger')) {
                const aluno = btn.dataset.aluno;
                const tipoFalta = btn.dataset.tipo;
                faltasSelecionadas.push({
                    tipo: tipoFalta,
                    aluno: aluno
                });
                if (['P', 'FJ', 'FI'].includes(tipoFalta)) {
                    const card = btn.closest('.card');
                    card.classList.remove('border-danger');
                }
            }
        });
        const cards = document.querySelectorAll('.card');
        cards.forEach(card => {
            if (!card.querySelector('.btn-danger[data-tipo="P"], .btn-danger[data-tipo="FJ"], .btn-danger[data-tipo="FI"]')) {
                card.classList.add('border-danger');
                todosCardsComSelecaoValida = false;
            }
        });
        if (faltasSelecionadas.length > 0 && todosCardsComSelecaoValida) {
            const confirmModal = new bootstrap.Modal(document.getElementById('confirmModal'), {
                keyboard: false
            });
            confirmModal.show();
            document.getElementById('confirmFaltasBtn').addEventListener('click', function() {
                const idAula = <?php echo $idAula; ?>;
                const cod_dis = <?php echo $disciplina; ?>;
                const indiceAula = <?php echo isset($indiceAula) ? $indiceAula : 'null'; ?>;
                const dia = new Date().toISOString().slice(0, 10);
                $.ajax({
                    url: 'apagar_faltas.php',
                    method: 'POST',
                    data: {
                        id_aula: idAula,
                        indice_aula: indiceAula,
                    },
                    success: function(response) {
                        console.log('Faltas apagadas');
                    },
                    error: function(xhr, status, error) {
                        console.error('Erro ao apagar faltas');
                    }
                });
                faltasSelecionadas.forEach(falta => {
                    const { tipo, aluno } = falta;
                    const tipoFaltaMap = {
                        'FA': 3,
                        'FM': 4,
                        'FD': 5,
                        'FI': 1,
                        'FJ': 2,
                        'P': 0
                    };
                    const tipoFalta = tipoFaltaMap[tipo];
                    $.ajax({
                        url: 'registrar_falta.php',
                        method: 'POST',
                        data: {
                            id_aula: idAula,
                            user: aluno,
                            indice_aula: indiceAula,
                            tipo_falta: tipoFalta,
                            dia: dia,
                            cod_dis: cod_dis
                        },
                        success: function(response) {
                            console.log('Falta registrada com sucesso:', response);
                        },
                        error: function(xhr, status, error) {
                            console.error('Erro ao registrar falta:', error);
                        }
                    });
                });
                const url = `http://localhost/projecto/area-reservada/sumarios.php?idAula=${idAula}`;
                window.location.href = url;
            });
        } else {
            const warningModal = new bootstrap.Modal(document.getElementById('warningModal'), {
                keyboard: false
            });
            warningModal.show();
        }
    });
});

</script>

</body>
</html>

<?php include 'footer-reservado.php'; ?>
