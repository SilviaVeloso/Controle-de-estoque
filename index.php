<?php
session_start();

// Verifica se o usuário está logado
if (!isset($_SESSION['usuario'])) {
    header('Location: login.php');
    exit;
}

// Se o usuário estiver logado, exibe o conteúdo da página
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Página Inicial</title>
</head>

<body>
    <?php include './views/menu_lateral_view.php'; ?>

    <div class="content">
        <h1>Bem-vindo, <?= $_SESSION['usuario']['nome'] ?>!</h1>
        <p>Este é o conteúdo da sua aplicação.</p>
        <a href="logout.php">Sair</a>
    </div>
</body>

</html>
