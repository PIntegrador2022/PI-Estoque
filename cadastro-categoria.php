<?php
session_start();
include_once 'db/connect.php';

// Verifica se o usuário está logado
if (!isset($_SESSION['usuario_id'])) {
    header("Location: index.php");
    exit;
}

$nivel_acesso = $_SESSION['nivel_acesso'];

// Processa o formulário de cadastro de categoria
$mensagem = ''; // Variável para armazenar a mensagem
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $nome = trim($_POST['nome']);

    if (empty($nome)) {
        $mensagem = "<p style='color:red;'>O nome da categoria é obrigatório.</p>";
    } else {
        // Insere a categoria no banco de dados
        $stmt = $pdo->prepare("INSERT INTO categorias (nome) VALUES (?)");
        $stmt->execute([$nome]);

        $mensagem = "<p style='color:green;'>Categoria cadastrada com sucesso!</p>";
    }
}
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cadastro de Categoria</title>
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
                    <span class="user-name"><?= htmlspecialchars($_SESSION['nome']) ?></span>
                    <div class="dropdown-menu">
                        <a href="editar-perfil.php">Editar Perfil</a>
                        <a href="logout.php">Sair</a>
                    </div>
                </div>
                <button class="menu-toggle" id="menuToggle">&#9776;</button>
            </header>

            <!-- Área de Mensagens -->
            <?php if (!empty($mensagem)): ?>
                <div class="message-container <?= strpos($mensagem, 'sucesso') !== false ? 'success' : 'error' ?>">
                    <?= $mensagem ?>
                </div>
            <?php endif; ?>

            <!-- Área de Scroll -->
            <div class="scrollable-content">
                <!-- Título da Página -->
                <h2>Cadastro de Categoria</h2>

                <!-- Formulário de Cadastro -->
                <form method="POST">
                    <label for="nome">Nome da Categoria:</label>
                    <input type="text" name="nome" id="nome" required>
                    <button type="submit">Cadastrar</button>
                </form>
            </div>
        </main>
    </div>
    <script src="js/scripts.js"></script>
</body>
</html>