-- phpMyAdmin SQL Dump
-- version 5.0.4
-- https://www.phpmyadmin.net/
--
-- Host: localhost
-- Generation Time: Mar 01, 2021 at 05:31 AM
-- Server version: 10.4.17-MariaDB
-- PHP Version: 8.0.0

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `nekretnine_db`
--

-- --------------------------------------------------------

--
-- Table structure for table `fotografije`
--

CREATE TABLE `fotografije` (
  `id` int(11) NOT NULL,
  `foto_url` varchar(255) COLLATE utf8_bin NOT NULL,
  `nekretnina_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

--
-- Dumping data for table `fotografije`
--

INSERT INTO `fotografije` (`id`, `foto_url`, `nekretnina_id`) VALUES
(1, './uploads/1/pexels-curtis-adams-5008400.jpg', 1),
(2, './uploads/1/pexels-binyamin-mellish-1396132.jpg', 1),
(3, './uploads/2/pexels-vecislavas-popa-1571470.jpg', 2),
(4, './uploads/2/pexels-naim-benjelloun-2029694.jpg', 2),
(5, './uploads/2/pexels-naim-benjelloun-2029665.jpg', 2),
(6, './uploads/3/pexels-jason-boyd-3209045.jpg', 3),
(7, './uploads/3/pexels-curtis-adams-5353880.jpg', 3),
(8, './uploads/3/pexels-binyamin-mellish-1396132.jpg', 3);

-- --------------------------------------------------------

--
-- Table structure for table `gradovi`
--

CREATE TABLE `gradovi` (
  `id` int(11) NOT NULL,
  `ime_grada` varchar(255) COLLATE utf8_bin NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

--
-- Dumping data for table `gradovi`
--

INSERT INTO `gradovi` (`id`, `ime_grada`) VALUES
(1, 'Podgorica'),
(2, 'Nikšić'),
(3, 'Bar'),
(5, 'Kolašin'),
(6, 'Bijelo Polje'),
(7, 'Budva');

-- --------------------------------------------------------

--
-- Table structure for table `nekretnine`
--

CREATE TABLE `nekretnine` (
  `id` int(11) NOT NULL,
  `naziv` varchar(255) COLLATE utf8_bin NOT NULL,
  `povrsina` smallint(5) UNSIGNED NOT NULL,
  `cijena` int(10) UNSIGNED NOT NULL,
  `godina_izgradnje` smallint(5) UNSIGNED NOT NULL,
  `opis` text COLLATE utf8_bin DEFAULT NULL,
  `grad` int(11) NOT NULL,
  `tip_oglasa` int(11) NOT NULL,
  `tip_nekretnine` int(11) UNSIGNED NOT NULL,
  `status` tinyint(1) NOT NULL DEFAULT 0,
  `datum_prodaje` date DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

--
-- Dumping data for table `nekretnine`
--

INSERT INTO `nekretnine` (`id`, `naziv`, `povrsina`, `cijena`, `godina_izgradnje`, `opis`, `grad`, `tip_oglasa`, `tip_nekretnine`, `status`, `datum_prodaje`) VALUES
(1, 'Kuća Marinka Rokvića', 100, 150000, 1990, 'Ovo je njegova kuća, živeo je tu.', 2, 1, 2, 0, NULL),
(2, 'Stan Alena Islamovića', 30, 40000, 1980, 'Za sreću dosta je.', 1, 1, 1, 0, NULL),
(3, 'Kuća Izlazećeg Sunca', 120, 2000, 1983, 'Idealno mjesto ako želite da provedete život u grijehu i bijedi. Gratis nove plave farmerke što mi je sašila majka.', 5, 2, 2, 0, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `tipovi_nekretnina`
--

CREATE TABLE `tipovi_nekretnina` (
  `id` int(10) UNSIGNED NOT NULL,
  `tip_nekretnine` varchar(255) COLLATE utf8_bin NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

--
-- Dumping data for table `tipovi_nekretnina`
--

INSERT INTO `tipovi_nekretnina` (`id`, `tip_nekretnine`) VALUES
(1, 'stan'),
(2, 'kuća'),
(3, 'garaža'),
(4, 'poslovni prostor');

-- --------------------------------------------------------

--
-- Table structure for table `tipovi_oglasa`
--

CREATE TABLE `tipovi_oglasa` (
  `id` int(11) NOT NULL,
  `tip_oglasa` varchar(255) COLLATE utf8_bin NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

--
-- Dumping data for table `tipovi_oglasa`
--

INSERT INTO `tipovi_oglasa` (`id`, `tip_oglasa`) VALUES
(1, 'prodaja'),
(2, 'iznajmljivanje'),
(3, 'kompenzacija');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `fotografije`
--
ALTER TABLE `fotografije`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_foto_nekretnina` (`nekretnina_id`);

--
-- Indexes for table `gradovi`
--
ALTER TABLE `gradovi`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `nekretnine`
--
ALTER TABLE `nekretnine`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_nekretnina_grad` (`grad`),
  ADD KEY `fk_nekretnina_tip_oglasa` (`tip_oglasa`),
  ADD KEY `fk_nekretnina_tip_nekretnine` (`tip_nekretnine`);

--
-- Indexes for table `tipovi_nekretnina`
--
ALTER TABLE `tipovi_nekretnina`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tipovi_oglasa`
--
ALTER TABLE `tipovi_oglasa`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `fotografije`
--
ALTER TABLE `fotografije`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `gradovi`
--
ALTER TABLE `gradovi`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `nekretnine`
--
ALTER TABLE `nekretnine`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `tipovi_nekretnina`
--
ALTER TABLE `tipovi_nekretnina`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `tipovi_oglasa`
--
ALTER TABLE `tipovi_oglasa`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `fotografije`
--
ALTER TABLE `fotografije`
  ADD CONSTRAINT `fk_foto_nekretnina` FOREIGN KEY (`nekretnina_id`) REFERENCES `nekretnine` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `nekretnine`
--
ALTER TABLE `nekretnine`
  ADD CONSTRAINT `fk_nekretnina_grad` FOREIGN KEY (`grad`) REFERENCES `gradovi` (`id`),
  ADD CONSTRAINT `fk_nekretnina_tip_nekretnine` FOREIGN KEY (`tip_nekretnine`) REFERENCES `tipovi_nekretnina` (`id`),
  ADD CONSTRAINT `fk_nekretnina_tip_oglasa` FOREIGN KEY (`tip_oglasa`) REFERENCES `tipovi_oglasa` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
