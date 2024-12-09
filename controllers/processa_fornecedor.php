<?php
include __DIR__ . '/../config/db.php';
include __DIR__ . '/../models/Fornecedor.php';

// Conexão com o banco de dados
$database = new Database();
$db = $database->getConnection();
$fornecedor = new Fornecedor($db);

// Identificar a ação enviada pelo formulário
$action = $_POST['action'] ?? null;

try {
    if ($action === 'create') {
        // Criar novo fornecedor
        $fornecedor->nome = $_POST['nome'];
        $fornecedor->contato = $_POST['contato'] ?? null;
        $fornecedor->telefone = $_POST['telefone'] ?? null;
        $fornecedor->email = $_POST['email'] ?? null;
        $fornecedor->endereco = $_POST['endereco'] ?? null;

        if ($fornecedor->criar()) {
            echo "Fornecedor criado com sucesso!";
        } else {
            echo "Erro ao criar o fornecedor.";
        }
    } elseif ($action === 'update') {
        // Atualizar fornecedor existente
        $fornecedor->id_fornecedor = $_POST['id_fornecedor'];
        $fornecedor->nome = $_POST['nome'];
        $fornecedor->contato = $_POST['contato'] ?? null;
        $fornecedor->telefone = $_POST['telefone'] ?? null;
        $fornecedor->email = $_POST['email'] ?? null;
        $fornecedor->endereco = $_POST['endereco'] ?? null;

        if ($fornecedor->atualizar()) {
            echo "Fornecedor atualizado com sucesso!";
        } else {
            echo "Erro ao atualizar o fornecedor.";
        }
    } elseif ($action === 'delete') {
        // Deletar fornecedor
        $fornecedor->id_fornecedor = $_POST['id_fornecedor'];

        if ($fornecedor->deletar()) {
            echo "Fornecedor deletado com sucesso!";
        } else {
            echo "Erro ao deletar o fornecedor.";
        }
    } elseif ($action === 'edit') {
        // Buscar fornecedor para edição
        $fornecedor_data = $fornecedor->buscarPorId($_POST['id_fornecedor']);
        if ($fornecedor_data) {
            header('Content-Type: application/json');
            echo json_encode($fornecedor_data);
        } else {
            echo "Fornecedor não encontrado.";
        }
        exit;
    } else {
        echo "Ação inválida.";
    }
} catch (Exception $e) {
    echo "Erro: " . $e->getMessage();
}

// Redirecionar de volta para a página de fornecedores
header("Location: /controle_de_estoque/views/fornecedor_view.php");
exit;
?>
