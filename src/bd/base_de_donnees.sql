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
-- Base de données: `acleret`
--

CREATE DATABASE `CP_scrum` DEFAULT CHARACTER SET latin1 COLLATE latin1_swedish_ci;
USE `CP_scrum`;
-- --------------------------------------------------------

--
-- Structure de la table `DEVELOPPEUR`
--

CREATE TABLE IF NOT EXISTS `DEVELOPPEUR` (
  `DEV_id` int(11) NOT NULL auto_increment,
  `DEV_prenom` varchar(20) NOT NULL,
  `DEV_nom` varchar(20) NOT NULL,
  `DEV_pseudo` varchar(20) NOT NULL,
  `DEV_mdp` varchar(20) NOT NULL,
  `DEV_mail` varchar(100) NOT NULL,
  `DEV_urlAvatar` varchar(100) NOT NULL,
  PRIMARY KEY  (`DEV_id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

--
-- Contenu de la table `DEVELOPPEUR`
--


-- --------------------------------------------------------

--
-- Structure de la table `INTER_DEV_PROJET`
--

CREATE TABLE IF NOT EXISTS `INTER_DEV_PROJET` (
  `DEV_id` int(11) NOT NULL,
  `PRO_id` int(11) NOT NULL,
  PRIMARY KEY  (`DEV_id`,`PRO_id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Contenu de la table `INTER_DEV_PROJET`
--


-- --------------------------------------------------------

--
-- Structure de la table `PROJET`
--

CREATE TABLE IF NOT EXISTS `PROJET` (
  `PRO_id` int(11) NOT NULL auto_increment,
  `PRO_nom` varchar(20) NOT NULL,
  `PRO_client` varchar(20) NOT NULL,
  `PRO_description` text NOT NULL,
  `DEV_idProductOwner` int(11) NOT NULL,
  `DEV_idScrumMaster` int(11) NOT NULL,
  PRIMARY KEY  (`PRO_id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

--
-- Contenu de la table `PROJET`
--


-- --------------------------------------------------------

--
-- Structure de la table `SPRINT`
--

CREATE TABLE IF NOT EXISTS `SPRINT` (
  `SPR_id` int(11) NOT NULL auto_increment,
  `SPR_nom` varchar(20) NOT NULL,
  `SPR_dateDebut` date NOT NULL,
  `SPR_duree` time NOT NULL,
  `PRO_id` int(11) NOT NULL,
  PRIMARY KEY  (`SPR_id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

--
-- Contenu de la table `SPRINT`
--


-- --------------------------------------------------------

--
-- Structure de la table `TACHE`
--

CREATE TABLE IF NOT EXISTS `TACHE` (
  `TAC_id` int(11) NOT NULL auto_increment,
  `TAC_nom` varchar(250) NOT NULL,
  `TAC_description` text NOT NULL,
  `TAC_nbJours` int(11) NOT NULL,
  `TAC_dateDepart` date NOT NULL,
  `TAC_dateFin` date NOT NULL,
  `set` enum('TO DO','ON GOING','TO TEST','DONE') default NULL,
  `DEV_id` int(11) NOT NULL,
  `US_id` int(11) NOT NULL,
  PRIMARY KEY  (`TAC_id`),
  KEY `DEV_id` (`DEV_id`),
  KEY `DEV_id_2` (`DEV_id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

--
-- Contenu de la table `TACHE`
--


-- --------------------------------------------------------

--
-- Structure de la table `US`
--

CREATE TABLE IF NOT EXISTS `US` (
  `US_id` int(11) NOT NULL auto_increment,
  `US_nom` varchar(250) NOT NULL,
  `US_chiffrageAbstrait` int(11) NOT NULL,
  `US_priorite` int(11) NOT NULL,
  `US_dateDernierCommit` date NOT NULL,
  `US_idDernierCommit` varchar(250) NOT NULL,
  `US_auteurDernierCommit` varchar(20) NOT NULL,
  `SPR_id` int(11) NOT NULL,
  PRIMARY KEY  (`US_id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

--
-- Contenu de la table `US`
--
