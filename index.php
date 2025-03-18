<?php
session_start();
include_once 'db/connect.php';

// Processa o formulário de login
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $login = $_POST['login'];
    $senha = md5($_POST['senha']);

    // Verifica se o login e senha estão corretos
    $stmt = $pdo->prepare("SELECT * FROM usuarios WHERE login = ? AND senha = ?");
    $stmt->execute([$login, $senha]);
    $usuario = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($usuario) {
        // Inicia a sessão e redireciona para o dashboard
        $_SESSION['usuario_id'] = $usuario['id'];
        $_SESSION['nivel_acesso'] = $usuario['nivel_acesso'];
        header("Location: dashboard.php");
        exit;
    } else {
        // Define uma variável de erro para exibir a mensagem
        $erro = "Login ou senha inválidos!";
    }
}
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <link rel="stylesheet" href="css/login.css"> <!-- Link para o CSS específico -->
</head>
<body>
    <div class="login-container">
        <h2>Login</h2>
        <?php if (isset($erro)): ?>
            <p><?= htmlspecialchars($erro) ?></p> <!-- Exibe a mensagem de erro -->
        <?php endif; ?>
        <form method="POST">
            <input type="text" name="login" placeholder="Login" required>
            <input type="password" name="senha" placeholder="Senha" required>
            <button type="submit">Entrar</button>
        </form>
    </div>
</body>
</html>