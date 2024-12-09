<?php
include __DIR__ . '/../config/db.php';
include __DIR__ . '/../models/Categoria.php';

// Conexão com o banco de dados
$database = new Database();
$db = $database->getConnection();
$categoria = new Categoria($db);

// Identificar a ação enviada pelo formulário
$action = $_POST['action'] ?? null;

try {
    if ($action === 'create') {
        // Criar nova categoria
        $categoria->nome = $_POST['nome'];
        $categoria->descricao = $_POST['descricao'] ?? null;

        if ($categoria->criar()) {
            echo "Categoria criada com sucesso!";
        } else {
            echo "Erro ao criar a categoria.";
        }
    } elseif ($action === 'update') {
        // Atualizar categoria existente
        $categoria->id_categoria = $_POST['id_categoria'];
        $categoria->nome = $_POST['nome'];
        $categoria->descricao = $_POST['descricao'] ?? null;

        if ($categoria->atualizar()) {
            echo "Categoria atualizada com sucesso!";
        } else {
            echo "Erro ao atualizar a categoria.";
        }
    } elseif ($action === 'delete') {
        // Deletar categoria
        $categoria->id_categoria = $_POST['id_categoria'];

        if ($categoria->deletar()) {
            echo "Categoria deletada com sucesso!";
        } else {
            echo "Erro ao deletar a categoria.";
        }
    } elseif ($action === 'edit') {
        // Buscar categoria para edição
        $categoria_data = $categoria->buscarPorId($_POST['id_categoria']);
        if ($categoria_data) {
            header('Content-Type: application/json');
            echo json_encode($categoria_data);
        } else {
            echo "Categoria não encontrada.";
        }
        exit; // Evita saída adicional no modo edição
    } else {
        echo "Ação inválida.";
    }
} catch (Exception $e) {
    echo "Erro: " . $e->getMessage();
}

// Redirecionar de volta para a página de categorias
header("Location: /controle_de_estoque/views/categoria_view.php");
exit;
?>
