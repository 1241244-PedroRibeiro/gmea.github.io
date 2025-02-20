<?php
session_start();
require_once("generals/config.php");
ini_set('display_errors', 0);

$mysqli = new mysqli($bd_host, $bd_user, $bd_password, $bd_database);

if ($mysqli->connect_error) {
    die('Erro: (' . $mysqli->connect_errno . ') ' . $mysqli->connect_error);
}

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

// Verificar se o formulário de login foi enviado
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
                    echo "<script>location.href='area-reservada/index.php';</script>";
                    exit;
                }
            }
        }

        // Exibir mensagem de erro se o login falhar
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

// Paginação
$noticias_por_pagina = 10;
$pagina_atual = isset($_GET['pagina']) && is_numeric($_GET['pagina']) ? $_GET['pagina'] : 1;
$inicio = ($pagina_atual - 1) * $noticias_por_pagina;

// Consulta as notícias para esta página
$query = "SELECT ni.id_noticia, nt.titulo_noticia, ni.data_noticia, SUBSTRING(txt.texto_noticia, 1, 400) AS preview_texto
          FROM noticias_info ni
          JOIN noticias_titulo nt ON ni.id_noticia = nt.id_noticia
          JOIN noticias_texto txt ON ni.id_noticia = txt.id_noticia
          GROUP BY ni.id_noticia
          ORDER BY ni.id_noticia DESC
          LIMIT ?, ?";
$statement = $mysqli->prepare($query);
$statement->bind_param('ii', $inicio, $noticias_por_pagina);
$statement->execute();
$result = $statement->get_result();

$noticias = array();
if ($result && $result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $noticia = array(
            'id' => $row['id_noticia'],
            'titulo' => $row['titulo_noticia'],
            'data' => $row['data_noticia'],
            'preview_texto' => $row['preview_texto']
        );
        $noticias[] = $noticia;
    }
}

// Total de notícias
$total_noticias_query = "SELECT COUNT(*) AS total FROM noticias_info";
$total_noticias_result = $mysqli->query($total_noticias_query);
$total_noticias = $total_noticias_result->fetch_assoc()['total'];
$total_paginas = ceil($total_noticias / $noticias_por_pagina);

$statement->close();
$mysqli->close();



?>

<!DOCTYPE html>
<html lang="pt">
<head>
    <?php include "header.php"; ?>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Notícias</title>
    <link rel="shortcut icon" type="image/png" href="media/logo.png/"/>
    <script src="https://use.fontawesome.com/releases/v6.3.0/js/all.js" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.3.1/jquery.min.js" crossorigin="anonymous"></script>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js"></script>
    <style>
        .news-image {
            width: 100%;
            height: 200px;
            object-fit: cover;
        }
        .pagination .page-link {
            background-color: green;
            border-color: green;
        }
        .pagination .page-link:hover {
            background-color: #28a745;
            border-color: #28a745;
        }
        .pagination .page-item.active .page-link {
            background-color: #28a745;
            border-color: #28a745;
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
<div class="container">
    <h2>Notícias</h2>
    <div class="row">
        <?php foreach ($noticias as $noticia) { ?>
            <div class="col-md-6 mb-4">
                <div class="card">
                    <div class="card-body">
                        <h5 class="card-title"><?php echo $noticia['titulo']; ?></h5>
                        <p class="card-text"><?php echo $noticia['preview_texto']; ?></p>
                        <p class="card-text"><small class="text-muted"><?php echo $noticia['data']; ?></small></p>
                        <a href="noticia.php?id=<?php echo $noticia['id']; ?>" class="btn btn-primary" style="background-color: green; border-color: green;">Ver Notícia</a>
                    </div>
                </div>
            </div>
        <?php } ?>
    </div>

    <!-- Paginação -->
    <nav aria-label="Page navigation">
        <ul class="pagination">
            <?php if ($pagina_atual > 1) { ?>
                <li class="page-item"><a class="page-link" href="?pagina=1" style="background-color: green; border-color: green; color: white;">Primeira</a></li>
                <li class="page-item"><a class="page-link" href="?pagina=<?php echo $pagina_atual - 1; ?>" style="background-color: green; border-color: green; color: white;">Anterior</a></li>
            <?php } ?>
            <?php for ($i = 1; $i <= $total_paginas; $i++) { ?>
                <li class="page-item <?php if ($i === $pagina_atual) echo 'active'; ?>"><a class="page-link" href="?pagina=<?php echo $i; ?>" style="background-color: green; color: white; border-color: green;"><?php echo $i; ?></a></li>
            <?php } ?>
            <?php if ($pagina_atual < $total_paginas) { ?>
                <li class="page-item"><a class="page-link" href="?pagina=<?php echo $pagina_atual + 1; ?>" style="background-color: green; color: white; border-color: green;">Próxima</a></li>
                <li class="page-item"><a class="page-link" href="?pagina=<?php echo $total_paginas; ?>" style="background-color: green; color: white; border-color: green;">Última</a></li>
            <?php } ?>
        </ul>
    </nav>
</div>

<?php include "footer.php"; ?>

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