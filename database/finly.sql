-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Tempo de geração: 26/02/2026 às 03:56
-- Versão do servidor: 10.4.32-MariaDB
-- Versão do PHP: 8.0.30

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Banco de dados: `finly`
--

-- --------------------------------------------------------

--
-- Estrutura para tabela `simulacoes`
--

CREATE TABLE `simulacoes` (
  `id` int(11) NOT NULL,
  `usuario_id` int(11) NOT NULL,
  `nome` varchar(150) NOT NULL,
  `salario` decimal(10,2) DEFAULT NULL,
  `gastos` decimal(10,2) DEFAULT NULL,
  `meta` decimal(10,2) DEFAULT NULL,
  `extra` decimal(10,2) DEFAULT NULL,
  `valor_mensal` decimal(10,2) DEFAULT NULL,
  `tempo` varchar(100) DEFAULT NULL,
  `data` timestamp NOT NULL DEFAULT current_timestamp(),
  `favorita` tinyint(1) DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Despejando dados para a tabela `simulacoes`
--

INSERT INTO `simulacoes` (`id`, `usuario_id`, `nome`, `salario`, `gastos`, `meta`, `extra`, `valor_mensal`, `tempo`, `data`, `favorita`) VALUES
(4, 3, 'Teste', 2000.00, 500.00, 11000.00, 0.00, 1500.00, '8 mês(es)', '2026-02-19 05:17:41', 0),
(6, 3, 'Sair do Brasil', 1500.00, 700.00, 20000.00, 0.00, 800.00, '2 ano(s) e 1 mês(es)', '2026-02-19 13:34:33', 1),
(12, 1, 'Sair do Brasil', 2000.00, 700.00, 20000.00, 0.00, 1300.00, '1 ano(s) e 4 mês(es)', '2026-02-19 15:04:14', 1),
(13, 4, 'Sair do Brasil', 1000.00, 660.00, 20000.00, 0.00, 340.00, '4 ano(s) e 11 mês(es)', '2026-02-19 15:50:32', 1),
(16, 5, 'Viagem', 2000.00, 750.00, 20000.00, 0.00, 1250.00, '1 ano(s) e 4 mês(es)', '2026-02-25 23:40:27', 1);

-- --------------------------------------------------------

--
-- Estrutura para tabela `transacoes`
--

CREATE TABLE `transacoes` (
  `id` int(11) NOT NULL,
  `usuario_id` int(11) NOT NULL,
  `descricao` varchar(200) DEFAULT NULL,
  `valor` decimal(10,2) DEFAULT NULL,
  `tipo` enum('entrada','saida') DEFAULT NULL,
  `data` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Despejando dados para a tabela `transacoes`
--

INSERT INTO `transacoes` (`id`, `usuario_id`, `descricao`, `valor`, `tipo`, `data`) VALUES
(1, 3, 'Salario', 10.00, 'entrada', '2026-02-19 05:02:37'),
(2, 3, 'corte de cabelo', 30.00, 'saida', '2026-02-19 05:02:54'),
(9, 3, 'Salario', 10000.00, 'entrada', '2026-02-19 13:22:14'),
(27, 3, 'Conta de Luz', 122.00, 'entrada', '2026-02-19 14:05:43'),
(28, 3, 'Salario', 31.00, 'entrada', '2026-02-19 14:05:46'),
(29, 3, 'Conta de Luz123', 123.00, 'entrada', '2026-02-19 14:05:49'),
(30, 3, '12', 123.00, 'entrada', '2026-02-19 14:05:52'),
(50, 3, 'Fatura', 600.00, 'saida', '2026-02-19 15:07:31'),
(51, 3, 'Fatura', 600.00, 'saida', '2026-02-19 15:07:31'),
(52, 3, 'Boleto', 6000.00, 'saida', '2026-02-19 15:07:50'),
(53, 3, 'Boleto', 6000.00, 'saida', '2026-02-19 15:07:50'),
(54, 3, 'Salario', 10000.00, 'entrada', '2026-02-19 15:08:01'),
(55, 3, 'Salario', 10000.00, 'entrada', '2026-02-19 15:08:01'),
(56, 4, 'Salario', 1000.00, 'entrada', '2026-02-19 15:50:13'),
(57, 4, 'Salario', 1000.00, 'entrada', '2026-02-19 15:50:13'),
(58, 4, 'Conta de Luz', 150.00, 'saida', '2026-02-19 15:50:47'),
(59, 4, 'Conta de Luz', 150.00, 'saida', '2026-02-19 15:50:47'),
(60, 1, 'Salario', 2000.00, 'entrada', '2026-02-25 23:23:17'),
(61, 1, 'Salario', 2000.00, 'entrada', '2026-02-25 23:23:17'),
(62, 1, 'Conta de Luz', 180.00, 'saida', '2026-02-25 23:23:25'),
(63, 1, 'Conta de Luz', 180.00, 'saida', '2026-02-25 23:23:25'),
(64, 1, 'Comissao', 80.00, 'entrada', '2026-02-25 23:23:40'),
(65, 1, 'Comissao', 80.00, 'entrada', '2026-02-25 23:23:40'),
(128, 5, 'Salario', 2000.00, 'entrada', '2026-02-26 00:44:19'),
(129, 5, 'Fatura', 600.00, 'saida', '2026-02-26 00:44:30'),
(130, 5, 'Conta de Luz', 150.00, 'saida', '2026-02-26 00:44:39');

-- --------------------------------------------------------

--
-- Estrutura para tabela `usuarios`
--

CREATE TABLE `usuarios` (
  `id` int(11) NOT NULL,
  `nome` varchar(100) NOT NULL,
  `email` varchar(150) NOT NULL,
  `senha` varchar(255) NOT NULL,
  `data_criacao` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Despejando dados para a tabela `usuarios`
--

INSERT INTO `usuarios` (`id`, `nome`, `email`, `senha`, `data_criacao`) VALUES
(1, 'Gustavo Vieira', 'gustavo@gmail.com', '$2y$10$8QbAc6CVzCpW5uC0Zp/oOeThs8fhy8SFood6JRcBOfnwAIJGtLmFe', '2026-02-13 18:16:21'),
(2, 'isabelle', 'isa@gmail.com', '$2y$10$SgOp6ezEv/LBO0hTaBsaXexwdGYCNT5E8mmhS/XwHqU.Yf2NKfU3S', '2026-02-13 19:22:57'),
(3, 'João', 'joao@email', '$2y$10$SbtRd6ocHUSP0calIvYAP.HuXfs0hVt4896.OFDLUNZhmFzc2fQZG', '2026-02-19 04:31:21'),
(4, 'teste', 'teste@email', '$2y$10$a.lQdGgS3mxzcuOD/7vkQuwjERzLm76/TGR2H1kZNG2CinLZr.hc2', '2026-02-19 15:49:59'),
(5, 'admin', 'admin@teste', '$2y$10$vVRiA9ONDQ4rSKB8PX7joO3f1Ol4f08RBwckAHgvzpFDrRwkEeiRC', '2026-02-25 23:37:57');

--
-- Índices para tabelas despejadas
--

--
-- Índices de tabela `simulacoes`
--
ALTER TABLE `simulacoes`
  ADD PRIMARY KEY (`id`),
  ADD KEY `usuario_id` (`usuario_id`);

--
-- Índices de tabela `transacoes`
--
ALTER TABLE `transacoes`
  ADD PRIMARY KEY (`id`),
  ADD KEY `usuario_id` (`usuario_id`);

--
-- Índices de tabela `usuarios`
--
ALTER TABLE `usuarios`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `email` (`email`);

--
-- AUTO_INCREMENT para tabelas despejadas
--

--
-- AUTO_INCREMENT de tabela `simulacoes`
--
ALTER TABLE `simulacoes`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=17;

--
-- AUTO_INCREMENT de tabela `transacoes`
--
ALTER TABLE `transacoes`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=131;

--
-- AUTO_INCREMENT de tabela `usuarios`
--
ALTER TABLE `usuarios`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- Restrições para tabelas despejadas
--

--
-- Restrições para tabelas `simulacoes`
--
ALTER TABLE `simulacoes`
  ADD CONSTRAINT `simulacoes_ibfk_1` FOREIGN KEY (`usuario_id`) REFERENCES `usuarios` (`id`) ON DELETE CASCADE;

--
-- Restrições para tabelas `transacoes`
--
ALTER TABLE `transacoes`
  ADD CONSTRAINT `transacoes_ibfk_1` FOREIGN KEY (`usuario_id`) REFERENCES `usuarios` (`id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
