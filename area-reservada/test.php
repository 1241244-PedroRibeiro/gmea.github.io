<?php
// Incluir arquivo de configuração
session_start();
include "./generals/config.php";
$mysqli = new mysqli($bd_host, $bd_user, $bd_password, $bd_database);

if ($mysqli->connect_error) {
    die('Erro: (' . $mysqli->connect_errno . ') ' . $mysqli->connect_error);
}

if (empty($_SESSION["session_id"]) || $_SESSION["type"] != 3) {
    header("Location: ../index.php");
    exit;
}

// Verificar se o formulário foi submetido para adicionar ou eliminar serviço
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if ($_POST["action"] == "add") {
        // Adicionar um novo serviço
        $date = $_POST["date"];
        $location = $_POST["location"];

        // Preparar a instrução SQL
        $sql = "INSERT INTO servicos (data_servico, local_servico, estado) VALUES (?, ?, 1)";

        if ($stmt = $mysqli->prepare($sql)) {
            // Vincular variáveis aos parâmetros da instrução preparada
            $stmt->bind_param("ss", $date, $location);

            // Executar a instrução preparada
            if ($stmt->execute()) {
                // Redirecionar para a página de serviços
                header("Location: services.php");
                exit();
            } else {
                echo "Erro ao executar a instrução: " . $stmt->error;
            }

            // Fechar a instrução preparada
            $stmt->close();
        } else {
            echo "Erro ao preparar a instrução: " . $mysqli->error;
        }
    } elseif ($_POST["action"] == "delete") {
        // Eliminar um serviço
        $serviceId = $_POST["service"];

        // Preparar a instrução SQL
        $sql = "UPDATE servicos SET estado = 0 WHERE id_servico = ?";

        if ($stmt = $mysqli->prepare($sql)) {
            // Vincular variáveis aos parâmetros da instrução preparada
            $stmt->bind_param("i", $serviceId);

            // Executar a instrução preparada
            if ($stmt->execute()) {
                // Redirecionar para a página de serviços
                header("Location: services.php");
                exit();
            } else {
                echo "Erro ao executar a instrução: " . $stmt->error;
            }

            // Fechar a instrução preparada
            $stmt->close();
        } else {
            echo "Erro ao preparar a instrução: " . $mysqli->error;
        }
    }
}

// Consultar os serviços ativos
$sql = "SELECT * FROM servicos WHERE estado = 1";
$result = $mysqli->query($sql);

// Fechar a conexão com o banco de dados
$mysqli->close();
?>

<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>GMEA - Gerir Alunos</title>
    <link rel="shortcut icon" type="image/png" href="media/logo.png" />
    <script src="https://use.fontawesome.com/releases/v6.3.0/js/all.js" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.3.1/jquery.min.js" crossorigin="anonymous"></script>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js"></script>
    <link href="https://netdna.bootstrapcdn.com/font-awesome/3.2.1/css/font-awesome.css" rel="stylesheet">
</head>
<body class="sb-nav-fixed">
    <nav class="sb-topnav navbar navbar-expand navbar-dark bg-dark">
        <a class="navbar-brand" href="index.php">GMEA</a>
        <button class="btn btn-link btn-sm order-1 order-lg-0 me-4 me-lg-0" id="sidebarToggle" href="#!"><i class="fas fa-bars"></i></button>
        <ul class="navbar-nav ms-auto ms-md-0 me-3 me-lg-4">
            <li class="nav-item dropdown">
                <a class="nav-link dropdown-toggle" id="navbarDropdown" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false"><i class="fas fa-user fa-fw"></i></a>
                <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="navbarDropdown">
                    <li><a class="dropdown-item" href="profile.php">Perfil</a></li>
                    <li><hr class="dropdown-divider"></li>
                    <li><a class="dropdown-item" href="../logout.php">Sair</a></li>
                </ul>
            </li>
        </ul>
    </nav>
    <div id="layoutSidenav">
        <div id="layoutSidenav_nav">
            <nav class="sb-sidenav accordion sb-sidenav-dark" id="sidenavAccordion">
                <div class="sb-sidenav-menu">
                    <div class="nav">
                        <div class="sb-sidenav-menu-heading">Menu Principal</div>
                        <a class="nav-link" href="index.php">
                            <div class="sb-nav-link-icon"><i class="fas fa-tachometer-alt"></i></div>
                            Dashboard
                        </a>
                        <a class="nav-link" href="services.php">
                            <div class="sb-nav-link-icon"><i class="fas fa-cogs"></i></div>
                            Gerir Serviços
                        </a>
                    </div>
                </div>
                <div class="sb-sidenav-footer">
                    <div class="small">Logged in as:</div>
                    <?php echo $_SESSION["username"]; ?>
                </div>
            </nav>
        </div>
        <div id="layoutSidenav_content">
            <main>
                <div class="container-fluid px-4">
                    <h1 class="mt-4">Gerir Serviços</h1>
                    <ol class="breadcrumb mb-4">
                        <li class="breadcrumb-item"><a href="index.php">Dashboard</a></li>
                        <li class="breadcrumb-item active">Gerir Serviços</li>
                    </ol>
                    <div class="card mb-4">
                        <div class="card-header">
                            <i class="fas fa-cogs me-1"></i>
                            Adicionar Serviço
                        </div>
                        <div class="card-body">
                            <form method="POST" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
                                <div class="row">
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label for="date">Data do Serviço</label>
                                            <input type="date" class="form-control" id="date" name="date" required>
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label for="location">Local do Serviço</label>
                                            <input type="text" class="form-control" id="location" name="location" required>
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label>&nbsp;</label>
                                            <button type="submit" class="btn btn-primary" name="action" value="add">Adicionar</button>
                                        </div>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                    <div class="card mb-4">
                        <div class="card-header">
                            <i class="fas fa-cogs me-1"></i>
                            Lista de Serviços
                        </div>
                        <div class="card-body">
                            <div class="table-responsive">
                                <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                                    <thead>
                                        <tr>
                                            <th>Data do Serviço</th>
                                            <th>Local do Serviço</th>
                                            <th>Ações</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php
                                        while ($row = $result->fetch_assoc()) {
                                            echo "<tr>";
                                            echo "<td>" . $row['data_servico'] . "</td>";
                                            echo "<td>" . $row['local_servico'] . "</td>";
                                            echo "<td>";
                                            echo "<a href='edit.php?id=" . $row['id_servico'] . "' class='btn btn-primary btn-sm'>Editar</a> ";
                                            echo "<form method='POST' class='d-inline' onSubmit='return confirm(\"Tem certeza que deseja excluir este serviço?\")' action='" . htmlspecialchars($_SERVER["PHP_SELF"]) . "'>";
                                            echo "<input type='hidden' name='service' value='" . $row['id_servico'] . "'>";
                                            echo "<button type='submit' class='btn btn-danger btn-sm' name='action' value='delete'>Excluir</button>";
                                            echo "</form>";
                                            echo "</td>";
                                            echo "</tr>";
                                        }
                                        ?>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </main>
            <footer class="py-4 bg-light mt-auto">
                <div class="container-fluid px-4">
                    <div class="d-flex align-items-center justify-content-between small">
                        <div class="text-muted">GMEA - Gerir Alunos &copy; <?php echo date("Y"); ?></div>
                    </div>
                </div>
            </footer>
        </div>
    </div>
</body>
</html>
