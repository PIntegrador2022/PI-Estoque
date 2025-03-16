<?php
    session_start();

    if (isset($_SESSION['usuario'])){
        header("Location: /dashboard.php");
        exit();
    }
?>
<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>PI Estoque</title>
    <link rel="stylesheet" href="../assets/css/style.css">
</head>
<body>
    <div class="login-container">
        <h2>Login</h2>

        <?php if (isset($_GET['erro']) && $_GET['erro'] == 1): ?>
        <p class="error">Usuário ou senha inválidos!</p>
        <?php endif; ?>

        <form action="../includes/autenticar.php" method="POST"> 
            <label for="usuario">Usuário</label>
            <input type="text" name="usuario" require>

            <label for="senha">Senha</label>
            <input type="password" name="senha" require>

            <button type="submit">Entrar</button>
        </form>
    </div>
</body>
</html>