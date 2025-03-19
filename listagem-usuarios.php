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
        <aside class="sidebar">
            <h2>Menu</h2>
            <ul>
                <li><a href="dashboard.php">Dashboard</a></li>
                <li><a href="cadastro-produto.php">Cadastrar Produto</a></li>
                <li><a href="cadastro-usuario.php">Cadastrar Usuário</a></li>
                <li><a href="listagem-usuarios.php">Listar Usuários</a></li>
                <li><a href="logout.php">Sair</a></li>
            </ul>
        </aside>

        <!-- Conteúdo Principal -->
        <main class="content">

         <!-- Cabeçalho -->
         <header class="header">
                <div class="logo">
                    <img src="https://estoquetudo.com.br/wp-content/themes/estoque-tudo/images/assets/logo.svg" alt="Logo" width="50"> 
                </div>
                <div class="user-info">
                    <span class="user-name">Olá, <?= htmlspecialchars($usuario_logado['nome']) ?></span>
                    <div class="dropdown-menu">
                        <a href="editar-perfil.php">Editar Perfil</a>
                        <a href="logout.php">Sair</a>
                    </div>
                </div>
            </header>

            <h2>Listagem de Usuários</h2>
            <table>
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
        </main>
    </div>

     <!-- Script para o Menu Dropdown -->
     <script>
        // Mostrar/Esconder o menu dropdown ao clicar no nome do usuário
        const userInfo = document.querySelector('.user-info');
        const dropdownMenu = document.querySelector('.dropdown-menu');

        userInfo.addEventListener('click', () => {
            dropdownMenu.classList.toggle('show');
        });

        // Fechar o menu quando clicar fora dele
        document.addEventListener('click', (event) => {
            if (!userInfo.contains(event.target)) {
                dropdownMenu.classList.remove('show');
            }
        });
    </script>
</body>
</html>