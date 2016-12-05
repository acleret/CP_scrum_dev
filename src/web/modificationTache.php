<?php
require_once("../web/config.php");

// Partie pour modifier juste l'état de la tâche
if (isset($_POST["id_tache"]) && isset($_POST["etat_tache"])) {
	$id_tache = $_POST["id_tache"];
	$etat_tache = $_POST["etat_tache"];

	$tache = $db->infosTache($id_tache);
	$idUS_tache = $tache->fetch_assoc()["US_id"];
	
	$expire = time() + 60 * 60 * 24; // 24 heures
	$us = $db->infosUserStory($idUS_tache);
	$idSprint_us = $us->fetch_assoc()["SPR_id"];
	setcookie("id_sprint", $idSprint_us, $expire);

	if (isset($_COOKIE["id_projet"]) && isset($_SESSION["session"])) {
		if ($db->estMembreProjet($_COOKIE["id_projet"], $_SESSION["id_co"])) {
			if ($db->testIDTache($id_tache)) {
				if ($db->modifEtatTache($id_tache, $etat_tache)) {
					header("Location: ../web/kanban.php?modifEtat=OK");
					exit();		
				}
			} else {
				header("Location: ../web/kanban.php?modif=erreurID");
				exit();
			}
		} else {
			header("Location: ../web/kanban.php?modifEtat=pasConnecte");
			exit();
		}
	} else {
		header("Location: ../web/kanban.php?modifEtat=pasConnecte");
		exit();
	}
}
	
// Partie pour mettre à jour toutes les infos de la tâche
if (isset($_COOKIE["id_projet"]) && isset($_SESSION["session"])) {
	if ($db->estMembreProjet($_COOKIE["id_projet"], $_SESSION["id_co"])) {
		if (isset($_POST["id_tache"])) {
			$id_tache = $_POST["id_tache"];
			if ($db->testIDTache($id_tache)) {

				$nom = isset($_POST["nom"]) ? htmlspecialchars($_POST["nom"]) : "";
				$etat = isset($_POST["etat"]) ? htmlspecialchars($_POST["etat"]) : "";;
				$description = isset($_POST["description"]) ? htmlspecialchars($_POST["description"]) : "";
				$nbJours = isset($_POST["nbJours"]) ? $_POST["nbJours"] : 0;
				$dateDepart = isset($_POST["dateDepart"]) ? $_POST["dateDepart"] : "10/10/2016";
				$id_dev = isset($_POST["responsable"]) ? $_POST["responsable"] : $_SESSION["id_co"];
				$id_us = isset($_POST["us"]) ? $_POST["us"] : 0;

				$expire = time() + 60 * 60 * 24; // 24 heures
				$us = $db->infosUserStory($id_us);
				$id_sprint_us = $us->fetch_assoc()["SPR_id"];
				setcookie("id_sprint", $id_sprint_us, $expire);
				
				if ($db->modifTache($id_tache, $nom, $description, $nbJours, $dateDepart, $etat, $id_dev, $id_us)) {
					header("Location: ../web/kanban.php?modif=OK");
					exit();
				} else {
					header("Location: ../web/kanban.php?modif=erreur");
					exit();
				}
			} else {
				header("Location: ../web/kanban.php?modif=erreurID");
				exit();
			}
		} else {
      header("Location: ../web/index.php");
      exit();
    }
	}	else {
		header("Location: ../web/index.php");
		exit();
	}
} else {
	header("Location: ../web/index.php");
	exit();
}
?>