-- phpMyAdmin SQL Dump
-- version 4.8.3
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: 18-Set-2019 às 21:50
-- Versão do servidor: 10.1.37-MariaDB
-- versão do PHP: 7.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `cena`
--

-- --------------------------------------------------------

--
-- Estrutura da tabela `cliente`
--

CREATE TABLE `cliente` (
  `id` int(11) NOT NULL,
  `id_company` int(11) DEFAULT NULL,
  `cliente_nome` varchar(200) DEFAULT NULL,
  `cliente_email` varchar(45) DEFAULT NULL,
  `cliente_rg` varchar(10) DEFAULT NULL COMMENT '530831090',
  `cliente_cpf` varchar(11) DEFAULT NULL,
  `clend_id` int(11) DEFAULT NULL,
  `cliente_responsavel` varchar(45) DEFAULT NULL,
  `acesso` varchar(1) DEFAULT '0',
  `acesso_criado` varchar(1) DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Extraindo dados da tabela `cliente`
--

INSERT INTO `cliente` (`id`, `id_company`, `cliente_nome`, `cliente_email`, `cliente_rg`, `cliente_cpf`, `clend_id`, `cliente_responsavel`, `acesso`, `acesso_criado`) VALUES
(40, 1, 'Marcos Varella', 'marcos@marcos', NULL, NULL, NULL, 'josé', '1', '1'),
(47, 1, 'CNA Spitaletti', 'cna@cna.com.br', '', '', NULL, 'josé', '0', '1'),
(48, 1, 'P4 Engenharia', '', '', '', NULL, NULL, '0', '1'),
(49, 1, 'P4 Engenharia', 'adm@p4', NULL, NULL, NULL, 'Tiago', '0', '0');

-- --------------------------------------------------------

--
-- Estrutura da tabela `cliente_endereco`
--

CREATE TABLE `cliente_endereco` (
  `id_endereco` int(11) NOT NULL,
  `clc_id` int(11) DEFAULT NULL,
  `rua` varchar(255) DEFAULT NULL,
  `numero` varchar(5) DEFAULT NULL,
  `bairro` varchar(45) DEFAULT NULL,
  `cidade` varchar(45) DEFAULT NULL,
  `estado` varchar(2) DEFAULT NULL,
  `cep` varchar(8) DEFAULT NULL,
  `complemento` varchar(120) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Extraindo dados da tabela `cliente_endereco`
--

INSERT INTO `cliente_endereco` (`id_endereco`, `clc_id`, `rua`, `numero`, `bairro`, `cidade`, `estado`, `cep`, `complemento`) VALUES
(12, NULL, 'Alameda das Margaridas', '123', 'Alphaville', 'Santana de Parnaíba', 'SP', '06539270', NULL);

-- --------------------------------------------------------

--
-- Estrutura da tabela `companies`
--

CREATE TABLE `companies` (
  `id` int(11) NOT NULL,
  `name` varchar(45) COLLATE utf8_bin DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

--
-- Extraindo dados da tabela `companies`
--

INSERT INTO `companies` (`id`, `name`) VALUES
(1, 'Cena');

-- --------------------------------------------------------

--
-- Estrutura da tabela `concessionaria`
--

CREATE TABLE `concessionaria` (
  `id` int(11) NOT NULL,
  `razao_social` varchar(255) DEFAULT NULL,
  `id_company` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Extraindo dados da tabela `concessionaria`
--

INSERT INTO `concessionaria` (`id`, `razao_social`, `id_company`) VALUES
(75, 'Enel', 1);

-- --------------------------------------------------------

--
-- Estrutura da tabela `concessionaria_servico`
--

CREATE TABLE `concessionaria_servico` (
  `id` int(11) NOT NULL,
  `id_concessionaria` int(11) DEFAULT NULL,
  `id_servico` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Extraindo dados da tabela `concessionaria_servico`
--

INSERT INTO `concessionaria_servico` (`id`, `id_concessionaria`, `id_servico`) VALUES
(95, 66, 6),
(96, 65, 6),
(97, 67, 7),
(98, 68, 18),
(99, 68, 0),
(100, 68, 0),
(101, 68, 0),
(102, 68, 0),
(103, 68, 6),
(104, 69, 18),
(105, 70, 18),
(106, 71, 18),
(107, 72, 18),
(108, 73, 18),
(109, 74, 18),
(110, 75, 18),
(111, 76, 18),
(114, 76, 19),
(115, 76, 20),
(116, 76, 23),
(117, 76, 22),
(118, 74, 24),
(119, 76, 24),
(120, 74, 23),
(121, 74, 20),
(122, 75, 19),
(123, 75, 0);

-- --------------------------------------------------------

--
-- Estrutura da tabela `documentos`
--

CREATE TABLE `documentos` (
  `id` int(11) NOT NULL,
  `docs_nome` varchar(255) DEFAULT NULL,
  `id_company` int(11) DEFAULT NULL,
  `docs_link` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Estrutura da tabela `documentos_obra`
--

CREATE TABLE `documentos_obra` (
  `id` int(11) NOT NULL,
  `id_documento` int(11) DEFAULT NULL,
  `id_obra` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Estrutura da tabela `documento_etapa`
--

CREATE TABLE `documento_etapa` (
  `id_etapa_documento` int(11) NOT NULL,
  `id_etapa_obra` int(11) DEFAULT NULL,
  `id_documento` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Extraindo dados da tabela `documento_etapa`
--

INSERT INTO `documento_etapa` (`id_etapa_documento`, `id_etapa_obra`, `id_documento`) VALUES
(1, 97, 72),
(2, 84, 97),
(3, 97, 85),
(4, 91, 86),
(5, 113, 87),
(6, 111, 89),
(7, 111, 90),
(8, 111, 91),
(9, 111, 92),
(10, 161, 111),
(11, 160, 1);

-- --------------------------------------------------------

--
-- Estrutura da tabela `etapa`
--

CREATE TABLE `etapa` (
  `id` int(11) NOT NULL,
  `etp_nome` varchar(255) DEFAULT NULL,
  `tipo` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Extraindo dados da tabela `etapa`
--

INSERT INTO `etapa` (`id`, `etp_nome`, `tipo`) VALUES
(1, 'Aprovação projeto implantação', 2),
(2, 'Aprovação projeto Civil', 2),
(3, 'Confecção custo de rede', 2),
(4, 'Execução do serviço de rede', 2),
(5, 'Reserva de equipamento', 2),
(6, 'Contrato de fornecimento', 2),
(7, 'Pedido de vistoria', 2),
(8, 'Pedido de ligação', 2),
(9, 'Carta de autorização', 1),
(10, 'Contrato social', 1),
(11, 'CNPJ', 1),
(12, 'Comprovante de propriedade do imóvel', 1),
(13, 'Projeto de implantação aprovado', 1),
(14, 'Projeto Construtivo e ART', 1),
(15, 'Relação de carga', 1),
(16, 'Confecção projeto executivo civil', 1),
(17, 'Visita Programação de Obras', 3),
(18, 'Compra de Materiais', 3),
(19, 'programação de Entrega', 3),
(20, 'Contratação de Escavação', 3),
(21, 'Instalação de Pedestal', 3),
(22, 'Programação de Materiais', 3),
(23, 'Novo ADMIN', 1),
(24, 'Nova Com', 2),
(25, 'Nova Obra', 3),
(26, 'Art e CREA', 2),
(27, 'Abertura APPJ', 2),
(28, 'Contrato de obras', 2),
(29, 'Boleto de obras', 2),
(30, 'Laudo de Aterramento', 1),
(31, 'Laudo de ensaio BW', 1),
(32, 'Confecção do aterramento', 3),
(33, 'Lançamento dos dutos BT', 3),
(34, 'Lançamento dos dutos MT', 3),
(35, 'Tapete trafo', 3),
(36, 'Tampa ferro fundido ', 3),
(37, 'Furos tecnicos', 3),
(38, 'Confecção do projeto civil', 2),
(39, 'Abertura APPJ', 2);

-- --------------------------------------------------------

--
-- Estrutura da tabela `etapas_servico_concessionaria`
--

CREATE TABLE `etapas_servico_concessionaria` (
  `id` int(11) NOT NULL,
  `id_concessionaria` int(11) DEFAULT NULL,
  `id_servico` int(11) DEFAULT NULL,
  `id_etapa` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Extraindo dados da tabela `etapas_servico_concessionaria`
--

INSERT INTO `etapas_servico_concessionaria` (`id`, `id_concessionaria`, `id_servico`, `id_etapa`) VALUES
(112, 68, 6, 9),
(121, 68, 6, 10),
(122, 68, 6, 3),
(124, 68, 6, 17),
(126, 68, 6, 18),
(127, 68, 6, 19),
(128, 68, 6, 20),
(130, 68, 18, 9),
(131, 68, 6, 13),
(132, 68, 6, 11),
(135, 69, 18, 1),
(136, 69, 18, 5),
(137, 69, 18, 8),
(138, 69, 18, 9),
(139, 69, 18, 10),
(140, 69, 18, 11),
(141, 69, 18, 12),
(142, 69, 18, 21),
(143, 70, 18, 1),
(144, 70, 18, 9),
(145, 70, 18, 17),
(146, 71, 18, 1),
(147, 71, 18, 2),
(148, 71, 18, 3),
(149, 71, 18, 9),
(150, 71, 18, 10),
(151, 71, 18, 11),
(152, 71, 18, 17),
(153, 71, 18, 18),
(154, 71, 18, 19),
(155, 72, 18, 1),
(156, 72, 18, 9),
(157, 72, 18, 17),
(163, 73, 18, 1),
(164, 73, 18, 2),
(183, 73, 18, 23),
(184, 73, 18, 24),
(185, 73, 18, 25),
(198, 74, 18, 9),
(199, 74, 18, 10),
(200, 74, 18, 11),
(201, 74, 18, 12),
(202, 74, 18, 13),
(203, 74, 18, 14),
(204, 74, 18, 15),
(205, 74, 18, 16),
(206, 74, 18, 30),
(207, 74, 18, 31),
(208, 74, 18, 17),
(209, 74, 18, 18),
(210, 74, 18, 19),
(211, 74, 18, 20),
(212, 74, 18, 21),
(213, 74, 18, 32),
(218, 74, 18, 37),
(219, 74, 18, 33),
(220, 74, 18, 34),
(221, 74, 18, 35),
(223, 74, 18, 1),
(224, 74, 18, 38),
(225, 74, 18, 2),
(226, 74, 18, 39),
(227, 74, 18, 3),
(228, 74, 18, 28),
(229, 74, 18, 29),
(230, 74, 18, 36),
(231, 74, 20, 6),
(232, 74, 20, 3),
(233, 74, 20, 5),
(234, 74, 20, 15),
(235, 74, 20, 12),
(236, 74, 20, 19),
(237, 74, 20, 37),
(238, 75, 19, 1),
(239, 75, 19, 2),
(240, 75, 19, 3),
(241, 75, 19, 4),
(242, 75, 19, 9),
(243, 75, 19, 10),
(244, 75, 19, 11),
(245, 75, 19, 12),
(246, 75, 19, 17),
(247, 75, 19, 18),
(248, 75, 19, 19),
(249, 75, 19, 20);

-- --------------------------------------------------------

--
-- Estrutura da tabela `etapa_tipo`
--

CREATE TABLE `etapa_tipo` (
  `id_etapatipo` int(11) NOT NULL,
  `nome` varchar(55) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Extraindo dados da tabela `etapa_tipo`
--

INSERT INTO `etapa_tipo` (`id_etapatipo`, `nome`) VALUES
(1, 'ADMINISTRATIVA'),
(2, 'CONCESSIONARIA'),
(3, 'OBRA');

-- --------------------------------------------------------

--
-- Estrutura da tabela `notificacao_usuario`
--

CREATE TABLE `notificacao_usuario` (
  `id_not_user` int(11) NOT NULL,
  `id_user` int(11) DEFAULT NULL,
  `id_notificacao` int(11) DEFAULT NULL,
  `lido` int(11) DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Extraindo dados da tabela `notificacao_usuario`
--

INSERT INTO `notificacao_usuario` (`id_not_user`, `id_user`, `id_notificacao`, `lido`) VALUES
(17, 6, 168, 0),
(18, 2, 168, 0),
(19, 1, 168, 1),
(20, 7, 168, 0),
(21, 6, 169, 0),
(22, 2, 169, 0),
(23, 1, 169, 1),
(24, 7, 169, 0),
(25, 6, 170, 0),
(26, 2, 170, 0),
(27, 1, 170, 1),
(28, 7, 170, 0),
(29, 6, 171, 0),
(30, 2, 171, 0),
(31, 1, 171, 1),
(32, 7, 171, 0),
(33, 6, 172, 0),
(34, 2, 172, 0),
(35, 1, 172, 1),
(36, 7, 172, 0),
(37, 6, 173, 0),
(38, 2, 173, 0),
(39, 1, 173, 1),
(40, 7, 173, 0),
(41, 6, 174, 0),
(42, 2, 174, 0),
(43, 1, 174, 1),
(44, 7, 174, 0),
(45, 6, 175, 0),
(46, 2, 175, 0),
(47, 1, 175, 1),
(48, 7, 175, 0),
(49, 6, 176, 0),
(50, 2, 176, 0),
(51, 1, 176, 1),
(52, 7, 176, 0),
(53, 6, 177, 0),
(54, 2, 177, 0),
(55, 1, 177, 1),
(56, 7, 177, 0),
(57, 6, 178, 0),
(58, 2, 178, 0),
(59, 1, 178, 1),
(60, 7, 178, 0),
(61, 6, 179, 0),
(62, 2, 179, 0),
(63, 1, 179, 1),
(64, 7, 179, 0),
(65, 6, 180, 0),
(66, 2, 180, 0),
(67, 1, 180, 1),
(68, 7, 180, 0),
(69, 6, 181, 0),
(70, 2, 181, 0),
(71, 1, 181, 1),
(72, 7, 181, 0),
(73, 6, 182, 0),
(74, 2, 182, 0),
(75, 1, 182, 1),
(76, 7, 182, 0),
(77, 6, 183, 0),
(78, 2, 183, 0),
(79, 1, 183, 1),
(80, 7, 183, 0),
(81, 6, 184, 0),
(82, 2, 184, 0),
(83, 1, 184, 1),
(84, 7, 184, 0),
(85, 6, 185, 0),
(86, 2, 185, 0),
(87, 1, 185, 1),
(88, 7, 185, 0),
(89, 6, 186, 0),
(90, 2, 186, 0),
(91, 1, 186, 1),
(92, 7, 186, 0),
(93, 6, 187, 0),
(94, 2, 187, 0),
(95, 1, 187, 1),
(96, 7, 187, 0),
(97, 6, 188, 0),
(98, 2, 188, 0),
(99, 1, 188, 1),
(100, 7, 188, 0),
(101, 6, 189, 0),
(102, 2, 189, 0),
(103, 1, 189, 1),
(104, 7, 189, 0),
(105, 6, 190, 0),
(106, 2, 190, 0),
(107, 1, 190, 1),
(108, 7, 190, 0),
(109, 6, 191, 0),
(110, 2, 191, 0),
(111, 1, 191, 1),
(112, 7, 191, 0),
(113, 6, 192, 0),
(114, 2, 192, 0),
(115, 1, 192, 1),
(116, 7, 192, 0),
(117, 6, 193, 0),
(118, 2, 193, 0),
(119, 1, 193, 1),
(120, 7, 193, 0),
(121, 6, 194, 0),
(122, 2, 194, 0),
(123, 1, 194, 1),
(124, 7, 194, 1),
(125, 6, 195, 0),
(126, 2, 195, 0),
(127, 1, 195, 1),
(128, 7, 195, 0);

-- --------------------------------------------------------

--
-- Estrutura da tabela `notificacoes`
--

CREATE TABLE `notificacoes` (
  `id` int(11) UNSIGNED NOT NULL,
  `nome_usuario` varchar(100) DEFAULT NULL,
  `data_notificacao` datetime DEFAULT NULL,
  `notificacao_tipo` varchar(50) DEFAULT NULL,
  `propriedades` text,
  `link` varchar(100) DEFAULT NULL,
  `id_company` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Extraindo dados da tabela `notificacoes`
--

INSERT INTO `notificacoes` (`id`, `nome_usuario`, `data_notificacao`, `notificacao_tipo`, `propriedades`, `link`, `id_company`) VALUES
(168, '1', '2019-09-17 10:10:35', 'CONCLUIDO', '{\"msg\":\"Tampa ferro fundido  Foi Concluido\",\"etapa\":1,\"id_obra\":\"31\"}', 'http://www2.cena.com.br/admin/obras/edit/31', 1),
(169, 'gabriel', '2019-09-17 10:13:05', 'CONCLUIDO', '{\"msg\":\"Tampa ferro fundido  Foi Concluido\",\"etapa\":1,\"id_obra\":\"31\"}', 'http://www2.cena.com.br/admin/obras/edit/31', 1),
(170, 'gabriel', '2019-09-17 10:27:50', 'CONCLUIDO', '{\"msg\":\"Aprovação projeto implantação Foi Concluido\",\"etapa\":1,\"id_obra\":\"31\"}', 'http://www2.cena.com.br/admin/obras/edit/31', 1),
(171, 'gabriel', '2019-09-17 10:27:55', 'CONCLUIDO', '{\"msg\":\"Aprovação projeto implantação Foi Concluido\",\"etapa\":1,\"id_obra\":\"31\"}', 'http://www2.cena.com.br/admin/obras/edit/31', 1),
(172, 'gabriel', '2019-09-17 12:10:46', 'CONCLUIDO', '{\"msg\":\"Aprovação projeto implantação Foi Concluido\",\"etapa\":1,\"id_obra\":\"35\"}', 'http://www2.cena.com.br/admin/obras/edit/35', 1),
(173, 'gabriel', '2019-09-17 12:10:47', 'CONCLUIDO', '{\"msg\":\"Confecção do projeto civil Foi Concluido\",\"etapa\":1,\"id_obra\":\"35\"}', 'http://www2.cena.com.br/admin/obras/edit/35', 1),
(174, 'gabriel', '2019-09-17 12:11:02', 'CONCLUIDO', '{\"msg\":\"Aprovação projeto Civil Foi Concluido\",\"etapa\":1,\"id_obra\":\"35\"}', 'http://www2.cena.com.br/admin/obras/edit/35', 1),
(175, 'gabriel', '2019-09-17 12:11:03', 'CONCLUIDO', '{\"msg\":\"Abertura APPJ Foi Concluido\",\"etapa\":1,\"id_obra\":\"35\"}', 'http://www2.cena.com.br/admin/obras/edit/35', 1),
(176, 'gabriel', '2019-09-17 12:11:06', 'CONCLUIDO', '{\"msg\":\"Confecção custo de rede Foi Concluido\",\"etapa\":1,\"id_obra\":\"35\"}', 'http://www2.cena.com.br/admin/obras/edit/35', 1),
(177, 'gabriel', '2019-09-17 12:11:09', 'CONCLUIDO', '{\"msg\":\"Comprovante de propriedade do imóvel Foi Concluido\",\"etapa\":1,\"id_obra\":\"35\"}', 'http://www2.cena.com.br/admin/obras/edit/35', 1),
(178, 'gabriel', '2019-09-17 12:11:10', 'CONCLUIDO', '{\"msg\":\"CNPJ Foi Concluido\",\"etapa\":1,\"id_obra\":\"35\"}', 'http://www2.cena.com.br/admin/obras/edit/35', 1),
(179, 'gabriel', '2019-09-17 12:11:35', 'CONCLUIDO', '{\"msg\":\"Projeto de implantação aprovado Foi Concluido\",\"etapa\":1,\"id_obra\":\"35\"}', 'http://www2.cena.com.br/admin/obras/edit/35', 1),
(180, 'gabriel', '2019-09-17 12:23:25', 'CONCLUIDO', '{\"msg\":\"Contrato de obras Foi Concluido\",\"etapa\":1,\"id_obra\":\"35\"}', 'http://www2.cena.com.br/admin/obras/edit/35', 1),
(181, 'gabriel', '2019-09-17 14:33:38', 'CONCLUIDO', '{\"msg\":\"Visita Programação de Obras Foi Concluido\",\"etapa\":1,\"id_obra\":\"35\"}', 'http://www2.cena.com.br/admin/obras/edit/35', 1),
(182, 'gabriel', '2019-09-17 14:33:40', 'CONCLUIDO', '{\"msg\":\"Compra de Materiais Foi Concluido\",\"etapa\":1,\"id_obra\":\"35\"}', 'http://www2.cena.com.br/admin/obras/edit/35', 1),
(183, 'gabriel', '2019-09-17 16:03:07', 'CONCLUIDO', '{\"msg\":\"Lançamento dos dutos MT Foi Concluido\",\"etapa\":1,\"id_obra\":\"35\"}', 'http://www2.cena.com.br/admin/obras/edit/35', 1),
(184, 'gabriel', '2019-09-17 16:11:47', 'CONCLUIDO', '{\"msg\":\"Boleto de obras Foi Concluido\",\"etapa\":1,\"id_obra\":\"35\"}', 'http://www2.cena.com.br/admin/obras/edit/35', 1),
(185, 'gabriel', '2019-09-17 16:12:08', 'CONCLUIDO', '{\"msg\":\"Projeto Construtivo e ART Foi Concluido\",\"etapa\":1,\"id_obra\":\"35\"}', 'http://www2.cena.com.br/admin/obras/edit/35', 1),
(186, 'gabriel', '2019-09-17 16:12:10', 'CONCLUIDO', '{\"msg\":\"Relação de carga Foi Concluido\",\"etapa\":1,\"id_obra\":\"35\"}', 'http://www2.cena.com.br/admin/obras/edit/35', 1),
(187, 'gabriel', '2019-09-17 16:12:12', 'CONCLUIDO', '{\"msg\":\"Confecção projeto executivo civil Foi Concluido\",\"etapa\":1,\"id_obra\":\"35\"}', 'http://www2.cena.com.br/admin/obras/edit/35', 1),
(188, 'gabriel', '2019-09-17 16:35:56', 'CONCLUIDO', '{\"msg\":\"Compra de Materiais Foi Concluido\",\"etapa\":1,\"id_obra\":\"36\"}', 'http://www2.cena.com.br/admin/obras/edit/36', 1),
(189, 'gabriel', '2019-09-17 16:37:31', 'CONCLUIDO', '{\"msg\":\"Compra de Materiais Foi Concluido\",\"etapa\":1,\"id_obra\":\"36\"}', 'http://www2.cena.com.br/admin/obras/edit/36', 1),
(190, 'gabriel', '2019-09-17 16:37:37', 'CONCLUIDO', '{\"msg\":\"Compra de Materiais Foi Concluido\",\"etapa\":1,\"id_obra\":\"36\"}', 'http://www2.cena.com.br/admin/obras/edit/36', 1),
(191, 'gabriel', '2019-09-17 17:31:13', 'CONCLUIDO', '{\"msg\":\"Visita Programação de Obras Foi Concluido\",\"etapa\":1,\"id_obra\":\"36\"}', 'http://www2.cena.com.br/admin/obras/edit/36', 1),
(192, 'gabriel', '2019-09-17 20:53:35', 'DEFINIDO', '{\"msg\":\"Foi definido um prazo na etapa Aprovação projeto implantação\",\"etapa\":2,\"id_obra\":\"36\"}', 'http://www2.cena.com.br/admin/obras/edit/36', 1),
(193, 'gabriel', '2019-09-17 20:54:32', 'DEFINIDO', '{\"msg\":\"Foi definido um prazo na etapa Aprovação projeto implantação\",\"etapa\":2,\"id_obra\":\"36\"}', 'http://www2.cena.com.br/admin/obras/edit/36', 1),
(194, 'gabriel', '2019-09-17 20:54:43', 'DEFINIDO', '{\"msg\":\"Foi definido um prazo na etapa Aprovação projeto Civil\",\"etapa\":2,\"id_obra\":\"36\"}', 'http://www2.cena.com.br/admin/obras/edit/36', 1),
(195, 'gabriel', '2019-09-18 12:49:51', 'CONCLUIDO', '{\"msg\":\"Aprovação projeto implantação Foi Concluido\",\"etapa\":1,\"id_obra\":\"36\"}', 'http://www2.cena.com.br/admin/obras/edit/36', 1);

-- --------------------------------------------------------

--
-- Estrutura da tabela `obra`
--

CREATE TABLE `obra` (
  `id` int(11) NOT NULL,
  `id_company` int(11) DEFAULT NULL,
  `id_servico` int(11) DEFAULT NULL,
  `id_cliente` int(11) DEFAULT NULL,
  `id_concessionaria` int(11) DEFAULT NULL,
  `obr_razao_social` varchar(120) DEFAULT NULL,
  `data_obra` varchar(45) DEFAULT NULL,
  `atv` int(11) DEFAULT '1',
  `obra_nota_numero` varchar(45) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Extraindo dados da tabela `obra`
--

INSERT INTO `obra` (`id`, `id_company`, `id_servico`, `id_cliente`, `id_concessionaria`, `obr_razao_social`, `data_obra`, `atv`, `obra_nota_numero`) VALUES
(33, 1, 18, 40, 74, '123', '17-09-2019', 0, NULL),
(36, 1, 19, 40, 75, 'Casa Marcos', '17-09-2019', 1, '');

-- --------------------------------------------------------

--
-- Estrutura da tabela `obra_etapa`
--

CREATE TABLE `obra_etapa` (
  `id_etapa_obra` int(11) NOT NULL,
  `id_obra` int(11) DEFAULT NULL,
  `id_etapa` int(11) DEFAULT NULL,
  `check` varchar(1) DEFAULT '0',
  `ordem` varchar(45) DEFAULT NULL,
  `nota_numero` varchar(45) DEFAULT NULL,
  `data_abertura` varchar(45) DEFAULT NULL,
  `prazo_atendimento` varchar(45) DEFAULT NULL,
  `responsavel` varchar(225) DEFAULT NULL,
  `data_pedido` varchar(45) DEFAULT NULL,
  `cliente_responsavel` varchar(225) DEFAULT NULL,
  `data_programada` varchar(45) DEFAULT NULL,
  `data_iniciada` varchar(45) DEFAULT NULL,
  `tempo_atividade` varchar(45) DEFAULT NULL,
  `data_prazo_total` datetime DEFAULT NULL,
  `parcial_check` int(11) DEFAULT '0',
  `observacao` varchar(500) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Extraindo dados da tabela `obra_etapa`
--

INSERT INTO `obra_etapa` (`id_etapa_obra`, `id_obra`, `id_etapa`, `check`, `ordem`, `nota_numero`, `data_abertura`, `prazo_atendimento`, `responsavel`, `data_pedido`, `cliente_responsavel`, `data_programada`, `data_iniciada`, `tempo_atividade`, `data_prazo_total`, `parcial_check`, `observacao`) VALUES
(249, 33, 9, '0', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 0, NULL),
(250, 33, 10, '0', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 0, NULL),
(251, 33, 11, '0', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 0, NULL),
(252, 33, 12, '0', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 0, NULL),
(253, 33, 13, '0', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 0, NULL),
(254, 33, 14, '0', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 0, NULL),
(255, 33, 15, '0', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 0, NULL),
(256, 33, 16, '0', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 0, NULL),
(257, 33, 30, '0', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 0, NULL),
(258, 33, 31, '0', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 0, NULL),
(259, 33, 17, '0', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 0, NULL),
(260, 33, 18, '0', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 0, NULL),
(261, 33, 19, '0', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 0, NULL),
(262, 33, 20, '0', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 0, NULL),
(263, 33, 21, '0', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 0, NULL),
(264, 33, 32, '0', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 0, NULL),
(265, 33, 37, '0', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 0, NULL),
(266, 33, 33, '0', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 0, NULL),
(267, 33, 34, '0', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 0, NULL),
(268, 33, 35, '0', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 0, NULL),
(269, 33, 1, '0', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 0, NULL),
(270, 33, 38, '0', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 0, NULL),
(271, 33, 2, '0', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 0, NULL),
(272, 33, 39, '0', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 0, NULL),
(273, 33, 3, '0', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 0, NULL),
(274, 33, 28, '0', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 0, NULL),
(275, 33, 29, '0', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 0, NULL),
(276, 33, 36, '0', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 0, NULL),
(333, 36, 1, '1', '', '12321', '10-02-2019', '1', NULL, NULL, NULL, NULL, NULL, NULL, '2019-02-11 00:00:00', 0, '123'),
(334, 36, 2, '0', '', '', '', '', NULL, NULL, NULL, NULL, NULL, NULL, '1999-11-30 00:00:00', 0, 'dqwe'),
(335, 36, 3, '0', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 0, 'wqedweqdw'),
(336, 36, 4, '0', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 0, NULL),
(337, 36, 9, '0', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 0, NULL),
(338, 36, 10, '0', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 0, 'wqedweqd'),
(339, 36, 11, '0', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 0, 'weqdwed'),
(340, 36, 12, '0', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 0, 'dedqwed'),
(341, 36, 17, '1', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 0, NULL),
(342, 36, 18, '0', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 2, NULL),
(343, 36, 19, '0', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, NULL),
(344, 36, 20, '0', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, NULL);

-- --------------------------------------------------------

--
-- Estrutura da tabela `permission_groups`
--

CREATE TABLE `permission_groups` (
  `id` int(11) NOT NULL,
  `id_usuario` int(11) NOT NULL,
  `params` varchar(200) COLLATE utf8_bin DEFAULT NULL,
  `id_company` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

--
-- Extraindo dados da tabela `permission_groups`
--

INSERT INTO `permission_groups` (`id`, `id_usuario`, `params`, `id_company`) VALUES
(1, 1, '1,2,3,4,5,6,7,8,9,10,11,12,13,14,15,16,17,18,19,20,21,22,23,24,25', 1),
(6, 24, '1', 1),
(7, 25, '1,6,7,8,9,10,11,12,13,14,15,16,17,18,19,20,21,22,23,24,25', 1),
(8, 26, '1', 1),
(9, 35, '1', 1),
(10, 36, '1,22,23,24,25', 1),
(11, 42, '1,2,3,4,5,6', 1),
(12, 45, '1,2,3,4,5,6,7,8,9,10,11,12,13,14,15,16,17,18,19,20,21,22,23,24,25', 1),
(13, 46, '1,2,3,4,5,6,7,8,9,10,11,12,13,14,15,16,17,18,19,20,21,22,23,24,25', 1);

-- --------------------------------------------------------

--
-- Estrutura da tabela `permission_params`
--

CREATE TABLE `permission_params` (
  `id` int(11) NOT NULL,
  `name` varchar(50) COLLATE utf8_bin NOT NULL,
  `id_company` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

--
-- Extraindo dados da tabela `permission_params`
--

INSERT INTO `permission_params` (`id`, `name`, `id_company`) VALUES
(1, 'dashboard_view', 1),
(2, 'user_view', 1),
(3, 'user_edit', 1),
(4, 'user_delet', 1),
(5, 'user_add', 1),
(6, 'cliente_view', 1),
(7, 'cliente_edit', 1),
(8, 'cliente_delete', 1),
(9, 'cliente_add', 1),
(10, 'concessionaria_view', 1),
(11, 'concessionaria_delete', 1),
(12, 'concessionaria_add', 1),
(13, 'concessionaria_edit', 1),
(14, 'servico_add', 1),
(15, 'servico_view', 1),
(16, 'servico_edit', 1),
(17, 'servico_delete', 1),
(18, 'obra_view', 1),
(19, 'obra_add', 1),
(20, 'obra_edit', 1),
(21, 'obra_delete', 1),
(22, 'documento_view', 1),
(23, 'documento_delete', 1),
(24, 'documento_edit', 1),
(25, 'documento_add', 1);

-- --------------------------------------------------------

--
-- Estrutura da tabela `servico`
--

CREATE TABLE `servico` (
  `id` int(11) NOT NULL,
  `sev_nome` varchar(255) DEFAULT NULL,
  `id_company` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Extraindo dados da tabela `servico`
--

INSERT INTO `servico` (`id`, `sev_nome`, `id_company`) VALUES
(19, 'Cubiculo blindado Simplificado', 1),
(22, 'Pedestal', 1),
(26, 'Barramento', 1);

-- --------------------------------------------------------

--
-- Estrutura da tabela `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `email` varchar(50) COLLATE utf8_bin DEFAULT NULL,
  `login` varchar(45) COLLATE utf8_bin DEFAULT NULL,
  `password` varchar(32) COLLATE utf8_bin DEFAULT NULL,
  `usr_info` varchar(45) COLLATE utf8_bin DEFAULT NULL,
  `user_photo_url` varchar(300) COLLATE utf8_bin DEFAULT NULL,
  `id_group` int(11) NOT NULL,
  `id_company` int(11) DEFAULT NULL,
  `usu_ativo` varchar(45) COLLATE utf8_bin DEFAULT '1',
  `id_cliente` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

--
-- Extraindo dados da tabela `users`
--

INSERT INTO `users` (`id`, `email`, `login`, `password`, `usr_info`, `user_photo_url`, `id_group`, `id_company`, `usu_ativo`, `id_cliente`) VALUES
(1, 'gabriel@gabriel', 'gabriel', '21232f297a57a5a743894a0e4a801fc3', 'sistema', NULL, 0, 1, '1', NULL),
(2, 'camila@camila', 'camila', '21232f297a57a5a743894a0e4a801fc3', 'sistema', NULL, 0, 1, '1', NULL),
(3, NULL, 'cNA Spitaletti', '21232f297a57a5a743894a0e4a801fc3', 'cliente', NULL, 0, 1, '0', 47),
(4, NULL, 'p4 Engenharia', '21232f297a57a5a743894a0e4a801fc3', 'cliente', NULL, 0, 1, '1', 48),
(5, NULL, 'marcos Varella', '21232f297a57a5a743894a0e4a801fc3', 'cliente', NULL, 0, 1, '1', 40),
(6, '', 'admin', '21232f297a57a5a743894a0e4a801fc3', 'sistema', NULL, 0, 1, '1', NULL),
(7, 'marcos@cenabrcombr', 'marcos', '21232f297a57a5a743894a0e4a801fc3', 'sistema', NULL, 0, 1, '1', NULL);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `cliente`
--
ALTER TABLE `cliente`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `cliente_endereco`
--
ALTER TABLE `cliente_endereco`
  ADD PRIMARY KEY (`id_endereco`);

--
-- Indexes for table `companies`
--
ALTER TABLE `companies`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `concessionaria`
--
ALTER TABLE `concessionaria`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `concessionaria_servico`
--
ALTER TABLE `concessionaria_servico`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `documentos`
--
ALTER TABLE `documentos`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `documentos_obra`
--
ALTER TABLE `documentos_obra`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `documento_etapa`
--
ALTER TABLE `documento_etapa`
  ADD PRIMARY KEY (`id_etapa_documento`);

--
-- Indexes for table `etapa`
--
ALTER TABLE `etapa`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `etapas_servico_concessionaria`
--
ALTER TABLE `etapas_servico_concessionaria`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `etapa_tipo`
--
ALTER TABLE `etapa_tipo`
  ADD PRIMARY KEY (`id_etapatipo`);

--
-- Indexes for table `notificacao_usuario`
--
ALTER TABLE `notificacao_usuario`
  ADD PRIMARY KEY (`id_not_user`);

--
-- Indexes for table `notificacoes`
--
ALTER TABLE `notificacoes`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `obra`
--
ALTER TABLE `obra`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `obra_etapa`
--
ALTER TABLE `obra_etapa`
  ADD PRIMARY KEY (`id_etapa_obra`);

--
-- Indexes for table `permission_groups`
--
ALTER TABLE `permission_groups`
  ADD PRIMARY KEY (`id`),
  ADD KEY `params_idx` (`params`);

--
-- Indexes for table `permission_params`
--
ALTER TABLE `permission_params`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `servico`
--
ALTER TABLE `servico`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD KEY `company_idx` (`id_company`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `cliente`
--
ALTER TABLE `cliente`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=50;

--
-- AUTO_INCREMENT for table `cliente_endereco`
--
ALTER TABLE `cliente_endereco`
  MODIFY `id_endereco` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT for table `concessionaria`
--
ALTER TABLE `concessionaria`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=76;

--
-- AUTO_INCREMENT for table `concessionaria_servico`
--
ALTER TABLE `concessionaria_servico`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=124;

--
-- AUTO_INCREMENT for table `documentos`
--
ALTER TABLE `documentos`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `documentos_obra`
--
ALTER TABLE `documentos_obra`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `documento_etapa`
--
ALTER TABLE `documento_etapa`
  MODIFY `id_etapa_documento` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT for table `etapa`
--
ALTER TABLE `etapa`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=40;

--
-- AUTO_INCREMENT for table `etapas_servico_concessionaria`
--
ALTER TABLE `etapas_servico_concessionaria`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=250;

--
-- AUTO_INCREMENT for table `notificacao_usuario`
--
ALTER TABLE `notificacao_usuario`
  MODIFY `id_not_user` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=129;

--
-- AUTO_INCREMENT for table `notificacoes`
--
ALTER TABLE `notificacoes`
  MODIFY `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=196;

--
-- AUTO_INCREMENT for table `obra`
--
ALTER TABLE `obra`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=37;

--
-- AUTO_INCREMENT for table `obra_etapa`
--
ALTER TABLE `obra_etapa`
  MODIFY `id_etapa_obra` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=345;

--
-- AUTO_INCREMENT for table `permission_groups`
--
ALTER TABLE `permission_groups`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;

--
-- AUTO_INCREMENT for table `permission_params`
--
ALTER TABLE `permission_params`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=26;

--
-- AUTO_INCREMENT for table `servico`
--
ALTER TABLE `servico`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=27;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- Constraints for dumped tables
--

--
-- Limitadores para a tabela `users`
--
ALTER TABLE `users`
  ADD CONSTRAINT `company` FOREIGN KEY (`id_company`) REFERENCES `companies` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
