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

// Exclui o produto do banco de dados
$stmt = $pdo->prepare("DELETE FROM produtos WHERE id = ?");
$stmt->execute([$id_produto]);

// Redireciona de volta para o dashboard após a exclusão
header("Location: dashboard.php");
exit;
?>