<?php
session_start();
ini_set('display_errors', 0);
include "./generals/config.php";
$mysqli = new mysqli($bd_host, $bd_user, $bd_password, $bd_database);

if ($mysqli->connect_error) {
    die('Erro: (' . $mysqli->connect_errno . ') ' . $mysqli->connect_error);
}

if (empty($_SESSION["session_id"]) || $_SESSION["type"] < 3) {
    header("Location: ../index.php");
    exit;
}

// Verifique se o formulário foi enviado
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Obtenha os valores enviados pelo formulário
    $acao = $_POST["acao"];

    // Redireciona para a página correspondente
    if ($acao === 'adicionar') {
        header("Location: adicionar-socio.php");
        exit;
    } elseif ($acao === 'editar') {
        header("Location: editar-socio.php");
        exit;
    } elseif ($acao === 'eliminar') {
        header("Location: eliminar-socios.php");
        exit;
    }
}

// Função para inserir um sócio no banco de dados
function inserirSocio($conexao, $nome, $morada1, $morada2, $nif, $aluno)
{
    // Obter o próximo número de sócio
    $queryMaxNumSocio = "SELECT MAX(num_socio) AS max_num_socio FROM socios";
    $resultadoMaxNumSocio = $conexao->query($queryMaxNumSocio);

    if ($resultadoMaxNumSocio) {
        $rowMaxNumSocio = $resultadoMaxNumSocio->fetch_assoc();
        $max_num_socio = $rowMaxNumSocio['max_num_socio'];
        $prox_num_socio = $max_num_socio + 1;
    } else {
        echo "Erro ao obter o próximo número de sócio: " . $conexao->error;
        exit;
    }

    // Preparar a query de inserção usando uma instrução preparada
    $query = "INSERT INTO socios (nome, morada1, morada2, nif, aluno, num_socio, data_added) VALUES (?, ?, ?, ?, ?, ?, ?)";
    $stmt = $conexao->prepare($query);

    if ($stmt) {
        $currentDateTime = date('Y-m-d');
        // Bind dos parâmetros e execução da query
        $stmt->bind_param("sssisss", $nome, $morada1, $morada2, $nif, $aluno, $prox_num_socio, $currentDateTime);

        if ($stmt->execute()) {
            
            if ($aluno != 0) {
                // Atualizar o número do sócio na tabela 'alunos'
                $stmtUpdate = $conexao->prepare("UPDATE alunos SET num_socio = ? WHERE user = ?");
                $stmtUpdate->bind_param("is", $prox_num_socio, $aluno);
                $stmtUpdate->execute();
            }
        } else {
            echo "Erro ao inserir o sócio: " . $stmt->error;
        }

        // Fechar a declaração preparada
        $stmt->close();
    } else {
        echo "Erro na preparação da declaração: " . $conexao->error;
    }
}

$alunos = array(); // Inicialize a variável $alunos como um array vazio

// Código para recuperar alunos do banco de dados
$queryAlunos = "SELECT user, nome FROM users1 WHERE type = 1";

$resultadoAlunos = $mysqli->query($queryAlunos);

if ($resultadoAlunos) {
    // Loop para iterar pelos resultados e adicionar os alunos ao array $alunos
    while ($rowAluno = $resultadoAlunos->fetch_assoc()) {
        $alunos[] = $rowAluno;
    }
} else {
    echo "Erro na consulta de alunos: " . $mysqli->error;
}

?>


<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Inserir Sócio</title>
    <link rel="shortcut icon" type="image/png" href="media/logo.png" />
    <script src="https://use.fontawesome.com/releases/v6.3.0/js/all.js" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.3.1/jquery.min.js" crossorigin="anonymous"></script>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js"></script>
    <link href="https://netdna.bootstrapcdn.com/font-awesome/3.2.1/css/font-awesome.css" rel="stylesheet">
</head>

<body>

    <div style="margin-top: 0;">
        <img style="width: 100%; height: auto;" src="./media/topAR.png" class="img-responsive">
    </div>

    <?php
    include "header-direcao.php";
    ?>

    <div class="mb-3 container">
        <form action="" method="POST">
            <div class="mb-3">
                <label for="acao" class="form-label">Selecione uma ação:</label>
                <select name="acao" id="acao" class="form-select">
                    <option value="">Selecione</option>
                    <option value="adicionar">Adicionar Sócio</option>
                    <option value="editar">Editar Sócio</option>
                    <option value="eliminar">Eliminar Sócio</option>
                </select>
            </div>
            <button type="submit" class="btn btn-primary">Ir</button>
        </form>
    </div>


    <div class="container">
        <h2 class="mt-5 text-center">Formulário de Inserção de Sócio</h2>
        <form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="post">
            <div class="mb-3">
                <label for="nome" class="form-label">Nome:</label>
                <input type="text" id="nome" name="nome" class="form-control" required>
            </div>

            <div class="mb-3">
                <label for="morada1" class="form-label">Morada:</label>
                <input type="text" id="morada1" name="morada1" class="form-control" required>
            </div>

            <div class="mb-3">
                <label for="morada2" class="form-label">Morada (Continuação):</label>
                <input type="text" id="morada2" name="morada2" class="form-control" required>
            </div>

            <div class="mb-3">
                <label for="nif" class="form-label">NIF:</label>
                <input type="number" id="nif" name="nif" class="form-control" required min="0">
            </div>

            <div class="mb-3">
                <label for="aluno" class="form-label">Aluno Correspondente:</label>
                <select id="aluno" name="aluno" class="form-select" required>
                    <option value="0">Não Aplicável</option>
                    <?php foreach ($alunos as $aluno): ?>
                        <option value="<?php echo $aluno['user']; ?>" data-user="<?php echo $aluno['user']; ?>">
                            <?php echo $aluno['user'] . ' - ' . $aluno['nome']; ?>
                        </option>
                    <?php endforeach; ?>
                </select>
            </div>

            <button style="background-color: #00631b; border-color: black;" type="submit" class="btn btn-primary">Inserir Sócio</button>
        </form>

        <?php if ($_SERVER['REQUEST_METHOD'] === 'POST') : ?>
            <div class="alert alert-success mt-4">
                <?php
                // Recupere os valores do formulário
                $nome = $_POST['nome'];
                $morada1 = $_POST['morada1'];
                $morada2 = $_POST['morada2'];
                $nif = $_POST['nif'];
                $aluno = $_POST['aluno'];

                // Chame a função para inserir o sócio no banco de dados
                inserirSocio($mysqli, $nome, $morada1, $morada2, $nif, $aluno);
                print("Dados registados com sucesso.");
                ?>
            </div>
        <?php endif; ?>
    </div>
</body>

</html>

<?php
include "footer-reservado.php";
$mysqli->close();
?>