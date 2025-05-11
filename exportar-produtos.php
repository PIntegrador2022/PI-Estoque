<?php
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

// Carrega o autoloader do Composer
require 'vendor/autoload.php';

use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

// Cria uma nova planilha
$spreadsheet = new Spreadsheet();
$sheet = $spreadsheet->getActiveSheet();

// Define o cabeçalho
$headers = ['ID', 'Nome', 'Descrição', 'Preço (R$)', 'Quantidade em Estoque', 'Categoria ID', 'Estoque Mínimo'];
$sheet->fromArray($headers, null, 'A1');

// Preenche os dados dos produtos
$row = 2; // Começa na linha 2 (após o cabeçalho)
foreach ($produtos as $produto) {
    $sheet->setCellValue('A' . $row, $produto['id']);
    $sheet->setCellValue('B' . $row, $produto['nome']);
    $sheet->setCellValue('C' . $row, $produto['descricao']);
    $sheet->setCellValue('D' . $row, number_format($produto['preco'], 2, ',', '.')); // Formata o preço
    $sheet->setCellValue('E' . $row, $produto['quantidade']);
    $sheet->setCellValue('F' . $row, $produto['categoria_id']);
    $sheet->setCellValue('G' . $row, $produto['estoque_minimo']);
    $row++;
}

// Formatação do cabeçalho
$headerStyle = [
    'font' => [
        'bold' => true,
        'color' => ['rgb' => 'FFFFFF'], // Texto branco
    ],
    'fill' => [
        'fillType' => \PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID,
        'startColor' => ['rgb' => '4F81BD'], // Fundo azul
    ],
    'alignment' => [
        'horizontal' => \PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER,
    ],
    'borders' => [
        'allBorders' => [
            'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN,
        ],
    ],
];
$sheet->getStyle('A1:G1')->applyFromArray($headerStyle);

// Ajusta a largura das colunas automaticamente
foreach (range('A', 'G') as $column) {
    $sheet->getColumnDimension($column)->setAutoSize(true);
}

// Alinha os valores numéricos à direita
$numericColumns = ['D', 'E', 'F', 'G'];
foreach ($numericColumns as $col) {
    $sheet->getStyle($col . '2:' . $col . $row)->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_RIGHT);
}

// Configura o cabeçalho HTTP para download do arquivo
header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
header('Content-Disposition: attachment;filename="lista-de-produtos.xlsx"');
header('Cache-Control: max-age=0');

// Salva o arquivo no output
$writer = new Xlsx($spreadsheet);
$writer->save('php://output');
exit;