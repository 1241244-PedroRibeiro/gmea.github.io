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
                    <a href="consultar-avisos.php" class="nav-item nav-link">AVISOS</a>
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle no-arrow" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                          INFORMAÇÕES
                        </a>
                        <ul class="dropdown-menu">
                          <li><a class="dropdown-item" href="as-minhas-informacoes.php">Os meus dados</a></li>
                          <li><a class="dropdown-item" href="alterar-password.php">Mudar password</a></li>
                        </ul>
                    </li>
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle no-arrow" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                          CONSULTAR
                        </a>
                        <ul class="dropdown-menu">
                          <li><a class="dropdown-item" href="consultar-horario-alunos.php">O meu horário</a></li>
                          <li><a class="dropdown-item" href="consultar-avaliacoes.php">Avaliações</a></li>
                          <li><a class="dropdown-item" href="consultar-minhas-pautas.php">Pautas de Avaliação</a></li>
                          <li><a class="dropdown-item" href="consultar-agenda.php">Agenda</a></li>
                          <li><a class="dropdown-item" href="consultar-mensalidade.php">Mensalidade</a></li>
                          <li><a class="dropdown-item" href="consultar-faltas.php">Faltas</a></li>
                        </ul>
                    </li>
                    <a href="generals/logout.php" class="nav-item nav-link">TERMINAR SESSÃO</a>
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