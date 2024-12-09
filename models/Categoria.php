<?php
class Categoria {
    private $conn;
    private $table_name = "categorias";

    public $id_categoria;
    public $nome;
    public $descricao;
    public $data_criacao;

    public function __construct($db) {
        $this->conn = $db;
    }

    // Criar Categoria
    public function criar() {
        $query = "INSERT INTO " . $this->table_name . " (nome, descricao)
                  VALUES (:nome, :descricao)";
        $stmt = $this->conn->prepare($query);

        $stmt->bindParam(":nome", $this->nome);
        $stmt->bindParam(":descricao", $this->descricao);

        return $stmt->execute();
    }

    // Buscar todas as Categorias
    public function buscarTodas() {
        $query = "SELECT * FROM " . $this->table_name;
        $stmt = $this->conn->prepare($query);
        $stmt->execute();
        return $stmt;
    }

    // Buscar Categoria por ID
    public function buscarPorId($id) {
        $query = "SELECT * FROM " . $this->table_name . " WHERE id_categoria = :id_categoria LIMIT 1";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':id_categoria', $id, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    // Atualizar Categoria
    public function atualizar() {
        $query = "UPDATE " . $this->table_name . " 
                  SET nome = :nome, descricao = :descricao 
                  WHERE id_categoria = :id_categoria";
        $stmt = $this->conn->prepare($query);

        $stmt->bindParam(":nome", $this->nome);
        $stmt->bindParam(":descricao", $this->descricao);
        $stmt->bindParam(":id_categoria", $this->id_categoria);

        return $stmt->execute();
    }

    // Deletar Categoria
    public function deletar() {
        $query = "DELETE FROM " . $this->table_name . " WHERE id_categoria = :id_categoria";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(":id_categoria", $this->id_categoria);
        return $stmt->execute();
    }
}
?>
