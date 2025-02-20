<?php
session_start();
require_once("generals/config.php");
ini_set('display_errors', 0);

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


// Obter o endereço IP do usuário
$ip = gethostbyaddr($_SERVER['REMOTE_ADDR']);

// Consultar se o IP já existe na tabela de cookies
$currentDateTime = date('Y-m-d H:i:s'); // Obtém a data e hora atual no formato 'Y-m-d H:i:s'
$queryCheckIP = "SELECT COUNT(*) AS ip_count FROM cookies WHERE ip_address = ? AND expiry_date > ?";
$statementCheckIP = $mysqli->prepare($queryCheckIP);
$statementCheckIP->bind_param('ss', $ip, $currentDateTime);
$statementCheckIP->execute();
$statementCheckIP->bind_result($ipCount);
$statementCheckIP->fetch();
$statementCheckIP->close();

// Verificar se o IP já existe na base de dados
$ipExists = ($ipCount > 0);

// Definir se a mensagem de cookies deve ser exibida com base na existência do IP na base de dados
$showCookieMessage = !$ipExists;

if (!$ipExists) {
    // Cookie a ser armazenado no banco de dados (por exemplo, 'cookieConsent')
    $cookieName = 'cookieConsent';

    // Data de expiração do cookie no formato Unix timestamp
    $expiry = time() + (14 * 24 * 60 * 60); // Expira em duas semanas

    // Armazena o cookie no banco de dados
    $query = "INSERT INTO cookies (cookie_name, ip_address, expiry_date) VALUES (?, ?, ?)";
    $statement = $mysqli->prepare($query);
    $expiryDateTime = date('Y-m-d H:i:s', $expiry);
    $statement->bind_param('sss', $cookieName, $ip, $expiryDateTime);

    $statement->execute();
    $statement->close();
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
</style>

</head>
<body>
    <!-- Exibir a mensagem de cookies apenas se necessário -->
<?php if ($showCookieMessage) { ?>
<div id="cookies" style="background-color: #333; color: #fff; padding: 10px; position: fixed; bottom: 0; left: 0; width: 100%; text-align: center; z-index: 999;">
    Utilizamos cookies para adaptar conteúdos, oferecer funcionalidades personalizadas e analisar o tráfego do nosso site. Não partilhamos dados pessoais com terceiros, apenas informações sobre o uso do site. Consulte a nossa Política de Cookies e Aviso Legal para mais informações.
    <br><button onclick="acceptCookies()" style="background-color: #00631b; color: #fff; border: none; padding: 5px 10px; margin-left: 10px; cursor: pointer;">Fechar</button>
</div>
<?php } ?>
    <?php
        include "header.php";
    ?>

<div class="container" >
    <h2><?php echo $tituloNoticia; ?></h2>
    <p>Data: <?php echo $dataNoticia; ?></p>
    <?php
    $query = "SELECT user FROM noticias_info WHERE id_noticia = $idNoticia";
    $result = $mysqli->query($query);
    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            $queryNome = "SELECT nome FROM users1 WHERE user = '" . $row['user'] . "'";
            $resultNome = $mysqli->query($queryNome);
            if ($resultNome->num_rows > 0) {
                while ($rowNome = $resultNome->fetch_assoc()) {
                    print('<p> Adicionada por: ' . $rowNome['nome'] . '</td>');
                }
            }
            // Libere a memória associada ao resultado da consulta
            $resultNome->free();
        }
    }
    ?>
    <p><?php echo $textoNoticia; ?></p>

    <?php if (!empty($fotos)) { ?>
        <div id="carouselExampleIndicators" class="carousel slide mx-auto" data-bs-ride="carousel" style ="background-color: black;">
            <div class="carousel-inner">
                <?php
                foreach ($fotos as $index => $foto) {
                    ?>
                    <div class="carousel-item <?php echo ($index === 0) ? 'active' : ''; ?>" style="text-align: center;">
                        <?php
                        // Get image dimensions
                        list($width, $height) = getimagesize($foto);
                        
                        // Calculate aspect ratio
                        $aspectRatio = $width / $height;
                        
                        // Calculate width and height for stretched image
                        $stretchedWidth = 600 * $aspectRatio;
                        $stretchedHeight = 600;
                        ?>
                        <div style="max-width: 100%; height: 600px; display: flex; justify-content: center; align-items: center; overflow: hidden; border: 1px solid black;">
                            <img src="<?php echo htmlspecialchars(trim($foto)); ?>" class="d-block" alt="Imagem da notícia" style="width: <?php echo $stretchedWidth; ?>px; height: <?php echo $stretchedHeight; ?>px; object-fit: <?php echo ($aspectRatio > 1) ? 'cover' : 'contain'; ?>;">
                        </div>
                    </div>
                    <?php
                }
                ?>
            </div>
            <?php if (!empty($fotos) && count($fotos) > 1) { ?>
                <button class="carousel-control-prev" type="button" data-bs-target="#carouselExampleIndicators" data-bs-slide="prev">
                    <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                    <span class="visually-hidden">Previous</span>
                </button>
                <button class="carousel-control-next" type="button" data-bs-target="#carouselExampleIndicators" data-bs-slide="next">
                    <span class="carousel-control-next-icon" aria-hidden="true"></span>
                    <span class="visually-hidden">Next</span>
                </button>
            <?php } ?>

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
        $query = "SELECT password FROM users1 WHERE user=? and estado=1";
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
                $query = "SELECT type FROM users1 WHERE user=? and estado=1";
                $statement = $mysqli->prepare($query);
                $statement->bind_param('s', $_POST["user"]);
                $statement->execute();
                $statement->bind_result($type);

                if ($statement->fetch()) {
                    $_SESSION["session_id"] = session_id();
                    $_SESSION["username"] = $_POST["user"];
                    $_SESSION["type"] = $type;
                    $_SESSION["ano_letivo"] = "2023/24";
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
          <a href="recuperar-password.php" style="text-align: center; text-decoration: none; color: black;"><strong>Recuperar</strong> palavra-passe</a>
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


    function acceptCookies() {
        // Armazene o consentimento do usuário em um cookie com uma data de expiração
        document.cookie = "cookieConsent=accepted; expires=Fri, 31 Dec 9999 23:59:59 GMT; path=/";

        // Oculte a notificação de cookies
        document.getElementById('cookies').style.display = 'none';
    }

    // Verifique se o usuário já aceitou os cookies
    function checkCookies() {
        if (document.cookie.indexOf('cookieConsent=accepted') === -1) {
            // Se não houver consentimento, exiba a notificação
            document.getElementById('cookie-notification').style.display = 'block';
        }
    }

    // Verificar cookies assim que a página for carregada
    document.addEventListener('DOMContentLoaded', function() {
        checkCookies();
    });

</script>