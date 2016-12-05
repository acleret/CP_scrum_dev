ALTER TABLE `burdown_chart`
  DROP FOREIGN KEY `burdown_chart_ibfk_1`,
  DROP FOREIGN KEY `burdown_chart_ibfk_2`;
ALTER TABLE `inter_dev_projet`
  DROP FOREIGN KEY `inter_dev_projet_ibfk_1`,
  DROP FOREIGN KEY `inter_dev_projet_ibfk_2`;
ALTER TABLE `projet`
  DROP FOREIGN KEY `projet_ibfk_1`,
  DROP FOREIGN KEY `projet_ibfk_2`;
ALTER TABLE `sprint`
  DROP FOREIGN KEY `sprint_ibfk_1`;
ALTER TABLE `tache`
  DROP FOREIGN KEY `tache_ibfk_1`,
  DROP FOREIGN KEY `tache_ibfk_2`;
ALTER TABLE `us`
  DROP FOREIGN KEY `us_ibfk_1`,
  DROP FOREIGN KEY `us_ibfk_2`;

TRUNCATE TABLE `burdown_chart`;
TRUNCATE TABLE `projet`;
TRUNCATE TABLE `developpeur`;
TRUNCATE TABLE `inter_dev_projet`;
TRUNCATE TABLE `sprint`;
TRUNCATE TABLE `tache`;
TRUNCATE TABLE `us`;

ALTER TABLE `burdown_chart`
  ADD CONSTRAINT `burdown_chart_ibfk_1` FOREIGN KEY (`SPR_id`) REFERENCES `sprint` (`SPR_id`),
  ADD CONSTRAINT `burdown_chart_ibfk_2` FOREIGN KEY (`PRO_id`) REFERENCES `projet` (`PRO_id`);
ALTER TABLE `inter_dev_projet`
  ADD CONSTRAINT `inter_dev_projet_ibfk_1` FOREIGN KEY (`DEV_id`) REFERENCES `developpeur` (`DEV_id`),
  ADD CONSTRAINT `inter_dev_projet_ibfk_2` FOREIGN KEY (`PRO_id`) REFERENCES `projet` (`PRO_id`);
ALTER TABLE `projet`
  ADD CONSTRAINT `projet_ibfk_1` FOREIGN KEY (`DEV_idProductOwner`) REFERENCES `developpeur` (`DEV_id`),
  ADD CONSTRAINT `projet_ibfk_2` FOREIGN KEY (`DEV_idScrumMaster`) REFERENCES `developpeur` (`DEV_id`);
ALTER TABLE `sprint`
  ADD CONSTRAINT `sprint_ibfk_1` FOREIGN KEY (`PRO_id`) REFERENCES `projet` (`PRO_id`);
ALTER TABLE `tache`
  ADD CONSTRAINT `tache_ibfk_1` FOREIGN KEY (`DEV_id`) REFERENCES `developpeur` (`DEV_id`),
  ADD CONSTRAINT `tache_ibfk_2` FOREIGN KEY (`US_id`) REFERENCES `us` (`US_id`);
ALTER TABLE `us`
  ADD CONSTRAINT `us_ibfk_1` FOREIGN KEY (`PRO_id`) REFERENCES `projet` (`PRO_id`),
  ADD CONSTRAINT `us_ibfk_2` FOREIGN KEY (`SPR_id`) REFERENCES `sprint` (`SPR_id`);

INSERT INTO `developpeur` (`DEV_prenom`, `DEV_nom`, `DEV_pseudo`, `DEV_mdp`, `DEV_mail`, `DEV_urlAvatar`, `DEV_dateCreation`) VALUES
("Thomas", "VIGUE", "tvigue", "mdp", "thomas.vigue@etu.u-bordeaux.fr", "https://cdn1.iconfinder.com/data/icons/ninja-things-1/1772/ninja-simple-512.png", Now()),
("Nathalie", "CRAEYE", "ncraeye", "mdp", "nathalie.craeye@etu.u-bordeaux.fr", "https://cdn3.iconfinder.com/data/icons/avatars-9/145/Avatar_Panda-512.png", Now()),
("Anthony", "CLERET", "acleret", "mdp", "anthony.cleret@etu.u-bordeaux.fr", "", Now());

INSERT INTO `projet`(`PRO_nom`, `PRO_client`, `PRO_description`, `PRO_dateCreation`, `DEV_idProductOwner`, `DEV_idScrumMaster`) VALUES
("projet SCRUM", "Xavier Blanc", "Un site web de gestion de projet qui utilise la m&#233thode scrum. Les utilisateur pourront s\'inscrire sur le site, inscrire un nouveau projet, lui affecter des d&#233veloppeurs (utilisateurs), &#233titer le backlog, organiser les sprints, affecter des user stories &#224 chaque sprint, &#233diter le kanban et visualiser l\'avanc&#233e du projet via le burndown chart. <br><br>

lien github : https://github.com/acleret/CP_scrum_demo", Now(), 1, 3);

INSERT IGNORE INTO `inter_dev_projet` (`DEV_id`, `PRO_id`) VALUES
(1,1),(2,1),(3,1);

INSERT INTO `sprint` (`SPR_numero` , `SPR_dateDebut` , `SPR_duree` , `PRO_id`) VALUES
(1, '2016-10-24', '14', 1),
(2, '2016-11-07', '14', 1),
(3, '2016-11-21', '14', 1);

INSERT INTO `us` (`US_numero`, `US_nom`, `US_chiffrageAbstrait`, `US_priorite`, `US_dateCreation`, `US_dateDernierCommit`, `US_idDernierCommit`, `US_auteurDernierCommit`, `PRO_id`, `SPR_id`) VALUES
(1, 'En tant que visiteur je souhaite m’inscrire en tant que développeur.', '5', '1', '2016-10-24', NULL, NULL, NULL, 1, NULL),
(2, 'En tant que visiteur je souhaite m’identifier en tant que développeur.', '3', '1', '2016-10-24', NULL, NULL, NULL, 1, NULL),
(3, 'En tant que développeur je souhaite visualiser/modifier mon profil.', '2', '5', '2016-10-24', NULL, NULL, NULL, 1, NULL),
(4, 'En tant que visiteur/développeur je souhaite visualiser la liste des projets.', '3', '1', '2016-10-24', NULL, NULL, NULL, 1, NULL),
(5, 'En tant que développeur je souhaite repérer et accéder partout sur le site aux projets auxquels je suis associé et à ceux auxquels je ne le suis pas.', '3', '5', '2016-10-24', NULL, NULL, NULL, 1, NULL),
(6, 'En tant que visiteur/développeur je souhaite visualiser la fiche récapitulative d’un projet.', '2', '1', '2016-10-24', NULL, NULL, NULL, 1, NULL),
(7, 'En tant que développeur je souhaite ajouter/éditer/supprimer mes projets.', '8', '1', '2016-10-24', NULL, NULL, NULL, 1, NULL);
(8, '', '', '', '2016-10-24', NULL, NULL, NULL, 1, NULL),
(9, '', '', '', '2016-10-24', NULL, NULL, NULL, 1, NULL),
(10, '', '', '', '2016-10-24', NULL, NULL, NULL, 1, NULL),
(11, '', '', '', '2016-10-24', NULL, NULL, NULL, 1, NULL),
(12, '', '', '', '2016-10-24', NULL, NULL, NULL, 1, NULL),
(13, '', '', '', '2016-10-24', NULL, NULL, NULL, 1, NULL),
(14, '', '', '', '2016-10-24', NULL, NULL, NULL, 1, NULL),
(15, '', '', '', '2016-10-24', NULL, NULL, NULL, 1, NULL),
(16, '', '', '', '2016-10-24', NULL, NULL, NULL, 1, NULL),
(17, '', '', '', '2016-10-24', NULL, NULL, NULL, 1, NULL),
(18, '', '', '', '2016-10-24', NULL, NULL, NULL, 1, NULL),
(19, '', '', '', '2016-10-24', NULL, NULL, NULL, 1, NULL),
(20, '', '', '', '2016-10-24', NULL, NULL, NULL, 1, NULL),
(21, '', '', '', '2016-10-24', NULL, NULL, NULL, 1, NULL),
(22, '', '', '', '2016-10-24', NULL, NULL, NULL, 1, NULL),
(23, '', '', '', '2016-10-24', NULL, NULL, NULL, 1, NULL),
(24, '', '', '', '2016-10-24', NULL, NULL, NULL, 1, NULL);
