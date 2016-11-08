<?php
class Requetes {

    private $conn;

	/******************************************************/
	/** Fonctions pour la connexion à la Base de Données **/
	/******************************************************/
	
    // crée la connexion
    public function __construct($servername, $username, $password, $dbname) {
        $this->conn = new mysqli($servername, $username, $password, $dbname);
    }

    // ferme la connexion
    public function __destruct() {
        $this->conn->close();
    }

    // vérifie la connexion
    public function verifConnexion() {
        return $this->conn->connect_error;
    }

	
	/************************************************/
	/** Fonctions pour la gestion des développeurs **/
	/************************************************/

    // retourne les données du développeur $id_dev
    public function infosDeveloppeur($id_dev) {
        $sql = "SELECT * FROM developpeur WHERE DEV_id = ".$id_dev.";";
        if (!$result = $this->conn->query($sql)) {
            printf("Message d'erreur: %s<br>", $this->conn->error);
        }
        return $result;
    }

    // retourne la liste des développeurs du site web
    public function listeDeveloppeurs() {
        $sql = "SELECT D.* FROM developpeur as D
                ORDER BY D.DEV_pseudo ASC;";
        if (!$result = $this->conn->query($sql)) {
            printf("Message d'erreur: %s<br>", $this->conn->error);
        }
        return $result;
    }

    // ajoute un développeur dans la BD (si le pseudo et le mail sont libres)
	// retourne vrai si il est ajouté
    public function ajoutNouveauDeveloppeur($prenom, $nom, $pseudo, $mdp, $mail, $url_avatar) {
        if ($this->testPseudoDeveloppeur($pseudo) || $this->testMailDeveloppeur($mail)) {
            return false;
        }
        $sql = "INSERT INTO developpeur (DEV_prenom, DEV_nom, DEV_pseudo, DEV_mdp, DEV_mail, DEV_urlAvatar, DEV_date_creation)
                VALUES ('".$prenom."', '".$nom."', '".$pseudo."', '".$mdp."', '".$mail."', '".$url_avatar."', Now());";
        if (!$result = $this->conn->query($sql)) {
            printf("Message d'erreur: %s<br>", $this->conn->error);
        }
        return true;
    }

    // si le pseudo d'un développeur existe retourne vrai
    public function testPseudoDeveloppeur($pseudo) {
        $sql = "SELECT * FROM developpeur WHERE DEV_pseudo = '".$pseudo."';";
        if (!$result = $this->conn->query($sql)) {
            printf("Message d'erreur: %s<br>", $this->conn->error);
        }
        $row = $result->fetch_assoc();
        if ($row["DEV_pseudo"] == $pseudo) {
            return true;
        }
        return false;
    }

    // si le mail d'un développeur existe retourne vrai
    public function testMailDeveloppeur($mail) {
        $sql = "SELECT * FROM developpeur WHERE DEV_mail = '".$mail."';";
        if (!$result = $this->conn->query($sql)) {
            printf("Message d'erreur: %s<br>", $this->conn->error);
        }
        $row = $result->fetch_assoc();
        if ($row["DEV_mail"] == $mail) {
            return true;
        }
        return false;
    }

    // modifie les données du développeur connecté
	// retourne vrai quand c'est exécuté
    public function modifDeveloppeur($id, $prenom, $nom, $pseudo, $url_avatar) {
        $sql = "UPDATE developpeur
				SET `DEV_prenom`='".$prenom."',`DEV_nom`='".$nom."',`DEV_pseudo`='".$pseudo."', `DEV_urlAvatar`='".$url_avatar."'
				WHERE DEV_id=".$id.";";
        if (!$result = $this->conn->query($sql)) {
            printf("Message d'erreur: %s<br>", $this->conn->error);
        }
        return true;
    }

    // retourne vrai si le développeur est membre du projet
    public function estMembreProjet($id_projet, $id_dev) {
        $sql = "SELECT * FROM inter_dev_projet
                WHERE PRO_id = ".$id_projet." AND DEV_id = ".$id_dev.";";
        if (!$result = $this->conn->query($sql)) {
            printf("Message d'erreur: %s<br>", $this->conn->error);
        }
        $row = $result->fetch_assoc();
        if ($row["PRO_id"] == $id_projet && $row["DEV_id"] == $id_dev) {
            return true;
        }
        return false;
    }

    // retourne vrai si le développeur $id_dev est le Scrum Master du projet
    public function estScrumMaster($id_dev, $id_pro) {
        $sql = "SELECT * FROM projet
                WHERE PRO_id=".$id_pro." AND DEV_idScrumMaster=".$id_dev.";";
        if (!$result = $this->conn->query($sql)) {
            printf("Message d'erreur: %s<br>", $this->conn->error);
        }
        if ($result->num_rows == 1)
            return true;
        else
            return false;
    }

    // retourne vrai si le développeur $id_dev est le Product Owner du projet
    public function estProductOwner($id_dev, $id_pro) {
      $sql = "SELECT * FROM projet
              WHERE PRO_id=".$id_pro." AND DEV_idProductOwner=".$id_dev.";";
      if (!$result = $this->conn->query($sql)) {
          printf("Message d'erreur: %s<br>", $this->conn->error);
      }
      if ($result->num_rows == 1)
          return true;
      else
          return false;
    }

	// si l'id d'un développeur existe retourne vrai
    public function testIDDeveloppeur($id_dev) {
        $sql = "SELECT * FROM developpeur WHERE DEV_id = ".$id_dev.";";
        if (!$result = $this->conn->query($sql)) {
            printf("Message d'erreur: %s<br>", $this->conn->error);
        }
        $row = $result->fetch_assoc();
        if ($row["DEV_id"] == $id_dev) {
            return true;
        }
        return false;
    }

    // retourne la liste des projets dont le développeur $id_dev est Product Owner
    public function listeProjetsDeveloppeurProductOwner($id_dev) {
        $sql = "SELECT * FROM projet
                WHERE DEV_idProductOwner = ".$id_dev."
                ORDER BY PRO_date_creation ASC;";
        if (!$result = $this->conn->query($sql)) {
            printf("Message d'erreur: %s<br>", $this->conn->error);
        }
        return $result;
    }
	
    // retourne la liste des projets liés au développeur $id_dev
    public function listeProjetsDeveloppeur($id_dev) {
        $sql = "SELECT P.* FROM projet as P
                INNER JOIN inter_dev_projet AS DV ON P.PRO_id = DV.PRO_id
                WHERE DV.DEV_id = ".$id_dev."
                ORDER BY P.PRO_date_creation ASC;";
        if (!$result = $this->conn->query($sql)) {
            printf("Message d'erreur: %s<br>", $this->conn->error);
        }
        return $result;
    }

    // retourne le nombre de projets liés au développeur $id_dev
    public function nombreProjetsDeveloppeur($id_dev) {
        $sql = "SELECT * FROM projet as P
                INNER JOIN inter_dev_projet AS DV ON P.PRO_id = DV.PRO_id
                WHERE DV.DEV_id = ".$id_dev.";";
        if (!$result = $this->conn->query($sql)) {
            printf("Message d'erreur: %s<br>", $this->conn->error);
        }
        return $result->num_rows;
    }

    // retourne les infos d'un développeur si les pseudo et mot de passe sont exacts
    public function testDeveloppeurConnexion($pseudo, $mdp) {
        $sql = "SELECT * FROM developpeur
                WHERE DEV_pseudo='".$pseudo."' AND DEV_mdp='".$mdp."';";
        if (!$result = $this->conn->query($sql)) {
            printf("Message d'erreur: %s<br>", $this->conn->error);
        }
        return $result;
    }

	
	/*******************************************/
	/** Fonctions pour la gestion des projets **/
	/*******************************************/
	
    // retourne les données du projet $id_pro
    public function infosProjet($id_pro) {
        $sql = "SELECT * FROM projet WHERE PRO_id = ".$id_pro.";";
        if (!$result = $this->conn->query($sql)) {
            printf("Message d'erreur: %s<br>", $this->conn->error);
        }
        return $result;
    }
	
    // retourne la liste de tous les projets enregistrés sur le site web
	// les paramètres sont optionnels car mis en place pour la pagination
    public function listeProjets($id_premiere_ligne = 0, $nb_projets_par_pages = 2000) {
        $sql = "SELECT * FROM projet
                ORDER BY PRO_date_creation ASC
                LIMIT ".$id_premiere_ligne.", ".$nb_projets_par_pages.";";
        if (!$result = $this->conn->query($sql)) {
            printf("Message d'erreur: %s<br>", $this->conn->error);
        }
        return $result;
    }

    // retourne le nombre de projets enregistrés sur le site web
    public function nombreProjets() {
        $sql = "SELECT * FROM projet";
        if (!$result = $this->conn->query($sql)) {
            printf("Message d'erreur: %s<br>", $this->conn->error);
        }
        return $result->num_rows;
    }

    // ajoute un projet dans la BD et retourne vrai si il est ajouté
	// sa date de création est celle du jour où il est enregistré
    public function ajoutNouveauProjet($nom, $client, $description, $idPO, $idSM){
        $sql = "INSERT INTO projet (PRO_nom, PRO_client, PRO_description, PRO_date_creation, DEV_idProductOwner, DEV_idScrumMaster)
                VALUES ('".$nom."', '".$client."', '".$description."', Now(), '".$idPO."', '".$idSM."');";
        if (!$result = $this->conn->query($sql)) {
            printf("Message d'erreur: %s<br>", $this->conn->error);
        }
        return true;
    }
	
	// modifie les données du projet et retourne vrai quand c'est fait
    public function modifProjet($id_pro, $nom, $client, $description, $idPO, $idSM){
        $sql = "UPDATE PROJET
        SET PRO_nom='".$nom."',PRO_client='".$client."',PRO_description='".$description."', DEV_idProductOwner='".$idPO."', DEV_idScrumMaster='".$idSM."'
        WHERE PRO_id=".$id_pro.";";
        if (!$result = $this->conn->query($sql)) {
            printf("Message d'erreur: %s<br>", $this->conn->error);
        }
        return true;
    }
	
	// retire de la BD tous les liens avec le projet en paramètre puis lui-même
	// retourne vrai une fois exécuté
    public function suppressionProjet($id_pro){
		$sql_InterDevProjet = "DELETE FROM inter_dev_projet WHERE PRO_id=".$id_pro.";";
		$sql_Sprint = "DELETE FROM sprint WHERE PRO_id=".$id_pro.";";
	    $sql_Projet = "DELETE FROM projet WHERE PRO_id=".$id_pro.";";
        if (!$result = $this->conn->query($sql_InterDevProjet)) {
			printf("Message d'erreur: %s<br>", $this->conn->error);
			return false;
		}
		else {
			if (!$result = $this->conn->query($sql_Sprint)) {
				printf("Message d'erreur: %s<br>", $this->conn->error);
				return false;
			}
			else {
				if (!$result = $this->conn->query($sql_Projet)) {
					printf("Message d'erreur: %s<br>", $this->conn->error);
					return false;
				}
				else {
					return true;
				}
			}
        }
	}

    // retourne la liste des développeurs du projet $id_pro
    public function listeDeveloppeursProjet($id_pro) {
        $sql = "SELECT D.* FROM developpeur as D
                INNER JOIN inter_dev_projet AS IDP ON D.DEV_id = IDP.DEV_id
                WHERE IDP.PRO_id = ".$id_pro."
                ORDER BY D.DEV_pseudo ASC;";
        if (!$result = $this->conn->query($sql)) {
            printf("Message d'erreur: %s<br>", $this->conn->error);
        }
        return $result;
    }

    // si l'id du projet $id_pro existe déjà retourne vrai
    public function testIDProjet($id_pro) {
        $sql = "SELECT * FROM projet WHERE PRO_id = ".$id_pro.";";
        if (!$result = $this->conn->query($sql)) {
            printf("Message d'erreur: %s<br>", $this->conn->error);
        }
        $row = $result->fetch_assoc();
        if ($row["PRO_id"] == $id_pro) {
            return true;
        }
        return false;
    }


	/*******************************************/
	/** Fonctions pour la gestion des sprints **/
	/*******************************************/

	//retourne les données du sprint $id_spr 
    public function infosSprint($id_spr) {
        $sql = "SELECT * FROM sprint WHERE SPR_id = ".$id_spr.";";
        if (!$res = $this->conn->query($sql)) {
            printf("Message d'erreur: %s<br>", $this->conn->error);
        }
        return $res;
    }
	
    // retourne la liste des sprints du projet $id_pro
    public function listeSprints($id_pro) {
        $sql = "SELECT * FROM sprint 
                WHERE PRO_id = ".$id_pro."
                ORDER BY SPR_dateDebut ASC;";
        if (!$result = $this->conn->query($sql)) {
            printf("Message d'erreur: %s<br>", $this->conn->error);
        }
        return $result;
    }

    // si l'id du sprint existe déjà retourne vrai
    public function testIDSprint($id_spr) {
        $sql = "SELECT * FROM sprint WHERE SPR_id = ".$id_spr.";";
        if (!$result = $this->conn->query($sql)) {
            printf("Message d'erreur: %s<br>", $this->conn->error);
        }
        $row = $result->fetch_assoc();
        if ($row["SPR_id"] == $id_spr) {
            return true;
        }
        return false;
    }

}
?>
