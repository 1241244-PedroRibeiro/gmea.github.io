
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
                <div class="navbar-nav">
                    <a href="index.php" class="nav-item nav-link">Início</a>
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                          Escola
                        </a>
                        <ul class="dropdown-menu">
                          <li><a class="dropdown-item" href="#">A nossa formação</a></li>
                          <li><a class="dropdown-item" href="#">Instrumento</a></li>
                          <li><a class="dropdown-item" href="#">Orquestra Juvenil</a></li>
                          <li><a class="dropdown-item" href="#">Formação Musical</a></li>
                          <li><a class="dropdown-item" href="#">Coro</a></li>
                          <li><hr class="dropdown-divider"></li>
                          <li><a class="dropdown-item" href="#">Fazer pré-inscrição</a></li>
                        </ul>
                    </li>
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                          Banda Sinfónica
                        </a>
                        <ul class="dropdown-menu">
                          <li><a class="dropdown-item" href="#">Músicos</a></li>
                          <li><a class="dropdown-item" href="servicos.php">Serviços e concertos</a></li>
                          <li><hr class="dropdown-divider"></li>
                          <li><a class="dropdown-item" href="#">Quero juntar-me</a></li>
                        </ul>
                    </li>
                    <a href="https://estreladeargoncilhe.bol.pt/" class="nav-item nav-link">Bilhetes</a>
                </div>
                <div class="navbar-nav ms-auto">
                    <button data-bs-toggle="modal" data-bs-target="#exampleModal" class="nav-item nav-link">Área reservada</button>
                </div>
            </div>
        </div>
    </nav>
</div>


<div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h1 class="modal-title fs-5" id="exampleModalLabel">Área Reservada</h1>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
									<form id="formlogin2" name="formlogin2" method="post">
                                    
                                    <div class="form-group">
                                        <label for="username" class="form-control-label">Utilizador</label>
                                        <input type="text" name="user" id="username" tabindex="1" class="form-control" placeholder="Utilizador" value="" required="">
                                    </div>
                                        <br>
                                    <div class="form-group">
                                        <label for="password" class="form-control-label">Password</label>
                                        <input type="password" name="password" id="password" tabindex="2" class="form-control" placeholder="Password" autocomplete="off" required="">
                                    </div>
                                        <br>
                                    
                                    <div class="form-group">
                                        <div class="row">
                                            
                                            <div class="col-xs-12 pull-right" style="width: 90%; margin: auto;">
                                                <button id="login" name="login" style="background-color: #00631b; width: 100%; margin: auto; color: whitesmoke; border-radius: 30px;" type="submit">Login</button>
                                            </div>
                                        </div>
                                                </div>
                                    
                                   </form>
                                   
                                
			</div>
    </div>
  </div>
</div>


<style>

    button {
        border: none;
        background-color: inherit;
        padding: 14px 28px;
        font-size: 16px;
        cursor: pointer;
        display: inline-block;
    }

    .dropdown-item:hover {
        background-color: #00631b;
        color: white;
    }
    .dropdown-item:active {
        background-color: none;
    }

</style>

<script>
const myModal = document.getElementById('myModal')
const myInput = document.getElementById('myInput')

myModal.addEventListener('shown.bs.modal', () => {
  myInput.focus()
})
</script>