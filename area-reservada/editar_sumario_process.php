    <!-- Banner -->
    <div style="margin-top: 0;">
        <img style="width: 100%; height: auto;" src="./media/topAR.png" class="img-responsive">
    </div>

<?php
session_start();
include "./generals/config.php";
$mysqli = new mysqli($bd_host, $bd_user, $bd_password, $bd_database);

if ($mysqli->connect_error) {
    die('Erro: (' . $mysqli->connect_errno . ') ' . $mysqli->connect_error);
}

if ($_SESSION["type"] == 2) {
    include "header-profs.php";
}
if ($_SESSION["type"] == 3) {
    include "header-direcao.php";
}

$user = $_SESSION['username'];

// Consultar todas as aulas ordenadas pelo ID
$queryAulas = "SELECT id_aula FROM aulas ORDER BY id_aula";
$resultAulas = $mysqli->query($queryAulas);

// Processar o formulário de seleção de aula e lição
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $idAula = $_POST['id_aula'];
    $indiceAula = $_POST['indice_aula'];

    // Consultar o sumário existente para edição
    $querySumario = "SELECT sumario_texto FROM sumarios WHERE id_aula = $idAula AND indice_aula = $indiceAula";
    $resultSumario = $mysqli->query($querySumario);

    if ($resultSumario && $resultSumario->num_rows > 0) {
        $rowSumario = $resultSumario->fetch_assoc();
        $sumarioTexto = $rowSumario['sumario_texto'];

        // Exibir formulário de edição com o editor Quill
        echo "<!DOCTYPE html>";
        echo "<html lang='en'>";
        echo "<head>";
        echo "<meta charset='UTF-8'>";
        echo "<meta name='viewport' content='width=device-width, initial-scale=1.0'>";
        echo "<title>Editar Sumário</title>";
        echo "<link href='https://cdn.quilljs.com/1.3.6/quill.snow.css' rel='stylesheet'>";
        echo "<link rel='stylesheet' href='https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css'>";
        echo "</head>";
        echo "<body>";
        echo "<div class='container mt-5'>";
        echo "<h2>Edição de Sumário</h2>";
        echo "<form method='post' action='atualizar_sumario.php'>";
        echo "<div class='mb-3'>";
        echo "<label for='editor'>Texto do Sumário:</label>";
        echo "<div id='editor' style='height: 200px;'>$sumarioTexto</div>";
        echo "<input type='hidden' name='id_aula' value='$idAula'>";
        echo "<input type='hidden' name='indice_aula' value='$indiceAula'>";

        // Campo hidden para armazenar o texto do sumário
        echo "<input type='hidden' name='texto_sumario' id='texto_sumario'>";

        // Botões dentro da mesma div do formulário
        echo '<div class="mt-3">';
        echo '<a href="alterar_faltas.php?idAula=' . urlencode($idAula) . '&indiceAula=' . urlencode($indiceAula) . '" class="btn btn-danger me-2">Marcar Faltas</a>';
        echo "<button type='submit' class='btn btn-primary'>Atualizar Sumário</button>";
        echo '</div>';

        echo "</div>";
        echo "</form>";
        echo "</div>";
        echo "<script src='https://cdn.quilljs.com/1.3.6/quill.js'></script>";
        echo "<script>";
        echo "var quill = new Quill('#editor', {";
        echo "theme: 'snow'";
        echo "});";

        // Capturar o conteúdo do Quill Editor e atribuir ao campo hidden antes do envio do formulário
        echo "var form = document.querySelector('form');";
        echo "form.onsubmit = function() {";
        echo "  var textoSumarioInput = document.getElementById('texto_sumario');";
        echo "  textoSumarioInput.value = quill.root.innerHTML;";
        echo "};";

        echo "</script>";
        echo "</body>";
        echo "</html>";
    } else {
        echo "Sumário não encontrado para esta lição.";
    }
}
?>

<!DOCTYPE html>
<html lang="pt">
<head>
    <meta charset="UTF-8">
    <title>Gestão de Agenda</title>
    <script src="https://use.fontawesome.com/releases/v6.3.0/js/all.js" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.3.1/jquery.min.js" crossorigin="anonymous"></script>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js"></script>
    <link href="https://netdna.bootstrapcdn.com/font-awesome/3.2.1/css/font-awesome.css" rel="stylesheet">
    <style>
        /* Estilos do calendário */
        body {
            font-family: Arial, Helvetica Neue, Helvetica, sans-serif;
            font-size: 14px;
        }

        /* Estilos para os cards */
        .custom-card {
            width: calc(33.33% - 20px); /* Ajusta a largura dos cards em telas maiores */
            margin-bottom: 20px; /* Espaço abaixo dos cards */
            padding: 15px;
            box-shadow: 0 4px 8px rgba(0,0,0,0.1);
            background-color: #fff;
        }

        @media (max-width: 992px) {
            .custom-card {
                width: calc(50% - 20px); /* Ajusta a largura dos cards em telas médias */
            }
        }

        @media (max-width: 576px) {
            .custom-card {
                width: 100%; /* Cards ocupam 100% da largura em telas menores */
            }
        }


        .card-img-top {
            max-width: 100%;
            height: auto;
        }
    </style>
</head>
<body>

</body>
</html>


<?php include 'footer-reservado.php' ?>