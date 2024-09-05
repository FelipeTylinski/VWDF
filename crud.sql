-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1:3306
-- Tempo de geração: 29-Jul-2024 às 20:52
-- Versão do servidor: 8.3.0
-- versão do PHP: 8.2.18

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Banco de dados: `crud`
--

-- --------------------------------------------------------

--
-- Estrutura da tabela `cadastrar`
--

DROP TABLE IF EXISTS `cadastrar`;
CREATE TABLE IF NOT EXISTS `cadastrar` (
  `id` int NOT NULL AUTO_INCREMENT,
  `nome` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(55) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `telefone` varchar(18) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `sexo` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `data_nasc` date NOT NULL,
  `cidade` varchar(45) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `estado` varchar(45) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `endereco` varchar(45) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `curso` varchar(150) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `senha` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `tipo_usuario` varchar(20) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=47 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Extraindo dados da tabela `cadastrar`
--

INSERT INTO `cadastrar` (`id`, `nome`, `email`, `telefone`, `sexo`, `data_nasc`, `cidade`, `estado`, `endereco`, `curso`, `senha`, `tipo_usuario`) VALUES
(45, 'Celso', 'celso@gmail.com', '41999663388', 'outro', '2024-07-19', 'São José dos Pinhais', 'Paraná', 'rua guarapuava', 'Técnico em Desenvolvimento de Sistemas', '223355', 'secretaria'),
(46, 'Denilson Denir Santana da Cruz', 'denilsonsantanar6@gmail.com', '41 992051604', 'masculino', '1998-04-16', 'São José dos Pinhais', 'Paraná', 'Rua Bélem 201, Bloco A apto 301', 'Técnico em Desenvolvimento de Sistemas', '142578', 'aluno');

-- --------------------------------------------------------

--
-- Estrutura da tabela `ensalamento`
--

DROP TABLE IF EXISTS `ensalamento`;
CREATE TABLE IF NOT EXISTS `ensalamento` (
  `Id` int NOT NULL AUTO_INCREMENT,
  `curso` varchar(45) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `professor` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `data` varchar(45) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `hora` time NOT NULL,
  `sala` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  PRIMARY KEY (`Id`)
) ENGINE=MyISAM AUTO_INCREMENT=27 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Extraindo dados da tabela `ensalamento`
--

INSERT INTO `ensalamento` (`Id`, `curso`, `professor`, `data`, `hora`, `sala`) VALUES
(20, 'Téc. Desenvolvimento de Sistemas', 'felipe', 'terca feira', '12:00:00', 'Lab de informática 1'),
(21, 'Téc. Alimentos', 'ana', 'terca', '19:30:00', 'Lab de informática 1'),
(22, 'Téc. Desenvolvimento de Sistemas', 'carlos', 'terca', '19:30:00', 'Lab de informática 1'),
(23, 'Téc. Alimentos', 'ana', 'quarta', '19:30:00', 'Lab de informática 1'),
(24, 'Téc. Administração', 'Rafael', '31/03/97', '16:30:00', 'Lab de informática 1');
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
