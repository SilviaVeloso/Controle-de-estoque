<?php
class Pedido {
    private $conn;
    private $table_name = "pedidos";
    private $table_details = "detalhespedido";

    public $id_pedido;
    public $id_cliente;
    public $data_criacao; // Adicionado
    public $total;
    public $produtos = []; // Agora temos a variável para os produtos

    public function __construct($db) {
        $this->conn = $db;
    }

    // Criar um pedido
    public function criar() {
        // Inicia a transação
        $this->conn->beginTransaction();

        // Cria o pedido
        $query = "INSERT INTO " . $this->table_name . " (id_cliente, total) VALUES (:id_cliente, :total)";
        $stmt = $this->conn->prepare($query);

        $stmt->bindParam(":id_cliente", $this->id_cliente);
        $stmt->bindParam(":total", $this->total);

        if ($stmt->execute()) {
            // Pega o ID do pedido recém-criado
            $this->id_pedido = $this->conn->lastInsertId();

            // Adiciona os detalhes do pedido
            foreach ($this->produtos as $produto_id => $detalhe) {
                $query = "INSERT INTO " . $this->table_details . " (id_pedido, id_produto, quantidade, preco_unitario, subtotal) 
                          VALUES (:id_pedido, :id_produto, :quantidade, :preco_unitario, :subtotal)";
                $stmt = $this->conn->prepare($query);
                $stmt->bindParam(":id_pedido", $this->id_pedido);
                $stmt->bindParam(":id_produto", $produto_id);
                $stmt->bindParam(":quantidade", $detalhe['quantidade']);
                $stmt->bindParam(":preco_unitario", $detalhe['preco_unitario']);
                $stmt->bindParam(":subtotal", $detalhe['subtotal']);

                if (!$stmt->execute()) {
                    $this->conn->rollBack();
                    return false;
                }
            }

            // Commit da transação
            $this->conn->commit();
            return true;
        }

        // Caso algum erro ocorra, desfaz a transação
        $this->conn->rollBack();
        return false;
    }

    // Obter pedidos (inclui data de criação)
    public function buscarTodos() {
        $query = "SELECT id_pedido, id_cliente, total, data_criacao FROM " . $this->table_name . " ORDER BY data_criacao DESC";
        $stmt = $this->conn->prepare($query);
        $stmt->execute();
        return $stmt;
    }
}

?>
