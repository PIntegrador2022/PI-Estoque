<?php

    $host = "localhost"; // Sevidor do banco de dados
    $usuario = "root";   // usuario padrão do mysql
    $senha = "";         // Senha padrão do mysql
    $banco = "estoque";  // Nome do banco de dados

    try {
        $conexao = new PDO("mysql:host=$host;dbname=$banco;charset=utf8", $usuario, $senha);
    } catch (PDOException $e){
        die("falha na conexão: ".$e->getMessage());
    }

?>