<div class="sidebar">
    <h2>Gerenciamento</h2>
    <ul>
        <li><a href="/controle_de_estoque/index.php">Home</a></li>
        <li><a href="/controle_de_estoque/views/produto_view.php">Produtos</a></li>
        <li><a href="/controle_de_estoque/views/categoria_view.php">Categorias</a></li>
        <li><a href="/controle_de_estoque/views/fornecedor_view.php">Fornecedores</a></li>
        <li><a href="/controle_de_estoque/views/cliente_view.php">Clientes</a></li>
        <li><a href="/controle_de_estoque/views/pedido_view.php">Pedidos</a></li>
        <li><a href="/controle_de_estoque/views/pedido_saida_view.php">Saidas</a></li>
    </ul>
</div>

<style>
    body {
        margin: 0;
        font-family: Arial, sans-serif;
    }

    /* Menu lateral */
    .sidebar {
        width: 250px;
        background-color: #225c22;
        color: #ecf0f1;
        height: 100vh;
        position: fixed;
        padding: 20px 0;
    }

    .sidebar h2 {
        text-align: center;
        margin-bottom: 20px;
        font-size: 1.5em;
    }

    .sidebar ul {
        list-style: none;
        padding: 0;
        margin: 0;
    }

    .sidebar ul li {
        padding: 15px 20px;
    }

    .sidebar ul li a {
        color: #ecf0f1;
        text-decoration: none;
        display: block;
    }

    .sidebar ul li a:hover {
        /* background-color: #34495e; */
        border-radius: 4px;
    }

    /* Conteúdo principal */
    .content {
        margin-left: 250px; /* Margem para empurrar o conteúdo */
        padding: 20px;
    }
</style>


<!-- <div class="sidebar">
    <h2>Gerenciamento</h2>
    <ul>
        <li>
            <a href="javascript:void(0);" class="menu-toggle">Produtos</a>
            <ul class="submenu">
                <li><a href="/controle_de_estoque/views/produto_view.php">Listar Produtos</a></li>
                <li><a href="/controle_de_estoque/views/produto_adicionar.php">Adicionar Produto</a></li>
            </ul>
        </li>
        <li>
            <a href="javascript:void(0);" class="menu-toggle">Categorias</a>
            <ul class="submenu">
                <li><a href="/controle_de_estoque/views/categoria_view.php">Listar Categorias</a></li>
                <li><a href="/controle_de_estoque/views/categoria_adicionar.php">Adicionar Categoria</a></li>
            </ul>
        </li>
        <li><a href="/controle_de_estoque/views/fornecedor_view.php">Fornecedores</a></li>
        <li><a href="/controle_de_estoque/views/cliente_view.php">Clientes</a></li>
        <li><a href="/controle_de_estoque/views/pedido_view.php">Pedidos</a></li>
    </ul>
</div>

<style>
    body {
        margin: 0;
        font-family: Arial, sans-serif;
    }

    /* Menu lateral */
    .sidebar {
        width: 250px;
        background-color: #2c3e50;
        color: #ecf0f1;
        height: 100vh;
        position: fixed;
        padding: 20px 0;
    }

    .sidebar h2 {
        text-align: center;
        margin-bottom: 20px;
        font-size: 1.5em;
    }

    .sidebar ul {
        list-style: none;
        padding: 0;
        margin: 0;
    }

    .sidebar ul li {
        padding: 15px 20px;
        position: relative;
    }

    .sidebar ul li a {
        color: #ecf0f1;
        text-decoration: block;
        display: block;
    }

    .sidebar ul li a:hover {
        background-color: #34495e;
        border-radius: 4px;
    }

    .submenu {
        display: block; /* Esconde o submenu por padrão */
        padding-left: 20px;
    }

    .submenu li a {
        background-color: #34495e;
    }

    .submenu li a:hover {
        background-color: #16a085;
    }

    /* Conteúdo principal */
    .content {
        margin-left: 250px;
        padding: 20px;
    }
</style>

<script>
    // Adicionar interação para exibir/ocultar submenus
    const menuToggles = document.querySelectorAll('.menu-toggle');

    menuToggles.forEach(toggle => {
        toggle.addEventListener('click', () => {
            const submenu = toggle.nextElementSibling;
            submenu.style.display = (submenu.style.display === 'block') ? 'none' : 'block';
        });
    });
</script> -->
