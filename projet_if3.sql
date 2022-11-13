-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Hôte : 127.0.0.1
-- Généré le : dim. 13 nov. 2022 à 23:46
-- Version du serveur : 10.4.25-MariaDB
-- Version de PHP : 8.1.10

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de données : `projet_if3`
--

-- --------------------------------------------------------

--
-- Structure de la table `account`
--

CREATE TABLE `account` (
  `id` int(11) NOT NULL,
  `username` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `first_name` varchar(255) NOT NULL,
  `last_name` varchar(255) NOT NULL,
  `level` varchar(255) NOT NULL,
  `weight` int(11) DEFAULT NULL,
  `size` int(11) DEFAULT NULL,
  `picture` varchar(255) NOT NULL DEFAULT 'unknown.jpg'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Déchargement des données de la table `account`
--

INSERT INTO `account` (`id`, `username`, `password`, `email`, `first_name`, `last_name`, `level`, `weight`, `size`, `picture`) VALUES
(1, 'Catherine', '$2y$10$IbAbp..qytPkSPJVo/za3.llS96M9clyyv9TnY0KrZJxmSGzOD9Te', 'catherine.midi_six@time.net', 'Catherine', 'De Medicis', 'Beginner', 70, 172, 'if2.jpg');

-- --------------------------------------------------------

--
-- Structure de la table `follow`
--

CREATE TABLE `follow` (
  `id_account` int(11) NOT NULL,
  `id_followed` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Structure de la table `run`
--

CREATE TABLE `run` (
  `id_run` int(11) NOT NULL,
  `distance` float NOT NULL,
  `time` time NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Déchargement des données de la table `run`
--

INSERT INTO `run` (`id_run`, `distance`, `time`) VALUES
(1, 17.7, '03:26:00'),
(2, 3.9, '00:48:00');

-- --------------------------------------------------------

--
-- Structure de la table `run_saved`
--

CREATE TABLE `run_saved` (
  `number_run` int(11) NOT NULL,
  `id_run` int(11) NOT NULL,
  `id_account` int(11) NOT NULL,
  `run_name` varchar(255) DEFAULT NULL,
  `completed` tinyint(1) DEFAULT NULL,
  `date` date DEFAULT NULL,
  `time` time DEFAULT NULL,
  `difficulty` varchar(255) DEFAULT NULL,
  `weather` varchar(255) DEFAULT NULL,
  `comments` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Déchargement des données de la table `run_saved`
--

INSERT INTO `run_saved` (`number_run`, `id_run`, `id_account`, `run_name`, `completed`, `date`, `time`, `difficulty`, `weather`, `comments`) VALUES
(1, 1, 1, 'Belfort - Montbeliard', 1, '2022-10-14', '03:36:00', 'medium', 'Sunny', 'Very nice run !!'),
(2, 1, 1, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(3, 2, 1, NULL, 1, '2022-11-05', '01:00:00', 'easy', 'Rain', 'The weather wasn\'t good, but I quite like this run.');

-- --------------------------------------------------------

--
-- Structure de la table `waypoints`
--

CREATE TABLE `waypoints` (
  `id_run` int(11) NOT NULL,
  `order_waypoint` int(11) NOT NULL,
  `latitude` decimal(18,15) NOT NULL,
  `longitude` decimal(18,15) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Déchargement des données de la table `waypoints`
--

INSERT INTO `waypoints` (`id_run`, `order_waypoint`, `latitude`, `longitude`) VALUES
(1, 1, '47.639674000000000', '6.863849000000000'),
(1, 2, '47.510155100000000', '6.798201000000000'),
(2, 1, '47.676484442213210', '6.494293212890626'),
(2, 2, '47.652900314148200', '6.462879180908203');

--
-- Index pour les tables déchargées
--

--
-- Index pour la table `account`
--
ALTER TABLE `account`
  ADD PRIMARY KEY (`id`);

--
-- Index pour la table `follow`
--
ALTER TABLE `follow`
  ADD KEY `id_account` (`id_account`),
  ADD KEY `id_followed` (`id_followed`);

--
-- Index pour la table `run`
--
ALTER TABLE `run`
  ADD PRIMARY KEY (`id_run`);

--
-- Index pour la table `run_saved`
--
ALTER TABLE `run_saved`
  ADD PRIMARY KEY (`number_run`),
  ADD KEY `id_run` (`id_run`,`id_account`),
  ADD KEY `id_account` (`id_account`);

--
-- Index pour la table `waypoints`
--
ALTER TABLE `waypoints`
  ADD KEY `id_run` (`id_run`);

--
-- AUTO_INCREMENT pour les tables déchargées
--

--
-- AUTO_INCREMENT pour la table `account`
--
ALTER TABLE `account`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT pour la table `run`
--
ALTER TABLE `run`
  MODIFY `id_run` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT pour la table `run_saved`
--
ALTER TABLE `run_saved`
  MODIFY `number_run` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- Contraintes pour les tables déchargées
--

--
-- Contraintes pour la table `follow`
--
ALTER TABLE `follow`
  ADD CONSTRAINT `follow_ibfk_1` FOREIGN KEY (`id_account`) REFERENCES `account` (`id`),
  ADD CONSTRAINT `follow_ibfk_2` FOREIGN KEY (`id_followed`) REFERENCES `account` (`id`);

--
-- Contraintes pour la table `run_saved`
--
ALTER TABLE `run_saved`
  ADD CONSTRAINT `run_saved_ibfk_1` FOREIGN KEY (`id_account`) REFERENCES `account` (`id`),
  ADD CONSTRAINT `run_saved_ibfk_2` FOREIGN KEY (`id_run`) REFERENCES `run` (`id_run`);

--
-- Contraintes pour la table `waypoints`
--
ALTER TABLE `waypoints`
  ADD CONSTRAINT `waypoints_ibfk_1` FOREIGN KEY (`id_run`) REFERENCES `run` (`id_run`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
