-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Tempo de geração: 03-Jun-2024 às 22:10
-- Versão do servidor: 10.4.28-MariaDB
-- versão do PHP: 8.2.4

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Banco de dados: `gmea`
--

-- --------------------------------------------------------

--
-- Estrutura da tabela `alteracoes_password`
--

CREATE TABLE `alteracoes_password` (
  `id_alteracao` int(11) NOT NULL,
  `user` varchar(255) NOT NULL,
  `data_alteracao` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Extraindo dados da tabela `alteracoes_password`
--

INSERT INTO `alteracoes_password` (`id_alteracao`, `user`, `data_alteracao`) VALUES
(1, 'a110', '2024-02-03'),
(2, 'a110', '2024-02-03'),
(3, 'a110', '2024-02-03'),
(4, 'a110', '2024-02-03'),
(5, 'a110', '2024-02-03'),
(6, 'a110', '2024-02-03'),
(7, 'a110', '2024-02-03'),
(8, 'a110', '2024-02-03'),
(13, 'a120', '2016-02-11'),
(14, 'p100', '2023-02-03'),
(15, 'a110', '2024-02-03'),
(16, 'p100', '2024-02-05'),
(28, 'd100', '2024-02-05'),
(29, 'd100', '2024-02-05'),
(30, 'd100', '2024-02-05'),
(31, 'd100', '2024-02-05');

-- --------------------------------------------------------

--
-- Estrutura da tabela `alunos`
--

CREATE TABLE `alunos` (
  `user` varchar(255) NOT NULL,
  `turma` varchar(255) NOT NULL,
  `cod_in1` int(11) NOT NULL,
  `prof_in1` varchar(255) NOT NULL,
  `dur1` int(11) NOT NULL,
  `grau_in1` int(11) NOT NULL,
  `cod_in2` int(11) NOT NULL,
  `prof_in2` varchar(255) NOT NULL,
  `dur2` int(11) NOT NULL,
  `grau_in2` int(11) NOT NULL,
  `cod_fm` int(11) NOT NULL,
  `grau_fm` int(11) NOT NULL,
  `cod_orq` int(11) NOT NULL,
  `cod_in_orq` int(11) NOT NULL,
  `grau_orq` int(11) NOT NULL,
  `cod_coro` int(11) NOT NULL,
  `grau_coro` int(11) NOT NULL,
  `regime` int(11) NOT NULL,
  `tipo_regime` int(11) NOT NULL,
  `irmaos` int(11) NOT NULL,
  `desc_irmaos` int(11) NOT NULL,
  `mem_bs` int(11) NOT NULL,
  `num_socio` int(11) NOT NULL,
  `num_fatura` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Extraindo dados da tabela `alunos`
--

INSERT INTO `alunos` (`user`, `turma`, `cod_in1`, `prof_in1`, `dur1`, `grau_in1`, `cod_in2`, `prof_in2`, `dur2`, `grau_in2`, `cod_fm`, `grau_fm`, `cod_orq`, `cod_in_orq`, `grau_orq`, `cod_coro`, `grau_coro`, `regime`, `tipo_regime`, `irmaos`, `desc_irmaos`, `mem_bs`, `num_socio`, `num_fatura`) VALUES
('a104', '', 0, '0', 0, 0, 0, '0', 0, 0, 0, 0, 0, 0, 0, 0, 0, 4, 1, 0, 0, 0, 11, 1),
('a105', 'tg004', 0, '0', 0, 0, 0, '0', 0, 0, 0, 0, 0, 0, 0, 0, 0, 1, 0, 1, 0, 0, 0, 2),
('a106', '', 0, '0', 0, 0, 0, '0', 0, 0, 0, 0, 0, 0, 0, 0, 0, 4, 1, 0, 0, 0, 12, 3),
('a107', '', 0, '0', 0, 0, 0, '0', 0, 0, 0, 0, 0, 0, 0, 0, 0, 4, 1, 0, 0, 0, 7, 4),
('a108', '', 0, '0', 0, 0, 0, '0', 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 5),
('a109', '', 0, '0', 0, 0, 0, '0', 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 6),
('a110', 'tg007', 3, 'p118', 50, 12, 0, '0', 0, 0, 2, 12, 11, 3, 12, 0, 0, 3, 1, 1, 2, 1, 1, 7),
('a116', '', 0, '0', 0, 0, 0, '0', 0, 0, 0, 0, 0, 0, 0, 0, 0, 4, 1, 0, 0, 0, 8, 8),
('a117', '', 20, 'p101', 50, 0, 16, 'p107', 30, 0, 1, 0, 11, 0, 0, 10, 0, 2, 1, 1, 2, 0, 0, 9),
('a118', 'tg001', 17, 'p107', 20, 0, 0, '0', 0, 0, 1, 0, 0, 0, 0, 9, 0, 4, 1, 1, 1, 0, 17, 10),
('a119', '', 0, '0', 0, 0, 0, '0', 0, 0, 0, 0, 0, 0, 0, 0, 0, 2, 1, 0, 0, 0, 6, 11),
('a120', 'tg007', 15, 'p101', 50, 0, 3, 'p107', 50, 8, 2, 0, 11, 0, 0, 0, 0, 3, 1, 0, 0, 1, 3, 12),
('a121', 'tg003', 20, 'p101', 50, 0, 12, 'p107', 30, 0, 1, 0, 11, 0, 0, 10, 0, 2, 1, 1, 1, 1, 14, 13),
('a122', 'tg004', 7, 'p110', 30, 0, 0, '0', 0, 0, 1, 0, 11, 0, 0, 0, 0, 0, 1, 0, 0, 0, 11, 15),
('a123', '', 0, '0', 0, 0, 0, '0', 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 16);

-- --------------------------------------------------------

--
-- Estrutura da tabela `aulas`
--

CREATE TABLE `aulas` (
  `id_aula` int(11) NOT NULL,
  `userOuTurma` varchar(255) NOT NULL,
  `prof` varchar(255) NOT NULL,
  `cod_dis` int(11) NOT NULL,
  `hora_inicio` varchar(255) NOT NULL,
  `hora_fim` varchar(255) NOT NULL,
  `dia_semana` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Extraindo dados da tabela `aulas`
--

INSERT INTO `aulas` (`id_aula`, `userOuTurma`, `prof`, `cod_dis`, `hora_inicio`, `hora_fim`, `dia_semana`) VALUES
(60, 'a110', 'p118', 3, '18:20', '19:10', '2'),
(61, 't041', 'p118', 2, '10:30', '11:45', '6'),
(63, 'a110', 'p118', 16, '17:25', '17:55', '4'),
(64, 'a110', 'p100', 8, '10:30', '11:00', '2'),
(65, 't042', 'p100', 2, '12:30', '13:45', '1'),
(66, 'a120', 'p116', 7, '12:20', '12:40', '5'),
(67, 'a110', 'p118', 8, '15:00', '16:20', '7'),
(68, 'a123', 'p116', 15, '10:00', '10:30', '1'),
(78, 'a120', 'p118', 16, '12:00', '13:50', '6'),
(79, 't047', 'p118', 1, '15:00', '16:20', '4'),
(80, 't048', 'p101', 1, '10:00', '11:00', '4'),
(81, 't049', 'p101', 1, '15:00', '16:00', '6');

-- --------------------------------------------------------

--
-- Estrutura da tabela `avaliacoes`
--

CREATE TABLE `avaliacoes` (
  `id` int(11) NOT NULL,
  `id_avaliacao` int(11) NOT NULL,
  `tipo_avaliacao` int(11) NOT NULL,
  `nivel` int(11) NOT NULL,
  `notas` varchar(255) NOT NULL,
  `data_avaliacao` date NOT NULL,
  `data_inserido` date NOT NULL,
  `prof` varchar(255) NOT NULL,
  `escala` int(11) NOT NULL,
  `disciplina` int(11) NOT NULL,
  `user` varchar(255) NOT NULL,
  `userOuTurma` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Extraindo dados da tabela `avaliacoes`
--

INSERT INTO `avaliacoes` (`id`, `id_avaliacao`, `tipo_avaliacao`, `nivel`, `notas`, `data_avaliacao`, `data_inserido`, `prof`, `escala`, `disciplina`, `user`, `userOuTurma`) VALUES
(54, 5, 2, 110, '', '2024-04-24', '2024-05-03', 'p118', 3, 9, 'a123', 't043'),
(55, 5, 2, 100, '', '2024-04-24', '2024-05-03', 'p118', 3, 9, 'a120', 't043'),
(56, 5, 2, 100, '', '2024-04-24', '2024-05-03', 'p118', 3, 9, 'a114', 't043'),
(57, 5, 2, 100, '', '2024-04-24', '2024-05-03', 'p118', 3, 9, 'a108', 't043'),
(58, 6, 2, 164, 'Parabéns pelo bom desemprenho!', '2024-04-13', '2024-05-03', 'p118', 3, 9, 'a110', 'a110'),
(63, 7, 1, 157, 'Parabéns pela melhoria! É preciso continuar a estudar!', '2024-04-12', '2024-05-05', 'p118', 3, 2, 'a110', 't041'),
(64, 7, 1, 4, '', '2024-04-12', '2024-05-05', 'p118', 1, 2, 'a115', 't041'),
(65, 7, 1, 135, '', '2024-04-12', '2024-05-05', 'p118', 3, 2, 'a121', 't041'),
(66, 7, 1, 187, '', '2024-04-12', '2024-05-05', 'p118', 3, 2, 'a120', 't041'),
(67, 8, 2, 173, '', '2024-04-30', '2024-05-07', 'p118', 3, 2, 'a110', 't041'),
(68, 8, 2, 115, '', '2024-04-30', '2024-05-07', 'p118', 3, 2, 'a115', 't041'),
(69, 8, 2, 54, '', '2024-04-30', '2024-05-07', 'p118', 2, 2, 'a121', 't041'),
(70, 8, 2, 5, '', '2024-05-02', '2024-05-07', 'p118', 1, 2, 'a120', 't041'),
(74, 10, 1, 168, '', '2024-05-11', '2024-05-16', 'p118', 3, 8, 'a110', 'a110'),
(79, 13, 2, 122, '', '0000-00-00', '2024-05-28', 'p118', 3, 8, 'a110', 'a110'),
(80, 14, 2, 152, '', '0000-00-00', '2024-05-28', 'p118', 3, 8, 'a110', 'a110'),
(81, 15, 2, 160, '', '2024-05-25', '2024-05-29', 'p118', 3, 2, 'a110', 't041'),
(82, 15, 2, 123, '', '2024-05-29', '2024-05-29', 'p118', 3, 2, 'a117', 't041'),
(83, 15, 2, 123, '', '2024-05-29', '2024-05-29', 'p118', 3, 2, 'a120', 't041');

-- --------------------------------------------------------

--
-- Estrutura da tabela `avisos`
--

CREATE TABLE `avisos` (
  `id_aviso` int(11) NOT NULL,
  `criador` varchar(255) NOT NULL,
  `titulo` varchar(255) NOT NULL,
  `texto` text NOT NULL,
  `destino` varchar(255) NOT NULL,
  `data_inicio` date NOT NULL,
  `data_fim` date NOT NULL,
  `tipo_aviso` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Extraindo dados da tabela `avisos`
--

INSERT INTO `avisos` (`id_aviso`, `criador`, `titulo`, `texto`, `destino`, `data_inicio`, `data_fim`, `tipo_aviso`) VALUES
(1, 'd100', 'Aviso - Professor César Santos irá faltar', 'Bom dia,\r\n\r\nGostaríamos de avisar que o professor e maestro César Santos irá faltar no próximo dia 3 de Fevereiro, por motivos pessoais.\r\n\r\nSendo assim, todas as aulas de Orquestra Juvenil, Trombone e outras Classes de Conjunto marcadas para esse dia ficarão sem efeito.\r\nPedimos, desde já, desculpa pelo transtorno.\r\n\r\nCom os melhores cumprimentos,\r\nA direção do GMEA e o professor César Santos', 'alunos', '2024-02-01', '2024-02-03', 1),
(2, 'd100', 'Aviso - Professor César Santos irá faltar', 'Aaaaa', 'todos', '2024-02-01', '2024-02-04', 1),
(3, 'd100', 'Aviso - Professor César Santos irá faltar', 'AA', 'todos', '2024-02-01', '2024-02-10', 1),
(4, 'd100', 'Aviso - Professor César Santos irá faltar', 'Aaaa', 'alunos', '2024-02-01', '2024-02-04', 1),
(5, 'd100', 'Aviso - Professor César Santos irá faltar', 'Aaaa', 'alunos', '2024-02-01', '2024-02-04', 1),
(6, 'd100', 'AAA', 'AAA', 'alunos', '2024-01-02', '2024-02-04', 1),
(7, 'd100', 'Maestro vai faltar', 'faltou', 'alunos', '2024-02-02', '2024-02-05', 1),
(8, 'd100', 'Maestro vai faltar', 'faltou', 'alunos', '2024-02-02', '2024-02-05', 1),
(9, 'd100', 'URGENTE - Gastão Reis', 'Acontece', 'todos', '2024-02-02', '2024-02-05', 1),
(10, 'd100', 'Maestro vai faltar', 'O maestro irá faltar.', 'alunos_professor_p110', '2024-02-02', '2024-02-03', 1),
(11, 'd100', 'Maestro vai faltar', 'AAAAA', 'alunos_professor_p110', '2024-02-02', '2023-04-02', 1),
(12, 'd100', 'Maestro vai faltar', 'AAAAA', 'alunos_professor_p110', '2024-02-02', '2023-04-02', 1),
(13, 'd100', 'Maestro vai faltar', 'AAAAA', 'alunos_professor_p110', '2024-02-02', '2023-04-02', 1),
(14, 'd100', 'Alteração ao sistema de avisos', 'Boa tarde,\r\n\r\nEstamos, atualmente, a testar este novo sistema de avisos. Pedimos a vossa compreensão.\r\n\r\nCom os melhores cumprimentos,\r\nA equipa de desenvolvimento do GMEA', 'alunos_professor_p110', '2024-02-01', '2024-02-03', 1),
(20, 'd100', 'Alteração ao sistema de avisos', 'Boa tarde, \r\n\r\nEstamos, atualmente, a testar este novo sistema de avisos. Pedimos a vossa compreensão. \r\n\r\nCom os melhores cumprimentos, \r\nA equipa de desenvolvimento do GMEA!', 'alunos_professor_p110', '2024-02-01', '2024-02-04', 1),
(21, 'd100', 'Alteração ao sistema de avisos', 'AAAAAAAAAAAA', 'alunos_professor_p110', '2024-02-06', '2024-02-10', 2),
(22, 'd100', 'Aviso - Professor César Santos irá faltar', 'Faltará!', 'todos', '2024-03-03', '2024-06-07', 2),
(23, 'd100', 'Aviso - Mudança de Horário', 'Novo!', 'todos', '2024-03-03', '2024-03-08', 1),
(24, 'd100', 'Aviso - Professor César Santos irá faltar', 'aaaaaa', 'alunos_professor_p117', '2024-03-13', '2024-03-14', 2),
(25, 'd100', 'Aviso - Professor César Santos irá faltar', 'aaaaaa', 'alunos_professor_p118', '2024-03-13', '2024-03-15', 1),
(26, 'd100', 'Aviso - Mensalidades', '<p>Relembramos que as mensalidades devem ser regularizadas, impereterivelmente, até ao <u>segundo sábado</u> de aulas de cada mês. </p><p><br></p><p> Obrigado,</p><p><br></p><p>A secretaria</p>', 'alunos_professor_p116', '2024-04-13', '2024-06-30', 1),
(27, 'd100', 'Aviso - Professor César Santos irá faltar', '<p>Informamos que o professor César Santos irá faltas durante os próximos dois fins de semana por motivos de saúde.</p><p><br></p><p>Agradecemos a compreensão.</p><p><br></p><p>A direção do GMEA</p>', 'todos', '2024-01-01', '2024-06-30', 1),
(28, 'd100', 'AAA', 'AAA', 'professores', '2000-01-01', '2222-01-01', 1),
(29, 'd100', 'AAA', 'AAA', 'turmas_t031', '2024-04-14', '2024-06-30', 1),
(30, 'd100', 'Aviso - Prof', '<p>Teste</p>', 'todos', '2024-02-14', '2024-05-16', 1),
(31, 'p118', 'Regularização de Mensalidades', '<p>Boa tarde,</p><p>Informamos que, de forma urgente, as mesalidades <strong>todas</strong> devem ser regularizadas até ao final do ano lectivo, sob pena de aplicação de coima.</p><p>Agradecemos a vossa compreensão.</p><p><br></p><p>Atentamente,</p><p>A direção do GMEA</p>', 'todos', '2024-05-16', '2024-07-01', 2),
(32, 'p118', 'Regularização de Mensalidades', '<p>Boa tarde,</p><p>Informamos que, de forma urgente, as mesalidades <strong>todas</strong> devem ser regularizadas até ao final do ano lectivo, sob pena de aplicação de coima.</p><p>Agradecemos a compreensão.</p><p><br></p><p>Atentamente,</p><p>A direção do GMEA</p>', 'todos', '2024-05-16', '2024-05-15', 2),
(33, 'p118', 'Regularização de Mensalidades', '<p>Boa tarde,</p><p>Informamos que, de forma urgente, as mesalidades <strong>todas</strong> devem ser regularizadas até ao final do ano lectivo, sob pena de aplicação de coima.</p><p>Agradecemos a compreensão.</p><p><br></p><p>Atentamente,</p><p>A direção do GMEA</p>', 'todos', '2024-05-16', '2024-05-15', 2),
(34, 'd107', 'Aviso - Professor César Santos irá faltar', '<p>Aviso - Professor César Santos irá faltar</p>', 'todos', '2001-01-01', '2024-05-29', 1),
(35, 'p118', 'Atualização no Sistema', '<p>Informamos que, a partir do dia 1º de junho, haverá uma atualização no sistema que poderá ocasionar interrupções temporárias nos serviços. Pedimos desculpas por qualquer inconveniente e agradecemos sua compreensão. Para mais informações, entre em contato com nosso suporte técnico.</p>', 'todos', '2024-05-29', '2024-05-30', 1),
(36, 'p118', 'Atualização no Sistema', '<p>Informamos que, a partir do dia 1º de junho, haverá uma atualização no sistema que poderá ocasionar interrupções temporárias nos serviços. Pedimos desculpas por qualquer inconveniente e agradecemos sua compreensão. Para mais informações, entre em contato com nosso suporte técnico.</p>', 'todos', '2024-05-29', '2024-05-31', 1),
(37, 'd100', 'Atualização no Sistema', '<p>O sistema passará por uma atualização nas próximas horas.</p>', 'todos', '2024-05-29', '2024-05-30', 2);

-- --------------------------------------------------------

--
-- Estrutura da tabela `calendario`
--

CREATE TABLE `calendario` (
  `id_evento` int(11) NOT NULL,
  `inicio` datetime NOT NULL,
  `fim` datetime NOT NULL,
  `tipo_evento` int(11) NOT NULL,
  `titulo` varchar(255) NOT NULL,
  `notas` varchar(255) NOT NULL,
  `userOuTurma` varchar(255) NOT NULL,
  `cod_dis` int(11) NOT NULL,
  `criador` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Extraindo dados da tabela `calendario`
--

INSERT INTO `calendario` (`id_evento`, `inicio`, `fim`, `tipo_evento`, `titulo`, `notas`, `userOuTurma`, `cod_dis`, `criador`) VALUES
(1, '2024-04-29 23:00:00', '2024-04-30 00:00:00', 1, 'Avaliação Intercalar de Percussão', 'Avaliação Intercalar de Percussão', 'a110', 1, 'p118'),
(3, '2024-06-19 18:30:00', '2024-06-19 19:45:00', 2, '', '', 'a110', 2, 'p118'),
(4, '2024-06-21 18:30:00', '2024-06-21 19:45:00', 2, '', '', 't041', 2, 'p118'),
(5, '0000-00-00 00:00:00', '0000-00-00 00:00:00', 0, '', '', '', 0, 'p118'),
(6, '2024-04-30 11:00:00', '2024-04-30 12:00:00', 3, 'Audição de Cordas', 'Audição Final de Ano', 'a110', 0, 'p118'),
(7, '2024-05-14 00:00:00', '2024-05-21 00:00:00', 6, 'Férias de Hannukah', 'Férias', 'a110', 0, 'd100'),
(8, '2024-05-14 00:00:00', '2024-05-22 00:00:00', 6, 'Férias de Hannukah', 'Férias', '0', 0, 'd100'),
(11, '2024-05-02 19:00:00', '2024-05-02 19:45:00', 5, 'Audição Arthenoon - Clarinetes e Flautas', 'Audição Arthenoon - Clarinetes e Flautas', 'a110', 0, 'p118'),
(13, '2024-05-01 00:00:00', '2024-05-02 00:00:00', 5, 'Magusto', 'Magusto', '0', 0, 'd100'),
(17, '2024-05-02 18:20:00', '2024-05-02 19:10:00', 2, 'Prova de Clarinete', 'Prova de Clarinete', 'a110', 3, 'p118'),
(18, '2024-05-08 12:00:00', '2024-05-08 15:00:00', 5, 'Oficina de Escrita', 'Oficina de Escrita', 't041', 0, 'p118'),
(19, '2024-05-09 15:00:00', '2024-05-09 17:00:00', 2, 'Prova de Solfejo', 'Prova de Solfejo Intercalar', 't041', 2, 'p118'),
(20, '2024-05-08 12:00:00', '2024-05-08 12:15:00', 5, 'Dia de Banho', 'Dia de Banho', 't041', 0, 'p118'),
(21, '2024-05-08 15:00:00', '2024-05-08 18:00:00', 5, 'Banana', 'Banana', 't041', 0, 'p118'),
(30, '2024-05-08 00:00:00', '2024-05-08 00:00:00', 5, 'Concerto Didático - \'Pedro e o Lobo\'', 'Concerto Didático com o quarteto \'Quas In Modus\'', '0', 10, 'd100'),
(31, '2024-05-30 17:00:00', '2024-05-30 18:30:00', 1, 'Avaliação Intercalar da Banda', 'Avaliação Intercalar da Banda', 'a110', 1, 'p118'),
(36, '2024-05-29 18:30:00', '2024-05-29 19:45:00', 2, 'Teste de Formação Musical', 'Exame de Formação Musical', '0', 2, 'd100');

-- --------------------------------------------------------

--
-- Estrutura da tabela `candidaturas_bs`
--

CREATE TABLE `candidaturas_bs` (
  `id_candidatura` int(11) NOT NULL,
  `nome` int(11) NOT NULL,
  `morada1` varchar(255) NOT NULL,
  `morada2` varchar(255) NOT NULL,
  `telef` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `data_nas` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Extraindo dados da tabela `candidaturas_bs`
--

INSERT INTO `candidaturas_bs` (`id_candidatura`, `nome`, `morada1`, `morada2`, `telef`, `email`, `data_nas`) VALUES
(1, 0, 'Rua do Cruzeiro Velho, 12, 1.º Tras', '4505-102, Argoncilhe', '962517031', 'pedroribeiro4702@gmail.com', '2001-04-07');

-- --------------------------------------------------------

--
-- Estrutura da tabela `cod_dis`
--

CREATE TABLE `cod_dis` (
  `cod_dis` int(11) NOT NULL,
  `nome_dis` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Extraindo dados da tabela `cod_dis`
--

INSERT INTO `cod_dis` (`cod_dis`, `nome_dis`) VALUES
(1, 'Formação Musical (Iniciação)'),
(2, 'Formação Musical'),
(3, 'Clarinete'),
(4, 'Saxofone'),
(5, 'Tuba'),
(6, 'Trombone'),
(7, 'Trompa'),
(8, 'Percussão'),
(9, 'Coro Infantil'),
(10, 'Coro Juvenil'),
(11, 'Orquestra Juvenil'),
(12, 'Violino'),
(13, 'Viola d\'Arco'),
(14, 'Violoncelo'),
(15, 'Piano'),
(16, 'Guitarra'),
(17, 'Flauta Transversal'),
(18, 'Trompete'),
(19, 'Contrabaixo'),
(20, 'Bombardino'),
(21, 'Canto');

-- --------------------------------------------------------

--
-- Estrutura da tabela `cookies`
--

CREATE TABLE `cookies` (
  `id_cookie` int(11) NOT NULL,
  `cookie_name` varchar(255) NOT NULL,
  `ip_address` varchar(255) NOT NULL,
  `expiry_date` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Extraindo dados da tabela `cookies`
--

INSERT INTO `cookies` (`id_cookie`, `cookie_name`, `ip_address`, `expiry_date`) VALUES
(23, 'cookieConsent', '192.168.0.15', '2034-05-14 23:53:09'),
(25, 'cookieConsent', 'DESKTOP-U6LSR3L', '2024-05-31 18:36:26');

-- --------------------------------------------------------

--
-- Estrutura da tabela `faltas`
--

CREATE TABLE `faltas` (
  `indice_falta` int(11) NOT NULL,
  `user` varchar(255) NOT NULL,
  `indice_aula` int(11) NOT NULL,
  `id_aula` int(11) NOT NULL,
  `dia` date NOT NULL,
  `tipo_falta` int(11) NOT NULL,
  `cod_dis` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Extraindo dados da tabela `faltas`
--

INSERT INTO `faltas` (`indice_falta`, `user`, `indice_aula`, `id_aula`, `dia`, `tipo_falta`, `cod_dis`) VALUES
(422, 'a110', 30, 61, '2024-04-26', 0, 0),
(423, 'a110', 30, 61, '2024-04-26', 3, 0),
(424, 'a110', 30, 61, '2024-04-26', 4, 0),
(425, 'a110', 30, 61, '2024-04-26', 5, 0),
(426, 'a115', 30, 61, '2024-04-26', 1, 0),
(427, 'a121', 30, 61, '2024-04-26', 2, 0),
(428, 'a110', 34, 61, '2024-04-26', 0, 0),
(429, 'a110', 34, 61, '2024-04-26', 4, 0),
(430, 'a110', 34, 61, '2024-04-26', 3, 0),
(431, 'a110', 34, 61, '2024-04-26', 5, 0),
(432, 'a115', 34, 61, '2024-04-26', 2, 0),
(433, 'a121', 34, 61, '2024-04-26', 1, 0),
(446, 'a110', 35, 61, '2024-05-07', 0, 0),
(447, 'a110', 35, 61, '2024-05-07', 3, 0),
(448, 'a110', 35, 61, '2024-05-07', 4, 0),
(449, 'a115', 35, 61, '2024-05-07', 2, 0),
(450, 'a110', 35, 61, '2024-05-07', 5, 0),
(451, 'a121', 35, 61, '2024-05-07', 1, 0),
(452, 'a120', 35, 61, '2024-05-07', 0, 0),
(453, 'a110', 2, 60, '2024-05-07', 0, 0),
(454, 'a110', 2, 60, '2024-05-07', 4, 0),
(455, 'a110', 36, 61, '2024-05-09', 0, 0),
(456, 'a110', 36, 61, '2024-05-09', 3, 0),
(457, 'a115', 36, 61, '2024-05-09', 2, 0),
(458, 'a120', 36, 61, '2024-05-09', 2, 0),
(459, 'a121', 36, 61, '2024-05-09', 1, 0),
(463, 'a120', 37, 61, '2024-05-10', 0, 2),
(464, 'a110', 38, 61, '2024-05-10', 0, 2),
(465, 'a110', 38, 61, '2024-05-10', 3, 2),
(466, 'a110', 38, 61, '2024-05-10', 4, 2),
(467, 'a115', 38, 61, '2024-05-10', 2, 2),
(468, 'a110', 38, 61, '2024-05-10', 5, 2),
(469, 'a121', 38, 61, '2024-05-10', 1, 2),
(470, 'a120', 38, 61, '2024-05-10', 0, 2),
(471, 'a120', 38, 61, '2024-05-10', 3, 2),
(472, 'a120', 38, 61, '2024-05-10', 4, 2),
(473, 'a120', 38, 61, '2024-05-10', 5, 2),
(474, 'a115', 39, 61, '2024-05-10', 0, 2),
(475, 'a110', 39, 61, '2024-05-10', 0, 2),
(476, 'a121', 39, 61, '2024-05-10', 0, 2),
(477, 'a120', 39, 61, '2024-05-10', 0, 2),
(478, 'a110', 40, 61, '2024-05-10', 2, 2),
(479, 'a115', 40, 61, '2024-05-10', 0, 2),
(480, 'a121', 40, 61, '2024-05-10', 0, 2),
(481, 'a120', 40, 61, '2024-05-10', 0, 2),
(482, 'a110', 41, 61, '2024-05-10', 1, 2),
(483, 'a115', 41, 61, '2024-05-10', 0, 2),
(484, 'a121', 41, 61, '2024-05-10', 0, 2),
(485, 'a120', 41, 61, '2024-05-10', 2, 2),
(486, 'a110', 42, 61, '2024-05-10', 1, 2),
(487, 'a115', 42, 61, '2024-05-10', 1, 2),
(488, 'a121', 42, 61, '2024-05-10', 1, 2),
(489, 'a120', 42, 61, '2024-05-10', 1, 2),
(538, 'a110', 44, 61, '2024-05-28', 1, 2),
(539, 'a115', 44, 61, '2024-05-28', 0, 2),
(540, 'a121', 44, 61, '2024-05-28', 0, 2),
(541, 'a120', 44, 61, '2024-05-28', 0, 2),
(542, 'a110', 3, 60, '2024-05-29', 1, 3);

-- --------------------------------------------------------

--
-- Estrutura da tabela `fardas`
--

CREATE TABLE `fardas` (
  `id_peca` int(11) NOT NULL,
  `tipo` varchar(255) NOT NULL,
  `genero` varchar(255) NOT NULL,
  `tamanho` int(11) NOT NULL,
  `estado` int(11) NOT NULL DEFAULT 0,
  `membs` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Extraindo dados da tabela `fardas`
--

INSERT INTO `fardas` (`id_peca`, `tipo`, `genero`, `tamanho`, `estado`, `membs`) VALUES
(22, 'Chapéu', 'Mulher', 42, 0, NULL),
(23, 'Casaco', 'Homem', 36, 1, 'João Gomes');

-- --------------------------------------------------------

--
-- Estrutura da tabela `faturas`
--

CREATE TABLE `faturas` (
  `fatura_num` int(11) NOT NULL,
  `num_fatura` varchar(255) NOT NULL,
  `user` varchar(255) DEFAULT NULL,
  `unique_id` varchar(255) NOT NULL,
  `valor` float NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Extraindo dados da tabela `faturas`
--

INSERT INTO `faturas` (`fatura_num`, `num_fatura`, `user`, `unique_id`, `valor`) VALUES
(1, 'F7', 'a110', '', 0),
(2, 'F7', 'a110', '', 0),
(3, 'F7', 'a110', '', 0),
(4, 'F7', 'a110', '', 0),
(5, 'F7', 'a110', '', 0),
(6, 'F7', 'a110', '', 0),
(7, 'F7', 'a110', '', 0),
(8, 'F7', 'a110', '', 0),
(9, 'F7', 'a110', '', 0),
(10, 'F7', 'a110', '', 0),
(11, 'F7', 'a110', '', 0),
(12, 'F7', 'a110', '', 0),
(13, 'F7', 'a110', '', 0),
(14, 'F7', 'a110', '', 0),
(15, 'F7', 'a110', '', 0),
(16, 'F7', 'a110', '', 0),
(17, 'F7', 'a110', '', 0),
(18, 'F7', 'a110', '', 0),
(19, 'F7', 'a110', '', 0),
(20, 'F7', 'a110', '', 0),
(21, 'F7', 'a110', '', 0),
(22, 'F7', 'a110', '', 0),
(23, 'F7', 'a110', '', 0),
(24, 'F7', 'a110', '', 0),
(25, 'F7', 'a110', '', 0),
(26, 'F7', 'a110', '', 0),
(27, 'F7', 'a110', '', 0),
(28, 'F7', 'a110', '', 0),
(29, 'F7', 'a110', '', 0),
(30, 'F7', 'a110', '', 0),
(31, 'F7', 'a110', '', 0),
(32, 'F7', 'a110', '', 0),
(33, 'F7', 'a110', '', 0),
(34, 'F7', 'a110', '', 0),
(35, 'F7', 'a110', '', 0),
(36, 'F7', 'a110', '', 0),
(37, 'F7', 'a110', '', 0),
(38, 'F7', 'a110', '', 0),
(39, 'F7', 'a110', '', 0),
(40, 'F7', 'a110', '', 0),
(41, 'F7', 'a110', '', 0),
(42, 'F7', 'a110', '', 0),
(43, 'F7', 'a110', '', 0),
(44, 'F7', 'a110', '', 0),
(45, 'F7', 'a110', '', 0),
(46, 'F7', 'a110', '', 0),
(47, 'F7', 'a110', '', 0),
(48, 'F7', 'a110', '', 0),
(49, 'F8', 'a116', '', 0),
(50, 'F8', 'a116', '', 0),
(51, 'F8', 'a116', '', 0),
(52, 'F9', 'a117', '', 0),
(53, 'F9', 'a117', '', 0),
(54, 'F7', 'a110', '', 0),
(55, 'F10', 'a118', '', 0),
(56, 'F11', 'a119', '', 0),
(57, 'F12', 'a120', '', 0),
(58, 'F12', 'a120', '', 0),
(59, 'F12', 'a120', '', 0),
(60, '', '', '', 0),
(61, 'F12', 'a120', '', 0),
(62, 'F12', 'a120', '', 0),
(63, 'F12', 'a120', '', 0),
(64, 'F12', 'a120', '', 0),
(65, 'F12', 'a120', '', 0),
(66, 'F12', 'a120', '', 0),
(67, 'F12', 'a120', '', 0),
(68, 'F12', 'a120', '', 0),
(69, 'F12', 'a120', '', 0),
(70, 'F12', 'a120', '', 0),
(71, 'F12', 'a120', '', 0),
(72, 'F12', 'a120', '', 0),
(73, 'F12', 'a120', '', 0),
(74, 'F12', 'a120', '', 0),
(75, 'F12', 'a120', '', 0),
(76, 'F12', 'a120', '', 0),
(77, 'F12', 'a120', '', 0),
(78, 'F12', 'a120', '', 0),
(79, 'F12', 'a120', '', 0),
(80, 'F12', 'a120', '', 0),
(81, 'F12', 'a120', '', 0),
(82, 'F12', 'a120', '', 0),
(83, 'F12', 'a120', '', 0),
(84, 'F12', 'a120', '', 0),
(85, 'F12', 'a120', '', 0),
(86, 'F12', 'a120', '', 0),
(87, 'F12', 'a120', '', 0),
(88, 'F12', 'a120', '', 0),
(89, 'F12', 'a120', '', 0),
(90, 'F12', 'a120', '', 0),
(91, 'F12', 'a120', '', 0),
(92, 'F7', 'a110', '', 0),
(93, 'F7', 'a110', '', 0),
(94, 'F7', 'a110', '', 0),
(95, 'F12', 'a120', '', 0),
(96, 'F12', 'a120', '', 0),
(97, 'F12', 'a120', '', 0),
(98, 'F12', 'a120', '', 0),
(99, 'F7', 'a110', '', 0),
(100, 'F12', 'a120', '', 0),
(101, 'F12', 'a120', '', 0),
(102, 'F12', 'a120', '', 0),
(103, 'F12', 'a120', '', 0),
(104, 'F12', 'a120', '', 0),
(105, 'F12', 'a120', '', 0),
(106, 'F12', 'a120', '', 0),
(107, 'F12', 'a120', '', 0),
(108, 'F12', 'a120', '', 0),
(109, 'F12', 'a120', '', 0),
(110, 'F12', 'a120', '', 0),
(111, 'F12', 'a120', '', 0),
(112, 'F12', 'a120', '', 0),
(113, 'F12', 'a120', '', 0),
(114, 'F12', 'a120', '', 0),
(115, 'F12', 'a120', '', 0),
(116, 'F12', 'a120', '', 0),
(117, 'F12', 'a120', '', 0),
(118, 'F12', 'a120', '', 0),
(119, 'F12', 'a120', '', 0),
(120, 'F7', 'a110', '', 0),
(121, 'F7', 'a110', '', 0),
(123, 'F13', 'a121', '', 0),
(124, 'F12', 'a120', '', 0),
(125, 'F12', 'a120', '', 0),
(126, 'F9', 'a117', '', 0),
(127, 'F7', 'a110', '', 0),
(128, 'F13', 'a121', '', 0),
(129, 'F13', 'a121', '', 0),
(130, 'F9', 'a117', '', 0),
(131, 'F9', 'a117', '', 0),
(132, 'F13', 'a121', '', 0),
(133, 'F13', 'a121', '', 0),
(134, 'F13', 'a121', '', 0),
(135, 'F13', 'a121', '', 0),
(136, 'F13', 'a121', '', 0),
(137, 'F13', 'a121', '', 0),
(138, 'F13', 'a121', '', 0),
(139, 'F13', 'a121', '', 0),
(140, 'F13', 'a121', '', 0),
(141, 'F13', 'a121', '', 0),
(142, 'F13', 'a121', '', 0),
(143, 'F13', 'a121', '', 0),
(144, 'F13', 'a121', '', 0),
(145, 'F13', 'a121', '', 0),
(146, 'F13', 'a121', '', 0),
(147, 'F13', 'a121', '', 0),
(148, 'F13', 'a121', '', 0),
(149, 'F13', 'a121', '', 0),
(150, 'F13', 'a121', '', 0),
(151, 'F13', 'a121', '', 0),
(152, 'F13', 'a121', '', 0),
(153, 'F13', 'a121', '', 0),
(154, 'F13', 'a121', '', 0),
(155, 'F13', 'a121', '', 0),
(156, 'F13', 'a121', '', 0),
(157, 'F13', 'a121', '', 0),
(158, 'F13', 'a121', '', 0),
(159, 'F13', 'a121', '', 0),
(160, 'F13', 'a121', 'PNTLK PNTLK792-792', 0),
(161, 'F12', 'a120', 'WTTQU WTTQU491-491', 0),
(162, 'F12', 'a120', 'FUCTX FUCTX751-751', 0),
(163, 'F12', 'a120', 'YBTVI YBTVI036-036', 0),
(164, 'F12', 'a120', 'NDKLV NDKLV873-873', 0),
(165, 'F', '', 'BJCBK BJCBK379-379', 0),
(166, 'F', '', 'EKYOS EKYOS453-453', 0),
(167, 'F', '', 'OGMHX OGMHX069-069', 0),
(168, 'F', '', 'GSWNS GSWNS297-297', 0),
(169, 'Q3', '3', 'OGDYY OGDYY219-219', 0),
(170, 'Q', 's3', 'NVVWN NVVWN548-548', 0),
(171, 'Q3', 's3', 'CYQSK CYQSK808-808', 0),
(172, 'Q4', 's4', 'UTKWM UTKWM122-122', 0),
(173, 'Q4', 's4', 'NQZFH NQZFH750-750', 0),
(174, 'Q4', 's4', 'PGQIR PGQIR198-198', 0),
(175, 'Q2', 's2', 'IAJDZ IAJDZ239-239', 0),
(176, 'Q2', 's2', 'IVQKS IVQKS817-817', 0),
(177, 'Q1', 's1', 'AVFLY AVFLY296-296', 0),
(178, 'Q1', 's1', 'DTQNI DTQNI891-891', 0),
(179, 'Q1', 's1', 'KTDBJ KTDBJ923-923', 0),
(180, 'Q1', 's1', 'JCLZQ JCLZQ101-101', 0),
(181, 'Q3', 's3', 'JWDKQ JWDKQ867-867', 0),
(182, 'G', '', 'ZQWYG ZQWYG165-165', 0),
(183, 'G1', '', 'UKXSN UKXSN949-949', 0),
(184, 'G2', '', 'NZFRG NZFRG098-098', 0),
(185, 'G3', '', 'IJVDS IJVDS588-588', 0),
(186, 'G4', '', 'IDJRX IDJRX199-199', 0),
(187, 'G5', '', 'WJMZA WJMZA876-876', 0),
(188, 'G6', '', 'QFOKR QFOKR330-330', 0),
(189, 'G7', '', 'ESFRY ESFRY646-646', 0),
(190, 'G8', '', 'AUQGP AUQGP479-479', 0),
(191, 'G9', '', 'ZRNSV ZRNSV352-352', 0),
(192, 'G10', '', 'HWSJO HWSJO155-155', 0),
(193, 'G11', '', 'YGWDW YGWDW601-601', 0),
(194, 'G12', '', 'IDQCV IDQCV826-826', 0),
(195, 'G13', '', 'BBNXX BBNXX221-221', 0),
(196, 'G14', '', 'YFYKY YFYKY371-371', 0),
(197, 'G15', '', 'FCFJK FCFJK389-389', 0),
(198, 'G16', '', 'OMCAC OMCAC575-575', 0),
(199, 'G17', '', 'YAQRS YAQRS830-830', 0),
(200, 'G18', '', 'YHFOZ YHFOZ060-060', 0),
(201, 'G19', '', 'PXHPM PXHPM455-455', 0),
(202, 'G20', '', 'TEERT TEERT339-339', 0),
(203, 'G21', '', 'YICKT YICKT490-490', 0),
(204, 'G22', NULL, 'EOPAD EOPAD010-010', 0),
(205, 'G23', NULL, 'ERDVB ERDVB638-638', 0),
(206, 'G24', NULL, 'QSXKM QSXKM313-313', 0),
(207, 'Q6', 's6', 'FQHSQ FQHSQ184-184', 0),
(208, 'Q6', 's6', 'XEKTO XEKTO863-863', 0),
(209, 'Q6', 's6', 'PTNXF PTNXF622-622', 0),
(210, 'Q6', 's6', 'UAVWF UAVWF830-830', 0),
(211, 'Q6', 's6', 'GOWCE GOWCE162-162', 0),
(212, 'Q6', 's6', 'OQQHM OQQHM069-069', 0),
(213, 'F13', 'a121', 'MDNBJ MDNBJ828-828', 0),
(214, 'G25', NULL, 'CTXQX CTXQX160-160', 0),
(215, 'G26', NULL, 'RTYOS RTYOS211-211', 0),
(216, 'F12', 'a120', 'WDWCK WDWCK320-320', 0),
(217, 'F12', 'a120', 'LCKYD LCKYD422-422', 0),
(218, 'F12', 'a120', 'TYOUE TYOUE683-683', 0),
(219, 'F12', 'a120', 'FRTAF FRTAF683-683', 0),
(220, 'F12', 'a120', 'QPGLA QPGLA905-905', 0),
(221, 'F12', 'a120', 'OZDPU OZDPU753-753', 0),
(222, 'F12', 'a120', 'MXKHK MXKHK681-681', 0),
(223, 'F12', 'a120', 'JMIQA JMIQA417-417', 0),
(224, 'F12', 'a120', 'VIXZP VIXZP486-486', 0),
(225, 'F12', 'a120', 'LWMEI LWMEI234-234', 0),
(226, 'F12', 'a120', 'AOOGP AOOGP347-347', 0),
(227, 'F12', 'a120', 'GQTYZ GQTYZ670-670', 0),
(228, 'F12', 'a120', 'TMOGT TMOGT219-219', 0),
(229, 'F12', 'a120', 'YDQGZ YDQGZ386-386', 0),
(230, 'F12', 'a120', 'WMVCM WMVCM107-107', 0),
(231, 'F12', 'a120', 'SJGEU SJGEU769-769', 0),
(232, 'F12', 'a120', 'ZIXDF ZIXDF633-633', 0),
(233, 'F12', 'a120', 'SCYOS SCYOS861-861', 0),
(234, 'F12', 'a120', 'UXPZO UXPZO401-401', 0),
(235, 'G27', NULL, 'MFIRQ MFIRQ649-649', 0),
(236, 'F12', 'a120', 'RYCVK RYCVK513-513', 0),
(237, 'F12', 'a120', 'LJIAT LJIAT650-650', 0),
(238, 'F12', 'a120', 'WPZAG WPZAG390-390', 0),
(239, 'F12', 'a120', 'NWFQY NWFQY756-756', 0),
(240, 'F12', 'a120', 'UKAZZ UKAZZ874-874', 0),
(241, 'F12', 'a120', 'TXWAI TXWAI280-280', 0),
(242, 'Q1', 's1', 'XFJXD XFJXD058-058', 0),
(243, 'Q1', 's1', 'XOWIS XOWIS012-012', 0),
(244, 'F12', 'a120', 'BTPNQ BTPNQ493-493', 0),
(245, 'F12', 'a120', 'WKPLT WKPLT510-510', 0),
(246, 'F12', 'a120', 'QQEGG QQEGG173-173', 0),
(247, 'F7', 'a110', 'ONAQU ONAQU377-377', 0),
(248, 'F7', 'a110', 'ZGBTE ZGBTE905-905', 0),
(249, 'F7', 'a110', 'JRSQN JRSQN474-474', 0),
(250, 'F12', 'a120', 'QOKUA QOKUA649-649', 0),
(251, 'F12', 'a120', 'HTFDM HTFDM805-805', 0),
(252, 'F7', 'a110', 'RIQRS RIQRS052-052', 0),
(253, 'F12', 'a120', 'LCGOV LCGOV713-713', 0),
(254, 'F12', 'a120', 'QXLXR QXLXR367-367', 0),
(255, 'F12', 'a120', 'BNJZE BNJZE662-662', 0),
(256, 'F12', 'a120', 'UZJOA UZJOA577-577', 0),
(257, 'F12', 'a120', 'OMZPI OMZPI125-125', 0),
(258, 'F12', 'a120', 'OWWPJ OWWPJ503-503', 0),
(259, 'F12', 'a120', 'YVJVQ YVJVQ595-595', 0),
(260, 'F12', 'a120', 'XSDTL XSDTL887-887', 0),
(261, 'F10', 'a118', 'NDJGU NDJGU315-315', 0),
(262, 'F7', 'a110', 'FPQHA FPQHA885-885', 0),
(263, 'F7', 'a110', 'HKBSL HKBSL869-869', 0),
(264, 'F7', 'a110', 'CLKWV CLKWV366-366', 0),
(265, 'F7', 'a110', 'XVEXV XVEXV206-206', 0),
(266, 'F12', 'a120', 'TBCLL TBCLL835-835', 117),
(267, 'F7', 'a110', 'CUCVQ CUCVQ222-222', 0),
(268, 'F7', 'a110', 'KWVLC KWVLC902-902', 0),
(269, 'F7', 'a110', 'CTZHE CTZHE819-819', 48.45),
(270, 'F7', 'a110', 'NPIBU NPIBU467-467', 48.45),
(271, 'F7', 'a110', 'EOIQW EOIQW204-204', 48.45),
(272, 'F7', 'a110', 'LMUWU LMUWU067-067', 48.45),
(273, 'F7', 'a110', 'BPDBC BPDBC769-769', 48.45),
(274, 'F7', 'a110', 'PAAOZ PAAOZ880-880', 48.45),
(275, 'F7', 'a110', 'SDNNI SDNNI174-174', 48.45),
(276, 'F7', 'a110', 'DPEAH DPEAH884-884', 48.45),
(277, 'F7', 'a110', 'DWGFV DWGFV029-029', 48.45),
(278, 'F7', 'a110', 'LCLAP LCLAP478-478', 24.225),
(279, 'F7', 'a110', 'ZHHGO ZHHGO349-349', 48.45),
(280, 'F7', 'a110', 'GBNGE GBNGE541-541', 48.45),
(281, 'F7', 'a110', 'CNSIG CNSIG495-495', 48.45),
(282, 'Q11', 's11', 'WOGUB WOGUB834-834', 12),
(283, 'G28', NULL, 'KDJQR KDJQR804-804', 0),
(284, 'G29', NULL, 'BIXPN BIXPN004-004', 0),
(285, 'G30', NULL, 'CSYBY CSYBY525-525', 0),
(286, 'Q13', 's13', 'MAWJK MAWJK874-874', 12),
(287, 'Q13', 's13', 'VVOYJ VVOYJ084-084', 12),
(288, 'Q13', 's13', 'UWJQD UWJQD340-340', 12),
(289, 'Q13', 's13', 'MAQFQ MAQFQ726-726', 12),
(290, 'Q13', 's13', 'KYLQP KYLQP578-578', 12),
(291, 'Q13', 's13', 'CSRNR VRHGR-603', 12),
(292, 'Q13', 's13', 'GYSHD QREUK688-158', 12),
(293, 'Q13', 's13', 'EPRCM ONIBN579-213', 12),
(294, 'Q13', 's13', 'JPHHT YHMKM145-136', 12),
(295, 'Q13', 's13', 'XCDBG YLBCL893-094', 12),
(296, 'Q13', 's13', 'VQGZR MIDPB642-879', 12),
(297, 'Q13', 's13', 'CVWVM MXCLP769-944', 12),
(298, 'Q13', 's13', 'UKMRE EBJHQ608-427', 12),
(299, 'Q13', 's13', 'ZRWBV YKGCH808-014', 12),
(300, 'F7', 'a110', 'HHMHU QJVWG135-101', 51.3);

-- --------------------------------------------------------

--
-- Estrutura da tabela `fatura_gen`
--

CREATE TABLE `fatura_gen` (
  `fatura_num` int(11) NOT NULL,
  `cod_fatura` varchar(255) NOT NULL,
  `nome` varchar(255) NOT NULL,
  `unique_id` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Extraindo dados da tabela `fatura_gen`
--

INSERT INTO `fatura_gen` (`fatura_num`, `cod_fatura`, `nome`, `unique_id`) VALUES
(204, 'G22', 'Pedro Ribeiro', 'EOPAD EOPAD010-010'),
(205, 'G23', '', 'ERDVB ERDVB638-638'),
(206, 'G24', 'Pedro Ribeiro', 'QSXKM QSXKM313-313'),
(214, 'G25', 'Pedro Ribeiro', 'CTXQX CTXQX160-160'),
(215, 'G26', 'Pedro Ribeiro', 'RTYOS RTYOS211-211'),
(235, 'G27', 'adad', 'MFIRQ MFIRQ649-649'),
(204, 'G22', 'Pedro Ribeiro', 'EOPAD EOPAD010-010'),
(205, 'G23', '', 'ERDVB ERDVB638-638'),
(206, 'G24', 'Pedro Ribeiro', 'QSXKM QSXKM313-313'),
(214, 'G25', 'Pedro Ribeiro', 'CTXQX CTXQX160-160'),
(215, 'G26', 'Pedro Ribeiro', 'RTYOS RTYOS211-211'),
(235, 'G27', 'adad', 'MFIRQ MFIRQ649-649'),
(204, 'G22', 'Pedro Ribeiro', 'EOPAD EOPAD010-010'),
(205, 'G23', '', 'ERDVB ERDVB638-638'),
(206, 'G24', 'Pedro Ribeiro', 'QSXKM QSXKM313-313'),
(214, 'G25', 'Pedro Ribeiro', 'CTXQX CTXQX160-160'),
(215, 'G26', 'Pedro Ribeiro', 'RTYOS RTYOS211-211'),
(235, 'G27', 'adad', 'MFIRQ MFIRQ649-649'),
(283, 'G28', 'Pedro Henriques Ribeiro', 'KDJQR KDJQR804-804'),
(284, 'G29', 'Pedro Henriques Ribeiro', 'BIXPN BIXPN004-004'),
(285, 'G30', 'Pedro Henriques Ribeiro', 'CSYBY CSYBY525-525'),
(204, 'G22', 'Pedro Ribeiro', 'EOPAD EOPAD010-010'),
(205, 'G23', '', 'ERDVB ERDVB638-638'),
(206, 'G24', 'Pedro Ribeiro', 'QSXKM QSXKM313-313'),
(214, 'G25', 'Pedro Ribeiro', 'CTXQX CTXQX160-160'),
(215, 'G26', 'Pedro Ribeiro', 'RTYOS RTYOS211-211'),
(235, 'G27', 'adad', 'MFIRQ MFIRQ649-649'),
(204, 'G22', 'Pedro Ribeiro', 'EOPAD EOPAD010-010'),
(205, 'G23', '', 'ERDVB ERDVB638-638'),
(206, 'G24', 'Pedro Ribeiro', 'QSXKM QSXKM313-313'),
(214, 'G25', 'Pedro Ribeiro', 'CTXQX CTXQX160-160'),
(215, 'G26', 'Pedro Ribeiro', 'RTYOS RTYOS211-211'),
(235, 'G27', 'adad', 'MFIRQ MFIRQ649-649'),
(204, 'G22', 'Pedro Ribeiro', 'EOPAD EOPAD010-010'),
(205, 'G23', '', 'ERDVB ERDVB638-638'),
(206, 'G24', 'Pedro Ribeiro', 'QSXKM QSXKM313-313'),
(214, 'G25', 'Pedro Ribeiro', 'CTXQX CTXQX160-160'),
(215, 'G26', 'Pedro Ribeiro', 'RTYOS RTYOS211-211'),
(235, 'G27', 'adad', 'MFIRQ MFIRQ649-649'),
(283, 'G28', 'Pedro Henriques Ribeiro', 'KDJQR KDJQR804-804'),
(284, 'G29', 'Pedro Henriques Ribeiro', 'BIXPN BIXPN004-004'),
(285, 'G30', 'Pedro Henriques Ribeiro', 'CSYBY CSYBY525-525');

-- --------------------------------------------------------

--
-- Estrutura da tabela `graus`
--

CREATE TABLE `graus` (
  `id_grau` int(11) NOT NULL,
  `nome_grau` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Extraindo dados da tabela `graus`
--

INSERT INTO `graus` (`id_grau`, `nome_grau`) VALUES
(1, 'Iniciação I'),
(2, 'Iniciação II'),
(3, 'Iniciação III'),
(4, 'Iniciação IV'),
(5, 'I Grau'),
(6, 'II Grau'),
(7, 'III Grau'),
(8, 'IV Grau'),
(9, 'V Grau'),
(10, 'VI Grau'),
(11, 'VII Grau'),
(12, 'VIII Grau'),
(13, 'Pré-Iniciação I'),
(14, 'Pré-Iniciação II'),
(15, 'Pré-Iniciação III'),
(16, 'Pré-Iniciação IV');

-- --------------------------------------------------------

--
-- Estrutura da tabela `inscricoes`
--

CREATE TABLE `inscricoes` (
  `id_inscricao` int(11) NOT NULL,
  `nome` varchar(255) NOT NULL,
  `morada1` varchar(255) NOT NULL,
  `morada2` varchar(225) NOT NULL,
  `nif` int(11) NOT NULL,
  `cc` int(11) NOT NULL,
  `data_nas` date NOT NULL,
  `email` varchar(255) NOT NULL,
  `telef` varchar(255) NOT NULL,
  `foto` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Extraindo dados da tabela `inscricoes`
--

INSERT INTO `inscricoes` (`id_inscricao`, `nome`, `morada1`, `morada2`, `nif`, `cc`, `data_nas`, `email`, `telef`, `foto`) VALUES
(1, 'André Carlos da Costa de Sacadura Cabral', 'Rua da Bela Vista, 115', '4028-354', 198525141, 10354741, '2001-02-09', 'ana@outlook.com', '962417521', 'Array'),
(2, 'André Carlos da Costa de Sacadura Cabral', 'Rua da Bela Vista, 115', '4028-354', 198525141, 10354741, '2001-02-09', 'ana@outlook.com', '962417521', 'Array'),
(3, 'André Carlos da Costa de Sacadura Cabral', 'Rua da Bela Vista, 115', '4028-354', 198525141, 10354741, '2001-02-09', 'ana@outlook.com', '962417521', 'Array'),
(4, 'André Carlos da Costa de Sacadura Cabral', 'Rua da Bela Vista, 115', '4028-354', 198525141, 10354741, '2001-02-09', 'ana@outlook.com', '962417521', 'Array'),
(5, 'André Carlos da Costa de Sacadura Cabral', 'Rua do Cruzeiro Velho, 12, 1.º Tras', '4028-354', 123456789, 12345678, '2024-05-02', 'aaaa@aaa.com', '123456789', ''),
(6, 'André Carlos da Costa de Sacadura Cabral', 'Rua do Cruzeiro Velho, 12, 1.º Tras', '4028-354', 123456789, 12345678, '2024-05-02', 'aaaa@aaa.com', '123456789', ''),
(7, 'Pedro Henriques Ribeiro', 'Rua do Ouro, 115', '4505-102 Argoncilhe', 1, 1, '2022-02-02', 's', '962417521', ''),
(8, 'Professor de Teste', 'Rua da Bela Vista, 115', '4028-354', 1, 1, '2022-02-02', 'a', '962417521', ''),
(9, 'André Carlos da Costa de Sacadura Cabral', 'Rua do Ouro, 115', '4028-354', 1, 1, '2001-01-01', '1', '1', ''),
(10, 'Maria João Alves Cunha', 'Rua do Cruzeiro Velho, 12, 1.º Tras', '4028-354', 1, 1, '0001-01-01', '1', '1', ''),
(11, 'Maria João Alves Cunha', 'Rua do Cruzeiro Velho, 12, 1.º Tras', '4505-102 Argoncilhe', 1, 1, '0001-01-01', '1', '1', ''),
(12, 'Ana', 'Rua do Ouro, 115', '4505-102 Argoncilhe', 1, 1, '0001-01-01', '1', '1', ''),
(13, 'Ana', 'Rua do Ouro, 115', '4505-102 Argoncilhe', 1, 1, '0001-01-01', '1', '1', ''),
(14, 'Ana', 'Rua do Ouro, 115', '4505-102 Argoncilhe', 1, 1, '0001-01-01', '1', '1', 'fotos-inscricoes/6642a11952b2f_150px-Portugal_FPF.png');

-- --------------------------------------------------------

--
-- Estrutura da tabela `instrumentos`
--

CREATE TABLE `instrumentos` (
  `codigo` int(11) NOT NULL,
  `cat` varchar(255) NOT NULL,
  `des` varchar(255) NOT NULL,
  `estado` int(11) NOT NULL DEFAULT 0,
  `user` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Extraindo dados da tabela `instrumentos`
--

INSERT INTO `instrumentos` (`codigo`, `cat`, `des`, `estado`, `user`) VALUES
(1, 'Clarinete Baixo', '', 1, 'a121'),
(2, 'Clarinete', '', 1, 'a110'),
(3, 'Clarinete', '', 1, 'a117'),
(4, 'Flauta Transversal', '', 0, NULL),
(5, 'Flauta Transversal', '', 1, 'a120'),
(6, 'Violino', '', 1, 'a116'),
(7, 'Fagote', 'Inexistente.', 1, 'a104'),
(8, 'Fagote', '', 0, NULL),
(9, 'Clarinete', 'Clarinete de 17 chaves em bom estado - bom para iniciantes.', 0, NULL);

-- --------------------------------------------------------

--
-- Estrutura da tabela `irmaos`
--

CREATE TABLE `irmaos` (
  `user_1` varchar(255) NOT NULL,
  `user_1_irmao` varchar(255) NOT NULL,
  `num_irmao` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Extraindo dados da tabela `irmaos`
--

INSERT INTO `irmaos` (`user_1`, `user_1_irmao`, `num_irmao`) VALUES
('a110', 'a112', 1),
('a110', 'a112', 1);

-- --------------------------------------------------------

--
-- Estrutura da tabela `justificacao_faltas`
--

CREATE TABLE `justificacao_faltas` (
  `id` int(11) NOT NULL,
  `indice_falta` int(11) NOT NULL,
  `tipo_falta` int(11) NOT NULL,
  `user` varchar(255) NOT NULL,
  `id_aula` int(11) NOT NULL,
  `indice_aula` int(11) NOT NULL,
  `data_pedido` date NOT NULL,
  `motivo` text NOT NULL,
  `anexo` varchar(255) NOT NULL,
  `estado` int(11) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Extraindo dados da tabela `justificacao_faltas`
--

INSERT INTO `justificacao_faltas` (`id`, `indice_falta`, `tipo_falta`, `user`, `id_aula`, `indice_aula`, `data_pedido`, `motivo`, `anexo`, `estado`) VALUES
(14, 430, 3, 'a110', 61, 34, '2024-05-09', 'Doença repentina.', '', 1),
(15, 423, 3, 'a110', 61, 30, '2024-05-09', 'Correria imensa.', '', 1),
(16, 456, 3, 'a110', 61, 36, '2024-05-09', 'AAAA', '', 1),
(17, 458, 1, 'a120', 61, 36, '2024-05-09', 'É bom que se justifique.', '', 1),
(20, 542, 1, 'a110', 60, 3, '2024-05-29', 'Doença.', '', 1);

-- --------------------------------------------------------

--
-- Estrutura da tabela `mensalidades_alunos`
--

CREATE TABLE `mensalidades_alunos` (
  `id` int(11) NOT NULL,
  `id_mes` int(11) NOT NULL,
  `user` varchar(255) NOT NULL,
  `data_pagamento` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Extraindo dados da tabela `mensalidades_alunos`
--

INSERT INTO `mensalidades_alunos` (`id`, `id_mes`, `user`, `data_pagamento`) VALUES
(3, 9, 'a120', '2024-05-10'),
(4, 8, 'a120', '2024-05-10'),
(5, 9, 'a110', '2024-05-10'),
(6, 3, 'a110', '2024-05-10'),
(7, 4, 'a120', '2024-05-10'),
(8, 9, 'a118', '2024-05-10'),
(9, 5, 'a117', '2024-05-10'),
(12, 7, 'a110', '2024-05-11'),
(13, 7, 'a110', '2024-05-11'),
(14, 2, 'a110', '2024-05-11'),
(15, 2, 'a110', '2024-05-11');

-- --------------------------------------------------------

--
-- Estrutura da tabela `meses`
--

CREATE TABLE `meses` (
  `id_mes` int(11) NOT NULL,
  `nome_mes` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Extraindo dados da tabela `meses`
--

INSERT INTO `meses` (`id_mes`, `nome_mes`) VALUES
(1, 'Setembro'),
(2, 'Outubro'),
(3, 'Novembro'),
(4, 'Dezembro'),
(5, 'Janeiro'),
(6, 'Fevereiro'),
(7, 'Março'),
(8, 'Abril'),
(9, 'Maio'),
(10, 'Junho');

-- --------------------------------------------------------

--
-- Estrutura da tabela `noticias_fotos`
--

CREATE TABLE `noticias_fotos` (
  `id_noticia` int(11) NOT NULL,
  `fotos_noticia` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Extraindo dados da tabela `noticias_fotos`
--

INSERT INTO `noticias_fotos` (`id_noticia`, `fotos_noticia`) VALUES
(5, 'iVBORw0KGgoAAAANSUhEUgAAAOEAAADhCAMAAAAJbSJIAAAAolBMVEX///8bhzrj7+ay0rqnzLCmx60yk03t9vAAdQDA2sdhpnJAl1dbo20AgyrG3sx4sYb3+/hrq3seij7R5NZLml/p8+zb6t8AhDDW6tyQvpuHupMAfiIAfBu007zy+PSZw6NoqXiAtYw6k1FSnmUsjkefx6kAeRAmj0UAeADK3c4AcQCNv5qgy6yEtY+oyK9UnGV7t4tlrHi'),
(5, 'iVBORw0KGgoAAAANSUhEUgAAAOEAAADhCAYAAAA+s9J6AABa2UlEQVR4Xu1dBVwVWRcfBGkQA1GxEBHFwMLAwu4OzFV0rTXWXnH9Vtw11661du3ubl0sMLEwUVHAQAXpRr7/f3zDPpF4WKvLvb/fg/dmbp65Z865JyVJFAEBAQEBAQEBAQEBAQEBAQEBAQEBAQEBAQEBAQEBAQEBAQEBAQEBAQEBAQEBAQEBAQEBAQEBAQGBbwoCe64fcf6mJiw'),
(5, 'iVBORw0KGgoAAAANSUhEUgAAAOEAAADhCAMAAAAJbSJIAAAAolBMVEX///8bhzrj7+ay0rqnzLCmx60yk03t9vAAdQDA2sdhpnJAl1dbo20AgyrG3sx4sYb3+/hrq3seij7R5NZLml/p8+zb6t8AhDDW6tyQvpuHupMAfiIAfBu007zy+PSZw6NoqXiAtYw6k1FSnmUsjkefx6kAeRAmj0UAeADK3c4AcQCNv5qgy6yEtY+oyK9UnGV7t4tlrHi'),
(5, 'iVBORw0KGgoAAAANSUhEUgAAAOEAAADhCAYAAAA+s9J6AABa2UlEQVR4Xu1dBVwVWRcfBGkQA1GxEBHFwMLAwu4OzFV0rTXWXnH9Vtw11661du3ubl0sMLEwUVHAQAXpRr7/f3zDPpF4WKvLvb/fg/dmbp65Z865JyVJFAEBAQEBAQEBAQEBAQEBAQEBAQEBAQEBAQEBAQEBAQEBAQEBAQEBAQEBAQEBAQEBAQEBAQEBAQGBbwoCe64fcf6mJiw'),
(5, 'iVBORw0KGgoAAAANSUhEUgAAAOEAAADhCAYAAAA+s9J6AABa2UlEQVR4Xu1dBVwVWRcfBGkQA1GxEBHFwMLAwu4OzFV0rTXWXnH9Vtw11661du3ubl0sMLEwUVHAQAXpRr7/f3zDPpF4WKvLvb/fg/dmbp65Z865JyVJFAEBAQEBAQEBAQEBAQEBAQEBAQEBAQEBAQEBAQEBAQEBAQEBAQEBAQEBAQEBAQEBAQEBAQEBAQGBbwoCe64fcf6mJiw'),
(5, 'iVBORw0KGgoAAAANSUhEUgAAAOEAAADhCAYAAAA+s9J6AABa2UlEQVR4Xu1dBVwVWRcfBGkQA1GxEBHFwMLAwu4OzFV0rTXWXnH9Vtw11661du3ubl0sMLEwUVHAQAXpRr7/f3zDPpF4WKvLvb/fg/dmbp65Z865JyVJFAEBAQEBAQEBAQEBAQEBAQEBAQEBAQEBAQEBAQEBAQEBAQEBAQEBAQEBAQEBAQEBAQEBAQEBAQGBbwoCe64fcf6mJiw'),
(6, 'iVBORw0KGgoAAAANSUhEUgAAAOEAAADhCAMAAAAJbSJIAAAAolBMVEX///8bhzrj7+ay0rqnzLCmx60yk03t9vAAdQDA2sdhpnJAl1dbo20AgyrG3sx4sYb3+/hrq3seij7R5NZLml/p8+zb6t8AhDDW6tyQvpuHupMAfiIAfBu007zy+PSZw6NoqXiAtYw6k1FSnmUsjkefx6kAeRAmj0UAeADK3c4AcQCNv5qgy6yEtY+oyK9UnGV7t4tlrHi'),
(6, 'iVBORw0KGgoAAAANSUhEUgAAAOEAAADhCAYAAAA+s9J6AABa2UlEQVR4Xu1dBVwVWRcfBGkQA1GxEBHFwMLAwu4OzFV0rTXWXnH9Vtw11661du3ubl0sMLEwUVHAQAXpRr7/f3zDPpF4WKvLvb/fg/dmbp65Z865JyVJFAEBAQEBAQEBAQEBAQEBAQEBAQEBAQEBAQEBAQEBAQEBAQEBAQEBAQEBAQEBAQEBAQEBAQEBAQGBbwoCe64fcf6mJiw'),
(6, 'iVBORw0KGgoAAAANSUhEUgAAAOEAAADhCAMAAAAJbSJIAAAAolBMVEX///8bhzrj7+ay0rqnzLCmx60yk03t9vAAdQDA2sdhpnJAl1dbo20AgyrG3sx4sYb3+/hrq3seij7R5NZLml/p8+zb6t8AhDDW6tyQvpuHupMAfiIAfBu007zy+PSZw6NoqXiAtYw6k1FSnmUsjkefx6kAeRAmj0UAeADK3c4AcQCNv5qgy6yEtY+oyK9UnGV7t4tlrHi'),
(6, 'iVBORw0KGgoAAAANSUhEUgAAAOEAAADhCAYAAAA+s9J6AABa2UlEQVR4Xu1dBVwVWRcfBGkQA1GxEBHFwMLAwu4OzFV0rTXWXnH9Vtw11661du3ubl0sMLEwUVHAQAXpRr7/f3zDPpF4WKvLvb/fg/dmbp65Z865JyVJFAEBAQEBAQEBAQEBAQEBAQEBAQEBAQEBAQEBAQEBAQEBAQEBAQEBAQEBAQEBAQEBAQEBAQEBAQGBbwoCe64fcf6mJiw'),
(6, 'iVBORw0KGgoAAAANSUhEUgAAAOEAAADhCAYAAAA+s9J6AABa2UlEQVR4Xu1dBVwVWRcfBGkQA1GxEBHFwMLAwu4OzFV0rTXWXnH9Vtw11661du3ubl0sMLEwUVHAQAXpRr7/f3zDPpF4WKvLvb/fg/dmbp65Z865JyVJFAEBAQEBAQEBAQEBAQEBAQEBAQEBAQEBAQEBAQEBAQEBAQEBAQEBAQEBAQEBAQEBAQEBAQEBAQGBbwoCe64fcf6mJiw'),
(6, 'iVBORw0KGgoAAAANSUhEUgAAAOEAAADhCAYAAAA+s9J6AABa2UlEQVR4Xu1dBVwVWRcfBGkQA1GxEBHFwMLAwu4OzFV0rTXWXnH9Vtw11661du3ubl0sMLEwUVHAQAXpRr7/f3zDPpF4WKvLvb/fg/dmbp65Z865JyVJFAEBAQEBAQEBAQEBAQEBAQEBAQEBAQEBAQEBAQEBAQEBAQEBAQEBAQEBAQEBAQEBAQEBAQEBAQGBbwoCe64fcf6mJiw'),
(7, 'iVBORw0KGgoAAAANSUhEUgAAAOEAAADhCAMAAAAJbSJIAAAAolBMVEX///8bhzrj7+ay0rqnzLCmx60yk03t9vAAdQDA2sdhpnJAl1dbo20AgyrG3sx4sYb3+/hrq3seij7R5NZLml/p8+zb6t8AhDDW6tyQvpuHupMAfiIAfBu007zy+PSZw6NoqXiAtYw6k1FSnmUsjkefx6kAeRAmj0UAeADK3c4AcQCNv5qgy6yEtY+oyK9UnGV7t4tlrHi'),
(7, 'iVBORw0KGgoAAAANSUhEUgAAAOEAAADhCAYAAAA+s9J6AABa2UlEQVR4Xu1dBVwVWRcfBGkQA1GxEBHFwMLAwu4OzFV0rTXWXnH9Vtw11661du3ubl0sMLEwUVHAQAXpRr7/f3zDPpF4WKvLvb/fg/dmbp65Z865JyVJFAEBAQEBAQEBAQEBAQEBAQEBAQEBAQEBAQEBAQEBAQEBAQEBAQEBAQEBAQEBAQEBAQEBAQEBAQGBbwoCe64fcf6mJiw'),
(7, 'iVBORw0KGgoAAAANSUhEUgAAAOEAAADhCAMAAAAJbSJIAAAAolBMVEX///8bhzrj7+ay0rqnzLCmx60yk03t9vAAdQDA2sdhpnJAl1dbo20AgyrG3sx4sYb3+/hrq3seij7R5NZLml/p8+zb6t8AhDDW6tyQvpuHupMAfiIAfBu007zy+PSZw6NoqXiAtYw6k1FSnmUsjkefx6kAeRAmj0UAeADK3c4AcQCNv5qgy6yEtY+oyK9UnGV7t4tlrHi'),
(7, 'iVBORw0KGgoAAAANSUhEUgAAAOEAAADhCAYAAAA+s9J6AABa2UlEQVR4Xu1dBVwVWRcfBGkQA1GxEBHFwMLAwu4OzFV0rTXWXnH9Vtw11661du3ubl0sMLEwUVHAQAXpRr7/f3zDPpF4WKvLvb/fg/dmbp65Z865JyVJFAEBAQEBAQEBAQEBAQEBAQEBAQEBAQEBAQEBAQEBAQEBAQEBAQEBAQEBAQEBAQEBAQEBAQEBAQGBbwoCe64fcf6mJiw'),
(7, 'iVBORw0KGgoAAAANSUhEUgAAAOEAAADhCAYAAAA+s9J6AABa2UlEQVR4Xu1dBVwVWRcfBGkQA1GxEBHFwMLAwu4OzFV0rTXWXnH9Vtw11661du3ubl0sMLEwUVHAQAXpRr7/f3zDPpF4WKvLvb/fg/dmbp65Z865JyVJFAEBAQEBAQEBAQEBAQEBAQEBAQEBAQEBAQEBAQEBAQEBAQEBAQEBAQEBAQEBAQEBAQEBAQEBAQGBbwoCe64fcf6mJiw'),
(7, 'iVBORw0KGgoAAAANSUhEUgAAAOEAAADhCAYAAAA+s9J6AABa2UlEQVR4Xu1dBVwVWRcfBGkQA1GxEBHFwMLAwu4OzFV0rTXWXnH9Vtw11661du3ubl0sMLEwUVHAQAXpRr7/f3zDPpF4WKvLvb/fg/dmbp65Z865JyVJFAEBAQEBAQEBAQEBAQEBAQEBAQEBAQEBAQEBAQEBAQEBAQEBAQEBAQEBAQEBAQEBAQEBAQEBAQGBbwoCe64fcf6mJiw'),
(8, '6475dd2575cfd.jpg'),
(8, '6475dd2577c91.jpg'),
(8, '6475dd2579b77.jpg'),
(8, '6475dd257b0fe.jpg'),
(8, '6475dd257c10c.jpg'),
(8, '6475dd257f46f.jpg'),
(9, 'fotos-noticias/6475de734a62c.jpg'),
(9, 'fotos-noticias/6475de734b2c1.jpg'),
(9, 'fotos-noticias/6475de734bfb7.jpg'),
(9, 'fotos-noticias/6475de734cf44.jpg'),
(9, 'fotos-noticias/6475de734ea73.jpg'),
(9, 'fotos-noticias/6475de7350b24.jpg'),
(10, 'fotos-noticias/6475dea809c4e.jpg'),
(10, 'fotos-noticias/6475dea80bbdb.jpg'),
(10, 'fotos-noticias/6475dea80e163.jpg'),
(10, 'fotos-noticias/6475dea80f0e6.jpg'),
(10, 'fotos-noticias/6475dea811e9e.jpg'),
(10, 'fotos-noticias/6475dea814046.jpg'),
(11, '6475deeb1da4e.jpg'),
(11, '6475deeb1fa2e.jpg'),
(11, '6475deeb22228.jpg'),
(11, '6475deeb240fb.jpg'),
(11, '6475deeb25ec3.jpg'),
(11, '6475deeb271bc.jpg'),
(12, 'fotos-noticias/6475df0469c9e.jpg'),
(12, 'fotos-noticias/6475df046b852.jpg'),
(12, 'fotos-noticias/6475df046d2af.jpg'),
(12, 'fotos-noticias/6475df046f17e.jpg'),
(12, 'fotos-noticias/6475df0470cab.jpg'),
(12, 'fotos-noticias/6475df047214c.jpg'),
(13, 'fotos-noticias/6475df0644dd8.jpg'),
(13, 'fotos-noticias/6475df06468ac.jpg'),
(13, 'fotos-noticias/6475df0647741.jpg'),
(13, 'fotos-noticias/6475df0648512.jpg'),
(13, 'fotos-noticias/6475df064acd2.jpg'),
(13, 'fotos-noticias/6475df064bf73.jpg'),
(14, 'noticias-fotos/6475e0d9d0a47.jpg'),
(14, 'noticias-fotos/6475e0d9d2e0b.jpg'),
(14, 'noticias-fotos/6475e0d9d5939.jpg'),
(14, 'noticias-fotos/6475e0d9d79de.jpg'),
(14, 'noticias-fotos/6475e0d9d9d93.jpg'),
(14, 'noticias-fotos/6475e0d9dba80.jpg'),
(15, 'noticias-fotos/6475e0da76fbe.jpg'),
(15, 'noticias-fotos/6475e0da78b75.jpg'),
(15, 'noticias-fotos/6475e0da7a626.jpg'),
(15, 'noticias-fotos/6475e0da7cf7e.jpg'),
(15, 'noticias-fotos/6475e0da7f092.jpg'),
(15, 'noticias-fotos/6475e0da80dc4.jpg'),
(16, 'noticias-fotos/6475e0db0554d.jpg'),
(16, 'noticias-fotos/6475e0db07488.jpg'),
(16, 'noticias-fotos/6475e0db09b9d.jpg'),
(16, 'noticias-fotos/6475e0db0b8fa.jpg'),
(16, 'noticias-fotos/6475e0db0d6c9.jpg'),
(16, 'noticias-fotos/6475e0db0f81d.jpg'),
(17, 'noticias-fotos/6476079a63c36.jpg'),
(17, 'noticias-fotos/6476079a64db7.jpg'),
(17, 'noticias-fotos/6476079a65d5a.jpg'),
(18, 'noticias-fotos/647607aa1a140.jpg'),
(18, 'noticias-fotos/647607aa1b383.jpg'),
(18, 'noticias-fotos/647607aa1c6ae.jpg'),
(19, 'noticias-fotos/647607ab68540.jpg'),
(19, 'noticias-fotos/647607ab6a2ba.jpg'),
(19, 'noticias-fotos/647607ab6b635.jpg'),
(20, 'noticias-fotos/647607ac2d369.jpg'),
(20, 'noticias-fotos/647607ac2edac.jpg'),
(20, 'noticias-fotos/647607ac320f4.jpg'),
(21, 'noticias-fotos/647609e52d773.jpg'),
(22, 'noticias-fotos/64760baaf0b8e.jpg'),
(23, 'noticias-fotos/64760bd4e14d7.jpg'),
(24, 'noticias-fotos/64760bd53cfec.jpg'),
(25, 'noticias-fotos/64760bd566234.jpg'),
(26, 'noticias-fotos/64760bd58ca11.jpg'),
(27, 'noticias-fotos/64760bd5b42a0.jpg'),
(28, 'noticias-fotos/64760bd5dacf2.jpg'),
(29, 'noticias-fotos/64760bd6045de.jpg'),
(30, 'noticias-fotos/64760bd632a8a.jpg'),
(31, 'noticias-fotos/64760bd653691.jpg'),
(32, 'noticias-fotos/64760bd67b674.jpg'),
(33, 'noticias-fotos/6476149b12a65.jpg'),
(33, 'noticias-fotos/6476149b13ba8.jpg'),
(33, 'noticias-fotos/6476149b15013.jpg'),
(34, 'noticias-fotos/6479eea1bb684.jpg'),
(35, 'noticias-fotos/6479f02beba84.jpg'),
(36, 'noticias-fotos/6479f04c8c1d9.jpg'),
(37, 'noticias-fotos/6479f467ede32.jpg'),
(37, 'noticias-fotos/6479f467ef39e.jpg'),
(37, 'noticias-fotos/6479f467f076f.jpg'),
(37, 'noticias-fotos/6479f467f1d19.jpg'),
(37, 'noticias-fotos/6479f467f325a.jpg'),
(37, 'noticias-fotos/6479f4680067a.jpg'),
(38, 'noticias-fotos/6479f573332f3.jpg'),
(38, 'noticias-fotos/6479f57334fe4.jpg'),
(38, 'noticias-fotos/6479f5733666b.jpg'),
(38, 'noticias-fotos/6479f5733828f.jpg'),
(38, 'noticias-fotos/6479f573398ba.jpg'),
(38, 'noticias-fotos/6479f5733cc11.jpg'),
(39, 'noticias-fotos/6479f63b43841.jpg'),
(5, 'iVBORw0KGgoAAAANSUhEUgAAAOEAAADhCAMAAAAJbSJIAAAAolBMVEX///8bhzrj7+ay0rqnzLCmx60yk03t9vAAdQDA2sdhpnJAl1dbo20AgyrG3sx4sYb3+/hrq3seij7R5NZLml/p8+zb6t8AhDDW6tyQvpuHupMAfiIAfBu007zy+PSZw6NoqXiAtYw6k1FSnmUsjkefx6kAeRAmj0UAeADK3c4AcQCNv5qgy6yEtY+oyK9UnGV7t4tlrHi'),
(5, 'iVBORw0KGgoAAAANSUhEUgAAAOEAAADhCAYAAAA+s9J6AABa2UlEQVR4Xu1dBVwVWRcfBGkQA1GxEBHFwMLAwu4OzFV0rTXWXnH9Vtw11661du3ubl0sMLEwUVHAQAXpRr7/f3zDPpF4WKvLvb/fg/dmbp65Z865JyVJFAEBAQEBAQEBAQEBAQEBAQEBAQEBAQEBAQEBAQEBAQEBAQEBAQEBAQEBAQEBAQEBAQEBAQEBAQGBbwoCe64fcf6mJiw'),
(5, 'iVBORw0KGgoAAAANSUhEUgAAAOEAAADhCAMAAAAJbSJIAAAAolBMVEX///8bhzrj7+ay0rqnzLCmx60yk03t9vAAdQDA2sdhpnJAl1dbo20AgyrG3sx4sYb3+/hrq3seij7R5NZLml/p8+zb6t8AhDDW6tyQvpuHupMAfiIAfBu007zy+PSZw6NoqXiAtYw6k1FSnmUsjkefx6kAeRAmj0UAeADK3c4AcQCNv5qgy6yEtY+oyK9UnGV7t4tlrHi'),
(5, 'iVBORw0KGgoAAAANSUhEUgAAAOEAAADhCAYAAAA+s9J6AABa2UlEQVR4Xu1dBVwVWRcfBGkQA1GxEBHFwMLAwu4OzFV0rTXWXnH9Vtw11661du3ubl0sMLEwUVHAQAXpRr7/f3zDPpF4WKvLvb/fg/dmbp65Z865JyVJFAEBAQEBAQEBAQEBAQEBAQEBAQEBAQEBAQEBAQEBAQEBAQEBAQEBAQEBAQEBAQEBAQEBAQEBAQGBbwoCe64fcf6mJiw'),
(5, 'iVBORw0KGgoAAAANSUhEUgAAAOEAAADhCAYAAAA+s9J6AABa2UlEQVR4Xu1dBVwVWRcfBGkQA1GxEBHFwMLAwu4OzFV0rTXWXnH9Vtw11661du3ubl0sMLEwUVHAQAXpRr7/f3zDPpF4WKvLvb/fg/dmbp65Z865JyVJFAEBAQEBAQEBAQEBAQEBAQEBAQEBAQEBAQEBAQEBAQEBAQEBAQEBAQEBAQEBAQEBAQEBAQEBAQGBbwoCe64fcf6mJiw'),
(5, 'iVBORw0KGgoAAAANSUhEUgAAAOEAAADhCAYAAAA+s9J6AABa2UlEQVR4Xu1dBVwVWRcfBGkQA1GxEBHFwMLAwu4OzFV0rTXWXnH9Vtw11661du3ubl0sMLEwUVHAQAXpRr7/f3zDPpF4WKvLvb/fg/dmbp65Z865JyVJFAEBAQEBAQEBAQEBAQEBAQEBAQEBAQEBAQEBAQEBAQEBAQEBAQEBAQEBAQEBAQEBAQEBAQEBAQGBbwoCe64fcf6mJiw'),
(6, 'iVBORw0KGgoAAAANSUhEUgAAAOEAAADhCAMAAAAJbSJIAAAAolBMVEX///8bhzrj7+ay0rqnzLCmx60yk03t9vAAdQDA2sdhpnJAl1dbo20AgyrG3sx4sYb3+/hrq3seij7R5NZLml/p8+zb6t8AhDDW6tyQvpuHupMAfiIAfBu007zy+PSZw6NoqXiAtYw6k1FSnmUsjkefx6kAeRAmj0UAeADK3c4AcQCNv5qgy6yEtY+oyK9UnGV7t4tlrHi'),
(6, 'iVBORw0KGgoAAAANSUhEUgAAAOEAAADhCAYAAAA+s9J6AABa2UlEQVR4Xu1dBVwVWRcfBGkQA1GxEBHFwMLAwu4OzFV0rTXWXnH9Vtw11661du3ubl0sMLEwUVHAQAXpRr7/f3zDPpF4WKvLvb/fg/dmbp65Z865JyVJFAEBAQEBAQEBAQEBAQEBAQEBAQEBAQEBAQEBAQEBAQEBAQEBAQEBAQEBAQEBAQEBAQEBAQEBAQGBbwoCe64fcf6mJiw'),
(6, 'iVBORw0KGgoAAAANSUhEUgAAAOEAAADhCAMAAAAJbSJIAAAAolBMVEX///8bhzrj7+ay0rqnzLCmx60yk03t9vAAdQDA2sdhpnJAl1dbo20AgyrG3sx4sYb3+/hrq3seij7R5NZLml/p8+zb6t8AhDDW6tyQvpuHupMAfiIAfBu007zy+PSZw6NoqXiAtYw6k1FSnmUsjkefx6kAeRAmj0UAeADK3c4AcQCNv5qgy6yEtY+oyK9UnGV7t4tlrHi'),
(6, 'iVBORw0KGgoAAAANSUhEUgAAAOEAAADhCAYAAAA+s9J6AABa2UlEQVR4Xu1dBVwVWRcfBGkQA1GxEBHFwMLAwu4OzFV0rTXWXnH9Vtw11661du3ubl0sMLEwUVHAQAXpRr7/f3zDPpF4WKvLvb/fg/dmbp65Z865JyVJFAEBAQEBAQEBAQEBAQEBAQEBAQEBAQEBAQEBAQEBAQEBAQEBAQEBAQEBAQEBAQEBAQEBAQEBAQGBbwoCe64fcf6mJiw'),
(6, 'iVBORw0KGgoAAAANSUhEUgAAAOEAAADhCAYAAAA+s9J6AABa2UlEQVR4Xu1dBVwVWRcfBGkQA1GxEBHFwMLAwu4OzFV0rTXWXnH9Vtw11661du3ubl0sMLEwUVHAQAXpRr7/f3zDPpF4WKvLvb/fg/dmbp65Z865JyVJFAEBAQEBAQEBAQEBAQEBAQEBAQEBAQEBAQEBAQEBAQEBAQEBAQEBAQEBAQEBAQEBAQEBAQEBAQGBbwoCe64fcf6mJiw'),
(6, 'iVBORw0KGgoAAAANSUhEUgAAAOEAAADhCAYAAAA+s9J6AABa2UlEQVR4Xu1dBVwVWRcfBGkQA1GxEBHFwMLAwu4OzFV0rTXWXnH9Vtw11661du3ubl0sMLEwUVHAQAXpRr7/f3zDPpF4WKvLvb/fg/dmbp65Z865JyVJFAEBAQEBAQEBAQEBAQEBAQEBAQEBAQEBAQEBAQEBAQEBAQEBAQEBAQEBAQEBAQEBAQEBAQEBAQGBbwoCe64fcf6mJiw'),
(7, 'iVBORw0KGgoAAAANSUhEUgAAAOEAAADhCAMAAAAJbSJIAAAAolBMVEX///8bhzrj7+ay0rqnzLCmx60yk03t9vAAdQDA2sdhpnJAl1dbo20AgyrG3sx4sYb3+/hrq3seij7R5NZLml/p8+zb6t8AhDDW6tyQvpuHupMAfiIAfBu007zy+PSZw6NoqXiAtYw6k1FSnmUsjkefx6kAeRAmj0UAeADK3c4AcQCNv5qgy6yEtY+oyK9UnGV7t4tlrHi'),
(7, 'iVBORw0KGgoAAAANSUhEUgAAAOEAAADhCAYAAAA+s9J6AABa2UlEQVR4Xu1dBVwVWRcfBGkQA1GxEBHFwMLAwu4OzFV0rTXWXnH9Vtw11661du3ubl0sMLEwUVHAQAXpRr7/f3zDPpF4WKvLvb/fg/dmbp65Z865JyVJFAEBAQEBAQEBAQEBAQEBAQEBAQEBAQEBAQEBAQEBAQEBAQEBAQEBAQEBAQEBAQEBAQEBAQEBAQGBbwoCe64fcf6mJiw'),
(7, 'iVBORw0KGgoAAAANSUhEUgAAAOEAAADhCAMAAAAJbSJIAAAAolBMVEX///8bhzrj7+ay0rqnzLCmx60yk03t9vAAdQDA2sdhpnJAl1dbo20AgyrG3sx4sYb3+/hrq3seij7R5NZLml/p8+zb6t8AhDDW6tyQvpuHupMAfiIAfBu007zy+PSZw6NoqXiAtYw6k1FSnmUsjkefx6kAeRAmj0UAeADK3c4AcQCNv5qgy6yEtY+oyK9UnGV7t4tlrHi'),
(7, 'iVBORw0KGgoAAAANSUhEUgAAAOEAAADhCAYAAAA+s9J6AABa2UlEQVR4Xu1dBVwVWRcfBGkQA1GxEBHFwMLAwu4OzFV0rTXWXnH9Vtw11661du3ubl0sMLEwUVHAQAXpRr7/f3zDPpF4WKvLvb/fg/dmbp65Z865JyVJFAEBAQEBAQEBAQEBAQEBAQEBAQEBAQEBAQEBAQEBAQEBAQEBAQEBAQEBAQEBAQEBAQEBAQEBAQGBbwoCe64fcf6mJiw'),
(7, 'iVBORw0KGgoAAAANSUhEUgAAAOEAAADhCAYAAAA+s9J6AABa2UlEQVR4Xu1dBVwVWRcfBGkQA1GxEBHFwMLAwu4OzFV0rTXWXnH9Vtw11661du3ubl0sMLEwUVHAQAXpRr7/f3zDPpF4WKvLvb/fg/dmbp65Z865JyVJFAEBAQEBAQEBAQEBAQEBAQEBAQEBAQEBAQEBAQEBAQEBAQEBAQEBAQEBAQEBAQEBAQEBAQEBAQGBbwoCe64fcf6mJiw'),
(7, 'iVBORw0KGgoAAAANSUhEUgAAAOEAAADhCAYAAAA+s9J6AABa2UlEQVR4Xu1dBVwVWRcfBGkQA1GxEBHFwMLAwu4OzFV0rTXWXnH9Vtw11661du3ubl0sMLEwUVHAQAXpRr7/f3zDPpF4WKvLvb/fg/dmbp65Z865JyVJFAEBAQEBAQEBAQEBAQEBAQEBAQEBAQEBAQEBAQEBAQEBAQEBAQEBAQEBAQEBAQEBAQEBAQEBAQGBbwoCe64fcf6mJiw'),
(8, '6475dd2575cfd.jpg'),
(8, '6475dd2577c91.jpg'),
(8, '6475dd2579b77.jpg'),
(8, '6475dd257b0fe.jpg'),
(8, '6475dd257c10c.jpg'),
(8, '6475dd257f46f.jpg'),
(9, 'fotos-noticias/6475de734a62c.jpg'),
(9, 'fotos-noticias/6475de734b2c1.jpg'),
(9, 'fotos-noticias/6475de734bfb7.jpg'),
(9, 'fotos-noticias/6475de734cf44.jpg'),
(9, 'fotos-noticias/6475de734ea73.jpg'),
(9, 'fotos-noticias/6475de7350b24.jpg'),
(10, 'fotos-noticias/6475dea809c4e.jpg'),
(10, 'fotos-noticias/6475dea80bbdb.jpg'),
(10, 'fotos-noticias/6475dea80e163.jpg'),
(10, 'fotos-noticias/6475dea80f0e6.jpg'),
(10, 'fotos-noticias/6475dea811e9e.jpg'),
(10, 'fotos-noticias/6475dea814046.jpg'),
(11, '6475deeb1da4e.jpg'),
(11, '6475deeb1fa2e.jpg'),
(11, '6475deeb22228.jpg'),
(11, '6475deeb240fb.jpg'),
(11, '6475deeb25ec3.jpg'),
(11, '6475deeb271bc.jpg'),
(12, 'fotos-noticias/6475df0469c9e.jpg'),
(12, 'fotos-noticias/6475df046b852.jpg'),
(12, 'fotos-noticias/6475df046d2af.jpg'),
(12, 'fotos-noticias/6475df046f17e.jpg'),
(12, 'fotos-noticias/6475df0470cab.jpg'),
(12, 'fotos-noticias/6475df047214c.jpg'),
(13, 'fotos-noticias/6475df0644dd8.jpg'),
(13, 'fotos-noticias/6475df06468ac.jpg'),
(13, 'fotos-noticias/6475df0647741.jpg'),
(13, 'fotos-noticias/6475df0648512.jpg'),
(13, 'fotos-noticias/6475df064acd2.jpg'),
(13, 'fotos-noticias/6475df064bf73.jpg'),
(14, 'noticias-fotos/6475e0d9d0a47.jpg'),
(14, 'noticias-fotos/6475e0d9d2e0b.jpg'),
(14, 'noticias-fotos/6475e0d9d5939.jpg'),
(14, 'noticias-fotos/6475e0d9d79de.jpg'),
(14, 'noticias-fotos/6475e0d9d9d93.jpg'),
(14, 'noticias-fotos/6475e0d9dba80.jpg'),
(15, 'noticias-fotos/6475e0da76fbe.jpg'),
(15, 'noticias-fotos/6475e0da78b75.jpg'),
(15, 'noticias-fotos/6475e0da7a626.jpg'),
(15, 'noticias-fotos/6475e0da7cf7e.jpg'),
(15, 'noticias-fotos/6475e0da7f092.jpg'),
(15, 'noticias-fotos/6475e0da80dc4.jpg'),
(16, 'noticias-fotos/6475e0db0554d.jpg'),
(16, 'noticias-fotos/6475e0db07488.jpg'),
(16, 'noticias-fotos/6475e0db09b9d.jpg'),
(16, 'noticias-fotos/6475e0db0b8fa.jpg'),
(16, 'noticias-fotos/6475e0db0d6c9.jpg'),
(16, 'noticias-fotos/6475e0db0f81d.jpg'),
(17, 'noticias-fotos/6476079a63c36.jpg'),
(17, 'noticias-fotos/6476079a64db7.jpg'),
(17, 'noticias-fotos/6476079a65d5a.jpg'),
(18, 'noticias-fotos/647607aa1a140.jpg'),
(18, 'noticias-fotos/647607aa1b383.jpg'),
(18, 'noticias-fotos/647607aa1c6ae.jpg'),
(19, 'noticias-fotos/647607ab68540.jpg'),
(19, 'noticias-fotos/647607ab6a2ba.jpg'),
(19, 'noticias-fotos/647607ab6b635.jpg'),
(20, 'noticias-fotos/647607ac2d369.jpg'),
(20, 'noticias-fotos/647607ac2edac.jpg'),
(20, 'noticias-fotos/647607ac320f4.jpg'),
(21, 'noticias-fotos/647609e52d773.jpg'),
(22, 'noticias-fotos/64760baaf0b8e.jpg'),
(23, 'noticias-fotos/64760bd4e14d7.jpg'),
(24, 'noticias-fotos/64760bd53cfec.jpg'),
(25, 'noticias-fotos/64760bd566234.jpg'),
(26, 'noticias-fotos/64760bd58ca11.jpg'),
(27, 'noticias-fotos/64760bd5b42a0.jpg'),
(28, 'noticias-fotos/64760bd5dacf2.jpg'),
(29, 'noticias-fotos/64760bd6045de.jpg'),
(30, 'noticias-fotos/64760bd632a8a.jpg'),
(31, 'noticias-fotos/64760bd653691.jpg'),
(32, 'noticias-fotos/64760bd67b674.jpg'),
(33, 'noticias-fotos/6476149b12a65.jpg'),
(33, 'noticias-fotos/6476149b13ba8.jpg'),
(33, 'noticias-fotos/6476149b15013.jpg'),
(34, 'noticias-fotos/6479eea1bb684.jpg'),
(35, 'noticias-fotos/6479f02beba84.jpg'),
(36, 'noticias-fotos/6479f04c8c1d9.jpg'),
(37, 'noticias-fotos/6479f467ede32.jpg'),
(37, 'noticias-fotos/6479f467ef39e.jpg'),
(37, 'noticias-fotos/6479f467f076f.jpg'),
(37, 'noticias-fotos/6479f467f1d19.jpg'),
(37, 'noticias-fotos/6479f467f325a.jpg'),
(37, 'noticias-fotos/6479f4680067a.jpg'),
(38, 'noticias-fotos/6479f573332f3.jpg'),
(38, 'noticias-fotos/6479f57334fe4.jpg'),
(38, 'noticias-fotos/6479f5733666b.jpg'),
(38, 'noticias-fotos/6479f5733828f.jpg'),
(38, 'noticias-fotos/6479f573398ba.jpg'),
(38, 'noticias-fotos/6479f5733cc11.jpg'),
(39, 'noticias-fotos/6479f63b43841.jpg'),
(5, 'iVBORw0KGgoAAAANSUhEUgAAAOEAAADhCAMAAAAJbSJIAAAAolBMVEX///8bhzrj7+ay0rqnzLCmx60yk03t9vAAdQDA2sdhpnJAl1dbo20AgyrG3sx4sYb3+/hrq3seij7R5NZLml/p8+zb6t8AhDDW6tyQvpuHupMAfiIAfBu007zy+PSZw6NoqXiAtYw6k1FSnmUsjkefx6kAeRAmj0UAeADK3c4AcQCNv5qgy6yEtY+oyK9UnGV7t4tlrHi'),
(5, 'iVBORw0KGgoAAAANSUhEUgAAAOEAAADhCAYAAAA+s9J6AABa2UlEQVR4Xu1dBVwVWRcfBGkQA1GxEBHFwMLAwu4OzFV0rTXWXnH9Vtw11661du3ubl0sMLEwUVHAQAXpRr7/f3zDPpF4WKvLvb/fg/dmbp65Z865JyVJFAEBAQEBAQEBAQEBAQEBAQEBAQEBAQEBAQEBAQEBAQEBAQEBAQEBAQEBAQEBAQEBAQEBAQEBAQGBbwoCe64fcf6mJiw'),
(5, 'iVBORw0KGgoAAAANSUhEUgAAAOEAAADhCAMAAAAJbSJIAAAAolBMVEX///8bhzrj7+ay0rqnzLCmx60yk03t9vAAdQDA2sdhpnJAl1dbo20AgyrG3sx4sYb3+/hrq3seij7R5NZLml/p8+zb6t8AhDDW6tyQvpuHupMAfiIAfBu007zy+PSZw6NoqXiAtYw6k1FSnmUsjkefx6kAeRAmj0UAeADK3c4AcQCNv5qgy6yEtY+oyK9UnGV7t4tlrHi'),
(5, 'iVBORw0KGgoAAAANSUhEUgAAAOEAAADhCAYAAAA+s9J6AABa2UlEQVR4Xu1dBVwVWRcfBGkQA1GxEBHFwMLAwu4OzFV0rTXWXnH9Vtw11661du3ubl0sMLEwUVHAQAXpRr7/f3zDPpF4WKvLvb/fg/dmbp65Z865JyVJFAEBAQEBAQEBAQEBAQEBAQEBAQEBAQEBAQEBAQEBAQEBAQEBAQEBAQEBAQEBAQEBAQEBAQEBAQGBbwoCe64fcf6mJiw'),
(5, 'iVBORw0KGgoAAAANSUhEUgAAAOEAAADhCAYAAAA+s9J6AABa2UlEQVR4Xu1dBVwVWRcfBGkQA1GxEBHFwMLAwu4OzFV0rTXWXnH9Vtw11661du3ubl0sMLEwUVHAQAXpRr7/f3zDPpF4WKvLvb/fg/dmbp65Z865JyVJFAEBAQEBAQEBAQEBAQEBAQEBAQEBAQEBAQEBAQEBAQEBAQEBAQEBAQEBAQEBAQEBAQEBAQEBAQGBbwoCe64fcf6mJiw'),
(5, 'iVBORw0KGgoAAAANSUhEUgAAAOEAAADhCAYAAAA+s9J6AABa2UlEQVR4Xu1dBVwVWRcfBGkQA1GxEBHFwMLAwu4OzFV0rTXWXnH9Vtw11661du3ubl0sMLEwUVHAQAXpRr7/f3zDPpF4WKvLvb/fg/dmbp65Z865JyVJFAEBAQEBAQEBAQEBAQEBAQEBAQEBAQEBAQEBAQEBAQEBAQEBAQEBAQEBAQEBAQEBAQEBAQEBAQGBbwoCe64fcf6mJiw'),
(6, 'iVBORw0KGgoAAAANSUhEUgAAAOEAAADhCAMAAAAJbSJIAAAAolBMVEX///8bhzrj7+ay0rqnzLCmx60yk03t9vAAdQDA2sdhpnJAl1dbo20AgyrG3sx4sYb3+/hrq3seij7R5NZLml/p8+zb6t8AhDDW6tyQvpuHupMAfiIAfBu007zy+PSZw6NoqXiAtYw6k1FSnmUsjkefx6kAeRAmj0UAeADK3c4AcQCNv5qgy6yEtY+oyK9UnGV7t4tlrHi'),
(6, 'iVBORw0KGgoAAAANSUhEUgAAAOEAAADhCAYAAAA+s9J6AABa2UlEQVR4Xu1dBVwVWRcfBGkQA1GxEBHFwMLAwu4OzFV0rTXWXnH9Vtw11661du3ubl0sMLEwUVHAQAXpRr7/f3zDPpF4WKvLvb/fg/dmbp65Z865JyVJFAEBAQEBAQEBAQEBAQEBAQEBAQEBAQEBAQEBAQEBAQEBAQEBAQEBAQEBAQEBAQEBAQEBAQEBAQGBbwoCe64fcf6mJiw'),
(6, 'iVBORw0KGgoAAAANSUhEUgAAAOEAAADhCAMAAAAJbSJIAAAAolBMVEX///8bhzrj7+ay0rqnzLCmx60yk03t9vAAdQDA2sdhpnJAl1dbo20AgyrG3sx4sYb3+/hrq3seij7R5NZLml/p8+zb6t8AhDDW6tyQvpuHupMAfiIAfBu007zy+PSZw6NoqXiAtYw6k1FSnmUsjkefx6kAeRAmj0UAeADK3c4AcQCNv5qgy6yEtY+oyK9UnGV7t4tlrHi'),
(6, 'iVBORw0KGgoAAAANSUhEUgAAAOEAAADhCAYAAAA+s9J6AABa2UlEQVR4Xu1dBVwVWRcfBGkQA1GxEBHFwMLAwu4OzFV0rTXWXnH9Vtw11661du3ubl0sMLEwUVHAQAXpRr7/f3zDPpF4WKvLvb/fg/dmbp65Z865JyVJFAEBAQEBAQEBAQEBAQEBAQEBAQEBAQEBAQEBAQEBAQEBAQEBAQEBAQEBAQEBAQEBAQEBAQEBAQGBbwoCe64fcf6mJiw'),
(6, 'iVBORw0KGgoAAAANSUhEUgAAAOEAAADhCAYAAAA+s9J6AABa2UlEQVR4Xu1dBVwVWRcfBGkQA1GxEBHFwMLAwu4OzFV0rTXWXnH9Vtw11661du3ubl0sMLEwUVHAQAXpRr7/f3zDPpF4WKvLvb/fg/dmbp65Z865JyVJFAEBAQEBAQEBAQEBAQEBAQEBAQEBAQEBAQEBAQEBAQEBAQEBAQEBAQEBAQEBAQEBAQEBAQEBAQGBbwoCe64fcf6mJiw'),
(6, 'iVBORw0KGgoAAAANSUhEUgAAAOEAAADhCAYAAAA+s9J6AABa2UlEQVR4Xu1dBVwVWRcfBGkQA1GxEBHFwMLAwu4OzFV0rTXWXnH9Vtw11661du3ubl0sMLEwUVHAQAXpRr7/f3zDPpF4WKvLvb/fg/dmbp65Z865JyVJFAEBAQEBAQEBAQEBAQEBAQEBAQEBAQEBAQEBAQEBAQEBAQEBAQEBAQEBAQEBAQEBAQEBAQEBAQGBbwoCe64fcf6mJiw'),
(7, 'iVBORw0KGgoAAAANSUhEUgAAAOEAAADhCAMAAAAJbSJIAAAAolBMVEX///8bhzrj7+ay0rqnzLCmx60yk03t9vAAdQDA2sdhpnJAl1dbo20AgyrG3sx4sYb3+/hrq3seij7R5NZLml/p8+zb6t8AhDDW6tyQvpuHupMAfiIAfBu007zy+PSZw6NoqXiAtYw6k1FSnmUsjkefx6kAeRAmj0UAeADK3c4AcQCNv5qgy6yEtY+oyK9UnGV7t4tlrHi'),
(7, 'iVBORw0KGgoAAAANSUhEUgAAAOEAAADhCAYAAAA+s9J6AABa2UlEQVR4Xu1dBVwVWRcfBGkQA1GxEBHFwMLAwu4OzFV0rTXWXnH9Vtw11661du3ubl0sMLEwUVHAQAXpRr7/f3zDPpF4WKvLvb/fg/dmbp65Z865JyVJFAEBAQEBAQEBAQEBAQEBAQEBAQEBAQEBAQEBAQEBAQEBAQEBAQEBAQEBAQEBAQEBAQEBAQEBAQGBbwoCe64fcf6mJiw'),
(7, 'iVBORw0KGgoAAAANSUhEUgAAAOEAAADhCAMAAAAJbSJIAAAAolBMVEX///8bhzrj7+ay0rqnzLCmx60yk03t9vAAdQDA2sdhpnJAl1dbo20AgyrG3sx4sYb3+/hrq3seij7R5NZLml/p8+zb6t8AhDDW6tyQvpuHupMAfiIAfBu007zy+PSZw6NoqXiAtYw6k1FSnmUsjkefx6kAeRAmj0UAeADK3c4AcQCNv5qgy6yEtY+oyK9UnGV7t4tlrHi'),
(7, 'iVBORw0KGgoAAAANSUhEUgAAAOEAAADhCAYAAAA+s9J6AABa2UlEQVR4Xu1dBVwVWRcfBGkQA1GxEBHFwMLAwu4OzFV0rTXWXnH9Vtw11661du3ubl0sMLEwUVHAQAXpRr7/f3zDPpF4WKvLvb/fg/dmbp65Z865JyVJFAEBAQEBAQEBAQEBAQEBAQEBAQEBAQEBAQEBAQEBAQEBAQEBAQEBAQEBAQEBAQEBAQEBAQEBAQGBbwoCe64fcf6mJiw'),
(7, 'iVBORw0KGgoAAAANSUhEUgAAAOEAAADhCAYAAAA+s9J6AABa2UlEQVR4Xu1dBVwVWRcfBGkQA1GxEBHFwMLAwu4OzFV0rTXWXnH9Vtw11661du3ubl0sMLEwUVHAQAXpRr7/f3zDPpF4WKvLvb/fg/dmbp65Z865JyVJFAEBAQEBAQEBAQEBAQEBAQEBAQEBAQEBAQEBAQEBAQEBAQEBAQEBAQEBAQEBAQEBAQEBAQEBAQGBbwoCe64fcf6mJiw'),
(7, 'iVBORw0KGgoAAAANSUhEUgAAAOEAAADhCAYAAAA+s9J6AABa2UlEQVR4Xu1dBVwVWRcfBGkQA1GxEBHFwMLAwu4OzFV0rTXWXnH9Vtw11661du3ubl0sMLEwUVHAQAXpRr7/f3zDPpF4WKvLvb/fg/dmbp65Z865JyVJFAEBAQEBAQEBAQEBAQEBAQEBAQEBAQEBAQEBAQEBAQEBAQEBAQEBAQEBAQEBAQEBAQEBAQEBAQGBbwoCe64fcf6mJiw'),
(8, '6475dd2575cfd.jpg'),
(8, '6475dd2577c91.jpg'),
(8, '6475dd2579b77.jpg'),
(8, '6475dd257b0fe.jpg'),
(8, '6475dd257c10c.jpg'),
(8, '6475dd257f46f.jpg'),
(9, 'fotos-noticias/6475de734a62c.jpg'),
(9, 'fotos-noticias/6475de734b2c1.jpg'),
(9, 'fotos-noticias/6475de734bfb7.jpg'),
(9, 'fotos-noticias/6475de734cf44.jpg'),
(9, 'fotos-noticias/6475de734ea73.jpg'),
(9, 'fotos-noticias/6475de7350b24.jpg'),
(10, 'fotos-noticias/6475dea809c4e.jpg'),
(10, 'fotos-noticias/6475dea80bbdb.jpg'),
(10, 'fotos-noticias/6475dea80e163.jpg'),
(10, 'fotos-noticias/6475dea80f0e6.jpg'),
(10, 'fotos-noticias/6475dea811e9e.jpg'),
(10, 'fotos-noticias/6475dea814046.jpg'),
(11, '6475deeb1da4e.jpg'),
(11, '6475deeb1fa2e.jpg'),
(11, '6475deeb22228.jpg'),
(11, '6475deeb240fb.jpg'),
(11, '6475deeb25ec3.jpg'),
(11, '6475deeb271bc.jpg'),
(12, 'fotos-noticias/6475df0469c9e.jpg'),
(12, 'fotos-noticias/6475df046b852.jpg'),
(12, 'fotos-noticias/6475df046d2af.jpg'),
(12, 'fotos-noticias/6475df046f17e.jpg'),
(12, 'fotos-noticias/6475df0470cab.jpg'),
(12, 'fotos-noticias/6475df047214c.jpg'),
(13, 'fotos-noticias/6475df0644dd8.jpg'),
(13, 'fotos-noticias/6475df06468ac.jpg'),
(13, 'fotos-noticias/6475df0647741.jpg'),
(13, 'fotos-noticias/6475df0648512.jpg'),
(13, 'fotos-noticias/6475df064acd2.jpg'),
(13, 'fotos-noticias/6475df064bf73.jpg'),
(14, 'noticias-fotos/6475e0d9d0a47.jpg'),
(14, 'noticias-fotos/6475e0d9d2e0b.jpg'),
(14, 'noticias-fotos/6475e0d9d5939.jpg'),
(14, 'noticias-fotos/6475e0d9d79de.jpg'),
(14, 'noticias-fotos/6475e0d9d9d93.jpg'),
(14, 'noticias-fotos/6475e0d9dba80.jpg'),
(15, 'noticias-fotos/6475e0da76fbe.jpg'),
(15, 'noticias-fotos/6475e0da78b75.jpg'),
(15, 'noticias-fotos/6475e0da7a626.jpg'),
(15, 'noticias-fotos/6475e0da7cf7e.jpg'),
(15, 'noticias-fotos/6475e0da7f092.jpg'),
(15, 'noticias-fotos/6475e0da80dc4.jpg'),
(16, 'noticias-fotos/6475e0db0554d.jpg'),
(16, 'noticias-fotos/6475e0db07488.jpg'),
(16, 'noticias-fotos/6475e0db09b9d.jpg'),
(16, 'noticias-fotos/6475e0db0b8fa.jpg'),
(16, 'noticias-fotos/6475e0db0d6c9.jpg'),
(16, 'noticias-fotos/6475e0db0f81d.jpg'),
(17, 'noticias-fotos/6476079a63c36.jpg'),
(17, 'noticias-fotos/6476079a64db7.jpg'),
(17, 'noticias-fotos/6476079a65d5a.jpg'),
(18, 'noticias-fotos/647607aa1a140.jpg'),
(18, 'noticias-fotos/647607aa1b383.jpg'),
(18, 'noticias-fotos/647607aa1c6ae.jpg'),
(19, 'noticias-fotos/647607ab68540.jpg'),
(19, 'noticias-fotos/647607ab6a2ba.jpg'),
(19, 'noticias-fotos/647607ab6b635.jpg'),
(20, 'noticias-fotos/647607ac2d369.jpg'),
(20, 'noticias-fotos/647607ac2edac.jpg'),
(20, 'noticias-fotos/647607ac320f4.jpg'),
(21, 'noticias-fotos/647609e52d773.jpg'),
(22, 'noticias-fotos/64760baaf0b8e.jpg'),
(23, 'noticias-fotos/64760bd4e14d7.jpg'),
(24, 'noticias-fotos/64760bd53cfec.jpg'),
(25, 'noticias-fotos/64760bd566234.jpg'),
(26, 'noticias-fotos/64760bd58ca11.jpg'),
(27, 'noticias-fotos/64760bd5b42a0.jpg'),
(28, 'noticias-fotos/64760bd5dacf2.jpg'),
(29, 'noticias-fotos/64760bd6045de.jpg'),
(30, 'noticias-fotos/64760bd632a8a.jpg'),
(31, 'noticias-fotos/64760bd653691.jpg'),
(32, 'noticias-fotos/64760bd67b674.jpg'),
(33, 'noticias-fotos/6476149b12a65.jpg'),
(33, 'noticias-fotos/6476149b13ba8.jpg'),
(33, 'noticias-fotos/6476149b15013.jpg'),
(34, 'noticias-fotos/6479eea1bb684.jpg'),
(35, 'noticias-fotos/6479f02beba84.jpg'),
(36, 'noticias-fotos/6479f04c8c1d9.jpg'),
(37, 'noticias-fotos/6479f467ede32.jpg'),
(37, 'noticias-fotos/6479f467ef39e.jpg'),
(37, 'noticias-fotos/6479f467f076f.jpg'),
(37, 'noticias-fotos/6479f467f1d19.jpg'),
(37, 'noticias-fotos/6479f467f325a.jpg'),
(37, 'noticias-fotos/6479f4680067a.jpg'),
(38, 'noticias-fotos/6479f573332f3.jpg'),
(38, 'noticias-fotos/6479f57334fe4.jpg'),
(38, 'noticias-fotos/6479f5733666b.jpg'),
(38, 'noticias-fotos/6479f5733828f.jpg'),
(38, 'noticias-fotos/6479f573398ba.jpg'),
(38, 'noticias-fotos/6479f5733cc11.jpg'),
(39, 'noticias-fotos/6479f63b43841.jpg'),
(40, 'noticias-fotos/65c9187a52876.jpg'),
(40, 'noticias-fotos/65c9187a52d9d.jpg'),
(40, 'noticias-fotos/65c9187a5317b.jpg'),
(41, 'noticias-fotos/65c918ce1d81f.jpg'),
(41, 'noticias-fotos/65c918ce1dc5d.jpg'),
(41, 'noticias-fotos/65c918ce1e08d.jpg'),
(42, 'noticias-fotos/65c918ee26549.jpg'),
(43, 'noticias-fotos/65c92c9ab1dde.jpg'),
(43, 'noticias-fotos/65c92c9ab2340.jpg'),
(43, 'noticias-fotos/65c92c9ab2772.jpg'),
(38, 'noticias-fotos/65c934d468645.png'),
(44, 'noticias-fotos/65f2d6031350d.jpg'),
(44, 'noticias-fotos/65f2d60313953.jpg'),
(44, 'noticias-fotos/65f2d60313cde.jpg'),
(44, 'noticias-fotos/65f2d60314022.jpg'),
(45, 'noticias-fotos/65f2d64b841a0.jpg'),
(45, 'noticias-fotos/65f2d64b84751.jpg'),
(45, 'noticias-fotos/65f2d64b84bc0.jpg'),
(45, 'noticias-fotos/65f2d64b85018.jpg'),
(45, 'noticias-fotos/65f2d64b854a2.jpg'),
(45, 'noticias-fotos/65f2d64b85954.jpg'),
(45, 'noticias-fotos/65f2d64b85db6.jpg'),
(45, 'noticias-fotos/65f2d64b862f0.jpg'),
(46, 'noticias-fotos/65f2d6d3cbd5b.jpg'),
(47, 'noticias-fotos/664340928178f.jpg'),
(48, 'noticias-fotos/664343d13e6cc.jpg'),
(49, 'noticias-fotos/6643440ecc3ed.jpg'),
(50, 'noticias-fotos/664344f2d0cb2.jpg'),
(51, 'noticias-fotos/6643457168b22.jpg'),
(52, 'noticias-fotos/66434584b60d5.jpg'),
(53, 'noticias-fotos/6643463d83f56.jpg'),
(54, 'noticias-fotos/664347082d3c3.jpg'),
(55, 'noticias-fotos/664347c207316.jpg'),
(56, 'noticias-fotos/664347d90d31c.jpg'),
(57, 'noticias-fotos/66434823e76a7.jpg'),
(58, 'noticias-fotos/664348309f9ea.jpg'),
(59, 'noticias-fotos/6643485bef776.jpg'),
(60, 'noticias-fotos/66434991f1729.jpg'),
(61, 'noticias-fotos/66434aa6f31f3.jpg'),
(62, 'noticias-fotos/66434b35cdf8f.jpg'),
(63, 'noticias-fotos/66434b6285251.jpg'),
(64, 'noticias-fotos/66434bb6e337c.jpg'),
(65, 'noticias-fotos/66434cc77fb2a.jpg'),
(66, 'noticias-fotos/66434d6f9a9b3.jpg'),
(67, 'noticias-fotos/66434eea9174a.jpg'),
(68, 'noticias-fotos/66434f24ceb80.jpg'),
(69, 'noticias-fotos/6644cf9504584.jpg'),
(69, 'noticias-fotos/6644cf9504a90.jpg'),
(69, 'noticias-fotos/6644cf9504e2d.jpg'),
(69, 'noticias-fotos/6644cf95051e7.jpg'),
(69, 'noticias-fotos/6644cf9505542.jpg'),
(70, 'noticias-fotos/6644d0741fdb9.jpg'),
(71, 'noticias-fotos/6644d10366ac5.jpg'),
(71, 'noticias-fotos/6644d10367190.jpg'),
(72, 'noticias-fotos/6644d16191722.jpg'),
(73, 'noticias-fotos/6644d1d037a2f.jpg'),
(74, 'noticias-fotos/6644d2023baa7.jpg'),
(70, 'noticias-fotos/664a7805edae6.jpg'),
(5, 'iVBORw0KGgoAAAANSUhEUgAAAOEAAADhCAMAAAAJbSJIAAAAolBMVEX///8bhzrj7+ay0rqnzLCmx60yk03t9vAAdQDA2sdhpnJAl1dbo20AgyrG3sx4sYb3+/hrq3seij7R5NZLml/p8+zb6t8AhDDW6tyQvpuHupMAfiIAfBu007zy+PSZw6NoqXiAtYw6k1FSnmUsjkefx6kAeRAmj0UAeADK3c4AcQCNv5qgy6yEtY+oyK9UnGV7t4tlrHi'),
(5, 'iVBORw0KGgoAAAANSUhEUgAAAOEAAADhCAYAAAA+s9J6AABa2UlEQVR4Xu1dBVwVWRcfBGkQA1GxEBHFwMLAwu4OzFV0rTXWXnH9Vtw11661du3ubl0sMLEwUVHAQAXpRr7/f3zDPpF4WKvLvb/fg/dmbp65Z865JyVJFAEBAQEBAQEBAQEBAQEBAQEBAQEBAQEBAQEBAQEBAQEBAQEBAQEBAQEBAQEBAQEBAQEBAQEBAQGBbwoCe64fcf6mJiw'),
(5, 'iVBORw0KGgoAAAANSUhEUgAAAOEAAADhCAMAAAAJbSJIAAAAolBMVEX///8bhzrj7+ay0rqnzLCmx60yk03t9vAAdQDA2sdhpnJAl1dbo20AgyrG3sx4sYb3+/hrq3seij7R5NZLml/p8+zb6t8AhDDW6tyQvpuHupMAfiIAfBu007zy+PSZw6NoqXiAtYw6k1FSnmUsjkefx6kAeRAmj0UAeADK3c4AcQCNv5qgy6yEtY+oyK9UnGV7t4tlrHi'),
(5, 'iVBORw0KGgoAAAANSUhEUgAAAOEAAADhCAYAAAA+s9J6AABa2UlEQVR4Xu1dBVwVWRcfBGkQA1GxEBHFwMLAwu4OzFV0rTXWXnH9Vtw11661du3ubl0sMLEwUVHAQAXpRr7/f3zDPpF4WKvLvb/fg/dmbp65Z865JyVJFAEBAQEBAQEBAQEBAQEBAQEBAQEBAQEBAQEBAQEBAQEBAQEBAQEBAQEBAQEBAQEBAQEBAQEBAQGBbwoCe64fcf6mJiw'),
(5, 'iVBORw0KGgoAAAANSUhEUgAAAOEAAADhCAYAAAA+s9J6AABa2UlEQVR4Xu1dBVwVWRcfBGkQA1GxEBHFwMLAwu4OzFV0rTXWXnH9Vtw11661du3ubl0sMLEwUVHAQAXpRr7/f3zDPpF4WKvLvb/fg/dmbp65Z865JyVJFAEBAQEBAQEBAQEBAQEBAQEBAQEBAQEBAQEBAQEBAQEBAQEBAQEBAQEBAQEBAQEBAQEBAQEBAQGBbwoCe64fcf6mJiw'),
(5, 'iVBORw0KGgoAAAANSUhEUgAAAOEAAADhCAYAAAA+s9J6AABa2UlEQVR4Xu1dBVwVWRcfBGkQA1GxEBHFwMLAwu4OzFV0rTXWXnH9Vtw11661du3ubl0sMLEwUVHAQAXpRr7/f3zDPpF4WKvLvb/fg/dmbp65Z865JyVJFAEBAQEBAQEBAQEBAQEBAQEBAQEBAQEBAQEBAQEBAQEBAQEBAQEBAQEBAQEBAQEBAQEBAQEBAQGBbwoCe64fcf6mJiw'),
(6, 'iVBORw0KGgoAAAANSUhEUgAAAOEAAADhCAMAAAAJbSJIAAAAolBMVEX///8bhzrj7+ay0rqnzLCmx60yk03t9vAAdQDA2sdhpnJAl1dbo20AgyrG3sx4sYb3+/hrq3seij7R5NZLml/p8+zb6t8AhDDW6tyQvpuHupMAfiIAfBu007zy+PSZw6NoqXiAtYw6k1FSnmUsjkefx6kAeRAmj0UAeADK3c4AcQCNv5qgy6yEtY+oyK9UnGV7t4tlrHi'),
(6, 'iVBORw0KGgoAAAANSUhEUgAAAOEAAADhCAYAAAA+s9J6AABa2UlEQVR4Xu1dBVwVWRcfBGkQA1GxEBHFwMLAwu4OzFV0rTXWXnH9Vtw11661du3ubl0sMLEwUVHAQAXpRr7/f3zDPpF4WKvLvb/fg/dmbp65Z865JyVJFAEBAQEBAQEBAQEBAQEBAQEBAQEBAQEBAQEBAQEBAQEBAQEBAQEBAQEBAQEBAQEBAQEBAQEBAQGBbwoCe64fcf6mJiw'),
(6, 'iVBORw0KGgoAAAANSUhEUgAAAOEAAADhCAMAAAAJbSJIAAAAolBMVEX///8bhzrj7+ay0rqnzLCmx60yk03t9vAAdQDA2sdhpnJAl1dbo20AgyrG3sx4sYb3+/hrq3seij7R5NZLml/p8+zb6t8AhDDW6tyQvpuHupMAfiIAfBu007zy+PSZw6NoqXiAtYw6k1FSnmUsjkefx6kAeRAmj0UAeADK3c4AcQCNv5qgy6yEtY+oyK9UnGV7t4tlrHi'),
(6, 'iVBORw0KGgoAAAANSUhEUgAAAOEAAADhCAYAAAA+s9J6AABa2UlEQVR4Xu1dBVwVWRcfBGkQA1GxEBHFwMLAwu4OzFV0rTXWXnH9Vtw11661du3ubl0sMLEwUVHAQAXpRr7/f3zDPpF4WKvLvb/fg/dmbp65Z865JyVJFAEBAQEBAQEBAQEBAQEBAQEBAQEBAQEBAQEBAQEBAQEBAQEBAQEBAQEBAQEBAQEBAQEBAQEBAQGBbwoCe64fcf6mJiw'),
(6, 'iVBORw0KGgoAAAANSUhEUgAAAOEAAADhCAYAAAA+s9J6AABa2UlEQVR4Xu1dBVwVWRcfBGkQA1GxEBHFwMLAwu4OzFV0rTXWXnH9Vtw11661du3ubl0sMLEwUVHAQAXpRr7/f3zDPpF4WKvLvb/fg/dmbp65Z865JyVJFAEBAQEBAQEBAQEBAQEBAQEBAQEBAQEBAQEBAQEBAQEBAQEBAQEBAQEBAQEBAQEBAQEBAQEBAQGBbwoCe64fcf6mJiw'),
(6, 'iVBORw0KGgoAAAANSUhEUgAAAOEAAADhCAYAAAA+s9J6AABa2UlEQVR4Xu1dBVwVWRcfBGkQA1GxEBHFwMLAwu4OzFV0rTXWXnH9Vtw11661du3ubl0sMLEwUVHAQAXpRr7/f3zDPpF4WKvLvb/fg/dmbp65Z865JyVJFAEBAQEBAQEBAQEBAQEBAQEBAQEBAQEBAQEBAQEBAQEBAQEBAQEBAQEBAQEBAQEBAQEBAQEBAQGBbwoCe64fcf6mJiw'),
(7, 'iVBORw0KGgoAAAANSUhEUgAAAOEAAADhCAMAAAAJbSJIAAAAolBMVEX///8bhzrj7+ay0rqnzLCmx60yk03t9vAAdQDA2sdhpnJAl1dbo20AgyrG3sx4sYb3+/hrq3seij7R5NZLml/p8+zb6t8AhDDW6tyQvpuHupMAfiIAfBu007zy+PSZw6NoqXiAtYw6k1FSnmUsjkefx6kAeRAmj0UAeADK3c4AcQCNv5qgy6yEtY+oyK9UnGV7t4tlrHi'),
(7, 'iVBORw0KGgoAAAANSUhEUgAAAOEAAADhCAYAAAA+s9J6AABa2UlEQVR4Xu1dBVwVWRcfBGkQA1GxEBHFwMLAwu4OzFV0rTXWXnH9Vtw11661du3ubl0sMLEwUVHAQAXpRr7/f3zDPpF4WKvLvb/fg/dmbp65Z865JyVJFAEBAQEBAQEBAQEBAQEBAQEBAQEBAQEBAQEBAQEBAQEBAQEBAQEBAQEBAQEBAQEBAQEBAQEBAQGBbwoCe64fcf6mJiw'),
(7, 'iVBORw0KGgoAAAANSUhEUgAAAOEAAADhCAMAAAAJbSJIAAAAolBMVEX///8bhzrj7+ay0rqnzLCmx60yk03t9vAAdQDA2sdhpnJAl1dbo20AgyrG3sx4sYb3+/hrq3seij7R5NZLml/p8+zb6t8AhDDW6tyQvpuHupMAfiIAfBu007zy+PSZw6NoqXiAtYw6k1FSnmUsjkefx6kAeRAmj0UAeADK3c4AcQCNv5qgy6yEtY+oyK9UnGV7t4tlrHi'),
(7, 'iVBORw0KGgoAAAANSUhEUgAAAOEAAADhCAYAAAA+s9J6AABa2UlEQVR4Xu1dBVwVWRcfBGkQA1GxEBHFwMLAwu4OzFV0rTXWXnH9Vtw11661du3ubl0sMLEwUVHAQAXpRr7/f3zDPpF4WKvLvb/fg/dmbp65Z865JyVJFAEBAQEBAQEBAQEBAQEBAQEBAQEBAQEBAQEBAQEBAQEBAQEBAQEBAQEBAQEBAQEBAQEBAQEBAQGBbwoCe64fcf6mJiw'),
(7, 'iVBORw0KGgoAAAANSUhEUgAAAOEAAADhCAYAAAA+s9J6AABa2UlEQVR4Xu1dBVwVWRcfBGkQA1GxEBHFwMLAwu4OzFV0rTXWXnH9Vtw11661du3ubl0sMLEwUVHAQAXpRr7/f3zDPpF4WKvLvb/fg/dmbp65Z865JyVJFAEBAQEBAQEBAQEBAQEBAQEBAQEBAQEBAQEBAQEBAQEBAQEBAQEBAQEBAQEBAQEBAQEBAQEBAQGBbwoCe64fcf6mJiw'),
(7, 'iVBORw0KGgoAAAANSUhEUgAAAOEAAADhCAYAAAA+s9J6AABa2UlEQVR4Xu1dBVwVWRcfBGkQA1GxEBHFwMLAwu4OzFV0rTXWXnH9Vtw11661du3ubl0sMLEwUVHAQAXpRr7/f3zDPpF4WKvLvb/fg/dmbp65Z865JyVJFAEBAQEBAQEBAQEBAQEBAQEBAQEBAQEBAQEBAQEBAQEBAQEBAQEBAQEBAQEBAQEBAQEBAQEBAQGBbwoCe64fcf6mJiw'),
(8, '6475dd2575cfd.jpg'),
(8, '6475dd2577c91.jpg'),
(8, '6475dd2579b77.jpg'),
(8, '6475dd257b0fe.jpg'),
(8, '6475dd257c10c.jpg'),
(8, '6475dd257f46f.jpg'),
(9, 'fotos-noticias/6475de734a62c.jpg'),
(9, 'fotos-noticias/6475de734b2c1.jpg'),
(9, 'fotos-noticias/6475de734bfb7.jpg'),
(9, 'fotos-noticias/6475de734cf44.jpg'),
(9, 'fotos-noticias/6475de734ea73.jpg'),
(9, 'fotos-noticias/6475de7350b24.jpg'),
(10, 'fotos-noticias/6475dea809c4e.jpg'),
(10, 'fotos-noticias/6475dea80bbdb.jpg'),
(10, 'fotos-noticias/6475dea80e163.jpg'),
(10, 'fotos-noticias/6475dea80f0e6.jpg'),
(10, 'fotos-noticias/6475dea811e9e.jpg'),
(10, 'fotos-noticias/6475dea814046.jpg'),
(11, '6475deeb1da4e.jpg'),
(11, '6475deeb1fa2e.jpg'),
(11, '6475deeb22228.jpg'),
(11, '6475deeb240fb.jpg'),
(11, '6475deeb25ec3.jpg'),
(11, '6475deeb271bc.jpg'),
(12, 'fotos-noticias/6475df0469c9e.jpg'),
(12, 'fotos-noticias/6475df046b852.jpg'),
(12, 'fotos-noticias/6475df046d2af.jpg'),
(12, 'fotos-noticias/6475df046f17e.jpg'),
(12, 'fotos-noticias/6475df0470cab.jpg'),
(12, 'fotos-noticias/6475df047214c.jpg'),
(13, 'fotos-noticias/6475df0644dd8.jpg'),
(13, 'fotos-noticias/6475df06468ac.jpg'),
(13, 'fotos-noticias/6475df0647741.jpg'),
(13, 'fotos-noticias/6475df0648512.jpg'),
(13, 'fotos-noticias/6475df064acd2.jpg'),
(13, 'fotos-noticias/6475df064bf73.jpg'),
(14, 'noticias-fotos/6475e0d9d0a47.jpg'),
(14, 'noticias-fotos/6475e0d9d2e0b.jpg'),
(14, 'noticias-fotos/6475e0d9d5939.jpg'),
(14, 'noticias-fotos/6475e0d9d79de.jpg'),
(14, 'noticias-fotos/6475e0d9d9d93.jpg'),
(14, 'noticias-fotos/6475e0d9dba80.jpg'),
(15, 'noticias-fotos/6475e0da76fbe.jpg'),
(15, 'noticias-fotos/6475e0da78b75.jpg'),
(15, 'noticias-fotos/6475e0da7a626.jpg'),
(15, 'noticias-fotos/6475e0da7cf7e.jpg'),
(15, 'noticias-fotos/6475e0da7f092.jpg'),
(15, 'noticias-fotos/6475e0da80dc4.jpg'),
(16, 'noticias-fotos/6475e0db0554d.jpg'),
(16, 'noticias-fotos/6475e0db07488.jpg'),
(16, 'noticias-fotos/6475e0db09b9d.jpg'),
(16, 'noticias-fotos/6475e0db0b8fa.jpg'),
(16, 'noticias-fotos/6475e0db0d6c9.jpg'),
(16, 'noticias-fotos/6475e0db0f81d.jpg'),
(17, 'noticias-fotos/6476079a63c36.jpg'),
(17, 'noticias-fotos/6476079a64db7.jpg'),
(17, 'noticias-fotos/6476079a65d5a.jpg'),
(18, 'noticias-fotos/647607aa1a140.jpg'),
(18, 'noticias-fotos/647607aa1b383.jpg'),
(18, 'noticias-fotos/647607aa1c6ae.jpg'),
(19, 'noticias-fotos/647607ab68540.jpg'),
(19, 'noticias-fotos/647607ab6a2ba.jpg'),
(19, 'noticias-fotos/647607ab6b635.jpg'),
(20, 'noticias-fotos/647607ac2d369.jpg'),
(20, 'noticias-fotos/647607ac2edac.jpg'),
(20, 'noticias-fotos/647607ac320f4.jpg'),
(21, 'noticias-fotos/647609e52d773.jpg'),
(22, 'noticias-fotos/64760baaf0b8e.jpg'),
(23, 'noticias-fotos/64760bd4e14d7.jpg'),
(24, 'noticias-fotos/64760bd53cfec.jpg'),
(25, 'noticias-fotos/64760bd566234.jpg'),
(26, 'noticias-fotos/64760bd58ca11.jpg'),
(27, 'noticias-fotos/64760bd5b42a0.jpg'),
(28, 'noticias-fotos/64760bd5dacf2.jpg'),
(29, 'noticias-fotos/64760bd6045de.jpg'),
(30, 'noticias-fotos/64760bd632a8a.jpg'),
(31, 'noticias-fotos/64760bd653691.jpg'),
(32, 'noticias-fotos/64760bd67b674.jpg'),
(33, 'noticias-fotos/6476149b12a65.jpg'),
(33, 'noticias-fotos/6476149b13ba8.jpg'),
(33, 'noticias-fotos/6476149b15013.jpg'),
(34, 'noticias-fotos/6479eea1bb684.jpg'),
(35, 'noticias-fotos/6479f02beba84.jpg'),
(36, 'noticias-fotos/6479f04c8c1d9.jpg'),
(37, 'noticias-fotos/6479f467ede32.jpg'),
(37, 'noticias-fotos/6479f467ef39e.jpg'),
(37, 'noticias-fotos/6479f467f076f.jpg'),
(37, 'noticias-fotos/6479f467f1d19.jpg'),
(37, 'noticias-fotos/6479f467f325a.jpg'),
(37, 'noticias-fotos/6479f4680067a.jpg'),
(38, 'noticias-fotos/6479f573332f3.jpg'),
(38, 'noticias-fotos/6479f57334fe4.jpg'),
(38, 'noticias-fotos/6479f5733666b.jpg'),
(38, 'noticias-fotos/6479f5733828f.jpg'),
(38, 'noticias-fotos/6479f573398ba.jpg'),
(38, 'noticias-fotos/6479f5733cc11.jpg'),
(39, 'noticias-fotos/6479f63b43841.jpg'),
(5, 'iVBORw0KGgoAAAANSUhEUgAAAOEAAADhCAMAAAAJbSJIAAAAolBMVEX///8bhzrj7+ay0rqnzLCmx60yk03t9vAAdQDA2sdhpnJAl1dbo20AgyrG3sx4sYb3+/hrq3seij7R5NZLml/p8+zb6t8AhDDW6tyQvpuHupMAfiIAfBu007zy+PSZw6NoqXiAtYw6k1FSnmUsjkefx6kAeRAmj0UAeADK3c4AcQCNv5qgy6yEtY+oyK9UnGV7t4tlrHi'),
(5, 'iVBORw0KGgoAAAANSUhEUgAAAOEAAADhCAYAAAA+s9J6AABa2UlEQVR4Xu1dBVwVWRcfBGkQA1GxEBHFwMLAwu4OzFV0rTXWXnH9Vtw11661du3ubl0sMLEwUVHAQAXpRr7/f3zDPpF4WKvLvb/fg/dmbp65Z865JyVJFAEBAQEBAQEBAQEBAQEBAQEBAQEBAQEBAQEBAQEBAQEBAQEBAQEBAQEBAQEBAQEBAQEBAQEBAQGBbwoCe64fcf6mJiw'),
(5, 'iVBORw0KGgoAAAANSUhEUgAAAOEAAADhCAMAAAAJbSJIAAAAolBMVEX///8bhzrj7+ay0rqnzLCmx60yk03t9vAAdQDA2sdhpnJAl1dbo20AgyrG3sx4sYb3+/hrq3seij7R5NZLml/p8+zb6t8AhDDW6tyQvpuHupMAfiIAfBu007zy+PSZw6NoqXiAtYw6k1FSnmUsjkefx6kAeRAmj0UAeADK3c4AcQCNv5qgy6yEtY+oyK9UnGV7t4tlrHi'),
(5, 'iVBORw0KGgoAAAANSUhEUgAAAOEAAADhCAYAAAA+s9J6AABa2UlEQVR4Xu1dBVwVWRcfBGkQA1GxEBHFwMLAwu4OzFV0rTXWXnH9Vtw11661du3ubl0sMLEwUVHAQAXpRr7/f3zDPpF4WKvLvb/fg/dmbp65Z865JyVJFAEBAQEBAQEBAQEBAQEBAQEBAQEBAQEBAQEBAQEBAQEBAQEBAQEBAQEBAQEBAQEBAQEBAQEBAQGBbwoCe64fcf6mJiw'),
(5, 'iVBORw0KGgoAAAANSUhEUgAAAOEAAADhCAYAAAA+s9J6AABa2UlEQVR4Xu1dBVwVWRcfBGkQA1GxEBHFwMLAwu4OzFV0rTXWXnH9Vtw11661du3ubl0sMLEwUVHAQAXpRr7/f3zDPpF4WKvLvb/fg/dmbp65Z865JyVJFAEBAQEBAQEBAQEBAQEBAQEBAQEBAQEBAQEBAQEBAQEBAQEBAQEBAQEBAQEBAQEBAQEBAQEBAQGBbwoCe64fcf6mJiw'),
(5, 'iVBORw0KGgoAAAANSUhEUgAAAOEAAADhCAYAAAA+s9J6AABa2UlEQVR4Xu1dBVwVWRcfBGkQA1GxEBHFwMLAwu4OzFV0rTXWXnH9Vtw11661du3ubl0sMLEwUVHAQAXpRr7/f3zDPpF4WKvLvb/fg/dmbp65Z865JyVJFAEBAQEBAQEBAQEBAQEBAQEBAQEBAQEBAQEBAQEBAQEBAQEBAQEBAQEBAQEBAQEBAQEBAQEBAQGBbwoCe64fcf6mJiw'),
(6, 'iVBORw0KGgoAAAANSUhEUgAAAOEAAADhCAMAAAAJbSJIAAAAolBMVEX///8bhzrj7+ay0rqnzLCmx60yk03t9vAAdQDA2sdhpnJAl1dbo20AgyrG3sx4sYb3+/hrq3seij7R5NZLml/p8+zb6t8AhDDW6tyQvpuHupMAfiIAfBu007zy+PSZw6NoqXiAtYw6k1FSnmUsjkefx6kAeRAmj0UAeADK3c4AcQCNv5qgy6yEtY+oyK9UnGV7t4tlrHi'),
(6, 'iVBORw0KGgoAAAANSUhEUgAAAOEAAADhCAYAAAA+s9J6AABa2UlEQVR4Xu1dBVwVWRcfBGkQA1GxEBHFwMLAwu4OzFV0rTXWXnH9Vtw11661du3ubl0sMLEwUVHAQAXpRr7/f3zDPpF4WKvLvb/fg/dmbp65Z865JyVJFAEBAQEBAQEBAQEBAQEBAQEBAQEBAQEBAQEBAQEBAQEBAQEBAQEBAQEBAQEBAQEBAQEBAQEBAQGBbwoCe64fcf6mJiw'),
(6, 'iVBORw0KGgoAAAANSUhEUgAAAOEAAADhCAMAAAAJbSJIAAAAolBMVEX///8bhzrj7+ay0rqnzLCmx60yk03t9vAAdQDA2sdhpnJAl1dbo20AgyrG3sx4sYb3+/hrq3seij7R5NZLml/p8+zb6t8AhDDW6tyQvpuHupMAfiIAfBu007zy+PSZw6NoqXiAtYw6k1FSnmUsjkefx6kAeRAmj0UAeADK3c4AcQCNv5qgy6yEtY+oyK9UnGV7t4tlrHi'),
(6, 'iVBORw0KGgoAAAANSUhEUgAAAOEAAADhCAYAAAA+s9J6AABa2UlEQVR4Xu1dBVwVWRcfBGkQA1GxEBHFwMLAwu4OzFV0rTXWXnH9Vtw11661du3ubl0sMLEwUVHAQAXpRr7/f3zDPpF4WKvLvb/fg/dmbp65Z865JyVJFAEBAQEBAQEBAQEBAQEBAQEBAQEBAQEBAQEBAQEBAQEBAQEBAQEBAQEBAQEBAQEBAQEBAQEBAQGBbwoCe64fcf6mJiw'),
(6, 'iVBORw0KGgoAAAANSUhEUgAAAOEAAADhCAYAAAA+s9J6AABa2UlEQVR4Xu1dBVwVWRcfBGkQA1GxEBHFwMLAwu4OzFV0rTXWXnH9Vtw11661du3ubl0sMLEwUVHAQAXpRr7/f3zDPpF4WKvLvb/fg/dmbp65Z865JyVJFAEBAQEBAQEBAQEBAQEBAQEBAQEBAQEBAQEBAQEBAQEBAQEBAQEBAQEBAQEBAQEBAQEBAQEBAQGBbwoCe64fcf6mJiw'),
(6, 'iVBORw0KGgoAAAANSUhEUgAAAOEAAADhCAYAAAA+s9J6AABa2UlEQVR4Xu1dBVwVWRcfBGkQA1GxEBHFwMLAwu4OzFV0rTXWXnH9Vtw11661du3ubl0sMLEwUVHAQAXpRr7/f3zDPpF4WKvLvb/fg/dmbp65Z865JyVJFAEBAQEBAQEBAQEBAQEBAQEBAQEBAQEBAQEBAQEBAQEBAQEBAQEBAQEBAQEBAQEBAQEBAQEBAQGBbwoCe64fcf6mJiw'),
(7, 'iVBORw0KGgoAAAANSUhEUgAAAOEAAADhCAMAAAAJbSJIAAAAolBMVEX///8bhzrj7+ay0rqnzLCmx60yk03t9vAAdQDA2sdhpnJAl1dbo20AgyrG3sx4sYb3+/hrq3seij7R5NZLml/p8+zb6t8AhDDW6tyQvpuHupMAfiIAfBu007zy+PSZw6NoqXiAtYw6k1FSnmUsjkefx6kAeRAmj0UAeADK3c4AcQCNv5qgy6yEtY+oyK9UnGV7t4tlrHi'),
(7, 'iVBORw0KGgoAAAANSUhEUgAAAOEAAADhCAYAAAA+s9J6AABa2UlEQVR4Xu1dBVwVWRcfBGkQA1GxEBHFwMLAwu4OzFV0rTXWXnH9Vtw11661du3ubl0sMLEwUVHAQAXpRr7/f3zDPpF4WKvLvb/fg/dmbp65Z865JyVJFAEBAQEBAQEBAQEBAQEBAQEBAQEBAQEBAQEBAQEBAQEBAQEBAQEBAQEBAQEBAQEBAQEBAQEBAQGBbwoCe64fcf6mJiw'),
(7, 'iVBORw0KGgoAAAANSUhEUgAAAOEAAADhCAMAAAAJbSJIAAAAolBMVEX///8bhzrj7+ay0rqnzLCmx60yk03t9vAAdQDA2sdhpnJAl1dbo20AgyrG3sx4sYb3+/hrq3seij7R5NZLml/p8+zb6t8AhDDW6tyQvpuHupMAfiIAfBu007zy+PSZw6NoqXiAtYw6k1FSnmUsjkefx6kAeRAmj0UAeADK3c4AcQCNv5qgy6yEtY+oyK9UnGV7t4tlrHi'),
(7, 'iVBORw0KGgoAAAANSUhEUgAAAOEAAADhCAYAAAA+s9J6AABa2UlEQVR4Xu1dBVwVWRcfBGkQA1GxEBHFwMLAwu4OzFV0rTXWXnH9Vtw11661du3ubl0sMLEwUVHAQAXpRr7/f3zDPpF4WKvLvb/fg/dmbp65Z865JyVJFAEBAQEBAQEBAQEBAQEBAQEBAQEBAQEBAQEBAQEBAQEBAQEBAQEBAQEBAQEBAQEBAQEBAQEBAQGBbwoCe64fcf6mJiw'),
(7, 'iVBORw0KGgoAAAANSUhEUgAAAOEAAADhCAYAAAA+s9J6AABa2UlEQVR4Xu1dBVwVWRcfBGkQA1GxEBHFwMLAwu4OzFV0rTXWXnH9Vtw11661du3ubl0sMLEwUVHAQAXpRr7/f3zDPpF4WKvLvb/fg/dmbp65Z865JyVJFAEBAQEBAQEBAQEBAQEBAQEBAQEBAQEBAQEBAQEBAQEBAQEBAQEBAQEBAQEBAQEBAQEBAQEBAQGBbwoCe64fcf6mJiw'),
(7, 'iVBORw0KGgoAAAANSUhEUgAAAOEAAADhCAYAAAA+s9J6AABa2UlEQVR4Xu1dBVwVWRcfBGkQA1GxEBHFwMLAwu4OzFV0rTXWXnH9Vtw11661du3ubl0sMLEwUVHAQAXpRr7/f3zDPpF4WKvLvb/fg/dmbp65Z865JyVJFAEBAQEBAQEBAQEBAQEBAQEBAQEBAQEBAQEBAQEBAQEBAQEBAQEBAQEBAQEBAQEBAQEBAQEBAQGBbwoCe64fcf6mJiw'),
(8, '6475dd2575cfd.jpg'),
(8, '6475dd2577c91.jpg'),
(8, '6475dd2579b77.jpg'),
(8, '6475dd257b0fe.jpg'),
(8, '6475dd257c10c.jpg'),
(8, '6475dd257f46f.jpg'),
(9, 'fotos-noticias/6475de734a62c.jpg'),
(9, 'fotos-noticias/6475de734b2c1.jpg'),
(9, 'fotos-noticias/6475de734bfb7.jpg'),
(9, 'fotos-noticias/6475de734cf44.jpg'),
(9, 'fotos-noticias/6475de734ea73.jpg'),
(9, 'fotos-noticias/6475de7350b24.jpg'),
(10, 'fotos-noticias/6475dea809c4e.jpg'),
(10, 'fotos-noticias/6475dea80bbdb.jpg'),
(10, 'fotos-noticias/6475dea80e163.jpg'),
(10, 'fotos-noticias/6475dea80f0e6.jpg'),
(10, 'fotos-noticias/6475dea811e9e.jpg'),
(10, 'fotos-noticias/6475dea814046.jpg'),
(11, '6475deeb1da4e.jpg'),
(11, '6475deeb1fa2e.jpg'),
(11, '6475deeb22228.jpg'),
(11, '6475deeb240fb.jpg'),
(11, '6475deeb25ec3.jpg'),
(11, '6475deeb271bc.jpg'),
(12, 'fotos-noticias/6475df0469c9e.jpg'),
(12, 'fotos-noticias/6475df046b852.jpg'),
(12, 'fotos-noticias/6475df046d2af.jpg'),
(12, 'fotos-noticias/6475df046f17e.jpg'),
(12, 'fotos-noticias/6475df0470cab.jpg'),
(12, 'fotos-noticias/6475df047214c.jpg'),
(13, 'fotos-noticias/6475df0644dd8.jpg'),
(13, 'fotos-noticias/6475df06468ac.jpg'),
(13, 'fotos-noticias/6475df0647741.jpg'),
(13, 'fotos-noticias/6475df0648512.jpg'),
(13, 'fotos-noticias/6475df064acd2.jpg'),
(13, 'fotos-noticias/6475df064bf73.jpg'),
(14, 'noticias-fotos/6475e0d9d0a47.jpg'),
(14, 'noticias-fotos/6475e0d9d2e0b.jpg'),
(14, 'noticias-fotos/6475e0d9d5939.jpg'),
(14, 'noticias-fotos/6475e0d9d79de.jpg'),
(14, 'noticias-fotos/6475e0d9d9d93.jpg'),
(14, 'noticias-fotos/6475e0d9dba80.jpg'),
(15, 'noticias-fotos/6475e0da76fbe.jpg'),
(15, 'noticias-fotos/6475e0da78b75.jpg'),
(15, 'noticias-fotos/6475e0da7a626.jpg'),
(15, 'noticias-fotos/6475e0da7cf7e.jpg'),
(15, 'noticias-fotos/6475e0da7f092.jpg'),
(15, 'noticias-fotos/6475e0da80dc4.jpg'),
(16, 'noticias-fotos/6475e0db0554d.jpg'),
(16, 'noticias-fotos/6475e0db07488.jpg'),
(16, 'noticias-fotos/6475e0db09b9d.jpg'),
(16, 'noticias-fotos/6475e0db0b8fa.jpg'),
(16, 'noticias-fotos/6475e0db0d6c9.jpg'),
(16, 'noticias-fotos/6475e0db0f81d.jpg'),
(17, 'noticias-fotos/6476079a63c36.jpg'),
(17, 'noticias-fotos/6476079a64db7.jpg'),
(17, 'noticias-fotos/6476079a65d5a.jpg'),
(18, 'noticias-fotos/647607aa1a140.jpg'),
(18, 'noticias-fotos/647607aa1b383.jpg'),
(18, 'noticias-fotos/647607aa1c6ae.jpg'),
(19, 'noticias-fotos/647607ab68540.jpg'),
(19, 'noticias-fotos/647607ab6a2ba.jpg'),
(19, 'noticias-fotos/647607ab6b635.jpg'),
(20, 'noticias-fotos/647607ac2d369.jpg'),
(20, 'noticias-fotos/647607ac2edac.jpg'),
(20, 'noticias-fotos/647607ac320f4.jpg'),
(21, 'noticias-fotos/647609e52d773.jpg'),
(22, 'noticias-fotos/64760baaf0b8e.jpg'),
(23, 'noticias-fotos/64760bd4e14d7.jpg'),
(24, 'noticias-fotos/64760bd53cfec.jpg'),
(25, 'noticias-fotos/64760bd566234.jpg'),
(26, 'noticias-fotos/64760bd58ca11.jpg'),
(27, 'noticias-fotos/64760bd5b42a0.jpg'),
(28, 'noticias-fotos/64760bd5dacf2.jpg'),
(29, 'noticias-fotos/64760bd6045de.jpg'),
(30, 'noticias-fotos/64760bd632a8a.jpg'),
(31, 'noticias-fotos/64760bd653691.jpg'),
(32, 'noticias-fotos/64760bd67b674.jpg'),
(33, 'noticias-fotos/6476149b12a65.jpg'),
(33, 'noticias-fotos/6476149b13ba8.jpg'),
(33, 'noticias-fotos/6476149b15013.jpg'),
(34, 'noticias-fotos/6479eea1bb684.jpg'),
(35, 'noticias-fotos/6479f02beba84.jpg'),
(36, 'noticias-fotos/6479f04c8c1d9.jpg'),
(37, 'noticias-fotos/6479f467ede32.jpg'),
(37, 'noticias-fotos/6479f467ef39e.jpg'),
(37, 'noticias-fotos/6479f467f076f.jpg'),
(37, 'noticias-fotos/6479f467f1d19.jpg'),
(37, 'noticias-fotos/6479f467f325a.jpg'),
(37, 'noticias-fotos/6479f4680067a.jpg'),
(38, 'noticias-fotos/6479f573332f3.jpg'),
(38, 'noticias-fotos/6479f57334fe4.jpg'),
(38, 'noticias-fotos/6479f5733666b.jpg'),
(38, 'noticias-fotos/6479f5733828f.jpg'),
(38, 'noticias-fotos/6479f573398ba.jpg'),
(38, 'noticias-fotos/6479f5733cc11.jpg'),
(39, 'noticias-fotos/6479f63b43841.jpg'),
(5, 'iVBORw0KGgoAAAANSUhEUgAAAOEAAADhCAMAAAAJbSJIAAAAolBMVEX///8bhzrj7+ay0rqnzLCmx60yk03t9vAAdQDA2sdhpnJAl1dbo20AgyrG3sx4sYb3+/hrq3seij7R5NZLml/p8+zb6t8AhDDW6tyQvpuHupMAfiIAfBu007zy+PSZw6NoqXiAtYw6k1FSnmUsjkefx6kAeRAmj0UAeADK3c4AcQCNv5qgy6yEtY+oyK9UnGV7t4tlrHi'),
(5, 'iVBORw0KGgoAAAANSUhEUgAAAOEAAADhCAYAAAA+s9J6AABa2UlEQVR4Xu1dBVwVWRcfBGkQA1GxEBHFwMLAwu4OzFV0rTXWXnH9Vtw11661du3ubl0sMLEwUVHAQAXpRr7/f3zDPpF4WKvLvb/fg/dmbp65Z865JyVJFAEBAQEBAQEBAQEBAQEBAQEBAQEBAQEBAQEBAQEBAQEBAQEBAQEBAQEBAQEBAQEBAQEBAQEBAQGBbwoCe64fcf6mJiw'),
(5, 'iVBORw0KGgoAAAANSUhEUgAAAOEAAADhCAMAAAAJbSJIAAAAolBMVEX///8bhzrj7+ay0rqnzLCmx60yk03t9vAAdQDA2sdhpnJAl1dbo20AgyrG3sx4sYb3+/hrq3seij7R5NZLml/p8+zb6t8AhDDW6tyQvpuHupMAfiIAfBu007zy+PSZw6NoqXiAtYw6k1FSnmUsjkefx6kAeRAmj0UAeADK3c4AcQCNv5qgy6yEtY+oyK9UnGV7t4tlrHi'),
(5, 'iVBORw0KGgoAAAANSUhEUgAAAOEAAADhCAYAAAA+s9J6AABa2UlEQVR4Xu1dBVwVWRcfBGkQA1GxEBHFwMLAwu4OzFV0rTXWXnH9Vtw11661du3ubl0sMLEwUVHAQAXpRr7/f3zDPpF4WKvLvb/fg/dmbp65Z865JyVJFAEBAQEBAQEBAQEBAQEBAQEBAQEBAQEBAQEBAQEBAQEBAQEBAQEBAQEBAQEBAQEBAQEBAQEBAQGBbwoCe64fcf6mJiw'),
(5, 'iVBORw0KGgoAAAANSUhEUgAAAOEAAADhCAYAAAA+s9J6AABa2UlEQVR4Xu1dBVwVWRcfBGkQA1GxEBHFwMLAwu4OzFV0rTXWXnH9Vtw11661du3ubl0sMLEwUVHAQAXpRr7/f3zDPpF4WKvLvb/fg/dmbp65Z865JyVJFAEBAQEBAQEBAQEBAQEBAQEBAQEBAQEBAQEBAQEBAQEBAQEBAQEBAQEBAQEBAQEBAQEBAQEBAQGBbwoCe64fcf6mJiw'),
(5, 'iVBORw0KGgoAAAANSUhEUgAAAOEAAADhCAYAAAA+s9J6AABa2UlEQVR4Xu1dBVwVWRcfBGkQA1GxEBHFwMLAwu4OzFV0rTXWXnH9Vtw11661du3ubl0sMLEwUVHAQAXpRr7/f3zDPpF4WKvLvb/fg/dmbp65Z865JyVJFAEBAQEBAQEBAQEBAQEBAQEBAQEBAQEBAQEBAQEBAQEBAQEBAQEBAQEBAQEBAQEBAQEBAQEBAQGBbwoCe64fcf6mJiw'),
(6, 'iVBORw0KGgoAAAANSUhEUgAAAOEAAADhCAMAAAAJbSJIAAAAolBMVEX///8bhzrj7+ay0rqnzLCmx60yk03t9vAAdQDA2sdhpnJAl1dbo20AgyrG3sx4sYb3+/hrq3seij7R5NZLml/p8+zb6t8AhDDW6tyQvpuHupMAfiIAfBu007zy+PSZw6NoqXiAtYw6k1FSnmUsjkefx6kAeRAmj0UAeADK3c4AcQCNv5qgy6yEtY+oyK9UnGV7t4tlrHi'),
(6, 'iVBORw0KGgoAAAANSUhEUgAAAOEAAADhCAYAAAA+s9J6AABa2UlEQVR4Xu1dBVwVWRcfBGkQA1GxEBHFwMLAwu4OzFV0rTXWXnH9Vtw11661du3ubl0sMLEwUVHAQAXpRr7/f3zDPpF4WKvLvb/fg/dmbp65Z865JyVJFAEBAQEBAQEBAQEBAQEBAQEBAQEBAQEBAQEBAQEBAQEBAQEBAQEBAQEBAQEBAQEBAQEBAQEBAQGBbwoCe64fcf6mJiw'),
(6, 'iVBORw0KGgoAAAANSUhEUgAAAOEAAADhCAMAAAAJbSJIAAAAolBMVEX///8bhzrj7+ay0rqnzLCmx60yk03t9vAAdQDA2sdhpnJAl1dbo20AgyrG3sx4sYb3+/hrq3seij7R5NZLml/p8+zb6t8AhDDW6tyQvpuHupMAfiIAfBu007zy+PSZw6NoqXiAtYw6k1FSnmUsjkefx6kAeRAmj0UAeADK3c4AcQCNv5qgy6yEtY+oyK9UnGV7t4tlrHi'),
(6, 'iVBORw0KGgoAAAANSUhEUgAAAOEAAADhCAYAAAA+s9J6AABa2UlEQVR4Xu1dBVwVWRcfBGkQA1GxEBHFwMLAwu4OzFV0rTXWXnH9Vtw11661du3ubl0sMLEwUVHAQAXpRr7/f3zDPpF4WKvLvb/fg/dmbp65Z865JyVJFAEBAQEBAQEBAQEBAQEBAQEBAQEBAQEBAQEBAQEBAQEBAQEBAQEBAQEBAQEBAQEBAQEBAQEBAQGBbwoCe64fcf6mJiw'),
(6, 'iVBORw0KGgoAAAANSUhEUgAAAOEAAADhCAYAAAA+s9J6AABa2UlEQVR4Xu1dBVwVWRcfBGkQA1GxEBHFwMLAwu4OzFV0rTXWXnH9Vtw11661du3ubl0sMLEwUVHAQAXpRr7/f3zDPpF4WKvLvb/fg/dmbp65Z865JyVJFAEBAQEBAQEBAQEBAQEBAQEBAQEBAQEBAQEBAQEBAQEBAQEBAQEBAQEBAQEBAQEBAQEBAQEBAQGBbwoCe64fcf6mJiw'),
(6, 'iVBORw0KGgoAAAANSUhEUgAAAOEAAADhCAYAAAA+s9J6AABa2UlEQVR4Xu1dBVwVWRcfBGkQA1GxEBHFwMLAwu4OzFV0rTXWXnH9Vtw11661du3ubl0sMLEwUVHAQAXpRr7/f3zDPpF4WKvLvb/fg/dmbp65Z865JyVJFAEBAQEBAQEBAQEBAQEBAQEBAQEBAQEBAQEBAQEBAQEBAQEBAQEBAQEBAQEBAQEBAQEBAQEBAQGBbwoCe64fcf6mJiw'),
(7, 'iVBORw0KGgoAAAANSUhEUgAAAOEAAADhCAMAAAAJbSJIAAAAolBMVEX///8bhzrj7+ay0rqnzLCmx60yk03t9vAAdQDA2sdhpnJAl1dbo20AgyrG3sx4sYb3+/hrq3seij7R5NZLml/p8+zb6t8AhDDW6tyQvpuHupMAfiIAfBu007zy+PSZw6NoqXiAtYw6k1FSnmUsjkefx6kAeRAmj0UAeADK3c4AcQCNv5qgy6yEtY+oyK9UnGV7t4tlrHi'),
(7, 'iVBORw0KGgoAAAANSUhEUgAAAOEAAADhCAYAAAA+s9J6AABa2UlEQVR4Xu1dBVwVWRcfBGkQA1GxEBHFwMLAwu4OzFV0rTXWXnH9Vtw11661du3ubl0sMLEwUVHAQAXpRr7/f3zDPpF4WKvLvb/fg/dmbp65Z865JyVJFAEBAQEBAQEBAQEBAQEBAQEBAQEBAQEBAQEBAQEBAQEBAQEBAQEBAQEBAQEBAQEBAQEBAQEBAQGBbwoCe64fcf6mJiw'),
(7, 'iVBORw0KGgoAAAANSUhEUgAAAOEAAADhCAMAAAAJbSJIAAAAolBMVEX///8bhzrj7+ay0rqnzLCmx60yk03t9vAAdQDA2sdhpnJAl1dbo20AgyrG3sx4sYb3+/hrq3seij7R5NZLml/p8+zb6t8AhDDW6tyQvpuHupMAfiIAfBu007zy+PSZw6NoqXiAtYw6k1FSnmUsjkefx6kAeRAmj0UAeADK3c4AcQCNv5qgy6yEtY+oyK9UnGV7t4tlrHi'),
(7, 'iVBORw0KGgoAAAANSUhEUgAAAOEAAADhCAYAAAA+s9J6AABa2UlEQVR4Xu1dBVwVWRcfBGkQA1GxEBHFwMLAwu4OzFV0rTXWXnH9Vtw11661du3ubl0sMLEwUVHAQAXpRr7/f3zDPpF4WKvLvb/fg/dmbp65Z865JyVJFAEBAQEBAQEBAQEBAQEBAQEBAQEBAQEBAQEBAQEBAQEBAQEBAQEBAQEBAQEBAQEBAQEBAQEBAQGBbwoCe64fcf6mJiw'),
(7, 'iVBORw0KGgoAAAANSUhEUgAAAOEAAADhCAYAAAA+s9J6AABa2UlEQVR4Xu1dBVwVWRcfBGkQA1GxEBHFwMLAwu4OzFV0rTXWXnH9Vtw11661du3ubl0sMLEwUVHAQAXpRr7/f3zDPpF4WKvLvb/fg/dmbp65Z865JyVJFAEBAQEBAQEBAQEBAQEBAQEBAQEBAQEBAQEBAQEBAQEBAQEBAQEBAQEBAQEBAQEBAQEBAQEBAQGBbwoCe64fcf6mJiw'),
(7, 'iVBORw0KGgoAAAANSUhEUgAAAOEAAADhCAYAAAA+s9J6AABa2UlEQVR4Xu1dBVwVWRcfBGkQA1GxEBHFwMLAwu4OzFV0rTXWXnH9Vtw11661du3ubl0sMLEwUVHAQAXpRr7/f3zDPpF4WKvLvb/fg/dmbp65Z865JyVJFAEBAQEBAQEBAQEBAQEBAQEBAQEBAQEBAQEBAQEBAQEBAQEBAQEBAQEBAQEBAQEBAQEBAQEBAQGBbwoCe64fcf6mJiw'),
(8, '6475dd2575cfd.jpg'),
(8, '6475dd2577c91.jpg'),
(8, '6475dd2579b77.jpg'),
(8, '6475dd257b0fe.jpg'),
(8, '6475dd257c10c.jpg'),
(8, '6475dd257f46f.jpg'),
(9, 'fotos-noticias/6475de734a62c.jpg'),
(9, 'fotos-noticias/6475de734b2c1.jpg'),
(9, 'fotos-noticias/6475de734bfb7.jpg'),
(9, 'fotos-noticias/6475de734cf44.jpg'),
(9, 'fotos-noticias/6475de734ea73.jpg'),
(9, 'fotos-noticias/6475de7350b24.jpg'),
(10, 'fotos-noticias/6475dea809c4e.jpg'),
(10, 'fotos-noticias/6475dea80bbdb.jpg'),
(10, 'fotos-noticias/6475dea80e163.jpg'),
(10, 'fotos-noticias/6475dea80f0e6.jpg'),
(10, 'fotos-noticias/6475dea811e9e.jpg'),
(10, 'fotos-noticias/6475dea814046.jpg'),
(11, '6475deeb1da4e.jpg'),
(11, '6475deeb1fa2e.jpg'),
(11, '6475deeb22228.jpg'),
(11, '6475deeb240fb.jpg'),
(11, '6475deeb25ec3.jpg'),
(11, '6475deeb271bc.jpg'),
(12, 'fotos-noticias/6475df0469c9e.jpg'),
(12, 'fotos-noticias/6475df046b852.jpg');
INSERT INTO `noticias_fotos` (`id_noticia`, `fotos_noticia`) VALUES
(12, 'fotos-noticias/6475df046d2af.jpg'),
(12, 'fotos-noticias/6475df046f17e.jpg'),
(12, 'fotos-noticias/6475df0470cab.jpg'),
(12, 'fotos-noticias/6475df047214c.jpg'),
(13, 'fotos-noticias/6475df0644dd8.jpg'),
(13, 'fotos-noticias/6475df06468ac.jpg'),
(13, 'fotos-noticias/6475df0647741.jpg'),
(13, 'fotos-noticias/6475df0648512.jpg'),
(13, 'fotos-noticias/6475df064acd2.jpg'),
(13, 'fotos-noticias/6475df064bf73.jpg'),
(14, 'noticias-fotos/6475e0d9d0a47.jpg'),
(14, 'noticias-fotos/6475e0d9d2e0b.jpg'),
(14, 'noticias-fotos/6475e0d9d5939.jpg'),
(14, 'noticias-fotos/6475e0d9d79de.jpg'),
(14, 'noticias-fotos/6475e0d9d9d93.jpg'),
(14, 'noticias-fotos/6475e0d9dba80.jpg'),
(15, 'noticias-fotos/6475e0da76fbe.jpg'),
(15, 'noticias-fotos/6475e0da78b75.jpg'),
(15, 'noticias-fotos/6475e0da7a626.jpg'),
(15, 'noticias-fotos/6475e0da7cf7e.jpg'),
(15, 'noticias-fotos/6475e0da7f092.jpg'),
(15, 'noticias-fotos/6475e0da80dc4.jpg'),
(16, 'noticias-fotos/6475e0db0554d.jpg'),
(16, 'noticias-fotos/6475e0db07488.jpg'),
(16, 'noticias-fotos/6475e0db09b9d.jpg'),
(16, 'noticias-fotos/6475e0db0b8fa.jpg'),
(16, 'noticias-fotos/6475e0db0d6c9.jpg'),
(16, 'noticias-fotos/6475e0db0f81d.jpg'),
(17, 'noticias-fotos/6476079a63c36.jpg'),
(17, 'noticias-fotos/6476079a64db7.jpg'),
(17, 'noticias-fotos/6476079a65d5a.jpg'),
(18, 'noticias-fotos/647607aa1a140.jpg'),
(18, 'noticias-fotos/647607aa1b383.jpg'),
(18, 'noticias-fotos/647607aa1c6ae.jpg'),
(19, 'noticias-fotos/647607ab68540.jpg'),
(19, 'noticias-fotos/647607ab6a2ba.jpg'),
(19, 'noticias-fotos/647607ab6b635.jpg'),
(20, 'noticias-fotos/647607ac2d369.jpg'),
(20, 'noticias-fotos/647607ac2edac.jpg'),
(20, 'noticias-fotos/647607ac320f4.jpg'),
(21, 'noticias-fotos/647609e52d773.jpg'),
(22, 'noticias-fotos/64760baaf0b8e.jpg'),
(23, 'noticias-fotos/64760bd4e14d7.jpg'),
(24, 'noticias-fotos/64760bd53cfec.jpg'),
(25, 'noticias-fotos/64760bd566234.jpg'),
(26, 'noticias-fotos/64760bd58ca11.jpg'),
(27, 'noticias-fotos/64760bd5b42a0.jpg'),
(28, 'noticias-fotos/64760bd5dacf2.jpg'),
(29, 'noticias-fotos/64760bd6045de.jpg'),
(30, 'noticias-fotos/64760bd632a8a.jpg'),
(31, 'noticias-fotos/64760bd653691.jpg'),
(32, 'noticias-fotos/64760bd67b674.jpg'),
(33, 'noticias-fotos/6476149b12a65.jpg'),
(33, 'noticias-fotos/6476149b13ba8.jpg'),
(33, 'noticias-fotos/6476149b15013.jpg'),
(34, 'noticias-fotos/6479eea1bb684.jpg'),
(35, 'noticias-fotos/6479f02beba84.jpg'),
(36, 'noticias-fotos/6479f04c8c1d9.jpg'),
(37, 'noticias-fotos/6479f467ede32.jpg'),
(37, 'noticias-fotos/6479f467ef39e.jpg'),
(37, 'noticias-fotos/6479f467f076f.jpg'),
(37, 'noticias-fotos/6479f467f1d19.jpg'),
(37, 'noticias-fotos/6479f467f325a.jpg'),
(37, 'noticias-fotos/6479f4680067a.jpg'),
(38, 'noticias-fotos/6479f573332f3.jpg'),
(38, 'noticias-fotos/6479f57334fe4.jpg'),
(38, 'noticias-fotos/6479f5733666b.jpg'),
(38, 'noticias-fotos/6479f5733828f.jpg'),
(38, 'noticias-fotos/6479f573398ba.jpg'),
(38, 'noticias-fotos/6479f5733cc11.jpg'),
(39, 'noticias-fotos/6479f63b43841.jpg'),
(40, 'noticias-fotos/65c9187a52876.jpg'),
(40, 'noticias-fotos/65c9187a52d9d.jpg'),
(40, 'noticias-fotos/65c9187a5317b.jpg'),
(41, 'noticias-fotos/65c918ce1d81f.jpg'),
(41, 'noticias-fotos/65c918ce1dc5d.jpg'),
(41, 'noticias-fotos/65c918ce1e08d.jpg'),
(42, 'noticias-fotos/65c918ee26549.jpg'),
(43, 'noticias-fotos/65c92c9ab1dde.jpg'),
(43, 'noticias-fotos/65c92c9ab2340.jpg'),
(43, 'noticias-fotos/65c92c9ab2772.jpg'),
(38, 'noticias-fotos/65c934d468645.png'),
(44, 'noticias-fotos/65f2d6031350d.jpg'),
(44, 'noticias-fotos/65f2d60313953.jpg'),
(44, 'noticias-fotos/65f2d60313cde.jpg'),
(44, 'noticias-fotos/65f2d60314022.jpg'),
(45, 'noticias-fotos/65f2d64b841a0.jpg'),
(45, 'noticias-fotos/65f2d64b84751.jpg'),
(45, 'noticias-fotos/65f2d64b84bc0.jpg'),
(45, 'noticias-fotos/65f2d64b85018.jpg'),
(45, 'noticias-fotos/65f2d64b854a2.jpg'),
(45, 'noticias-fotos/65f2d64b85954.jpg'),
(45, 'noticias-fotos/65f2d64b85db6.jpg'),
(45, 'noticias-fotos/65f2d64b862f0.jpg'),
(46, 'noticias-fotos/65f2d6d3cbd5b.jpg'),
(47, 'noticias-fotos/664340928178f.jpg'),
(48, 'noticias-fotos/664343d13e6cc.jpg'),
(49, 'noticias-fotos/6643440ecc3ed.jpg'),
(50, 'noticias-fotos/664344f2d0cb2.jpg'),
(51, 'noticias-fotos/6643457168b22.jpg'),
(52, 'noticias-fotos/66434584b60d5.jpg'),
(53, 'noticias-fotos/6643463d83f56.jpg'),
(54, 'noticias-fotos/664347082d3c3.jpg'),
(55, 'noticias-fotos/664347c207316.jpg'),
(56, 'noticias-fotos/664347d90d31c.jpg'),
(57, 'noticias-fotos/66434823e76a7.jpg'),
(58, 'noticias-fotos/664348309f9ea.jpg'),
(59, 'noticias-fotos/6643485bef776.jpg'),
(60, 'noticias-fotos/66434991f1729.jpg'),
(61, 'noticias-fotos/66434aa6f31f3.jpg'),
(62, 'noticias-fotos/66434b35cdf8f.jpg'),
(63, 'noticias-fotos/66434b6285251.jpg'),
(64, 'noticias-fotos/66434bb6e337c.jpg'),
(65, 'noticias-fotos/66434cc77fb2a.jpg'),
(66, 'noticias-fotos/66434d6f9a9b3.jpg'),
(67, 'noticias-fotos/66434eea9174a.jpg'),
(68, 'noticias-fotos/66434f24ceb80.jpg'),
(69, 'noticias-fotos/6644cf9504584.jpg'),
(69, 'noticias-fotos/6644cf9504a90.jpg'),
(69, 'noticias-fotos/6644cf9504e2d.jpg'),
(69, 'noticias-fotos/6644cf95051e7.jpg'),
(69, 'noticias-fotos/6644cf9505542.jpg'),
(70, 'noticias-fotos/6644d0741fdb9.jpg'),
(71, 'noticias-fotos/6644d10366ac5.jpg'),
(71, 'noticias-fotos/6644d10367190.jpg'),
(72, 'noticias-fotos/6644d16191722.jpg'),
(73, 'noticias-fotos/6644d1d037a2f.jpg'),
(74, 'noticias-fotos/6644d2023baa7.jpg'),
(70, 'noticias-fotos/664a7805edae6.jpg'),
(75, 'noticias-fotos/6656e488e9370.jpg'),
(75, 'noticias-fotos/6656e488e97cc.jpg'),
(75, 'noticias-fotos/6656e488e9c0f.jpg'),
(75, 'noticias-fotos/6656e488e9fe8.jpg');

-- --------------------------------------------------------

--
-- Estrutura da tabela `noticias_info`
--

CREATE TABLE `noticias_info` (
  `id_noticia` int(11) NOT NULL,
  `data_noticia` date NOT NULL,
  `user` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Extraindo dados da tabela `noticias_info`
--

INSERT INTO `noticias_info` (`id_noticia`, `data_noticia`, `user`) VALUES
(15, '2023-05-30', ''),
(16, '2023-05-30', ''),
(17, '2023-05-31', ''),
(18, '2023-05-31', ''),
(19, '2023-05-31', ''),
(21, '2023-05-31', ''),
(22, '2023-05-31', ''),
(23, '2023-05-31', ''),
(24, '2023-05-31', ''),
(25, '2023-05-31', ''),
(26, '2023-05-31', ''),
(27, '2023-05-31', ''),
(28, '2023-05-31', ''),
(29, '2023-05-31', ''),
(30, '2023-05-31', ''),
(31, '2023-05-31', ''),
(32, '2023-05-31', ''),
(33, '2023-06-01', ''),
(34, '2023-06-02', ''),
(35, '2023-06-02', ''),
(36, '2023-06-02', ''),
(37, '2023-05-31', ''),
(38, '2023-06-01', ''),
(39, '2023-06-02', ''),
(40, '0000-00-00', 'd100'),
(41, '0000-00-00', 'd100'),
(42, '0000-00-00', 'd100'),
(43, '2024-02-11', 'd100'),
(44, '2024-03-14', 'p118'),
(45, '2024-03-14', 'p118'),
(46, '2024-03-14', 'p118'),
(47, '2024-05-14', 'd100'),
(48, '2024-05-14', 'd100'),
(49, '2024-05-14', 'd100'),
(50, '2024-05-14', 'd100'),
(51, '2024-05-14', 'd100'),
(52, '2024-05-14', 'd100'),
(53, '2024-05-14', 'd100'),
(54, '2024-05-14', 'd100'),
(55, '2024-05-14', 'd100'),
(56, '2024-05-14', 'd100'),
(57, '2024-05-14', 'd100'),
(58, '2024-05-14', 'd100'),
(59, '2024-05-14', 'd100'),
(60, '2024-05-14', 'd100'),
(61, '2024-05-14', 'd100'),
(62, '2024-05-14', 'd100'),
(63, '2024-05-14', 'd100'),
(64, '2024-05-14', 'd100'),
(65, '2024-05-14', 'd100'),
(66, '2024-05-14', 'd100'),
(67, '2024-05-14', 'd100'),
(68, '2024-05-14', 'd100'),
(69, '2024-05-15', 'p118'),
(70, '2024-05-15', 'd100'),
(71, '2024-05-15', 'p118'),
(72, '2024-05-15', 'p118'),
(73, '2024-05-15', 'p118'),
(74, '2024-05-15', 'p118'),
(75, '2024-05-29', 'd100');

-- --------------------------------------------------------

--
-- Estrutura da tabela `noticias_texto`
--

CREATE TABLE `noticias_texto` (
  `id_noticia` int(11) NOT NULL,
  `texto_noticia` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Extraindo dados da tabela `noticias_texto`
--

INSERT INTO `noticias_texto` (`id_noticia`, `texto_noticia`) VALUES
(5, 'Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry\'s standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into electronic typesetting, remaining essentially unchanged. It was popularised in the 1960s with the release of Letraset sheets containing Lorem Ipsum passages, and more recently with desktop publishing software like Aldus PageMaker including versions of Lorem Ipsum.\r\n\r\nLorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry\'s standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into electronic typesetting, remaining essentially unchanged. It was popularised in the 1960s with the release of Letraset sheets containing Lorem Ipsum passages, and more recently with desktop publishing software like Aldus PageMaker including versions of Lorem Ipsum.\r\n\r\nLorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry\'s standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into electronic typesetting, remaining essentially unchanged. It was popularised in the 1960s with the release of Letraset sheets containing Lorem Ipsum passages, and more recently with desktop publishing software like Aldus PageMaker including versions of Lorem Ipsum.\r\n\r\nLorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry\'s standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into electronic typesetting, remaining essentially unchanged. It was popularised in the 1960s with the release of Letraset sheets containing Lorem Ipsum passages, and more recently with desktop publishing software like Aldus PageMaker including versions of Lorem Ipsum.'),
(6, 'Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry\'s standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into electronic typesetting, remaining essentially unchanged. It was popularised in the 1960s with the release of Letraset sheets containing Lorem Ipsum passages, and more recently with desktop publishing software like Aldus PageMaker including versions of Lorem Ipsum.\r\n\r\nLorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry\'s standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into electronic typesetting, remaining essentially unchanged. It was popularised in the 1960s with the release of Letraset sheets containing Lorem Ipsum passages, and more recently with desktop publishing software like Aldus PageMaker including versions of Lorem Ipsum.\r\n\r\nLorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry\'s standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into electronic typesetting, remaining essentially unchanged. It was popularised in the 1960s with the release of Letraset sheets containing Lorem Ipsum passages, and more recently with desktop publishing software like Aldus PageMaker including versions of Lorem Ipsum.\r\n\r\nLorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry\'s standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into electronic typesetting, remaining essentially unchanged. It was popularised in the 1960s with the release of Letraset sheets containing Lorem Ipsum passages, and more recently with desktop publishing software like Aldus PageMaker including versions of Lorem Ipsum.'),
(7, 'Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry\'s standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into electronic typesetting, remaining essentially unchanged. It was popularised in the 1960s with the release of Letraset sheets containing Lorem Ipsum passages, and more recently with desktop publishing software like Aldus PageMaker including versions of Lorem Ipsum.\r\n\r\nLorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry\'s standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into electronic typesetting, remaining essentially unchanged. It was popularised in the 1960s with the release of Letraset sheets containing Lorem Ipsum passages, and more recently with desktop publishing software like Aldus PageMaker including versions of Lorem Ipsum.\r\n\r\nLorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry\'s standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into electronic typesetting, remaining essentially unchanged. It was popularised in the 1960s with the release of Letraset sheets containing Lorem Ipsum passages, and more recently with desktop publishing software like Aldus PageMaker including versions of Lorem Ipsum.\r\n\r\nLorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry\'s standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into electronic typesetting, remaining essentially unchanged. It was popularised in the 1960s with the release of Letraset sheets containing Lorem Ipsum passages, and more recently with desktop publishing software like Aldus PageMaker including versions of Lorem Ipsum.'),
(8, 'Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry\'s standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into electronic typesetting, remaining essentially unchanged. It was popularised in the 1960s with the release of Letraset sheets containing Lorem Ipsum passages, and more recently with desktop publishing software like Aldus PageMaker including versions of Lorem Ipsum.\r\n\r\nLorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry\'s standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into electronic typesetting, remaining essentially unchanged. It was popularised in the 1960s with the release of Letraset sheets containing Lorem Ipsum passages, and more recently with desktop publishing software like Aldus PageMaker including versions of Lorem Ipsum.\r\n\r\nLorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry\'s standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into electronic typesetting, remaining essentially unchanged. It was popularised in the 1960s with the release of Letraset sheets containing Lorem Ipsum passages, and more recently with desktop publishing software like Aldus PageMaker including versions of Lorem Ipsum.\r\n\r\nLorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry\'s standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into electronic typesetting, remaining essentially unchanged. It was popularised in the 1960s with the release of Letraset sheets containing Lorem Ipsum passages, and more recently with desktop publishing software like Aldus PageMaker including versions of Lorem Ipsum.'),
(9, 'Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry\'s standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into electronic typesetting, remaining essentially unchanged. It was popularised in the 1960s with the release of Letraset sheets containing Lorem Ipsum passages, and more recently with desktop publishing software like Aldus PageMaker including versions of Lorem Ipsum.\r\n\r\nLorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry\'s standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into electronic typesetting, remaining essentially unchanged. It was popularised in the 1960s with the release of Letraset sheets containing Lorem Ipsum passages, and more recently with desktop publishing software like Aldus PageMaker including versions of Lorem Ipsum.\r\n\r\nLorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry\'s standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into electronic typesetting, remaining essentially unchanged. It was popularised in the 1960s with the release of Letraset sheets containing Lorem Ipsum passages, and more recently with desktop publishing software like Aldus PageMaker including versions of Lorem Ipsum.\r\n\r\nLorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry\'s standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into electronic typesetting, remaining essentially unchanged. It was popularised in the 1960s with the release of Letraset sheets containing Lorem Ipsum passages, and more recently with desktop publishing software like Aldus PageMaker including versions of Lorem Ipsum.'),
(10, 'Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry\'s standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into electronic typesetting, remaining essentially unchanged. It was popularised in the 1960s with the release of Letraset sheets containing Lorem Ipsum passages, and more recently with desktop publishing software like Aldus PageMaker including versions of Lorem Ipsum.\r\n\r\nLorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry\'s standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into electronic typesetting, remaining essentially unchanged. It was popularised in the 1960s with the release of Letraset sheets containing Lorem Ipsum passages, and more recently with desktop publishing software like Aldus PageMaker including versions of Lorem Ipsum.\r\n\r\nLorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry\'s standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into electronic typesetting, remaining essentially unchanged. It was popularised in the 1960s with the release of Letraset sheets containing Lorem Ipsum passages, and more recently with desktop publishing software like Aldus PageMaker including versions of Lorem Ipsum.\r\n\r\nLorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry\'s standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into electronic typesetting, remaining essentially unchanged. It was popularised in the 1960s with the release of Letraset sheets containing Lorem Ipsum passages, and more recently with desktop publishing software like Aldus PageMaker including versions of Lorem Ipsum.'),
(11, 'Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry\'s standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into electronic typesetting, remaining essentially unchanged. It was popularised in the 1960s with the release of Letraset sheets containing Lorem Ipsum passages, and more recently with desktop publishing software like Aldus PageMaker including versions of Lorem Ipsum.\r\n\r\nLorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry\'s standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into electronic typesetting, remaining essentially unchanged. It was popularised in the 1960s with the release of Letraset sheets containing Lorem Ipsum passages, and more recently with desktop publishing software like Aldus PageMaker including versions of Lorem Ipsum.\r\n\r\nLorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry\'s standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into electronic typesetting, remaining essentially unchanged. It was popularised in the 1960s with the release of Letraset sheets containing Lorem Ipsum passages, and more recently with desktop publishing software like Aldus PageMaker including versions of Lorem Ipsum.\r\n\r\nLorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry\'s standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into electronic typesetting, remaining essentially unchanged. It was popularised in the 1960s with the release of Letraset sheets containing Lorem Ipsum passages, and more recently with desktop publishing software like Aldus PageMaker including versions of Lorem Ipsum.'),
(12, 'Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry\'s standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into electronic typesetting, remaining essentially unchanged. It was popularised in the 1960s with the release of Letraset sheets containing Lorem Ipsum passages, and more recently with desktop publishing software like Aldus PageMaker including versions of Lorem Ipsum.\r\n\r\nLorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry\'s standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into electronic typesetting, remaining essentially unchanged. It was popularised in the 1960s with the release of Letraset sheets containing Lorem Ipsum passages, and more recently with desktop publishing software like Aldus PageMaker including versions of Lorem Ipsum.\r\n\r\nLorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry\'s standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into electronic typesetting, remaining essentially unchanged. It was popularised in the 1960s with the release of Letraset sheets containing Lorem Ipsum passages, and more recently with desktop publishing software like Aldus PageMaker including versions of Lorem Ipsum.\r\n\r\nLorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry\'s standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into electronic typesetting, remaining essentially unchanged. It was popularised in the 1960s with the release of Letraset sheets containing Lorem Ipsum passages, and more recently with desktop publishing software like Aldus PageMaker including versions of Lorem Ipsum.'),
(13, 'Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry\'s standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into electronic typesetting, remaining essentially unchanged. It was popularised in the 1960s with the release of Letraset sheets containing Lorem Ipsum passages, and more recently with desktop publishing software like Aldus PageMaker including versions of Lorem Ipsum.\r\n\r\nLorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry\'s standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into electronic typesetting, remaining essentially unchanged. It was popularised in the 1960s with the release of Letraset sheets containing Lorem Ipsum passages, and more recently with desktop publishing software like Aldus PageMaker including versions of Lorem Ipsum.\r\n\r\nLorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry\'s standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into electronic typesetting, remaining essentially unchanged. It was popularised in the 1960s with the release of Letraset sheets containing Lorem Ipsum passages, and more recently with desktop publishing software like Aldus PageMaker including versions of Lorem Ipsum.\r\n\r\nLorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry\'s standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into electronic typesetting, remaining essentially unchanged. It was popularised in the 1960s with the release of Letraset sheets containing Lorem Ipsum passages, and more recently with desktop publishing software like Aldus PageMaker including versions of Lorem Ipsum.'),
(14, 'Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry\'s standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into electronic typesetting, remaining essentially unchanged. It was popularised in the 1960s with the release of Letraset sheets containing Lorem Ipsum passages, and more recently with desktop publishing software like Aldus PageMaker including versions of Lorem Ipsum.\r\n\r\nLorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry\'s standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into electronic typesetting, remaining essentially unchanged. It was popularised in the 1960s with the release of Letraset sheets containing Lorem Ipsum passages, and more recently with desktop publishing software like Aldus PageMaker including versions of Lorem Ipsum.\r\n\r\nLorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry\'s standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into electronic typesetting, remaining essentially unchanged. It was popularised in the 1960s with the release of Letraset sheets containing Lorem Ipsum passages, and more recently with desktop publishing software like Aldus PageMaker including versions of Lorem Ipsum.\r\n\r\nLorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry\'s standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into electronic typesetting, remaining essentially unchanged. It was popularised in the 1960s with the release of Letraset sheets containing Lorem Ipsum passages, and more recently with desktop publishing software like Aldus PageMaker including versions of Lorem Ipsum.'),
(15, 'Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry\'s standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into electronic typesetting, remaining essentially unchanged. It was popularised in the 1960s with the release of Letraset sheets containing Lorem Ipsum passages, and more recently with desktop publishing software like Aldus PageMaker including versions of Lorem Ipsum.\r\n\r\nLorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry\'s standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into electronic typesetting, remaining essentially unchanged. It was popularised in the 1960s with the release of Letraset sheets containing Lorem Ipsum passages, and more recently with desktop publishing software like Aldus PageMaker including versions of Lorem Ipsum.\r\n\r\nLorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry\'s standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into electronic typesetting, remaining essentially unchanged. It was popularised in the 1960s with the release of Letraset sheets containing Lorem Ipsum passages, and more recently with desktop publishing software like Aldus PageMaker including versions of Lorem Ipsum.\r\n\r\nLorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry\'s standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into electronic typesetting, remaining essentially unchanged. It was popularised in the 1960s with the release of Letraset sheets containing Lorem Ipsum passages, and more recently with desktop publishing software like Aldus PageMaker including versions of Lorem Ipsum.'),
(16, 'Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry\'s standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into electronic typesetting, remaining essentially unchanged. It was popularised in the 1960s with the release of Letraset sheets containing Lorem Ipsum passages, and more recently with desktop publishing software like Aldus PageMaker including versions of Lorem Ipsum.\r\n\r\nLorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry\'s standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into electronic typesetting, remaining essentially unchanged. It was popularised in the 1960s with the release of Letraset sheets containing Lorem Ipsum passages, and more recently with desktop publishing software like Aldus PageMaker including versions of Lorem Ipsum.\r\n\r\nLorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry\'s standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into electronic typesetting, remaining essentially unchanged. It was popularised in the 1960s with the release of Letraset sheets containing Lorem Ipsum passages, and more recently with desktop publishing software like Aldus PageMaker including versions of Lorem Ipsum.\r\n\r\nLorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry\'s standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into electronic typesetting, remaining essentially unchanged. It was popularised in the 1960s with the release of Letraset sheets containing Lorem Ipsum passages, and more recently with desktop publishing software like Aldus PageMaker including versions of Lorem Ipsum.'),
(17, 'ðŸ¤© As nossas crianÃ§as sÃ£o as melhores!\r\n\r\nðŸ‘©â€ðŸ« Esta semana fomos tambÃ©m ao JI e EB1 do Carvalhal levar mÃºsica, diretamente da nossa Academia de MÃºsica, com ajuda de alguns professores e alunos/executantes ðŸŽ¶\r\n\r\nðŸ˜ Nunca Ã© demais ver o sorriso das crianÃ§as e a forma como vibram com a mÃºsica, adoramos estar com elas! Esperamos encontrar-nos novamente em breve ðŸ¥³\r\n\r\nðŸ“¸ Registamos aqui alguns destes momentos'),
(18, 'ðŸ¤© As nossas crianÃ§as sÃ£o as melhores!\r\n\r\nðŸ‘©â€ðŸ« Esta semana fomos tambÃ©m ao JI e EB1 do Carvalhal levar mÃºsica, diretamente da nossa Academia de MÃºsica, com ajuda de alguns professores e alunos/executantes ðŸŽ¶\r\n\r\nðŸ˜ Nunca Ã© demais ver o sorriso das crianÃ§as e a forma como vibram com a mÃºsica, adoramos estar com elas! Esperamos encontrar-nos novamente em breve ðŸ¥³\r\n\r\nðŸ“¸ Registamos aqui alguns destes momentos'),
(19, 'ðŸ¤© As nossas crianÃ§as sÃ£o as melhores!\r\n\r\nðŸ‘©â€ðŸ« Esta semana fomos tambÃ©m ao JI e EB1 do Carvalhal levar mÃºsica, diretamente da nossa Academia de MÃºsica, com ajuda de alguns professores e alunos/executantes ðŸŽ¶\r\n\r\nðŸ˜ Nunca Ã© demais ver o sorriso das crianÃ§as e a forma como vibram com a mÃºsica, adoramos estar com elas! Esperamos encontrar-nos novamente em breve ðŸ¥³\r\n\r\nðŸ“¸ Registamos aqui alguns destes momentos'),
(20, 'ðŸ¤© As nossas crianÃ§as sÃ£o as melhores!\r\n\r\nðŸ‘©â€ðŸ« Esta semana fomos tambÃ©m ao JI e EB1 do Carvalhal levar mÃºsica, diretamente da nossa Academia de MÃºsica, com ajuda de alguns professores e alunos/executantes ðŸŽ¶\r\n\r\nðŸ˜ Nunca Ã© demais ver o sorriso das crianÃ§as e a forma como vibram com a mÃºsica, adoramos estar com elas! Esperamos encontrar-nos novamente em breve ðŸ¥³\r\n\r\nðŸ“¸ Registamos aqui alguns destes momentos'),
(21, 'EspetÃ¡culo de ComÃ©dia, integrado nas Noites de ComÃ©dia do Grupo Musical Estrela de Argoncilhe, desta vez com JoÃ£o Dantas e ZÃ© Pedro Rodrigues. Bilhete em desconto atÃ© 26 de Agosto.\r\n\r\n<a href=\"https://estreladeargoncilhe.bol.pt/Comprar/Bilhetes/124317-joao_dantas_e_ze_pedro_rodrigues_noites_de_comedia_gmea-estrela_de_argoncilhe/\">Podes adquirir aqui! </a>'),
(22, 'EspetÃ¡culo de ComÃ©dia, integrado nas Noites de ComÃ©dia do Grupo Musical Estrela de Argoncilhe, desta vez com JoÃ£o Dantas e ZÃ© Pedro Rodrigues. Bilhete em desconto atÃ© 26 de Agosto.\r\n\r\n<a href=\"https://estreladeargoncilhe.bol.pt/Comprar/Bilhetes/124317-joao_dantas_e_ze_pedro_rodrigues_noites_de_comedia_gmea-estrela_de_argoncilhe/\">Podes adquirir aqui! </a>'),
(23, 'EspetÃ¡culo de ComÃ©dia, integrado nas Noites de ComÃ©dia do Grupo Musical Estrela de Argoncilhe, desta vez com JoÃ£o Dantas e ZÃ© Pedro Rodrigues. Bilhete em desconto atÃ© 26 de Agosto.\r\n\r\n<a href=\"https://estreladeargoncilhe.bol.pt/Comprar/Bilhetes/124317-joao_dantas_e_ze_pedro_rodrigues_noites_de_comedia_gmea-estrela_de_argoncilhe/\">Podes adquirir aqui! </a>'),
(24, 'EspetÃ¡culo de ComÃ©dia, integrado nas Noites de ComÃ©dia do Grupo Musical Estrela de Argoncilhe, desta vez com JoÃ£o Dantas e ZÃ© Pedro Rodrigues. Bilhete em desconto atÃ© 26 de Agosto.\r\n\r\n<a href=\"https://estreladeargoncilhe.bol.pt/Comprar/Bilhetes/124317-joao_dantas_e_ze_pedro_rodrigues_noites_de_comedia_gmea-estrela_de_argoncilhe/\">Podes adquirir aqui! </a>'),
(25, 'EspetÃ¡culo de ComÃ©dia, integrado nas Noites de ComÃ©dia do Grupo Musical Estrela de Argoncilhe, desta vez com JoÃ£o Dantas e ZÃ© Pedro Rodrigues. Bilhete em desconto atÃ© 26 de Agosto.\r\n\r\n<a href=\"https://estreladeargoncilhe.bol.pt/Comprar/Bilhetes/124317-joao_dantas_e_ze_pedro_rodrigues_noites_de_comedia_gmea-estrela_de_argoncilhe/\">Podes adquirir aqui! </a>'),
(26, 'EspetÃ¡culo de ComÃ©dia, integrado nas Noites de ComÃ©dia do Grupo Musical Estrela de Argoncilhe, desta vez com JoÃ£o Dantas e ZÃ© Pedro Rodrigues. Bilhete em desconto atÃ© 26 de Agosto.\r\n\r\n<a href=\"https://estreladeargoncilhe.bol.pt/Comprar/Bilhetes/124317-joao_dantas_e_ze_pedro_rodrigues_noites_de_comedia_gmea-estrela_de_argoncilhe/\">Podes adquirir aqui! </a>'),
(27, 'EspetÃ¡culo de ComÃ©dia, integrado nas Noites de ComÃ©dia do Grupo Musical Estrela de Argoncilhe, desta vez com JoÃ£o Dantas e ZÃ© Pedro Rodrigues. Bilhete em desconto atÃ© 26 de Agosto.\r\n\r\n<a href=\"https://estreladeargoncilhe.bol.pt/Comprar/Bilhetes/124317-joao_dantas_e_ze_pedro_rodrigues_noites_de_comedia_gmea-estrela_de_argoncilhe/\">Podes adquirir aqui! </a>'),
(28, 'EspetÃ¡culo de ComÃ©dia, integrado nas Noites de ComÃ©dia do Grupo Musical Estrela de Argoncilhe, desta vez com JoÃ£o Dantas e ZÃ© Pedro Rodrigues. Bilhete em desconto atÃ© 26 de Agosto.\r\n\r\n<a href=\"https://estreladeargoncilhe.bol.pt/Comprar/Bilhetes/124317-joao_dantas_e_ze_pedro_rodrigues_noites_de_comedia_gmea-estrela_de_argoncilhe/\">Podes adquirir aqui! </a>'),
(29, 'EspetÃ¡culo de ComÃ©dia, integrado nas Noites de ComÃ©dia do Grupo Musical Estrela de Argoncilhe, desta vez com JoÃ£o Dantas e ZÃ© Pedro Rodrigues. Bilhete em desconto atÃ© 26 de Agosto.\r\n\r\n<a href=\"https://estreladeargoncilhe.bol.pt/Comprar/Bilhetes/124317-joao_dantas_e_ze_pedro_rodrigues_noites_de_comedia_gmea-estrela_de_argoncilhe/\">Podes adquirir aqui! </a>'),
(30, 'EspetÃ¡culo de ComÃ©dia, integrado nas Noites de ComÃ©dia do Grupo Musical Estrela de Argoncilhe, desta vez com JoÃ£o Dantas e ZÃ© Pedro Rodrigues. Bilhete em desconto atÃ© 26 de Agosto.\r\n\r\n<a href=\"https://estreladeargoncilhe.bol.pt/Comprar/Bilhetes/124317-joao_dantas_e_ze_pedro_rodrigues_noites_de_comedia_gmea-estrela_de_argoncilhe/\">Podes adquirir aqui! </a>'),
(31, 'EspetÃ¡culo de ComÃ©dia, integrado nas Noites de ComÃ©dia do Grupo Musical Estrela de Argoncilhe, desta vez com JoÃ£o Dantas e ZÃ© Pedro Rodrigues. Bilhete em desconto atÃ© 26 de Agosto.\r\n\r\n<a href=\"https://estreladeargoncilhe.bol.pt/Comprar/Bilhetes/124317-joao_dantas_e_ze_pedro_rodrigues_noites_de_comedia_gmea-estrela_de_argoncilhe/\">Podes adquirir aqui! </a>'),
(32, 'EspetÃ¡culo de ComÃ©dia, integrado nas Noites de ComÃ©dia do Grupo Musical Estrela de Argoncilhe, desta vez com JoÃ£o Dantas e ZÃ© Pedro Rodrigues. Bilhete em desconto atÃ© 26 de Agosto.\r\n\r\n<a href=\"https://estreladeargoncilhe.bol.pt/Comprar/Bilhetes/124317-joao_dantas_e_ze_pedro_rodrigues_noites_de_comedia_gmea-estrela_de_argoncilhe/\">Podes adquirir aqui! </a>'),
(33, 'ðŸ¤© As nossas crianÃ§as sÃ£o as melhores!\r\n\r\nðŸ‘©â€ðŸ« Esta semana fomos tambÃ©m ao JI e EB1 do Carvalhal levar mÃºsica, diretamente da nossa Academia de MÃºsica, com ajuda de alguns professores e alunos/executantes ðŸŽ¶\r\n\r\nðŸ˜ Nunca Ã© demais ver o sorriso das crianÃ§as e a forma como vibram com a mÃºsica, adoramos estar com elas! Esperamos encontrar-nos novamente em breve ðŸ¥³\r\n\r\nðŸ“¸ Registamos aqui alguns destes momentos'),
(34, 'sasa'),
(35, 'sasa'),
(36, 'sasa'),
(37, '🎙️ Os The Smokestackers estiveram connosco no passado dia 20 de Maio, no nosso Café Convívio 😎 <br><br>\r\n🌟 Que banda espetacular e, sem dúvida, merecedora da distinção de melhor banda de blues portuguesa. Agradecemos a oportunidade de terem partilhado esta noite connosco e desejamos a melhor sorte para o concurso europeu que vão participar no próximo mês! 🍀<br><br>\r\n🤩 Um agradecimento ao nosso público, ao nosso staff do bar, técnicos de som e luz pela magnífica noite!<br><br>\r\n🏗 Esta foi a última noite de música ao vivo antes da nossa paragem de verão para fazer algumas melhorias no espaço.<br><br>\r\n📅 Em breve estarão as novas datas de música ao vivo e comédia anunciadas e à venda. Os bilhetes estarão disponíveis <a href=\"https://estreladeargoncilhe.bol.pt\">aqui!</a><br><br>\r\n🙏 @fsom.eventpartners @joanasousadesign<br><br>\r\n\r\n#gmea #gmeamúsica #gmeamusicaaovivo #argoncilhe #música #espetáculos'),
(38, '🎵 Apresentamos o nosso cartaz da oferta educativa, repleto de oportunidades emocionantes para todos os amantes da música. 🎶 Seja qual for o teu instrumento de eleição ou o teu estilo musical preferido, temos algo especial à tua espera! 🎹🎸🎙️<br><br>\r\n✨ Aprende com os melhores professores, que são músicos talentosos e apaixonados pelo ensino. Eles vão guiar-te, inspirar-te e ajudar-te a desenvolver o teu talento musical ao máximo. 🎵🎶<br><br>\r\n🌟 Quer estejas a dar os primeiros passos no mundo da música ou já tenhas alguma experiência, temos opções para todas as idades e níveis de habilidade. Desde aulas individuais a workshops em grupo, há algo para todos!<br><br>\r\n📆 A primeira fase de inscrições está aberta até 30 de Junho! 🧑‍🏫🎷🎺 🌟 Deixa a música guiar-te numa jornada emocionante e descobre o teu verdadeiro ritmo!<br><br>\r\n#AcademiaDeMúsica #OfertaEducativa #AulasDeMúsica #Música #InscriçõesAbertas #DescobreOTeuRitmo\r\n#gmea #bsa'),
(39, 'A venda de bilhetes para o próximo evento no nosso espaço já abriu! <br><br>\r\nTeremos uma noite de comédia com mais dois humoristas fantásticos: João Dantas e Zé Pedro Sousa! <br><br>\r\nEles prometem trazer muitas gargalhadas numa noite que promete! <br><br>\r\nPodes adquirir os teus bilhetes <a href=\"https://estreladeargoncilhe.bol.pt\">aqui!</a>'),
(40, 'Olá!<br/>É basicamente isto.'),
(41, 'Olá!<br>Adeus.'),
(42, 'Olá.'),
(43, 'Adeus!aaafesds Mmamama <br/> Jajjaj <br/> ahofasudg'),
(44, 'Anunciamos os vencedores do sorteio de rifas promovido pela nossa instituição!<br/><br/>\r\n\r\nAos vendedores, os nossos parabéns! Os prémios podem ser levantados na nossa secretaria!<br/><br/>\r\n\r\nObrigado a todos pela contribuição 😊'),
(45, '🔙 Neste último domingo, dia 3 de março, tivemos mais uma sessão dedicada aos mais pequeninos, desta vez feita na nossa sede!<br/><br/>\r\n\r\n👶🏻 Foi uma sessão interativa chamada \"Sessão de música em Família\", orientada pelas professoras Joana Neves e Tatiana Leal!<br/><br/>\r\n\r\n⭐ Ficam aqui alguns registos desse dia! 📷'),
(46, '⭐ Formação de Música & Som<br/><br/>\r\n\r\n🗓️ Dia 29 de março, iremos ter uma formação de Música e Som, dinamizada pelo orientador Paulo Ramos!<br/><br/>\r\n\r\n⏰ Realizar-se-á entre as 10h e as 18h, com um concerto às 22h para os nossos formandos aplicarem os conhecimentos adquiridos!<br/><br/>\r\n\r\n💭 O objetivo desta formação passa por dotar tecnicamente e teoricamente os formandos para a concretização de eventos ao vivo, assim como o registo dos mesmos através de abordagens tanto teóricas como práticas.<br/>\r\nRelativamente à parte prática, irá ser abordado as ferramentas passíveis de serem usadas, tais como Transdutores (microfones, colunas, mesas de mistura etc), Daw`s, FOH, Monitores e assim por diante.<br/><br/>\r\n\r\n📝 As inscrições já estão abertas. Podem ser feitas em <a href=\"https://forms.gle/ZyNTKd1n1VfZLJuQ9\">Formulário de Inscrição</a> ou na secretaria do nosso grupo!<br/><br/>\r\n\r\nContamos contigo?<br/>\r\nAté já 😉'),
(47, 'aa'),
(48, ''),
(49, ''),
(50, ''),
(51, ''),
(52, '<p>AAAAA</p>'),
(53, ''),
(54, ''),
(55, ''),
(56, ''),
(57, ''),
(58, '<p>aaaaa</p>'),
(59, '<p>Na passada sexta-feira, dia 2<a href=\"cic.pt\" target=\"_blank\">9 de març</a>o, realizou-se, sob tutela do orientador Paulo Ramos a formação \"Som &amp; Luz\", que reuniu alunos e rofessores da Academia de Música do GMEA e pessoas externas.</p><p>Ficam aqui alguns registos des<strong>se d</strong>ia!</p>'),
(60, ''),
(61, ''),
(62, ''),
(63, ''),
(64, '<p>AAA</p><p><br></p><p><strong>AAAA</strong></p><p><br></p><p><strong><em>AAA</em></strong></p><p><br></p><p><strong><em><u>AAAAA</u></em></strong></p><p><br></p><p><a href=\"https://www.cic.pt/\" target=\"_blank\">aaa</a></p>'),
(65, ''),
(66, ''),
(67, ''),
(68, '<p>Na passada sexta-feira, dia 2<a href=\"cic.pt\" target=\"_blank\">9 de març</a>o, realizou-se, sob tutela do orientador Paulo Ramos a formação \"Som &amp; Luz\", que reuniu alunos e rofessores da Academia de Música do GMEA e pessoas externas.</p><p>Ficam aqui alguns registos des<strong>se d</strong>ia!</p><p><br></p><p>AAAAAAA</p><p><br></p><p><u>Boa tarde!</u></p>'),
(69, '<p><img src=\"https://static.xx.fbcdn.net/images/emoji.php/v9/tb5/1/16/1f519.png\" alt=\"🔙\" height=\"16\" width=\"16\"> No passado dia 4 de Maio, os alunos da classe de clarinete e flauta deram um concerto na sede da Cooperativa Arthenon, em virtude da parceria estabelecida com a Academia de Música do Grupo Musical Estrela de Argoncilhe!</p><p><br></p><p><img src=\"https://static.xx.fbcdn.net/images/emoji.php/v9/tb4/1/16/2b50.png\" alt=\"⭐\" height=\"16\" width=\"16\"> Ficam aqui alguns registos desse dia!</p>'),
(70, '<p><img src=\"https://static.xx.fbcdn.net/images/emoji.php/v9/tb5/1/16/1f519.png\" alt=\"🔙\" height=\"16\" width=\"16\"> No passado dia 25 de Abril, os alunos da classe de canto deram um concerto na sede da Cooperativa Arthenon, em virtude da parceria estabelecida com a Academia de Música do Grupo Musical Estrela de Argoncilhe.</p><p><br></p><p><img src=\"https://static.xx.fbcdn.net/images/emoji.php/v9/tb4/1/16/2b50.png\" alt=\"⭐\" height=\"16\" width=\"16\"> Ficam aqui alguns registos desse dia!</p>'),
(71, '<p><img src=\"https://static.xx.fbcdn.net/images/emoji.php/v9/t5c/1/16/1f5d3.png\" alt=\"🗓️\" height=\"16\" width=\"16\"> Dia 21 de Abril, entre as 10h e as 11h30 teremos na nossa academia de música o Workshop \"<strong>Soundpaiting</strong>\", dinamizado pela orientadora Joana Carvalhas!</p><p><br></p><p><img src=\"https://static.xx.fbcdn.net/images/emoji.php/v9/tcc/1/16/1f3bc.png\" alt=\"🎼\" height=\"16\" width=\"16\"> Esta é uma atividade acessível a todos, independentemente da idade ou nível técnico do instrumento, que permite desenvolver ferramentas a nível da improvisação e criatividade.</p><p><br></p><p><img src=\"https://static.xx.fbcdn.net/images/emoji.php/v9/t4d/1/16/1f4de.png\" alt=\"📞\" height=\"16\" width=\"16\"> Entra em contacto connosco para garantires já o teu lugar!</p><p><br></p><p><img src=\"https://static.xx.fbcdn.net/images/emoji.php/v9/tcc/1/16/1f4dd.png\" alt=\"📝\" height=\"16\" width=\"16\"> Podes também inscrever-te preenchendo este formulário: <a href=\"https://bit.ly/soundpaintinggmea\" target=\"_blank\" style=\"background-color: transparent; color: var(--blue-link);\">https://bit.ly/soundpaintinggmea</a>  ou lendo o QR Code presente no cartaz.</p><p><br></p><p>Contamos contigo?</p><p>Até já <img src=\"https://static.xx.fbcdn.net/images/emoji.php/v9/t57/1/16/1f609.png\" alt=\"😉\" height=\"16\" width=\"16\"></p>'),
(72, '<p><img src=\"https://static.xx.fbcdn.net/images/emoji.php/v9/t5c/1/16/1f5d3.png\" alt=\"🗓️\" height=\"16\" width=\"16\"> Dia 13 de Abril, entre as 10h30 e as 13h teremos na nossa academia de música o Workshop \"<strong>Circle Singing</strong>\", orientado pelo professor João Belchior</p><p><br></p><p><img src=\"https://static.xx.fbcdn.net/images/emoji.php/v9/t7e/1/16/1f3a4.png\" alt=\"🎤\" height=\"16\" width=\"16\"> Esta é uma actividade aberta a toda a gente que tenha qualquer tipo de relação com o canto e/ou improvisação.</p><p><br></p><p><img src=\"https://static.xx.fbcdn.net/images/emoji.php/v9/t4d/1/16/1f4de.png\" alt=\"📞\" height=\"16\" width=\"16\"> Entra em contacto connosco para garantires já o teu lugar!</p><p><br></p><p><img src=\"https://static.xx.fbcdn.net/images/emoji.php/v9/tcc/1/16/1f4dd.png\" alt=\"📝\" height=\"16\" width=\"16\"> Podes também inscrever-te preenchendo este formulário: <a href=\"https://l.facebook.com/l.php?u=https%3A%2F%2Fbit.ly%2Fcirclesinginggmea%3Ffbclid%3DIwZXh0bgNhZW0CMTAAAR327W0zNV4PJeIWpFqn_5DKoDHGQvQ3DV2CxTTbXvuHdh64eZ4is9OMDMM_aem_AamusrVomQ1Zk35_dk4aIoOEXK6tqw27mfh3NtVnkXxLKNN2vPyEuX7NNZGo9NL_Ic9EN048cFBgCNNj6fYmgjDU&amp;h=AT0JXH_t_9QWHSziQl4-6z9ZoqddnMu_Ua7eaA6ODFnEQr3EuMXqE0lY3dKKJG7s-xD7IAToqKtrEsFV4i2P1GZvEIhQ2FH7jxtJy-RqWgBrLDNXXWFqYKmxPxLszIjv_02x&amp;__tn__=-UK-R&amp;c[0]=AT0tj2yc_U-GxDLYi_HY_rGZMlUqZGG5GDOEm92V0C3z_FxQh3CamKHhFkS5aQkZzklV5gpk6m5Et9jbXFD9bWOEjbal9CIgEZOKm2Iuba0uPgrwLx5XFfza-jJedQpXjIKX1ubSdR7_lKdy-2lbs5Xi6_0p3yml6hoMs3eof_-D4lZJgvHYOLXVJvjtyyUI81SUlOhAgDE5eW_LmcBUV66pBwvjsRlWtTV_nEkZYg\" target=\"_blank\" style=\"background-color: transparent; color: var(--blue-link);\">https://bit.ly/circlesinginggmea</a> ou lendo o QR Code presente no cartaz.</p><p><br></p><p><img src=\"https://static.xx.fbcdn.net/images/emoji.php/v9/t5d/1/16/1f4f7.png\" alt=\"📷\" height=\"16\" width=\"16\"> Visita os comentários para veres um pouco de como funcionará este workshop!</p><p><br></p><p>Contamos contigo?</p><p>Até já <img src=\"https://static.xx.fbcdn.net/images/emoji.php/v9/t57/1/16/1f609.png\" alt=\"😉\" height=\"16\" width=\"16\"></p>'),
(73, '<p><span style=\"background-color: rgb(36, 37, 38); color: rgb(228, 230, 235);\"><img src=\"https://static.xx.fbcdn.net/images/emoji.php/v9/t5c/1/16/1f5d3.png\" alt=\"🗓️\" height=\"16\" width=\"16\">&nbsp;Dia 29 de março, iremos ter uma formação de Música e Som, dinamizada pelo orientador Paulo Ramos!</span></p><p><br></p><p><span style=\"background-color: rgb(36, 37, 38); color: rgb(228, 230, 235);\"><img src=\"https://static.xx.fbcdn.net/images/emoji.php/v9/t34/1/16/23f0.png\" alt=\"⏰\" height=\"16\" width=\"16\">&nbsp;Realizar-se-á entre as 10h e as 18h, com um concerto às 22h para os nossos formandos aplicarem os conhecimentos adquiridos!</span></p><p><br></p><p><span style=\"background-color: rgb(36, 37, 38); color: rgb(228, 230, 235);\"><img src=\"https://static.xx.fbcdn.net/images/emoji.php/v9/tef/1/16/1f4ad.png\" alt=\"💭\" height=\"16\" width=\"16\">&nbsp;O objetivo desta formação passa por dotar tecnicamente e teoricamente os formandos para a concretização de eventos ao vivo, assim como o registo dos mesmos através de abordagens tanto teóricas como práticas.</span></p><p><span style=\"background-color: rgb(36, 37, 38); color: rgb(228, 230, 235);\">Relativamente à parte prática, irá ser abordado as ferramentas passíveis de serem usadas, tais como Transdutores (microfones, colunas, mesas de mistura etc), Daw`s, FOH, Monitores e assim por diante.</span></p><p><br></p><p><span style=\"background-color: rgb(36, 37, 38); color: rgb(228, 230, 235);\"><img src=\"https://static.xx.fbcdn.net/images/emoji.php/v9/tcc/1/16/1f4dd.png\" alt=\"📝\" height=\"16\" width=\"16\">&nbsp;As inscrições já estão abertas. Podem ser feitas em&nbsp;</span><a href=\"https://forms.gle/ZyNTKd1n1VfZLJuQ9?fbclid=IwZXh0bgNhZW0CMTAAAR2nVRyxDq0rASfHs4s-R4ZLz0RUJJRyXSVzgZ4lFuCAeBk-w4_8x8Arsnc_aem_Aamy6SE1TRNYFpw_3I367MOyt-P4QhNrz2j9fsZZUR3c5z_TgVpkIDbCOLeCPgXhLyfY-1ji2ddrUgmM5EYg2ATj\" target=\"_blank\" style=\"background-color: transparent; color: var(--blue-link);\">forms.gle/ZyNTKd1n1VfZLJuQ9</a><span style=\"background-color: rgb(36, 37, 38); color: rgb(228, 230, 235);\">&nbsp;ou na secretaria do nosso grupo!</span></p><p><br></p><p><span style=\"background-color: rgb(36, 37, 38); color: rgb(228, 230, 235);\">Contamos contigo?</span></p><p><span style=\"background-color: rgb(36, 37, 38); color: rgb(228, 230, 235);\">Até já&nbsp;<img src=\"https://static.xx.fbcdn.net/images/emoji.php/v9/t57/1/16/1f609.png\" alt=\"😉\" height=\"16\" width=\"16\"></span></p><p><br></p>'),
(74, '<p><img src=\"https://static.xx.fbcdn.net/images/emoji.php/v9/tab/1/16/1f476.png\" alt=\"👶\" height=\"16\" width=\"16\"> No próximo dia 3 de março iremos ter mais um Workshop orientado para os mais pequeninos (entre os 6 meses e os 5 anos)!</p><p><br></p><p><img src=\"https://static.xx.fbcdn.net/images/emoji.php/v9/tfa/1/16/231a.png\" alt=\"⌚\" height=\"16\" width=\"16\"> Realizar-se-á entre as 10h30 e as 11h30, na sede do Grupo Musical Estrela de Argoncilhe.</p><p><br></p><p><img src=\"https://static.xx.fbcdn.net/images/emoji.php/v9/t51/1/16/2714.png\" alt=\"✔️\" height=\"16\" width=\"16\"> Esta \"Sessão de Música em Família\" é ideal para que as crianças possam ter os primeiros contactos com a música e com as suas mais diversas vertentes!</p><p><br></p><p><img src=\"https://static.xx.fbcdn.net/images/emoji.php/v9/tcc/1/16/1f4dd.png\" alt=\"📝\" height=\"16\" width=\"16\"> As inscrições já estão abertas e têm o custo de 10€ por participante, podendo cada criança ser acompanhada por até 2 adultos. As inscrições podem ser feitas apenas em<a href=\"https://bit.ly/sessaomusicaemfamilia?fbclid=IwZXh0bgNhZW0CMTAAAR2fYxI3ge8h9-gilEmqUr2YfWHJPtAUwY0719l9BHTRKxc7v3daGNjfAHg_aem_Aal-NaMpIeevLFL4rLXdNV_9VeDyhpY-fAzQH4kALmsO_ZUH5agKQXNUGaAADsopyBkcnpwFDlXUhK6jEkHEgQ3P\" target=\"_blank\" style=\"color: var(--blue-link); background-color: transparent;\"> bit.ly/sessaomusicaemfamili</a>a ou na secretaria do nosso grupo!</p><p><br></p><p><img src=\"https://static.xx.fbcdn.net/images/emoji.php/v9/t94/1/16/1f469_200d_1f3eb.png\" alt=\"👩‍🏫\" height=\"16\" width=\"16\"> Este workshop será orientado pelas professoras Tatiana Leal e Joana Neves. A professora Tatiana foi aluna na Academia de Música do GMEA, tem mestrado em Ensino de Música e é, atualmente, professora na empresa InTempo e no Estúdio de Música de Gaia. A professora Joana é, também, ex-Aluna da Academia de Música do GMEA e tem mestrado em Ensino de Música, sendo, atualmente, professora na própria Academia de Música do GMEA e no Conservatório Terras de Santa Maria!</p>'),
(75, '<p>Concerto no passado sábado.</p>');

-- --------------------------------------------------------

--
-- Estrutura da tabela `noticias_titulo`
--

CREATE TABLE `noticias_titulo` (
  `id_noticia` int(11) NOT NULL,
  `titulo_noticia` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Extraindo dados da tabela `noticias_titulo`
--

INSERT INTO `noticias_titulo` (`id_noticia`, `titulo_noticia`) VALUES
(5, 'LOREM IPSUM'),
(6, 'LOREM IPSUM'),
(7, 'LOREM IPSUM'),
(8, 'LOREM IPSUM'),
(9, 'LOREM IPSUM'),
(10, 'LOREM IPSUM'),
(11, 'LOREM IPSUM'),
(12, 'LOREM IPSUM'),
(13, 'LOREM IPSUM'),
(14, 'LOREM IPSUM'),
(15, 'LOREM IPSUM'),
(16, 'LOREM IPSUM'),
(17, 'O GMEA VAI Ã€S ESCOLAS'),
(18, 'O GMEA VAI Ã€S ESCOLAS'),
(19, 'O GMEA VAI Ã€S ESCOLAS'),
(20, 'O GMEA VAI Ã€S ESCOLAS'),
(21, 'Bilhetes para a \'Noite de ComÃ©dia\' de Setembro jÃ¡ disponÃ­veis!'),
(22, 'Bilhetes para a \'Noite de ComÃ©dia\' de Setembro jÃ¡ disponÃ­veis!'),
(23, 'Bilhetes para a \'Noite de ComÃ©dia\' de Setembro jÃ¡ disponÃ­veis!'),
(24, 'Bilhetes para a \'Noite de ComÃ©dia\' de Setembro jÃ¡ disponÃ­veis!'),
(25, 'Bilhetes para a \'Noite de ComÃ©dia\' de Setembro jÃ¡ disponÃ­veis!'),
(26, 'Bilhetes para a \'Noite de ComÃ©dia\' de Setembro jÃ¡ disponÃ­veis!'),
(27, 'Bilhetes para a \'Noite de ComÃ©dia\' de Setembro jÃ¡ disponÃ­veis!'),
(28, 'Bilhetes para a \'Noite de ComÃ©dia\' de Setembro jÃ¡ disponÃ­veis!'),
(29, 'Bilhetes para a \'Noite de ComÃ©dia\' de Setembro jÃ¡ disponÃ­veis!'),
(30, 'Bilhetes para a \'Noite de ComÃ©dia\' de Setembro jÃ¡ disponÃ­veis!'),
(31, 'Bilhetes para a \'Noite de ComÃ©dia\' de Setembro jÃ¡ disponÃ­veis!'),
(32, 'Bilhetes para a \'Noite de ComÃ©dia\' de Setembro jÃ¡ disponÃ­veis!'),
(33, 'O GMEA VAI Ã€S ESCOLAS'),
(34, 'já às 4 mãe'),
(35, 'já às 4 mãe'),
(36, 'já às 4 mãe'),
(37, 'Os The Smokestackers vieram ao GMEA!'),
(38, '🎶 Descobre o teu ritmo na nossa Academia de Música! 🎵'),
(39, 'Bilhetes para a \'Noite de Comédia\' de Setembro já disponíveis!'),
(5, 'LOREM IPSUM'),
(6, 'LOREM IPSUM'),
(7, 'LOREM IPSUM'),
(8, 'LOREM IPSUM'),
(9, 'LOREM IPSUM'),
(10, 'LOREM IPSUM'),
(11, 'LOREM IPSUM'),
(12, 'LOREM IPSUM'),
(13, 'LOREM IPSUM'),
(14, 'LOREM IPSUM'),
(15, 'LOREM IPSUM'),
(16, 'LOREM IPSUM'),
(17, 'O GMEA VAI Ã€S ESCOLAS'),
(18, 'O GMEA VAI Ã€S ESCOLAS'),
(19, 'O GMEA VAI Ã€S ESCOLAS'),
(20, 'O GMEA VAI Ã€S ESCOLAS'),
(21, 'Bilhetes para a \'Noite de ComÃ©dia\' de Setembro jÃ¡ disponÃ­veis!'),
(22, 'Bilhetes para a \'Noite de ComÃ©dia\' de Setembro jÃ¡ disponÃ­veis!'),
(23, 'Bilhetes para a \'Noite de ComÃ©dia\' de Setembro jÃ¡ disponÃ­veis!'),
(24, 'Bilhetes para a \'Noite de ComÃ©dia\' de Setembro jÃ¡ disponÃ­veis!'),
(25, 'Bilhetes para a \'Noite de ComÃ©dia\' de Setembro jÃ¡ disponÃ­veis!'),
(26, 'Bilhetes para a \'Noite de ComÃ©dia\' de Setembro jÃ¡ disponÃ­veis!'),
(27, 'Bilhetes para a \'Noite de ComÃ©dia\' de Setembro jÃ¡ disponÃ­veis!'),
(28, 'Bilhetes para a \'Noite de ComÃ©dia\' de Setembro jÃ¡ disponÃ­veis!'),
(29, 'Bilhetes para a \'Noite de ComÃ©dia\' de Setembro jÃ¡ disponÃ­veis!'),
(30, 'Bilhetes para a \'Noite de ComÃ©dia\' de Setembro jÃ¡ disponÃ­veis!'),
(31, 'Bilhetes para a \'Noite de ComÃ©dia\' de Setembro jÃ¡ disponÃ­veis!'),
(32, 'Bilhetes para a \'Noite de ComÃ©dia\' de Setembro jÃ¡ disponÃ­veis!'),
(33, 'O GMEA VAI Ã€S ESCOLAS'),
(34, 'já às 4 mãe'),
(35, 'já às 4 mãe'),
(36, 'já às 4 mãe'),
(37, 'Os The Smokestackers vieram ao GMEA!'),
(38, '🎶 Descobre o teu ritmo na nossa Academia de Música! 🎵'),
(39, 'Bilhetes para a \'Noite de Comédia\' de Setembro já disponíveis!'),
(5, 'LOREM IPSUM'),
(6, 'LOREM IPSUM'),
(7, 'LOREM IPSUM'),
(8, 'LOREM IPSUM'),
(9, 'LOREM IPSUM'),
(10, 'LOREM IPSUM'),
(11, 'LOREM IPSUM'),
(12, 'LOREM IPSUM'),
(13, 'LOREM IPSUM'),
(14, 'LOREM IPSUM'),
(15, 'LOREM IPSUM'),
(16, 'LOREM IPSUM'),
(17, 'O GMEA VAI Ã€S ESCOLAS'),
(18, 'O GMEA VAI Ã€S ESCOLAS'),
(19, 'O GMEA VAI Ã€S ESCOLAS'),
(20, 'O GMEA VAI Ã€S ESCOLAS'),
(21, 'Bilhetes para a \'Noite de ComÃ©dia\' de Setembro jÃ¡ disponÃ­veis!'),
(22, 'Bilhetes para a \'Noite de ComÃ©dia\' de Setembro jÃ¡ disponÃ­veis!'),
(23, 'Bilhetes para a \'Noite de ComÃ©dia\' de Setembro jÃ¡ disponÃ­veis!'),
(24, 'Bilhetes para a \'Noite de ComÃ©dia\' de Setembro jÃ¡ disponÃ­veis!'),
(25, 'Bilhetes para a \'Noite de ComÃ©dia\' de Setembro jÃ¡ disponÃ­veis!'),
(26, 'Bilhetes para a \'Noite de ComÃ©dia\' de Setembro jÃ¡ disponÃ­veis!'),
(27, 'Bilhetes para a \'Noite de ComÃ©dia\' de Setembro jÃ¡ disponÃ­veis!'),
(28, 'Bilhetes para a \'Noite de ComÃ©dia\' de Setembro jÃ¡ disponÃ­veis!'),
(29, 'Bilhetes para a \'Noite de ComÃ©dia\' de Setembro jÃ¡ disponÃ­veis!'),
(30, 'Bilhetes para a \'Noite de ComÃ©dia\' de Setembro jÃ¡ disponÃ­veis!'),
(31, 'Bilhetes para a \'Noite de ComÃ©dia\' de Setembro jÃ¡ disponÃ­veis!'),
(32, 'Bilhetes para a \'Noite de ComÃ©dia\' de Setembro jÃ¡ disponÃ­veis!'),
(33, 'O GMEA VAI Ã€S ESCOLAS'),
(34, 'já às 4 mãe'),
(35, 'já às 4 mãe'),
(36, 'já às 4 mãe'),
(37, 'Os The Smokestackers vieram ao GMEA!'),
(38, '🎶 Descobre o teu ritmo na nossa Academia de Música! 🎵'),
(39, 'Bilhetes para a \'Noite de Comédia\' de Setembro já disponíveis!'),
(40, 'Novas Coisas'),
(41, 'Novas Coisas'),
(42, 'Novas Coisas'),
(43, 'Olá!aazsda'),
(44, 'Resultados do Sorteio de Rifas'),
(45, 'Sessão de Música em Família - Registos'),
(46, 'Workshop - Formação Luz e Som'),
(47, 'aaa'),
(48, 'Concerto na ARthenon'),
(49, 'Novas Coisassss'),
(50, 'Concerto na ARthenon'),
(51, 'Concerto na ARthenon'),
(52, 'AAAA'),
(53, 'Concerto na ARthenon'),
(54, 'Novas Coisas'),
(55, 'Novas Coisas'),
(56, 'AAA'),
(57, 'AAA'),
(58, 'aaaa'),
(59, 'aaaaa'),
(60, 'Concerto na ARthenon'),
(61, 'Concerto na ARthenon'),
(62, 'Concerto na ARthenon'),
(63, 'Concerto na ARthenon'),
(64, 'Concerto na ARthenon'),
(65, 'Concerto na ARthenon'),
(66, 'dsdaa'),
(67, 'Concerto na ARthenon'),
(68, 'Olá Mundo!'),
(69, 'Apresentação da Classe de Clarinetes e Flautas na Arthenon'),
(70, 'Apresentação da Classe de Canto na Arthenon'),
(71, '⭐ Workshop - Soundpaiting'),
(72, '⭐ Workshop - Circle singing (NOVA DATA E HORÁRIO!)'),
(73, '⭐ Formação de Música & Som'),
(74, 'Sessão de Música em Família'),
(75, 'Concerto na Arthenon');

-- --------------------------------------------------------

--
-- Estrutura da tabela `page_content`
--

CREATE TABLE `page_content` (
  `id` varchar(255) NOT NULL,
  `content` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Extraindo dados da tabela `page_content`
--

INSERT INTO `page_content` (`id`, `content`) VALUES
('banner_image', 'content/istockphoto-1129332575-612x612.jpg'),
('banner_image_sobre_nos', 'content/20170427_000125.jpg'),
('banner_title', 'A nossa Formação'),
('banner_title_sobre_nos', 'Sobre Nós'),
('section1_content', '<p><span class=\"ql-size-large\">Desperta a tua paixão pela música e aprimora as tuas habilidades na disciplina de </span><strong class=\"ql-size-large\"><u>formação musical</u></strong><span class=\"ql-size-large\">. Nas nossas aulas, mergulha num universo de conhecimento </span><span class=\"ql-size-large\" style=\"color: rgb(0, 138, 0);\">onde cada nota é uma descoberta e cada acorde é uma expressão da tua criatividade</span><span class=\"ql-size-large\">. Orientados por profissionais experientes, os nossos cursos oferecem-te uma jornada envolvente e dinâmica, onde explorarás teoria musical, prática instrumental e muito mais. Prepara-te para desvendares os segredos da música enquanto desenvolves o teu talento e apreciação artística. </span><u class=\"ql-size-large\">Junta-te a nós e embarca nesta emocionante jornada musical</u><span class=\"ql-size-large\">!</span></p>'),
('section1_title', 'Formação Musical'),
('section2_content', '<p><span class=\"ql-size-large\">Tu és a estrela da nossa </span><strong class=\"ql-size-large\"><u>orquestra juvenil</u></strong><span class=\"ql-size-large\">! Aqui, vais mergulhar num mundo de harmonia e melodia, onde cada nota que tocas ecoa com o poder da tua paixão pela música. Na nossa orquestra, não é apenas sobre tocar um instrumento; </span><span class=\"ql-size-large\" style=\"color: rgb(0, 138, 0);\">é sobre fazeres parte de algo maior, criando uma sinfonia de sons que ecoará na memória de todos</span><span class=\"ql-size-large\">. Com orientação especializada e companheiros entusiasmados, vais desenvolver as tuas habilidades musicais, partilhar experiências únicas e criar laços que perdurarão para sempre. Juntos, vamos elevar a música a novos patamares e deslumbrar o mundo com o nosso talento juvenil. </span><u class=\"ql-size-large\">Vem fazer parte desta emocionante jornada na nossa orquestra juvenil</u><span class=\"ql-size-large\">!</span></p>'),
('section2_title', 'Orquestra Juvenil'),
('section3_content', '<p><span class=\"ql-size-large\">Tu és o brilho que ilumina o nosso </span><strong class=\"ql-size-large\"><u>coro infantil e juvenil</u></strong><span class=\"ql-size-large\">! Aqui, mergulharás num mundo de música vocal, </span><span class=\"ql-size-large\" style=\"color: rgb(0, 138, 0);\">onde cada nota que entoas ganha vida e contorna emoções únicas</span><span class=\"ql-size-large\">. No nosso coro, não é apenas sobre cantar; é sobre transmitir quem és, criando harmonias que emocionam e inspiram. Com orientação dedicada e o caloroso apoio dos teus colegas, vais explorar a beleza da tua voz e a arte de te expressares através dela. Juntos, vamos elevar as nossas vozes e criar melodias que ecoam nos corações de todos. </span><u class=\"ql-size-large\">Junta-te a nós nesta emocionante jornada no nosso coro infantil e juvenil</u><span class=\"ql-size-large\">!</span></p>'),
('section3_title', 'Coro'),
('section4_content', '<p><span class=\"ql-size-large\">Tu és a melodia que ecoa através do nosso programa de </span><strong class=\"ql-size-large\"><u>aulas de instrumento</u></strong><span class=\"ql-size-large\">! Aqui, vais embarcar numa jornada musical onde </span><span class=\"ql-size-large\" style=\"color: rgb(0, 138, 0);\">o teu instrumento se tornará uma extensão de ti</span><span class=\"ql-size-large\">. Cada acorde que tocas é uma expressão do teu próprio eu, uma maneira de comunicar sentimentos profundos e contar histórias sem palavras. Nas nossas aulas, não é apenas sobre dominar o instrumento; é sobre descobrir o poder da tua voz musical e explorar todo o seu potencial. Com orientação personalizada e o apoio caloroso dos teus colegas músicos, vais mergulhar numa experiência enriquecedora que te desafiará e te inspirará a alcançar novas alturas musicais. </span><strong class=\"ql-size-large\"><u>Junta-te a nós nesta emocionante jornada nas nossas aulas de instrumento</u></strong><span class=\"ql-size-large\">!</span></p>'),
('section4_title', 'Instrumento'),
('sobre_nos_content', '<p><span class=\"ql-size-large\" style=\"color: rgb(0, 138, 0);\">Primórdios</span></p><p>O Grupo Musical Estrela de Argoncilhe fundou-se em 1926 por um grupo de amigos, executantes de diversos instrumentos musicais e atores amadores, inicialmente com a denominação “Grupo Musical Estrela de São Martinho de Argoncilhe”, fazendo referência ao mártir da freguesia.</p><p><br></p><p>Com muita garra, estes fundadores, e com recursos próprios e através da ajuda de beneméritos construíram o edifício que ainda hoje é a sede da coletividade. Foi durante décadas, uma sede que se dedicou ao cinema, tendo acolhido inúmeras e renomadas sessões e exposições de cinema que, neste âmbito, tiveram um imenso êxito.</p><p><br></p><p><span class=\"ql-size-large\" style=\"color: rgb(0, 138, 0);\">Banda Sinfónica</span></p><p>A sua banda pode ser designada por aquilo a que, corriqueiramente, se chama uma “tuna”, que representa um grupo de músicos em que uma considerável parte é assegurada pelos violinos, violas d’arco e outros instrumentos de cordas apresentando, assim, um menor número de músicos de outros instrumentos como Clarinetes, Flautas ou Oboés.</p><p><br></p><p><span class=\"ql-size-large\" style=\"color: rgb(0, 138, 0);\">Aparecimento da Escola</span></p><p>Foi apenas nos finais dos anos 70 e princípios de 80, que se dedicou ao ensino da música e cântico musical sendo, hoje, uma Academia de Música, onde se formam excelentes músicos, contando com cerca de 120 alunos na Academia atualmente, dedicados às várias componentes da música, desde a solo, em ensemble ou classe de conjunto, além das aulas teóricas.</p><p><br></p><p>Além de já ter tido num passado recente a componente de Academia de Dança, possui uma Banda Sinfónica de Música com cerca de 60 executantes, sendo quase todos formados na respetiva Academia de Música, denotando-se como uma das mais prósperas, jovens e qualificadas escolas artísticas da zona norte, já tendo atuado e representado a instituição em vários pontos do país, como o Mosteiro dos Jerónimos ou o Festival de Bandas Filarmónicas, promovido em 2020 pela RTP e tendo lançado o seu mais recente CD, “Novo Rumo”, em 2014, sob tutela artística do maestro César Santos.</p><p><br></p><p><span class=\"ql-size-large\" style=\"color: rgb(0, 138, 0);\">Atualidade</span></p><p>Hoje, com 97 anos de história, o GMEA continua a trilhar seu caminho com a mesma paixão e dedicação que o caracterizam desde o início. A banda se mantém ativa, realizando concertos, participando de eventos e promovendo a cultura musical na comunidade. O GMEA é um exemplo inspirador de como a música pode unir pessoas, fortalecer laços e construir um legado duradouro.</p>');

-- --------------------------------------------------------

--
-- Estrutura da tabela `pautas_avaliacao`
--

CREATE TABLE `pautas_avaliacao` (
  `id` int(11) NOT NULL,
  `id_pauta` int(11) NOT NULL,
  `disciplina` int(11) NOT NULL,
  `escala` int(11) NOT NULL,
  `nivel` int(11) NOT NULL,
  `semestre` int(11) NOT NULL,
  `estado` int(11) NOT NULL DEFAULT 0,
  `user` varchar(255) NOT NULL,
  `prof` varchar(255) NOT NULL,
  `par1` int(11) NOT NULL,
  `par2` int(11) NOT NULL,
  `par3` int(11) NOT NULL,
  `media` int(11) NOT NULL,
  `notas` varchar(255) NOT NULL,
  `userOuTurma` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Extraindo dados da tabela `pautas_avaliacao`
--

INSERT INTO `pautas_avaliacao` (`id`, `id_pauta`, `disciplina`, `escala`, `nivel`, `semestre`, `estado`, `user`, `prof`, `par1`, `par2`, `par3`, `media`, `notas`, `userOuTurma`) VALUES
(13, 1, 2, 2, 20, 3, 1, 'a110', 'p118', 5, 5, 5, 167, '', 't041'),
(14, 1, 2, 2, 20, 3, 1, 'a115', 'p118', 5, 5, 5, 130, '', 't041'),
(15, 1, 2, 2, 20, 3, 1, 'a121', 'p118', 5, 5, 5, 117, '', 't041'),
(16, 1, 2, 2, 15, 3, 1, 'a120', 'p118', 5, 5, 5, 195, 'AAAA', 't041'),
(34, 2, 11, 2, 16, 3, 1, 'a110', 'p118', 5, 4, 4, 167, '', 't042'),
(35, 2, 11, 2, 17, 3, 1, 'a120', 'p118', 4, 3, 4, 195, 'AAA', 't042'),
(36, 2, 11, 2, 6, 3, 1, 'a123', 'p118', 0, 0, 0, 0, 'a) A Aluna desistiu.', 't042'),
(37, 3, 2, 1, 5, 4, 1, 'a110', 'p118', 5, 5, 5, 167, '', 't042'),
(38, 3, 2, 1, 5, 4, 1, 'a120', 'p118', 5, 5, 5, 195, '', 't042'),
(39, 3, 2, 1, 3, 4, 1, 'a123', 'p118', 3, 3, 4, 0, '', 't042');

-- --------------------------------------------------------

--
-- Estrutura da tabela `pautas_avaliacao_intercalar`
--

CREATE TABLE `pautas_avaliacao_intercalar` (
  `id` int(11) NOT NULL,
  `id_pauta` int(11) NOT NULL,
  `disciplina` int(11) NOT NULL,
  `par1` int(11) NOT NULL,
  `par2` int(11) NOT NULL,
  `par3` int(11) NOT NULL,
  `user` varchar(255) NOT NULL,
  `notas` varchar(255) NOT NULL,
  `semestre` int(11) NOT NULL,
  `estado` int(11) NOT NULL,
  `prof` varchar(255) NOT NULL,
  `userOuTurma` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Extraindo dados da tabela `pautas_avaliacao_intercalar`
--

INSERT INTO `pautas_avaliacao_intercalar` (`id`, `id_pauta`, `disciplina`, `par1`, `par2`, `par3`, `user`, `notas`, `semestre`, `estado`, `prof`, `userOuTurma`) VALUES
(1, 1, 8, 5, 4, 4, 'a110', 'AAAASSSS!\n!!!', 1, 1, 'p118', 'a110'),
(2, 2, 2, 5, 5, 5, 'a110', 'AAAAaaaa', 2, 1, 'p118', 't041'),
(3, 2, 2, 5, 5, 5, 'a115', 'AAAA', 2, 1, 'p118', 't041'),
(4, 2, 2, 5, 5, 5, 'a121', 'AAAA', 2, 1, 'p118', 't041'),
(5, 2, 2, 5, 5, 5, 'a120', 'ssssAAA', 2, 1, 'p118', 't041'),
(6, 3, 2, 4, 3, 2, 'a110', 'AAA', 1, 1, 'p118', 't041'),
(7, 3, 2, 3, 2, 3, 'a115', 'AAA', 1, 1, 'p118', 't041'),
(8, 3, 2, 4, 2, 4, 'a121', 'AAA', 1, 1, 'p118', 't041'),
(9, 3, 2, 1, 2, 1, 'a120', 'AAA', 1, 1, 'p118', 't041'),
(10, 4, 8, 3, 3, 3, 'a110', 'Boa!', 2, 1, 'p118', 'a110'),
(17, 5, 2, 4, 4, 4, 'a110', '', 1, 1, 'p118', 't042'),
(18, 5, 2, 4, 4, 4, 'a120', '', 1, 1, 'p118', 't042'),
(19, 5, 2, 4, 4, 4, 'a123', '', 1, 1, 'p118', 't042'),
(26, 6, 2, 0, 0, 0, 'a110', '', 2, 1, 'p118', 't042'),
(27, 6, 2, 3, 1, 1, 'a120', '', 2, 1, 'p118', 't042'),
(28, 6, 2, 4, 4, 5, 'a123', '', 2, 1, 'p118', 't042');

-- --------------------------------------------------------

--
-- Estrutura da tabela `produtos_faturas_gen`
--

CREATE TABLE `produtos_faturas_gen` (
  `fatura_num` int(11) NOT NULL,
  `produto` varchar(255) NOT NULL,
  `preco` varchar(8) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Extraindo dados da tabela `produtos_faturas_gen`
--

INSERT INTO `produtos_faturas_gen` (`fatura_num`, `produto`, `preco`) VALUES
(182, 'bolos', '12.00'),
(182, 'vaka', '12.30'),
(190, 'Was', '12.00'),
(195, '1', '1.00'),
(195, '2', '2.00'),
(196, 'Batata Frita', '1.50'),
(196, 'Bolo', '1.20'),
(196, 'Chicletes', '0.30'),
(197, 'Batata Frita', '1.50'),
(197, 'Bolo', '1.20'),
(197, 'Chicletes', '0.30'),
(197, 'Alcácer', '12.00'),
(197, 'Bolachas', '0.90'),
(198, 'Bolachas', '1.20'),
(198, 'Sumos', '1.10'),
(199, 'Batatas', '2.00'),
(199, 'Cebolas', '3.00'),
(202, '3', '3.00'),
(202, '4', '4.00'),
(203, '3', '3.00'),
(203, '4', '4.00'),
(204, 'Corda Violino - Mi', '5.00'),
(204, 'Palhetas Clarinete', '30.00'),
(206, 'Bolachas', '0.80'),
(206, 'Crepes de Chocolate', '1.60'),
(206, 'Sumos de Frutas', '2.40'),
(206, 'Água', '3.60'),
(206, 'Corda Violino - Lá', '10.00'),
(206, 'Caixa Palhetas - Clarinete', '35.00'),
(206, 'Borrachas Boquilha - Sax e Clarinete', '13.50'),
(215, 'Dildo 12 Pulegadas - Cor Preto', '24.99'),
(235, 'as', '12.00'),
(182, 'bolos', '12.00'),
(182, 'vaka', '12.30'),
(190, 'Was', '12.00'),
(195, '1', '1.00'),
(195, '2', '2.00'),
(196, 'Batata Frita', '1.50'),
(196, 'Bolo', '1.20'),
(196, 'Chicletes', '0.30'),
(197, 'Batata Frita', '1.50'),
(197, 'Bolo', '1.20'),
(197, 'Chicletes', '0.30'),
(197, 'Alcácer', '12.00'),
(197, 'Bolachas', '0.90'),
(198, 'Bolachas', '1.20'),
(198, 'Sumos', '1.10'),
(199, 'Batatas', '2.00'),
(199, 'Cebolas', '3.00'),
(202, '3', '3.00'),
(202, '4', '4.00'),
(203, '3', '3.00'),
(203, '4', '4.00'),
(204, 'Corda Violino - Mi', '5.00'),
(204, 'Palhetas Clarinete', '30.00'),
(206, 'Bolachas', '0.80'),
(206, 'Crepes de Chocolate', '1.60'),
(206, 'Sumos de Frutas', '2.40'),
(206, 'Água', '3.60'),
(206, 'Corda Violino - Lá', '10.00'),
(206, 'Caixa Palhetas - Clarinete', '35.00'),
(206, 'Borrachas Boquilha - Sax e Clarinete', '13.50'),
(215, 'Dildo 12 Pulegadas - Cor Preto', '24.99'),
(235, 'as', '12.00'),
(182, 'bolos', '12.00'),
(182, 'vaka', '12.30'),
(190, 'Was', '12.00'),
(195, '1', '1.00'),
(195, '2', '2.00'),
(196, 'Batata Frita', '1.50'),
(196, 'Bolo', '1.20'),
(196, 'Chicletes', '0.30'),
(197, 'Batata Frita', '1.50'),
(197, 'Bolo', '1.20'),
(197, 'Chicletes', '0.30'),
(197, 'Alcácer', '12.00'),
(197, 'Bolachas', '0.90'),
(198, 'Bolachas', '1.20'),
(198, 'Sumos', '1.10'),
(199, 'Batatas', '2.00'),
(199, 'Cebolas', '3.00'),
(202, '3', '3.00'),
(202, '4', '4.00'),
(203, '3', '3.00'),
(203, '4', '4.00'),
(204, 'Corda Violino - Mi', '5.00'),
(204, 'Palhetas Clarinete', '30.00'),
(206, 'Bolachas', '0.80'),
(206, 'Crepes de Chocolate', '1.60'),
(206, 'Sumos de Frutas', '2.40'),
(206, 'Água', '3.60'),
(206, 'Corda Violino - Lá', '10.00'),
(206, 'Caixa Palhetas - Clarinete', '35.00'),
(206, 'Borrachas Boquilha - Sax e Clarinete', '13.50'),
(215, 'Dildo 12 Pulegadas - Cor Preto', '24.99'),
(235, 'as', '12.00'),
(283, 'Palhetas Clarinete', '12.00'),
(283, 'Pano Clarinete', '7.50'),
(283, 'Estante de Rua', '10.00'),
(283, 'Palhetas Clarinete', '12.00'),
(283, 'Pano Clarinete', '7.50'),
(283, 'Estante de Rua', '10.00'),
(285, 'Caixa de Palhetas Vandoren Clarinete 3.0 - 10 utd.', '32.00');

-- --------------------------------------------------------

--
-- Estrutura da tabela `profs`
--

CREATE TABLE `profs` (
  `user` varchar(255) NOT NULL,
  `nome` varchar(255) NOT NULL,
  `cod_dis` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Extraindo dados da tabela `profs`
--

INSERT INTO `profs` (`user`, `nome`, `cod_dis`) VALUES
('p101', 'Miguel ângelo', 4),
('p107', 'Miguel ângelo', 4),
('p101', 'Miguel ângelo', 4),
('p107', 'Miguel ângelo', 4),
('p110', 'Miguel ângelo', 7),
('p101', 'Miguel ângelo', 4),
('p107', 'Miguel ângelo', 4),
('p118', 'Pedro Henriques Ribeiro', 8),
('p118', 'Pedro Henriques Ribeiro', 11),
('p118', 'Pedro Henriques Ribeiro', 9),
('p118', 'Pedro Henriques Ribeiro', 2),
('p117', 'Pedro Henriques Ribeiro', 7),
('p117', 'Pedro Henriques Ribeiro', 3),
('p117', 'Pedro Henriques Ribeiro', 15),
('p118', 'Pedro Henriques Ribeiro', 5),
('p118', 'Pedro Henriques Ribeiro', 4),
('p102', 'Miguel ângelo', 4);

-- --------------------------------------------------------

--
-- Estrutura da tabela `quotas_socios`
--

CREATE TABLE `quotas_socios` (
  `id_quota` int(11) NOT NULL,
  `num_socio` int(11) NOT NULL,
  `ano` int(11) NOT NULL,
  `data_pagamento` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Extraindo dados da tabela `quotas_socios`
--

INSERT INTO `quotas_socios` (`id_quota`, `num_socio`, `ano`, `data_pagamento`) VALUES
(1, 13, 2020, '2024-05-17'),
(9, 13, 2021, '2024-05-18');

-- --------------------------------------------------------

--
-- Estrutura da tabela `recuperacao`
--

CREATE TABLE `recuperacao` (
  `user` varchar(255) NOT NULL,
  `confirmacao` int(11) NOT NULL,
  `indice` int(11) NOT NULL,
  `data_hora` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Extraindo dados da tabela `recuperacao`
--

INSERT INTO `recuperacao` (`user`, `confirmacao`, `indice`, `data_hora`) VALUES
('a121', 423149, 32, NULL),
('a121', 515132, 33, NULL),
('a121', 122423, 34, NULL),
('a121', 739316, 35, NULL),
('a121', 3433, 36, NULL),
('a121', 929895, 37, NULL),
('a121', 637974, 38, NULL),
('a121', 168333, 39, NULL),
('a121', 670085, 40, NULL),
('a121', 102455, 41, NULL),
('a121', 278352, 42, NULL),
('a121', 711232, 43, NULL),
('a121', 578173, 44, NULL),
('a121', 337479, 45, NULL),
('a121', 945442, 46, NULL),
('a121', 945442, 47, NULL),
('a121', 49769, 48, NULL),
('a121', 791553, 49, NULL),
('a121', 331782, 50, NULL),
('a121', 477277, 51, NULL),
('a121', 572116, 52, NULL),
('a121', 798797, 53, NULL),
('a121', 394348, 54, NULL),
('a121', 394348, 55, NULL),
('a121', 394348, 56, NULL),
('a121', 394348, 57, NULL),
('a121', 520944, 58, NULL),
('a121', 825922, 59, NULL),
('a121', 748488, 60, NULL),
('a121', 216138, 61, NULL),
('a121', 120824, 62, NULL),
('a121', 594415, 63, NULL),
('a121', 166030, 64, NULL),
('a121', 760357, 65, NULL),
('a121', 342435, 66, NULL),
('a121', 624948, 67, NULL),
('a121', 862721, 68, NULL),
('a121', 594140, 69, NULL),
('a121', 122796, 70, NULL),
('a121', 660869, 71, NULL),
('a121', 861665, 72, NULL),
('a121', 277564, 73, NULL),
('p117', 554200, 74, NULL),
('a121', 903326, 75, NULL),
('a121', 372281, 76, NULL),
('a120', 94658, 77, NULL),
('p117', 639735, 78, NULL),
('p117', 109756, 79, NULL),
('p117', 728275, 80, NULL),
('p117', 646570, 81, NULL),
('a120', 321855, 82, NULL),
('a120', 156903, 83, NULL),
('a120', 69689, 84, NULL),
('d100', 217602, 85, NULL),
('a120', 355967, 86, NULL),
('a120', 68869, 87, NULL),
('a120', 420735, 88, NULL),
('a110', 855133, 89, NULL),
('a110', 759603, 91, NULL),
('a110', 595368, 93, NULL),
('a120', 118932, 95, '2024-03-14 01:04:55'),
('a110', 839942, 96, '2024-03-14 01:05:57'),
('a110', 737570, 97, '2024-03-14 01:06:13'),
('a110', 612114, 98, '2024-03-14 01:08:53'),
('a110', 886413, 99, '2024-03-14 01:21:49'),
('a110', 239519, 100, '2024-03-14 01:44:57'),
('a110', 778781, 101, '2024-03-14 01:53:54'),
('a110', 596085, 102, '2024-03-14 01:53:58'),
('a110', 254022, 103, '2024-03-14 01:55:26'),
('a110', 457518, 104, '2024-05-16 01:09:23'),
('a110', 705682, 105, '2024-05-29 08:31:11'),
('a110', 849328, 106, '2024-05-29 08:31:40');

-- --------------------------------------------------------

--
-- Estrutura da tabela `servicos`
--

CREATE TABLE `servicos` (
  `id_servico` int(11) NOT NULL,
  `tipo_servico` int(255) NOT NULL,
  `data_servico` date NOT NULL,
  `hora_servico` varchar(5) NOT NULL,
  `hora_fim` varchar(255) NOT NULL,
  `local_servico` varchar(255) NOT NULL,
  `estado` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Extraindo dados da tabela `servicos`
--

INSERT INTO `servicos` (`id_servico`, `tipo_servico`, `data_servico`, `hora_servico`, `hora_fim`, `local_servico`, `estado`) VALUES
(4, 0, '2023-07-02', '', '', 'Aldriz', 0),
(5, 0, '2023-08-08', '', '', 'Argoncilhe - Sra. das Neves', 0),
(6, 2, '2024-03-04', '12:30', '14:00', 'Salmonelas', 0),
(7, 0, '2222-03-12', '12:30', '', 'undefined', 0),
(8, 0, '2023-07-02', '', '', 'Aldriz - Argoncilhe', 1),
(9, 0, '2323-04-23', '03:04', '', 'Pereira - Argoncilhe', 1),
(10, 0, '4565-03-12', '12:33', '', 'Pereira - Argoncilhe', 1),
(11, 0, '2023-05-02', '14:00', '', 'Arrentela', 1),
(12, 2, '2024-05-12', '08:00', '15:00', 'Gestosa', 1),
(13, 2, '2024-05-12', '15:30', '01:00', 'Sandim', 1),
(14, 6, '2024-05-21', '10:00', '16:00', 'Almeirinhos', 1),
(15, 4, '2025-05-02', '12:05', '14:07', 'Carvalhosa do Almeiral', 1),
(16, 5, '2024-05-30', '08:30', '12:00', 'Sandim', 1);

-- --------------------------------------------------------

--
-- Estrutura da tabela `sobre_nos`
--

CREATE TABLE `sobre_nos` (
  `id` int(11) NOT NULL,
  `texto` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estrutura da tabela `socios`
--

CREATE TABLE `socios` (
  `num_socio` int(11) NOT NULL,
  `nome` varchar(255) NOT NULL,
  `morada1` varchar(255) NOT NULL,
  `morada2` varchar(255) NOT NULL,
  `nif` int(11) NOT NULL,
  `data_added` date DEFAULT NULL,
  `aluno` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Extraindo dados da tabela `socios`
--

INSERT INTO `socios` (`num_socio`, `nome`, `morada1`, `morada2`, `nif`, `data_added`, `aluno`) VALUES
(1, 'Pedro Henriques Ribeiro', 'Rua do Ouro, 115', '4505-102 Argoncilhe', 257647104, '2024-05-15', 'a110'),
(3, 'Maria João Alves Cunha', 'Rua do Ouro, 115', '4505-102 Argoncilhe', 11, NULL, 'a122'),
(4, 'Maria João Alves Cunha', 'Rua do Ouro, 115', '4505-102 Argoncilhe', 11, NULL, 'a122'),
(5, 'Maria João Alves Cunha', 'Rua do Ouro, 115', '4505-102 Argoncilhe', 11, NULL, 'a122'),
(6, 'Maria João Alves Cunha', 'Rua do Ouro, 115', '4505-102 Argoncilhe', 11, NULL, 'a122'),
(7, 'Maria João Alves Cunha', 'Rua do Ouro, 115', '4505-102 Argoncilhe', 11, NULL, 'a122'),
(8, 'Maria João Alves Cunha', 'Rua do Ouro, 115', '4505-102 Argoncilhe', 11, NULL, 'a122'),
(9, 'Maria João Alves Cunha', 'Rua do Ouro, 115', '4505-102 Argoncilhe', 11, NULL, 'a122'),
(10, 'Maria João Alves Cunha', 'Rua do Ouro, 115', '4505-102 Argoncilhe', 11, NULL, 'a122'),
(11, 'Maria João Alves Cunha', 'Rua do Ouro, 115', '4505-102 Argoncilhe', 11, '2024-05-16', 'a122'),
(12, 'André Claro da Costa Amaral', 'Rua da Bela Vista, 115', '4028-354', 198574112, '2024-05-17', '0'),
(13, 'Carlos da Costa Teixeira', 'Avenida da Subida Infinita, 114', '3847-204 Alvalade', 204528741, '2018-05-03', '0');

-- --------------------------------------------------------

--
-- Estrutura da tabela `sumarios`
--

CREATE TABLE `sumarios` (
  `id_aula` int(11) NOT NULL,
  `indice_aula` int(11) NOT NULL,
  `user` varchar(255) NOT NULL,
  `sumario_texto` text NOT NULL,
  `data` date DEFAULT NULL,
  `hora_inicio` varchar(255) NOT NULL,
  `hora_fim` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Extraindo dados da tabela `sumarios`
--

INSERT INTO `sumarios` (`id_aula`, `indice_aula`, `user`, `sumario_texto`, `data`, `hora_inicio`, `hora_fim`) VALUES
(0, 1, 'p117', '1212', '2023-11-20', '11:11', '11:12'),
(0, 1, 'p117', '1212', '2023-11-20', '11:11', '11:12'),
(0, 2, 'p117', 'asasas', '2023-11-20', '12:34', '12:33'),
(0, 3, 'p117', 'wqas', '2023-11-20', '12:34', '12:59'),
(0, 4, 'p117', 'Escala de Mib M/Dó m\r\nEstudo n.º12 - Jean Jean\r\nLeitura do IV andamento da sonata de Saint-Saens', '2023-11-21', '18:20', '19:10'),
(0, 5, 'p117', 'Teste.', '2023-11-28', '10:20', '11:10'),
(0, 1, 'p117', 'Teste.', '2023-11-28', '10:20', '11:10'),
(0, 6, 'p117', '1111', '2023-11-21', '11:11', '11:11'),
(0, 1, 'p117', '1212', '2023-11-20', '11:11', '11:12'),
(0, 1, 'p117', '1212', '2023-11-20', '11:11', '11:12'),
(0, 2, 'p117', 'asasas', '2023-11-20', '12:34', '12:33'),
(0, 3, 'p117', 'wqas', '2023-11-20', '12:34', '12:59'),
(0, 4, 'p117', 'Escala de Mib M/Dó m\r\nEstudo n.º12 - Jean Jean\r\nLeitura do IV andamento da sonata de Saint-Saens', '2023-11-21', '18:20', '19:10'),
(0, 5, 'p117', 'Teste.', '2023-11-28', '10:20', '11:10'),
(0, 1, 'p117', 'Teste.', '2023-11-28', '10:20', '11:10'),
(0, 6, 'p117', '1111', '2023-11-21', '11:11', '11:11'),
(0, 1, 'p117', '1212', '2023-11-20', '11:11', '11:12'),
(0, 1, 'p117', '1212', '2023-11-20', '11:11', '11:12'),
(0, 2, 'p117', 'asasas', '2023-11-20', '12:34', '12:33'),
(0, 3, 'p117', 'wqas', '2023-11-20', '12:34', '12:59'),
(0, 4, 'p117', 'Escala de Mib M/Dó m\r\nEstudo n.º12 - Jean Jean\r\nLeitura do IV andamento da sonata de Saint-Saens', '2023-11-21', '18:20', '19:10'),
(0, 5, 'p117', 'Teste.', '2023-11-28', '10:20', '11:10'),
(0, 1, 'p117', 'Teste.', '2023-11-28', '10:20', '11:10'),
(0, 6, 'p117', '1111', '2023-11-21', '11:11', '11:11'),
(0, 1, '', 'sad', NULL, '10:30', '11:45'),
(0, 1, '', 'sad', NULL, '10:30', '11:45'),
(0, 1, '', 'sad', NULL, '10:30', '11:45'),
(0, 1, '', 'sad', NULL, '10:30', '11:45'),
(0, 1, '', 'sad', NULL, '10:30', '11:45'),
(0, 1, '', 'sad', NULL, '10:30', '11:45'),
(61, 1, '', 'yut', NULL, '10:30', '11:45'),
(61, 1, '', 'fdgdgg', '0000-00-00', '10:30', '11:45'),
(61, 2, '', 'utoiutiiuyt', '0000-00-00', '10:30', '11:45'),
(61, 2, '', 'tyjjty', '0000-00-00', '10:30', '11:45'),
(61, 3, '', 'tyifiyiy', '0000-00-00', '10:30', '11:45'),
(61, 3, '', 'tyifiyiy', '0000-00-00', '10:30', '11:45'),
(61, 4, '', 'Leituras Atonais. <br/>\r\nIdentificação auditiva de acordes e intervalos. <br/>\r\nDitados vários.', '0000-00-00', '10:30', '11:45'),
(61, 5, '', 'Leituras Atonais. <br/>\r\nIdentificação auditiva de..', '2024-04-19', '10:30', '11:45'),
(61, 6, '', 'kfguhhgk', '2024-04-19', '10:30', '11:45'),
(61, 7, '', '7oiuyuio', '2024-04-19', '10:30', '11:45'),
(61, 8, '', 'yukuykyu', '2024-04-19', '10:30', '11:45'),
(61, 8, '', 'yukuykyu', '2024-04-19', '10:30', '11:45'),
(61, 9, '', 'uyuyiiuyiuy', '2024-04-19', '10:30', '11:45'),
(61, 9, '', 'uyuyiiuyiuy', '2024-04-19', '10:30', '11:45'),
(61, 9, '', 'ytjytjyj', '2024-04-19', '10:30', '11:45'),
(61, 9, '', 'ytjytjyj', '2024-04-19', '10:30', '11:45'),
(61, 10, '', 'ykfkfhg', '2024-04-19', '10:30', '11:45'),
(61, 10, '', 'ykfkfhg', '2024-04-19', '10:30', '11:45'),
(61, 11, '', 'dyhtkjytykt', '2024-04-19', '10:30', '11:45'),
(61, 11, '', 'dyhtkjytykt', '2024-04-19', '10:30', '11:45'),
(60, 1, '', 'yuotouo', '2024-04-19', '18:20', '19:10'),
(60, 1, '', 'yuotouo', '2024-04-19', '18:20', '19:10'),
(61, 12, '', 'fdbbd', '2024-04-19', '10:30', '11:45'),
(61, 12, '', 'fdbbd', '2024-04-19', '10:30', '11:45'),
(61, 13, '', 'fgdhfgh', '2024-04-19', '10:30', '11:45'),
(61, 13, '', 'fgdhfgh', '2024-04-19', '10:30', '11:45'),
(61, 14, '', 'thrrhrh', '2024-04-19', '10:30', '11:45'),
(61, 14, '', 'thrrhrh', '2024-04-19', '10:30', '11:45'),
(61, 15, '', 'sda', '2024-04-19', '10:30', '11:45'),
(61, 16, '', 'ergergreg', '2024-04-19', '10:30', '11:45'),
(61, 17, '', 'fdhfdhfhd', '2024-04-19', '10:30', '11:45'),
(61, 18, '', 'awsfd', '2024-04-19', '10:30', '11:45'),
(61, 19, '', 'AAAAA', '2024-04-20', '10:30', '11:45'),
(61, 20, '', 'AAAA', '2024-04-20', '10:30', '11:45'),
(61, 21, '', 'efwwfwe', '2024-04-20', '10:30', '11:45'),
(61, 22, '', 'dfsfds', '2024-04-20', '10:30', '11:45'),
(61, 23, '', 'ytytytuytj', '2024-04-20', '10:30', '11:45'),
(61, 23, '', 'ytytytuytj', '2024-04-20', '10:30', '11:45'),
(61, 24, '', 'tyu', '2024-04-20', '10:30', '11:45'),
(61, 25, '', 'ewtwttwt', '2024-04-20', '10:30', '11:45'),
(61, 0, '', 'eaffadd', '2024-04-22', '10:30', '11:45'),
(61, 26, '', 'rehrherh', '2024-04-22', '10:30', '11:45'),
(61, 27, '', 'dwdwdw', '2024-04-22', '10:30', '11:45'),
(61, 28, '', 'gfgfggg', '2024-04-22', '10:30', '11:45'),
(61, 29, '', 'fafddssdf', '2024-04-22', '10:30', '11:45'),
(61, 30, '', 'Asalansfolfsdboplaf', '2024-04-26', '10:30', '11:45'),
(61, 31, '', 'ewfrwfew', '2024-04-26', '10:30', '11:45'),
(61, 32, 'p118', 'gvkhjkhjgv', '2024-04-26', '10:30', '11:45'),
(61, 33, 'p118', 'ergrgrgrge', '2024-04-26', '10:30', '11:45'),
(61, 34, 'p118', 'dfgdgfdg', '2024-04-26', '10:30', '11:45'),
(61, 35, 'p118', 'BOAS!', '2024-05-08', '10:30', '11:45'),
(60, 2, 'p118', 'Nada porque o morcão do aluno não trouxe instrumento', '2024-05-08', '18:20', '19:10'),
(61, 36, 'p118', 'Leituras.', '2024-05-09', '10:30', '11:45'),
(61, 37, 'p118', 'AAAAA', '2024-05-10', '10:30', '11:45'),
(61, 38, 'p118', 'll', '2024-05-10', '10:30', '11:45'),
(61, 39, 'p118', 'AAAA', '2024-05-10', '10:30', '11:45'),
(61, 40, 'p118', '<p>Ditados variados.</p>', '2024-05-10', '10:30', '11:45'),
(61, 41, 'p118', '<p>Leituras</p>', '2024-05-10', '10:30', '11:45'),
(61, 42, 'p118', '<p>Leituras modais e atonais.</p><p>Muito bem!</p>', '2024-05-10', '10:30', '11:45'),
(61, 43, 'p118', '<p>Leituras variadas.</p>', '2024-05-14', '10:30', '11:45'),
(61, 44, 'p118', '<p>Leituras atonais.</p><p>Ditado rítmico com mudança de compasso.</p>', '2024-05-28', '10:30', '11:45'),
(60, 3, 'p118', '<p>Estudo</p>', '2024-05-29', '18:20', '19:10');

-- --------------------------------------------------------

--
-- Estrutura da tabela `tipos_regimes`
--

CREATE TABLE `tipos_regimes` (
  `cod_tipo_regime` int(11) NOT NULL,
  `nome_regime` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Extraindo dados da tabela `tipos_regimes`
--

INSERT INTO `tipos_regimes` (`cod_tipo_regime`, `nome_regime`) VALUES
(1, 'Normal'),
(2, 'Livre'),
(3, 'Orquestra'),
(4, 'Orquestra'),
(5, 'Ensemble'),
(6, 'Orquestra e Ensemble'),
(7, 'Orquestra e Coro'),
(8, 'Coro e Ensemble');

-- --------------------------------------------------------

--
-- Estrutura da tabela `tipos_servicos`
--

CREATE TABLE `tipos_servicos` (
  `id_tipo` int(11) NOT NULL,
  `tipo_servico` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Extraindo dados da tabela `tipos_servicos`
--

INSERT INTO `tipos_servicos` (`id_tipo`, `tipo_servico`) VALUES
(1, 'Concerto'),
(2, 'Procissão'),
(3, 'Missa'),
(4, 'Casamento'),
(5, 'Missa + Procissão'),
(6, 'Missa + Concerto'),
(7, 'Missa + Procissão + Concerto'),
(8, 'Outro');

-- --------------------------------------------------------

--
-- Estrutura da tabela `tipo_servico`
--

CREATE TABLE `tipo_servico` (
  `id_tipo` int(11) NOT NULL,
  `desc_tipo` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Extraindo dados da tabela `tipo_servico`
--

INSERT INTO `tipo_servico` (`id_tipo`, `desc_tipo`) VALUES
(1, 'Concerto'),
(2, 'Procissão'),
(3, 'Missa'),
(4, 'Casamento'),
(5, 'Missa + Procissão'),
(6, 'Missa + Concerto'),
(7, 'Missa + Procissão + Concerto'),
(8, 'Outro');

-- --------------------------------------------------------

--
-- Estrutura da tabela `turmas`
--

CREATE TABLE `turmas` (
  `cod_turma` varchar(4) NOT NULL,
  `prof_turma` varchar(255) NOT NULL,
  `dis_turma` int(11) NOT NULL,
  `nome_turma` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Extraindo dados da tabela `turmas`
--

INSERT INTO `turmas` (`cod_turma`, `prof_turma`, `dis_turma`, `nome_turma`) VALUES
('t001', '', 0, 'Cristina Pedrosa'),
('t002', '', 0, 'Pedro Henriques Ribeiro'),
('t003', '', 0, 'Aaaaas'),
('t004', '', 0, 'Albano Jerónimo Costa Alves'),
('t005', '', 0, 'Albano Jerónimo Costa Alves'),
('t006', '', 0, 'Albano Jerónimo Costa Alves'),
('t007', '', 0, 'Formação Musical - I Grau'),
('t008', '', 0, 'IV Grau'),
('t009', '', 0, 'Albano Jerónimo Costa Alves'),
('t010', '', 0, 'Pedro Ribeiro'),
('t011', '', 0, 'Pedro Ribeiro'),
('t012', '', 0, 'Pedro Ribeiro'),
('t013', '', 0, 'Pedro Ribeiro'),
('t014', '', 0, 'Albano Jerónimo Costa Alves'),
('t015', '', 0, 'Pedro Ribeiro'),
('t016', '', 0, 'Albano Jerónimo Costa Alves'),
('t016', '', 0, 'Albano Jerónimo Costa Alves'),
('t016', '', 0, 'Albano Jerónimo Costa Alves'),
('t017', '', 0, 'IV Grau'),
('t017', '', 0, 'IV Grau'),
('t017', '', 0, 'IV Grau'),
('t018', '', 0, 'Pedro Ribeiro'),
('t019', '', 0, 'IV Grau'),
('t019', '', 0, 'IV Grau'),
('t019', '', 0, 'IV Grau'),
('t020', '', 0, 'Albano Jerónimo Costa Alves'),
('t020', '', 0, 'Albano Jerónimo Costa Alves'),
('t021', '', 0, 'IV Grau'),
('t022', '', 0, 'IV Grau'),
('t022', '', 0, 'IV Grau'),
('t022', '', 0, 'IV Grau'),
('t023', '', 0, 'Pedro Ribeiro'),
('t024', '', 0, 'Iniciação I'),
('t024', '', 0, 'Iniciação I'),
('t025', '', 0, 'Pedro Ribeiro'),
('t025', '', 0, 'Pedro Ribeiro'),
('t025', '', 0, 'Pedro Ribeiro'),
('t026', '', 0, 'IV Grau'),
('t026', '', 0, 'IV Grau'),
('t027', '', 0, 'VII Grau'),
('t027', '', 0, 'VII Grau'),
('t027', '', 0, 'VII Grau'),
('t028', '', 0, 'Orquestra Juvenil'),
('t029', 'p107', 4, 'Ensemble'),
('t030', 'p101', 11, 'Orquestra Juvenil'),
('t031', 'p117', 2, 'Formação Musical - VI, VII e VIII graus'),
('t032', 'p101', 1, 'Balelas'),
('t033', 'p101', 1, 'Meditação'),
('t034', 'p101', 1, 'Creatina'),
('t034', 'p101', 1, 'Meditação'),
('t035', 'p101', 1, 'Nenuco'),
('t036', 'p101', 1, 'Canto Coral'),
('t037', 'p101', 1, 'Formação Musical'),
('t037', 'p101', 1, 'Formação Musical'),
('a105', 's2rua5hgcibvjekns1booepm4a', 18, ''),
('', 'p117', 0, 'Canto Coral'),
('t038', 'p101', 1, 'Meditação'),
('a104', '', 17, ''),
('t039', 'p101', 1, 'Nenuco'),
('t001', '', 0, 'Cristina Pedrosa'),
('t002', '', 0, 'Pedro Henriques Ribeiro'),
('t003', '', 0, 'Aaaaas'),
('t004', '', 0, 'Albano Jerónimo Costa Alves'),
('t005', '', 0, 'Albano Jerónimo Costa Alves'),
('t006', '', 0, 'Albano Jerónimo Costa Alves'),
('t007', '', 0, 'Formação Musical - I Grau'),
('t008', '', 0, 'IV Grau'),
('t009', '', 0, 'Albano Jerónimo Costa Alves'),
('t010', '', 0, 'Pedro Ribeiro'),
('t011', '', 0, 'Pedro Ribeiro'),
('t012', '', 0, 'Pedro Ribeiro'),
('t013', '', 0, 'Pedro Ribeiro'),
('t014', '', 0, 'Albano Jerónimo Costa Alves'),
('t015', '', 0, 'Pedro Ribeiro'),
('t016', '', 0, 'Albano Jerónimo Costa Alves'),
('t016', '', 0, 'Albano Jerónimo Costa Alves'),
('t016', '', 0, 'Albano Jerónimo Costa Alves'),
('t017', '', 0, 'IV Grau'),
('t017', '', 0, 'IV Grau'),
('t017', '', 0, 'IV Grau'),
('t018', '', 0, 'Pedro Ribeiro'),
('t019', '', 0, 'IV Grau'),
('t019', '', 0, 'IV Grau'),
('t019', '', 0, 'IV Grau'),
('t020', '', 0, 'Albano Jerónimo Costa Alves'),
('t020', '', 0, 'Albano Jerónimo Costa Alves'),
('t021', '', 0, 'IV Grau'),
('t022', '', 0, 'IV Grau'),
('t022', '', 0, 'IV Grau'),
('t022', '', 0, 'IV Grau'),
('t023', '', 0, 'Pedro Ribeiro'),
('t024', '', 0, 'Iniciação I'),
('t024', '', 0, 'Iniciação I'),
('t025', '', 0, 'Pedro Ribeiro'),
('t025', '', 0, 'Pedro Ribeiro'),
('t025', '', 0, 'Pedro Ribeiro'),
('t026', '', 0, 'IV Grau'),
('t026', '', 0, 'IV Grau'),
('t027', '', 0, 'VII Grau'),
('t027', '', 0, 'VII Grau'),
('t027', '', 0, 'VII Grau'),
('t028', '', 0, 'Orquestra Juvenil'),
('t029', 'p107', 4, 'Ensemble'),
('t030', 'p101', 11, 'Orquestra Juvenil'),
('t031', 'p117', 2, 'Formação Musical - VI, VII e VIII graus'),
('t032', 'p101', 1, 'Balelas'),
('t033', 'p101', 1, 'Meditação'),
('t034', 'p101', 1, 'Creatina'),
('t034', 'p101', 1, 'Meditação'),
('t035', 'p101', 1, 'Nenuco'),
('t036', 'p101', 1, 'Canto Coral'),
('t037', 'p101', 1, 'Formação Musical'),
('t037', 'p101', 1, 'Formação Musical'),
('a105', 's2rua5hgcibvjekns1booepm4a', 18, ''),
('', 'p117', 0, 'Canto Coral'),
('t038', 'p101', 1, 'Meditação'),
('a104', '', 17, ''),
('t039', 'p101', 1, 'Nenuco'),
('t040', 'p110', 10, 'Formação Musical'),
('t001', '', 0, 'Cristina Pedrosa'),
('t002', '', 0, 'Pedro Henriques Ribeiro'),
('t003', '', 0, 'Aaaaas'),
('t004', '', 0, 'Albano Jerónimo Costa Alves'),
('t005', '', 0, 'Albano Jerónimo Costa Alves'),
('t006', '', 0, 'Albano Jerónimo Costa Alves'),
('t007', '', 0, 'Formação Musical - I Grau'),
('t008', '', 0, 'IV Grau'),
('t009', '', 0, 'Albano Jerónimo Costa Alves'),
('t010', '', 0, 'Pedro Ribeiro'),
('t011', '', 0, 'Pedro Ribeiro'),
('t012', '', 0, 'Pedro Ribeiro'),
('t013', '', 0, 'Pedro Ribeiro'),
('t014', '', 0, 'Albano Jerónimo Costa Alves'),
('t015', '', 0, 'Pedro Ribeiro'),
('t016', '', 0, 'Albano Jerónimo Costa Alves'),
('t016', '', 0, 'Albano Jerónimo Costa Alves'),
('t016', '', 0, 'Albano Jerónimo Costa Alves'),
('t017', '', 0, 'IV Grau'),
('t017', '', 0, 'IV Grau'),
('t017', '', 0, 'IV Grau'),
('t018', '', 0, 'Pedro Ribeiro'),
('t019', '', 0, 'IV Grau'),
('t019', '', 0, 'IV Grau'),
('t019', '', 0, 'IV Grau'),
('t020', '', 0, 'Albano Jerónimo Costa Alves'),
('t020', '', 0, 'Albano Jerónimo Costa Alves'),
('t021', '', 0, 'IV Grau'),
('t022', '', 0, 'IV Grau'),
('t022', '', 0, 'IV Grau'),
('t022', '', 0, 'IV Grau'),
('t023', '', 0, 'Pedro Ribeiro'),
('t024', '', 0, 'Iniciação I'),
('t024', '', 0, 'Iniciação I'),
('t025', '', 0, 'Pedro Ribeiro'),
('t025', '', 0, 'Pedro Ribeiro'),
('t025', '', 0, 'Pedro Ribeiro'),
('t026', '', 0, 'IV Grau'),
('t026', '', 0, 'IV Grau'),
('t027', '', 0, 'VII Grau'),
('t027', '', 0, 'VII Grau'),
('t027', '', 0, 'VII Grau'),
('t028', '', 0, 'Orquestra Juvenil'),
('t029', 'p107', 4, 'Ensemble'),
('t030', 'p101', 11, 'Orquestra Juvenil'),
('t031', 'p117', 2, 'Formação Musical - VI, VII e VIII graus'),
('t032', 'p101', 1, 'Balelas'),
('t033', 'p101', 1, 'Meditação'),
('t034', 'p101', 1, 'Creatina'),
('t034', 'p101', 1, 'Meditação'),
('t035', 'p101', 1, 'Nenuco'),
('t036', 'p101', 1, 'Canto Coral'),
('t037', 'p101', 1, 'Formação Musical'),
('t037', 'p101', 1, 'Formação Musical'),
('a105', 's2rua5hgcibvjekns1booepm4a', 18, ''),
('', 'p117', 0, 'Canto Coral'),
('t038', 'p101', 1, 'Meditação'),
('a104', '', 17, ''),
('t039', 'p101', 1, 'Nenuco'),
('a110', '', 3, ''),
('t041', 'p118', 2, 'Formação Musical VI, VII e VIII'),
('a110', '', 16, ''),
('a110', '', 16, ''),
('a110', '', 8, ''),
('t042', 'p118', 2, 'Formação Musical IV GRau'),
('a120', '', 7, ''),
('a110', '', 8, ''),
('a123', '', 15, ''),
('t043', 'p118', 15, 'Ensemble de Pianos'),
('a110', '', 11, ''),
('a120', '', 16, ''),
('a120', '', 16, ''),
('t047', 'p118', 1, 'Aula de culinária'),
('t048', 'p101', 1, 'a fazer testes'),
('t049', 'p101', 1, 'so a testar');

-- --------------------------------------------------------

--
-- Estrutura da tabela `turmas_alunos`
--

CREATE TABLE `turmas_alunos` (
  `cod_turma` varchar(255) NOT NULL,
  `user` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Extraindo dados da tabela `turmas_alunos`
--

INSERT INTO `turmas_alunos` (`cod_turma`, `user`) VALUES
('0', 'a106'),
('79', 'a104'),
('79', 'a106'),
('t047', 'a123'),
('t047', 'a110'),
('t041', 'a110'),
('t041', 'a117'),
('t041', 'a120');

-- --------------------------------------------------------

--
-- Estrutura da tabela `turmas_gerais`
--

CREATE TABLE `turmas_gerais` (
  `cod_turma` varchar(255) NOT NULL,
  `nome_turma` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Extraindo dados da tabela `turmas_gerais`
--

INSERT INTO `turmas_gerais` (`cod_turma`, `nome_turma`) VALUES
('tg001', 'I, II, II e IV Iniciação'),
('tg002', 'I Grau'),
('tg003', 'II Grau'),
('tg004', 'III Grau'),
('tg005', 'IV Grau'),
('tg006', 'V Grau'),
('tg007', 'VI, VII e VIII Graus'),
('tg008', 'Pré-Iniciação I, II, III e IV');

-- --------------------------------------------------------

--
-- Estrutura da tabela `users1`
--

CREATE TABLE `users1` (
  `user` varchar(255) NOT NULL,
  `nome` varchar(255) NOT NULL,
  `morada1` varchar(255) NOT NULL,
  `morada2` varchar(255) NOT NULL,
  `nif` int(11) NOT NULL,
  `cc` int(11) NOT NULL,
  `data_nas` date DEFAULT NULL,
  `telef` varchar(20) NOT NULL,
  `email` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `type` int(11) NOT NULL,
  `foto` varchar(255) NOT NULL,
  `estado` int(11) NOT NULL DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Extraindo dados da tabela `users1`
--

INSERT INTO `users1` (`user`, `nome`, `morada1`, `morada2`, `nif`, `cc`, `data_nas`, `telef`, `email`, `password`, `type`, `foto`, `estado`) VALUES
('d100', 'Joaquim Correia', 'Rua do Cruzeiro Velho, 12, 1.º Tras', '4520-112 Santa Maria de Lamas', 123456789, 12345678, '1977-02-05', '962517031', 'pedroribeiro4702@gmail.com', '$2y$10$fafUDEpmKMFVlGjagepSpefE4UBoZkWdI5vrp8scX/ZaOcSuc/6X6', 3, 'fotos_perfil/6656668385d44.jpg', 1),
('p100', 'Professor de Teste', '-', '-', 1, 1, '0001-01-01', '-', '-', '$2y$10$WQjgIB.Q6MULFW9f.s99jOTrhrf8KgXEQ10BuZsYHSQ9lgKOaNRZm', 2, 'fotos_perfil/6656668385d44.jpg', 1),
('d101', 'Pedro Ribeiro', '0', '0', 0, 0, NULL, '', '', '$2y$10$ZKLu9m65fJKIu1GMlCmQTegRCuwVb2qrrcLckfYBpo1AU2uYE0WW.', 3, 'fotos_perfil/6656668385d44.jpg', 1),
('d102', 'Pedro Ribeiro', '0', '0', 0, 0, NULL, '', '', '$2y$10$L5IGnd5x60bJTFKkAOJIN.7LVKsGXiHZxgBUl6SXRvqs2/Swwt8qC', 3, 'fotos_perfil/6656668385d44.jpg', 1),
('p101', 'Miguel ângelo', '0', '0', 0, 0, NULL, '', '', '$2y$10$uXQ.Xvv2FcqZduGg4qWMy.0eKLiqo0wrBZ.37oTa96Ncei6.VZH.W', 2, 'fotos_perfil/6656668385d44.jpg', 1),
('p102', 'Miguel ângelo', '0', '0', 0, 0, NULL, '', '', '$2y$10$FoA9wsvz9LuCXMQDm7OF8OFwZdT37fo4NpS6OFGHDYvw5f5oT7Lg.', 2, 'fotos_perfil/6656668385d44.jpg', 1),
('p103', 'Miguel ângelo', '0', '0', 0, 0, NULL, '', '', '$2y$10$X5sLP0o0XP7udN9eTj4gpO7ZltLP0pfBfxpm5eHe.WYOZsFnsg2Aq', 2, 'fotos_perfil/6656668385d44.jpg', 1),
('p104', 'Miguel ângelo', '0', '0', 0, 0, NULL, '', '', '$2y$10$5SE8dHsxr1HsvQQ1l/5I7.Hjmm22qDAOzl.9RwhKDXRjRluwzPgpy', 2, 'fotos_perfil/6656668385d44.jpg', 1),
('p105', 'Miguel ângelo', '0', '0', 0, 0, '1111-01-01', '-', '-', '$2y$10$T0jR87uf9WccmnPbd0D6OOMYHpKGPrzOO/h23akmjzetzwfQUN7Wu', 2, 'fotos_perfil/6656668385d44.jpg', 1),
('p106', 'Miguel ângelo', '0', '0', 0, 0, NULL, '', '', '$2y$10$ZTnRUbZC4Nlp25pENw7sy.GdpAMCbBnQBwEYKXza1dgSIfjmMfS42', 2, 'fotos_perfil/6656668385d44.jpg', 0),
('p107', 'Miguel ângelo', '0', '0', 0, 0, NULL, '', '', '$2y$10$MsdcUrH4Sd58icv7eHZ4auf3DGcAU10oBEFWzK/45lDF/9b/KyEMi', 2, 'fotos_perfil/6656668385d44.jpg', 0),
('p108', 'Miguel ângelo', '0', '0', 0, 0, NULL, '', '', '$2y$10$CcCSd76CWe6AfbXnrnjdcuzm.abdTseAab8vXeZ2q1EgNoJybkSVa', 2, 'fotos_perfil/6656668385d44.jpg', 1),
('p109', 'Miguel ângelo', '0', '0', 0, 0, NULL, '', '', '$2y$10$6uGV4u0Du4Ldpxph8TJik.X6VT9bxzPp11GRU98ily8VVV3umDzDG', 2, 'fotos_perfil/6656668385d44.jpg', 1),
('p110', 'Miguel ângelo', '0', '0', 0, 0, NULL, '', '', '$2y$10$SZCUwyUkf1mkdKn8v2i8fOmI7wk7.T5qHrnzojOeeCy2zlKNkY9CS', 2, 'fotos_perfil/6656668385d44.jpg', 1),
('p111', 'Miguel ângelo', '0', '0', 0, 0, NULL, '', '', '$2y$10$84sdHaAvujJn9RfXXXnNfeg4W937D1i1eLt9l.hL9YMcS0MhhzwiS', 2, 'fotos_perfil/6656668385d44.jpg', 1),
('p112', 'Miguel ângelo', '0', '0', 0, 0, NULL, '', '', '$2y$10$dw4X.8.OBv2rVnWj0swNmuoaiFMRxqB9ie8Am8VPtwsM8gR4zKjnK', 2, 'fotos_perfil/6656668385d44.jpg', 0),
('p113', 'Miguel ângelo', '0', '0', 0, 0, NULL, '', '', '$2y$10$iE8jFNrgFbm8vq2ISxuAY.A2Xr/sB9lzbuEDHf9QZdN0KabaFNQWe', 2, 'fotos_perfil/6656668385d44.jpg', 1),
('p114', 'Miguel ângelo', '0', '0', 0, 0, NULL, '', '', '$2y$10$UMv0Lb4qiAXLk.c/V9oDpuSJs6UeVny3rqVo2moiWijLV6lFP8akC', 2, 'fotos_perfil/6656668385d44.jpg', 0),
('p115', 'Miguel ângelo', '0', '0', 0, 0, NULL, '', '', '$2y$10$9MWc1XzqB/4KGUG9p6j6pOvjZsubwHLrbRD5UY3JAlbrlRhmBRoEi', 2, 'fotos_perfil/6656668385d44.jpg', 0),
('a104', 'Cralos', '0', '0', 0, 0, '2002-05-02', '1', '1', '$2y$10$ymyVYeUfXkP1A35qA/RzaejR5HnkG6uuHbXkyd4AlGR2BWEYNXuJy', 1, 'fotos_perfil/6656668385d44.jpg', 1),
('d103', 'Cristina Pedrosa', '0', '0', 0, 0, NULL, '', '', '$2y$10$jlGgHOuN166oDVKuojAeq.OhDuGjoQDEmw/8ie5ucIZETYj3H/0Na', 3, 'fotos_perfil/6656668385d44.jpg', 1),
('p116', 'Manel', '0', '0', 0, 0, NULL, '', '', '$2y$10$ht54YWE.Ja41Z.Fb.KW..eHOzMT2hc7MPDWuf2AvSHEV2OS6Z70TS', 2, 'fotos_perfil/6656668385d44.jpg', 1),
('a105', 'João Vasco', '0', '0', 287654323, 123, '2023-06-20', 'shamel@juol.pt', '+351223455632', '$2y$10$QRwaR8Xbijo0uLPK37RIruGOzg8DoiE8cOV73cPPfT3hHfE40KjSK', 1, 'fotos_perfil/6656668385d44.jpg', 1),
('a106', 'João Vasco', '0', '0', 234556789, 12345678, '3333-08-07', 'nelinhofernandesambi', '+351223455632', '$2y$10$hXXVLfxKLWKG21nX0IG2c.AnplBeZJR21gGnWJbCQK03cgju0py1C', 1, 'fotos_perfil/6656668385d44.jpg', 1),
('d104', 'Ana', '0', '0', 15764679, 2006, '2220-02-02', '+351962517031', 'Pedro Henriques Ribeiro', '$2y$10$b4QKf2csRPtWQ9p7b6W3EeEJPzEwzSPOWXMZcqRpDlsBZaF3G0Dye', 3, 'fotos_perfil/6656668385d44.jpg', 1),
('a107', 'João Vasco', '0', '0', 123456789, 12345678, '9999-09-09', 'comunidadelms@gmail.', '+351962517031', '$2y$10$m.PuoYtsRjnqkLO7qX/UJOh6kSz0oMnlLWSNPgTQGtY49xfUQqVX6', 1, 'fotos_perfil/6656668385d44.jpg', 1),
('d105', 'Pedro Henriques Ribeiro', '0', '0', 257647104, 15764679, '2006-08-02', 'pedroribeiro4702@gma', '+351962517031', '$2y$10$3vNLpVKMwcdY7EisfC57beyc3qDLXvmPG6HKCA4sZ9LPdkfMEM6Xe', 3, 'fotos_perfil/6656668385d44.jpg', 1),
('a108', 'Albano Jerónimo Costa Alves', '0', '0', 154747887, 123456789, '2000-04-01', 'teste@gmail.com', '962517031', '$2y$10$n9QI4iFJsyY2no2.O5AU0.hXw69j2SNRV2HJgkllAabB9haj5i4Fa', 1, 'fotos_perfil/6656668385d44.jpg', 1),
('a109', 'Rua do Ouro, 115', '4505-102 Argoncilhe', 'Pedro Ribeiro', 257647104, 15764679, '2006-08-02', 'pedroribeiro4702@gma', '962517031', '$2y$10$kmEBw6SAJCn61dQxgJa3UO3jhvm8CjcafreLsqGgkCfsHSNDDkQfe', 1, 'fotos_perfil/6656668385d44.jpg', 1),
('a110', 'Pedro Henriques Ribeiro', 'Rua do Ouro, 115', '4505-102 Argoncilhe', 257647104, 15764679, '2006-08-02', '962517031', 'pedroribeiro4702@gmail.com', '$2y$10$5lC32/WDCxZ.Tu.rZ/e7SOr9iSGSkf.yznB.Sf/WFYVYQ2eiuk8TO', 1, 'fotos_perfil/6656668385d44.jpg', 1),
('a111', 'João Henriques Ribeiro', 'Rua do Ouro, 115', 'Argoncilhe 4505-102', 257647104, 15764679, '2011-07-09', '963554821', 'joaohribeiro09@gmail.com', '$2y$10$yiwI6Fs5Z.XNNy1U5vUNjuPR4qT9zOhXLtxIrQGa3T6tSynl10RwC', 1, 'fotos_perfil/6656668385d44.jpg', 1),
('a112', 'João Henriques Ribeiro', 'Rua do Ouro, 115', 'Argoncilhe 4505-102', 257647104, 15764679, '2011-07-09', '963554821', 'joaohribeiro09@gmail.com', '$2y$10$l1jb/YDUpiSEP3xdUMkne.giwxe0VkSF/LOOXwU5Yeroa5/Uu9aKS', 1, 'fotos_perfil/6656668385d44.jpg', 1),
('a113', 'João Henriques Ribeiro', 'Rua do Ouro, 115', 'Argoncilhe 4505-102', 257647104, 15764679, '2011-07-09', '963554821', 'joaohribeiro09@gmail.com', '$2y$10$koKp.ho6Y5qYgmGayO0Nwup.rG6oadaMOZaqnli5jN4FXmSp08rce', 1, 'fotos_perfil/6656668385d44.jpg', 1),
('a114', 'João Henriques Ribeiro', 'Rua do Ouro, 115', 'Argoncilhe 4505-102', 257647104, 15764679, '2011-07-09', '963554821', 'joaohribeiro09@gmail.com', '$2y$10$8hRQaO9MpK.hm.TkCMBTYODDDU88s93JzugH8YyTMyVFkNW9BSQDu', 1, 'fotos_perfil/6656668385d44.jpg', 1),
('a115', 'João Henriques Ribeiro', 'Rua do Ouro, 115', 'Argoncilhe 4505-102', 257647104, 15764679, '2011-07-09', '963554821', 'joaohribeiro09@gmail.com', '$2y$10$y0pmp8COQ6rczKa6nTeLaOy.cDG.wyeHVUk5HPldBdE6HVmalgyFi', 1, 'fotos_perfil/6656668385d44.jpg', 1),
('a116', 'João Henriques Ribeiro', 'Rua do Ouro, 115', 'Argoncilhe 4505-102', 257647104, 15764679, '2011-07-09', '963554821', 'joaohribeiro09@gmail.com', '$2y$10$g2Px0HJ3IEwwd9bzjFI2M.xlA2xPq6mUa5ZnCcoszxOGVEPD8Hqxu', 1, 'fotos_perfil/6656668385d44.jpg', 1),
('a117', 'Ana Ribeiro Henriques', 'Rua da Fronteira, 77, 1.º Traseiras-Direito', '4500-793 Nogueira da Regedoura', 147471471, 12345678, '2011-01-17', '962574114', 'ana@gmail.com', '$2y$10$wA5PLZA6C3BissPW5ZHWpu8QUEZcy.vrLCARuJhh4uyT/VvqD0Zrq', 1, 'fotos_perfil/6656668385d44.jpg', 1),
('a118', 'Teresa Rocha Amorim', 'Rua do Ouro, 115', 'Rua do Ouro, 115', 123456789, 12345678, '2017-02-02', '123456789', 'pedroribeiro4702@gmail.com', '$2y$10$U.cDPEKRnwqML4bqvES77eRvoq3c4yBkuF/R3eMKS9/xeqQcwrVje', 1, 'fotos_perfil/6656668385d44.jpg', 1),
('a119', 'Filipa Martins de Sá', 'Rua do Ouro, 115', 'Rua do Ouro, 115', 123456789, 12345678, '2020-02-02', '962517031', 'pedroribeiro4702@gmail.com', '$2y$10$Z7WfJgIH97338dMGMTBvjOXtVLu.NP6ZMN3jJ1d8qmrMJyB1UNDAO', 1, 'fotos_perfil/6656668385d44.jpg', 1),
('a120', 'Inês Pedrosa', 'Rua do Ouro, 115', 'Rua do Ouro, 115', 123456789, 12345678, '2222-02-02', '962517031', 'pedroribeiro4702@gmail.com', '$2y$10$L4YUKuqK8DSvkH3QqxcTJ.EngXK7NDlobNjPYRF5hA9SRVj4uc3jC', 1, 'fotos_perfil/6656668385d44.jpg', 1),
('a121', 'Manel Lopes', 'Rua do Ouro, 115', 'Rua do Ouro, 115', 123456789, 12345678, '2002-05-02', '962444741', 'pedroribeiro4702@gmail.com', '$2y$10$ygWneOM5ZG1vYH6grgszTOTFNKgVZt3viET95T6FbpKgVuqdO8TgC', 1, 'fotos_perfil/6656668385d44.jpg', 1),
('p117', 'Pedro Henriques Ribeiro', 'Rua do Ouro, 115', '4505-102 Argoncilhe', 257647104, 157647104, '2006-08-02', '+351962517031', 'pedroribeiro4702@gmail.com', '$2y$10$vi5htppL12VqXMPSa.YEKOnXvW8YnLUswmCmKa6Cub6I2qvra496S', 2, 'fotos_perfil/6656668385d44.jpg', 1),
('d106', 'Anabela Guedes Ribeiro', 'Rua da Fronteira, 77, 1.º Tras Dir', '4500-793 Nogueira da Regedoura', 123456789, 12345678, '1977-01-29', '123456789', 'pedroribeiro4702@gmail.com', '$2y$10$xnEaK/.jgUuk2lblhIGZu.urR5RoruCqFIh8wqbWNX1sWzSphmK2i', 3, 'fotos_perfil/6656668385d44.jpg', 1),
('a122', 'Maria João Alves Cunha', 'Rua do Cruzeiro Velho, 12, 1.º Tras', '4505-102 Argoncilhe', 257441014, 12345678, '2005-08-02', '962517031', 'pedroribeiro4702@gmail.com', '$2y$10$Ol488KcFE7Ph1agIjhSn/eAbqK7alWH9Yodjy00sSH/MUopXRuzoe', 1, 'fotos_perfil/6656668385d44.jpg', 1),
('a123', 'Maria João Alves Cunha', 'Rua do Cruzeiro Velho, 12, 1.º Tras', '4505-102 Argoncilhe', 257441287, 12345678, '2005-08-02', '962517031', 'comunidadelms@gmail.com', '$2y$10$qN4ftTXscHJYOKn/retj3e0sXj/aeKpE9iJtk.gyeIA.I9XZnoGgu', 1, 'fotos_perfil/6656668385d44.jpg', 1),
('p118', 'Pedro Henriques Ribeiro', 'Rua do Ouro, 115', '4505-102 Argoncilhe', 257647104, 15764679, '2006-08-02', '962517031', 'pedroribeiro4702@gmail.com', '$2y$10$EcMZc15hxMePQ.Nz0anDwuRENt7rrtLZs3YVTmZtXtgwqLQmIPEMK', 2, 'fotos_perfil/6656668385d44.jpg', 1),
('d107', 'Andreia Santos', 'Rua do Rancho Regional de Argoncilhe, 147', '4505-098', 123456789, 12345678, '2000-08-04', '962517031', 'pedroribeiro4702@gmail.com', '$2y$10$AJU/G1PXzITc14aDTFScQuVA2YJm4ypDLDg6NXvYvnPjl0tSvLcAO', 4, 'fotos_perfil/6656668385d44.jpg', 1);

--
-- Índices para tabelas despejadas
--

--
-- Índices para tabela `alteracoes_password`
--
ALTER TABLE `alteracoes_password`
  ADD PRIMARY KEY (`id_alteracao`);

--
-- Índices para tabela `alunos`
--
ALTER TABLE `alunos`
  ADD PRIMARY KEY (`num_fatura`);

--
-- Índices para tabela `aulas`
--
ALTER TABLE `aulas`
  ADD PRIMARY KEY (`id_aula`);

--
-- Índices para tabela `avaliacoes`
--
ALTER TABLE `avaliacoes`
  ADD PRIMARY KEY (`id`);

--
-- Índices para tabela `avisos`
--
ALTER TABLE `avisos`
  ADD PRIMARY KEY (`id_aviso`);

--
-- Índices para tabela `calendario`
--
ALTER TABLE `calendario`
  ADD PRIMARY KEY (`id_evento`);

--
-- Índices para tabela `candidaturas_bs`
--
ALTER TABLE `candidaturas_bs`
  ADD PRIMARY KEY (`id_candidatura`);

--
-- Índices para tabela `cookies`
--
ALTER TABLE `cookies`
  ADD PRIMARY KEY (`id_cookie`);

--
-- Índices para tabela `faltas`
--
ALTER TABLE `faltas`
  ADD PRIMARY KEY (`indice_falta`);

--
-- Índices para tabela `fardas`
--
ALTER TABLE `fardas`
  ADD PRIMARY KEY (`id_peca`);

--
-- Índices para tabela `faturas`
--
ALTER TABLE `faturas`
  ADD PRIMARY KEY (`fatura_num`);

--
-- Índices para tabela `graus`
--
ALTER TABLE `graus`
  ADD PRIMARY KEY (`id_grau`);

--
-- Índices para tabela `inscricoes`
--
ALTER TABLE `inscricoes`
  ADD PRIMARY KEY (`id_inscricao`);

--
-- Índices para tabela `instrumentos`
--
ALTER TABLE `instrumentos`
  ADD PRIMARY KEY (`codigo`);

--
-- Índices para tabela `justificacao_faltas`
--
ALTER TABLE `justificacao_faltas`
  ADD PRIMARY KEY (`id`);

--
-- Índices para tabela `mensalidades_alunos`
--
ALTER TABLE `mensalidades_alunos`
  ADD PRIMARY KEY (`id`);

--
-- Índices para tabela `meses`
--
ALTER TABLE `meses`
  ADD PRIMARY KEY (`id_mes`);

--
-- Índices para tabela `noticias_info`
--
ALTER TABLE `noticias_info`
  ADD PRIMARY KEY (`id_noticia`);

--
-- Índices para tabela `noticias_texto`
--
ALTER TABLE `noticias_texto`
  ADD PRIMARY KEY (`id_noticia`);

--
-- Índices para tabela `page_content`
--
ALTER TABLE `page_content`
  ADD PRIMARY KEY (`id`);

--
-- Índices para tabela `pautas_avaliacao`
--
ALTER TABLE `pautas_avaliacao`
  ADD PRIMARY KEY (`id`);

--
-- Índices para tabela `pautas_avaliacao_intercalar`
--
ALTER TABLE `pautas_avaliacao_intercalar`
  ADD PRIMARY KEY (`id`);

--
-- Índices para tabela `quotas_socios`
--
ALTER TABLE `quotas_socios`
  ADD PRIMARY KEY (`id_quota`);

--
-- Índices para tabela `recuperacao`
--
ALTER TABLE `recuperacao`
  ADD PRIMARY KEY (`indice`),
  ADD KEY `utilizador` (`user`,`confirmacao`);

--
-- Índices para tabela `servicos`
--
ALTER TABLE `servicos`
  ADD PRIMARY KEY (`id_servico`);

--
-- Índices para tabela `sobre_nos`
--
ALTER TABLE `sobre_nos`
  ADD PRIMARY KEY (`id`);

--
-- Índices para tabela `socios`
--
ALTER TABLE `socios`
  ADD KEY `num_socio` (`num_socio`);

--
-- Índices para tabela `sumarios`
--
ALTER TABLE `sumarios`
  ADD KEY `indice_aula` (`indice_aula`);

--
-- Índices para tabela `tipos_servicos`
--
ALTER TABLE `tipos_servicos`
  ADD PRIMARY KEY (`id_tipo`);

--
-- AUTO_INCREMENT de tabelas despejadas
--

--
-- AUTO_INCREMENT de tabela `alteracoes_password`
--
ALTER TABLE `alteracoes_password`
  MODIFY `id_alteracao` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=32;

--
-- AUTO_INCREMENT de tabela `alunos`
--
ALTER TABLE `alunos`
  MODIFY `num_fatura` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=34;

--
-- AUTO_INCREMENT de tabela `aulas`
--
ALTER TABLE `aulas`
  MODIFY `id_aula` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=82;

--
-- AUTO_INCREMENT de tabela `avaliacoes`
--
ALTER TABLE `avaliacoes`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=84;

--
-- AUTO_INCREMENT de tabela `avisos`
--
ALTER TABLE `avisos`
  MODIFY `id_aviso` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=38;

--
-- AUTO_INCREMENT de tabela `calendario`
--
ALTER TABLE `calendario`
  MODIFY `id_evento` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=37;

--
-- AUTO_INCREMENT de tabela `candidaturas_bs`
--
ALTER TABLE `candidaturas_bs`
  MODIFY `id_candidatura` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT de tabela `cookies`
--
ALTER TABLE `cookies`
  MODIFY `id_cookie` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=26;

--
-- AUTO_INCREMENT de tabela `faltas`
--
ALTER TABLE `faltas`
  MODIFY `indice_falta` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=543;

--
-- AUTO_INCREMENT de tabela `fardas`
--
ALTER TABLE `fardas`
  MODIFY `id_peca` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=24;

--
-- AUTO_INCREMENT de tabela `faturas`
--
ALTER TABLE `faturas`
  MODIFY `fatura_num` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=301;

--
-- AUTO_INCREMENT de tabela `graus`
--
ALTER TABLE `graus`
  MODIFY `id_grau` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=17;

--
-- AUTO_INCREMENT de tabela `inscricoes`
--
ALTER TABLE `inscricoes`
  MODIFY `id_inscricao` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;

--
-- AUTO_INCREMENT de tabela `instrumentos`
--
ALTER TABLE `instrumentos`
  MODIFY `codigo` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT de tabela `justificacao_faltas`
--
ALTER TABLE `justificacao_faltas`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=21;

--
-- AUTO_INCREMENT de tabela `mensalidades_alunos`
--
ALTER TABLE `mensalidades_alunos`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;

--
-- AUTO_INCREMENT de tabela `meses`
--
ALTER TABLE `meses`
  MODIFY `id_mes` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT de tabela `noticias_info`
--
ALTER TABLE `noticias_info`
  MODIFY `id_noticia` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=76;

--
-- AUTO_INCREMENT de tabela `pautas_avaliacao`
--
ALTER TABLE `pautas_avaliacao`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=40;

--
-- AUTO_INCREMENT de tabela `pautas_avaliacao_intercalar`
--
ALTER TABLE `pautas_avaliacao_intercalar`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=29;

--
-- AUTO_INCREMENT de tabela `quotas_socios`
--
ALTER TABLE `quotas_socios`
  MODIFY `id_quota` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT de tabela `recuperacao`
--
ALTER TABLE `recuperacao`
  MODIFY `indice` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=107;

--
-- AUTO_INCREMENT de tabela `servicos`
--
ALTER TABLE `servicos`
  MODIFY `id_servico` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=17;

--
-- AUTO_INCREMENT de tabela `socios`
--
ALTER TABLE `socios`
  MODIFY `num_socio` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=26;

--
-- AUTO_INCREMENT de tabela `tipos_servicos`
--
ALTER TABLE `tipos_servicos`
  MODIFY `id_tipo` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
