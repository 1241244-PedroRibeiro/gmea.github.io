<!-- Modal de Marcação de Faltas -->
<div class="modal fade" id="marcaFaltasModal" tabindex="-1" aria-labelledby="marcaFaltasModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="marcaFaltasModalLabel">Marcação de Faltas</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="row row-cols-1 row-cols-md-3 g-4">
                    <?php foreach ($alunos as $aluno): ?>
                        <div class="col">
                            <div class="card h-100 text-center"> <!-- Adiciona a classe text-center para centralizar o conteúdo -->
                                <?php
                                    // Caminho da foto do aluno
                                    $caminhoFoto = $aluno['foto']; // Ajuste o caminho conforme necessário
                                ?>
                                <img src="<?php echo $caminhoFoto; ?>" class="card-img-top" alt="Foto do Aluno">
                                <div class="card-body d-flex flex-column justify-content-between align-items-center">
                                    <h5 class="card-title"><?php echo $aluno['user']; ?> - <?php echo $aluno['nome']; ?></h5>
                                    <p class="card-text">Selecione o tipo de falta:</p>
                                    <div class="btn-group mt-2 w-100" role="group" aria-label="Tipo de Faltas">
                                        <?php
                                            // Array de tipos de falta a serem exibidos nos botões
                                            $tiposFalta = ['P', 'FI', 'FJ', 'FA', 'FM', 'FD'];
                                            // Dividir os botões em duas linhas
                                            $count = 0;
                                            foreach ($tiposFalta as $tipo): ?>
                                                <?php if ($count > 0 && $count % 3 === 0): ?>
                                                    </div>
                                                    <div class="btn-group mt-2 w-100" role="group" aria-label="Tipo de Faltas">
                                                <?php endif; ?>
                                                <button type="button" class="btn btn-outline-danger toggle-btn" data-aluno="<?php echo $aluno['user']; ?>" data-tipo="<?php echo $tipo; ?>"><?php echo $tipo; ?></button>
                                                <?php $count++; ?>
                                            <?php endforeach; ?>
                                    </div>
                                </div>
                            </div>
                        </div>
                    <?php endforeach; ?>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Fechar</button>
            </div>
        </div>
    </div>
</div>

<!-- Estilo CSS para ajustes -->
<style>
    .modal-content {
        /* Define uma largura máxima para o conteúdo do modal */
        max-width: 800px;
        /* Centraliza o modal horizontalmente */
        margin: 0 auto;
    }

    .card {
        /* Adiciona margem inferior para separar os cards */
        margin-bottom: 20px;
        /* Adiciona padding interno para espaçamento interno */
        padding: 10px;
    }

    .card-img-top {
        /* Define a largura máxima para a imagem do aluno */
        max-width: 100%;
        height: auto;
    }

    .btn-group .btn {
        /* Ajusta a largura dos botões para serem iguais */
        width: 80px; /* Personalize conforme necessário */
    }
</style>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const toggleButtons = document.querySelectorAll('.toggle-btn');

    // Função para desativar os botões FA, FM e FD imediatamente ao carregar o modal
    function disableNonPButtons() {
        toggleButtons.forEach(button => {
            const aluno = button.dataset.aluno;
            const tipoFalta = button.dataset.tipo;

            // Verificar se o botão é FA, FM ou FD
            if (['FA', 'FM', 'FD'].includes(tipoFalta)) {
                const buttonsP = Array.from(document.querySelectorAll(`.toggle-btn[data-aluno="${aluno}"][data-tipo="P"]`));
                const buttonPSelected = buttonsP.some(btn => btn.classList.contains('btn-danger'));

                // Desativar o botão se P não estiver selecionado
                button.disabled = !buttonPSelected;

                // Remover classe de perigo se estiver desativado
                if (!buttonPSelected) {
                    button.classList.remove('btn-danger');
                    button.classList.add('btn-outline-danger');
                }
            }
        });
    }

    // Desativar os botões FA, FM e FD imediatamente ao carregar o modal
    disableNonPButtons();

    toggleButtons.forEach(button => {
        button.addEventListener('click', function() {
            const aluno = button.dataset.aluno;
            const tipoFalta = button.dataset.tipo;
            const tipoFaltasExclusivas = ['P', 'FI', 'FJ'];

            // Verificar se o botão clicado é de tipo exclusivo (FI ou FJ)
            if (tipoFaltasExclusivas.includes(tipoFalta)) {
                const buttonsForAluno = document.querySelectorAll(`.toggle-btn[data-aluno="${aluno}"]`);

                // Desselecionar todos os botões de tipo exclusivo do mesmo aluno
                buttonsForAluno.forEach(btn => {
                    if (btn !== button && tipoFaltasExclusivas.includes(btn.dataset.tipo)) {
                        btn.classList.remove('btn-danger');
                        btn.classList.add('btn-outline-danger');
                    }
                });

                // Bloquear os botões FA, FM e FD se FI ou FJ estiver selecionado
                const nonExclusiveButtons = ['FA', 'FM', 'FD'];
                nonExclusiveButtons.forEach(type => {
                    const btn = Array.from(buttonsForAluno).find(btn => btn.dataset.tipo === type);
                    if (btn) {
                        btn.disabled = tipoFalta !== 'P'; // Desativa se P não estiver selecionado
                        if (tipoFalta !== 'P') {
                            btn.classList.remove('btn-danger');
                            btn.classList.add('btn-outline-danger');
                        }
                    }
                });
            }

            // Toggle de seleção do botão clicado
            if (button.classList.contains('btn-danger')) {
                button.classList.remove('btn-danger');
                button.classList.add('btn-outline-danger');
            } else {
                button.classList.remove('btn-outline-danger');
                button.classList.add('btn-danger');
            }

            // Desativar os botões FA, FM e FD se P não estiver selecionado
            disableNonPButtons();
        });
    });
});


</script>
