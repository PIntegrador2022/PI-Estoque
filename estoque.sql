-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Tempo de geração: 02/04/2025 às 01:11
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


INSERT INTO `categorias` (`id`, `nome`) VALUES
(1, 'Inverno'),
(2, 'Verão'),
(3, 'Primavera'),
(4, 'Outono'),
(5, 'Moda Praia');


CREATE TABLE `produtos` (
  `id` int(11) NOT NULL,
  `nome` varchar(100) NOT NULL,
  `descricao` text DEFAULT NULL,
  `quantidade` int(11) NOT NULL,
  `preco` decimal(10,2) NOT NULL,
  `categoria_id` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;


INSERT INTO `produtos` (`id`, `nome`, `descricao`, `quantidade`, `preco`, `categoria_id`) VALUES
(1, 'Casaco de Lã', 'Casaco quente para dias frios', 74, 199.99, 1),
(2, 'Blusa de Moletom', 'Blusa confortável para o inverno', 100, 89.99, 1),
(3, 'Calça Jeans Forrada', 'Calça jeans com forro térmico', 30, 149.99, 1),
(4, 'Luvas de Couro', 'Luvas resistentes para proteger do frio', 78, 49.99, 1),
(5, 'Gorro de Lã', 'Gorro estiloso para o inverno', 60, 29.99, 1),
(6, 'Camiseta Regata', 'Camiseta leve para dias quentes', 200, 39.99, 2),
(7, 'Shorts Jeans', 'Shorts casual para o verão', 150, 79.99, 2),
(8, 'Vestido Floral', 'Vestido leve e estampado', 55, 129.99, 2),
(9, 'Chinelo de Praia', 'Chinelo confortável para o verão', 120, 19.99, 2),
(10, 'Óculos de Sol', 'Proteção para os olhos nos dias ensolarados', 80, 59.99, 2),
(11, 'Jaqueta Corta-Vento', 'Jaqueta leve para dias amenos', 43, 109.99, 3),
(12, 'Saia Plissada', 'Saia elegante para a primavera', 31, 89.99, 3),
(13, 'Blusa de Seda', 'Blusa suave e estilosa', 50, 69.99, 3),
(14, 'Calça Social', 'Calça versátil para o trabalho ou passeios', 40, 99.99, 3),
(15, 'Lenço Estampado', 'Acessório charmoso para complementar o look', 100, 19.99, 3),
(16, 'Suéter de Tricô', 'Suéter quentinho para o outono', 60, 119.99, 4),
(17, 'Cardigã', 'Cardigã versátil para looks casuais', 50, 99.99, 4),
(18, 'Botas de Camurça', 'Botas estilosas para o outono', 20, 179.99, 4),
(19, 'Echarpe de Cashmere', 'Acessório elegante para dias ameno', 40, 79.99, 4),
(20, 'Calça de Veludo', 'Calça confortável e estilosa', 30, 129.99, 4),
(21, 'Biquíni Estampado', 'Conjunto de biquíni vibrante para o verão', 80, 59.99, 5),
(22, 'Sunga Masculina', 'Sunga clássica para o verão', 100, 49.99, 5),
(23, 'Canga Listrada', 'Canga prática para levar à praia', 70, 39.99, 5),
(24, 'Protetor Solar', 'Protetor solar FPS 50 para proteção máxima', 200, 29.99, 5),
(25, 'Boné Praia', 'Boné leve e fresco para dias ensolarados', 120, 35.99, 5);

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
-- Restrições para tabelas `produtos`
--
ALTER TABLE `produtos`
  ADD CONSTRAINT `fk_categoria` FOREIGN KEY (`categoria_id`) REFERENCES `categorias` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
