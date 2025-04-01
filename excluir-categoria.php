<?php
session_start();
include_once 'db/connect.php';

// Verifica se o usuário está logado
if (!isset($_SESSION['usuario_id'])) {
    header("Location: index.php");
    exit;
}

$nivel_acesso = $_SESSION['nivel_acesso'];

// Verifica se o ID da categoria foi fornecido via GET
if (!isset($_GET['id']) || empty($_GET['id'])) {
    header("Location: listagem-categorias.php");
    exit;
}

$categoria_id = $_GET['id'];

// Busca os dados da categoria no banco de dados
$stmt = $pdo->prepare("SELECT * FROM categorias WHERE id = ?");
$stmt->execute([$categoria_id]);
$categoria = $stmt->fetch(PDO::FETCH_ASSOC);

if (!$categoria) {
    echo "<p style='color:red;'>Categoria não encontrada.</p>";
    exit;
}

// Verifica se a categoria está associada a algum produto
$stmt = $pdo->prepare("SELECT COUNT(*) AS total_produtos FROM produtos WHERE categoria_id = ?");
$stmt->execute([$categoria_id]);
$total_produtos = $stmt->fetch(PDO::FETCH_ASSOC)['total_produtos'];

if ($total_produtos > 0) {
    echo "<p style='color:red;'>Não é possível excluir esta categoria porque ela está associada a $total_produtos produto(s).</p>";
    echo "<a href='listagem-categorias.php'>Voltar</a>";
    exit;
}

// Exclui a categoria do banco de dados
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $stmt = $pdo->prepare("DELETE FROM categorias WHERE id = ?");
    $stmt->execute([$categoria_id]);

    header("Location: listagem-categorias.php");
    exit;
}
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Excluir Categoria</title>
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
            </header>

            <!-- Área de Scroll -->
            <div class="scrollable-content">
                <!-- Título da Página -->
                <h2>Excluir Categoria</h2>

                <p>Você está prestes a excluir a categoria <strong><?= htmlspecialchars($categoria['nome']) ?></strong>.</p>
                <p>Esta ação não pode ser desfeita. Deseja continuar?</p>

                <!-- Formulário de Confirmação -->
                <form method="POST">
                    <button type="submit">Confirmar Exclusão</button>
                    <a href="listagem-categorias.php">Cancelar</a>
                </form>
            </div>
        </main>
    </div>
    <script src="js/scripts.js"></script>
</body>
</html>