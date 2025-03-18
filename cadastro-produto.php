<?php
session_start();
include_once 'db/connect.php';

// Verifica se o usuário está logado e é admin
if (!isset($_SESSION['usuario_id']) || $_SESSION['nivel_acesso'] != 'admin') {
    header("Location: index.php");
    exit;
}

// Processa o formulário de cadastro de produto
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $nome = $_POST['nome'];
    $descricao = $_POST['descricao'];
    $quantidade = $_POST['quantidade'];
    $preco = $_POST['preco'];

    // Insere o produto no banco de dados
    $stmt = $pdo->prepare("INSERT INTO produtos (nome, descricao, quantidade, preco) VALUES (?, ?, ?, ?)");
    $stmt->execute([$nome, $descricao, $quantidade, $preco]);

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
    <title>Cadastro de Produto</title>
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
            <h2>Cadastro de Produto</h2>
            <form method="POST">
                <input type="text" name="nome" placeholder="Nome do Produto" required>
                <textarea name="descricao" placeholder="Descrição do Produto"></textarea>
                <input type="number" name="quantidade" placeholder="Quantidade" required>
                <input type="number" step="0.01" name="preco" placeholder="Preço" required>
                <button type="submit">Cadastrar Produto</button>
            </form>
        </main>
    </div>
</body>
</html>