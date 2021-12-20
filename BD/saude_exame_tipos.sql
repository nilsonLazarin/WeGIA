-- phpMyAdmin SQL Dump
-- version 5.1.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Tempo de geração: 20-Dez-2021 às 18:39
-- Versão do servidor: 10.4.21-MariaDB
-- versão do PHP: 8.0.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Banco de dados: `wegia`
--

-- --------------------------------------------------------


-- Extraindo dados da tabela `saude_exame_tipos`
--

INSERT INTO `saude_exame_tipos` (`id_exame_tipo`, `descricao`) VALUES
(1, 'Fezes'),
(2, 'Hemograma'),
(3, 'Urina'),
(4, 'Cardíaco'),
(5, 'Glicemia'),
(6, 'Colesterol'),
(7, 'TSH'),
(8, 'Papanicolau'),
(9, 'Transaminases'),
(10, 'Creatinina'),
(11, 'Triglicerídios'),
(12, 'Ácido úrico'),
(13, 'Ureia'),
(14, 'TGO'),
(15, 'TGP');


--
-- AUTO_INCREMENT de tabela `saude_exame_tipos`
--
ALTER TABLE `saude_exame_tipos`
  MODIFY `id_exame_tipo` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
