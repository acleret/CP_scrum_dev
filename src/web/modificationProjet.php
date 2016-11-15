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
	
	if (isset($_GET["action"]) && $_GET['action']=="ajouter") {
		$nbProjetsBDD = $db->nombreProjets();
		//TODO ATTENTION  aux apostrophe dans DESCRIPTION
		
		$id_projet = $db->ajoutNouveauProjet($nom, $client, $description, $_SESSION['id_co'], $_SESSION['id_co'] /*$idPO, $idSM*/);
		$expire = time() + 60 * 60 * 24; // 24 heures
		setcookie("id_projet", $id_projet, $expire);
		header("Location: projet.php");
		exit();
	}
	else {
		if ($db->modifProjet($_COOKIE["id_projet"]/*TODO id_pro */, $nom, $client, $description, $_SESSION['id_co'], $_SESSION['id_co'] /*TODO :id_devPO, id_devSM*/)) {
			header("Location: projet.php");
			exit();
		}
	}
} else {
	header("Location: index.php");
	exit();
}
?>