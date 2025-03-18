<?php
session_start();
include_once 'db/connect.php';

// Verifica se o usuário está logado e é admin
if (!isset($_SESSION['usuario_id']) || $_SESSION['nivel_acesso'] != 'admin') {
    header("Location: index.php");
    exit;
}

// Processa o formulário de cadastro de usuário
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $nome = $_POST['nome'];
    $login = $_POST['login'];
    $senha = md5($_POST['senha']);
    $nivel_acesso = $_POST['nivel_acesso'];

    // Insere o usuário no banco de dados
    $stmt = $pdo->prepare("INSERT INTO usuarios (nome, login, senha, nivel_acesso) VALUES (?, ?, ?, ?)");
    $stmt->execute([$nome, $login, $senha, $nivel_acesso]);

    // Redireciona para o dashboard após o cadastro
    header("Location: dashboard.php");
    exit;
}
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cadastro de Usuário</title>
    <link rel="stylesheet" href="css/style.css">
</head>
<body>
    <div class="container">
        <!-- Sidebar -->
        <aside class="sidebar">
            <h2>Menu</h2>
            <ul>
                <li><a href="dashboard.php">Dashboard</a></li>
                <li><a href="cadastro-produto.php">Cadastrar Produto</a></li>
                <li><a href="cadastro-usuario.php">Cadastrar Usuário</a></li>
                <li><a href="listagem-usuarios.php">Listar Usuários</a></li>
                <li><a href="logout.php">Sair</a></li>
            </ul>
        </aside>

        <!-- Conteúdo Principal -->
        <main class="content">
            <h2>Cadastro de Usuário</h2>
            <form method="POST">
                <input type="text" name="nome" placeholder="Nome do Usuário" required>
                <input type="text" name="login" placeholder="Login do Usuário" required>
                <input type="password" name="senha" placeholder="Senha do Usuário" required>
                <select name="nivel_acesso" required>
                    <option value="admin">Admin</option>
                    <option value="usuario">Usuário</option>
                </select>
                <button type="submit">Cadastrar Usuário</button>
            </form>
        </main>
    </div>
</body>
</html>