-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Hôte : 127.0.0.1:3306
-- Généré le : mar. 13 jan. 2026 à 12:50
-- Version du serveur : 9.1.0
-- Version de PHP : 8.3.14

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de données : `smartculture`
--

-- --------------------------------------------------------

--
-- Structure de la table `bluray`
--

DROP TABLE IF EXISTS `bluray`;
CREATE TABLE IF NOT EXISTS `bluray` (
  `id` int NOT NULL,
  `titre` text NOT NULL,
  `date_sortie` text NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Déchargement des données de la table `bluray`
--

INSERT INTO `bluray` (`id`, `titre`, `date_sortie`) VALUES
(0, 'Inception', '2010'),
(0, 'Le Parrain', '1972'),
(0, 'Pulp Fiction', '1994'),
(0, 'Interstellar', '2014'),
(0, 'The Dark Knight', '2008');

-- --------------------------------------------------------

--
-- Structure de la table `dvd`
--

DROP TABLE IF EXISTS `dvd`;
CREATE TABLE IF NOT EXISTS `dvd` (
  `id` int NOT NULL,
  `titre` int NOT NULL,
  `date_sortie` int NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Déchargement des données de la table `dvd`
--

INSERT INTO `dvd` (`id`, `titre`, `date_sortie`) VALUES
(0, 0, 1999),
(0, 0, 2000),
(0, 0, 1997),
(0, 0, 2001),
(0, 0, 2009);

-- --------------------------------------------------------

--
-- Structure de la table `jeu_de_societe`
--

DROP TABLE IF EXISTS `jeu_de_societe`;
CREATE TABLE IF NOT EXISTS `jeu_de_societe` (
  `id` int NOT NULL,
  `titre` text NOT NULL,
  `date_sortie` text NOT NULL,
  `marque` text NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Déchargement des données de la table `jeu_de_societe`
--

INSERT INTO `jeu_de_societe` (`id`, `titre`, `date_sortie`, `marque`) VALUES
(0, 'Catan', '1995', 'Kosmos'),
(0, 'Carcassonne', '2000', 'Hans im Glück'),
(0, '7 Wonders', '2010', 'Repos Production'),
(0, 'Ticket to Ride', '2004', 'Days of Wonder'),
(0, 'Pandemic', '2008', 'Z-Man Games');

-- --------------------------------------------------------

--
-- Structure de la table `livres`
--

DROP TABLE IF EXISTS `livres`;
CREATE TABLE IF NOT EXISTS `livres` (
  `id` int NOT NULL,
  `titre` text NOT NULL,
  `editeurs` text NOT NULL,
  `date_publication` text NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Déchargement des données de la table `livres`
--

INSERT INTO `livres` (`id`, `titre`, `editeurs`, `date_publication`) VALUES
(0, '1984', 'Gallimard', '1949'),
(0, 'Le Petit Prince', 'Gallimard', '1943'),
(0, 'Harry Potter à l\'école des sorciers', 'Gallimard Jeunesse', '1998'),
(0, 'L\'Étranger', 'Gallimard', '1942'),
(0, 'Les Misérables', 'Albert Lacroix et Cie', '1862');
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
