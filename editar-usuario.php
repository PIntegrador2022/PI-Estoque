<?php
session_start();
include_once 'db/connect.php';

// Verifica se o usuário está logado e é admin
if (!isset($_SESSION['usuario_id']) || $_SESSION['nivel_acesso'] != 'admin') {
    header("Location: index.php");
    exit;
}

// Verifica se o ID do usuário foi enviado via GET
if (!isset($_GET['id'])) {
    header("Location: listagem-usuarios.php");
    exit;
}

$id_usuario = $_GET['id'];

// Buscar os dados do usuário pelo ID
$stmt = $pdo->prepare("SELECT * FROM usuarios WHERE id = ?");
$stmt->execute([$id_usuario]);
$usuario = $stmt->fetch(PDO::FETCH_ASSOC);

if (!$usuario) {
    header("Location: listagem-usuarios.php");
    exit;
}

// Processa o formulário de edição de usuário
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $nome = $_POST['nome'];
    $login = $_POST['login'];
    $senha = $_POST['senha'];
    $nivel_acesso = $_POST['nivel_acesso'];

    // Se a senha for fornecida, atualiza a senha; caso contrário, mantém a senha atual
    if (!empty($senha)) {
        $senha_hash = md5($senha);
        $stmt = $pdo->prepare("UPDATE usuarios SET nome = ?, login = ?, senha = ?, nivel_acesso = ? WHERE id = ?");
        $stmt->execute([$nome, $login, $senha_hash, $nivel_acesso, $id_usuario]);
    } else {
        $stmt = $pdo->prepare("UPDATE usuarios SET nome = ?, login = ?, nivel_acesso = ? WHERE id = ?");
        $stmt->execute([$nome, $login, $nivel_acesso, $id_usuario]);
    }

    // Redireciona para a listagem de usuários após a edição
    header("Location: listagem-usuarios.php");
    exit;
}
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Editar Usuário</title>
    <link rel="stylesheet" href="css/style.css">
</head>
<body>
    <div class="container">
          <!-- Sidebar -->
          <?php include_once 'includes/sidebar.php'; ?>

        <!-- Conteúdo Principal -->
        <main class="content">
            <h2>Editar Usuário</h2>
            <form method="POST">
                <input type="text" name="nome" placeholder="Nome do Usuário" value="<?= htmlspecialchars($usuario['nome']) ?>" required>
                <input type="text" name="login" placeholder="Login do Usuário" value="<?= htmlspecialchars($usuario['login']) ?>" required>
                <input type="password" name="senha" placeholder="Nova Senha (deixe em branco para manter)">
                <select name="nivel_acesso" required>
                    <option value="admin" <?= $usuario['nivel_acesso'] == 'admin' ? 'selected' : '' ?>>Admin</option>
                    <option value="usuario" <?= $usuario['nivel_acesso'] == 'usuario' ? 'selected' : '' ?>>Usuário</option>
                </select>
                <button type="submit">Salvar Alterações</button>
            </form>
        </main>
    </div>
</body>
</html>