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
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Entrada de Produtos</title>
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
                <h2>Entrada de Produtos</h2>

                <!-- Formulário de Busca -->
                <form method="GET" style="margin-bottom: 20px;">
                    <input type="text" name="busca" placeholder="Buscar por nome ou código" value="<?= htmlspecialchars($busca) ?>" required>
                    <button type="submit">Buscar</button>
                </form>

                <!-- Lista de Produtos -->
                <table>
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
                                    <!-- Formulário para Registrar Entrada -->
                                    <form method="POST" style="display:inline;">
                                        <input type="hidden" name="produto_id" value="<?= $produto['id'] ?>">
                                        <input type="number" name="quantidade_adicional" placeholder="Quantidade" min="1" required>
                                        <button type="submit">Registrar Entrada</button>
                                    </form>
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