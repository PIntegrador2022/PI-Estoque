<?php
session_start();
include_once 'db/connect.php';

// Verifica se o usuário está logado
if (!isset($_SESSION['usuario_id'])) {
    header("Location: index.php");
    exit;
}

$nivel_acesso = $_SESSION['nivel_acesso'];

// Funções de formatação
function formatarValorMonetario($valor) {
    return 'R$ ' . number_format($valor, 2, ',', '.');
}

function formatarNumeroInteiro($numero) {
    return number_format($numero, 0, ',', '.');
}

// Inicializa as variáveis de busca e filtro
$busca = isset($_GET['busca']) ? trim($_GET['busca']) : '';
$filtro_estoque = isset($_GET['filtro_estoque']) ? $_GET['filtro_estoque'] : 'todos'; // Padrão: "todos"

// Consulta os produtos com base na busca e no filtro
if ($busca) {
    // Filtra por nome, ID ou categoria
    $stmt = $pdo->prepare("
        SELECT p.*, c.nome AS categoria_nome 
        FROM produtos p
        LEFT JOIN categorias c ON p.categoria_id = c.id
        WHERE (p.id = :id OR p.nome LIKE :nome OR c.nome LIKE :categoria)
        AND (:filtro_estoque = 'todos' OR p.quantidade <= p.estoque_minimo)
    ");
    $stmt->bindValue(':id', $busca, PDO::PARAM_INT);
    $stmt->bindValue(':nome', '%' . $busca . '%', PDO::PARAM_STR);
    $stmt->bindValue(':categoria', '%' . $busca . '%', PDO::PARAM_STR);
    $stmt->bindValue(':filtro_estoque', $filtro_estoque, PDO::PARAM_STR);
    $stmt->execute();
} else {
    // Se não houver busca, lista os produtos com base no filtro
    $stmt = $pdo->prepare("
        SELECT p.*, c.nome AS categoria_nome 
        FROM produtos p
        LEFT JOIN categorias c ON p.categoria_id = c.id
        WHERE :filtro_estoque = 'todos' OR p.quantidade <= p.estoque_minimo
    ");
    $stmt->bindValue(':filtro_estoque', $filtro_estoque, PDO::PARAM_STR);
    $stmt->execute();
}
$produtos = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Listagem de Produtos</title>
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
            
            <!-- Área de Scroll -->
            <div class="scrollable-content">
                <!-- Título da Página -->
                <h2>Listagem de Produtos</h2>
                
                <!-- Formulário de Busca e Filtro -->
                <form method="GET" style="margin-bottom: 20px;">
                    <input type="text" name="busca" placeholder="Buscar por nome, código ou categoria" value="<?= htmlspecialchars($busca) ?>" required>
                    
                    <label for="filtro_estoque">Filtrar por Estoque:</label>
                    <select name="filtro_estoque" id="filtro_estoque">
                        <option value="todos" <?= $filtro_estoque === 'todos' ? 'selected' : '' ?>>Todos os Produtos</option>
                        <option value="baixo" <?= $filtro_estoque === 'baixo' ? 'selected' : '' ?>>Estoque Baixo</option>
                    </select>
                    <a href="exportar-produtos.php" class="btn-export">Exportar Produtos para Excel</a>
                    <button type="submit">Aplicar Filtro</button>
                </form>
                
                <!-- Lista de Produtos (Visível no Desktop) -->
                <table class="desktop-table">
                    <thead>
                        <tr>
                            <th>Código</th>
                            <th>Nome</th>
                            <th>Descrição</th>
                            <th>Categoria</th>
                            <th>Quantidade Atual</th>
                            <th>Estoque Mínimo</th>
                            <th>Preço</th>
                            <th>Ações</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($produtos as $produto): ?>
                            <tr class="<?= $produto['quantidade'] <= $produto['estoque_minimo'] ? 'baixo-estoque' : '' ?>">
                                <td><?= $produto['id'] ?></td>
                                <td><?= htmlspecialchars($produto['nome']) ?></td>
                                <td><?= htmlspecialchars($produto['descricao']) ?></td>
                                <td><?= htmlspecialchars($produto['categoria_nome'] ?? 'Sem Categoria') ?></td>
                                <td><?= formatarNumeroInteiro($produto['quantidade']) ?></td>
                                <td><?= formatarNumeroInteiro($produto['estoque_minimo']) ?></td>
                                <td><?= formatarValorMonetario($produto['preco']) ?></td>
                                <td>
                                    <a href="editar-produto.php?id=<?= $produto['id'] ?>">Editar</a>
                                    <a href="excluir-produto.php?id=<?= $produto['id'] ?>" onclick="return confirm('Tem certeza que deseja excluir este produto?')">Excluir</a>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>

                <!-- Lista Amigável para Mobile -->
                <ul class="mobile-list">
                    <?php foreach ($produtos as $produto): ?>
                        <li class="<?= $produto['quantidade'] <= $produto['estoque_minimo'] ? 'baixo-estoque' : '' ?>">
                            <strong>Código:</strong> <?= $produto['id'] ?><br>
                            <strong>Nome:</strong> <?= htmlspecialchars($produto['nome']) ?><br>
                            <strong>Descrição:</strong> <?= htmlspecialchars($produto['descricao']) ?><br>
                            <strong>Categoria:</strong> <?= htmlspecialchars($produto['categoria_nome'] ?? 'Sem Categoria') ?><br>
                            <strong>Quantidade Atual:</strong> <?= formatarNumeroInteiro($produto['quantidade']) ?><br>
                            <strong>Estoque Mínimo:</strong> <?= formatarNumeroInteiro($produto['estoque_minimo']) ?><br>
                            <strong>Preço:</strong> <?= formatarValorMonetario($produto['preco']) ?><br>
                            <strong>Ações:</strong>
                            <a href="editar-produto.php?id=<?= $produto['id'] ?>">Editar</a>
                            <a href="excluir-produto.php?id=<?= $produto['id'] ?>" onclick="return confirm('Tem certeza que deseja excluir este produto?')">Excluir</a>
                        </li>
                    <?php endforeach; ?>
                </ul>
            </div>
        </main>
    </div>
    <script src="js/scripts.js"></script>
</body>
</html>