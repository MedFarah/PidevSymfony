-- phpMyAdmin SQL Dump
-- version 4.7.9
-- https://www.phpmyadmin.net/
--
-- Hôte : 127.0.0.1:3306
-- Généré le :  mer. 10 juin 2020 à 14:44
-- Version du serveur :  5.7.21
-- Version de PHP :  5.6.35

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de données :  `pidev`
--

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
  `nomComplet` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `adresse` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `tel` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `dateCreation` datetime NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `UNIQ_957A647992FC23A8` (`username_canonical`),
  UNIQUE KEY `UNIQ_957A6479A0D96FBF` (`email_canonical`),
  UNIQUE KEY `UNIQ_957A6479C05FB297` (`confirmation_token`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

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
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
