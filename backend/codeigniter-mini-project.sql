-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Dec 23, 2024 at 11:24 AM
-- Server version: 10.4.32-MariaDB
-- PHP Version: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `codeigniter-mini-project`
--

-- --------------------------------------------------------

--
-- Table structure for table `ci_sessions`
--

CREATE TABLE `ci_sessions` (
  `id` varchar(128) NOT NULL,
  `ip_address` varchar(45) NOT NULL,
  `timestamp` int(10) UNSIGNED NOT NULL DEFAULT 0,
  `data` blob NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `ci_sessions`
--

INSERT INTO `ci_sessions` (`id`, `ip_address`, `timestamp`, `data`) VALUES
('heqbnldbvgn80mohodof8u61hkjvs77o', '::1', 1734949236, 0x61757468546f6b656e7c733a36343a2265363437316432666530353062396139633461613364333563656666313563636466323465343261333938346530393865636666623534306433383036353438223b757365725f69647c733a323a223139223b6e6f6d7c733a353a2261646d696e223b7072656e6f6d7c733a353a2261646d696e223b726f6c657c733a313a2231223b),
('rb8spjucd9tbscup5d7snina6su28fbh', '::1', 1734948676, 0x61757468546f6b656e7c733a36343a2239613730616632363665366366383931663064303438386232326133363634393866323338646331373336346661646631653030303237393433373464373664223b757365725f69647c733a323a223134223b6e6f6d7c733a353a226261727269223b7072656e6f6d7c733a31323a224d4f48414d454420414d494e223b726f6c657c733a313a2231223b);

-- --------------------------------------------------------

--
-- Table structure for table `employe`
--

CREATE TABLE `employe` (
  `id` int(11) NOT NULL,
  `nom` varchar(255) NOT NULL,
  `prenom` varchar(255) NOT NULL,
  `mail` varchar(255) NOT NULL,
  `adresse` longtext NOT NULL,
  `telephone` varchar(50) NOT NULL,
  `poste` int(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `employe`
--

INSERT INTO `employe` (`id`, `nom`, `prenom`, `mail`, `adresse`, `telephone`, `poste`) VALUES
(50, 'employe1', 'employe1', 'employe1@employe1.com', 'employe1', '025481515', 1),
(51, 'employe2', 'employe2', 'employe2@employe2.com', 'employe2', '6241653', 2),
(52, 'employe3', 'employe3', 'employe3@employe3.com', 'employe3', '51588945', 3);

-- --------------------------------------------------------

--
-- Table structure for table `sessions`
--

CREATE TABLE `sessions` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `token` varchar(255) NOT NULL,
  `expiration` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `sessions`
--

INSERT INTO `sessions` (`id`, `user_id`, `token`, `expiration`, `created_at`, `updated_at`) VALUES
(1, 19, 'e6471d2fe050b9a9c4aa3d35ceff15ccdf24e42a3984e098ecffb540d3806548', '2024-12-23 11:15:07', '2024-12-23 10:15:07', '2024-12-23 10:15:07');

-- --------------------------------------------------------

--
-- Table structure for table `utilisateur`
--

CREATE TABLE `utilisateur` (
  `id` int(11) NOT NULL,
  `nom` varchar(255) NOT NULL,
  `prenom` varchar(255) NOT NULL,
  `login` varchar(255) NOT NULL,
  `mot_de_passe` longtext NOT NULL,
  `role` int(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `utilisateur`
--

INSERT INTO `utilisateur` (`id`, `nom`, `prenom`, `login`, `mot_de_passe`, `role`) VALUES
(19, 'admin', 'admin', 'admin@admin.com', '$2y$10$sTQMb/IxWH18.ZUrdILr9eMmVLf2jg45LCVpXOZOGp7pxPmsXaKxm', 1),
(20, 'user', 'user', 'user@user.com', '$2y$10$ZZdQqNWHTZVu06dCW215uuXXxAqps/oK./FEWv.Y1k0kkcBcZ7zoe', 2);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `ci_sessions`
--
ALTER TABLE `ci_sessions`
  ADD PRIMARY KEY (`id`),
  ADD KEY `ci_sessions_timestamp` (`timestamp`);

--
-- Indexes for table `employe`
--
ALTER TABLE `employe`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `mail` (`mail`,`telephone`);

--
-- Indexes for table `sessions`
--
ALTER TABLE `sessions`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_id` (`user_id`);

--
-- Indexes for table `utilisateur`
--
ALTER TABLE `utilisateur`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `login` (`login`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `employe`
--
ALTER TABLE `employe`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=54;

--
-- AUTO_INCREMENT for table `sessions`
--
ALTER TABLE `sessions`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `utilisateur`
--
ALTER TABLE `utilisateur`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=21;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `sessions`
--
ALTER TABLE `sessions`
  ADD CONSTRAINT `sessions_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `utilisateur` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
