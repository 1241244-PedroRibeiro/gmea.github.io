<?php
// Inclua o arquivo de configuração do banco de dados
session_start();
include "./generals/config.php";
ini_set('display_errors', 0);

// Conexão com o banco de dados
$mysqli = new mysqli($bd_host, $bd_user, $bd_password, $bd_database);

if ($mysqli->connect_error) {
    die('Erro de Conexão: (' . $mysqli->connect_errno . ') ' . $mysqli->connect_error);
}

// Consulta para obter os serviços ativos
$query = "SELECT * FROM servicos WHERE estado = 1";
$result = $mysqli->query($query);

$events = array();

// Processar os resultados da consulta
while ($row = $result->fetch_assoc()) {
    $tipo_servico = $row['tipo_servico'];
    $data_servico = $row['data_servico'];
    $hora_inicio = $row['hora_servico'];
    $hora_fim = $row['hora_fim'];
    $local_servico = $row['local_servico'];

    // Formatar o título do evento (local do serviço)
    $title = $local_servico;

    // Mapear o tipo de serviço para uma descrição legível
    switch ($tipo_servico) {
        case 1:
            $tipo_evento = 'Concerto';
            break;
        case 2:
            $tipo_evento = 'Procissão';
            break;
        case 3:
            $tipo_evento = 'Missa';
            break;
        case 4:
            $tipo_evento = 'Casamento';
            break;
        case 5:
            $tipo_evento = 'Missa + Procissão';
            break;
        case 6:
            $tipo_evento = 'Missa + Concerto';
            break;
        case 7:
            $tipo_evento = 'Missa + Procissão + Concerto';
            break;
        case 8:
            $tipo_evento = 'Outro';
            break;
        default:
            $tipo_evento = 'Desconhecido';
    }

    // Formatar a data e hora para o formato esperado pelo FullCalendar (ISO 8601)
    $start = $data_servico . 'T' . $hora_inicio;
    $end = $data_servico . 'T' . $hora_fim;

    // Construir o evento no formato esperado pelo FullCalendar
    $events[] = array(
        'id' => $row['id_servico'],
        'title' => $title,
        'start' => $start,
        'end' => $end,
        'tipo_evento' => $tipo_evento
    );
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

?>

<!DOCTYPE html>
<html lang="pt">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>GMEA</title>
    <link rel="shortcut icon" type="image/png" href="media/logo.png/"/>
    <script src="https://use.fontawesome.com/releases/v6.3.0/js/all.js" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.3.1/jquery.min.js" crossorigin="anonymous"></script>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js"></script>
    <link href='generals/vendor/fullcalendar/packages/core/main.css' rel='stylesheet' />
    <link href='generals/vendor/fullcalendar/packages/daygrid/main.css' rel='stylesheet' />

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

<div class="container mt-4">
    <h2>Consulta de Serviços</h2>
    <div id='calendar' class="mt-4"></div>
</div>

<!-- Modal para exibir detalhes do serviço -->
<div class="modal fade" id="serviceModal" tabindex="-1" role="dialog" aria-labelledby="serviceModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="serviceModalLabel">Detalhes do Serviço</h5>
            </div>
            <div class="modal-body">
                <p><strong>Tipo de Serviço:</strong> <span id="serviceType"></span></p>
                <p><strong>Local do Serviço:</strong> <span id="serviceLocation"></span></p>
                <p><strong>Data:</strong> <span id="serviceDate"></span></p>
                <p><strong>Horário:</strong> <span id="serviceTime"></span></p>
            </div>
            <div class="modal-footer">
                <button id="closeModalBtn" type="button" class="btn btn-secondary">Fechar</button>
            </div>
        </div>
    </div>
</div>

<script src='generals/vendor/fullcalendar/packages/core/main.js'></script>
<script src='generals/vendor/fullcalendar/packages/daygrid/main.js'></script>
<!-- jQuery e Bootstrap JS -->
<script src='https://cdnjs.cloudflare.com/ajax/libs/fullcalendar/5.9.0/locales/pt-br.js'></script>

<script>
document.addEventListener('DOMContentLoaded', function() {
    var calendarEl = document.getElementById('calendar');

    var calendar = new FullCalendar.Calendar(calendarEl, {
        plugins: ['dayGrid'],
        header: {
            left: 'prev,next today',
            center: 'title',
            right: 'dayGridMonth'
        },
        buttonText: {
            today: 'Hoje',
            month: 'Mês'
        },
        locale: 'pt-br',
        editable: false,
        events: <?php echo json_encode($events); ?>,
        eventClick: function(info) {
            var evento = info.event;
            var serviceType = evento.extendedProps.tipo_evento;
            var serviceLocation = evento.title;
            var serviceDate = new Date(evento.start).toLocaleDateString();
            var serviceTime = new Date(evento.start).toLocaleTimeString();

            // Preencher o modal com as informações do serviço
            document.getElementById('serviceType').textContent = serviceType;
            document.getElementById('serviceLocation').textContent = serviceLocation;
            document.getElementById('serviceDate').textContent = serviceDate;
            document.getElementById('serviceTime').textContent = serviceTime;

            // Exibir o modal
            $('#serviceModal').modal('show');
        }
    });

    calendar.render();

    document.getElementById('closeModalBtn').addEventListener('click', function() {
        $('#serviceModal').modal('hide');
    });

});
</script>

</body>
</html>

<?php
    include "footer.php";
?>
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