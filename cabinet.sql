-- phpMyAdmin SQL Dump
-- version 4.7.9
-- https://www.phpmyadmin.net/
--
-- Hôte : 127.0.0.1:3306
-- Généré le :  ven. 18 mai 2018 à 08:00
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
-- Structure de la table `medecin`
--

DROP TABLE IF EXISTS `medecin`;
CREATE TABLE IF NOT EXISTS `medecin` (
  `civilite` tinyint(1) NOT NULL,
  `nom` varchar(50) NOT NULL,
  `prenom` varchar(50) NOT NULL,
  `pkmedecin` int(11) NOT NULL AUTO_INCREMENT,
  PRIMARY KEY (`pkmedecin`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

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
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Structure de la table `rdv`
--

DROP TABLE IF EXISTS `rdv`;
CREATE TABLE IF NOT EXISTS `rdv` (
  `date` timestamp NOT NULL,
  `heure` time NOT NULL,
  `duree` time NOT NULL,
  `pkrdv` int(11) NOT NULL AUTO_INCREMENT,
  `fkpatient` int(11) NOT NULL,
  `fkmedecin` int(11) NOT NULL,
  PRIMARY KEY (`pkrdv`),
  KEY `fkmedecin` (`fkmedecin`),
  KEY `fkpatient` (`fkpatient`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
