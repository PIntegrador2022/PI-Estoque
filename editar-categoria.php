<?php
session_start();
include_once 'db/connect.php';

// Verifica se o usuário está logado
if (!isset($_SESSION['usuario_id'])) {
    header("Location: index.php");
    exit;
}

$nivel_acesso = $_SESSION['nivel_acesso'];

// Verifica se o ID da categoria foi fornecido via GET
if (!isset($_GET['id']) || empty($_GET['id'])) {
    header("Location: listagem-categorias.php");
    exit;
}

$categoria_id = $_GET['id'];

// Busca os dados da categoria no banco de dados
$stmt = $pdo->prepare("SELECT * FROM categorias WHERE id = ?");
$stmt->execute([$categoria_id]);
$categoria = $stmt->fetch(PDO::FETCH_ASSOC);

if (!$categoria) {
    echo "<p style='color:red;'>Categoria não encontrada.</p>";
    exit;
}

// Processa o formulário de edição
$mensagem = ''; // Variável para armazenar a mensagem
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $nome = trim($_POST['nome']);

    if (empty($nome)) {
        $mensagem = "<p style='color:red;'>O nome da categoria é obrigatório.</p>";
    } else {
        // Atualiza o nome da categoria no banco de dados
        $stmt = $pdo->prepare("UPDATE categorias SET nome = ? WHERE id = ?");
        $stmt->execute([$nome, $categoria_id]);

        $mensagem = "<p style='color:green;'>Categoria atualizada com sucesso!</p>";
    }
}
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Editar Categoria</title>
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

            <!-- Área de Mensagens -->
            <?php if (!empty($mensagem)): ?>
                <div class="message-container">
                    <?= $mensagem ?>
                </div>
            <?php endif; ?>

            <!-- Área de Scroll -->
            <div class="scrollable-content">
                <!-- Título da Página -->
                <h2>Editar Categoria</h2>

                <!-- Formulário de Edição -->
                <form method="POST">
                    <label for="nome">Nome da Categoria:</label>
                    <input type="text" name="nome" id="nome" value="<?= htmlspecialchars($categoria['nome']) ?>" required>
                    <button type="submit">Salvar Alterações</button>
                </form>
            </div>
        </main>
    </div>
    <script src="js/scripts.js"></script>
</body>
</html>