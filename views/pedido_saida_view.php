<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Últimas Saídas do Estoque</title>
    <style>
        body {
            font-family: Arial, sans-serif;
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
        <h1>Últimas Saídas do Estoque</h1>

        <table>
            <thead>
                <tr>
                    <th>Produto</th>
                    <th>Quantidade Vendida</th>
                    <th>Cliente</th>
                    <th>Data da Venda</th>
                </tr>
            </thead>
            <tbody>
                <?php
                include __DIR__ . '/../config/db.php';
                include __DIR__ . '/../models/Produto.php';
                include __DIR__ . '/../models/Pedido.php';

                $database = new Database();
                $db = $database->getConnection();

                // Obter as últimas saídas do estoque
                $query = "
                    SELECT 
                        p.nome AS produto_nome, 
                        dp.quantidade AS quantidade_vendida, 
                        c.nome AS cliente_nome, 
                        ped.data_criacao AS data_venda
                    FROM detalhespedido dp
                    JOIN produtos p ON dp.id_produto = p.id_produto
                    JOIN pedidos ped ON dp.id_pedido = ped.id_pedido
                    JOIN clientes c ON ped.id_cliente = c.id_cliente
                    ORDER BY ped.data_criacao DESC
                    LIMIT 10";

                $stmt = $db->prepare($query);
                $stmt->execute();

                while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                    echo "<tr>
                        <td>{$row['produto_nome']}</td>
                        <td>{$row['quantidade_vendida']}</td>
                        <td>{$row['cliente_nome']}</td>
                        <td>{$row['data_venda']}</td>
                    </tr>";
                }
                ?>
            </tbody>
        </table>
    </div>
</body>

</html>
s