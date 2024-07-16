<?php
if ($_SERVER["REQUEST_METHOD"] == "GET" && isset($_GET['acao'])) {
    $acao = $_GET['acao'];
    
    // Redirecionar para páginas específicas com base na ação selecionada
    if ($acao == 'inserir') {
        header("Location: inserir-avaliacoes.php");
        exit();
    } elseif ($acao == 'editar') {
        header("Location: editar-avaliacoes.php");
        exit();
    } elseif ($acao == 'eliminar') {
        header("Location: eliminar-avaliacoes.php");
        exit();
    }
}
// Se nenhuma ação válida for selecionada ou houver algum erro, redirecionar para a página principal
header("Location: index.php");
exit();
?>
