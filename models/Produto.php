<?php
class Produto {
    private $conn;
    private $table_name = "Produtos";

    public $id_produto;
    public $nome;
    public $descricao;
    public $preco;
    public $quantidade_estoque;
    public $id_categoria;
    public $id_fornecedor;

    public $quantidade_compra  = 1;

    public function __construct($db) {
        $this->conn = $db;
    }

    // Criar Produto
    public function criar() {
        $query = "INSERT INTO " . $this->table_name . " (nome, descricao, preco, quantidade_estoque, id_categoria, id_fornecedor)
                  VALUES (:nome, :descricao, :preco, :quantidade_estoque, :id_categoria, :id_fornecedor)";
        $stmt = $this->conn->prepare($query);

        $stmt->bindParam(":nome", $this->nome);
        $stmt->bindParam(":descricao", $this->descricao);
        $stmt->bindParam(":preco", $this->preco);
        $stmt->bindParam(":quantidade_estoque", $this->quantidade_estoque);
        $stmt->bindParam(":id_categoria", $this->id_categoria);
        $stmt->bindParam(":id_fornecedor", $this->id_fornecedor);

        return $stmt->execute();
    }

    // Ler todos os Produtos
    public function buscarTodos() {
        $query = "SELECT * FROM " . $this->table_name;
        $stmt = $this->conn->prepare($query);
        $stmt->execute();
        return $stmt;
    }

    public function buscarPorId($id) {
        $query = "SELECT * FROM " . $this->table_name . " WHERE id_produto = :id_produto LIMIT 1";
        $stmt = $this->conn->prepare($query);
    
        $stmt->bindParam(':id_produto', $id, PDO::PARAM_INT);
        $stmt->execute();
    
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function atualizar() {
        $query = "UPDATE " . $this->table_name . " 
                  SET nome = :nome, descricao = :descricao, preco = :preco, 
                      quantidade_estoque = :quantidade_estoque, id_categoria = :id_categoria, id_fornecedor = :id_fornecedor 
                  WHERE id_produto = :id_produto";
        $stmt = $this->conn->prepare($query);

        $stmt->bindParam(":nome", $this->nome);
        $stmt->bindParam(":descricao", $this->descricao);
        $stmt->bindParam(":preco", $this->preco);
        $stmt->bindParam(":quantidade_estoque", $this->quantidade_estoque);
        $stmt->bindParam(":id_categoria", $this->id_categoria);
        $stmt->bindParam(":id_fornecedor", $this->id_fornecedor);
        $stmt->bindParam(":id_produto", $this->id_produto);

        return $stmt->execute();
    }

    // Deletar Produto
    public function deletar() {
        $query = "DELETE FROM " . $this->table_name . " WHERE id_produto = :id_produto";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(":id_produto", $this->id_produto);
        return $stmt->execute();
    }
}
?>
