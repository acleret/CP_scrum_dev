<?php
	require_once("../web/config.php");
	
	$pseudo = $_POST['identifiant'];
	$mdp = $_POST['motDePasse'];
	
	$requete = $db->verifDevExistant($pseudo, $mdp);
	
	$donnees = $requete->fetch_assoc();
		
	if($donnees['nb_devs'] == 0 ) // si 0 alors on renvoie la page d'accueil du site
		header('Location: index.php');
	else // si au moins 1 de trouvé alors on met en place la session
	{
		$_SESSION['session'] = true;
		$_SESSION['id_co'] = $donnees['DEV_id'];
		$_SESSION['pseudo_co'] = $donnees['DEV_pseudo'];
		$_SESSION['email_co'] = $donnees['DEV_mail'];
		$_SESSION['image_co'] = $donnees['DEV_urlAvatar'];
		$_SESSION['nom_co'] = $donnees['DEV_nom'];
		$_SESSION['prenom_co'] = $donnees['DEV_prenom'];

		header('Location: index.php');
	}
?>