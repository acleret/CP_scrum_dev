-- phpMyAdmin SQL Dump
-- version 3.1.2deb1ubuntu0.2
-- http://www.phpmyadmin.net
--
-- Serveur: localhost
-- Généré le : Mar 25 Octobre 2016 à 11:35
-- Version du serveur: 5.0.75
-- Version de PHP: 5.2.6-3ubuntu4.6

SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";

--
-- Base de données: `CP_scrum`
--

CREATE DATABASE `CP_scrum` DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci;
USE `CP_scrum`;
-- --------------------------------------------------------

--
-- Structure de la table `DEVELOPPEUR`
--

CREATE TABLE IF NOT EXISTS `DEVELOPPEUR` (
  `DEV_id` int(11) NOT NULL AUTO_INCREMENT,
  `DEV_prenom` varchar(255) NOT NULL,
  `DEV_nom` varchar(255) NOT NULL,
  `DEV_pseudo` varchar(20) NOT NULL,
  `DEV_mdp` varchar(255) NOT NULL,
  `DEV_mail` varchar(255) NOT NULL,
  `DEV_urlAvatar` varchar(255),
  `DEV_date_creation` date DEFAULT NULL,
  PRIMARY KEY (`DEV_id`),
  CONSTRAINT UC_DEVELOPPEUR_PSEUDO UNIQUE (`DEV_pseudo`),
  CONSTRAINT UC_DEVELOPPEUR_MAIL UNIQUE (`DEV_mail`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1;

--
-- Contenu de la table `DEVELOPPEUR`
--


-- --------------------------------------------------------

--
-- Structure de la table `PROJET`
--

CREATE TABLE IF NOT EXISTS `PROJET` (
  `PRO_id` int(11) NOT NULL AUTO_INCREMENT,
  `PRO_nom` varchar(255) NOT NULL,
  `PRO_client` varchar(255) NOT NULL,
  `PRO_description` text NOT NULL,
  `PRO_date_creation` date DEFAULT NULL,
  `DEV_idProductOwner` int(11) NOT NULL,
  `DEV_idScrumMaster` int(11) NOT NULL,
  PRIMARY KEY (`PRO_id`),
  FOREIGN KEY (`DEV_idProductOwner`) REFERENCES DEVELOPPEUR(`DEV_id`),
  FOREIGN KEY (`DEV_idScrumMaster`) REFERENCES DEVELOPPEUR(`DEV_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1;

--
-- Contenu de la table `PROJET`
--


-- --------------------------------------------------------

--
-- Structure de la table `INTER_DEV_PROJET`
--

CREATE TABLE IF NOT EXISTS `INTER_DEV_PROJET` (
  `DEV_id` int(11) NOT NULL,
  `PRO_id` int(11) NOT NULL,
  PRIMARY KEY (`DEV_id`,`PRO_id`),
  FOREIGN KEY (`DEV_id`) REFERENCES DEVELOPPEUR(`DEV_id`),
  FOREIGN KEY (`PRO_id`) REFERENCES PROJET(`PRO_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Contenu de la table `INTER_DEV_PROJET`
--


-- --------------------------------------------------------

--
-- Structure de la table `SPRINT`
--

CREATE TABLE IF NOT EXISTS `SPRINT` (
  `SPR_id` int(11) NOT NULL AUTO_INCREMENT,
  `SPR_nom` varchar(255) NOT NULL,
  `SPR_dateDebut` date NOT NULL,
  `SPR_duree` time NOT NULL,
  `PRO_id` int(11) NOT NULL,
  PRIMARY KEY (`SPR_id`),
  FOREIGN KEY (`PRO_id`) REFERENCES PROJET(`PRO_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1;

--
-- Contenu de la table `SPRINT`
--


-- --------------------------------------------------------

--
-- Structure de la table `US`
--

CREATE TABLE IF NOT EXISTS `US` (
  `US_id` int(11) NOT NULL AUTO_INCREMENT,
  `US_nom` varchar(255) NOT NULL,
  `US_chiffrageAbstrait` int(11) NOT NULL,
  `US_priorite` int(11) NOT NULL,
  `US_dateDernierCommit` date NOT NULL,
  `US_idDernierCommit` varchar(255) NOT NULL,
  `US_auteurDernierCommit` varchar(255) NOT NULL,
  `SPR_id` int(11) NOT NULL,
  PRIMARY KEY (`US_id`),
  FOREIGN KEY (`SPR_id`) REFERENCES SPRINT(`SPR_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1;

--
-- Contenu de la table `US`
--


-- --------------------------------------------------------

--
-- Structure de la table `TACHE`
--

CREATE TABLE IF NOT EXISTS `TACHE` (
  `TAC_id` int(11) NOT NULL AUTO_INCREMENT,
  `TAC_nom` varchar(255) NOT NULL,
  `TAC_description` text NOT NULL,
  `TAC_nbJours` int(11) NOT NULL,
  `TAC_dateDepart` date NOT NULL,
  `TAC_dateFin` date NOT NULL,
  `set` enum('TO DO','ON GOING','TO TEST','DONE') default NULL,
  `DEV_id` int(11) NOT NULL,
  `US_id` int(11) NOT NULL,
  PRIMARY KEY (`TAC_id`),
  FOREIGN KEY (`DEV_id`) REFERENCES DEVELOPPEUR(`DEV_id`),
  FOREIGN KEY (`US_id`) REFERENCES US(`US_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1;

--
-- Contenu de la table `TACHE`
--
