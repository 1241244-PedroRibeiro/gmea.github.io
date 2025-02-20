<?php
session_start();
include "./generals/config.php";
$mysqli = new mysqli($bd_host, $bd_user, $bd_password, $bd_database);

if ($mysqli->connect_error) {
    die('Erro: (' . $mysqli->connect_errno . ') ' . $mysqli->connect_error);
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['tipo_avaliacao'])) {
        $tipoAvaliacao = $_POST['tipo_avaliacao'];

        // Verificar qual tipo de avaliação foi selecionado
        if ($tipoAvaliacao == 1 || $tipoAvaliacao == 2) {
            // Avaliação Intercalar - Primeiro ou Segundo Semestre
            $semestre = ($tipoAvaliacao == 1) ? 1 : 2;
            $table = 'pautas_avaliacao_intercalar';

            // Atualizar o campo 'estado' para 1 nos registros correspondentes
            $updateQuery = "UPDATE $table SET estado = 1 WHERE semestre = $semestre";

            // Executar a atualização somente se confirmada pelo modal
            if (isset($_POST['confirmacao']) && $_POST['confirmacao'] == 'confirmar') {
                if ($mysqli->query($updateQuery)) {
                    // Atualização bem-sucedida
                    echo '
                    <div class="modal fade" id="modalSucesso" tabindex="-1" role="dialog" aria-labelledby="modalSucessoLabel" aria-hidden="true">
                        <div class="modal-dialog" role="document">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title" id="modalSucessoLabel">Sucesso!</h5>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                </div>
                                <div class="modal-body">
                                    A pauta foi lançada com sucesso.
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Fechar</button>
                                </div>
                            </div>
                        </div>
                    </div>
                    <script>
                        $(document).ready(function(){
                            $("#modalSucesso").modal("show");
                        });
                    </script>';
                } else {
                    // Erro na atualização
                    echo '
                    <div class="modal fade" id="modalErro" tabindex="-1" role="dialog" aria-labelledby="modalErroLabel" aria-hidden="true">
                        <div class="modal-dialog" role="document">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title" id="modalErroLabel">Erro!</h5>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                </div>
                                <div class="modal-body">
                                    Houve um erro ao excluir a avaliação. Por favor, tente novamente.
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Fechar</button>
                                </div>
                            </div>
                        </div>
                    </div>
                    <script>
                        $(document).ready(function(){
                            $("#modalErro").modal("show");
                        });
                    </script>';
                }
            }
        } elseif ($tipoAvaliacao == 3 || $tipoAvaliacao == 4) {
            // Avaliação - Primeiro ou Segundo Semestre
            $semestre = ($tipoAvaliacao == 3) ? 3 : 4;
            $table = 'pautas_avaliacao';

            // Atualizar o campo 'estado' para 1 nos registros correspondentes
            $updateQuery = "UPDATE $table SET estado = 1 WHERE semestre = $semestre";

            // Executar a atualização somente se confirmada pelo modal
            if (isset($_POST['confirmacao']) && $_POST['confirmacao'] == 'confirmar') {
                if ($mysqli->query($updateQuery)) {
                    // Atualização bem-sucedida
                    echo '
                    <div class="modal fade" id="modalSucesso" tabindex="-1" role="dialog" aria-labelledby="modalSucessoLabel" aria-hidden="true">
                        <div class="modal-dialog" role="document">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title" id="modalSucessoLabel">Sucesso!</h5>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                </div>
                                <div class="modal-body">
                                    A pauta foi lançada com sucesso.
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Fechar</button>
                                </div>
                            </div>
                        </div>
                    </div>
                    <script>
                        $(document).ready(function(){
                            $("#modalSucesso").modal("show");
                        });
                    </script>';
                } else {
                    // Erro na atualização
                    echo '
                    <div class="modal fade" id="modalErro" tabindex="-1" role="dialog" aria-labelledby="modalErroLabel" aria-hidden="true">
                        <div class="modal-dialog" role="document">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title" id="modalErroLabel">Erro!</h5>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                </div>
                                <div class="modal-body">
                                    Houve um erro ao excluir a avaliação. Por favor, tente novamente.
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Fechar</button>
                                </div>
                            </div>
                        </div>
                    </div>
                    <script>
                        $(document).ready(function(){
                            $("#modalErro").modal("show");
                        });
                    </script>';
                }
            }

            // Redirecionar para a página ./generals/pautas_ava.php com o semestre selecionado
            header("Location: ./generals/pautas_ava.php?semestre=$semestre");
            exit();
        }
    }
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
        if ($_SESSION["type"] == 3) {
            include "header-direcao.php";
        }
        if ($_SESSION["type"] == 4) { // Mostrar cabeçalho para professores
            include "header-professor-direcao.php";
        }
    ?>

    <div class="container mt-4">
        <h2>Lançamento de Pautas</h2>
        <form id="lancamentoForm" action="<?php echo $_SERVER['PHP_SELF']; ?>" method="post">
            <div class="form-group">
                <label for="tipoAvaliacao">Selecionar Tipo de Avaliação:</label>
                <select id="tipoAvaliacao" name="tipo_avaliacao" class="form-control" required>
                    <option value="">Selecionar Tipo de Avaliação</option>
                    <option value="1">Avaliação Intercalar - Primeiro Semestre</option>
                    <option value="2">Avaliação Intercalar - Segundo Semestre</option>
                    <option value="3">Avaliação - Primeiro Semestre</option>
                    <option value="4">Avaliação - Segundo Semestre</option>
                </select>
            </div>
            <br>
            <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#confirmModal">
                Confirmar Lançamento
            </button>
        </form>
    </div>

    <!-- Modal de Confirmação -->
    <div class="modal fade" id="confirmModal" tabindex="-1" role="dialog" aria-labelledby="confirmModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="confirmModalLabel">Confirmação de Lançamento</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Fechar"></button>
                </div>
                <div class="modal-body">
                    Tem certeza que deseja lançar esta avaliação?
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                    <button type="submit" form="lancamentoForm" name="confirmacao" value="confirmar" class="btn btn-primary">Confirmar</button>
                </div>
            </div>
        </div>
    </div>

</body>
</html>

<?php include 'footer-reservado.php'; ?>
