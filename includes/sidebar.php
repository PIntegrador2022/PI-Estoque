<?php
// Verifica se o usuário está logado
if (!isset($_SESSION['usuario_id'])) {
    header("Location: index.php");
    exit;
}

$nivel_acesso = $_SESSION['nivel_acesso'];
?>

<aside class="sidebar">
    <h2>Menu</h2>
    <ul>
        <li><a href="dashboard.php">Dashboard</a></li>

        <!-- Submenu Gerenciamento de Produtos -->
        <li class="submenu">
            <span class="submenu-title">Gerenciamento de Produtos</span>
            <ul class="submenu-items">
                <li><a href="cadastro-produto.php">Cadastrar Produto</a></li>
                <li><a href="listagem-produtos.php">Listar Produtos</a></li>
                <li><a href="entrada-produto.php">Entrada de Produtos</a></li>
                <li><a href="saida-produto.php">Saída de Produtos</a></li> <!-- Nova opção -->
            </ul>
        </li>

        <?php if ($nivel_acesso == 'admin'): ?>
            <!-- Submenu Gerenciamento de Usuários -->
            <li class="submenu">
                <span class="submenu-title">Gerenciamento de Usuários</span>
                <ul class="submenu-items">
                    <li><a href="cadastro-usuario.php">Cadastrar Usuário</a></li>
                    <li><a href="listagem-usuarios.php">Listar Usuários</a></li>
                </ul>
            </li>
        <?php endif; ?>

        <li><a href="logout.php">Sair</a></li>
    </ul>
</aside>