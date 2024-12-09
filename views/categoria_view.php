<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gerenciamento de Categorias</title>
    <style>
        body {
            font-family: Arial, sans-serif;
        }

        form.cadastro {
            margin-bottom: 20px;
            background: #f9f9f9;
            padding: 15px;
            border: 1px solid #ddd;
            border-radius: 5px;
        }

        table {
            width: 100%;
            border-collapse: collapse;
        }

        table,
        th,
        td {
            border: 1px solid #ddd;
        }

        th,
        td {
            padding: 10px;
            text-align: left;
        }

        th {
            background-color: #f2f2f2;
        }

        /* Modal de Atualização */
        .modal {
            display: none;
            position: fixed;
            z-index: 1;
            left: 0;
            top: 0;
            width: 100%;
            height: 100%;
            overflow: auto;
            background-color: rgba(0, 0, 0, 0.4);
            padding-top: 60px;
        }

        .modal-content {
            background-color: #fefefe;
            margin: 5% auto;
            padding: 20px;
            border: 1px solid #888;
            width: 80%;
            max-width: 600px;
        }

        .close {
            color: #aaa;
            float: right;
            font-size: 28px;
            font-weight: bold;
        }

        .close:hover,
        .close:focus {
            color: black;
            text-decoration: none;
            cursor: pointer;
        }
    </style>
</head>

<body>
    <?php include 'menu_lateral_view.php'; ?>

    <div class="content">
        <h1>Gerenciamento de Categorias</h1>

        <!-- Formulário para cadastro de categorias -->
        <form class="cadastro" action='/controle_de_estoque/controllers/processa_categoria.php' method="POST">
            <input type="hidden" id="id_categoria" name="id_categoria">

            <label for="nome">Nome:</label><br>
            <input type="text" id="nome" name="nome" required><br><br>

            <label for="descricao">Descrição:</label><br>
            <textarea id="descricao" name="descricao"></textarea><br><br>

            <button type="submit" name="action" value="create">Cadastrar Categoria</button>
        </form>

        <h2>Lista de Categorias</h2>
        <table>
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Nome</th>
                    <th>Descrição</th>
                    <th>Data de Criação</th>
                    <th>Ações</th>
                </tr>
            </thead>
            <tbody>
                <?php
                include __DIR__ . '/../config/db.php';
                include __DIR__ . '/../models/Categoria.php';

                $database = new Database();
                $db = $database->getConnection();
                $categoria = new Categoria($db);
                $stmt = $categoria->buscarTodas();

                while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                    echo "<tr>
                        <td>{$row['id_categoria']}</td>
                        <td>{$row['nome']}</td>
                        <td>{$row['descricao']}</td>
                        <td>{$row['data_criacao']}</td>
                        <td>
                            <button type='button' onclick='openModal({$row['id_categoria']}, \"{$row['nome']}\", \"{$row['descricao']}\")'>Editar</button>
                            <form style='display:inline;' action='/controle_de_estoque/controllers/processa_categoria.php' method='POST' onsubmit='return confirmDelete();'>
                                <input type='hidden' name='id_categoria' value='{$row['id_categoria']}'>
                                <button type='submit' name='action' value='delete'>Deletar</button>
                            </form>
                        </td>
                      </tr>";
                }
                ?>
            </tbody>
        </table>
    </div>

    <!-- Modal de Edição de Categorias -->
    <div id="editModal" class="modal">
        <div class="modal-content">
            <span class="close" onclick="closeModal()">&times;</span>
            <h2>Editar Categoria</h2>
            <form action="/controle_de_estoque/controllers/processa_categoria.php" method="POST">
                <input type="hidden" id="id_categoria_modal" name="id_categoria">

                <label for="nome_modal">Nome:</label><br>
                <input type="text" id="nome_modal" name="nome" required><br><br>

                <label for="descricao_modal">Descrição:</label><br>
                <textarea id="descricao_modal" name="descricao"></textarea><br><br>

                <button type="submit" name="action" value="update">Atualizar Categoria</button>
            </form>
        </div>
    </div>

    <script>
        // Função para abrir o modal e preencher os dados
        function openModal(id, nome, descricao) {
            document.getElementById("editModal").style.display = "block";
            document.getElementById("id_categoria_modal").value = id;
            document.getElementById("nome_modal").value = nome;
            document.getElementById("descricao_modal").value = descricao;
        }

        // Função para fechar o modal
        function closeModal() {
            document.getElementById("editModal").style.display = "none";
        }

        // Alerta de confirmação para deletar
        function confirmDelete() {
            return confirm('Tem certeza de que deseja excluir esta categoria?');
        }
    </script>
</body>

</html>
