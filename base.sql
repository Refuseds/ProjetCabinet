-- phpMyAdmin SQL Dump
-- version 4.7.7
-- https://www.phpmyadmin.net/
--
-- Hôte : localhost:8889
-- Généré le :  ven. 18 mai 2018 à 07:14
-- Version du serveur :  5.6.38
-- Version de PHP :  7.2.1

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";

--
-- Base de données :  `BaseCabinet`
--

-- --------------------------------------------------------

--
-- Structure de la table `Medecin`
--

CREATE TABLE `Medecin` (
  `civilite` varchar(4) NOT NULL,
  `nom` varchar(50) NOT NULL,
  `prénom` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Structure de la table `Patient`
--

CREATE TABLE `Patient` (
  `Civilite` varchar(4) NOT NULL,
  `Nom` varchar(50) NOT NULL,
  `Prenom` varchar(50) NOT NULL,
  `Adresse` varchar(50) NOT NULL,
  `Date naissance` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `lieu naissance` varchar(50) NOT NULL,
  `numero secu` bigint(20) NOT NULL,
  `fk_medecins` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Structure de la table `rendezvous`
--

CREATE TABLE `rendezvous` (
  `date` date NOT NULL,
  `heure` time NOT NULL,
  `duree` time NOT NULL,
  `fk_patient` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
