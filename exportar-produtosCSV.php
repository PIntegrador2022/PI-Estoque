<?php
//Para usar a versão de CSV utilizado no infinityfree deve renomear este arquivo para exportar-produtos.php e sobreescrever o atual

session_start();
include_once 'db/connect.php';

// Verifica se o usuário está logado
if (!isset($_SESSION['usuario_id'])) {
    header("Location: index.php");
    exit;
}

// Consulta para buscar todos os produtos
$stmt = $pdo->query("
    SELECT 
        id, nome, descricao, preco, quantidade, categoria_id, estoque_minimo
    FROM produtos
");
$produtos = $stmt->fetchAll(PDO::FETCH_ASSOC);

// Configura o cabeçalho HTTP para download do arquivo CSV
header('Content-Type: text/csv; charset=UTF-8');
header('Content-Disposition: attachment;filename="produtos.csv"');

// Abre o output para escrita
$output = fopen('php://output', 'w');

// Escreve o cabeçalho do CSV
fputcsv($output, ['ID', 'Nome do Produto', 'Descrição do Produto', 'Preço (R$)', 'Quantidade em Estoque', 'Categoria ID', 'Estoque Mínimo']);

// Escreve os dados dos produtos
foreach ($produtos as $produto) {
    fputcsv($output, [
        $produto['id'],
        $produto['nome'],
        $produto['descricao'],
        number_format($produto['preco'], 2, ',', '.'),
        number_format($produto['quantidade'], 0, '', '.'),
        $produto['categoria_id'],
        $produto['estoque_minimo']
    ]);
}

// Fecha o arquivo
fclose($output);
exit;