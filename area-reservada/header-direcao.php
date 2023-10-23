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
                          CONTEÚDO
                        </a>
                        <ul class="dropdown-menu">
                          <li><a class="dropdown-item" href="gerir-servicos.php">Gerir Serviços</a></li>
                          <li><a class="dropdown-item" href="gerir-noticias.php">Gerir Notícias</a></li>
                          <li><a class="dropdown-item" href="#">Adicionar fotos</a></li>
                        </ul>
                    </li>
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle no-arrow" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                          INSERIR
                        </a>
                        <ul class="dropdown-menu">
                          <li><a class="dropdown-item" href="criar-utilizador.php">Inserir utilizadores</a></li>
                          <li><a class="dropdown-item" href="#">Inserir avisos</a></li>
                          <li><a class="dropdown-item" href="adicionar-inventario.php">Inserir inventário</a></li>
                          <li><a class="dropdown-item" href="#">Inserir membros banda sinfónica</a></li>
                        </ul>
                    </li>
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle no-arrow" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                          GERIR
                        </a>
                        <ul class="dropdown-menu">
                          <li><a class="dropdown-item" href="gerir-professores.php">Professores</a></li>
                          <li><a class="dropdown-item" href="gerir-alunos.php">Alunos</a></li>
                          <li><a class="dropdown-item" href="#">Turmas</a></li>
                          <li><a class="dropdown-item" href="#">Membros banda sinfónica</a></li>
                        </ul>
                    </li>
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle no-arrow" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                          REMOVER
                        </a>
                        <ul class="dropdown-menu">
                          <li><a class="dropdown-item" href="criar-utilizador.php">Remover utilizadores</a></li>
                          <li><a class="dropdown-item" href="#">Remover avisos</a></li>
                          <li><a class="dropdown-item" href="eliminar-inventario.php">Remover inventário</a></li>
                          <li><a class="dropdown-item" href="#">Remover membros banda sinfónica</a></li>
                        </ul>
                    </li>
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle no-arrow" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                          CONSULTAR
                        </a>
                        <ul class="dropdown-menu">
                          <li><a class="dropdown-item" href="#">Avaliações</a></li>
                          <li><a class="dropdown-item" href="#">Alunos</a></li>
                          <li><a class="dropdown-item" href="#">Professores</a></li>
                          <li><a class="dropdown-item" href="#">Avisos</a></li>
                          <li><a class="dropdown-item" href="consultar-inventario.php">Inventário (com filtro)</a></li>
                          <li><a class="dropdown-item" href="consultar-inventario-todo.php">Inventário (todo)</a></li>
                          <li><a class="dropdown-item" href="#">Membros Banda Sinfónica</a></li>
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