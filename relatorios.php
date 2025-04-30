<?php
session_start();
include_once 'db/connect.php';

// Verifica se o usuário está logado
if (!isset($_SESSION['usuario_id'])) {
    header("Location: index.php");
    exit;
}

$nivel_acesso = $_SESSION['nivel_acesso'];

// Funções de formatação
function formatarValorMonetario($valor) {
    return 'R$ ' . number_format($valor, 2, ',', '.');
}

function formatarNumeroInteiro($numero) {
    return number_format($numero, 0, ',', '.');
}

// Variáveis para armazenar os resultados
$data_inicio = isset($_GET['data_inicio']) ? $_GET['data_inicio'] : null;
$data_fim = isset($_GET['data_fim']) ? $_GET['data_fim'] : null;
$tipo_relatorio = isset($_GET['tipo_relatorio']) ? $_GET['tipo_relatorio'] : null;
$resultados = [];

// Processar os filtros (se o formulário foi enviado)
if ($data_inicio && $data_fim && $tipo_relatorio) {
    switch ($tipo_relatorio) {
        case 'consumo':
            // Consulta para consumo
            $stmt = $pdo->prepare("
                SELECT 
                    p.nome AS produto,
                    SUM(m.quantidade) AS total_consumido
                FROM movimentacoes m
                JOIN produtos p ON m.produto_id = p.id
                WHERE m.tipo = 'saida' AND m.data_movimentacao BETWEEN :data_inicio AND :data_fim
                GROUP BY p.nome
                ORDER BY total_consumido DESC
            ");
            $stmt->execute(['data_inicio' => $data_inicio, 'data_fim' => $data_fim]);
            $resultados = $stmt->fetchAll(PDO::FETCH_ASSOC);
            break;

        case 'reposicao':
            // Consulta para reposição
            $stmt = $pdo->prepare("
                SELECT 
                    p.nome AS produto,
                    SUM(m.quantidade) AS total_reposto
                FROM movimentacoes m
                JOIN produtos p ON m.produto_id = p.id
                WHERE m.tipo = 'entrada' AND m.data_movimentacao BETWEEN :data_inicio AND :data_fim
                GROUP BY p.nome
                ORDER BY total_reposto DESC
            ");
            $stmt->execute(['data_inicio' => $data_inicio, 'data_fim' => $data_fim]);
            $resultados = $stmt->fetchAll(PDO::FETCH_ASSOC);
            break;

        case 'tendencias':
            // Consulta para tendências temporais (formato MM-YYYY)
            $stmt = $pdo->prepare("
                SELECT 
                    DATE_FORMAT(m.data_movimentacao, '%m-%Y') AS mes,
                    SUM(m.quantidade) AS total_movimentado
                FROM movimentacoes m
                WHERE m.tipo = 'saida' AND m.data_movimentacao BETWEEN :data_inicio AND :data_fim
                GROUP BY mes
                ORDER BY m.data_movimentacao ASC
            ");
            $stmt->execute(['data_inicio' => $data_inicio, 'data_fim' => $data_fim]);
            $resultados = $stmt->fetchAll(PDO::FETCH_ASSOC);
            break;

        case 'valor':
            // Consulta para valor total movimentado
            $stmt = $pdo->prepare("
                SELECT 
                    p.nome AS produto,
                    SUM(m.quantidade * p.preco) AS valor_total
                FROM movimentacoes m
                JOIN produtos p ON m.produto_id = p.id
                WHERE m.data_movimentacao BETWEEN :data_inicio AND :data_fim
                GROUP BY p.nome
                ORDER BY valor_total DESC
            ");
            $stmt->execute(['data_inicio' => $data_inicio, 'data_fim' => $data_fim]);
            $resultados = $stmt->fetchAll(PDO::FETCH_ASSOC);
            break;
    }
}
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Relatórios</title>
    <link rel="stylesheet" href="css/style.css">
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
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

            <!-- Área de Scroll -->
            <div class="scrollable-content">
                <!-- Título da Página -->
                <h2>Relatórios</h2>

                <!-- Formulário de Filtros -->
                <form method="GET" style="margin-bottom: 20px;">
                    <label for="data_inicio">Data Inicial:</label>
                    <input type="date" name="data_inicio" id="data_inicio" required>

                    <label for="data_fim">Data Final:</label>
                    <input type="date" name="data_fim" id="data_fim" required>

                    <label for="tipo_relatorio">Tipo de Relatório:</label>
                    <select name="tipo_relatorio" id="tipo_relatorio" required>
                        <option value="consumo">Consumo</option>
                        <option value="reposicao">Reposição</option>
                        <option value="tendencias">Tendências Temporais</option>
                        <option value="valor">Valor Total Movimentado</option>
                    </select>

                    <button type="submit">Gerar Relatório</button>
                </form>

                <!-- Área de Resultados -->
                <div id="resultados">
                    <?php if (!empty($resultados)): ?>
                        <h3>Resultados do Relatório</h3>

                        <!-- Tabela de Resultados -->
                        <table>
                            <thead>
                                <tr>
                                    <?php if ($tipo_relatorio === 'tendencias'): ?>
                                        <th>Mês</th>
                                        <th>Total Movimentado</th>
                                    <?php else: ?>
                                        <th>Produto</th>
                                        <th>Valor</th>
                                    <?php endif; ?>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach ($resultados as $resultado): ?>
                                    <tr>
                                        <?php if ($tipo_relatorio === 'tendencias'): ?>
                                            <td><?= $resultado['mes'] ?></td>
                                            <td><?= formatarNumeroInteiro($resultado['total_movimentado']) ?></td>
                                        <?php elseif ($tipo_relatorio === 'valor'): ?>
                                            <td><?= htmlspecialchars($resultado['produto']) ?></td>
                                            <td><?= formatarValorMonetario($resultado['valor_total']) ?></td>
                                        <?php else: ?>
                                            <td><?= htmlspecialchars($resultado['produto']) ?></td>
                                            <td><?= formatarNumeroInteiro($resultado['total_consumido'] ?? $resultado['total_reposto']) ?></td>
                                        <?php endif; ?>
                                    </tr>
                                <?php endforeach; ?>
                            </tbody>
                        </table>

                        <!-- Gráfico -->
                        <?php if ($tipo_relatorio !== 'tendencias'): ?>
                            <canvas id="graficoRelatorio" width="400" height="200"></canvas>
                            <script>
                                document.addEventListener('DOMContentLoaded', function () {
                                    const ctx = document.getElementById('graficoRelatorio').getContext('2d');
                                    const graficoRelatorio = new Chart(ctx, {
                                        type: 'bar',
                                        data: {
                                            labels: [<?php echo "'" . implode("','", array_column($resultados, 'produto')) . "'"; ?>],
                                            datasets: [{
                                                label: 'Valores',
                                                data: [<?php echo implode(',', array_column($resultados, 'total_consumido' ?? 'total_reposto' ?? 'valor_total')); ?>],
                                                backgroundColor: 'rgba(75, 192, 192, 0.2)',
                                                borderColor: 'rgba(75, 192, 192, 1)',
                                                borderWidth: 1
                                            }]
                                        },
                                        options: {
                                            scales: {
                                                y: {
                                                    beginAtZero: true
                                                }
                                            }
                                        }
                                    });
                                });
                            </script>
                        <?php elseif ($tipo_relatorio === 'tendencias'): ?>
                            <canvas id="graficoTendencias" width="400" height="200"></canvas>
                            <script>
                                document.addEventListener('DOMContentLoaded', function () {
                                    const ctx = document.getElementById('graficoTendencias').getContext('2d');
                                    const graficoTendencias = new Chart(ctx, {
                                        type: 'line',
                                        data: {
                                            labels: [<?php echo "'" . implode("','", array_column($resultados, 'mes')) . "'"; ?>],
                                            datasets: [{
                                                label: 'Total Movimentado',
                                                data: [<?php echo implode(',', array_column($resultados, 'total_movimentado')); ?>],
                                                borderColor: 'rgba(75, 192, 192, 1)',
                                                borderWidth: 2,
                                                fill: false
                                            }]
                                        },
                                        options: {
                                            scales: {
                                                x: {
                                                    title: {
                                                        display: true,
                                                        text: 'Período (MM-YYYY)'
                                                    }
                                                },
                                                y: {
                                                    beginAtZero: true,
                                                    title: {
                                                        display: true,
                                                        text: 'Quantidade'
                                                    }
                                                }
                                            }
                                        }
                                    });
                                });
                            </script>
                        <?php endif; ?>
                    <?php else: ?>
                        <p>Nenhum resultado disponível.</p>
                    <?php endif; ?>
                </div>
            </div>
        </main>
    </div>
    <script src="js/scripts.js"></script>
</body>
</html>