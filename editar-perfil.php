<?php
session_start();
include_once 'db/connect.php';

// Verifica se o usuário está logado
if (!isset($_SESSION['usuario_id'])) {
    header("Location: index.php");
    exit;
}

$id_usuario = $_SESSION['usuario_id'];

// Buscar os dados do usuário
$stmt = $pdo->prepare("SELECT * FROM usuarios WHERE id = ?");
$stmt->execute([$id_usuario]);
$usuario = $stmt->fetch(PDO::FETCH_ASSOC);

if (!$usuario) {
    header("Location: dashboard.php");
    exit;
}

// Processa o formulário de edição de perfil
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $nome = $_POST['nome'];
    $login = $_POST['login'];
    $senha = $_POST['senha'];

    // Se a senha for fornecida, atualiza a senha; caso contrário, mantém a senha atual
    if (!empty($senha)) {
        $senha_hash = md5($senha);
        $stmt = $pdo->prepare("UPDATE usuarios SET nome = ?, login = ?, senha = ? WHERE id = ?");
        $stmt->execute([$nome, $login, $senha_hash, $id_usuario]);
    } else {
        $stmt = $pdo->prepare("UPDATE usuarios SET nome = ?, login = ? WHERE id = ?");
        $stmt->execute([$nome, $login, $id_usuario]);
    }

    // Redireciona de volta para o dashboard após a edição
    header("Location: dashboard.php");
    exit;
}
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Editar Perfil</title>
    <link rel="stylesheet" href="css/style.css">
</head>
<body>
    <div class="container">
        <!-- Sidebar -->
        <aside class="sidebar">
            <h2>Menu</h2>
            <ul>
                <li><a href="dashboard.php">Dashboard</a></li>
                <li><a href="logout.php">Sair</a></li>
            </ul>
        </aside>

        <!-- Conteúdo Principal -->
        <main class="content">
            <h2>Editar Perfil</h2>
            <form method="POST">
                <input type="text" name="nome" placeholder="Nome" value="<?= htmlspecialchars($usuario['nome']) ?>" required>
                <input type="text" name="login" placeholder="Login" value="<?= htmlspecialchars($usuario['login']) ?>" required>
                <input type="password" name="senha" placeholder="Nova Senha (deixe em branco para manter)">
                <button type="submit">Salvar Alterações</button>
            </form>
        </main>
    </div>
</body>
</html>