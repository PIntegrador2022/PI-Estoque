<?php
session_start();
include_once 'db/connect.php';

// Verifica se o usuário está logado
if (!isset($_SESSION['usuario_id'])) {
    header("Location: index.php");
    exit;
}

// Garante que o nome do usuário está definido na sessão
if (!isset($_SESSION['nome'])) {
    // Busca o nome do usuário no banco de dados, caso não esteja na sessão
    $stmt = $pdo->prepare("SELECT nome FROM usuarios WHERE id = ?");
    $stmt->execute([$_SESSION['usuario_id']]);
    $usuario_logado = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($usuario_logado) {
        $_SESSION['nome'] = $usuario_logado['nome']; // Salva o nome na sessão
    } else {
        // Redireciona para a página de login se o usuário não for encontrado
        session_destroy();
        header("Location: index.php");
        exit;
    }
}

$nivel_acesso = $_SESSION['nivel_acesso'];

// Buscar o total de usuários
$stmt = $pdo->query("SELECT COUNT(*) AS total_usuarios FROM usuarios");
$total_usuarios = $stmt->fetch(PDO::FETCH_ASSOC)['total_usuarios'];

// Buscar o total de produtos
$stmt = $pdo->query("SELECT COUNT(*) AS total_produtos FROM produtos");
$total_produtos = $stmt->fetch(PDO::FETCH_ASSOC)['total_produtos'];

// Buscar o valor total dos produtos
$stmt = $pdo->query("SELECT SUM(preco * quantidade) AS valor_total_produtos FROM produtos");
$valor_total_produtos = $stmt->fetch(PDO::FETCH_ASSOC)['valor_total_produtos'];
$valor_total_produtos = number_format($valor_total_produtos, 2, ',', '.');

// Consulta para produtos com estoque baixo
$stmt = $pdo->query("SELECT * FROM produtos WHERE quantidade <= estoque_minimo");
$produtos_baixo_estoque = $stmt->fetchAll(PDO::FETCH_ASSOC);
$total_baixo_estoque = count($produtos_baixo_estoque);
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard</title>
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
                    <span class="user-name">Olá, <?= htmlspecialchars($_SESSION['nome']) ?></span>
                    <div class="dropdown-menu">
                        <a href="editar-perfil.php">Editar Perfil</a>
                        <a href="logout.php">Sair</a>
                    </div>
                </div>
                <button class="menu-toggle" id="menuToggle">&#9776;</button>
            </header>

            <!-- Cards do Dashboard -->
            <h2>Painel de Controle</h2>
            <div class="cards-container">
                <div class="card">
                    <h3>Total de Usuários</h3>
                    <p><?= $total_usuarios ?></p>
                </div>
                <div class="card">
                    <h3>Total de Produtos</h3>
                    <p><?= $total_produtos ?></p>
                </div>
                <div class="card">
                    <h3>Valor Total dos Produtos</h3>
                    <p>R$ <?= $valor_total_produtos ?></p>
                </div>

                <!-- Card de Alerta de Estoque Baixo (Visível no Desktop) -->
                <div class="card desktop-card">
                    <h3>Alerta de Estoque Baixo</h3>
                    <?php if ($total_baixo_estoque > 0): ?>
                        <ul>
                            <?php foreach ($produtos_baixo_estoque as $produto): ?>
                                <li>
                                    <?= htmlspecialchars($produto['nome']) ?> 
                                    (Quantidade: <?= $produto['quantidade'] ?>/<?= $produto['estoque_minimo'] ?>)
                                </li>
                            <?php endforeach; ?>
                        </ul>
                    <?php else: ?>
                        <p>Nenhum produto com estoque baixo.</p>
                    <?php endif; ?>
                </div>

                <!-- Mensagem de Alerta de Estoque Baixo (Visível no Mobile) -->
                <div class="card mobile-message">
                    <h3>Alerta de Estoque Baixo</h3>
                    <?php if ($total_baixo_estoque > 0): ?>
                        <p>Há <?= $total_baixo_estoque ?> produto(s) com estoque baixo.</p>
                    <?php else: ?>
                        <p>Nenhum produto com estoque baixo.</p>
                    <?php endif; ?>
                </div>
            </div>
        </main>
    </div>

    <script src="js/scripts.js"></script>
</body>
</html>