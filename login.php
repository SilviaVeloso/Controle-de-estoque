<?php
session_start();
include_once __DIR__ . '/config/db.php';

// Verifica se o formulário foi enviado
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = $_POST['email'];
    $senha = $_POST['senha'];

    $database = new Database();
    $db = $database->getConnection();

    // Verifica as credenciais
    $query = "SELECT id_usuario, nome FROM usuarios WHERE email = :email AND senha = :senha";
    $stmt = $db->prepare($query);
    $stmt->bindParam(':email', $email);
    $stmt->bindParam(':senha', md5($senha)); // Use hash seguro em produção (ex: password_hash)
    $stmt->execute();

    $user = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($user) {
        // Login bem-sucedido
        $_SESSION['usuario'] = [
            'id' => $user['id_usuario'],
            'nome' => $user['nome'],
        ];
        header('Location: index.php');
        exit;
    } else {
        $erro = "E-mail ou senha inválidos.";
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            margin: 0;
            background-color: #f2f2f2;
        }

        .login-form {
            background: #fff;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }

        .login-form h1 {
            margin-bottom: 20px;
        }

        .login-form input {
            width: 90%;
            padding: 10px;
            margin-bottom: 15px;
            border: 1px solid #ddd;
            border-radius: 5px;
        }

        .login-form button {
            width: 90%;
            padding: 10px;
            background-color: #225c22;
            color: #ecf0f1;
            color: #fff;
            border: none;
            border-radius: 5px;
            cursor: pointer;
        }

        .login-form button:hover {
            background: #0056b3;
        }

        .error {
            color: red;
            margin-bottom: 10px;
        }
    </style>
</head>

<body>
    <form class="login-form" method="POST" action="login.php">
        <h1>Login</h1>
        <?php if (isset($erro)): ?>
            <div class="error"><?= $erro ?></div>
        <?php endif; ?>
        <input type="email" name="email" placeholder="E-mail" required>
        <input type="password" name="senha" placeholder="Senha" required>
        <button type="submit">Entrar</button>
    </form>
</body>

</html>
