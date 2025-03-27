<?php
session_start();
include_once 'db/connect.php';

// Verifica se o usuário está logado e é admin
if (!isset($_SESSION['usuario_id']) || $_SESSION['nivel_acesso'] != 'admin') {
    header("Location: index.php");
    exit;
}

// Buscar o nome do usuário logado
$stmt = $pdo->prepare("SELECT nome FROM usuarios WHERE id = ?");
$stmt->execute([$_SESSION['usuario_id']]);
$usuario_logado = $stmt->fetch(PDO::FETCH_ASSOC);

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
          <?php include_once 'includes/sidebar.php'; ?>

        <!-- Conteúdo Principal -->
        <main class="content">


        <!-- Cabeçalho -->
        <header class="header">
                <div class="logo">
                    <img src="https://bluefocus.com.br/sites/default/files/styles/medium/public/estoque.png?itok=1yVi8VcO" alt="Logo" width="50"> 
                </div>
                <div class="user-info">
                    <span class="user-name">Olá, <?= htmlspecialchars($usuario_logado['nome']) ?></span>
                    <div class="dropdown-menu">
                        <a href="editar-perfil.php">Editar Perfil</a>
                        <a href="logout.php">Sair</a>
                    </div>
                </div>
            </header>

            <h2>Cadastro de Usuário</h2>
            <form method="POST">
                <input type="text" name="nome" placeholder="Nome do Usuário" required>
                <input type="text" name="login" placeholder="Login do Usuário" required>
                <input type="password" name="senha" placeholder="Senha do Usuário" required>
                <select class="select-user" name="nivel_acesso" required>
                    <option value="admin">Admin</option>
                    <option value="usuario">Usuário</option>
                </select>
                <button type="submit">Cadastrar Usuário</button>
            </form>
        </main>
    </div>

    <script src="js/scripts.js"></script>
</body>
</html>