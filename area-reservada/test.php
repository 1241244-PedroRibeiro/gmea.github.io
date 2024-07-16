<!DOCTYPE html>
<html>
<head>
    <title>Enviar Array para PHP</title>
</head>
<body>
    <form id="formEnviarArray" method="post">
        <input type="hidden" id="alunosSelecionadosInput" name="alunosSelecionados">
        <button type="submit" name="atualizarAula">Atualizar Aula</button>
    </form>

    <script>
        document.addEventListener("DOMContentLoaded", function() {
            // Seleciona o formulário
            var formEnviarArray = document.getElementById("formEnviarArray");

            // Adiciona um event listener para o submit do formulário
            formEnviarArray.addEventListener("submit", function(event) {
                event.preventDefault(); // Previne o comportamento padrão do formulário

                // Sua array de alunos selecionados
                var alunosSelecionados = ["João", "Maria", "Pedro"];

                // Preenche o valor do input hidden com a array convertida para JSON
                document.getElementById("alunosSelecionadosInput").value = JSON.stringify(alunosSelecionados);

                // Submete o formulário
                this.submit();
            });
        });
    </script>

    <?php
    // Verifica se o formulário foi submetido
    if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["alunosSelecionados"])) {
        // Recebe a array enviada do JavaScript
        $alunosSelecionados = json_decode($_POST["alunosSelecionados"], true);

        // Faça o que desejar com a array recebida
        print_r($alunosSelecionados);
    }
    ?>
</body>
</html>
