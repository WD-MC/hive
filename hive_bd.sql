-- phpMyAdmin SQL Dump
-- version 4.9.2
-- https://www.phpmyadmin.net/
--
-- Hôte : 127.0.0.1:3308
-- Généré le :  sam. 24 juin 2023 à 12:33
-- Version du serveur :  8.0.18
-- Version de PHP :  7.3.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de données :  `hive_bd`
--

-- --------------------------------------------------------

--
-- Structure de la table `archives`
--

DROP TABLE IF EXISTS `archives`;
CREATE TABLE IF NOT EXISTS `archives` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `titreDocument` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL,
  `categorie` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL,
  `descriptions` text NOT NULL,
  `fichierArchive` varchar(255) NOT NULL,
  `dateSauvegarde` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `id_admin` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `FK_OFRES_USERS` (`id_admin`)
) ENGINE=InnoDB AUTO_INCREMENT=15 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Déchargement des données de la table `archives`
--

INSERT INTO `archives` (`id`, `titreDocument`, `categorie`, `descriptions`, `fichierArchive`, `dateSauvegarde`, `id_admin`) VALUES
(2, 'rapport house', 'projets', 'bien', 'http://localhost/Hive/API/documents/archives/1_Fiche de Professions.pdf', '2023-05-25 17:40:43', 1),
(14, 'house', 'reunions', 'Etat d\'avancé back-end', 'http://localhost/Hive/API/documents/archives/2_Fiche de Professions.pdf', '2023-05-27 12:06:33', 2);

-- --------------------------------------------------------

--
-- Structure de la table `corbeille`
--

DROP TABLE IF EXISTS `corbeille`;
CREATE TABLE IF NOT EXISTS `corbeille` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `deleteArchive` longtext NOT NULL,
  `id_admin` int(11) NOT NULL,
  `dateSuppression` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  KEY `FK_CORBEILLE_USERS` (`id_admin`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Déchargement des données de la table `corbeille`
--

INSERT INTO `corbeille` (`id`, `deleteArchive`, `id_admin`, `dateSuppression`) VALUES
(1, '{\"titreDocument\":\"house\",\"categorie\":\"reunions\",\"descriptions\":\"etat d\'avancement  sur UI\",\"fichierArchive\":\"http:\\/\\/localhost\\/Hive\\/API\\/documents\\/archives\\/2_Fiche de Professions.pdf\",\"dateSauvegarde\":\"2023-05-27 12:49:59\"}', 2, '2023-05-27 12:06:01'),
(2, '{\"titreDocument\":\"Back-end Hive\",\"categorie\":\"reunions\",\"descriptions\":\"\\t\\r\\nEtat d\'avancement Hive Back-end\",\"fichierArchive\":\"http:\\/\\/localhost\\/Hive\\/API\\/documents\\/archives\\/1_Article.pdf\",\"dateSauvegarde\":\"2023-05-27 12:25:45\"}', 1, '2023-06-17 20:58:45');

-- --------------------------------------------------------

--
-- Structure de la table `historique`
--

DROP TABLE IF EXISTS `historique`;
CREATE TABLE IF NOT EXISTS `historique` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `nomTable` varchar(100) NOT NULL,
  `id_user` int(11) NOT NULL,
  `valeurPrecedente` longtext NOT NULL,
  `valeurActuelle` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL,
  `actions` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL,
  `dateModification` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  KEY `FK_HISTORIQUE_USERS` (`id_user`)
) ENGINE=InnoDB AUTO_INCREMENT=33 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Déchargement des données de la table `historique`
--

INSERT INTO `historique` (`id`, `nomTable`, `id_user`, `valeurPrecedente`, `valeurActuelle`, `actions`, `dateModification`) VALUES
(1, 'archives', 2, '{\"titreDocument\":\"house\",\"categorie\":\"reunions\",\"descriptions\":\"Etat d\\\\\'avanc\\u00e9 back-end\",\"fichierArchive\":\"http:\\/\\/localhost\\/Hive\\/API\\/documents\\/archives\\/2_Fiche de Professions.pdf\"}', '{\"titreDocument\":\"house\",\"categorie\":\"reunions\",\"descriptions\":\"Etat d\\\\\'avanc\\u00e9 back-end\",\"fichierArchive\":\"http:\\/\\/localhost\\/Hive\\/API\\/documents\\/archives\\/2_Fiche de Professions.pdf\"}', 'Création', '2023-05-27 12:06:33'),
(19, 'users', 2, '{\"imgProfile\":\"\"}', '{\"N_imgProfile\":\"http:\\/\\/localhost\\/Hive\\/API\\/documents\\/profil\\/2_WIN_20220223_15_33_31_Pro.jpg\"}', 'Modification', '2023-05-27 19:04:57'),
(20, 'users', 2, '{\"imgProfile\":\"http:\\/\\/localhost\\/Hive\\/API\\/documents\\/profil\\/2_WIN_20220223_15_33_31_Pro.jpg\"}', '{\"N_imgProfile\":\"\"}', 'Suppression', '2023-05-27 19:05:20'),
(21, 'users', 2, '{\"username\":\"wdmc\"}', '{\"N_username\":\"wdmc1\"}', 'Modification', '2023-05-27 19:05:58'),
(22, 'users', 2, '{\"nom\":\"Wagsong1\"}', '{\"N_nom\":\"Wagsong2\"}', 'Modification', '2023-05-27 19:06:31'),
(23, 'users', 2, '{\"username\":\"wdmc1\",\"nom\":\"Wagsong2\"}', '{\"N_username\":\"wdmc\",\"N_nom\":\"Wagsong1\"}', 'Modification', '2023-05-27 19:06:50'),
(24, 'archives', 1, '{\"titreDocument\":\"back-end hive\"}', '{\"N_titreDocument\":\"Back-end Hive\"}', 'Modification', '2023-05-27 19:07:54'),
(25, 'archives', 1, '{\"categorie\":projets}', '{\"N_categorie\":\"reunions\"}', 'Modification', '2023-05-27 19:11:48'),
(26, 'archives', 1, '{\"fichierArchive\":\"http:\\/\\/localhost\\/Hive\\/API\\/documents\\/archives\\/1_Article.pdf\"}', '{\"N_fichierArchive\":\"http:\\/\\/localhost\\/Hive\\/API\\/documents\\/archives\\/1_Article.pdf\"}', 'Modification', '2023-05-27 19:19:37'),
(27, 'archives', 1, '{\"descriptions\":\"Etat d\'avancement Hive back-end\"}', '{\"N_descriptions\":\"\\t\\\\r\\\\nEtat d\\\\\'avancement Hive Back-end\"}', 'Modification', '2023-05-27 19:20:56'),
(31, 'users', 2, '{\"statut\":Super Admin}', '{\"N_statut\":\"admin\"}', 'Modification', '2023-05-27 19:44:58'),
(32, 'users', 1, '{\"statut\":\"Super Admin\"}', '{\"N_statut\":\"admin\"}', 'Modification', '2023-06-12 14:54:16');

-- --------------------------------------------------------

--
-- Structure de la table `users`
--

DROP TABLE IF EXISTS `users`;
CREATE TABLE IF NOT EXISTS `users` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `username` varchar(191) NOT NULL,
  `nom` varchar(191) NOT NULL,
  `mdpasse` varchar(191) NOT NULL,
  `imgProfile` varchar(191) NOT NULL,
  `rol` int(10) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Déchargement des données de la table `users`
--

INSERT INTO `users` (`id`, `username`, `nom`, `mdpasse`, `imgProfile`, `rol`) VALUES
(1, 'MC', 'Wagsong', 'ab4f63f9ac65152575886860dde480a1', '', 0),
(2, 'wdmc', 'Wagsong1', '755c41988f8b530034c7803c26f44796', '', 1);

--
-- Contraintes pour les tables déchargées
--

--
-- Contraintes pour la table `archives`
--
ALTER TABLE `archives`
  ADD CONSTRAINT `FK_OFRES_USERS` FOREIGN KEY (`id_admin`) REFERENCES `users` (`id`) ON DELETE RESTRICT ON UPDATE RESTRICT;

--
-- Contraintes pour la table `corbeille`
--
ALTER TABLE `corbeille`
  ADD CONSTRAINT `FK_CORBEILLE_USERS` FOREIGN KEY (`id_admin`) REFERENCES `users` (`id`) ON DELETE RESTRICT ON UPDATE RESTRICT;

--
-- Contraintes pour la table `historique`
--
ALTER TABLE `historique`
  ADD CONSTRAINT `FK_HISTORIQUE_USERS` FOREIGN KEY (`id_user`) REFERENCES `users` (`id`) ON DELETE RESTRICT ON UPDATE RESTRICT;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
