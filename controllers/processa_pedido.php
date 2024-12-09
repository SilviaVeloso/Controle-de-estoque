<?php
include_once __DIR__ . '/../config/db.php';
include_once __DIR__ . '/../models/Pedido.php';
include_once __DIR__ . '/../models/Produto.php';

$database = new Database();
$db = $database->getConnection();
$pedido = new Pedido($db);

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $id_cliente = $_POST['id_cliente'];
    $produtos = $_POST['produtos'] ?? []; // Certifique-se de inicializar como array
    $quantidade = $_POST['quantidade'] ?? []; // Certifique-se de inicializar como array
    $total = $_POST['total']; // Certifique-se de inicializar como array

    $db->beginTransaction();

    try {
        // Inserir o pedido na tabela pedidos
        $query = "INSERT INTO pedidos (id_cliente, total) VALUES (:id_cliente, :total)";
        $stmt = $db->prepare($query);
        $stmt->bindParam(':id_cliente', $id_cliente, PDO::PARAM_INT);
        $stmt->bindParam(':total', $total, PDO::PARAM_STR);
        $stmt->execute();

        // Pegar o ID do pedido inserido
        $id_pedido = $db->lastInsertId();

        // Para cada produto, insira um detalhe do pedido na tabela detalhespedido
        if (is_array($produtos)) {
            foreach ($produtos as $produto) {
                $produto = json_decode($produto, true); // Decodifica o JSON para array
                $id_produto = $produto['id_produto'];
                $quantidade_compra = $produto['quantidade_compra'];

                // Consultar preço do produto
                $query_produto = "SELECT preco, quantidade_estoque FROM produtos WHERE id_produto = :id_produto";
                $stmt_produto = $db->prepare($query_produto);
                $stmt_produto->bindParam(':id_produto', $id_produto, PDO::PARAM_INT);
                $stmt_produto->execute();
                $produto_info = $stmt_produto->fetch(PDO::FETCH_ASSOC);
                $preco_unitario = $produto_info['preco'];
                $estoque_atual = $produto_info['quantidade_estoque'];

                // Verificar se há estoque suficiente
                if ($quantidade_compra > $estoque_atual) {
                    throw new Exception("Estoque insuficiente para o produto ID: $id_produto.");
                }

                // Inserir na tabela detalhespedido
                $query_detalhe = "INSERT INTO detalhespedido (id_pedido, id_produto, quantidade, preco_unitario) 
                                VALUES (:id_pedido, :id_produto, :quantidade, :preco_unitario)";
                $stmt_detalhe = $db->prepare($query_detalhe);
                $stmt_detalhe->bindParam(':id_pedido', $id_pedido, PDO::PARAM_INT);
                $stmt_detalhe->bindParam(':id_produto', $id_produto, PDO::PARAM_INT);
                $stmt_detalhe->bindParam(':quantidade', $quantidade_compra, PDO::PARAM_INT);
                $stmt_detalhe->bindParam(':preco_unitario', $preco_unitario, PDO::PARAM_STR);
                $stmt_detalhe->execute();

                // Atualizar o estoque do produto
                $query_update_estoque = "UPDATE produtos SET quantidade_estoque = quantidade_estoque - :quantidade_compra WHERE id_produto = :id_produto";
                $stmt_update_estoque = $db->prepare($query_update_estoque);
                $stmt_update_estoque->bindParam(':quantidade_compra', $quantidade_compra, PDO::PARAM_INT);
                $stmt_update_estoque->bindParam(':id_produto', $id_produto, PDO::PARAM_INT);
                $stmt_update_estoque->execute();
            }
        } else {
            throw new Exception("Erro: Produtos não são um array válido.");
        }

        // Commit da transação
        $db->commit();

        echo "Pedido cadastrado com sucesso!";
        // Redirecionar para a página de sucesso ou listagem de pedidos
        header('Location: /controle_de_estoque/views/pedido_sucesso.php');
        exit;

    } catch (Exception $e) {
        // Se algum erro ocorrer, desfaz a transação
        $db->rollBack();
        echo "Erro: " . $e->getMessage();
    }
}
