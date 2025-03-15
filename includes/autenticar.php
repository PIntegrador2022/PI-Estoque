<?php

    session_start();

    if ( $_SERVER["REQUEST_METHOD"] == "POST") {
        $usuario = $_POST['usuario'];
        $senha = $_POST['senha'];

        $sql = "SELECT * FROM usuarios WHERE usuario = :usuario";
        $stmt = $conexao->prepare($sql);
        $stmt->bindParam(":usuario", $usuario);
        $stmt->execute();
        $usuarioEncontrado = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($usuarioEncontrado && password_verify($senha, $usuarioEncontrado['senha'])) {
            $_SESSION['usuario'] = $usuarioEncontrado['usuario'];
            $_SESSION['nivel'] = $usuarioEncontrado['nivel']; // Guarda o nível do usuário
            header("Location: dashboard.php");
            exit();
        } else {
            echo "<script>alert('Usuário ou senha incorretos!');window.location.href=''login.php';</script>";
        }
    } 
?>