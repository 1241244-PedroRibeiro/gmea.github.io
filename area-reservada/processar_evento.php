<?php
session_start();
include "./generals/config.php"; // Certifique-se de incluir o arquivo de configuração corretamente

// Verificar se os dados do evento foram enviados via POST
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Verificar se a ação é para editar ou excluir um evento
    if (isset($_POST['acao'])) {
        // Se a ação for excluir, executar a exclusão do evento
        if ($_POST['acao'] == 'excluir') {
            // Capturar e limpar o ID do evento a ser excluído
            $id_evento = $_POST['id_evento'];

            // Conectar ao banco de dados
            $mysqli = new mysqli($bd_host, $bd_user, $bd_password, $bd_database);

            // Verificar a conexão
            if ($mysqli->connect_error) {
                die('Erro na conexão: (' . $mysqli->connect_errno . ') ' . $mysqli->connect_error);
            }

            // Preparar e executar a consulta de exclusão
            $delete_query = "DELETE FROM calendario WHERE id_evento = ?";

            // Preparar a declaração SQL
            $stmt = $mysqli->prepare($delete_query);

            // Verificar se a preparação da consulta foi bem-sucedida
            if ($stmt) {
                // Vincular o ID do evento à declaração
                $stmt->bind_param("i", $id_evento);

                // Executar a declaração
                if ($stmt->execute()) {
                    // Sucesso: evento excluído corretamente
                    echo "Evento excluído com sucesso!";
                } else {
                    // Erro ao executar a declaração
                    echo "Erro ao excluir evento: " . $stmt->error;
                }

                // Fechar a declaração
                $stmt->close();
            } else {
                // Erro na preparação da declaração
                echo "Erro na preparação da consulta: " . $mysqli->error;
            }

            // Fechar a conexão com o banco de dados
            $mysqli->close();
        }
    } else {
        // Se não for uma ação de exclusão, é uma ação de adição ou edição de evento

        // Capturar e limpar os dados enviados
        $tipo_evento = $_POST['tipo_evento'];
        $inicio = $_POST['inicio'];
        $fim = $_POST['fim'];
        $disciplina = $_POST['disciplina'];
        $destinatario = $_POST['destinatario'];
        $nota = $_POST['nota'];
        $title = $_POST['title'];

        // Validar os dados, se necessário
        // Aqui você pode adicionar validações adicionais, se precisar

        // Conectar ao banco de dados
        $mysqli = new mysqli($bd_host, $bd_user, $bd_password, $bd_database);

        // Verificar a conexão
        if ($mysqli->connect_error) {
            die('Erro na conexão: (' . $mysqli->connect_errno . ') ' . $mysqli->connect_error);
        }

        // Verificar se é uma ação de adição ou edição com base na presença do ID do evento
        if ($_POST['id_evento'] != '') {
            // É uma ação de edição, capturar e limpar o ID do evento
            $id_evento = $_POST['id_evento'];

            // Preparar e executar a consulta de atualização
            $update_query = "UPDATE calendario SET tipo_evento=?, inicio=?, fim=?, cod_dis=?, userOuTurma=?, criador=?, notas=?, titulo=? WHERE id_evento=?";

            // Preparar a declaração SQL
            $stmt = $mysqli->prepare($update_query);

            // Verificar se a preparação da consulta foi bem-sucedida
            if ($stmt) {
                // Vincular parâmetros à declaração
                $stmt->bind_param("ssssssssi", $tipo_evento, $inicio, $fim, $disciplina, $destinatario, $_SESSION["username"], $nota, $title, $id_evento);

                // Executar a declaração
                if ($stmt->execute()) {
                    // Sucesso: evento atualizado corretamente
                    echo "Evento atualizado com sucesso!";
                } else {
                    // Erro ao executar a declaração
                    echo "Erro ao atualizar evento: " . $stmt->error;
                }

                // Fechar a declaração
                $stmt->close();
            } else {
                // Erro na preparação da declaração
                echo "Erro na preparação da consulta: " . $mysqli->error;
            }
        } else {
            // É uma ação de adição, não há ID de evento, então é uma inserção

            // Preparar e executar a consulta de inserção
            $insert_query = "INSERT INTO calendario (tipo_evento, inicio, fim, cod_dis, userOuTurma, criador, notas, titulo) 
                             VALUES (?, ?, ?, ?, ?, ?, ?, ?)";

            // Preparar a declaração SQL
            $stmt = $mysqli->prepare($insert_query);

            // Verificar se a preparação da consulta foi bem-sucedida
            if ($stmt) {
                // Vincular parâmetros à declaração
                $stmt->bind_param("ssssssss", $tipo_evento, $inicio, $fim, $disciplina, $destinatario, $_SESSION["username"], $nota, $title);

                // Executar a declaração
                if ($stmt->execute()) {
                    // Sucesso: evento inserido corretamente
                    echo "Evento inserido com sucesso!";
                } else {
                    // Erro ao executar a declaração
                    echo "Erro ao inserir evento: " . $stmt->error;
                }

                // Fechar a declaração
                $stmt->close();
            } else {
                // Erro na preparação da declaração
                echo "Erro na preparação da consulta: " . $mysqli->error;
            }
        }

        // Fechar a conexão com o banco de dados
        $mysqli->close();
    }
} else {
    // Se os dados não foram enviados via POST
    echo "Erro: método inválido de requisição.";
}
?>
