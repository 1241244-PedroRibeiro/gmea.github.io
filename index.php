<?php
session_start();
require_once("generals/config.php");
ini_set('display_errors', 0);

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
          LIMIT 6";
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
$currentDate = date('Y-m-d');
$queryAvisos = "SELECT a.titulo, a.texto, a.data_inicio, u.nome AS criador_nome
                FROM avisos a
                JOIN users1 u ON a.criador = u.user
                WHERE a.destino = 'todos' AND a.data_fim >= '$currentDate'";
$resultAvisos = $mysqli->query($queryAvisos);


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

        .news-image {
            width: 100%;
            height: 350px; /* Defina a altura desejada para as imagens */
            object-fit: cover; /* Redimensiona a imagem para preencher o espaço mantendo a proporção */
        }
                /* Estilo para a div do mapa */
        .map-container {
            position: relative;
            width: 100%;
            height: 400px; /* Altura desejada para o mapa */
            border-radius: 10px;
            overflow: hidden;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        }

        /* Estilo para o mapa dentro da div */
        #google-map {
            width: 100%;
            height: 100%;
            border: none;
        }
        
        /* Estilo para o título da seção */
        .section-title {
            font-size: 24px;
            font-weight: bold;
            color: #333;
            margin-bottom: 20px;
        }

        #cookie-notification {
            display: none; /* Inicia oculto até que seja verificado */
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

<div style="width: 85%; margin: auto;">
    <h2>Notícias Recentes</h2>
    <div class="row">
        <div class="col-md-9">
            <div class="row">
                <?php foreach ($noticias as $noticia) { ?>
                    <div class="col-md-4">
                        <div class="card mb-4">
                            <?php if ($noticia['fotos']) {
                                // Converte a data de nascimento para o formato dd-mm-yyyy
                                $data_nas_formatada = DateTime::createFromFormat('Y-m-d', $noticia['data'])->format('d/m/Y');
                                $imagens = explode(",", $noticia['fotos']);
                                $imagem = $imagens[0];
                                ?>
                                <img src="<?php echo htmlspecialchars($imagem); ?>" class="card-img-top news-image" alt="Imagem da notícia">
                            <?php } ?>
                            <div class="card-body">
                                <h5 class="card-title"><?php echo $noticia['titulo']; ?></h5>
                                <p class="card-text"><?php echo $data_nas_formatada; ?></p>
                                <a href="noticia.php?id=<?php echo $noticia['id']; ?>"
                                   class="btn btn-primary" style="background-color: #00631b; border-color: black;">Ver Notícia</a>
                            </div>
                        </div>
                    </div>
                <?php } ?>
            </div>
            <a href="noticias.php" style="text-decoration: none; color: #00631b; text-align: right;"><strong>Ver todas as notícias »</strong></a>
        </div>
        <div class="col-md-3" style="background-color: #00631b; color: #FFF; padding: 10px;">
            <div style="background-color: #F4C01E; text-align: left; padding: 10px;">
                <span style="font-size: 30px;" class="titulonews"><b>AVISOS</b></span>
            </div>
            <div style="padding: 15px;">
                <?php
                if ($resultAvisos && $resultAvisos->num_rows > 0) {
                    while ($aviso = $resultAvisos->fetch_assoc()) {
                        echo '<div>';
                        echo '<h5 style="background-color: #000;">' . $aviso['titulo'] . '</h5>';
                        echo '<p>' . $aviso['texto'] . '</p>';
                        $data_inicio = $aviso['data_inicio']; // Assume que $aviso['data_inicio'] é uma string no formato 'YYYY-MM-DD'
                        $dateObj = DateTime::createFromFormat('Y-m-d', $data_inicio);
                        $data_formatada = $dateObj->format('d/m/Y');
                        echo '<h6>' . $data_formatada . '</h6>';                        
                        echo '<h6> ' . $aviso['criador_nome'] . '</h6>';
                        echo '</div><hr>';
                    }
                } else {
                    echo '<p>Nenhum aviso disponível.</p>';
                }
                ?>
            </div>
        </div>

        <div style="max-width: 60%; margin: 0 auto; padding: 20px;">
            <!-- O estilo do h2 foi ajustado para controlar a largura da cor de fundo -->
            <h2 style="display: inline-block; padding: 10px; background-color: #00631b; color: #fff;">
                Venha ter connosco!
            </h2>

            <div class="map-container">
                <iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3010.0565834166155!2d-8.543173!3d41.024018!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0xd247eecca41c49d%3A0xad54fe277d7ba1f4!2sGrupo%20Musical%20Estrela%20de%20Argoncilhe!5e0!3m2!1spt-PT!2spt!4v1715633307942!5m2!1spt-PT!2spt" width="100%" height="400" style="border:0;" allowfullscreen="" loading="lazy" referrerpolicy="no-referrer-when-downgrade"></iframe>
            </div>
        </div>


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