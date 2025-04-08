<?php
session_start();
include_once 'db/connect.php';

// Verifica se o usuário está logado e é admin
if (!isset($_SESSION['usuario_id']) || $_SESSION['nivel_acesso'] != 'admin') {
    header("Location: index.php");
    exit;
}

// Verifica se o ID do produto foi enviado via GET
if (!isset($_GET['id'])) {
    header("Location: dashboard.php");
    exit;
}

$id_produto = $_GET['id'];

// Buscar os dados do produto pelo ID
$stmt = $pdo->prepare("SELECT * FROM produtos WHERE id = ?");
$stmt->execute([$id_produto]);
$produto = $stmt->fetch(PDO::FETCH_ASSOC);

if (!$produto) {
    header("Location: dashboard.php");
    exit;
}

// Processa o formulário de edição de produto
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $nome = $_POST['nome'];
    $descricao = $_POST['descricao'];
    $quantidade = $_POST['quantidade'];
    $preco = $_POST['preco'];

    // Atualiza os dados do produto no banco de dados
    $stmt = $pdo->prepare("UPDATE produtos SET nome = ?, descricao = ?, quantidade = ?, preco = ? WHERE id = ?");
    $stmt->execute([$nome, $descricao, $quantidade, $preco, $id_produto]);

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
    <title>Editar Produto</title>
    <link rel="stylesheet" href="css/style.css">
</head>

<body>
    <div class="container">
        <!-- Sidebar -->
        <?php include_once 'includes/sidebar.php'; ?>

        <!-- Conteúdo Principal -->
        <main class="content">
            <h2>Editar Produto</h2>
            <form method="POST">
                <input type="text" name="nome" placeholder="Nome do Produto" value="<?= htmlspecialchars($produto['nome']) ?>" required>
                <textarea name="descricao" placeholder="Descrição do Produto"><?= htmlspecialchars($produto['descricao']) ?></textarea>
                <input type="number" name="quantidade" placeholder="Quantidade" value="<?= $produto['quantidade'] ?>" required>
                <input type="number" step="0.01" name="preco" placeholder="Preço" value="<?= $produto['preco'] ?>" required>
                <label for="estoque_minimo">Estoque Mínimo:</label>
<input type="number" name="estoque_minimo" id="estoque_minimo" value="<?= isset($produto['estoque_minimo']) ? $produto['estoque_minimo'] : 10 ?>" min="1" required>
                <button type="submit">Salvar Alterações</button>
            </form>

            <!-- Seleção de Categoria -->
            <label for="categoria_id">Categoria:</label>
            <select name="categoria_id" id="categoria_id" required>
                <option value="">Selecione uma categoria</option>
                <?php
                $stmt = $pdo->query("SELECT * FROM categorias");
                $categorias = $stmt->fetchAll(PDO::FETCH_ASSOC);
                foreach ($categorias as $categoria): ?>
                    <option value="<?= $categoria['id'] ?>"><?= htmlspecialchars($categoria['nome']) ?></option>
                <?php endforeach; ?>
            </select>
        </main>
    </div>
    <script src="js/scripts.js"></script>
</body>

</html>