-- phpMyAdmin SQL Dump
-- version 4.6.4
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: 07-Fev-2017 às 00:47
-- Versão do servidor: 5.7.14
-- PHP Version: 5.6.25

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `table`
--

-- --------------------------------------------------------

--
-- Estrutura da tabela `agenda`
--

CREATE TABLE `agenda` (
  `id` int(11) NOT NULL,
  `evento` varchar(200) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `dtevento` varchar(10) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `autor` varchar(200) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `data` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `hora` varchar(5) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `conteudo` text CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `local` varchar(200) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `ativo` int(1) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Extraindo dados da tabela `agenda`
--

INSERT INTO `agenda` (`id`, `evento`, `dtevento`, `autor`, `data`, `hora`, `conteudo`, `local`, `ativo`) VALUES
(37, '', '14-12-2016', 'Ciclano da Silva', '2016-12-11 19:31:45', '21:00', '', 'Campus JK / Diamantina', 0),
(36, '', '14-12-2016', 'Ciclano da Silva', '2016-12-11 19:31:45', '19:00', '', 'Campus JK / Diamantina', 0),
(35, '', '14-12-2016', 'Ciclano da Silva', '2016-12-11 19:31:45', '12:00', '', 'Campus JK / Diamantina', 0),
(34, '', '7-11-2016', 'Ciclano da Silva', '2016-12-11 19:25:42', '14:00', '', 'Campus JK / Diamantina', 0),
(33, '', '7-11-2016', 'Ciclano da Silva', '2016-12-11 19:25:42', '13:00', '', 'Campus JK / Diamantina', 0),
(32, '', '7-11-2016', 'Ciclano da Silva', '2016-12-11 19:25:42', '12:00', '', 'Campus JK / Diamantina', 0),
(31, '', '1-1-2017', 'Ciclano da Silva', '2016-12-03 00:28:05', '12:00', '', 'Campus JK / Diamantina', 0),
(30, '', '5-12-2016', 'Ciclano da Silva', '2016-12-02 19:24:10', '19:00', '', 'Campus JK / Diamantina', 0),
(29, '', '5-12-2016', 'Ciclano da Silva', '2016-12-02 19:24:10', '14:00', '', 'Campus JK / Diamantina', 0),
(28, '', '5-12-2016', 'Ciclano da Silva', '2016-12-02 19:24:10', '13:00', '', 'Campus JK / Diamantina', 0),
(27, '', '5-12-2016', 'Ciclano da Silva', '2016-12-02 19:24:10', '08:00', '', 'Campus JK / Diamantina', 0),
(26, '', '5-12-2016', 'Ciclano da Silva', '2016-12-02 19:24:10', '07:00', '', 'Campus JK / Diamantina', 0),
(38, '', '19-1-2017', 'Ciclano da Silva', '2017-01-17 16:07:15', '12:00', '', 'Campus JK / Diamantina', 0),
(39, '', '30-1-2017', 'Mauro Ferraz', '2017-01-27 12:25:39', '07:00', '', 'asasa', 0),
(40, '', '30-1-2017', 'Mauro Ferraz', '2017-01-27 12:25:39', '08:00', '', 'asasa', 0),
(41, '', '30-1-2017', 'Mauro Ferraz', '2017-01-27 12:25:39', '13:00', '', 'asasa', 0),
(42, '', '28-1-2017', 'Mauro Ferraz', '2017-01-27 12:26:36', '13:00', '', 'asasa', 0),
(43, '', '28-1-2017', 'Mauro Ferraz', '2017-01-27 12:26:36', '14:00', '', 'asasa', 0),
(44, '', '28-1-2017', 'Mauro Ferraz', '2017-01-27 12:26:36', '15:00', '', 'asasa', 0),
(45, '', '30-1-2017', 'Ciclano da Silva', '2017-01-27 13:34:05', '12:00', '', 'Campus JK / Diamantina', 0),
(46, '', '30-1-2017', 'Ciclano da Silva', '2017-01-27 13:34:05', '13:00', '', 'Campus JK / Diamantina', 0),
(47, '', '30-1-2017', 'Ciclano da Silva', '2017-01-27 13:34:05', '14:00', '', 'Campus JK / Diamantina', 0),
(60, '', '12-2-2017', 'Ciclano da Silva', '2017-02-06 23:16:14', '08:00', '', 'Campus JK / Diamantina', 0),
(49, '', '30-1-2017', 'Ciclano da Silva', '2017-01-27 15:54:35', '18:00', '', 'Campus JK / Diamantina', 0),
(50, '', '30-1-2017', 'Ciclano da Silva', '2017-01-27 15:54:35', '19:00', '', 'Campus JK / Diamantina', 0),
(51, '', '14-2-2017', 'Ciclano da Silva', '2017-02-06 15:42:22', '12:00', '', 'Campus JK / Diamantina', 0),
(52, '', '14-2-2017', 'Ciclano da Silva', '2017-02-06 15:42:22', '13:00', '', 'Campus JK / Diamantina', 0),
(53, '', '14-2-2017', 'Ciclano da Silva', '2017-02-06 15:42:22', '18:00', '', 'Campus JK / Diamantina', 0),
(62, '', '20-3-2017', 'Ciclano da Silva', '2017-02-06 23:17:30', '12:00', '', 'Campus JK / Diamantina', 0),
(69, '', '16-2-2017', 'Ciclano da Silva', '2017-02-06 23:23:16', '13:00', '', 'Campus JK / Diamantina', 0),
(68, '', '16-2-2017', 'Ciclano da Silva', '2017-02-06 23:23:16', '12:00', '', 'Campus JK / Diamantina', 0),
(67, '', '12-2-2017', 'Ciclano da Silva', '2017-02-06 23:20:16', '15:00', '', 'Campus JK / Diamantina', 0),
(70, '', '16-2-2017', 'Ciclano da Silva', '2017-02-06 23:23:16', '14:00', '', 'Campus JK / Diamantina', 0),
(71, '', '16-2-2017', 'Ciclano da Silva', '2017-02-06 23:23:16', '15:00', '', 'Campus JK / Diamantina', 0),
(72, '', '16-2-2017', 'Ciclano da Silva', '2017-02-06 23:23:16', '16:00', '', 'Campus JK / Diamantina', 0),
(73, '', '19-2-2017', 'Ciclano da Silva', '2017-02-06 23:39:54', '12:00', '', 'Campus JK / Diamantina', 0),
(74, '', '26-2-2017', 'Ciclano da Silva', '2017-02-06 23:43:49', '08:00', '', 'Campus JK / Diamantina', 0),
(75, '', '17-2-2017', 'Ciclano da Silva', '2017-02-07 00:04:25', '12:00', '', 'Campus JK / Diamantina', 1),
(76, '', '17-2-2017', 'Ciclano da Silva', '2017-02-07 00:04:25', '17:00', '', 'Campus JK / Diamantina', 1),
(77, '', '17-2-2017', 'Ciclano da Silva', '2017-02-07 00:04:25', '13:00', '', 'Campus JK / Diamantina', 1),
(78, '', '17-2-2017', 'Ciclano da Silva', '2017-02-07 00:04:25', '18:00', '', 'Campus JK / Diamantina', 0);

-- --------------------------------------------------------

--
-- Estrutura da tabela `arquivoatendimentopsicologico`
--

CREATE TABLE `arquivoatendimentopsicologico` (
  `id` int(11) NOT NULL,
  `cpfusuario` varchar(11) COLLATE utf8_unicode_ci NOT NULL,
  `statusatendimento` varchar(3) COLLATE utf8_unicode_ci NOT NULL,
  `statusencaminhamento` varchar(3) COLLATE utf8_unicode_ci NOT NULL,
  `encaminhamento` text COLLATE utf8_unicode_ci NOT NULL,
  `motivo` text COLLATE utf8_unicode_ci NOT NULL,
  `data` varchar(10) COLLATE utf8_unicode_ci NOT NULL,
  `hora` varchar(5) COLLATE utf8_unicode_ci NOT NULL,
  `local` varchar(60) COLLATE utf8_unicode_ci NOT NULL,
  `arquivadopor` varchar(11) COLLATE utf8_unicode_ci DEFAULT NULL,
  `cancelado` varchar(15) COLLATE utf8_unicode_ci NOT NULL,
  `idagendamento` int(11) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Extraindo dados da tabela `arquivoatendimentopsicologico`
--

INSERT INTO `arquivoatendimentopsicologico` (`id`, `cpfusuario`, `statusatendimento`, `statusencaminhamento`, `encaminhamento`, `motivo`, `data`, `hora`, `local`, `arquivadopor`, `cancelado`, `idagendamento`) VALUES
(1, '', 'Sim', 'Não', '', 'a', '14-12-2016', '12:00', 'Campus JK / Diamantina', '0', '', 0),
(2, '', 'Sim', 'Não', '', 'a', '14-12-2016', '12:00', 'Campus JK / Diamantina', '0', '', 0),
(3, '', 'Sim', 'Não', '', 'a', '14-12-2016', '12:00', 'Campus JK / Diamantina', '0', '', 0),
(4, '', 'Sim', 'Não', '', 'a', '14-12-2016', '12:00', 'Campus JK / Diamantina', '0', '', 0),
(5, '', 'Sim', 'Não', '', 'a', '14-12-2016', '12:00', 'Campus JK / Diamantina', '0', '', 0),
(6, '00000000000', 'Sim', 'Não', '', 'a', '14-12-2016', '12:00', 'Campus JK / Diamantina', '0', '', 0),
(7, '12345678910', 'Sim', 'Sim', 'Dr Joao', 'Problemas Familiares', '16-12-2016', '15:00', 'Campus Mucuri', '0', '', 0),
(8, '00000000000', 'Não', 'Não', '', 'dsf', '14-12-2016', '21:00', 'Campus JK / Diamantina', '00000000000', '', 0),
(9, '00000000000', 'Sim', 'Sim', 'Fulano', 'Aaafasfafas', '14-12-2016', '12:00', 'Campus JK / Diamantina', '00000000000', '', 0),
(10, '00000000000', 'Não', 'Não', '', 'a', '19-1-2017', '12:00', 'Campus JK / Diamantina', '00000000000', '', 0),
(11, '00000000000', '', '', '', '', '19-1-2017', '12:00', 'Campus JK / Diamantina', '00000000000', '', 0),
(12, '98765432101', 'Sim', 'Sim', 'a', '', '14-12-2016', '12:00', 'aa', '00000000000', '', 0),
(13, '00000000000', 'Não', 'Não', 'asaadad', '', '30-1-2017', '07:00', 'Campus JK / Diamantina', '00000000000', '', 0),
(14, '00000000000', 'Não', 'Não', '', '', '30-1-2017', '13:00', 'Campus JK / Diamantina', '00000000000', '', 0),
(15, '98765432101', 'Não', 'Não', 'asa', '', '30-1-2017', '07:00', 'Campus JK / Diamantina', '00000000000', '', 0),
(16, '00000000000', 'Não', 'Não', '', '', '30-1-2017', '08:00', 'Campus JK / Diamantina', '00000000000', '', 0),
(17, '00000000000', 'Não', 'Não', 'aa', '', '30-1-2017', '17:00', 'Campus JK / Diamantina', '00000000000', '', 0),
(18, '00000000000', 'Não', 'Não', 'ssssssssssss', '', '30-1-2017', '19:00', 'Campus JK / Diamantina', '00000000000', '', 0),
(19, '00000000000', 'Não', 'Não', 'dfd', '', '30-1-2017', '17:00', 'Campus JK / Diamantina', '00000000000', 'Não', 0),
(20, '48', '', '', '', '', '30-1-2017', '17:00', 'Campus JK / Diamantina', NULL, 'Sim', 0),
(21, '48', '', '', '', '', '30-1-2017', '17:00', 'Campus JK / Diamantina', NULL, 'Sim', 0),
(22, '00000000000', '', '', '', '', '30-1-2017', '17:00', 'Campus JK / Diamantina', NULL, 'Sim', 0),
(23, '00000000000', '', '', '', '', '30-1-2017', '17:00', 'Campus JK / Diamantina', NULL, 'Sim', 0),
(24, '00000000000', 'Não', 'Não', 'asasa', 'aaas', '30-1-2017', '17:00', 'Campus JK / Diamantina', NULL, 'Sim', 0),
(25, '00000000000', 'Não', 'Não', 'aa', 'aa', '14-2-2017', '13:00', 'Campus JK / Diamantina', NULL, 'Sim', 0),
(26, '00000000000', 'Não', 'Não', 'a', '', '14-2-2017', '12:00', 'Campus JK / Diamantina', '00000000000', 'Realizado', 0),
(27, '00000000000', 'Não', 'Sim', 'a', '', '14-2-2017', '13:00', 'Campus JK / Diamantina', '00000000000', 'Não Realizado', 0),
(28, '', '', '', '', '', '14-2-2017', '12:00', 'Campus JK / Diamantina', NULL, 'Cancelado', 0),
(29, '', '', '', '', '', '14-2-2017', '12:00', 'Campus JK / Diamantina', NULL, 'Cancelado', 0),
(30, '', '', '', '', '', '30-1-2017', '17:00', 'Campus JK / Diamantina', NULL, 'Cancelado', 0),
(31, '', '', '', '', '', '30-1-2017', '17:00', 'Campus JK / Diamantina', NULL, 'Cancelado', 0),
(32, '', '', '', '', '', '30-1-2017', '17:00', 'Campus JK / Diamantina', NULL, 'Cancelado', 0),
(33, '00000000000', 'Não', 'Não', 'a', '', '12-2-2017', '08:00', 'Campus JK / Diamantina', '00000000000', 'Não Realizado', 0),
(34, '00000000000', 'Sim', 'Sim', 'a', '', '20-3-2017', '12:00', 'Campus JK / Diamantina', '00000000000', 'Não Realizado', 0),
(35, '98765432101', 'Não', 'Não', 'a', '', '14-2-2017', '12:00', 'Campus JK / Diamantina', '00000000000', 'Não Realizado', 0),
(36, '00000000000', 'Não', 'Sim', 'a', '', '12-2-2017', '15:00', 'Campus JK / Diamantina', '00000000000', 'Não Realizado', 0),
(37, '00000000000', 'Não', 'Sim', 'a', '', '16-2-2017', '16:00', 'Campus JK / Diamantina', '00000000000', 'Não Realizado', 0),
(38, '00000000000', 'Não', 'Não', 'a', '', '16-2-2017', '12:00', 'Campus JK / Diamantina', '00000000000', 'Não Realizado', 0),
(39, '00000000000', 'Não', 'Não', 'a', '', '16-2-2017', '12:00', 'Campus JK / Diamantina', '00000000000', 'Não Realizado', 0),
(40, '00000000000', 'Não', 'Não', 'a', 'a', '16-2-2017', '12:00', 'Campus JK / Diamantina', NULL, 'Cancelado', 0),
(41, '00000000000', 'Não', 'Não', 'a', '', '16-2-2017', '12:00', 'Campus JK / Diamantina', '00000000000', 'Realizado', 0),
(42, '00000000000', 'Não', 'Não', 'a', '', '16-2-2017', '12:00', 'Campus JK / Diamantina', '00000000000', 'Não Realizado', 0),
(43, '00000000000', 'Não', 'Não', 'a', 'a', '19-2-2017', '12:00', 'Campus JK / Diamantina', NULL, 'Cancelado', 73),
(44, '00000000000', 'Não', 'Não', 'a', 'a', '26-2-2017', '08:00', 'Campus JK / Diamantina', NULL, 'Cancelado', 74),
(45, '00000000000', 'Não', 'Sim', 'a', '', '26-2-2017', '08:00', 'Campus JK / Diamantina', '00000000000', 'Realizado', 74),
(46, '00000000000', 'Sim', 'Sim', 'a', '', '19-2-2017', '12:00', 'Campus JK / Diamantina', '00000000000', 'Não Realizado', 73);

-- --------------------------------------------------------

--
-- Estrutura da tabela `atendimentopsicologico`
--

CREATE TABLE `atendimentopsicologico` (
  `id` int(11) NOT NULL,
  `cpfusuario` varchar(11) COLLATE utf8_unicode_ci NOT NULL,
  `statusatendimento` varchar(3) COLLATE utf8_unicode_ci NOT NULL,
  `statusencaminhamento` varchar(3) COLLATE utf8_unicode_ci NOT NULL,
  `encaminhamento` text COLLATE utf8_unicode_ci NOT NULL,
  `motivo` text COLLATE utf8_unicode_ci NOT NULL,
  `data` varchar(10) COLLATE utf8_unicode_ci NOT NULL,
  `hora` varchar(5) COLLATE utf8_unicode_ci NOT NULL,
  `local` varchar(60) COLLATE utf8_unicode_ci NOT NULL,
  `idagendamento` int(11) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Extraindo dados da tabela `atendimentopsicologico`
--

INSERT INTO `atendimentopsicologico` (`id`, `cpfusuario`, `statusatendimento`, `statusencaminhamento`, `encaminhamento`, `motivo`, `data`, `hora`, `local`, `idagendamento`) VALUES
(47, '00000000000', 'Não', 'Não', 'a', 'a', '17-2-2017', '12:00', 'Campus JK / Diamantina', 78);

-- --------------------------------------------------------

--
-- Estrutura da tabela `docente`
--

CREATE TABLE `docente` (
  `cpf` varchar(11) COLLATE utf8_unicode_ci NOT NULL,
  `siape` int(20) NOT NULL,
  `campus` varchar(60) COLLATE utf8_unicode_ci NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Extraindo dados da tabela `docente`
--

INSERT INTO `docente` (`cpf`, `siape`, `campus`) VALUES
('11144620635', 254452, 'jk'),
('548784545', 1122, 'aa');

-- --------------------------------------------------------

--
-- Estrutura da tabela `ead`
--

CREATE TABLE `ead` (
  `cpf` varchar(11) COLLATE utf8_unicode_ci NOT NULL,
  `matricula` varchar(15) COLLATE utf8_unicode_ci NOT NULL,
  `curso` varchar(60) COLLATE utf8_unicode_ci NOT NULL,
  `polo` varchar(60) COLLATE utf8_unicode_ci NOT NULL,
  `periodo` int(2) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Extraindo dados da tabela `ead`
--

INSERT INTO `ead` (`cpf`, `matricula`, `curso`, `polo`, `periodo`) VALUES
('545464861', '445', 'dffd', 'dfd', 1);

-- --------------------------------------------------------

--
-- Estrutura da tabela `funcionario`
--

CREATE TABLE `funcionario` (
  `cpf` varchar(11) COLLATE utf8_unicode_ci NOT NULL,
  `empresa` varchar(60) COLLATE utf8_unicode_ci NOT NULL,
  `funcao` varchar(60) COLLATE utf8_unicode_ci NOT NULL,
  `campus` varchar(60) COLLATE utf8_unicode_ci NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Extraindo dados da tabela `funcionario`
--

INSERT INTO `funcionario` (`cpf`, `empresa`, `funcao`, `campus`) VALUES
('09404905607', 'atair', 'atador', 'atiranele');

-- --------------------------------------------------------

--
-- Estrutura da tabela `graduacao`
--

CREATE TABLE `graduacao` (
  `matricula` varchar(15) COLLATE utf8_unicode_ci NOT NULL,
  `cpf` varchar(11) COLLATE utf8_unicode_ci NOT NULL,
  `curso` varchar(60) COLLATE utf8_unicode_ci NOT NULL,
  `campus` varchar(60) COLLATE utf8_unicode_ci NOT NULL,
  `periodo` int(2) NOT NULL,
  `turno` varchar(15) COLLATE utf8_unicode_ci NOT NULL,
  `bolsista` tinyint(1) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Extraindo dados da tabela `graduacao`
--

INSERT INTO `graduacao` (`matricula`, `cpf`, `curso`, `campus`, `periodo`, `turno`, `bolsista`) VALUES
('21212', '11111111111', 'aaa', 'aaa', 1, '1', 1),
('21212', '98765432101', 'aaa', 'Campus JK / Diamantina', 2, '2', 1),
('3243423', '13123122', 'Letras Português/Espanhol', 'Campus JK / Diamantina', 2, '2', 1);

-- --------------------------------------------------------

--
-- Estrutura da tabela `login`
--

CREATE TABLE `login` (
  `id` int(11) NOT NULL,
  `user` varchar(32) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `pass` varchar(32) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `cpf` varchar(11) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `regIP` varchar(15) CHARACTER SET utf32 COLLATE utf32_unicode_ci NOT NULL DEFAULT '',
  `dt` datetime NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Extraindo dados da tabela `login`
--

INSERT INTO `login` (`id`, `user`, `pass`, `cpf`, `regIP`, `dt`) VALUES
(1, 'admin', '202cb962ac59075b964b07152d234b70', '00000000000', '', '2016-11-21 00:00:00'),
(2, 'ead', '202cb962ac59075b964b07152d234b70', '11111111111', '127.0.0.1', '2017-01-11 16:59:40'),
(3, 'psicologo', '202cb962ac59075b964b07152d234b70', '09407779670', '127.0.0.1', '2017-01-11 17:09:20'),
(4, 'graduacao', '202cb962ac59075b964b07152d234b70', '98765432101', '127.0.0.1', '2017-01-11 17:23:27'),
(5, 'contatonabr@gmail.com', '45d5e53f54130efbdd23a35d64e9f399', '545464861', '127.0.0.1', '2017-01-11 17:23:52'),
(6, 'aloha@oi.com.br', '540d273c1daf0fe413ead4e1e1be8b8e', '548784545', '127.0.0.1', '2017-01-11 17:25:02'),
(7, 'dsdadd@gmail.com', 'a6d1b0e1d97018ec306d60583e79f125', '13123122', '127.0.0.1', '2017-02-06 22:45:12');

-- --------------------------------------------------------

--
-- Estrutura da tabela `posgraduacao`
--

CREATE TABLE `posgraduacao` (
  `cpf` varchar(11) COLLATE utf8_unicode_ci NOT NULL,
  `matricula` varchar(15) COLLATE utf8_unicode_ci NOT NULL,
  `curso` varchar(60) COLLATE utf8_unicode_ci NOT NULL,
  `campus` varchar(60) COLLATE utf8_unicode_ci NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Extraindo dados da tabela `posgraduacao`
--

INSERT INTO `posgraduacao` (`cpf`, `matricula`, `curso`, `campus`) VALUES
('98765432101', '12515145', 'asdasd', 'asdad');

-- --------------------------------------------------------

--
-- Estrutura da tabela `tecnico`
--

CREATE TABLE `tecnico` (
  `cpf` varchar(11) COLLATE utf8_unicode_ci NOT NULL,
  `siape` int(20) NOT NULL,
  `setor` varchar(60) COLLATE utf8_unicode_ci NOT NULL,
  `campus` varchar(60) COLLATE utf8_unicode_ci NOT NULL,
  `departamento` varchar(60) COLLATE utf8_unicode_ci NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Extraindo dados da tabela `tecnico`
--

INSERT INTO `tecnico` (`cpf`, `siape`, `setor`, `campus`, `departamento`) VALUES
('00000000000', 121185454, 'Psicólogo', 'Campus JK / Diamantina', 'PROACE'),
('00246545666', 125879, 'defesa', 'jk', 'dois');

-- --------------------------------------------------------

--
-- Estrutura da tabela `usuarios`
--

CREATE TABLE `usuarios` (
  `id` int(11) NOT NULL,
  `nome` varchar(120) COLLATE utf8_unicode_ci NOT NULL,
  `cpf` varchar(11) COLLATE utf8_unicode_ci NOT NULL,
  `nascimento` date NOT NULL,
  `sexo` varchar(1) COLLATE utf8_unicode_ci NOT NULL,
  `cidade` varchar(30) COLLATE utf8_unicode_ci NOT NULL,
  `estado` varchar(2) COLLATE utf8_unicode_ci NOT NULL,
  `telefonepref` varchar(15) COLLATE utf8_unicode_ci NOT NULL,
  `telefonealt` varchar(15) COLLATE utf8_unicode_ci DEFAULT NULL,
  `email` varchar(30) COLLATE utf8_unicode_ci NOT NULL,
  `classeusuario` int(1) NOT NULL,
  `campus` varchar(60) COLLATE utf8_unicode_ci NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Extraindo dados da tabela `usuarios`
--

INSERT INTO `usuarios` (`id`, `nome`, `cpf`, `nascimento`, `sexo`, `cidade`, `estado`, `telefonepref`, `telefonealt`, `email`, `classeusuario`, `campus`) VALUES
(1, 'Ciclano da Silva', '00000000000', '1996-12-06', 'M', 'Caxambu', 'MG', '854878', '87878', 'oi@oi.com', 1, 'Campus JK / Diamantina'),
(24, 'NEUZA SANTOS LEITE', '09404905607', '2017-01-17', 'F', 'minas novas', 'AC', '33991478260', '3391478545', 'nanda.macedo.san@gmail.com', 6, ''),
(25, 'Lucas Izumi De Oliveira', '11111111111', '2017-01-25', 'M', 'Caxambu', 'MG', '35991334319', '35991334319', 'ead', 5, 'aaa'),
(27, 'Mauro Ferraz', '09407779670', '2017-01-16', 'M', 'Estes Park', 'RJ', '35991334319', '35991334319', 'psicologo', 8, 'asasa'),
(28, 'Lucas', '98765432101', '2002-01-03', 'F', 'Diamantina', 'MG', '3891232926', '3891232926', 'graduacao', 2, 'Campus JK / Diamantina'),
(29, 'Jose Maria', '545464861', '2017-01-03', 'M', 'Estes Park', 'PB', '3891232926', '3891232926', 'contatonabr@gmail.com', 5, ''),
(30, 'aloja', '548784545', '2017-01-16', 'F', 'Caxambu', 'MG', '35991334319', '35991334319', 'aloha@oi.com.br', 4, ''),
(31, 'Randoman', '13123122', '2017-02-08', 'O', 'Caxambu', 'MG', '3891232926', '3891232926', 'dsdadd@gmail.com', 2, 'Campus JK / Diamantina');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `agenda`
--
ALTER TABLE `agenda`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `arquivoatendimentopsicologico`
--
ALTER TABLE `arquivoatendimentopsicologico`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `atendimentopsicologico`
--
ALTER TABLE `atendimentopsicologico`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `docente`
--
ALTER TABLE `docente`
  ADD PRIMARY KEY (`cpf`);

--
-- Indexes for table `ead`
--
ALTER TABLE `ead`
  ADD PRIMARY KEY (`cpf`);

--
-- Indexes for table `funcionario`
--
ALTER TABLE `funcionario`
  ADD PRIMARY KEY (`cpf`);

--
-- Indexes for table `graduacao`
--
ALTER TABLE `graduacao`
  ADD PRIMARY KEY (`cpf`);

--
-- Indexes for table `login`
--
ALTER TABLE `login`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `posgraduacao`
--
ALTER TABLE `posgraduacao`
  ADD PRIMARY KEY (`cpf`);

--
-- Indexes for table `tecnico`
--
ALTER TABLE `tecnico`
  ADD PRIMARY KEY (`cpf`);

--
-- Indexes for table `usuarios`
--
ALTER TABLE `usuarios`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `agenda`
--
ALTER TABLE `agenda`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=79;
--
-- AUTO_INCREMENT for table `arquivoatendimentopsicologico`
--
ALTER TABLE `arquivoatendimentopsicologico`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=47;
--
-- AUTO_INCREMENT for table `atendimentopsicologico`
--
ALTER TABLE `atendimentopsicologico`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=48;
--
-- AUTO_INCREMENT for table `login`
--
ALTER TABLE `login`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;
--
-- AUTO_INCREMENT for table `usuarios`
--
ALTER TABLE `usuarios`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=32;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
