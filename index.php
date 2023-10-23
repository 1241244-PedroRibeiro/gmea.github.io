<?php
session_start();
require_once("generals/config.php");

$mysqli = new mysqli($bd_host, $bd_user, $bd_password, $bd_database);

if ($mysqli->connect_error) {
    die('Erro: (' . $mysqli->connect_errno . ') ' . $mysqli->connect_error);
}


// Consulta as 3 notícias mais recentes
$query = "SELECT ni.id_noticia, nt.titulo_noticia, ni.data_noticia, nf.fotos_noticia
          FROM noticias_info ni
          JOIN noticias_titulo nt ON ni.id_noticia = nt.id_noticia
          LEFT JOIN noticias_fotos nf ON ni.id_noticia = nf.id_noticia
          GROUP BY ni.id_noticia
          ORDER BY ni.id_noticia DESC
          LIMIT 3";
$result = $mysqli->query($query);

$noticias = array();
if ($result && $result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $noticia = array(
            'id' => $row['id_noticia'],
            'titulo' => $row['titulo_noticia'],
            'data' => $row['data_noticia'],
            'fotos' => $row['fotos_noticia'] ? $row['fotos_noticia'] : null
        );
        $noticias[] = $noticia;
    }
}
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

        .news-image {
        width: 100%;
        height: 200px; /* Defina a altura desejada para as imagens */
        object-fit: cover; /* Redimensiona a imagem para preencher o espaço mantendo a proporção */
    }
    </style>

</head>
<body>
<?php
include "header.php";
?>

<div class="container">
    <h2>Notícias Recentes</h2>
    <div class="row">
        <?php foreach ($noticias as $noticia) { ?>
            <div class="col-md-4">
                <div class="card mb-4">
                <?php if ($noticia['fotos']) {
                    $imagens = explode(",", $noticia['fotos']);
                    $imagem = $imagens[0];
                ?>
                    <img src="<?php echo htmlspecialchars($imagem); ?>" class="card-img-top news-image" alt="Imagem da notícia">
                <?php } ?>
                    <div class="card-body">
                        <h5 class="card-title"><?php echo $noticia['titulo']; ?></h5>
                        <p class="card-text"><?php echo $noticia['data']; ?></p>
                        <a href="noticia.php?id=<?php echo $noticia['id']; ?>"
                           class="btn btn-primary" style="background-color: #00631b; border-color: black;">Ver Notícia</a>
                    </div>
                </div>
            </div>
        <?php } ?>
    </div>
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