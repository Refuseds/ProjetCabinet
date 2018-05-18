-- phpMyAdmin SQL Dump
-- version 4.7.9
-- https://www.phpmyadmin.net/
--
-- Hôte : 127.0.0.1:3306
-- Généré le :  ven. 18 mai 2018 à 08:18
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
-- Base de données :  `cabinet`
--

-- --------------------------------------------------------

--
-- Structure de la table `login`
--

DROP TABLE IF EXISTS `login`;
CREATE TABLE IF NOT EXISTS `login` (
  `identifiant` varchar(50) NOT NULL,
  `password` varchar(50) NOT NULL,
  `pklogin` int(11) NOT NULL AUTO_INCREMENT,
  PRIMARY KEY (`pklogin`)
) ENGINE=MyISAM AUTO_INCREMENT=5 DEFAULT CHARSET=latin1;

--
-- Déchargement des données de la table `login`
--

INSERT INTO `login` (`identifiant`, `password`, `pklogin`) VALUES
('root', 'root', 1),
('admin', 'admin', 2);

-- --------------------------------------------------------

--
-- Structure de la table `medecin`
--

DROP TABLE IF EXISTS `medecin`;
CREATE TABLE IF NOT EXISTS `medecin` (
  `civilite` tinyint(1) NOT NULL,
  `nom` varchar(50) NOT NULL,
  `prenom` varchar(50) NOT NULL,
  `pkmedecin` int(11) NOT NULL AUTO_INCREMENT,
  PRIMARY KEY (`pkmedecin`)
) ENGINE=MyISAM AUTO_INCREMENT=3 DEFAULT CHARSET=latin1;

--
-- Déchargement des données de la table `medecin`
--

INSERT INTO `medecin` (`civilite`, `nom`, `prenom`, `pkmedecin`) VALUES
(1, 'scalpel', 'beltran', 1),
(0, 'CroqMort', 'francois', 2);

-- --------------------------------------------------------

--
-- Structure de la table `patient`
--

DROP TABLE IF EXISTS `patient`;
CREATE TABLE IF NOT EXISTS `patient` (
  `civilite` tinyint(1) NOT NULL,
  `nom` varchar(50) NOT NULL,
  `prenom` varchar(50) NOT NULL,
  `adresse` varchar(200) NOT NULL,
  `datenaissance` timestamp NOT NULL,
  `lieunaissance` varchar(50) NOT NULL,
  `numsecurite` bigint(15) NOT NULL,
  `pkpatient` int(11) NOT NULL AUTO_INCREMENT,
  `fkmedecin` int(11) DEFAULT NULL,
  PRIMARY KEY (`pkpatient`),
  KEY `fkmedecin` (`fkmedecin`)
) ENGINE=MyISAM AUTO_INCREMENT=4 DEFAULT CHARSET=latin1;

--
-- Déchargement des données de la table `patient`
--

INSERT INTO `patient` (`civilite`, `nom`, `prenom`, `adresse`, `datenaissance`, `lieunaissance`, `numsecurite`, `pkpatient`, `fkmedecin`) VALUES
(1, 'Romero', 'Diego', '42 rue des haricots', '2014-09-09 22:00:00', 'Mexico', 1234958438, 1, NULL),
(0, 'Poussard', 'Sebastien', '42 rue des toncar', '2018-02-13 23:00:00', 'Corbeil', 12345678912, 2, 1),
(1, 'Blobu', 'Frank', '84 rue des soleils', '2010-05-01 22:00:00', 'Paris', 84394839489, 3, 2);

-- --------------------------------------------------------

--
-- Structure de la table `rdv`
--

DROP TABLE IF EXISTS `rdv`;
CREATE TABLE IF NOT EXISTS `rdv` (
  `date` timestamp NOT NULL,
  `heure` time NOT NULL,
  `duree` time NOT NULL DEFAULT '00:30:00',
  `pkrdv` int(11) NOT NULL AUTO_INCREMENT,
  `fkpatient` int(11) NOT NULL,
  `fkmedecin` int(11) NOT NULL,
  PRIMARY KEY (`pkrdv`),
  KEY `fkmedecin` (`fkmedecin`),
  KEY `fkpatient` (`fkpatient`)
) ENGINE=MyISAM AUTO_INCREMENT=3 DEFAULT CHARSET=latin1;

--
-- Déchargement des données de la table `rdv`
--

INSERT INTO `rdv` (`date`, `heure`, `duree`, `pkrdv`, `fkpatient`, `fkmedecin`) VALUES
('2018-07-11 22:00:00', '08:37:00', '03:00:00', 1, 1, 1),
('2018-05-29 22:00:00', '00:37:00', '00:19:00', 2, 2, 2);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
