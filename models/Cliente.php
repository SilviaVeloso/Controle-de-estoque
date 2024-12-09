<?php
class Cliente {
    private $conn;
    private $table_name = "clientes";

    public $id_cliente;
    public $nome;
    public $email;
    public $telefone;

    public function __construct($db) {
        $this->conn = $db;
    }

    // Criar novo cliente
    public function criar() {
        $query = "INSERT INTO " . $this->table_name . " (nome, email, telefone) VALUES (:nome, :email, :telefone)";
        $stmt = $this->conn->prepare($query);

        $stmt->bindParam(":nome", $this->nome);
        $stmt->bindParam(":email", $this->email);
        $stmt->bindParam(":telefone", $this->telefone);

        if ($stmt->execute()) {
            return true;
        }

        return false;
    }

    // Buscar todos os clientes
    public function buscarTodos() {
        $query = "SELECT id_cliente, nome, email, telefone FROM " . $this->table_name;
        $stmt = $this->conn->prepare($query);
        $stmt->execute();
        return $stmt;
    }

    // Buscar um cliente específico
    public function buscarPorId() {
        $query = "SELECT id_cliente, nome, email, telefone FROM " . $this->table_name . " WHERE id_cliente = :id_cliente";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(":id_cliente", $this->id_cliente);
        $stmt->execute();
        return $stmt;
    }

    // Atualizar cliente
    public function atualizar() {
        $query = "UPDATE " . $this->table_name . " SET nome = :nome, email = :email, telefone = :telefone WHERE id_cliente = :id_cliente";
        $stmt = $this->conn->prepare($query);

        $stmt->bindParam(":nome", $this->nome);
        $stmt->bindParam(":email", $this->email);
        $stmt->bindParam(":telefone", $this->telefone);
        $stmt->bindParam(":id_cliente", $this->id_cliente);

        if ($stmt->execute()) {
            return true;
        }

        return false;
    }

    // Deletar cliente
    public function deletar() {
        $query = "DELETE FROM " . $this->table_name . " WHERE id_cliente = :id_cliente";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(":id_cliente", $this->id_cliente);

        if ($stmt->execute()) {
            return true;
        }

        return false;
    }
}
?>
