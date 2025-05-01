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

// Buscar todos os usuários do banco de dados
$stmt = $pdo->query("SELECT * FROM usuarios");
$usuarios = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Listagem de Usuários</title>
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
                    <span class="user-name">Olá, <?= htmlspecialchars($usuario_logado['nome']) ?></span>
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
                <h2>Listagem de Usuários</h2>

                <!-- Lista de Usuários (Visível no Desktop) -->
                <table class="desktop-table">
                    <thead>
                        <tr>
                            <th>Nome</th>
                            <th>Login</th>
                            <th>Nível de Acesso</th>
                            <th>Ações</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($usuarios as $usuario): ?>
                            <tr>
                                <td><?= htmlspecialchars($usuario['nome']) ?></td>
                                <td><?= htmlspecialchars($usuario['login']) ?></td>
                                <td><?= htmlspecialchars($usuario['nivel_acesso']) ?></td>
                                <td>
                                    <a href="editar-usuario.php?id=<?= $usuario['id'] ?>">Editar</a>
                                    <a href="excluir-usuario.php?id=<?= $usuario['id'] ?>" onclick="return confirm('Tem certeza que deseja excluir este usuário?')">Excluir</a>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>

                <!-- Lista Amigável para Mobile -->
                <ul class="mobile-list">
                    <?php foreach ($usuarios as $usuario): ?>
                        <li>
                            <strong>Nome:</strong> <?= htmlspecialchars($usuario['nome']) ?><br>
                            <strong>Login:</strong> <?= htmlspecialchars($usuario['login']) ?><br>
                            <strong>Nível de Acesso:</strong> <?= htmlspecialchars($usuario['nivel_acesso']) ?><br>
                            <strong>Ações:</strong>
                            <a href="editar-usuario.php?id=<?= $usuario['id'] ?>">Editar</a>
                            <a href="excluir-usuario.php?id=<?= $usuario['id'] ?>" onclick="return confirm('Tem certeza que deseja excluir este usuário?')">Excluir</a>
                        </li>
                    <?php endforeach; ?>
                </ul>
            </div>
        </main>
    </div>
    <script src="js/scripts.js"></script>
</body>
</html>