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
                          AVISOS
                        </a>
                        <ul class="dropdown-menu">
                          <li><a class="dropdown-item" href="gerir-avisos.php">Gerir Avisos</a></li>
                          <li><a class="dropdown-item" href="consultar-avisos.php">Consultar Avisos</a></li>
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
                          INFORMAÇÕES
                        </a>
                        <ul class="dropdown-menu">
                          <li><a class="dropdown-item" href="as-minhas-informacoes.php">Consultar os meus dados</a></li>
                          <li><a class="dropdown-item" href="alterar-password.php">Alterar a password</a></li>

                        </ul>
                    </li>
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle no-arrow" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                          CONSULTAR
                        </a>
                        <ul class="dropdown-menu">
                          <li><a class="dropdown-item" href="consultar-horario-prof.php">O meu horário</a></li>
                          <li><a class="dropdown-item" href="consultar-agenda.php">Eventos Marcados</a></li>
                        </ul>
                    </li>
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle no-arrow" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                          GERIR
                        </a>
                        <ul class="dropdown-menu">
                          <li><a class="dropdown-item" href="gerir-agenda.php">Agenda</a></li>
                          <li><a class="dropdown-item" href="gerir-avaliacoes.php">Notas de Avaliações</a></li>
                          <li><a class="dropdown-item" href="gerir-pautas.php">Pautas de Avaliação</a></li>
                          <li><a class="dropdown-item" href="gerir-sumarios.php">Sumários</a></li>
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