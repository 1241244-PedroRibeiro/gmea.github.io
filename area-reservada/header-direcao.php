<div class="m-4">
    <nav class="navbar navbar-expand-lg navbar-light bg-light">
        <div class="container-fluid">
            <a href="#" class="navbar-brand">
                <img src="media/logo.png" height="50" alt="CoolBrand">
            </a>
            <button type="button" class="navbar-toggler" data-bs-toggle="collapse" data-bs-target="#navbarCollapse">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarCollapse">
                <div class="navbar-nav mx-auto">
                    <a href="index.php" class="nav-item nav-link">INÍCIO</a>
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle no-arrow" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                          INFORMAÇÕES
                        </a>
                        <ul class="dropdown-menu">
                          <li><a class="dropdown-item" href="as-minhas-informacoes.php">Consultar os meus dados</a></li>
                          <li><a class="dropdown-item" href="alterar-password.php">Alterar a password</a></li>
                        </ul>
                    </li>
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle no-arrow" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                          CONTEÚDO
                        </a>
                        <ul class="dropdown-menu">
                          <li><a class="dropdown-item" href="gerir-servicos.php">Gerir Serviços</a></li>
                          <li><a class="dropdown-item" href="gerir-conteudo.php">Gerir Páginas</a></li>
                          <li><a class="dropdown-item" href="gerir-avisos.php">Avisos</a></li>
                          <li><a class="dropdown-item" href="lancar-pautas.php">Pautas de Avaliação</a></li>
                        </ul>
                    </li>
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle no-arrow" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                          NOTÍCIAS
                        </a>
                        <ul class="dropdown-menu">
                          <li><a class="dropdown-item" href="adicionar-noticias.php">Adicionar Notícia</a></li>
                          <li><a class="dropdown-item" href="editar-noticias.php">Editar Notícia</a></li>
                          <li><a class="dropdown-item" href="eliminar-noticias.php">Eliminar Notícia</a></li>
                        </ul>
                    </li>
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle no-arrow" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                          GERIR
                        </a>
                        <ul class="dropdown-menu">
                          <li><a class="dropdown-item" href="gerir-utilizadores.php">Utilizadores</a></li>
                          <li><a class="dropdown-item" href="gerir-professores.php">Professores</a></li>
                          <li><a class="dropdown-item" href="gerir-inventario.php">Inventário</a></li>
                          <li><a class="dropdown-item" href="gerir-alunos.php">Alunos</a></li>
                          <li><a class="dropdown-item" href="gerir-informacoes-alunos.php">Informações dos Alunos</a></li>
                          <li><a class="dropdown-item" href="gerir-aulas.php">Aulas</a></li>
                          <li><a class="dropdown-item" href="gerir-alunos-aulas.php">Alunos das Turmas</a></li>
                          <li><a class="dropdown-item" href="gerir-turmas.php">Turmas</a></li>
                          <li><a class="dropdown-item" href="gerir-socios.php">Sócios</a></li>
                          <li><a class="dropdown-item" href="gerir-agenda.php">Agenda</a></li>
                          <li><a class="dropdown-item" href="gerir-justificacoes.php">Justificações de Faltas</a></li>
                        </ul>
                    </li>
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle no-arrow" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                          EMITIR
                        </a>
                        <ul class="dropdown-menu">
                          <li><a class="dropdown-item" href="quotas-socios.php">Quotas Sócios</a></li>
                          <li><a class="dropdown-item" href="mensalidades-alunos.php">Mensalidades dos alunos</a></li>
                          <li><a class="dropdown-item" href="emitir-faturas.php">Recibos</a></li>
                        </ul>
                    </li>
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle no-arrow" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                          CONSULTAR
                        </a>
                        <ul class="dropdown-menu">
                          <li><a class="dropdown-item" href="consultar-todas-avaliacoes.php">Avaliações</a></li>
                          <li><a class="dropdown-item" href="consultar-avisos.php">Avisos</a></li>
                        </ul>
                    </li>
                    <a href="generals/logout.php" class="nav-item nav-link">TERMINAR SESSÃO</a>
                      <!-- Botão de engrenagem -->
                      <button type="button" class="btn btn-outline-secondary" data-bs-toggle="modal" data-bs-target="#configModal">
                        <i class="fas fa-cog"></i>
                    </button>
                </div>
            </div>
        </div>
    </nav>
</div>




<style>
.dropdown-item:hover {
  background-color: #00631b;
  color: white;
}
.dropdown-item:active {
  background-color: none;
}
button {
        border: none;
        background-color: inherit;
        padding: 14px 28px;
        font-size: 16px;
        cursor: pointer;
        display: inline-block;
    }
    .navbar-nav .dropdown-toggle::after {
    display: none !important;
}

</style>

<!-- Modal -->
<div class="modal fade" id="configModal" tabindex="-1" aria-labelledby="configModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="configModalLabel">Configurações</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <!-- Conteúdo do modal aqui -->
                <div class="mb-3">
                    <label for="anoLetivoSelect" class="form-label">Ano Letivo:</label>
                    <select class="form-select" id="anoLetivoSelect">
                        <option value="">Selecione</option>
                        <option value="2023/24">2023/24</option>
                        <!-- Adicione outras opções de ano letivo conforme necessário -->
                    </select>
                </div>
                <p>Versão da aplicação: 0.8.01</p>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-primary" data-bs-dismiss="modal">Guardar</button>
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Fechar</button>
            </div>
        </div>
    </div>
</div>