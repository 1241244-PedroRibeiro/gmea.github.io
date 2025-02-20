<?php
session_start();
include "./generals/config.php";
$mysqli = new mysqli($bd_host, $bd_user, $bd_password, $bd_database);

// Load Composer's autoloader
require 'generals/vendor/autoload.php';
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;
require 'generals/vendor/phpmailer/phpmailer/src/Exception.php';
require 'generals/vendor/phpmailer/phpmailer/src/PHPMailer.php';
require 'generals/vendor/phpmailer/phpmailer/src/SMTP.php';

$mail = new PHPMailer();
$mail->IsSMTP();
$mail->Mailer = "smtp";

if ($mysqli->connect_error) {
    die('Erro: (' . $mysqli->connect_errno . ') ' . $mysqli->connect_error);
}

if (empty($_SESSION["session_id"]) || $_SESSION["type"] < 2) {
    header("Location: ../index.php");
    exit;
}

$user = $_SESSION["username"];
$type = $_SESSION["type"];

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["criar-aviso"])) {
    $titulo = $_POST["aviso-titulo"];
    $conteudo = $_POST["aviso-conteudo"];
    $destinatarios = $_POST["destinatarios"];
    $dataInicio = $_POST["data-inicio"];
    $dataFim = $_POST["data-fim"];
    $tipoAviso = ($_POST["tipo-aviso"] == "normal") ? 1 : 2; // 1 para Normal, 2 para Urgente
    $criador = $_SESSION["username"];

    // Inserir os dados na tabela "avisos"
    $stmt = $mysqli->prepare("INSERT INTO avisos (criador, titulo, texto, destino, data_inicio, data_fim, tipo_aviso) VALUES (?, ?, ?, ?, ?, ?, ?)");
    $stmt->bind_param("ssssssi", $criador, $titulo, $conteudo, $destinatarios, $dataInicio, $dataFim, $tipoAviso);

    if ($stmt->execute()) {
        // Obtém os e-mails correspondentes e envia o e-mail
        $emails = [];
        $users = [];
        $nomes = [];
        switch ($destinatarios) {
            case 'todos':
                $query = "SELECT user, nome, email FROM users1";
                $result = $mysqli->query($query);
                $emails = [];
                while ($row = $result->fetch_assoc()) {
                    $users[] = $row['user'];
                    $nomes[] = $row['nome'];
                    $emails[] = $row['email'];
                }
                break;
            case 'direcao':
                $query = "SELECT user, nome, email FROM users1 WHERE type = 3";
                $result = $mysqli->query($query);
                $emails = [];
                while ($row = $result->fetch_assoc()) {
                    $users[] = $row['user'];
                    $nomes[] = $row['nome'];
                    $emails[] = $row['email'];
                }
                break;
            case 'professores':
                $query = "SELECT user, nome, email FROM users1 WHERE type = 2";
                $result = $mysqli->query($query);
                $emails = [];
                while ($row = $result->fetch_assoc()) {
                    $users[] = $row['user'];
                    $nomes[] = $row['nome'];
                    $emails[] = $row['email'];
                }
                break;
            case 'alunos':
                $query = "SELECT user, nome, email FROM users1 WHERE type = 1";
                        // Executar a consulta e obter os e-mails
                $result = $mysqli->query($query);
                $emails = [];
                while ($row = $result->fetch_assoc()) {
                    $users[] = $row['user'];
                    $nomes[] = $row['nome'];
                    $emails[] = $row['email'];
                }
                break;
            case (strpos($destinatarios, 'turmas_gerais') !== false):
                $cod_turma_geral = substr($destinatarios, strrpos($destinatarios, '_') + 1);
                $query = "SELECT u1.user, u1.nome, u1.email FROM users1 u1 
                          JOIN alunos a ON u1.user = a.user 
                          WHERE a.turma = '$cod_turma_geral'";
                        // Executar a consulta e obter os e-mails
                $result = $mysqli->query($query);
                $emails = [];
                while ($row = $result->fetch_assoc()) {
                    $users[] = $row['user'];
                    $nomes[] = $row['nome'];
                    $emails[] = $row['email'];
                }
                break;
            case (strpos($destinatarios, 'turmas') !== false):
                $cod_turma = substr($destinatarios, strrpos($destinatarios, '_') + 1);
                $query = "SELECT u1.user, u1.nome, u1.email FROM users1 u1 
                          JOIN turmas_alunos ta ON u1.user = ta.user 
                          WHERE ta.cod_turma = '$cod_turma'";
                        // Executar a consulta e obter os e-mails
                $result = $mysqli->query($query);
                $emails = [];
                while ($row = $result->fetch_assoc()) {
                    $users[] = $row['user'];
                    $nomes[] = $row['nome'];
                    $emails[] = $row['email'];
                }
                break;
            case (strpos($destinatarios, 'alunos_professor') !== false):
                $selectedProfessorUser = substr($destinatarios, strrpos($destinatarios, '_') + 1);
            
                // Obter os alunos do professor na tabela aulas
                $queryAulas = "SELECT user, prof_in1, prof_in2 FROM alunos WHERE prof_in1 = '$selectedProfessorUser' OR prof_in2 = '$selectedProfessorUser'";
                $resultAulas = $mysqli->query($queryAulas);
            
                // Coletar os users dos alunos
                $alunosUsers = [];
                while ($rowAulas = $resultAulas->fetch_assoc()) {
                    $alunosUsers[] = $rowAulas['user'];
                }
            
                // Obter os emails dos alunos na tabela users1
                $queryAlunosEmails = "SELECT user, nome, email FROM users1 WHERE user IN ('" . implode("','", $alunosUsers) . "')";
                $resultAlunosEmails = $mysqli->query($queryAlunosEmails);
            
                // Coletar os users, nomes e emails dos alunos
                $alunosUsers = [];
                $alunosNomes = [];
                $alunosEmails = [];
                while ($rowAlunos = $resultAlunosEmails->fetch_assoc()) {
                    $alunosUsers[] = $rowAlunos['user'];
                    $alunosNomes[] = $rowAlunos['nome'];
                    $alunosEmails[] = $rowAlunos['email'];
                }
            
                // Adicionar os emails, users e nomes dos alunos ao array de emails
                $emails = array_merge($emails, $alunosEmails);
                $users = array_merge($users, $alunosUsers);
                $nomes = array_merge($nomes, $alunosNomes);
            
                // Obter os códigos de turma do professor na tabela turmas
                $queryTurmasProf = "SELECT cod_turma FROM turmas WHERE prof_turma = '$selectedProfessorUser'";
                $resultTurmasProf = $mysqli->query($queryTurmasProf);
            
                // Coletar os códigos de turma
                $codTurmas = [];
                while ($rowTurmasProf = $resultTurmasProf->fetch_assoc()) {
                    $codTurmas[] = $rowTurmasProf['cod_turma'];
                }
            
                // Obter os users dos alunos na tabela turmas_alunos
                $queryTurmasAlunos = "SELECT user FROM turmas_alunos WHERE cod_turma IN ('" . implode("','", $codTurmas) . "')";
                $resultTurmasAlunos = $mysqli->query($queryTurmasAlunos);
            
                // Coletar os users dos alunos
                $alunosTurmasUsers = [];
                while ($rowTurmasAlunos = $resultTurmasAlunos->fetch_assoc()) {
                    $alunosTurmasUsers[] = $rowTurmasAlunos['user'];
                }
            
                // Obter os emails dos alunos na tabela users1
                $queryAlunosTurmasEmails = "SELECT user, nome, email FROM users1 WHERE user IN ('" . implode("','", $alunosTurmasUsers) . "')";
                $resultAlunosTurmasEmails = $mysqli->query($queryAlunosTurmasEmails);
            
                // Coletar os users, nomes e emails dos alunos
                $alunosTurmasUsers = [];
                $alunosTurmasNomes = [];
                $alunosTurmasEmails = [];
                while ($rowAlunosTurmas = $resultAlunosTurmasEmails->fetch_assoc()) {
                    $alunosTurmasUsers[] = $rowAlunosTurmas['user'];
                    $alunosTurmasNomes[] = $rowAlunosTurmas['nome'];
                    $alunosTurmasEmails[] = $rowAlunosTurmas['email'];
                }
            
                // Adicionar os emails, users e nomes dos alunos ao array de emails
                $emails = array_merge($emails, $alunosTurmasEmails);
                $users = array_merge($users, $alunosTurmasUsers);
                $nomes = array_merge($nomes, $alunosTurmasNomes);
                break;
            // Adicione os casos para outros destinatários conforme necessário
        }

        // Enviar e-mails
        foreach ($emails as $index => $email) {
            $user = $users[$index];
            $nome = $nomes[$index];
            // Utilize aqui a função para enviar e-mails, como mail() ou uma biblioteca de e-mails
            // Substitua o seguinte echo pela lógica real de envio de e-mail
            //print($user);
            //print($nome);
            //print($email);
            //print('<br/>');

            // Configurações do servidor de e-mail
            $mail->SMTPDebug = SMTP::DEBUG_OFF;
            $mail->isSMTP();
            $mail->Host = 'smtp.gmail.com';
            $mail->SMTPAuth = true;
            $mail->Username = 'gmeasuporte@gmail.com';
            $mail->Password = 'ylav npkg syjg hdiu';
            $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
            $mail->Port = 587;
            $mail->SMTPOptions = array(
                'ssl' => array(
                    'verify_peer' => false,
                    'verify_peer_name' => false,
                    'allow_self_signed' => true
                )
            );

            // Recipients
            $mail->setFrom('gmeasuporte@gmail.com', 'GMEA');
            $mail->addAddress($email, $nome);

            // Content
            $mail->isHTML(true);
            $mail->CharSet = 'UTF-8';
            $mail->Subject = 'AVISO - ' . $titulo;
            $mail->Body = $conteudo;
            $mail->AltBody = $conteudo;

            //echo "E-mail enviado para: $email<br>";

            //$query = "SELECT user, FROM users1 WHERE user = '$user' and estado=1";
        }

        $enviado = $mail->send();
        $successMessage = "Aviso criado com sucesso!";
    } else {
        $errorMessage = "Erro ao criar aviso: " . $stmt->error;
    }

    $stmt->close();
}
else if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["editar-aviso"])) {
    $editarID = $_POST["editar-id-aviso"];
    $editarTitulo = $_POST["editar-aviso-titulo"];
    $editarConteudo = $_POST["editar-aviso-conteudo"];
    $editarDestinatarios = $_POST["editar-destinatarios"];
    $editarDataInicio = $_POST["editar-data-inicio"];
    $editarDataFim = $_POST["editar-data-fim"];
    $editarTipoAviso = $_POST["editar-tipo-aviso"];

    // Atualizar os dados na tabela "avisos"
    $stmtEditar = $mysqli->prepare("UPDATE avisos SET titulo = ?, texto = ?, destino = ?, data_inicio = ?, data_fim = ?, tipo_aviso = ? WHERE id_aviso = ?");
    $stmtEditar->bind_param("sssssii", $editarTitulo, $editarConteudo, $editarDestinatarios, $editarDataInicio, $editarDataFim, $editarTipoAviso, $editarID);

    if ($stmtEditar->execute()) {
        // Obtém os e-mails correspondentes e envia o e-mail
        $emails = [];
        $users = [];
        $nomes = [];
        switch ($editarDestinatarios) {
            case 'todos':
                $query = "SELECT user, nome, email FROM users1";
                $result = $mysqli->query($query);
                $emails = [];
                while ($row = $result->fetch_assoc()) {
                    $users[] = $row['user'];
                    $nomes[] = $row['nome'];
                    $emails[] = $row['email'];
                }
                break;
            case 'direcao':
                $query = "SELECT user, nome, email FROM users1 WHERE type = 3";
                $result = $mysqli->query($query);
                $emails = [];
                while ($row = $result->fetch_assoc()) {
                    $users[] = $row['user'];
                    $nomes[] = $row['nome'];
                    $emails[] = $row['email'];
                }
                break;
            case 'professores':
                $query = "SELECT user, nome, email FROM users1 WHERE type = 2";
                $result = $mysqli->query($query);
                $emails = [];
                while ($row = $result->fetch_assoc()) {
                    $users[] = $row['user'];
                    $nomes[] = $row['nome'];
                    $emails[] = $row['email'];
                }
                break;
            case 'alunos':
                $query = "SELECT user, nome, email FROM users1 WHERE type = 1";
                        // Executar a consulta e obter os e-mails
                $result = $mysqli->query($query);
                $emails = [];
                while ($row = $result->fetch_assoc()) {
                    $users[] = $row['user'];
                    $nomes[] = $row['nome'];
                    $emails[] = $row['email'];
                }
                break;
            case (strpos($editarDestinatarios, 'turmas_gerais') !== false):
                $cod_turma_geral = substr($editarDestinatarios, strrpos($editarDestinatarios, '_') + 1);
                $query = "SELECT u1.user, u1.nome, u1.email FROM users1 u1 
                          JOIN alunos a ON u1.user = a.user 
                          WHERE a.turma = '$cod_turma_geral'";
                        // Executar a consulta e obter os e-mails
                $result = $mysqli->query($query);
                $emails = [];
                while ($row = $result->fetch_assoc()) {
                    $users[] = $row['user'];
                    $nomes[] = $row['nome'];
                    $emails[] = $row['email'];
                }
                break;
            case (strpos($editarDestinatarios, 'turmas') !== false):
                $cod_turma = substr($editarDestinatarios, strrpos($editarDestinatarios, '_') + 1);
                $query = "SELECT u1.user, u1.nome, u1.email FROM users1 u1 
                          JOIN turmas_alunos ta ON u1.user = ta.user 
                          WHERE ta.cod_turma = '$cod_turma'";
                        // Executar a consulta e obter os e-mails
                $result = $mysqli->query($query);
                $emails = [];
                while ($row = $result->fetch_assoc()) {
                    $users[] = $row['user'];
                    $nomes[] = $row['nome'];
                    $emails[] = $row['email'];
                }
                break;
            case (strpos($editarDestinatarios, 'alunos_professor') !== false):
                $selectedProfessorUser = substr($editarDestinatarios, strrpos($editarDestinatarios, '_') + 1);
            
                // Obter os alunos do professor na tabela aulas
                $queryAulas = "SELECT user, prof_in1, prof_in2 FROM alunos WHERE prof_in1 = '$selectedProfessorUser' OR prof_in2 = '$selectedProfessorUser'";
                $resultAulas = $mysqli->query($queryAulas);
            
                // Coletar os users dos alunos
                $alunosUsers = [];
                while ($rowAulas = $resultAulas->fetch_assoc()) {
                    $alunosUsers[] = $rowAulas['user'];
                }
            
                // Obter os emails dos alunos na tabela users1
                $queryAlunosEmails = "SELECT user, nome, email FROM users1 WHERE user IN ('" . implode("','", $alunosUsers) . "')";
                $resultAlunosEmails = $mysqli->query($queryAlunosEmails);
            
                // Coletar os users, nomes e emails dos alunos
                $alunosUsers = [];
                $alunosNomes = [];
                $alunosEmails = [];
                while ($rowAlunos = $resultAlunosEmails->fetch_assoc()) {
                    $alunosUsers[] = $rowAlunos['user'];
                    $alunosNomes[] = $rowAlunos['nome'];
                    $alunosEmails[] = $rowAlunos['email'];
                }
            
                // Adicionar os emails, users e nomes dos alunos ao array de emails
                $emails = array_merge($emails, $alunosEmails);
                $users = array_merge($users, $alunosUsers);
                $nomes = array_merge($nomes, $alunosNomes);
            
                // Obter os códigos de turma do professor na tabela turmas
                $queryTurmasProf = "SELECT cod_turma FROM turmas WHERE prof_turma = '$selectedProfessorUser'";
                $resultTurmasProf = $mysqli->query($queryTurmasProf);
            
                // Coletar os códigos de turma
                $codTurmas = [];
                while ($rowTurmasProf = $resultTurmasProf->fetch_assoc()) {
                    $codTurmas[] = $rowTurmasProf['cod_turma'];
                }
            
                // Obter os users dos alunos na tabela turmas_alunos
                $queryTurmasAlunos = "SELECT user FROM turmas_alunos WHERE cod_turma IN ('" . implode("','", $codTurmas) . "')";
                $resultTurmasAlunos = $mysqli->query($queryTurmasAlunos);
            
                // Coletar os users dos alunos
                $alunosTurmasUsers = [];
                while ($rowTurmasAlunos = $resultTurmasAlunos->fetch_assoc()) {
                    $alunosTurmasUsers[] = $rowTurmasAlunos['user'];
                }
            
                // Obter os emails dos alunos na tabela users1
                $queryAlunosTurmasEmails = "SELECT user, nome, email FROM users1 WHERE user IN ('" . implode("','", $alunosTurmasUsers) . "')";
                $resultAlunosTurmasEmails = $mysqli->query($queryAlunosTurmasEmails);
            
                // Coletar os users, nomes e emails dos alunos
                $alunosTurmasUsers = [];
                $alunosTurmasNomes = [];
                $alunosTurmasEmails = [];
                while ($rowAlunosTurmas = $resultAlunosTurmasEmails->fetch_assoc()) {
                    $alunosTurmasUsers[] = $rowAlunosTurmas['user'];
                    $alunosTurmasNomes[] = $rowAlunosTurmas['nome'];
                    $alunosTurmasEmails[] = $rowAlunosTurmas['email'];
                }
            
                // Adicionar os emails, users e nomes dos alunos ao array de emails
                $emails = array_merge($emails, $alunosTurmasEmails);
                $users = array_merge($users, $alunosTurmasUsers);
                $nomes = array_merge($nomes, $alunosTurmasNomes);
                break;
            // Adicione os casos para outros destinatários conforme necessário
        }

        // Enviar e-mails
        foreach ($emails as $index => $email) {
            $user = $users[$index];
            $nome = $nomes[$index];
            // Utilize aqui a função para enviar e-mails, como mail() ou uma biblioteca de e-mails
            // Substitua o seguinte echo pela lógica real de envio de e-mail
            //print($user);
            //print($nome);
            //print($email);
            //print('<br/>');

            // Configurações do servidor de e-mail
            $mail->SMTPDebug = SMTP::DEBUG_OFF;
            $mail->isSMTP();
            $mail->CharSet = 'UTF-8';
            $mail->Host = 'smtp.gmail.com';
            $mail->SMTPAuth = true;
            $mail->Username = 'gmeasuporte@gmail.com';
            $mail->Password = 'ylav npkg syjg hdiu';
            $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
            $mail->Port = 587;
            $mail->SMTPOptions = array(
                'ssl' => array(
                    'verify_peer' => false,
                    'verify_peer_name' => false,
                    'allow_self_signed' => true
                )
            );

            // Recipients
            $mail->setFrom('gmeasuporte@gmail.com', 'GMEA');
            $mail->addAddress($email, $nome);

            // Content
            $mail->isHTML(true);
            $mail->Subject = '[ATUALIZADO] AVISO - ' . $editarTitulo;
            $mail->Body = $editarConteudo;
            $mail->AltBody = $editarConteudo;

            //echo "E-mail enviado para: $email<br>";

            //$query = "SELECT user, FROM users1 WHERE user = '$user' and estado=1";
        }

        $enviado = $mail->send();
        $successMessage = "Aviso criado com sucesso!";
    } else {
        $errorMessage = "Erro ao criar aviso: " . $stmt->error;
    }

    $stmtEditar->close();
}
?>


<!DOCTYPE html>
<html lang="en">

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
    <link href="https://cdn.quilljs.com/1.3.6/quill.snow.css" rel="stylesheet">
    <script src="https://cdn.quilljs.com/1.3.6/quill.min.js"></script>

</head>

<body>
    <div style="margin-top: 0;">
        <img style="width: 100%; height: auto;" src="./media/topAR.png" class="img-responsive">
    </div>

    <?php
        if ($_SESSION["type"] == 2) {
            include "header-profs.php";
        }
        if ($_SESSION["type"] == 3) {
            include "header-direcao.php";
        }
        if ($_SESSION["type"] == 4) { // Mostrar cabeçalho para professores
            include "header-professor-direcao.php";
        }
    ?>

    <div class="container">
        <h2>Gestão de Avisos</h2>
        <select class="form-select" id="gestao-opcoes">
            <option value="0">Selecionar</option>
            <option value="criar">Criar Aviso</option>
            <option value="editar">Editar Aviso</option>
            <option value="eliminar">Eliminar Aviso</option>
        </select>

        <div id="criar-aviso" class="mt-4 d-none">
            <h3>Criar Aviso</h3>
            <form action="" method="POST">
                <div class="form-group">
                    <label for="aviso-titulo">Título:</label>
                    <input type="text" class="form-control" id="aviso-titulo" name="aviso-titulo" required>
                </div>
                <div class="form-group">
                    <label for="aviso-conteudo">Corpo do Aviso:</label>
                    <div id="aviso-editor" style="height: 200px;"></div>
                    <textarea id="aviso-conteudo" name="aviso-conteudo" class="d-none"></textarea>
                </div>
                <div class="form-group">
                    <label for="destinatarios">Destinatários:</label>
                    <select class="form-select" id="destinatarios" name="destinatarios" required>
                        <option value="todos">Todos</option>
                        <option value="direcao">Elementos da Direção</option>
                        <option value="professores">Professores</option>
                        <option value="alunos">Alunos</option>
                        <?php
                        // Conectar ao banco de dados e buscar turmas
                        $resultTurmasGerais = $mysqli->query("SELECT cod_turma, nome_turma FROM turmas_gerais");
                        while ($rowTurmasGerais = $resultTurmasGerais->fetch_assoc()) {
                            echo "<option value='turmas_gerais_{$rowTurmasGerais['cod_turma']}'>Turma Geral: {$rowTurmasGerais['nome_turma']}</option>";
                        }

                        $resultTurmas = $mysqli->query("SELECT cod_turma, nome_turma FROM turmas WHERE prof_turma NOT LIKE '' AND nome_turma NOT LIKE ''");
                        while ($rowTurmas = $resultTurmas->fetch_assoc()) {
                            echo "<option value='turmas_{$rowTurmas['cod_turma']}'>Turma de: {$rowTurmas['nome_turma']}</option>";
                        }

                        // Conectar ao banco de dados e buscar professores
                        $resultProfessores = $mysqli->query("SELECT user, nome FROM users1 WHERE type = 2");
                        while ($rowProfessores = $resultProfessores->fetch_assoc()) {
                            echo "<option value='alunos_professor_{$rowProfessores['user']}'>Alunos do Professor {$rowProfessores['nome']}</option>";
                        }
                        ?>
                    </select>
                </div>
                <div class="form-group">
                    <label for="data-inicio">Data Início:</label>
                    <input type="date" class="form-control" id="data-inicio" name="data-inicio" required>
                </div>
                <div class="form-group">
                    <label for="data-fim">Data Fim:</label>
                    <input type="date" class="form-control" id="data-fim" name="data-fim" required>
                </div>
                <div class="form-group">
                    <label for="tipo-aviso">Tipo de Aviso:</label>
                    <select class="form-select" id="tipo-aviso" name="tipo-aviso" required>
                        <option value="normal">Normal</option>
                        <option value="urgente">Urgente</option>
                    </select>
                </div>
                <br/>
                <button type="submit" class="btn btn-primary" name="criar-aviso">Criar Aviso</button>
            </form>
        </div>

        <div id="editar-aviso" class="mt-4 d-none">
            <h3>Editar Aviso</h3>
            <table class="table">
                <thead>
                    <tr>
                        <th>Criador</th>
                        <th>Título</th>
                        <th>Texto</th>
                        <th>Destino</th>
                        <th>Data Início</th>
                        <th>Data Fim</th>
                        <th>Ação</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    // Obter avisos ativos
                    $currentDate = date("Y-m-d");
                    $query = "SELECT * FROM avisos WHERE data_fim >= '$currentDate' AND criador = '$user'";
                    $result = $mysqli->query($query);

                    while ($row = $result->fetch_assoc()) {
                        echo "<tr>";
                        echo "<td>{$row['criador']}</td>";
                        echo "<td>{$row['titulo']}</td>";
                        echo "<td>{$row['texto']}</td>";
                        echo "<td>{$row['destino']}</td>";
                        echo "<td>{$row['data_inicio']}</td>";
                        echo "<td>{$row['data_fim']}</td>";
                        echo "<td><button class='btn btn-warning editar-aviso-btn' data-toggle='modal' data-target='#editarAvisoModal' data-id='{$row['id_aviso']}'>Editar</button></td>";
                        echo "</tr>";
                    }
                    ?>
                </tbody>
            </table>
        </div>


        <!-- Tabela de Eliminação de Avisos -->
        <div id="eliminar-aviso" class="mt-4 d-none">
            <h3>Eliminar Aviso</h3>
            <table class="table">
                <thead>
                    <tr>
                        <th>Criador</th>
                        <th>Título</th>
                        <th>Texto</th>
                        <th>Destino</th>
                        <th>Data Início</th>
                        <th>Data Fim</th>
                        <th>Ação</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    // Obter avisos ativos
                    $currentDate = date("Y-m-d");
                    if ($type >= 3) {
                        $queryEliminar = "SELECT * FROM avisos WHERE data_fim >= '$currentDate'";
                    }
                    if ($type == 2) {
                        $queryEliminar = "SELECT * FROM avisos WHERE data_fim >= '$currentDate' AND criador = '$user'";
                    }
                    $resultEliminar = $mysqli->query($queryEliminar);

                    while ($rowEliminar = $resultEliminar->fetch_assoc()) {
                        echo "<tr>";
                        echo "<td>{$rowEliminar['criador']}</td>";
                        echo "<td>{$rowEliminar['titulo']}</td>";
                        echo "<td>{$rowEliminar['texto']}</td>";
                        echo "<td>{$rowEliminar['destino']}</td>";
                        echo "<td>{$rowEliminar['data_inicio']}</td>";
                        echo "<td>{$rowEliminar['data_fim']}</td>";
                        echo "<td><button class='btn btn-danger eliminar-aviso-btn' data-toggle='modal' data-target='#eliminarAvisoModal' data-id='{$rowEliminar['id_aviso']}'>Eliminar</button></td>";
                        echo "</tr>";
                    }
                    ?>
                </tbody>
            </table>
        </div>

    </div>

    <div class="modal fade" id="successModal" tabindex="-1" aria-labelledby="successModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="successModalLabel">Sucesso!</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <?php echo $successMessage; ?>
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
                    <?php echo $errorMessage; ?>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Fechar</button>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal de Edição de Aviso -->
    <div class="modal fade" id="editarAvisoModal" tabindex="-1" aria-labelledby="editarAvisoModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="editarAvisoModalLabel">Editar Aviso</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form action="" method="POST" id="editarAvisoForm">
                        <input type="hidden" id="editar-id-aviso" name="editar-id-aviso">

                        <div class="form-group">
                            <label for="editar-aviso-titulo">Título:</label>
                            <input type="text" class="form-control" id="editar-aviso-titulo" name="editar-aviso-titulo" required>
                        </div>

                        <div class="form-group">
                            <label for="editar-aviso-conteudo">Corpo do Aviso:</label>
                            <div id="editar-aviso-editor" style="height: 200px;"></div>
                            <textarea id="editar-aviso-conteudo" name="editar-aviso-conteudo" class="d-none"></textarea>
                        </div>

                        <div class="form-group">
                            <label for="editar-destinatarios">Destinatários:</label>
                            <select class="form-select" id="editar-destinatarios" name="editar-destinatarios" required>
                                <!-- Opções de Destinatários -->
                                <option value="todos">Todos</option>
                                <option value="direcao">Elementos da Direção</option>
                                <option value="professores">Professores</option>
                                <option value="alunos">Alunos</option>
                                <?php
                                    // Conectar ao banco de dados e buscar turmas gerais
                                    $resultTurmasGerais = $mysqli->query("SELECT cod_turma, nome_turma FROM turmas_gerais");
                                    while ($rowTurmasGerais = $resultTurmasGerais->fetch_assoc()) {
                                        echo "<option value='turmas_gerais_{$rowTurmasGerais['cod_turma']}'>{$rowTurmasGerais['nome_turma']}</option>";
                                    }

                                    // Conectar ao banco de dados e buscar turmas
                                    $resultTurmas = $mysqli->query("SELECT cod_turma, nome_turma FROM turmas");
                                    while ($rowTurmas = $resultTurmas->fetch_assoc()) {
                                        echo "<option value='turmas_{$rowTurmas['cod_turma']}'>{$rowTurmas['nome_turma']}</option>";
                                    }

                                    // Conectar ao banco de dados e buscar professores
                                    $resultProfessores = $mysqli->query("SELECT user, nome FROM users1 WHERE type = 2");
                                    while ($rowProfessores = $resultProfessores->fetch_assoc()) {
                                        echo "<option value='alunos_professor_{$rowProfessores['user']}'>Alunos do Professor {$rowProfessores['nome']}</option>";
                                    }
                                    // Outras consultas e opções de destinatários aqui...
                                ?>
                            </select>
                        </div>

                        <div class="form-group">
                            <label for="editar-data-inicio">Data Início:</label>
                            <input type="date" class="form-control" id="editar-data-inicio" name="editar-data-inicio" required>
                        </div>

                        <div class="form-group">
                            <label for="editar-data-fim">Data Fim:</label>
                            <input type="date" class="form-control" id="editar-data-fim" name="editar-data-fim" required>
                        </div>

                        <div class="form-group">
                            <label for="editar-tipo-aviso">Tipo de Aviso:</label>
                            <select class="form-select" id="editar-tipo-aviso" name="editar-tipo-aviso" required>
                                <option value="1">Normal</option>
                                <option value="2">Urgente</option>
                            </select>
                        </div>

                        <br/>
                        <button type="submit" class="btn btn-primary" name="editar-aviso">Guardar Alterações</button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal de Confirmação de Eliminação -->
    <div class="modal fade" id="eliminarAvisoModal" tabindex="-1" aria-labelledby="eliminarAvisoModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="eliminarAvisoModalLabel">Confirmar Eliminação</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    Tem a certeza de que deseja eliminar este aviso?
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                    <button type="button" class="btn btn-danger" id="confirmarEliminarAvisoBtn">Confirmar Eliminação</button>
                </div>
            </div>
        </div>
    </div>


    <br/><br/><br/><br/>
    <?php
    include "footer-reservado.php";
    ?>
</body>
    <script>
        $(document).ready(function() {
            $("#gestao-opcoes").change(function() {
                const selectedOption = $(this).val();
                $(".mt-4").addClass("d-none");
                $("#" + selectedOption + "-aviso").removeClass("d-none");
            });
        });

        $(document).ready(function() {
            <?php
            if (!empty($successMessage)) {
                echo "$('#successModal').modal('show');";
            }

            if (!empty($errorMessage)) {
                echo "$('#errorModal').modal('show');";
            }
            ?>
        });

            // Função para abrir o modal de edição e preencher os campos com os dados do aviso
            function abrirModalEdicao(avisoID) {
                $.ajax({
                    type: 'POST',
                    url: 'obter_aviso.php',
                    data: { avisoID: avisoID },
                    dataType: 'json',
                    success: function (data) {
                        if (data.error) {
                            alert(data.error);
                        } else {
                            // Preencher os campos do modal de edição com os dados do aviso
                            $('#editar-id-aviso').val(avisoID);
                            $('#editar-aviso-titulo').val(data.titulo);
                            $('#editar-destinatarios').val(data.destino);
                            $('#editar-data-inicio').val(data.data_inicio);
                            $('#editar-data-fim').val(data.data_fim);
                            $('#editar-tipo-aviso').val(data.tipo_aviso);

                            // Preencher o conteúdo do editor Quill com os dados do aviso
                            editarAvisoEditor.root.innerHTML = data.texto;

                            // Abrir o modal de edição
                            $('#editarAvisoModal').modal('show');
                        }
                    },
                    error: function (xhr, status, error) {
                        console.error(xhr.responseText);
                        alert('Erro ao obter dados do aviso');
                    }
                });
            }

            // Evento de clique para abrir o modal de edição
            $('.editar-aviso-btn').click(function () {
                var avisoID = $(this).data('id');
                abrirModalEdicao(avisoID);
            });

            // Função para abrir o modal de confirmação de eliminação
            function abrirModalConfirmacaoEliminar(avisoID) {
                // Defina o atributo 'data-id' do botão de confirmação no modal para o ID do aviso
                $('#confirmarEliminarAvisoBtn').data('id', avisoID);
                // Abrir o modal de confirmação
                $('#eliminarAvisoModal').modal('show');
            }

            // Evento de clique para abrir o modal de confirmação
            $('.eliminar-aviso-btn').click(function () {
                var avisoID = $(this).data('id');
                abrirModalConfirmacaoEliminar(avisoID);
            });

            // Evento de clique para confirmar a eliminação
            $('#confirmarEliminarAvisoBtn').click(function () {
                var avisoID = $(this).data('id');
                // Enviar solicitação AJAX para definir a data_fim para o dia anterior
                $.ajax({
                    type: 'POST',
                    url: 'eliminar-aviso.php',
                    data: { avisoID: avisoID },
                    success: function (data) {
                        // Atualizar a tabela de eliminação (recarregar a página ou atualizar dinamicamente)
                        // Pode ser necessário implementar uma lógica adicional aqui dependendo de como deseja atualizar a interface
                        location.reload();
                    },
                    error: function (xhr, status, error) {
                        console.error(xhr.responseText);
                        alert('Erro ao eliminar aviso');
                    }
                });
            });

            // Inicializar Quill para a caixa de texto de criação de aviso
            var avisoEditor = new Quill('#aviso-editor', {
                theme: 'snow'
            });
            avisoEditor.on('text-change', function() {
                document.getElementById('aviso-conteudo').value = avisoEditor.root.innerHTML;
            });

            // Inicializar Quill para a caixa de texto de edição de aviso
            var editarAvisoEditor = new Quill('#editar-aviso-editor', {
                theme: 'snow'
            });
            editarAvisoEditor.on('text-change', function() {
                document.getElementById('editar-aviso-conteudo').value = editarAvisoEditor.root.innerHTML;
            });


    </script>
    
</html>