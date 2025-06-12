-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Hôte : 127.0.0.1:3306
-- Généré le : mar. 29 oct. 2024 à 12:39
-- Version du serveur : 8.3.0
-- Version de PHP : 8.2.18

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de données : `tablepetanque`
--

-- --------------------------------------------------------

--
-- Structure de la table `evenement`
--

DROP TABLE IF EXISTS `evenement`;
CREATE TABLE IF NOT EXISTS `evenement` (
  `Id_evenement` varchar(50) NOT NULL,
  `date_` varchar(50) DEFAULT NULL,
  `durée` varchar(50) DEFAULT NULL,
  `ville` varchar(50) DEFAULT NULL,
  `nom_terrain` varchar(50) DEFAULT NULL,
  `Id_utilisateur` varchar(50) NOT NULL,
  PRIMARY KEY (`Id_evenement`),
  KEY `Id_utilisateur` (`Id_utilisateur`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- --------------------------------------------------------

--
-- Structure de la table `reservation`
--

DROP TABLE IF EXISTS `reservation`;
CREATE TABLE IF NOT EXISTS `reservation` (
  `Id_reservation` varchar(50) NOT NULL,
  `date_debut` varchar(50) DEFAULT NULL,
  `date_fin` varchar(50) DEFAULT NULL,
  `nbr_util` varchar(50) DEFAULT NULL,
  `Id_Terrain` varchar(50) NOT NULL,
  `Id_utilisateur` varchar(50) NOT NULL,
  PRIMARY KEY (`Id_reservation`),
  KEY `Id_Terrain` (`Id_Terrain`),
  KEY `Id_utilisateur` (`Id_utilisateur`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- --------------------------------------------------------

--
-- Structure de la table `terrain`
--

DROP TABLE IF EXISTS `terrain`;
CREATE TABLE IF NOT EXISTS `terrain` (
  `Id_Terrain` varchar(50) NOT NULL,
  `ville` varchar(50) DEFAULT NULL,
  `nom_terrain` varchar(50) DEFAULT NULL,
  `type_terrain` varchar(50) DEFAULT NULL,
  `interieur` varbinary(50) DEFAULT NULL,
  `equipements` varchar(50) DEFAULT NULL,
  `etat` varchar(50) DEFAULT NULL,
  `note` varchar(50) DEFAULT NULL,
  `longitude` decimal(9,6) NOT NULL,
  `latitude` decimal(8,6) NOT NULL,
  PRIMARY KEY (`Id_Terrain`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Déchargement des données de la table `terrain`
--

INSERT INTO `terrain` (`Id_Terrain`, `ville`, `nom_terrain`, `type_terrain`, `interieur`, `equipements`, `etat`, `note`, `longitude`, `latitude`) VALUES
('', 'ville', 'terrain beau', 'terre', NULL, NULL, 'boNNE', '10', 6.178379, 48.699969);

-- --------------------------------------------------------

--
-- Structure de la table `utilisateur`
--

DROP TABLE IF EXISTS `utilisateur`;
CREATE TABLE IF NOT EXISTS `utilisateur` (
  `Id_utilisateur` int NOT NULL AUTO_INCREMENT,
  `nom` varchar(50) DEFAULT NULL,
  `Prenom` varchar(50) DEFAULT NULL,
  `mail` varchar(50) DEFAULT NULL,
  `ville` varchar(50) DEFAULT NULL,
  `mot_de_passe` varchar(255) NOT NULL,
  `isClient` tinyint(1) NOT NULL DEFAULT 1,
  `isAdmin` tinyint(1) NOT NULL DEFAULT 0,
  PRIMARY KEY (`Id_utilisateur`)
) ENGINE=MyISAM AUTO_INCREMENT=6 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Déchargement des données de la table `utilisateur`
--

INSERT INTO `utilisateur` (`Id_utilisateur`, `nom`, `Prenom`, `mail`, `ville`, `mot_de_passe`, `isClient`, `isAdmin`) VALUES
(1, 'rouge', 'admin', 'admin@gmail.com', 'nancy', 'admin', 0, 1);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
