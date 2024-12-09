<?php
class DetalhesPedido {
    private $conn;
    private $table_name = "detalhespedido";

    public function __construct($db) {
        $this->conn = $db;
    }

    // Verifica se o produto está relacionado a algum pedido
    public function verificarProdutoRelacionado($id_produto) {
        $query = "SELECT COUNT(*) AS total FROM " . $this->table_name . " WHERE id_produto = :id_produto";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':id_produto', $id_produto, PDO::PARAM_INT);
        $stmt->execute();
        $result = $stmt->fetch(PDO::FETCH_ASSOC);

        return $result['total'] > 0; // Retorna true se relacionado
    }
}
?>
