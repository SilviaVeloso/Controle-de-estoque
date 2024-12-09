<?php
include_once __DIR__ . '/../config/db.php';
include_once __DIR__ . '/../models/Cliente.php';

$database = new Database();
$db = $database->getConnection();
$cliente = new Cliente($db);

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $action = isset($_POST['action']) ? $_POST['action'] : '';

    switch ($action) {
        case 'create':
            $cliente->nome = $_POST['nome'];
            $cliente->email = $_POST['email'];
            $cliente->telefone = $_POST['telefone'];

            if ($cliente->criar()) {
                echo "Cliente cadastrado com sucesso!";
            } else {
                echo "Erro ao cadastrar o cliente!";
            }
            break;

        case 'update':
            $cliente->id_cliente = $_POST['id_cliente'];
            $cliente->nome = $_POST['nome'];
            $cliente->email = $_POST['email'];
            $cliente->telefone = $_POST['telefone'];

            if ($cliente->atualizar()) {
                echo "Cliente atualizado com sucesso!";
            } else {
                echo "Erro ao atualizar o cliente!";
            }
            break;

        case 'edit':
            $cliente->id_cliente = $_POST['id_cliente'];
            $stmt = $cliente->buscarPorId();
            $row = $stmt->fetch(PDO::FETCH_ASSOC);

            // Preenche os campos do formulário com os dados do cliente
            // Isso seria feito na view de edição com um formulário
            break;

        case 'delete':
            $cliente->id_cliente = $_POST['id_cliente'];
            if ($cliente->deletar()) {
                echo "Cliente deletado com sucesso!";
            } else {
                echo "Erro ao deletar o cliente!";
            }
            break;
    }
}
header("Location: /controle_de_estoque/views/cliente_view.php");
?>
