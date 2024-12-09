<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gerenciamento de Produtos</title>
    <link rel="stylesheet" href="/controle_de_estoque/assets/css/styles.css">
</head>

<body>

    <?php include 'menu_lateral_view.php'; ?>

    <div class="content">
        <h1>Gerenciamento de Produtos</h1>

        <form class="cadastro" action='/controle_de_estoque/controllers/processa_produto.php' method="POST">
            <input type="hidden" id="id_produto" name="id_produto">

            <label for="nome">Nome:</label><br>
            <input type="text" id="nome" name="nome" required><br><br>

            <label for="descricao">Descrição:</label><br>
            <textarea id="descricao" name="descricao" required></textarea><br><br>

            <label for="preco">Preço:</label><br>
            <input type="number" step="0.01" id="preco" name="preco" required><br><br>

            <label for="quantidade_estoque">Quantidade em Estoque:</label><br>
            <input type="number" id="quantidade_estoque" name="quantidade_estoque" required><br><br>

            <label for="id_categoria">Categoria:</label><br>
            <select id="id_categoria" name="id_categoria" required>
                <option value="">Selecione uma Categoria</option>
                <?php
                include_once __DIR__ . '/../config/db.php';
                include_once __DIR__ . '/../models/Categoria.php';

                $database = new Database();
                $db = $database->getConnection();

                $categoria = new Categoria($db);
                $categorias = $categoria->buscarTodas();

                foreach ($categorias as $cat) {
                    echo "<option value='{$cat['id_categoria']}'>{$cat['nome']}</option>";
                }
                ?>
            </select><br><br>

            <label for="id_fornecedor">Fornecedor:</label><br>
            <select id="id_fornecedor" name="id_fornecedor" required>
                <option value="">Selecione um Fornecedor</option>
                <?php
                include_once __DIR__ . '/../models/Fornecedor.php';

                $fornecedor = new Fornecedor($db);
                $fornecedores = $fornecedor->buscarTodos();

                foreach ($fornecedores as $forn) {
                    echo "<option value='{$forn['id_fornecedor']}'>{$forn['nome']}</option>";
                }
                ?>
            </select><br><br>

            <button type="submit" name="action" value="create">Cadastrar Produto</button>
        </form>

        <h2>Lista de Produtos</h2>
        <table>
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Nome</th>
                    <th>Descrição</th>
                    <th>Preço</th>
                    <th>Quantidade</th>
                    <th>ID Categoria</th>
                    <th>ID Fornecedor</th>
                    <th>Ações</th>
                </tr>
            </thead>
            <tbody>
                <?php
                // include __DIR__ . '/../config/db.php';
                include __DIR__ . '/../models/Produto.php';
                include_once __DIR__ . '/../models/DetalhePedido.php';

                // $database = new Database();
                $db = $database->getConnection();
                $produto = new Produto($db);
                $stmt = $produto->buscarTodos();


                $detalhesPedido = new DetalhesPedido($db); // Classe para verificar relação com pedidos
                
                while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                    // Verifica se o produto está relacionado a algum pedido
                    $relacionado = $detalhesPedido->verificarProdutoRelacionado($row['id_produto']);

                    echo "<tr>
                    <td>{$row['id_produto']}</td>
                    <td>{$row['nome']}</td>
                    <td>{$row['descricao']}</td>
                    <td>{$row['preco']}</td>
                    <td>{$row['quantidade_estoque']}</td>
                    <td>{$row['id_categoria']}</td>
                    <td>{$row['id_fornecedor']}</td>
                    <td>
                        <form style='display:inline;' action='/controle_de_estoque/controllers/processa_produto.php' method='POST'>
                            <input type='hidden' name='id_produto' value='{$row['id_produto']}'>
                            <button type='button' name='action' value='edit' onclick='openModal({$row['id_produto']}, \"{$row['nome']}\", \"{$row['descricao']}\", {$row['preco']}, {$row['quantidade_estoque']})'>Editar</button>
                        </form>";

                    if (!$relacionado) {
                        echo "<form style='display:inline;' action='/controle_de_estoque/controllers/processa_produto.php' method='POST' onsubmit='return confirmDelete();'>
                            <input type='hidden' name='id_produto' value='{$row['id_produto']}'>
                            <button type='submit' name='action' value='delete'>Deletar</button>
                        </form>";
                    } else {
                        echo "<span class='tooltip'>
                            <i class='info-icon'>ℹ</i>
                            <span class='tooltip-text'>Itens relacionados com vendas não podem ser deletados.</span>
                          </span>";
                    }

                    echo "</td>
                </tr>";
                }
                ?>
            </tbody>
        </table>
    </div>

    <!-- Modal de Edição do Produto -->
    <div id="editModal" class="modal">
        <div class="modal-content">
            <span class="close" onclick="closeModal()">&times;</span>
            <h2>Editar Produto</h2>
            <form action="/controle_de_estoque/controllers/processa_produto.php" method="POST">
                <input type="hidden" id="id_produto_modal" name="id_produto">
                <label for="nome_modal">Nome:</label><br>
                <input type="text" id="nome_modal" name="nome" required><br><br>

                <label for="descricao_modal">Descrição:</label><br>
                <textarea id="descricao_modal" name="descricao" required></textarea><br><br>

                <label for="preco_modal">Preço:</label><br>
                <input type="number" step="0.01" id="preco_modal" name="preco" required><br><br>

                <label for="quantidade_estoque_modal">Quantidade em Estoque:</label><br>
                <input type="number" id="quantidade_estoque_modal" name="quantidade_estoque" required><br><br>

                <!-- 
                <label for="id_categoria_modal">ID Categoria:</label><br>
                <input type="number" id="id_categoria_modal" name="id_categoria" required><br><br>

                <label for="id_fornecedor_modal">ID Fornecedor:</label><br>
                <input type="number" id="id_fornecedor_modal" name="id_fornecedor" required><br><br> -->

                <button type="submit" name="action" value="update">Atualizar Produto</button>
            </form>
        </div>
    </div>

    <script>
        // Função para abrir o modal e preencher os dados
        function openModal(id, nome, descricao, preco, quantidade_estoque) {
            // Exibe o modal
            document.getElementById("editModal").style.display = "block";

            // Preenche os campos do modal
            document.getElementById("id_produto_modal").value = id;
            document.getElementById("nome_modal").value = nome;
            document.getElementById("descricao_modal").value = descricao;
            document.getElementById("preco_modal").value = preco;
            document.getElementById("quantidade_estoque_modal").value = quantidade_estoque;
            // document.getElementById("id_categoria_modal").value = id_categoria;
            // document.getElementById("id_fornecedor_modal").value = id_fornecedor;
        }

        // Função para fechar o modal
        function closeModal() {
            console.log("Fechando o modal...");
            document.getElementById("editModal").style.display = "none";
        }

        // Alerta de confirmação para deletar
        function confirmDelete() {
            return confirm('Tem certeza de que deseja excluir este produto?');
        }
    </script>

</body>

</html>