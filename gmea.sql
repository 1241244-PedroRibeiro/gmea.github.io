-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Tempo de geração: 12-Out-2023 às 18:25
-- Versão do servidor: 10.4.27-MariaDB
-- versão do PHP: 8.2.0

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
-- Estrutura da tabela `alunos`
--

CREATE TABLE `alunos` (
  `user` varchar(255) NOT NULL,
  `cod_in1` int(11) NOT NULL,
  `prof_in1` varchar(255) NOT NULL,
  `dur1` int(11) NOT NULL,
  `cod_in2` int(11) NOT NULL,
  `prof_in2` varchar(255) NOT NULL,
  `dur2` int(11) NOT NULL,
  `cod_fm` int(11) NOT NULL,
  `cod_orq` int(11) NOT NULL,
  `cod_coro` int(11) NOT NULL,
  `in_alg` int(11) NOT NULL,
  `regime` int(11) NOT NULL,
  `mem_bs` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Extraindo dados da tabela `alunos`
--

INSERT INTO `alunos` (`user`, `cod_in1`, `prof_in1`, `dur1`, `cod_in2`, `prof_in2`, `dur2`, `cod_fm`, `cod_orq`, `cod_coro`, `in_alg`, `regime`, `mem_bs`) VALUES
('a104', 7, 'p101', 50, 0, '0', 0, 2, 11, 10, 2, 1, 1),
('a105', 0, '0', 0, 0, '0', 0, 0, 0, 0, 0, 0, 0),
('a106', 0, '0', 0, 0, '0', 0, 0, 0, 0, 0, 0, 0),
('a107', 0, '0', 0, 0, '0', 0, 0, 0, 0, 0, 0, 0);

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
(20, 'Bombardino');

-- --------------------------------------------------------

--
-- Estrutura da tabela `fardas`
--

CREATE TABLE `fardas` (
  `id_peca` int(11) NOT NULL,
  `tipo` varchar(255) NOT NULL,
  `genero` varchar(255) NOT NULL,
  `tamanho` int(11) NOT NULL,
  `estado` int(11) NOT NULL,
  `membs` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estrutura da tabela `instrumentos`
--

CREATE TABLE `instrumentos` (
  `cat` varchar(255) NOT NULL,
  `codigo` int(11) NOT NULL,
  `estado` int(11) NOT NULL,
  `user` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Extraindo dados da tabela `instrumentos`
--

INSERT INTO `instrumentos` (`cat`, `codigo`, `estado`, `user`) VALUES
('Clarinete', 1, 1, 'a103'),
('Requinta', 2, 1, 'a104'),
('Trompete', 2, 0, '');

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
(39, 'noticias-fotos/6479f63b43841.jpg');

-- --------------------------------------------------------

--
-- Estrutura da tabela `noticias_info`
--

CREATE TABLE `noticias_info` (
  `id_noticia` int(11) NOT NULL,
  `data_noticia` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Extraindo dados da tabela `noticias_info`
--

INSERT INTO `noticias_info` (`id_noticia`, `data_noticia`) VALUES
(5, '2023-05-30'),
(6, '2023-05-30'),
(7, '2023-05-30'),
(8, '2023-05-30'),
(9, '2023-05-30'),
(10, '2023-05-30'),
(11, '2023-05-30'),
(12, '2023-05-30'),
(13, '2023-05-30'),
(14, '2023-05-30'),
(15, '2023-05-30'),
(16, '2023-05-30'),
(17, '2023-05-31'),
(18, '2023-05-31'),
(19, '2023-05-31'),
(20, '2023-05-31'),
(21, '2023-05-31'),
(22, '2023-05-31'),
(23, '2023-05-31'),
(24, '2023-05-31'),
(25, '2023-05-31'),
(26, '2023-05-31'),
(27, '2023-05-31'),
(28, '2023-05-31'),
(29, '2023-05-31'),
(30, '2023-05-31'),
(31, '2023-05-31'),
(32, '2023-05-31'),
(33, '2023-06-01'),
(34, '2023-06-02'),
(35, '2023-06-02'),
(36, '2023-06-02'),
(37, '2023-05-31'),
(38, '2023-06-01'),
(39, '2023-06-02');

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
(39, 'A venda de bilhetes para o próximo evento no nosso espaço já abriu! <br><br>\r\nTeremos uma noite de comédia com mais dois humoristas fantásticos: João Dantas e Zé Pedro Sousa! <br><br>\r\nEles prometem trazer muitas gargalhadas numa noite que promete! <br><br>\r\nPodes adquirir os teus bilhetes <a href=\"https://estreladeargoncilhe.bol.pt\">aqui!</a>');

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
(39, 'Bilhetes para a \'Noite de Comédia\' de Setembro já disponíveis!');

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
('p101', 'Miguel ângelo', 4);

-- --------------------------------------------------------

--
-- Estrutura da tabela `servicos`
--

CREATE TABLE `servicos` (
  `id_servico` int(11) NOT NULL,
  `tipo_servico` varchar(255) NOT NULL,
  `data_servico` date NOT NULL,
  `hora_servico` varchar(5) NOT NULL,
  `local_servico` varchar(255) NOT NULL,
  `estado` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Extraindo dados da tabela `servicos`
--

INSERT INTO `servicos` (`id_servico`, `tipo_servico`, `data_servico`, `hora_servico`, `local_servico`, `estado`) VALUES
(4, '', '2023-07-02', '', 'Aldriz', 0),
(5, '', '2023-08-08', '', 'Argoncilhe - Sra. das Neves', 0),
(6, '', '2024-03-04', '', 'Salmonelas', 0),
(7, 'Missa   Procissão   Concerto', '2222-03-12', '12:30', 'undefined', 0),
(8, 'Missa   Procissão', '2023-07-02', '', 'Aldriz - Argoncilhe', 1),
(9, 'Concerto', '2323-04-23', '03:04', 'Pereira - Argoncilhe', 1),
(10, 'Procissão', '4565-03-12', '12:33', 'Pereira - Argoncilhe', 1),
(11, 'Missa   Procissão', '2023-05-02', '14:00', 'Arrentela', 1);

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
(6, 'Procissão + Concerto'),
(7, 'Missa + Procissão + Concerto');

-- --------------------------------------------------------

--
-- Estrutura da tabela `turmas`
--

CREATE TABLE `turmas` (
  `cod_turma` varchar(4) NOT NULL,
  `prof_turma` varchar(6) NOT NULL,
  `dis_turma` int(11) NOT NULL,
  `nome_turma` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Extraindo dados da tabela `turmas`
--

INSERT INTO `turmas` (`cod_turma`, `prof_turma`, `dis_turma`, `nome_turma`) VALUES
('t001', 'p101', 1, 'Cristina Pedrosa'),
('t002', 'p101', 1, 'Pedro Henriques Ribeiro');

-- --------------------------------------------------------

--
-- Estrutura da tabela `users1`
--

CREATE TABLE `users1` (
  `user` varchar(255) NOT NULL,
  `nome` varchar(255) NOT NULL,
  `nif` int(11) NOT NULL,
  `cc` int(11) NOT NULL,
  `data_nas` date DEFAULT NULL,
  `telef` varchar(20) NOT NULL,
  `email` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `type` int(11) NOT NULL,
  `foto` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Extraindo dados da tabela `users1`
--

INSERT INTO `users1` (`user`, `nome`, `nif`, `cc`, `data_nas`, `telef`, `email`, `password`, `type`, `foto`) VALUES
('d100', '', 0, 0, NULL, '', '', '$2y$10$cQdjNx/6zF2MiY4MIiB.0eaW6ckPSMhDpFArSxAxxD3k2XCSeHP2W', 3, 'unnamed (1).png'),
('p100', '', 0, 0, NULL, '', '', '$2y$10$dyrEileRDGBhmFzevni2beRkOJZITjpkcrFRBNQBM93Tf10nCDa.i', 2, 'img921.jpg'),
('d101', 'Pedro Ribeiro', 0, 0, NULL, '', '', '$2y$10$ZKLu9m65fJKIu1GMlCmQTegRCuwVb2qrrcLckfYBpo1AU2uYE0WW.', 3, 'the-last-of-us-part-i-logo-black-scaled.webp'),
('d102', 'Pedro Ribeiro', 0, 0, NULL, '', '', '$2y$10$L5IGnd5x60bJTFKkAOJIN.7LVKsGXiHZxgBUl6SXRvqs2/Swwt8qC', 3, 'the-last-of-us-part-i-logo-black-scaled.webp'),
('p101', 'Miguel ângelo', 0, 0, NULL, '', '', '$2y$10$uXQ.Xvv2FcqZduGg4qWMy.0eKLiqo0wrBZ.37oTa96Ncei6.VZH.W', 2, 'superdraft-soccer-16.jpg'),
('p102', 'Miguel ângelo', 0, 0, NULL, '', '', '$2y$10$FoA9wsvz9LuCXMQDm7OF8OFwZdT37fo4NpS6OFGHDYvw5f5oT7Lg.', 2, 'superdraft-soccer-16.jpg'),
('p103', 'Miguel ângelo', 0, 0, NULL, '', '', '$2y$10$X5sLP0o0XP7udN9eTj4gpO7ZltLP0pfBfxpm5eHe.WYOZsFnsg2Aq', 2, 'superdraft-soccer-16.jpg'),
('p104', 'Miguel ângelo', 0, 0, NULL, '', '', '$2y$10$5SE8dHsxr1HsvQQ1l/5I7.Hjmm22qDAOzl.9RwhKDXRjRluwzPgpy', 2, 'superdraft-soccer-16.jpg'),
('p105', 'Miguel ângelo', 0, 0, NULL, '', '', '$2y$10$T0jR87uf9WccmnPbd0D6OOMYHpKGPrzOO/h23akmjzetzwfQUN7Wu', 2, 'superdraft-soccer-16.jpg'),
('p106', 'Miguel ângelo', 0, 0, NULL, '', '', '$2y$10$ZTnRUbZC4Nlp25pENw7sy.GdpAMCbBnQBwEYKXza1dgSIfjmMfS42', 2, 'superdraft-soccer-16.jpg'),
('p107', 'Miguel ângelo', 0, 0, NULL, '', '', '$2y$10$MsdcUrH4Sd58icv7eHZ4auf3DGcAU10oBEFWzK/45lDF/9b/KyEMi', 2, 'superdraft-soccer-16.jpg'),
('p108', 'Miguel ângelo', 0, 0, NULL, '', '', '$2y$10$CcCSd76CWe6AfbXnrnjdcuzm.abdTseAab8vXeZ2q1EgNoJybkSVa', 2, 'superdraft-soccer-16.jpg'),
('p109', 'Miguel ângelo', 0, 0, NULL, '', '', '$2y$10$6uGV4u0Du4Ldpxph8TJik.X6VT9bxzPp11GRU98ily8VVV3umDzDG', 2, 'superdraft-soccer-16.jpg'),
('p110', 'Miguel ângelo', 0, 0, NULL, '', '', '$2y$10$SZCUwyUkf1mkdKn8v2i8fOmI7wk7.T5qHrnzojOeeCy2zlKNkY9CS', 2, 'superdraft-soccer-16.jpg'),
('p111', 'Miguel ângelo', 0, 0, NULL, '', '', '$2y$10$84sdHaAvujJn9RfXXXnNfeg4W937D1i1eLt9l.hL9YMcS0MhhzwiS', 2, 'superdraft-soccer-16.jpg'),
('p112', 'Miguel ângelo', 0, 0, NULL, '', '', '$2y$10$dw4X.8.OBv2rVnWj0swNmuoaiFMRxqB9ie8Am8VPtwsM8gR4zKjnK', 2, 'superdraft-soccer-16.jpg'),
('p113', 'Miguel ângelo', 0, 0, NULL, '', '', '$2y$10$iE8jFNrgFbm8vq2ISxuAY.A2Xr/sB9lzbuEDHf9QZdN0KabaFNQWe', 2, 'superdraft-soccer-16.jpg'),
('p114', 'Miguel ângelo', 0, 0, NULL, '', '', '$2y$10$UMv0Lb4qiAXLk.c/V9oDpuSJs6UeVny3rqVo2moiWijLV6lFP8akC', 2, 'superdraft-soccer-16.jpg'),
('p115', 'Miguel ângelo', 0, 0, NULL, '', '', '$2y$10$9MWc1XzqB/4KGUG9p6j6pOvjZsubwHLrbRD5UY3JAlbrlRhmBRoEi', 2, 'superdraft-soccer-16.jpg'),
('a104', 'Cralos', 0, 0, NULL, '', '', '$2y$10$ymyVYeUfXkP1A35qA/RzaejR5HnkG6uuHbXkyd4AlGR2BWEYNXuJy', 1, 'Fut1NLaWIAgFKbB.jfif'),
('d103', 'Cristina Pedrosa', 0, 0, NULL, '', '', '$2y$10$jlGgHOuN166oDVKuojAeq.OhDuGjoQDEmw/8ie5ucIZETYj3H/0Na', 3, 'transferir-removebg-preview.png'),
('p116', 'Manel', 0, 0, NULL, '', '', '$2y$10$ht54YWE.Ja41Z.Fb.KW..eHOzMT2hc7MPDWuf2AvSHEV2OS6Z70TS', 2, 'transferir-removebg-preview.png'),
('a105', 'João Vasco', 287654323, 123, '2023-06-20', 'shamel@juol.pt', '+351223455632', '$2y$10$QRwaR8Xbijo0uLPK37RIruGOzg8DoiE8cOV73cPPfT3hHfE40KjSK', 1, 'fotos_perfil/64872d72c731a.jpg'),
('a106', 'João Vasco', 234556789, 12345678, '3333-08-07', 'nelinhofernandesambi', '+351223455632', '$2y$10$hXXVLfxKLWKG21nX0IG2c.AnplBeZJR21gGnWJbCQK03cgju0py1C', 1, 'fotos_perfil/64afc718c264c.jpg'),
('d104', '257647104', 15764679, 2006, '0000-00-00', '+351962517031', 'Pedro Henriques Ribeiro', '$2y$10$b4QKf2csRPtWQ9p7b6W3EeEJPzEwzSPOWXMZcqRpDlsBZaF3G0Dye', 3, 'fotos_perfil/64b8f90d78882.png'),
('a107', 'João Vasco', 123456789, 12345678, '9999-09-09', 'comunidadelms@gmail.', '+351962517031', '$2y$10$m.PuoYtsRjnqkLO7qX/UJOh6kSz0oMnlLWSNPgTQGtY49xfUQqVX6', 1, 'fotos_perfil/64b8f9d445799.png'),
('d105', 'Pedro Henriques Ribeiro', 257647104, 15764679, '2006-08-02', 'pedroribeiro4702@gma', '+351962517031', '$2y$10$3vNLpVKMwcdY7EisfC57beyc3qDLXvmPG6HKCA4sZ9LPdkfMEM6Xe', 3, 'fotos_perfil/64b8fa445ab03.png');

--
-- Índices para tabelas despejadas
--

--
-- Índices para tabela `fardas`
--
ALTER TABLE `fardas`
  ADD PRIMARY KEY (`id_peca`);

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
-- Índices para tabela `servicos`
--
ALTER TABLE `servicos`
  ADD PRIMARY KEY (`id_servico`);

--
-- AUTO_INCREMENT de tabelas despejadas
--

--
-- AUTO_INCREMENT de tabela `fardas`
--
ALTER TABLE `fardas`
  MODIFY `id_peca` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=22;

--
-- AUTO_INCREMENT de tabela `noticias_info`
--
ALTER TABLE `noticias_info`
  MODIFY `id_noticia` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=40;

--
-- AUTO_INCREMENT de tabela `servicos`
--
ALTER TABLE `servicos`
  MODIFY `id_servico` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
