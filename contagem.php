<?php
session_start();
include_once 'db/connect.php';

// Verifica se o usuário está logado
if (!isset($_SESSION['usuario_id'])) {
    header("Location: index.php");
    exit;
}

$nivel_acesso = $_SESSION['nivel_acesso'];

// Processa a atualização da quantidade via GET (botões + e -)
if ($_SERVER['REQUEST_METHOD'] == 'GET' && isset($_GET['acao']) && isset($_GET['id'])) {
    $produto_id = $_GET['id'];
    $acao = $_GET['acao']; // 'adicionar' ou 'remover'

    // Busca a quantidade atual do produto
    $stmt = $pdo->prepare("SELECT quantidade FROM produtos WHERE id = ?");
    $stmt->execute([$produto_id]);
    $produto = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($produto) {
        $nova_quantidade = $produto['quantidade'];
        if ($acao == 'adicionar') {
            $nova_quantidade += 1;
        } elseif ($acao == 'remover' && $nova_quantidade > 0) {
            $nova_quantidade -= 1;
        }

        // Atualiza a quantidade no banco de dados
        $stmt = $pdo->prepare("UPDATE produtos SET quantidade = ? WHERE id = ?");
        $stmt->execute([$nova_quantidade, $produto_id]);

        // Redireciona para evitar reenvio do formulário ao recarregar a página
        header("Location: contagem.php");
        exit;
    }
}

// Buscar todos os produtos
$stmt = $pdo->query("SELECT * FROM produtos");
$produtos = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Contagem de Produtos</title>
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
                <h2>Contagem de Produtos</h2>

                <!-- Lista de Produtos -->
                <table>
                    <thead>
                        <tr>
                            <th>Nome</th>
                            <th>Quantidade Atual</th>
                            <th>Ações</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($produtos as $produto): ?>
                            <tr>
                                <td><?= htmlspecialchars($produto['nome']) ?></td>
                                <td><?= $produto['quantidade'] ?></td>
                                <td>
                                    <!-- Botão "+" -->
                                    <a href="?acao=adicionar&id=<?= $produto['id'] ?>" class="btn btn-success">+</a>
                                    <!-- Botão "-" -->
                                    <a href="?acao=remover&id=<?= $produto['id'] ?>" class="btn btn-danger">-</a>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        </main>
    </div>
    <script src="js/scripts.js"></script>
</body>
</html>