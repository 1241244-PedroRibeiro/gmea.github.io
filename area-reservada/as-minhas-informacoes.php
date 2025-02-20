<?php
session_start();
require_once("generals/config.php");

$mysqli = new mysqli($bd_host, $bd_user, $bd_password, $bd_database);

if ($mysqli->connect_error) {
    die('Erro: (' . $mysqli->connect_errno . ') ' . $mysqli->connect_error);
}

if (empty($_SESSION["session_id"])) {
    header("Location: ../index.php");
    exit;
}

// Obtém o nome de utilizador
$username = $_SESSION["username"];

// Consulta para obter as informações do utilizador
$query = "SELECT * FROM users1 WHERE user = '$username'";
$result = $mysqli->query($query);

if ($result->num_rows > 0) {
    $userInfo = $result->fetch_assoc();
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>GMEA - As minhas informações</title>
    <link rel="shortcut icon" type="image/png" href="media/logo.png" />
    <script src="https://use.fontawesome.com/releases/v6.3.0/js/all.js" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.3.1/jquery.min.js" crossorigin="anonymous"></script>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js"></script>
</head>

<body>
    <div style="margin-top: 0;">
        <img style="width: 100%; height: auto;" src="./media/topAR.png" class="img-responsive">
    </div>

    <?php
    if ($_SESSION["type"] == 1) {
        include "header-alunos.php";
    }
    if ($_SESSION["type"] == 2) {
        include "header-profs.php";
    }
    if ($_SESSION["type"] == 3) {
        include "header-direcao.php";
    }
    if ($_SESSION["type"] == 4) {
        include "header-professor-direcao.php";
    }
    ?>

    <div class="container mt-4">
        <h2 class="mb-4">As minhas informações</h2>

        <form id="editForm" enctype="multipart/form-data">
            <table class="table table-bordered">
                <tr>
                    <th>Campos</th>
                    <th>Informações</th>
                    <th>Ação</th>
                </tr>
                <tr>
                    <td>Utilizador</td>
                    <td><?php echo $userInfo['user']; ?></td>
                    <td></td>
                </tr>
                <tr>
                    <td>Nome</td>
                    <td><?php echo $userInfo['nome']; ?></td>
                    <td></td>
                </tr>
                <tr>
                    <td>Data de Nascimento</td>
                    <td><?php echo $userInfo['data_nas']; ?></td>
                    <td></td>
                </tr>
                <tr>
                    <td>Morada</td>
                    <td><?php echo $userInfo['morada1'] . '<br>' . $userInfo['morada2']; ?></td>
                    <td></td>
                </tr>
                <tr>
                    <td>Número do Cartão de Cidadão</td>
                    <td><?php echo $userInfo['cc']; ?></td>
                    <td></td>
                </tr>
                <tr>
                    <td>Número de Contribuinte</td>
                    <td><?php echo $userInfo['nif']; ?></td>
                    <td></td>
                </tr>
                <tr>
                    <td>Número de Telemóvel/Telefone</td>
                    <td><?php echo $userInfo['telef']; ?></td>
                    <td></td>
                </tr>
                <tr>
                    <td>Email</td>
                    <td id="email"><?php echo $userInfo['email']; ?></td>
                    <td><button type="button" class="btn btn-primary" onclick="enableEdit('email')">Editar</button></td>
                </tr>
                <tr>
                    <td>Foto</td>
                    <td id="photo">
                        <img src="<?php echo $userInfo['foto']; ?>" alt="Foto de Perfil" style="max-width: 150px;">
                        <input type="file" id="photoInput" name="photo" style="display: none;">
                    </td>
                    <td><button type="button" class="btn btn-primary" onclick="enableEdit('photo')">Editar</button></td>
                </tr>
            </table>

            <button type="submit" class="btn btn-success" id="saveChanges" style="display: none;">Guardar Alterações</button>
        </form>
    </div>

    <!-- Adicione este bloco para os modals -->
    <div class="modal fade" id="successModal" tabindex="-1" aria-labelledby="successModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="successModalLabel">Sucesso!</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    As alterações foram salvas com sucesso!
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Fechar</button>
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade" id="errorModal" tabindex="-1" aria-labelledby="errorModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="errorModalLabel">Erro!</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    Houve um erro ao salvar as alterações. Por favor, tente novamente.
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Fechar</button>
                </div>
            </div>
        </div>
    </div>

    <?php
    // Incluir o rodapé comum
    include "footer-reservado.php";
    ?>

<script>
    // Altere as chamadas dos modals nas funções JavaScript
    function enableEdit(fieldName) {
        // Transforma a linha de informação em campo de texto ou upload
        var value = $('#' + fieldName).text().trim();

        if (fieldName === 'email') {
            $('#' + fieldName).html('<input type="text" id="' + fieldName + 'Input" name="' + fieldName + '" value="' + value + '">');
        } else if (fieldName === 'photo') {
            $('#' + fieldName).html('<input type="file" id="' + fieldName + 'Input" name="' + fieldName + '">');
        }

        $('#saveChanges').show();
    }

    function disableEdit(fieldName, originalValue) {
        // Desabilita a edição e restaura o valor original
        $('#' + fieldName).html(originalValue);
        $('#new' + fieldName.charAt(0).toUpperCase() + fieldName.slice(1)).hide();
        $('#saveChanges').hide();
    }

    $(window).on('beforeunload', function () {
        if ($('#saveChanges').is(':visible')) {
            return 'Tem alterações não salvas. Deseja mesmo sair?';
        }
    });

    // Intercepta o envio do formulário
    $('#editForm').submit(function (e) {
        e.preventDefault();

        // Processar as alterações aqui
        // Você pode enviar os dados via AJAX para o servidor e salvá-los no banco de dados

        // Exemplo de envio de dados usando AJAX
        var formData = new FormData(this);
        $.ajax({
            type: 'POST',
            url: 'processar_alteracoes.php', // Substitua pelo caminho do seu script de processamento
            data: formData,
            contentType: false,
            processData: false,
            success: function (response) {
                $('#successModal').modal('show');

                // Atualiza o valor do email na label
                $('#email').html($('#emailInput').val());

                // Verifica se houve alteração na foto antes de atualizar a visualização
                if ($('#photoInput')[0].files.length > 0) {
                    // Se houve alteração, atualiza a visualização da foto
                    var reader = new FileReader();
                    reader.onload = function (e) {
                        $('#photo').html('<img src="' + e.target.result + '" alt="Nova Foto de Perfil" style="max-width: 150px;">');
                    };
                    reader.readAsDataURL($('#photoInput')[0].files[0]);
                }

                $('#saveChanges').hide();
            },
            error: function () {
                $('#errorModal').modal('show');
            }
        });
    });
</script>

</body>

</html>
