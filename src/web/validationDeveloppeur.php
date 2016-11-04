<?php
   require_once("../web/config.php");

	if (isset($_POST["prenom"]) && isset($_POST["nom"]) && isset($_POST["pseudo"]) && isset($_POST["mdp"]) && isset($_POST["repetemdp"]) && isset($_POST["mail"]) && isset($_POST["repetemail"])){
		//echo "(Re)Bonjour sur votre outil CMMI préféré !";

		//echo $_POST["prenom"]." | ".$_POST["nom"]." | ".$_POST["pseudo"]." | ".$_POST["mdp"]." | ".$_POST["repetemdp"]." | ".$_POST["mail"]." | ".$_POST["repetemail"];
		
		if (strcmp($_POST["mdp"], $_POST["repetemdp"]) != 0){
			if(isset($_SESSION["session"]) && $_SESSION["session"] == true)
				header("Location:../web/formulaireProfil.php?erreur=repetemdp");
			else
				header("Location:../web/inscription.php?erreur=repetemdp");
		} else {
			if (strcmp($_POST["mail"], $_POST["repetemail"]) != 0) {
				if(isset($_SESSION["session"]) && $_SESSION["session"] == true)
					header("Location:../web/formulaireProfil.php?erreur=repetemail");
				else
					header("Location:../web/inscription.php?erreur=repetemail");
			} else {
				if ($db->testPseudoDeveloppeur($_POST["pseudo"])) {
					if(isset($_SESSION["session"]) && $_SESSION["session"] == true)
						header("Location:../web/formulaireProfil.php?erreur=pseudo");
					else
						header("Location:../web/inscription.php?erreur=pseudo");
				} else {
					if ($db->testMailDeveloppeur($_POST["mail"])) {
						if(isset($_SESSION["session"]) && $_SESSION["session"] == true)
							header("Location:../web/formulaireProfil.php?erreur=mail1");
						else
							header("Location:../web/inscription.php?erreur=mail1");
					} else {
						if (isset($_POST["url"])) {
							$url = $_POST["url"];
						}
						else
							$url = "";

						if(isset($_SESSION["session"]) && $_SESSION["session"] == true) {
							if ($db->modifDeveloppeur($_SESSION["id_co"], $_POST["prenom"], $_POST["nom"], $_POST["pseudo"], $_POST["mdp"], $_POST["mail"], $url)) {
								//Variables du formulaire
								$mdp = $_POST['mdp'];
								$mail = $_POST['mail'];
								$nom = $_POST['nom'];
								 
								// Mail
								$objet = 'Confirmation de la modification de votre profil' ;
								$contenu = '
								<html>
								<body>
								   <p>Bonjour Mr/Mme '.$nom.'</p>
								   <p>blablablabla</p>
								</body>
								</html>'; 
								$entetes = 'Content-type: text/html; charset=utf-8' . "\r\n" .
								'From: nathalie.craeye@etu.u-bordeaux.fr' . "\r\n" .
								'Reply-To: nathalie.craeye@etu.u-bordeaux.fr' . "\r\n" .
								'X-Mailer: PHP/' . phpversion();
														 
								//Envoi d'un mail de confirmation
								mail($mail, $objet, $contenu, $entetes);

								header("Location: profil.php");
							} else
								header("Location: ../web/formulaireProfil.php?erreur=dev");
						} else {
							if ($db->ajoutNouveauDeveloppeur($_POST["prenom"], $_POST["nom"], $_POST["pseudo"], $_POST["mdp"], $_POST["mail"], $url))
								header("Location: connexion.php");
							else
								header("Location: ../web/inscription.php?erreur=dev");
						}
					}
				}
			}
		}
	}
	else
		header("Location: index.php");
?>