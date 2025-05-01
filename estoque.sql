-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Tempo de geração: 01/05/2025 às 18:47
-- Versão do servidor: 10.4.32-MariaDB
-- Versão do PHP: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Banco de dados: `estoque`
--

-- --------------------------------------------------------

--
-- Estrutura para tabela `categorias`
--

CREATE TABLE `categorias` (
  `id` int(11) NOT NULL,
  `nome` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Despejando dados para a tabela `categorias`
--

INSERT INTO `categorias` (`id`, `nome`) VALUES
(1, 'Inverno'),
(2, 'Verão'),
(3, 'Primavera'),
(4, 'Outono'),
(5, 'Moda Praia');

-- --------------------------------------------------------

--
-- Estrutura para tabela `movimentacoes`
--

CREATE TABLE `movimentacoes` (
  `id` int(11) NOT NULL,
  `produto_id` int(11) NOT NULL,
  `tipo` enum('entrada','saida') NOT NULL,
  `quantidade` int(11) NOT NULL,
  `data_movimentacao` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Despejando dados para a tabela `movimentacoes`
--

INSERT INTO `movimentacoes` (`id`, `produto_id`, `tipo`, `quantidade`, `data_movimentacao`) VALUES
(1, 3, 'saida', 25, '2025-04-09'),
(2, 12, 'saida', 22, '2025-04-09'),
(3, 1, 'entrada', 5, '2025-04-09'),
(4, 1, 'saida', 10, '2025-04-09'),
(5, 1, 'saida', 10, '2025-04-09'),
(6, 1, 'entrada', 1, '2025-04-09'),
(7, 1, 'saida', 20, '2025-04-02'),
(8, 2, 'saida', 15, '2025-04-04'),
(9, 2, 'saida', 15, '2025-04-04'),
(10, 4, 'saida', 14, '2025-04-01'),
(11, 4, 'saida', 14, '2025-04-01'),
(12, 24, 'saida', 191, '2025-04-09'),
(13, 6, 'saida', 155, '2025-04-09'),
(14, 9, 'saida', 111, '2025-04-09'),
(15, 10, 'saida', 79, '2025-04-09'),
(16, 21, 'saida', 75, '2025-04-09'),
(17, 22, 'saida', 95, '2025-04-09'),
(18, 1, 'saida', 25, '2025-03-11'),
(19, 7, 'saida', 25, '2025-03-15'),
(20, 1, 'entrada', 10, '2025-04-13'),
(21, 1, 'entrada', 10, '2025-04-13'),
(22, 2, 'entrada', 10, '2025-04-13'),
(23, 3, 'entrada', 10, '2025-04-13'),
(24, 3, 'entrada', 10, '2025-04-13'),
(25, 4, 'entrada', 10, '2025-04-13'),
(26, 6, 'entrada', 10, '2025-04-13'),
(27, 6, 'entrada', 10, '2025-04-13'),
(28, 1, 'saida', 10, '2022-01-05'),
(29, 2, 'entrada', 50, '2022-01-10'),
(30, 3, 'saida', 15, '2022-01-15'),
(31, 4, 'entrada', 30, '2022-01-20'),
(32, 1, 'saida', 20, '2022-02-01'),
(33, 2, 'entrada', 40, '2022-02-05'),
(34, 3, 'saida', 25, '2022-02-10'),
(35, 4, 'entrada', 35, '2022-02-15'),
(36, 1, 'saida', 30, '2022-03-01'),
(37, 2, 'entrada', 60, '2022-03-05'),
(38, 3, 'saida', 35, '2022-03-10'),
(39, 4, 'entrada', 45, '2022-03-15'),
(40, 1, 'saida', 40, '2022-04-01'),
(41, 2, 'entrada', 70, '2022-04-05'),
(42, 3, 'saida', 45, '2022-04-10'),
(43, 4, 'entrada', 55, '2022-04-15'),
(44, 1, 'saida', 50, '2022-05-01'),
(45, 2, 'entrada', 80, '2022-05-05'),
(46, 3, 'saida', 55, '2022-05-10'),
(47, 4, 'entrada', 65, '2022-05-15'),
(48, 1, 'saida', 60, '2022-06-01'),
(49, 2, 'entrada', 90, '2022-06-05'),
(50, 3, 'saida', 65, '2022-06-10'),
(51, 4, 'entrada', 75, '2022-06-15'),
(52, 1, 'saida', 70, '2022-07-01'),
(53, 2, 'entrada', 100, '2022-07-05'),
(54, 3, 'saida', 75, '2022-07-10'),
(55, 4, 'entrada', 85, '2022-07-15'),
(56, 1, 'saida', 80, '2022-08-01'),
(57, 2, 'entrada', 110, '2022-08-05'),
(58, 3, 'saida', 85, '2022-08-10'),
(59, 4, 'entrada', 95, '2022-08-15'),
(60, 1, 'saida', 90, '2022-09-01'),
(61, 2, 'entrada', 120, '2022-09-05'),
(62, 3, 'saida', 95, '2022-09-10'),
(63, 4, 'entrada', 105, '2022-09-15'),
(64, 1, 'saida', 100, '2022-10-01'),
(65, 2, 'entrada', 130, '2022-10-05'),
(66, 3, 'saida', 105, '2022-10-10'),
(67, 4, 'entrada', 115, '2022-10-15'),
(68, 1, 'saida', 110, '2022-11-01'),
(69, 2, 'entrada', 140, '2022-11-05'),
(70, 3, 'saida', 115, '2022-11-10'),
(71, 4, 'entrada', 125, '2022-11-15'),
(72, 1, 'saida', 120, '2022-12-01'),
(73, 2, 'entrada', 150, '2022-12-05'),
(74, 3, 'saida', 125, '2022-12-10'),
(75, 4, 'entrada', 135, '2022-12-15'),
(76, 5, 'saida', 15, '2023-01-05'),
(77, 6, 'entrada', 45, '2023-01-10'),
(78, 7, 'saida', 20, '2023-01-15'),
(79, 8, 'entrada', 55, '2023-01-20'),
(80, 5, 'saida', 25, '2023-02-01'),
(81, 6, 'entrada', 60, '2023-02-05'),
(82, 7, 'saida', 30, '2023-02-10'),
(83, 8, 'entrada', 70, '2023-02-15'),
(84, 5, 'saida', 35, '2023-03-01'),
(85, 6, 'entrada', 75, '2023-03-05'),
(86, 7, 'saida', 40, '2023-03-10'),
(87, 8, 'entrada', 85, '2023-03-15'),
(88, 5, 'saida', 45, '2023-04-01'),
(89, 6, 'entrada', 90, '2023-04-05'),
(90, 7, 'saida', 50, '2023-04-10'),
(91, 8, 'entrada', 100, '2023-04-15'),
(92, 5, 'saida', 55, '2023-05-01'),
(93, 6, 'entrada', 105, '2023-05-05'),
(94, 7, 'saida', 60, '2023-05-10'),
(95, 8, 'entrada', 115, '2023-05-15'),
(96, 5, 'saida', 65, '2023-06-01'),
(97, 6, 'entrada', 120, '2023-06-05'),
(98, 7, 'saida', 70, '2023-06-10'),
(99, 8, 'entrada', 130, '2023-06-15'),
(100, 5, 'saida', 75, '2023-07-01'),
(101, 6, 'entrada', 135, '2023-07-05'),
(102, 7, 'saida', 80, '2023-07-10'),
(103, 8, 'entrada', 145, '2023-07-15'),
(104, 5, 'saida', 85, '2023-08-01'),
(105, 6, 'entrada', 150, '2023-08-05'),
(106, 7, 'saida', 90, '2023-08-10'),
(107, 8, 'entrada', 160, '2023-08-15'),
(108, 5, 'saida', 95, '2023-09-01'),
(109, 6, 'entrada', 165, '2023-09-05'),
(110, 7, 'saida', 100, '2023-09-10'),
(111, 8, 'entrada', 175, '2023-09-15'),
(112, 5, 'saida', 105, '2023-10-01'),
(113, 6, 'entrada', 180, '2023-10-05'),
(114, 7, 'saida', 110, '2023-10-10'),
(115, 8, 'entrada', 190, '2023-10-15'),
(116, 5, 'saida', 115, '2023-11-01'),
(117, 6, 'entrada', 195, '2023-11-05'),
(118, 7, 'saida', 120, '2023-11-10'),
(119, 8, 'entrada', 205, '2023-11-15'),
(120, 5, 'saida', 125, '2023-12-01'),
(121, 6, 'entrada', 210, '2023-12-05'),
(122, 7, 'saida', 130, '2023-12-10'),
(123, 8, 'entrada', 220, '2023-12-15'),
(124, 9, 'saida', 10, '2024-01-05'),
(125, 10, 'entrada', 30, '2024-01-10'),
(126, 11, 'saida', 15, '2024-01-15'),
(127, 12, 'entrada', 40, '2024-01-20'),
(128, 9, 'saida', 20, '2024-02-01'),
(129, 10, 'entrada', 50, '2024-02-05'),
(130, 11, 'saida', 25, '2024-02-10'),
(131, 12, 'entrada', 60, '2024-02-15'),
(132, 9, 'saida', 30, '2024-03-01'),
(133, 10, 'entrada', 70, '2024-03-05'),
(134, 11, 'saida', 35, '2024-03-10'),
(135, 12, 'entrada', 80, '2024-03-15'),
(136, 9, 'saida', 40, '2024-04-01'),
(137, 10, 'entrada', 90, '2024-04-05'),
(138, 11, 'saida', 45, '2024-04-10'),
(139, 12, 'entrada', 100, '2024-04-15'),
(140, 9, 'saida', 50, '2024-05-01'),
(141, 10, 'entrada', 110, '2024-05-05'),
(142, 11, 'saida', 55, '2024-05-10'),
(143, 12, 'entrada', 120, '2024-05-15'),
(144, 9, 'saida', 60, '2024-06-01'),
(145, 10, 'entrada', 130, '2024-06-05'),
(146, 11, 'saida', 65, '2024-06-10'),
(147, 12, 'entrada', 140, '2024-06-15'),
(148, 9, 'saida', 70, '2024-07-01'),
(149, 10, 'entrada', 150, '2024-07-05'),
(150, 11, 'saida', 75, '2024-07-10'),
(151, 12, 'entrada', 160, '2024-07-15'),
(152, 9, 'saida', 80, '2024-08-01'),
(153, 10, 'entrada', 170, '2024-08-05'),
(154, 11, 'saida', 85, '2024-08-10'),
(155, 12, 'entrada', 180, '2024-08-15'),
(156, 9, 'saida', 90, '2024-09-01'),
(157, 10, 'entrada', 190, '2024-09-05'),
(158, 11, 'saida', 95, '2024-09-10'),
(159, 12, 'entrada', 200, '2024-09-15'),
(160, 9, 'saida', 100, '2024-10-01'),
(161, 10, 'entrada', 210, '2024-10-05'),
(162, 11, 'saida', 105, '2024-10-10'),
(163, 12, 'entrada', 220, '2024-10-15'),
(164, 9, 'saida', 110, '2024-11-01'),
(165, 10, 'entrada', 230, '2024-11-05'),
(166, 11, 'saida', 115, '2024-11-10'),
(167, 12, 'entrada', 240, '2024-11-15'),
(168, 9, 'saida', 120, '2024-12-01'),
(169, 10, 'entrada', 250, '2024-12-05'),
(170, 11, 'saida', 125, '2024-12-10'),
(171, 12, 'entrada', 260, '2024-12-15');

-- --------------------------------------------------------

--
-- Estrutura para tabela `produtos`
--

CREATE TABLE `produtos` (
  `id` int(11) NOT NULL,
  `nome` varchar(100) NOT NULL,
  `descricao` text DEFAULT NULL,
  `quantidade` int(11) NOT NULL,
  `preco` decimal(10,2) NOT NULL,
  `categoria_id` int(11) DEFAULT NULL,
  `estoque_minimo` int(11) DEFAULT 10
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Despejando dados para a tabela `produtos`
--

INSERT INTO `produtos` (`id`, `nome`, `descricao`, `quantidade`, `preco`, `categoria_id`, `estoque_minimo`) VALUES
(1, 'Casaco de Lã', 'Casaco quente para dias frio', 40, 200.00, 1, 10),
(2, 'Blusa de Moletom', 'Blusa confortável para o inverno', 80, 89.99, 1, 10),
(3, 'Calça Jeans Forrada', 'Calça jeans com forro térmico', 25, 149.99, 1, 10),
(4, 'Luvas de Couro', 'Luvas resistentes para proteger do frio', 60, 49.99, 1, 10),
(5, 'Gorro de Lã', 'Gorro estiloso para o inverno', 60, 29.99, 1, 10),
(6, 'Camiseta Regata', 'Camiseta leve para dias quentes', 65, 39.99, 2, 10),
(7, 'Shorts Jeans', 'Shorts casual para o verão', 125, 79.99, 2, 10),
(8, 'Vestido Floral', 'Vestido leve e estampado', 55, 129.99, 2, 10),
(9, 'Chinelo de Praia', 'Chinelo confortável para o verão', 9, 19.99, 2, 10),
(10, 'Óculos de Sol', 'Proteção para os olhos nos dias ensolarados', 1, 59.99, 2, 10),
(11, 'Jaqueta Corta-Vento', 'Jaqueta leve para dias amenos', 43, 109.99, 3, 10),
(12, 'Saia Plissada', 'Saia elegante para a primavera', 9, 89.99, 3, 10),
(13, 'Blusa de Seda', 'Blusa suave e estilosa', 50, 69.99, 3, 10),
(14, 'Calça Social', 'Calça versátil para o trabalho ou passeios', 40, 99.99, 3, 10),
(15, 'Lenço Estampado', 'Acessório charmoso para complementar o look', 100, 19.99, 3, 10),
(16, 'Suéter de Tricô', 'Suéter quentinho para o outono', 60, 119.99, 4, 10),
(17, 'Cardigã', 'Cardigã versátil para looks casuais', 50, 99.99, 4, 10),
(18, 'Botas de Camurça', 'Botas estilosas para o outono', 20, 179.99, 4, 10),
(19, 'Echarpe de Cashmere', 'Acessório elegante para dias ameno', 40, 79.99, 4, 10),
(20, 'Calça de Veludo', 'Calça confortável e estilosa', 30, 129.99, 4, 10),
(21, 'Biquíni Estampado', 'Conjunto de biquíni vibrante para o verão', 5, 59.99, 5, 10),
(22, 'Sunga Masculina', 'Sunga clássica para o verão', 5, 49.99, 5, 10),
(23, 'Canga Listrada', 'Canga prática para levar à praia', 70, 39.99, 5, 10),
(24, 'Protetor Solar', 'Protetor solar FPS 50 para proteção máxima', 9, 29.99, 5, 10),
(25, 'Boné Praia', 'Boné leve e fresco para dias ensolarados', 120, 35.99, 5, 10);

-- --------------------------------------------------------

--
-- Estrutura para tabela `usuarios`
--

CREATE TABLE `usuarios` (
  `id` int(11) NOT NULL,
  `nome` varchar(100) NOT NULL,
  `senha` varchar(255) NOT NULL,
  `nivel_acesso` enum('admin','usuario') NOT NULL,
  `login` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Despejando dados para a tabela `usuarios`
--

INSERT INTO `usuarios` (`id`, `nome`, `senha`, `nivel_acesso`, `login`) VALUES
(2, 'Admin', '0192023a7bbd73250516f069df18b500', 'admin', 'admin'),
(3, 'Marcelo', 'e10adc3949ba59abbe56e057f20f883e', 'usuario', 'marcelo'),
(4, 'Teste da Silva', 'aa1bf4646de67fd9086cf6c79007026c', 'admin', 'Teste');

--
-- Índices para tabelas despejadas
--

--
-- Índices de tabela `categorias`
--
ALTER TABLE `categorias`
  ADD PRIMARY KEY (`id`);

--
-- Índices de tabela `movimentacoes`
--
ALTER TABLE `movimentacoes`
  ADD PRIMARY KEY (`id`),
  ADD KEY `produto_id` (`produto_id`);

--
-- Índices de tabela `produtos`
--
ALTER TABLE `produtos`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_categoria` (`categoria_id`);

--
-- Índices de tabela `usuarios`
--
ALTER TABLE `usuarios`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `login` (`login`);

--
-- AUTO_INCREMENT para tabelas despejadas
--

--
-- AUTO_INCREMENT de tabela `categorias`
--
ALTER TABLE `categorias`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT de tabela `movimentacoes`
--
ALTER TABLE `movimentacoes`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=172;

--
-- AUTO_INCREMENT de tabela `produtos`
--
ALTER TABLE `produtos`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=26;

--
-- AUTO_INCREMENT de tabela `usuarios`
--
ALTER TABLE `usuarios`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- Restrições para tabelas despejadas
--

--
-- Restrições para tabelas `movimentacoes`
--
ALTER TABLE `movimentacoes`
  ADD CONSTRAINT `movimentacoes_ibfk_1` FOREIGN KEY (`produto_id`) REFERENCES `produtos` (`id`);

--
-- Restrições para tabelas `produtos`
--
ALTER TABLE `produtos`
  ADD CONSTRAINT `fk_categoria` FOREIGN KEY (`categoria_id`) REFERENCES `categorias` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
