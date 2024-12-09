<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gerenciamento de Fornecedores</title>
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
        <h1>Gerenciamento de Fornecedores</h1>

        <!-- Formulário de Cadastro -->
        <form class="cadastro" action='/controle_de_estoque/controllers/processa_fornecedor.php' method="POST">
            <input type="hidden" id="id_fornecedor" name="id_fornecedor">

            <label for="nome">Nome:</label><br>
            <input type="text" id="nome" name="nome" required><br><br>

            <label for="contato">Contato:</label><br>
            <input type="text" id="contato" name="contato"><br><br>

            <label for="telefone">Telefone:</label><br>
            <input type="text" id="telefone" name="telefone"><br><br>

            <label for="email">E-mail:</label><br>
            <input type="email" id="email" name="email"><br><br>

            <label for="endereco">Endereço:</label><br>
            <textarea id="endereco" name="endereco"></textarea><br><br>

            <button type="submit" name="action" value="create">Cadastrar Fornecedor</button>
        </form>

        <!-- Lista de Fornecedores -->
        <h2>Lista de Fornecedores</h2>
        <table>
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Nome</th>
                    <th>Contato</th>
                    <th>Telefone</th>
                    <th>E-mail</th>
                    <th>Endereço</th>
                    <th>Data de Criação</th>
                    <th>Ações</th>
                </tr>
            </thead>
            <tbody>
                <?php
                include __DIR__ . '/../config/db.php';
                include __DIR__ . '/../models/Fornecedor.php';

                $database = new Database();
                $db = $database->getConnection();
                $fornecedor = new Fornecedor($db);
                $stmt = $fornecedor->buscarTodos();

                while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                    echo "<tr>
                        <td>{$row['id_fornecedor']}</td>
                        <td>{$row['nome']}</td>
                        <td>{$row['contato']}</td>
                        <td>{$row['telefone']}</td>
                        <td>{$row['email']}</td>
                        <td>{$row['endereco']}</td>
                        <td>{$row['data_criacao']}</td>
                        <td>
                            <button type='button' onclick='openModal({$row['id_fornecedor']}, \"{$row['nome']}\", \"{$row['contato']}\", \"{$row['telefone']}\", \"{$row['email']}\", \"{$row['endereco']}\")'>Editar</button>
                            <form style='display:inline;' action='/controle_de_estoque/controllers/processa_fornecedor.php' method='POST' onsubmit='return confirmDelete();'>
                                <input type='hidden' name='id_fornecedor' value='{$row['id_fornecedor']}'>
                                <button type='submit' name='action' value='delete'>Deletar</button>
                            </form>
                        </td>
                      </tr>";
                }
                ?>
            </tbody>
        </table>
    </div>

    <!-- Modal de Edição -->
    <div id="editModal" class="modal">
        <div class="modal-content">
            <span class="close" onclick="closeModal()">&times;</span>
            <h2>Editar Fornecedor</h2>
            <form action="/controle_de_estoque/controllers/processa_fornecedor.php" method="POST">
                <input type="hidden" id="id_fornecedor_modal" name="id_fornecedor">

                <label for="nome_modal">Nome:</label><br>
                <input type="text" id="nome_modal" name="nome" required><br><br>

                <label for="contato_modal">Contato:</label><br>
                <input type="text" id="contato_modal" name="contato"><br><br>

                <label for="telefone_modal">Telefone:</label><br>
                <input type="text" id="telefone_modal" name="telefone"><br><br>

                <label for="email_modal">E-mail:</label><br>
                <input type="email" id="email_modal" name="email"><br><br>

                <label for="endereco_modal">Endereço:</label><br>
                <textarea id="endereco_modal" name="endereco"></textarea><br><br>

                <button type="submit" name="action" value="update">Atualizar Fornecedor</button>
            </form>
        </div>
    </div>

    <script>
        // Função para abrir o modal e preencher os dados
        function openModal(id, nome, contato, telefone, email, endereco) {
            document.getElementById("editModal").style.display = "block";
            document.getElementById("id_fornecedor_modal").value = id;
            document.getElementById("nome_modal").value = nome;
            document.getElementById("contato_modal").value = contato;
            document.getElementById("telefone_modal").value = telefone;
            document.getElementById("email_modal").value = email;
            document.getElementById("endereco_modal").value = endereco;
        }

        // Função para fechar o modal
        function closeModal() {
            document.getElementById("editModal").style.display = "none";
        }

        // Confirmação antes de excluir
        function confirmDelete() {
            return confirm('Tem certeza de que deseja excluir este fornecedor?');
        }
    </script>
</body>

</html>
