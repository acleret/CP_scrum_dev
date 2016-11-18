<?php
require_once("config.php");

if (isset($_SESSION["session"])) {
	if (isset($_POST["nom"]) && isset($_POST["client"]) && isset($_POST["descr"])) {
		$nom = $_POST["nom"];
		$client = $_POST["client"];
		$description = $_POST["descr"];
	}
	
	if (isset($_POST["idPO"]))
		$id_PO = $_POST["idPO"];
	else
		$id_PO = $_SESSION["id_co"];
	
	if (isset($_GET["action"]) && $_GET["action"]=="ajouter") {
		//TODO ATTENTION aux apostrophe dans DESCRIPTION
		
		$id_projet = $db->ajouterProjetBDD($nom, $client, $description, $_SESSION['id_co'], $_SESSION['id_co'], $_SESSION['id_co'] /*$idPO, $idSM, idDev*/);
		$expire = time() + 60 * 60 * 24; // 24 heures
		setcookie("id_projet", $id_projet, $expire);
		header("Location: projet.php");
		exit();
	}
	else if (isset($_GET["action"]) && $_GET["action"]=="éditer") {
		// depuis le bouton "Modifier" de listeProjets.php
		echo $_POST["idProjet"]." test ".$_POST["pageActuelle"];
		if (isset($_POST["idProjet"]) && isset($_POST["pageActuelle"])) { 
			if ($db->modifProjet($_POST["idProjet"], $nom, $client, $description, $_SESSION['id_co'], $_SESSION['id_co'] /*TODO :id_devPO, id_devSM*/)) {
				header("Location: listeProjets.php?page=".$_POST["pageActuelle"]);
				exit();
			}
		} 
		// depuis le bouton "Modifier" de projet.php
		else {
			if ($db->modifProjet($_COOKIE["id_projet"], $nom, $client, $description, $_SESSION['id_co'], $_SESSION['id_co'] /*TODO :id_devPO, id_devSM*/)) {
				header("Location: projet.php");
				exit();
			}
		}
	}
	else {
		header("Location: index.php");
		exit();
	}
} else {
	header("Location: index.php");
	exit();
}
?>