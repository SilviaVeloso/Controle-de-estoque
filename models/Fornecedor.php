<?php
class Fornecedor {
    private $conn;
    private $table_name = "fornecedores";

    public $id_fornecedor;
    public $nome;
    public $contato;
    public $telefone;
    public $email;
    public $endereco;
    public $data_criacao;

    public function __construct($db) {
        $this->conn = $db;
    }

    // Criar Fornecedor
    public function criar() {
        $query = "INSERT INTO " . $this->table_name . " (nome, contato, telefone, email, endereco)
                  VALUES (:nome, :contato, :telefone, :email, :endereco)";
        $stmt = $this->conn->prepare($query);

        $stmt->bindParam(":nome", $this->nome);
        $stmt->bindParam(":contato", $this->contato);
        $stmt->bindParam(":telefone", $this->telefone);
        $stmt->bindParam(":email", $this->email);
        $stmt->bindParam(":endereco", $this->endereco);

        return $stmt->execute();
    }

    // Buscar todos os Fornecedores
    public function buscarTodos() {
        $query = "SELECT * FROM " . $this->table_name;
        $stmt = $this->conn->prepare($query);
        $stmt->execute();
        return $stmt;
    }

    // Buscar Fornecedor por ID
    public function buscarPorId($id) {
        $query = "SELECT * FROM " . $this->table_name . " WHERE id_fornecedor = :id_fornecedor LIMIT 1";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':id_fornecedor', $id, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    // Atualizar Fornecedor
    public function atualizar() {
        $query = "UPDATE " . $this->table_name . " 
                  SET nome = :nome, contato = :contato, telefone = :telefone, 
                      email = :email, endereco = :endereco 
                  WHERE id_fornecedor = :id_fornecedor";
        $stmt = $this->conn->prepare($query);

        $stmt->bindParam(":nome", $this->nome);
        $stmt->bindParam(":contato", $this->contato);
        $stmt->bindParam(":telefone", $this->telefone);
        $stmt->bindParam(":email", $this->email);
        $stmt->bindParam(":endereco", $this->endereco);
        $stmt->bindParam(":id_fornecedor", $this->id_fornecedor);

        return $stmt->execute();
    }

    // Deletar Fornecedor
    public function deletar() {
        $query = "DELETE FROM " . $this->table_name . " WHERE id_fornecedor = :id_fornecedor";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(":id_fornecedor", $this->id_fornecedor);
        return $stmt->execute();
    }
}
?>
