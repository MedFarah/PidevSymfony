-- phpMyAdmin SQL Dump
-- version 4.7.4
-- https://www.phpmyadmin.net/
--
-- Hôte : 127.0.0.1:3306
-- Généré le :  mer. 17 juin 2020 à 17:41
-- Version du serveur :  5.5.15
-- Version de PHP :  5.6.31

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de données :  `pidev3`
--

-- --------------------------------------------------------

--
-- Structure de la table `commande`
--

DROP TABLE IF EXISTS `commande`;
CREATE TABLE IF NOT EXISTS `commande` (
  `ref_cmd` varchar(760) NOT NULL,
  `ref_user` int(11) NOT NULL,
  `date_cmd` date NOT NULL,
  `etat_cmd` varchar(1000) NOT NULL,
  `prix_cmd` float NOT NULL,
  PRIMARY KEY (`ref_cmd`),
  KEY `ref_user` (`ref_user`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Déchargement des données de la table `commande`
--

INSERT INTO `commande` (`ref_cmd`, `ref_user`, `date_cmd`, `etat_cmd`, `prix_cmd`) VALUES
('test1', 44, '2020-06-17', 'En cours', 20000);

-- --------------------------------------------------------

--
-- Structure de la table `entreprise`
--

DROP TABLE IF EXISTS `entreprise`;
CREATE TABLE IF NOT EXISTS `entreprise` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `nom` varchar(255) NOT NULL,
  `marque` varchar(255) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=12 DEFAULT CHARSET=latin1;

--
-- Déchargement des données de la table `entreprise`
--

INSERT INTO `entreprise` (`id`, `nom`, `marque`) VALUES
(1, 'esprit', 'Atala'),
(2, 'esprit', 'Atom'),
(3, 'esprit', 'BH Bikes'),
(4, 'esprit', 'BTwin '),
(5, 'esprit', 'Bike By Me'),
(6, 'esprit', 'Cannondale Bicycles (US)'),
(7, 'esprit', 'Canyon (DE) '),
(8, 'esprit', 'Carraro Cicli (IT)'),
(9, 'esprit', 'Cervélo Cycles (CA)'),
(10, 'esprit', 'CKT Carbone (FR)'),
(11, 'esprit', 'Colnago (IT)');

-- --------------------------------------------------------

--
-- Structure de la table `evenements`
--

DROP TABLE IF EXISTS `evenements`;
CREATE TABLE IF NOT EXISTS `evenements` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `nom_evenements` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `nombre` int(11) NOT NULL,
  `dateeve` date NOT NULL,
  `datedebut` time DEFAULT NULL,
  `datefin` time DEFAULT NULL,
  `lieuxeve` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `descreptioneve` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `image` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Déchargement des données de la table `evenements`
--

INSERT INTO `evenements` (`id`, `nom_evenements`, `nombre`, `dateeve`, `datedebut`, `datefin`, `lieuxeve`, `descreptioneve`, `image`, `updated_at`) VALUES
(2, 'adasdas', 55, '2021-05-05', '00:00:00', '07:00:00', 'sadasdasdasd', 'dsaasdasdas', 'cyclingrace.jpg', NULL);

-- --------------------------------------------------------

--
-- Structure de la table `fos_user`
--

DROP TABLE IF EXISTS `fos_user`;
CREATE TABLE IF NOT EXISTS `fos_user` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `username` varchar(180) COLLATE utf8_unicode_ci NOT NULL,
  `username_canonical` varchar(180) COLLATE utf8_unicode_ci NOT NULL,
  `email` varchar(180) COLLATE utf8_unicode_ci NOT NULL,
  `email_canonical` varchar(180) COLLATE utf8_unicode_ci NOT NULL,
  `enabled` tinyint(1) NOT NULL,
  `salt` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `password` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `last_login` datetime DEFAULT NULL,
  `confirmation_token` varchar(180) COLLATE utf8_unicode_ci DEFAULT NULL,
  `password_requested_at` datetime DEFAULT NULL,
  `roles` longtext COLLATE utf8_unicode_ci NOT NULL COMMENT '(DC2Type:array)',
  `adresse` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `tel` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `dateCreation` datetime NOT NULL,
  `nomComplet` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `UNIQ_957A647992FC23A8` (`username_canonical`),
  UNIQUE KEY `UNIQ_957A6479A0D96FBF` (`email_canonical`),
  UNIQUE KEY `UNIQ_957A6479C05FB297` (`confirmation_token`)
) ENGINE=InnoDB AUTO_INCREMENT=45 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Déchargement des données de la table `fos_user`
--

INSERT INTO `fos_user` (`id`, `username`, `username_canonical`, `email`, `email_canonical`, `enabled`, `salt`, `password`, `last_login`, `confirmation_token`, `password_requested_at`, `roles`, `adresse`, `tel`, `dateCreation`, `nomComplet`) VALUES
(0, 'Farah', 'farah', 'hamouchka7@gmail.com', 'hamouchka7@gmail.com', 1, NULL, '$2y$13$MK1VG5mTnsAgPp4.a8wqMeBVzefxfGSKpIJ0cHmdadn0VtXuIX3y6', '2020-06-10 11:55:16', NULL, NULL, 'a:1:{i:0;s:10:\"ROLE_ADMIN\";}', 'Elaouina Rue Mongi Slim Jardins Elaouina', '52441279', '2020-06-04 14:05:58', 'Mohamed'),
(37, 'FaresAdmin', 'faresadmin', 'faresbenslama95@gmail.com', 'faresbenslama95@gmail.com', 1, NULL, '$2y$13$iKSqa/Oh5hTItYvGeU9oBOs5x4qfAAW6k21JvVZ87GU2r8P9lxYyy', '2020-06-01 14:15:33', NULL, NULL, 'a:1:{i:0;s:10:\"ROLE_ADMIN\";}', 'asdasda saddas', '12345678', '2020-04-07 21:20:34', 'Fares Ben Slama'),
(38, 'FaresAgent', 'faresagent', 'fares.benslama@esprit.tn', 'fares.benslama@esprit.tn', 1, NULL, '$2y$13$MTOEMPk5Q0w8iWAssv/2vewLGzUAnn1EwzTZkZ0kAaS4yHurnxTHq', '2020-06-01 14:58:27', NULL, NULL, 'a:1:{i:0;s:10:\"ROLE_AGENT\";}', 'asdasda saddas', '12345678', '2020-04-07 21:21:54', 'Ahmed Ghrabli'),
(39, 'FaresClient', 'faresclient', 'f_benslama@yahoo.fr', 'f_benslama@yahoo.fr', 1, NULL, '$2y$13$QchI9krxSYG.3Q/DkSNPSOF7mtdJb4e1wRVal7D21ciiKtLoKUUoW', '2020-05-17 14:55:04', '3pqre7Jfedn0hPbcgY3OxxmUD6ldhLdatA6rnTsH5RU', NULL, 'a:0:{}', 'asdasda saddas', '12345678', '2020-04-07 21:25:07', 'Fares Ben Slama'),
(40, 'Clients', 'clients', 'faresbenssslama95@gmail.com', 'faresbenssslama95@gmail.com', 1, NULL, '$2y$13$1MsrZwe8P8Spap4H3qysHePHc/8FEBLuMvVeDZkrJXDP2DL5paVxm', '2020-04-14 21:21:42', 'uIz9dl-5YXe2x5UR3pHeQkTsRPwyZWVthaOYshEUxKA', NULL, 'a:1:{i:0;s:11:\"ROLE_CLIENT\";}', 'asdasda saddas', '12345678', '2020-04-14 20:24:52', 'Fares'),
(41, 'FaresAgents', 'faresagents', 'f_benslama@yahoso.fr', 'f_benslama@yahoso.fr', 1, NULL, '$2y$13$z3lRCgOUiGqsAgHBg6V3peMa7L71qgcDmnRO0L.rEVLMex8aW6Jtq', NULL, 'il2ygOLTdKDVFyqoKWtuqCDQYgx1SZWZV1LwM6al1TI', NULL, 'a:1:{i:0;s:10:\"ROLE_AGENT\";}', 'asdasda saddas', '12345678', '2020-05-15 21:20:07', 'Lamis'),
(42, 'AchrefClient', 'achrefclient', 'adasd@dsa.com', 'adasd@dsa.com', 1, NULL, '$2y$13$pimo54hZ2tknv4dTxvFpKeZN13oKdlbSB0ObcblfOBqBN9kFKsQRG', '2020-05-17 14:57:06', 'EJfBuD99HbdQHeI-5Y5ksnD03dN-b6KP7WvHpIIwmyA', NULL, 'a:1:{i:0;s:11:\"ROLE_CLIENT\";}', 'asdasda saddas', '12345678', '2020-05-17 14:56:01', 'Achref'),
(44, 'chadi', 'chadi', 'chadisassi@gmaill.com', 'chadisassi@gmaill.com', 1, NULL, '$2y$13$1f/ziR7SpjtAoQhaSXiLBOhgcpeX.LuGpVmdXARPL/KQ9DDBkh4Ue', '2020-06-17 15:53:34', NULL, NULL, 'a:1:{i:0;s:10:\"ROLE_ADMIN\";}', 'tunis,tunis', '78945623', '2020-06-17 15:52:21', 'chadi');

-- --------------------------------------------------------

--
-- Structure de la table `livraison`
--

DROP TABLE IF EXISTS `livraison`;
CREATE TABLE IF NOT EXISTS `livraison` (
  `titre` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `etat` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `adresse` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `prix` double NOT NULL,
  `tel` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `dateCreation` datetime NOT NULL,
  `dateLivraison` datetime DEFAULT NULL,
  `agent_id` int(11) NOT NULL,
  `client_id` int(11) NOT NULL,
  `id` int(11) NOT NULL AUTO_INCREMENT,
  PRIMARY KEY (`id`),
  KEY `IDX_A60C9F1F3414710B` (`agent_id`),
  KEY `IDX_A60C9F1F19EB6921` (`client_id`)
) ENGINE=InnoDB AUTO_INCREMENT=35 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Déchargement des données de la table `livraison`
--

INSERT INTO `livraison` (`titre`, `etat`, `adresse`, `prix`, `tel`, `dateCreation`, `dateLivraison`, `agent_id`, `client_id`, `id`) VALUES
('adsadasda', 'Livrée', 'asdasdasdasd', 44444, '54847894', '2020-04-29 01:52:28', '2020-05-15 01:38:10', 38, 39, 25),
('asdasdasda', 'Livrée', 'sadasdasdas', 66, '25478124', '2020-05-05 02:01:34', '2020-05-05 04:40:30', 41, 40, 26),
('sdasdasdaassas', 'en cours', 'dsaasdasdasdas', 66, '12345678', '2020-05-15 21:20:46', NULL, 41, 39, 30),
('sdasdasdaassas', 'Livrée', 'dsaasdasdasdas', 5, '12345678', '2020-05-27 11:50:03', '2020-05-27 14:10:43', 38, 42, 33),
('asdasdasdas', 'en cours', 'saddddddddddddddd', 44, '12345678', '2020-05-27 11:54:10', NULL, 38, 39, 34);

-- --------------------------------------------------------

--
-- Structure de la table `notification`
--

DROP TABLE IF EXISTS `notification`;
CREATE TABLE IF NOT EXISTS `notification` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `title` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `description` longtext COLLATE utf8_unicode_ci NOT NULL,
  `icon` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `route` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `route_parameters` longtext COLLATE utf8_unicode_ci COMMENT '(DC2Type:array)',
  `notification_date` datetime NOT NULL,
  `seen` tinyint(1) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=24 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Déchargement des données de la table `notification`
--

INSERT INTO `notification` (`id`, `title`, `description`, `icon`, `route`, `route_parameters`, `notification_date`, `seen`) VALUES
(19, 'Nouvelle Livraison', 'Nouvelle Livraison a été ajoutée ', NULL, 'livraison_view', 'a:1:{s:2:\"id\";i:31;}', '2020-05-27 07:49:08', 0),
(20, 'Nouvelle Livraison', 'Nouvelle Livraison a été ajoutée ', NULL, 'livraison_view', 'a:1:{s:2:\"id\";i:32;}', '2020-05-27 08:13:19', 0),
(21, 'Nouvelle Confirmation Livraison', 'Nouvelle Confirmation Livraison a été ajoutée ', NULL, 'livraison_agent', 'a:1:{s:2:\"id\";i:39;}', '2020-05-27 08:16:35', 0),
(22, 'Nouvelle Livraison', 'Nouvelle Livraison a été ajoutée ', NULL, 'livraison_view', 'a:1:{s:2:\"id\";i:33;}', '2020-05-27 11:50:03', 0),
(23, 'Nouvelle Livraison', 'Nouvelle Livraison a été ajoutée ', NULL, 'livraison_view', 'a:1:{s:2:\"id\";i:34;}', '2020-05-27 11:54:10', 0);

-- --------------------------------------------------------

--
-- Structure de la table `participants`
--

DROP TABLE IF EXISTS `participants`;
CREATE TABLE IF NOT EXISTS `participants` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `idUser` int(11) DEFAULT NULL,
  `idEvenements` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `IDX_7169709263FECAEA` (`idEvenements`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Déchargement des données de la table `participants`
--

INSERT INTO `participants` (`id`, `idUser`, `idEvenements`) VALUES
(1, NULL, NULL),
(2, NULL, NULL),
(3, 42, NULL),
(4, 42, 2);

-- --------------------------------------------------------

--
-- Structure de la table `produit`
--

DROP TABLE IF EXISTS `produit`;
CREATE TABLE IF NOT EXISTS `produit` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `nom` varchar(255) NOT NULL,
  `description` varchar(1000) NOT NULL,
  `couleur` varchar(255) NOT NULL,
  `prix` int(11) NOT NULL,
  `prixt` double NOT NULL,
  `remise` int(11) NOT NULL,
  `prixr` double NOT NULL,
  `image` varchar(255) DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  `marque` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `UNIQ_29A5EC275A6F91CE` (`marque`)
) ENGINE=MyISAM AUTO_INCREMENT=115 DEFAULT CHARSET=latin1;

--
-- Déchargement des données de la table `produit`
--

INSERT INTO `produit` (`id`, `nom`, `description`, `couleur`, `prix`, `prixt`, `remise`, `prixr`, `image`, `updated_at`, `marque`) VALUES
(108, 'VELOBECANE', 'PANIER ET SACOCHE INCLUS', 'BLANC', 293, 395.55, 20, 316.44, '1.jpg', '2020-05-21 15:42:05', 1),
(7, 'POMPE À MAIN COMPACT ROUTE NOIRE', 'Reference: 8543541', 'NOIR', 42, 56.7, 10, 51.03, 'pompe-a-main-compact-route-noire.jpg', '2020-04-06 22:14:16', 7),
(8, 'SONNETTE VELO 100 UNIVERSEL', 'Reference: 8486978', 'Noir', 10, 13.5, 0, 13.5, 'sonnette-velo-100-universel.jpg', '2020-04-06 22:15:46', 8),
(9, 'ANTIVOL VELO U 920 ART2', 'Reference: 8385309', 'Noir/Gris', 99, 133.65, 5, 126.9675, 'antivol-velo-u-920-art2.jpg', '2020-04-06 22:17:30', 9),
(10, 'ECLAIRAGE VELO LED CL 500 AVANT/ARRIERE', 'Reference: 8402869', 'JAUNE', 35, 47.25, 0, 47.25, 'eclairage-velo-led-cl-500-avant-arriere-jaune-usb.jpg', '2020-04-06 22:19:46', 10),
(11, 'Cannondale Topstone', 'Carbon 105,2020', 'black pearl', 2300, 3105, 15, 2639.25, 'Cannondale_Topstone_Carbon_105_black_pearl[640x480].jpg', '2020-04-07 22:47:58', 11);

-- --------------------------------------------------------

--
-- Structure de la table `reclamation`
--

DROP TABLE IF EXISTS `reclamation`;
CREATE TABLE IF NOT EXISTS `reclamation` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `typeReclamation` varchar(45) NOT NULL,
  `dateReclamation` date NOT NULL,
  `image` varchar(250) DEFAULT NULL,
  `status` varchar(45) NOT NULL,
  `email` varchar(45) NOT NULL,
  `objet` varchar(45) NOT NULL,
  `description` varchar(255) NOT NULL,
  `id_user` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `id_user` (`id_user`)
) ENGINE=InnoDB AUTO_INCREMENT=42 DEFAULT CHARSET=latin1;

--
-- Déchargement des données de la table `reclamation`
--

INSERT INTO `reclamation` (`id`, `typeReclamation`, `dateReclamation`, `image`, `status`, `email`, `objet`, `description`, `id_user`) VALUES
(2, 'Location', '2020-02-15', 'No picture', 'Traité', 'hamouchka7@gmail.com', '', '2', 0),
(3, 'Commande', '2020-02-15', 'No picture', 'En traitement', '', '', '', 0),
(7, 'Maintenance', '2020-02-12', '86b1522fbb04e9fecf96df14c7aab9ca.jpeg', 'En traitement', 'test@', 'obj', 'Description', 0),
(8, 'Maintenance', '2020-02-13', 'No picture', 'En traitement', '', '', '', 0),
(9, 'Commande', '2020-02-12', 'No picture', 'En traitement', '', '', '', 0),
(11, 'Location', '2020-02-13', 'C:+Users+ASUS+Desktop+pi.jpg', '', '', '', '', 0),
(13, 'Evenement', '2020-02-13', '86b1522fbb04e9fecf96df14c7aab9ca.jpeg', '', '', '', '', 0),
(14, 'Commande', '2020-02-16', 'No picture', 'Traité', '', '', '', 0),
(15, 'Commande', '2020-02-16', 'No picture', 'En attente', 'test@', 'jnmmm', 'Description', 0),
(16, 'Evenement', '2020-02-16', 'No picture', 'En attente', 'test@', 'jnmmm', 'Description', 0),
(17, 'Evenement', '2020-02-16', 'No picture', 'En attente', 'test@', 'jnmmm', 'Description', 0),
(18, 'Evenement', '2020-02-16', 'No picture', 'En attente', 'test@', 'jnmmm', 'Description', 0),
(19, 'Maintenance', '2020-02-17', 'C:+Users+ASUS+Desktop+Nopic.png', 'En attente', 'test@', 'test', 'test', 2),
(39, 'Location', '2020-02-22', '86b1522fbb04e9fecf96df14c7aab9ca.jpeg', 'En attente', 'test@', 'fff', 'Description', 2),
(40, 'Location', '2020-02-22', '86b1522fbb04e9fecf96df14c7aab9ca.jpeg', 'En attente', 'test@', 'obj', 'Description', 2),
(41, 'Maintenance', '2020-06-04', '86b1522fbb04e9fecf96df14c7aab9ca.jpeg', 'En attente', 'hamouchka7@gmail.com', 'Reclamation', 'DEscription', 43);

-- --------------------------------------------------------

--
-- Structure de la table `reclamations`
--

DROP TABLE IF EXISTS `reclamations`;
CREATE TABLE IF NOT EXISTS `reclamations` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `titre` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `sujet` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `dateCreation` datetime NOT NULL,
  `livraison_id` int(11) NOT NULL,
  `agent_id` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `IDX_1CAD6B768E54FB25` (`livraison_id`),
  KEY `IDX_1CAD6B763414710B` (`agent_id`)
) ENGINE=InnoDB AUTO_INCREMENT=24 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
