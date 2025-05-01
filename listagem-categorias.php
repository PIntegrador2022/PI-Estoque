<?php
session_start();
include_once 'db/connect.php';

// Verifica se o usuário está logado
if (!isset($_SESSION['usuario_id'])) {
    header("Location: index.php");
    exit;
}

$nivel_acesso = $_SESSION['nivel_acesso'];

// Buscar todas as categorias
$stmt = $pdo->query("SELECT * FROM categorias");
$categorias = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Listagem de Categorias</title>
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
                <h2>Listagem de Categorias</h2>

                <!-- Lista de Categorias (Visível no Desktop) -->
                <table class="desktop-table">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Nome</th>
                            <th>Ações</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($categorias as $categoria): ?>
                            <tr>
                                <td><?= $categoria['id'] ?></td>
                                <td><?= htmlspecialchars($categoria['nome']) ?></td>
                                <td>
                                    <a href="editar-categoria.php?id=<?= $categoria['id'] ?>">Editar</a>
                                    <a href="excluir-categoria.php?id=<?= $categoria['id'] ?>" onclick="return confirm('Tem certeza que deseja excluir esta categoria?')">Excluir</a>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>

                <!-- Lista Amigável para Mobile -->
                <ul class="mobile-list">
                    <?php foreach ($categorias as $categoria): ?>
                        <li>
                            <strong>ID:</strong> <?= $categoria['id'] ?><br>
                            <strong>Nome:</strong> <?= htmlspecialchars($categoria['nome']) ?><br>
                            <strong>Ações:</strong>
                            <a href="editar-categoria.php?id=<?= $categoria['id'] ?>">Editar</a>
                            <a href="excluir-categoria.php?id=<?= $categoria['id'] ?>" onclick="return confirm('Tem certeza que deseja excluir esta categoria?')">Excluir</a>
                        </li>
                    <?php endforeach; ?>
                </ul>
            </div>
        </main>
    </div>
    <script src="js/scripts.js"></script>
</body>
</html>