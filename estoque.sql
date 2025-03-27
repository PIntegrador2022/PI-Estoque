-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Tempo de geração: 27/03/2025 às 02:04
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
-- Estrutura para tabela `produtos`
--

CREATE TABLE `produtos` (
  `id` int(11) NOT NULL,
  `nome` varchar(100) NOT NULL,
  `descricao` text DEFAULT NULL,
  `quantidade` int(11) NOT NULL,
  `preco` decimal(10,2) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Despejando dados para a tabela `produtos`
--

INSERT INTO `produtos` (`id`, `nome`, `descricao`, `quantidade`, `preco`) VALUES
(2, 'Camisa longa', 'Camisa masculina', 20, 50.00),
(3, 'Calça Jeans ( Masculina )', 'Calça usual', 20, 230.00),
(4, 'Jaqueta motoqueiro', 'Jaqueta de alta qualidade', 18, 250.53),
(5, 'Bermuda ', 'Bermuda de verão', 15, 99.99),
(6, 'Blusa Inverno', 'Blusa Moda inverno', 23, 45.25),
(7, 'Camisa gola polo', 'camisa casual', 45, 37.55),
(8, 'Calça Moleton', 'Calça Inverno', 45, 89.99),
(9, 'Camisa Dry Fit', 'Camisa para academia', 100, 65.99),
(10, 'Bermuda Dry Fit ', 'Bermuda para academia', 45, 39.90),
(11, 'Camisa Musculação', 'Camisa para treino em academia', 25, 45.00),
(12, 'Toalha', 'Toalha para banho', 25, 32.00),
(13, 'Lençol', 'Lençol Florido', 45, 36.88),
(14, 'Almofadas ', 'Kit 3 almofadas', 45, 35.55),
(15, 'Guardanapo', 'Guardanapo para cosinha', 100, 25.00),
(16, 'camisa manga curta', 'camisa básica', 45, 39.90);

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
-- Índices de tabela `produtos`
--
ALTER TABLE `produtos`
  ADD PRIMARY KEY (`id`);

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
-- AUTO_INCREMENT de tabela `produtos`
--
ALTER TABLE `produtos`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=17;

--
-- AUTO_INCREMENT de tabela `usuarios`
--
ALTER TABLE `usuarios`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
