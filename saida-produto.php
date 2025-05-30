<?php
session_start();
include_once 'db/connect.php';

// Verifica se o usuário está logado
if (!isset($_SESSION['usuario_id'])) {
    header("Location: index.php");
    exit;
}

$nivel_acesso = $_SESSION['nivel_acesso'];

// Inicializa a variável de busca
$busca = isset($_GET['busca']) ? trim($_GET['busca']) : '';

// Consulta os produtos com base na busca
if ($busca) {
    // Filtra por nome ou ID (código)
    $stmt = $pdo->prepare("SELECT * FROM produtos WHERE id = :id OR nome LIKE :nome");
    $stmt->bindValue(':id', $busca, PDO::PARAM_INT);
    $stmt->bindValue(':nome', '%' . $busca . '%', PDO::PARAM_STR);
    $stmt->execute();
} else {
    // Se não houver busca, lista todos os produtos
    $stmt = $pdo->query("SELECT * FROM produtos");
}
$produtos = $stmt->fetchAll(PDO::FETCH_ASSOC);

// Variável para armazenar a mensagem
$mensagem = '';

// Processa o formulário de saída de produtos
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $produto_id = $_POST['produto_id'];
    $quantidade_retirada = (int)$_POST['quantidade_retirada'];
    $data_movimentacao = $_POST['data_movimentacao'];

    // Verifica se a quantidade é válida
    if ($quantidade_retirada <= 0) {
        $mensagem = "<p style='color:red;'>A quantidade deve ser maior que zero.</p>";
    } else {
        // Busca a quantidade atual do produto no banco de dados
        $stmt = $pdo->prepare("SELECT quantidade FROM produtos WHERE id = ?");
        $stmt->execute([$produto_id]);
        $produto = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($produto && $produto['quantidade'] >= $quantidade_retirada) {
            // Atualiza a quantidade do produto no banco de dados
            $nova_quantidade = $produto['quantidade'] - $quantidade_retirada;
            $stmt = $pdo->prepare("UPDATE produtos SET quantidade = ? WHERE id = ?");
            $stmt->execute([$nova_quantidade, $produto_id]);

            // Registra a movimentação na tabela `movimentacoes`
            $stmt = $pdo->prepare("INSERT INTO movimentacoes (produto_id, tipo, quantidade, data_movimentacao) VALUES (?, 'saida', ?, ?)");
            $stmt->execute([$produto_id, $quantidade_retirada, $data_movimentacao]);

            // Define a mensagem de sucesso
            $mensagem = "<p style='color:green;'>Saída registrada com sucesso!</p>";
        } else {
            $mensagem = "<p style='color:red;'>Quantidade insuficiente em estoque.</p>";
        }
    }
}
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Saída de Produtos</title>
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
                <h2>Saída de Produtos</h2>

                <!-- Formulário de Busca -->
                <form method="GET" style="margin-bottom: 20px;">
                    <input type="text" name="busca" placeholder="Buscar por nome ou código" value="<?= htmlspecialchars($busca) ?>" required>
                    <button type="submit">Buscar</button>
                </form>

                <!-- Lista de Produtos (Visível no Desktop) -->
                <table class="desktop-table">
                    <thead>
                        <tr>
                            <th>Código</th>
                            <th>Nome</th>
                            <th>Descrição</th>
                            <th>Quantidade Atual</th>
                            <th>Ações</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($produtos as $produto): ?>
                            <tr>
                                <td><?= $produto['id'] ?></td>
                                <td><?= htmlspecialchars($produto['nome']) ?></td>
                                <td><?= htmlspecialchars($produto['descricao']) ?></td>
                                <td><?= $produto['quantidade'] ?></td>
                                <td>
                                    <!-- Formulário para Registrar Saída -->
                                    <form method="POST" style="display:inline;">
                                        <input type="hidden" name="produto_id" value="<?= $produto['id'] ?>">
                                        <input type="number" name="quantidade_retirada" placeholder="Quantidade" min="1" required>
                                        <input type="date" name="data_movimentacao" value="<?= date('Y-m-d') ?>" required>
                                        <button type="submit">Registrar Saída</button>
                                    </form>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>

                <!-- Lista Amigável para Mobile -->
                <ul class="mobile-list">
                    <?php foreach ($produtos as $produto): ?>
                        <li>
                            <strong>Código:</strong> <?= $produto['id'] ?><br>
                            <strong>Nome:</strong> <?= htmlspecialchars($produto['nome']) ?><br>
                            <strong>Descrição:</strong> <?= htmlspecialchars($produto['descricao']) ?><br>
                            <strong>Quantidade Atual:</strong> <?= $produto['quantidade'] ?><br>
                            <strong>Ações:</strong>
                            <form method="POST" style="display:inline;">
                                <input type="hidden" name="produto_id" value="<?= $produto['id'] ?>">
                                <input type="number" name="quantidade_retirada" placeholder="Quantidade" min="1" required>
                                <input type="date" name="data_movimentacao" value="<?= date('Y-m-d') ?>" required>
                                <button type="submit">Registrar Saída</button>
                            </form>
                        </li>
                    <?php endforeach; ?>
                </ul>
            </div>
        </main>
    </div>
    <script src="js/scripts.js"></script>
</body>
</html>