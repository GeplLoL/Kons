-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: d123176.mysql.zonevs.eu
-- Loomise aeg: Mai 06, 2024 kell 09:14 EL
-- Serveri versioon: 10.4.32-MariaDB-log
-- PHP versioon: 8.2.16

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Andmebaas: `d123176_andmebaas`
--

-- --------------------------------------------------------

--
-- Tabeli struktuur tabelile `konsultatsioon`
--

CREATE TABLE `konsultatsioon` (
  `id` int(11) NOT NULL,
  `nimi` varchar(255) NOT NULL,
  `päev` varchar(50) NOT NULL,
  `tund` varchar(50) NOT NULL,
  `klassiruum` varchar(50) DEFAULT NULL,
  `periood` varchar(50) NOT NULL,
  `opetaja` varchar(50),
  `kommentaar` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Andmete tõmmistamine tabelile `konsultatsioon`
--

INSERT INTO `konsultatsioon` (`id`, `nimi`, `päev`, `tund`, `klassiruum`, `periood`, `kommentaar`) VALUES
(1, 'Marin', 'Kolmap', '23:20', '101', 'фывff', 'asd'),
(2, 'Katja', 'Esmaspäev', '12:00', '102', '2. periood', 'halva'),
(4, 'Deniss', 'Neljapäev', '13:00', '708', '2. periood', 'Vene keel'),
(8, 'Irina', 'Teisipäev', '2', '2', '2', '2');

--
-- Indeksid tõmmistatud tabelitele
--

--
-- Indeksid tabelile `konsultatsioon`
--
ALTER TABLE `konsultatsioon`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT tõmmistatud tabelitele
--

--
-- AUTO_INCREMENT tabelile `konsultatsioon`
--
ALTER TABLE `konsultatsioon`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
