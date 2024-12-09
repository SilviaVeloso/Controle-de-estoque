<?php
include __DIR__ . '/../config/db.php'; // Caminho relativo à nova pasta
include __DIR__ . '/../models/Produto.php'; // Caminho relativo à nova pasta

$database = new Database();
$db = $database->getConnection();
$produto = new Produto($db);

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $action = $_POST['action'];
    
    switch ($action) {
        case 'create':
            $produto->nome = $_POST['nome'];
            $produto->descricao = $_POST['descricao'];
            $produto->preco = $_POST['preco'];
            $produto->quantidade_estoque = $_POST['quantidade_estoque'];
            $produto->id_categoria = $_POST['id_categoria'];
            $produto->id_fornecedor = $_POST['id_fornecedor'];

            if ($produto->criar()) {
                echo "Produto cadastrado com sucesso!";
            } else {
                echo "Erro ao cadastrar o produto.";
            }
            break;

        case 'update':
            $produto->id_produto = $_POST['id_produto'];
            $produto->nome = $_POST['nome'];
            $produto->descricao = $_POST['descricao'];
            $produto->preco = $_POST['preco'];
            $produto->quantidade_estoque = $_POST['quantidade_estoque'];
            $produto->id_categoria = $_POST['id_categoria'];
            $produto->id_fornecedor = $_POST['id_fornecedor'];

            if ($produto->atualizar()) {
                echo "Produto atualizado com sucesso!";
            } else {
                echo "Erro ao atualizar o produto.";
            }
            break;

        case 'delete':
            $produto->id_produto = $_POST['id_produto'];

            if ($produto->deletar()) {
                echo "Produto deletado com sucesso!";
            } else {
                header("Location: /controle_de_estoque/views/produto_view.php");

            }
            break;

        case 'edit':
            $produtoData = $produto->buscarPorId($_POST['id_produto']);
            echo "<script>
                    document.getElementById('id_produto').value = '{$produtoData['id_produto']}';
                    document.getElementById('nome').value = '{$produtoData['nome']}';
                    document.getElementById('descricao').value = '{$produtoData['descricao']}';
                    document.getElementById('preco').value = '{$produtoData['preco']}';
                    document.getElementById('quantidade_estoque').value = '{$produtoData['quantidade_estoque']}';
                    document.getElementById('id_categoria').value = '{$produtoData['id_categoria']}';
                    document.getElementById('id_fornecedor').value = '{$produtoData['id_fornecedor']}';
                </script>";
            break;

        default:
            echo "Ação inválida.";
    }
}
header("Location: /controle_de_estoque/views/produto_view.php");
exit;
?>

