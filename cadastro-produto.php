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

            <!-- Seleção de Categoria -->
            <label for="categoria_id">Categoria:</label>
            <select name="categoria_id" id="categoria_id" required>
                <option value="">Selecione uma categoria</option>
                <?php
                $stmt = $pdo->query("SELECT * FROM categorias");
                $categorias = $stmt->fetchAll(PDO::FETCH_ASSOC);
                foreach ($categorias as $categoria): ?>
                    <option value="<?= $categoria['id'] ?>"><?= htmlspecialchars($categoria['nome']) ?></option>
                <?php endforeach; ?>
            </select>

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



    <script src="js/scripts.js"></script>


</body>

</html>