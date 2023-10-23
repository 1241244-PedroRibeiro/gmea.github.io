<?php
session_start();
require_once("generals/config.php");

$mysqli = new mysqli($bd_host, $bd_user, $bd_password, $bd_database);

if ($mysqli->connect_error) {
    die('Erro: (' . $mysqli->connect_errno . ') ' . $mysqli->connect_error);
}

$idNoticia = $_GET['id'];

// Consulta para obter informações completas da notícia, incluindo todas as fotos
$query = "SELECT nt.titulo_noticia, ni.data_noticia, txt.texto_noticia, GROUP_CONCAT(nf.fotos_noticia SEPARATOR ',') AS fotos_noticia
          FROM noticias_info ni
          JOIN noticias_titulo nt ON ni.id_noticia = nt.id_noticia
          JOIN noticias_texto txt ON ni.id_noticia = txt.id_noticia
          JOIN noticias_fotos nf ON ni.id_noticia = nf.id_noticia
          WHERE ni.id_noticia = ?
          LIMIT 1";

$statement = $mysqli->prepare($query);

if ($statement === false) {
    die('Erro: (' . $mysqli->errno . ') ' . $mysqli->error);
}

$statement->bind_param('i', $idNoticia);

if ($statement->execute() === false) {
    die('Erro: (' . $statement->errno . ') ' . $statement->error);
}

$statement->bind_result($tituloNoticia, $dataNoticia, $textoNoticia, $fotosNoticia);

if ($statement->fetch() === false) {
    die('Erro ao obter informações da notícia.');
}

$statement->close();

$fotos = explode(",", $fotosNoticia);
?>

<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<title>GMEA</title>
<link rel="shortcut icon" type="image/png" href="media/logo.png/"/>
<script src="https://use.fontawesome.com/releases/v6.3.0/js/all.js" crossorigin="anonymous"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.3.1/jquery.min.js" crossorigin="anonymous"></script>
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet">
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js"></script>

<style>
  @keyframes fadeIn {
    0% { opacity: 0; }
    100% { opacity: 1; }
  }

  body {
    animation: 2s ease-out 0s 1 fadeIn;
  }

  a:hover {
    color: red;
  }
</style>

</head>
<body>
    <?php
        include "header.php";
    ?>

    <div class="container">
        <h2><?php echo $tituloNoticia; ?></h2>
        <p>Data: <?php echo $dataNoticia; ?></p>
        <p><?php echo $textoNoticia; ?></p>

        <?php if (!empty($fotos)) { ?>
            <div id="carouselExampleIndicators" class="carousel slide" data-bs-ride="carousel" style="max-width: 500px; margin: 0 auto;">
                <div class="carousel-indicators">
                    <?php
                    for ($i = 0; $i < count($fotos); $i++) {
                        ?>
                        <button type="button" data-bs-target="#carouselExampleIndicators" data-bs-slide-to="<?php echo $i; ?>" class="<?php echo ($i === 0) ? 'active' : ''; ?>"></button>
                        <?php
                    }
                    ?>
                </div>
                <div class="carousel-inner">
                    <?php
                    foreach ($fotos as $index => $foto) {
                        ?>
                        <div class="carousel-item <?php echo ($index === 0) ? 'active' : ''; ?>">
                            <img src="<?php echo htmlspecialchars(trim($foto)); ?>" class="d-block w-100" alt="Imagem da notícia">
                        </div>
                        <?php
                    }
                    ?>
                </div>
                <button class="carousel-control-prev" type="button" data-bs-target="#carouselExampleIndicators" data-bs-slide="prev">
                    <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                    <span class="visually-hidden">Previous</span>
                </button>
                <button class="carousel-control-next" type="button" data-bs-target="#carouselExampleIndicators" data-bs-slide="next">
                    <span class="carousel-control-next-icon" aria-hidden="true"></span>
                    <span class="visually-hidden">Next</span>
                </button>
            </div>
        <?php } ?>

    </div>

    <?php
        include "footer.php";
    ?>
</body>
</html>

<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (isset($_POST["login"]) && isset($_POST["user"]) && isset($_POST["password"])) {
        $query = "SELECT password FROM users1 WHERE user=?";
        $statement = $mysqli->prepare($query);
        $statement->bind_param('s', $_POST["user"]);
        $statement->execute();
        $statement->bind_result($hashedPassword);

        if ($statement->fetch()) {
            $p = $_POST["password"];
            if (password_verify($p, $hashedPassword)) {
                // Fechar o resultado da primeira consulta
                $statement->close();

                // Executar a segunda consulta para obter o tipo de usuário
                $query = "SELECT type FROM users1 WHERE user=?";
                $statement = $mysqli->prepare($query);
                $statement->bind_param('s', $_POST["user"]);
                $statement->execute();
                $statement->bind_result($type);

                if ($statement->fetch()) {
                    $_SESSION["session_id"] = session_id();
                    $_SESSION["username"] = $_POST["user"];
                    $_SESSION["type"] = $type;
                    echo "<script>location.href='area-reservada/index.php';</script>";
                    exit;
                }
            }
        }

        echo '
    <script>
      document.addEventListener("DOMContentLoaded", function() {
        var body = document.getElementsByTagName("body")[0];
        body.classList.add("no-animations");
        
        var myModal = new bootstrap.Modal(document.getElementById("errorModal"));
        myModal.show();
        
        myModal.addEventListener("hidden.bs.modal", function() {
          body.classList.remove("no-animations");
        });
      });
    </script>
    
    <div class="modal" tabindex="-1" id="errorModal">
      <div class="modal-dialog">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title">Erro</h5>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
          </div>
          <br>
          <div style="width: 90%; margin: auto;" class="alert alert-danger">
            <p style="text-align: center;">Utilizador ou Password incorreto(s).</p>
          </div>
          <br>
          <a href="#" style="text-align: center; text-decoration: none; color: black;"><strong>Recuperar</strong> palavra-passe</a>
          <br>
        </div>
      </div>
    </div>';

        $statement->close();
    }
}
?>

<script>
    const myModal = document.getElementById('myModal')
    const myInput = document.getElementById('myInput')

    myModal.addEventListener('shown.bs.modal', () => {
        myInput.focus()
    })
</script>