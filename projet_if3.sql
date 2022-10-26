-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Hôte : 127.0.0.1
-- Généré le : mer. 26 oct. 2022 à 14:08
-- Version du serveur : 10.4.24-MariaDB
-- Version de PHP : 8.1.6

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
  `level` varchar(255) NOT NULL,
  `weight` int(11) NOT NULL,
  `size` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Déchargement des données de la table `account`
--

INSERT INTO `account` (`id`, `username`, `password`, `email`, `level`, `weight`, `size`) VALUES
(1, 'Catherine', '12h06', 'catherine-de-midi-six@time.com', 'Débutant', 0, 0),
(21, 'Drake', 'fff', 'babacooldu95@gmail.com', 'Intermediate', 400, 20);

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
  `data` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Déchargement des données de la table `run`
--

INSERT INTO `run` (`id_run`, `data`) VALUES
(3, 4),
(4, 4),
(5, 4),
(6, 4),
(7, 4);

-- --------------------------------------------------------

--
-- Structure de la table `run_saved`
--

CREATE TABLE `run_saved` (
  `id_run` int(11) NOT NULL,
  `id_account` int(11) NOT NULL,
  `completed` tinyint(1) DEFAULT NULL,
  `date` date DEFAULT NULL,
  `time` time DEFAULT NULL,
  `difficulty` varchar(255) DEFAULT NULL,
  `weather` varchar(255) DEFAULT NULL,
  `comments` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Structure de la table `waypoints`
--

CREATE TABLE `waypoints` (
  `id_run` int(11) NOT NULL,
  `order_waypoint` int(11) NOT NULL,
  `latitude` float NOT NULL,
  `longitude` float NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Déchargement des données de la table `waypoints`
--

INSERT INTO `waypoints` (`id_run`, `order_waypoint`, `latitude`, `longitude`) VALUES
(5, 1, 47.6397, 6.86385),
(6, 1, 47.6397, 6.86385),
(6, 2, 47.5102, 6.7982),
(7, 1, 47.6397, 6.86385),
(7, 2, 47.6085, 6.93237),
(7, 3, 47.5102, 6.7982);

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
  ADD PRIMARY KEY (`id_run`,`id_account`),
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
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=22;

--
-- AUTO_INCREMENT pour la table `run`
--
ALTER TABLE `run`
  MODIFY `id_run` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

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
