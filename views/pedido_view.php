<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cadastro de Pedido</title>
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
    </style>
</head>

<body>

    <?php include 'menu_lateral_view.php'; ?>

    <div class="content">
        <h1>Cadastrar Pedido</h1>

        <!-- Formulário de Pedido -->
        <form class="cadastro" action="/controle_de_estoque/controllers/processa_pedido.php" method="POST">
            <label for="id_cliente">Selecione o Cliente:</label><br>
            <select id="id_cliente" name="id_cliente" required>
                <?php
                include_once __DIR__ . '/../config/db.php';
                include_once __DIR__ . '/../models/Cliente.php';

                $database = new Database();
                $db = $database->getConnection();
                $cliente = new Cliente($db);
                $clientes = $cliente->buscarTodos();

                foreach ($clientes as $cliente) {
                    echo "<option value='{$cliente['id_cliente']}'>{$cliente['nome']}</option>";
                }
                ?>
            </select><br><br>

            <label for="produtos">Selecione os Produtos:</label><br>
            <table id="produtos">
                <thead>
                    <tr>
                        <th>Produto</th>
                        <th>Quantidade</th>
                        <th>Estoque Disponível</th>
                        <th>Preço Unitário</th>
                        <th>Subtotal</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    include_once __DIR__ . '/../models/Produto.php';
                    $subtotal = 0;

                    $produto = new Produto(db: $db);
                    $produtos = $produto->buscarTodos();

                    foreach ($produtos as $produto) {
                        $produtoJson = htmlspecialchars(json_encode($produto)); // Serializa o objeto em JSON
                        $quantidade = [];
                        $quantidade = htmlspecialchars(json_encode($quantidade)); // Serializa o objeto em JSON
                    
                        echo "<tr>
                        <td>
                            <input type='checkbox' class='produto-checkbox' name='produtos[]' value='{$produtoJson}'>
                            {$produto['nome']}
                        </td>
                        <td>
                            <input type='number' class='quantidade-input' data-id='{$produto['id_produto']}' value='0' min='0'>
                        </td>
                        <td class='estoque-disponivel'>{$produto['quantidade_estoque']}</td>


                        <td class='preco-unitario'>{$produto['preco']}</td>
                        <td><span class='subtotal'>0.00</span></td>
                    </tr>";
                    }

                    ?>
                </tbody>
            </table>

            <!-- Total do Pedido -->
            <br>
            <label for="total">Total do Pedido:</label>
            <span id="total-display">0.00</span>
            <input type="hidden" name="total" id="total" value='{$subtotal}'>

            <br><br>
            <button type="submit" name="action" value="create">Cadastrar Pedido</button>
        </form>
    </div>

    <script>
        // Atualizar subtotal e total ao mudar a quantidade ou selecionar produtos
        const produtosTabela = document.querySelector('#produtos');
        const totalDisplay = document.querySelector('#total-display');
        const totalInput = document.querySelector('#total');

        function atualizarTotais() {
            let total = 0;

            // Iterar pelas linhas da tabela
            produtosTabela.querySelectorAll('tbody tr').forEach(tr => {
                const checkbox = tr.querySelector('input[type="checkbox"]');
                const quantidadeInput = tr.querySelector('input[type="number"]');
                const precoUnitario = parseFloat(tr.querySelector('.preco-unitario').textContent);
                const subtotalElement = tr.querySelector('.subtotal');

                if (checkbox.checked) {
                    const quantidade = parseFloat(quantidadeInput.value);
                    const subtotal = quantidade * precoUnitario;
                    subtotalElement.textContent = subtotal.toFixed(2);
                    total += subtotal;
                    $subtotal = total;
                } else {
                    subtotalElement.textContent = "0.00";
                }
            });

            // Atualizar o total no display e no input oculto
            totalDisplay.textContent = total.toFixed(2);
            totalInput.value = total.toFixed(2);
        }

        // Eventos para atualizar os totais
        produtosTabela.addEventListener('change', atualizarTotais);
        produtosTabela.addEventListener('input', atualizarTotais);

        atualizarTotais();


        // document.addEventListener('DOMContentLoaded', () => {
        console.log('DOM totalmente carregado!');

        const quantidadeInputs = document.querySelectorAll('.quantidade-input');
        const produtoCheckboxes = document.querySelectorAll('.produto-checkbox');

        quantidadeInputs.forEach(input => {
            input.addEventListener('input', () => {
                const produtoId = input.dataset.id; 
                const quantidade = parseInt(input.value) || 0;

                // Atualiza o JSON no checkbox correspondente
                produtoCheckboxes.forEach(checkbox => {
                    const produto = JSON.parse(checkbox.value); 
                    if (produto.id_produto == produtoId) {
                        produto.quantidade_compra = quantidade; 
                        console.log('produto:', produto);
                        checkbox.value = JSON.stringify(produto); 

                    }
                });
            });
            // });
        });

        function validarQuantidade(input) {
            const estoqueDisponivel = parseFloat(input.dataset.estoque);
            if (parseFloat(input.value) > estoqueDisponivel) {
                alert("Quantidade maior do que o estoque disponível!");
                input.value = estoqueDisponivel;
            }
        }

        produtosTabela.addEventListener('change', atualizarTotais);
        produtosTabela.addEventListener('input', event => {
            if (event.target.classList.contains('quantidade-input')) {
                validarQuantidade(event.target);
                atualizarTotais();
            }
        });

    </script>

</body>

</html>