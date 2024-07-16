<?php
session_start();
include "./generals/config.php";
$mysqli = new mysqli($bd_host, $bd_user, $bd_password, $bd_database);

if ($mysqli->connect_error) {
    die('Erro: (' . $mysqli->connect_errno . ') ' . $mysqli->connect_error);
}

if (empty($_SESSION["session_id"]) || $_SESSION["type"] < 3) {
    header("Location: ../index.php");
    exit;
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Consultar o número mais alto da tabela 'faturas'
    $query = "SELECT MAX(fatura_num) as max_fatura FROM faturas";
    $result = $mysqli->query($query);

    if ($result) {
        $row = $result->fetch_assoc();
        $maxFatura = $row["max_fatura"];

        // Incrementar o número da fatura
        $novaFatura = $maxFatura + 1;

        // Obter os produtos do campo oculto no formulário
        $produtos = json_decode($_POST['produtos'], true);

        // Inserir os produtos na tabela 'produtos_faturas_gen'
        foreach ($produtos as $produto) {
            $nomeProduto = $mysqli->real_escape_string($produto['nome']);

            // Converter o preço de volta para o formato desejado
            $precoProduto = number_format($produto['valor'] / 100, 2, '.', '');

            $query = "INSERT INTO produtos_faturas_gen (fatura_num, produto, preco) VALUES ($novaFatura, '$nomeProduto', $precoProduto)";
            $mysqli->query($query);
        }

        echo "Produtos inseridos com sucesso!<br>";
    } else {
        echo "Erro ao obter o número da fatura mais alto.";
    }
}
?>

<!DOCTYPE html>
<html lang="pt">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>GMEA</title>
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
        if ($_SESSION["type"] == 3) { // Mostrar cabeçalho para professores
            include "header-direcao.php"; 
        } 
        if ($_SESSION["type"] == 4) { // Mostrar cabeçalho para professores
            include "header-professor-direcao.php";
        } 

    ?>
<div class="container mt-5">
    <!-- Formulário para informações do destinatário -->
    <form method="post" action="generals/pdf-fatura-base.php" class="mb-4" id="fatura-form">
        <h2>Informações do Destinatário</h2>
        <div class="mb-3">
            <label for="nome" class="form-label">Nome:</label>
            <input type="text" name="nome" id="nome" class="form-control" required>
        </div>
        
        <div class="mb-3">
            <label for="morada1" class="form-label">Morada:</label>
            <input type="text" name="morada1" id="morada1" class="form-control" required>
        </div>
        
        <div class="mb-3">
            <label for="morada2" class="form-label">Morada (Continuação):</label>
            <input type="text" name="morada2" id="morada2" class="form-control">
        </div>
        
        <div class="mb-3">
            <label for="nif" class="form-label">NIF:</label>
            <input type="text" name="nif" id="nif" class="form-control" required>
        </div>
        
        <div class="mb-3">
            <label for="email" class="form-label">E-mail:</label>
            <input type="email" name="email" id="email" class="form-control" required>
        </div>

        <!-- Adicione um campo oculto para armazenar os produtos -->
        <input type="hidden" name="produtos" id="produtos-input">

    </form>

    <!-- Espaço para o segundo formulário (Produtos) -->
    <div id="produtos-form">
        <h2>Artigos</h2>
        <form method="post" action="" id="produto-form">
            <div class="mb-3">
                <label for="produto" class="form-label">Nome do Artigo:</label>
                <input type="text" name="produto" class="form-control" required>
            </div>

            <div class="mb-3">
                <label for="valor" class="form-label">Valor a Cobrar:</label>
                <input type="text" name="valor" class="form-control" required>
            </div>

            <button type="button" onclick="adicionarProduto()" class="btn btn-success">Adicionar Artigo</button>
        </form>

        <!-- Tabela para exibir os produtos -->
        <table class="table mt-4">
            <thead>
                <tr>
                    <th>Artigo</th>
                    <th>Valor</th>
                    <th>Ação</th>
                </tr>
            </thead>
            <tbody id="corpo-tabela-produtos"></tbody>
        </table>

        <!-- Botão 'Inserir Produtos' adicionado -->
        <button type="button" onclick="inserirProdutos()" class="btn btn-secondary me-2">Inserir Artigo(s)</button>
        <button type="button" onclick="gerarFatura()" class="btn btn-primary">Gerar Fatura</button>
    </div>
</div>

<!-- Adicione os scripts do Bootstrap e outros scripts necessários -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0/dist/js/bootstrap.bundle.min.js" integrity="sha384-mQ93GR66B00ZXjt0YO5KlohRA5SY2XofTW3tDREhUjFfDjD5R4xC9d+JDA0OvRTw" crossorigin="anonymous"></script>
<!-- Seus outros scripts aqui -->

<!-- Script JavaScript -->
<script>
    var produtos = [];

    function adicionarProduto() {
        var produtoForm = document.getElementById('produto-form');
        var nomeProduto = produtoForm.querySelector('input[name="produto"]').value;
        var valorProduto = produtoForm.querySelector('input[name="valor"]').value.replace(',', '.');

        // Converter para inteiro de centavos
        var valorCentavos = Math.round(parseFloat(valorProduto) * 100);

        var produto = {
            nome: nomeProduto,
            valor: valorCentavos
        };

        produtos.push(produto);
        atualizarTabelaProdutos();

        produtoForm.reset(); // Limpar campos do formulário
    }

    function removerProduto(index) {
        produtos.splice(index, 1);
        atualizarTabelaProdutos();
    }

    function editarProduto(index) {
        var produto = produtos[index];
        var produtoForm = document.getElementById('produto-form');
        produtoForm.querySelector('input[name="produto"]').value = produto.nome;

        // Converter para formato de exibição com duas casas decimais e símbolo '€'
        var valorFormatado = (produto.valor / 100).toLocaleString('pt-PT', { style: 'currency', currency: 'EUR' });

        produtoForm.querySelector('input[name="valor"]').value = valorFormatado;

        // Remover o produto da lista enquanto editamos
        removerProduto(index);
    }

    function atualizarTabelaProdutos() {
        var tabela = document.getElementById('corpo-tabela-produtos');
        tabela.innerHTML = '';

        for (var i = 0; i < produtos.length; i++) {
            var produto = produtos[i];

            var linha = tabela.insertRow();
            var colunaNome = linha.insertCell(0);
            var colunaValor = linha.insertCell(1);
            var colunaAcao = linha.insertCell(2);

            colunaNome.innerHTML = produto.nome;

            // Converter para formato de exibição com duas casas decimais e símbolo '€'
            var valorFormatado = (produto.valor / 100).toLocaleString('pt-PT', { style: 'currency', currency: 'EUR' });

            colunaValor.innerHTML = valorFormatado;

            var btnRemover = document.createElement('button');
            btnRemover.innerHTML = 'Remover';
            btnRemover.classList.add('btn', 'btn-danger', 'me-2');
            btnRemover.addEventListener('click', (function(index) {
                return function() {
                    removerProduto(index);
                }
            })(i));

            var btnEditar = document.createElement('button');
            btnEditar.innerHTML = 'Editar';
            btnEditar.classList.add('btn', 'btn-warning');
            btnEditar.addEventListener('click', (function(index) {
                return function() {
                    editarProduto(index);
                }
            })(i));

            colunaAcao.appendChild(btnRemover);
            colunaAcao.appendChild(btnEditar);
        }

        // Atualizar o campo oculto de produtos antes de enviar o formulário
        document.getElementById('produtos-input').value = JSON.stringify(produtos);
    }

    // Função para inserir produtos na tabela 'produtos_faturas_gen'
    function inserirProdutos() {
        $.ajax({
            type: "POST",
            url: window.location.href, // Enviar a solicitação para a mesma página
            data: { produtos: JSON.stringify(produtos) },
            success: function(response) {
            },
            error: function(error) {
                alert("Erro ao inserir produtos.");
            }
        });
    }

    function gerarFatura() {
        // Enviar o formulário
        document.getElementById('fatura-form').submit();
    }
</script>
</body>
</html>

<?php
include "footer-reservado.php";
?>