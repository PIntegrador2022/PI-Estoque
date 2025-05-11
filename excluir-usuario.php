<?php
session_start();
include_once 'db/connect.php';

// Verifica se o usuário está logado
if (!isset($_SESSION['usuario_id'])) {
    header("Location: index.php");
    exit;
}

// Verifica se o usuário tem permissão para excluir outros usuários (admin)
$nivel_acesso = $_SESSION['nivel_acesso'];
if ($nivel_acesso !== 'admin') {
    die("Você não tem permissão para acessar esta página.");
}

// Obtém o ID do usuário a ser excluído via GET
if (isset($_GET['id']) && is_numeric($_GET['id'])) {
    $usuario_id = $_GET['id'];

    // Consulta para verificar se o usuário existe
    $stmt = $pdo->prepare("SELECT * FROM usuarios WHERE id = ?");
    $stmt->execute([$usuario_id]);
    $usuario = $stmt->fetch(PDO::FETCH_ASSOC);

    if (!$usuario) {
        die("Usuário não encontrado.");
    }

    // Exclui o usuário do banco de dados
    $delete_stmt = $pdo->prepare("DELETE FROM usuarios WHERE id = ?");
    if ($delete_stmt->execute([$usuario_id])) {
        // Redireciona para a página de listagem de usuários com uma mensagem de sucesso
        $_SESSION['mensagem'] = "Usuário excluído com sucesso!";
        header("Location: listagem-usuarios.php");
        exit;
    } else {
        die("Erro ao excluir o usuário.");
    }
} else {
    die("ID de usuário inválido.");
}
?>