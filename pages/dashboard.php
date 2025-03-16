<?php
session_start();
if (!isset($_SESSION['usuario'])) {
    header("Location: login.php");
    exit();
}

$usuario = $_SESSION['usuario'];
$nivel = $_SESSION['nivel'];
?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard</title>
    <link rel="stylesheet" href="../assets/css/dashboard.css">
</head>
<body>
    <div class="sidebar">
        <h2>Bem-vindo, <?php echo $usuario; ?>!</h2>
        <p>Seu nível de acesso é: <strong><?php echo $nivel; ?></strong></p>

        <nav>
            <ul>

                <?php if ($nivel === "admin") : ?>
                    <li><a href="../pages/usuarios.php">Gerenciar Usuários</a></li>
                <?php endif; ?>

                <li><a href="#">Fornecedores</a></li>
                <li><a href="#">Categorias</a></li>
                <li><a href="#">Produtos</a></li>
                <li><a href="../includes/logout.php">Sair</a></li>
            </ul>
        </nav>
    </div>
        <!-- Conteúdo Principal -->
<div class="main-content">
    <div class="header">
        <h1>Dashboard</h1>
        <p>Bem-vindo, <strong>Admin</strong></p>
    </div>

    <!-- Cards de informações -->
    <div class="cards">
        <div class="card">
            <h3>Usuários</h3>
            <p>10</p>
        </div>
        <div class="card">
            <h3>Fornecedores</h3>
            <p>5</p>
        </div>
        <div class="card">
            <h3>Produtos</h3>
            <p>200</p>
        </div>
    </div>
</div>
</body>
</html>