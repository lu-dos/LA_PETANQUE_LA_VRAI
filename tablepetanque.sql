-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Hôte : 127.0.0.1:3306
-- Généré le : mer. 18 juin 2025 à 08:41
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
-- Structure de la table `avis`
--

DROP TABLE IF EXISTS `avis`;
CREATE TABLE IF NOT EXISTS `avis` (
  `id_avis` bigint UNSIGNED NOT NULL AUTO_INCREMENT,
  `utilisateur_id` int NOT NULL,
  `note` smallint NOT NULL,
  `avis` text NOT NULL,
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id_avis`),
  UNIQUE KEY `id_avis` (`id_avis`),
  KEY `fk_utilisateur` (`utilisateur_id`)
) ;

-- --------------------------------------------------------
--
-- Structure de la table `mail`
--

DROP TABLE IF EXISTS `mail`;
CREATE TABLE IF NOT EXISTS `mail` (
  `Id_mail` int UNSIGNED NOT NULL AUTO_INCREMENT,
  `expediteur_id` int UNSIGNED NOT NULL,
  `destinataire_id` int UNSIGNED NOT NULL,
  `sujet` varchar(255) DEFAULT NULL,
  `corps` text NOT NULL,
  `date_envoi` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `lu` tinyint(1) NOT NULL DEFAULT '0',
  PRIMARY KEY (`Id_mail`),
  KEY `idx_destinataire` (`destinataire_id`),
  KEY `fk_mail_expediteur` (`expediteur_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

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

--
-- Déchargement des données de la table `reservation`
--

INSERT INTO `reservation` (`Id_reservation`, `date_debut`, `date_fin`, `nbr_util`, `Id_Terrain`, `Id_utilisateur`) VALUES
('6852707c16b74', '2025-06-13T09:53', '2025-06-21T09:53', '1', '1', '40');

-- --------------------------------------------------------
--
-- Structure de la table `terrain`
--

DROP TABLE IF EXISTS `terrain`;
CREATE TABLE IF NOT EXISTS `terrain` (
  `Id_Terrain` int NOT NULL AUTO_INCREMENT,
  `ville` varchar(50) DEFAULT NULL,
  `nom_terrain` varchar(50) DEFAULT NULL,
  `type_terrain` varchar(50) DEFAULT NULL,
  `interieur` tinyint DEFAULT '0',
  `equipements` tinyint DEFAULT '0',
  `etat` enum('Bon','Moyen','Mauvais') DEFAULT 'Bon',
  `note` varchar(50) DEFAULT NULL,
  `longitude` decimal(9,6) NOT NULL,
  `latitude` decimal(8,6) NOT NULL,
  PRIMARY KEY (`Id_Terrain`)
) ENGINE=MyISAM AUTO_INCREMENT=15 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Déchargement des données de la table `terrain`
--

INSERT INTO `terrain` (`Id_Terrain`, `ville`, `nom_terrain`, `type_terrain`, `interieur`, `equipements`, `etat`, `note`, `longitude`, `latitude`) VALUES
(1, 'ville', 'terrain beau', 'terre', 0, 0, 'Moyen', '10', 6.178379, 48.699969),
(4, 'Terrain du Jardin Dominique Alexandre Godron', 'Terrain Pétanque Parc de la Pépinière', 'sable', 1, 1, 'Bon', '10', 6.190000, 48.693100),
(6, 'nancy', 'le bon terrain ', 'sable', 0, 0, 'Bon', '25.2', 48.702000, 6.216000),
(13, 'admin', 'admin', 'bon', 1, 0, 'Bon', '1000000', 56.000000, 78.000000),
(12, 'sainville', 'sainville', 'sable', 0, 0, 'Bon', '8', 67.000000, 76.000000);

-- --------------------------------------------------------
--
-- Structure de la table `utilisateur`
--

DROP TABLE IF EXISTS `utilisateur`;
CREATE TABLE IF NOT EXISTS `utilisateur` (
  `Id_utilisateur` int UNSIGNED NOT NULL AUTO_INCREMENT,
  `nom` varchar(50) DEFAULT NULL,
  `Prenom` varchar(50) DEFAULT NULL,
  `mail` varchar(50) DEFAULT NULL,
  `ville` varchar(50) DEFAULT NULL,
  `mot_de_passe` varchar(255) NOT NULL,
  `isAdmin` tinyint(1) DEFAULT '0',
  PRIMARY KEY (`Id_utilisateur`)
) ENGINE=InnoDB AUTO_INCREMENT=41 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Déchargement des données de la table `utilisateur`
--

INSERT INTO `utilisateur` (`Id_utilisateur`, `nom`, `Prenom`, `mail`, `ville`, `mot_de_passe`, `isAdmin`) VALUES
(37, 'juliann', 'ploquin', 'ju@gmail.com', 'sainville', '$2y$10$.ahEgbFj0XLRRBKbCXy1MeQqzwuJ2fiQ0Pqh84Rs.H9WFZDTcJCzy', 0),
(38, 'admin', 'admin', 'admin@gmail.com', 'admin', '$2y$10$QBgWEKqrg/CY/4aXCr/8ue8MlaGKKXT1P9OwoxvNHcyKWMBwKjANa', 1),
(40, 'CANDUN', 'Kylian', 'kyle@gmail.com', 'sainville', '$2y$10$RJlVKsK4jwZZQD1DNe5VReHAWVOO79X0jqDjYqI5kTLozJM7Y3yk2', 0);

--
-- Contraintes pour les tables déchargées
--

--
-- Contraintes pour la table `mail`
--
ALTER TABLE `mail`
  ADD CONSTRAINT `fk_mail_destinataire` FOREIGN KEY (`destinataire_id`) REFERENCES `utilisateur` (`Id_utilisateur`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_mail_expediteur` FOREIGN KEY (`expediteur_id`) REFERENCES `utilisateur` (`Id_utilisateur`) ON DELETE CASCADE ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
