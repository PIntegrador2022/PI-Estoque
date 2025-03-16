<?php
session_start();
require '../conexao.php'; // Conexão com o banco de dados

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $usuario = $_POST['usuario'];
    $senha = $_POST['senha'];

    $sql = "SELECT * FROM usuarios WHERE usuario = :usuario";
    $stmt = $pdo->prepare($sql);
    $stmt->bindParam(':usuario', $usuario);
    $stmt->execute();
    $user = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($user && password_verify($senha, $user['senha'])) {
        // Login bem-sucedido, criar sessão
        $_SESSION['usuario'] = $user['usuario'];
        $_SESSION['nivel'] = $user['nivel']; // Nivel de acesso

        // Redireciona para o dashboard
        header("Location: ../pages/dashboard.php");
        exit();
    } else {
        // Login inválido, redireciona para login com erro
        header("Location: ../pages/login.php?erro=1");
        exit();
    }
} else {
    // Se acessar diretamente sem POST, volta para login
    header("Location: ../pages/login.php");
    exit();
}