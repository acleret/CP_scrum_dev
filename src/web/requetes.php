<?php
class Requetes {

    private $conn;

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

    // ajoute un développeur dans la BD (si le pseudo et le mail sont libres) et retourne vrai si il est ajouté
    public function ajoutNouveauDeveloppeur($prenom, $nom, $pseudo, $mdp, $mail, $url_avatar) {
        if ($this->testPseudoDeveloppeur($pseudo) || $this->testMailDeveloppeur($mail)) {
            return false;
        }
        $sql = "INSERT INTO developpeur (DEV_prenom, DEV_nom, DEV_pseudo, DEV_mdp, DEV_mail, DEV_urlAvatar, DEV_date_creation)
                VALUES ('".$prenom."', '".$nom."', '".$pseudo."', '".$mdp."', '".$mail."', '".$url_avatar."', Now());";
        if (!$result = $this->conn->query($sql)) {
            printf("Message d'erreur: %s<br>\n", $this->conn->error);
        }
        return true;
    }

    // modifie les données du développeur connecté et retourne vrai quand c'est bien fait
    public function modifDeveloppeur($id, $prenom, $nom, $pseudo, $url_avatar) {
        $sql = "UPDATE developpeur
        SET `DEV_prenom`='".$prenom."',`DEV_nom`='".$nom."',`DEV_pseudo`='".$pseudo."', `DEV_urlAvatar`='".$url_avatar."'
        WHERE DEV_id=".$id.";";
        if (!$result = $this->conn->query($sql)) {
            printf("Message d'erreur: %s<br>\n", $this->conn->error);
        }
        return true;
    }

    // si le pseudo d'un developpeur existe retourne vrai
    public function testPseudoDeveloppeur($pseudo) {
        $sql = "SELECT * FROM developpeur WHERE DEV_pseudo = '".$pseudo."';";
        if (!$result = $this->conn->query($sql)) {
            printf("Message d'erreur: %s<br>\n", $this->conn->error);
        }
        $row = $result->fetch_assoc();
        if ($row["DEV_pseudo"] == $pseudo) {
            return true;
        }
        return false;
    }

    // si le mail d'un developpeur existe retourne vrai
    public function testMailDeveloppeur($mail) {
        $sql = "SELECT * FROM developpeur WHERE DEV_mail = '".$mail."';";
        if (!$result = $this->conn->query($sql)) {
            printf("Message d'erreur: %s<br>\n", $this->conn->error);
        }
        $row = $result->fetch_assoc();
        if ($row["DEV_mail"] == $mail) {
            return true;
        }
        return false;
    }

    // si l'id d'un développeur existe retourne vrai
    public function testIDDeveloppeur($id_dev) {
        $sql = "SELECT * FROM developpeur WHERE DEV_id = ".$id_dev.";";
        if (!$result = $this->conn->query($sql)) {
            printf("Message d'erreur: %s<br>\n", $this->conn->error);
        }
        $row = $result->fetch_assoc();
        if ($row["DEV_id"] == $id_dev) {
            return true;
        }
        return false;
    }

    // retourne les données d'un développeur
    public function infosDeveloppeur($id_dev) {
        $sql = "SELECT * FROM developpeur WHERE DEV_id = ".$id_dev.";";
        if (!$result = $this->conn->query($sql)) {
            printf("Message d'erreur: %s<br>\n", $this->conn->error);
        }
        return $result;
    }

    // retourne la liste des projets lié à un developpeur
    public function listeProjetsDeveloppeur($id_dev) {
        $sql = "SELECT P.* FROM projet as P
                INNER JOIN inter_dev_projet AS DV ON P.PRO_id = DV.PRO_id
                WHERE DV.DEV_id = ".$id_dev."
                ORDER BY P.PRO_date_creation ASC;";
        if (!$result = $this->conn->query($sql)) {
            printf("Message d'erreur: %s<br>\n", $this->conn->error);
        }
        return $result;
    }

    /* temporaire */
    // retourne la liste des projets ou le developpeur est ProductOwner
    public function listeProjetsDeveloppeurProductOwner($id_dev) {
        $sql = "SELECT * FROM projet
                WHERE DEV_idProductOwner = ".$id_dev."
                ORDER BY PRO_date_creation ASC;";
        if (!$result = $this->conn->query($sql)) {
            printf("Message d'erreur: %s<br>\n", $this->conn->error);
        }
        return $result;
    }

    // retourne le nombre de projets lié à un developpeur
    public function nombreProjetsDeveloppeur($id_dev) {
        $sql = "SELECT * FROM projet as P
                INNER JOIN inter_dev_projet AS DV ON P.PRO_id = DV.PRO_id
                WHERE DV.DEV_id = ".$id_dev.";";
        if (!$result = $this->conn->query($sql)) {
            printf("Message d'erreur: %s<br>\n", $this->conn->error);
        }
        return $result->num_rows;
    }

    // retourne la liste de tous les projets (parametres optionnels pour la pagination)
    public function listeProjets($id_premiere_ligne = 0, $nb_projets_par_pages = 2000) {
        $sql = "SELECT * FROM projet
                ORDER BY PRO_date_creation ASC
                LIMIT ".$id_premiere_ligne.", ".$nb_projets_par_pages.";";
        if (!$result = $this->conn->query($sql)) {
            printf("Message d'erreur: %s<br>\n", $this->conn->error);
        }
        return $result;
    }

    // retourne le nombre de projets
    public function nombreProjets() {
        $sql = "SELECT * FROM projet";
        if (!$result = $this->conn->query($sql)) {
            printf("Message d'erreur: %s<br>\n", $this->conn->error);
        }
        return $result->num_rows;
    }

    // retourne vrai si le developpeur est membre du projet
    public function estMembreProjet($id_projet, $id_dev) {
        $sql = "SELECT * FROM inter_dev_projet
                WHERE PRO_id = ".$id_projet." AND DEV_id = ".$id_dev.";";
        if (!$result = $this->conn->query($sql)) {
            printf("Message d'erreur: %s<br>\n", $this->conn->error);
        }
        $row = $result->fetch_assoc();
        if ($row["PRO_id"] == $id_projet && $row["DEV_id"] == $id_dev) {
            return true;
        }
        return false;
    }

    // retourne les données d'un projet
    public function infosProjet($id_pro) {
        $sql = "SELECT * FROM projet WHERE PRO_id = ".$id_pro.";";
        if (!$result = $this->conn->query($sql)) {
            printf("Message d'erreur: %s<br>\n", $this->conn->error);
        }
        return $result;
    }

    // retourne vrai si un projet existe
    public function testIDProjet($id_pro) {
        $sql = "SELECT * FROM projet WHERE PRO_id = ".$id_pro.";";
        if (!$result = $this->conn->query($sql)) {
            printf("Message d'erreur: %s<br>\n", $this->conn->error);
        }
        $row = $result->fetch_assoc();
        if ($row["PRO_id"] == $id_pro) {
            return true;
        }
        return false;
    }

    // retourne la liste des développeurs
    public function listeDeveloppeurs() {
        $sql = "SELECT D.* FROM developpeur as D
                ORDER BY D.DEV_pseudo ASC;";
        if (!$result = $this->conn->query($sql)) {
            printf("Message d'erreur: %s<br>\n", $this->conn->error);
        }
        return $result;
    }

    // retourne la liste des développeurs d'un projet
    public function listeDeveloppeursProjet($id_pro) {
        $sql = "SELECT D.* FROM developpeur as D
                INNER JOIN inter_dev_projet AS IDP ON D.DEV_id = IDP.DEV_id
                WHERE IDP.PRO_id = ".$id_pro."
                ORDER BY D.DEV_pseudo ASC;";
        if (!$result = $this->conn->query($sql)) {
            printf("Message d'erreur: %s<br>\n", $this->conn->error);
        }
        return $result;
    }

    // retourne les infos d'un développeur si le pseudo et mot de passe sont exact
    public function testDeveloppeurConnexion($pseudo, $mdp) {
        $sql = "SELECT * FROM developpeur
                WHERE DEV_pseudo='".$pseudo."' AND DEV_mdp='".$mdp."';";
        if (!$result = $this->conn->query($sql)) {
            printf("Message d'erreur: %s<br>\n", $this->conn->error);
        }
        return $result;
    }

    // retourne vrai si le développeur id_dev est le ScrumMaster
    // du projet id_pro
    public function estScrumMaster($id_dev, $id_pro) {
        $sql = "SELECT * FROM projet
                WHERE PRO_id=".$id_pro." AND DEV_idScrumMaster=".$id_dev.";";
        if (!$result = $this->conn->query($sql)) {
            printf("Message d'erreur: %s<br>\n", $this->conn->error);
        }
        if ($result->num_rows == 1)
            return true;
        else
            return false;
    }

    public function estProductOwner($id_dev, $id_pro) {
      $sql = "SELECT * FROM projet
              WHERE PRO_id=".$id_pro." AND DEV_idProductOwner=".$id_dev.";";
      if (!$result = $this->conn->query($sql)) {
          printf("Message d'erreur: %s<br>\n", $this->conn->error);
      }
      if ($result->num_rows == 1)
          return true;
      else
          return false;
    }
    public function listeSprints($id_pro) {
        $sql = "SELECT * FROM sprint 
                WHERE PRO_id = ".$id_pro."
                ORDER BY SPR_dateDebut ASC;";
        if (!$result = $this->conn->query($sql)) {
            printf("Message d'erreur: %s<br>\n", $this->conn->error);
        }
        return $result;
    }

    public function infosSprint($id_spr) {
        $sql = "SELECT * FROM sprint WHERE SPR_id = ".$id_spr.";";
        if (!$res = $this->conn->query($sql)) {
            printf("Message d'erreur: %s<br>\n", $this->conn->error);
        }
        return $res;
    }

    // si l'id d'un sprint existe retourne vrai
    public function testIDSprint($id_spr) {
        $sql = "SELECT * FROM sprint WHERE SPR_id = ".$id_spr.";";
        if (!$result = $this->conn->query($sql)) {
            printf("Message d'erreur: %s<br>\n", $this->conn->error);
        }
        $row = $result->fetch_assoc();
        if ($row["SPR_id"] == $id_spr) {
            return true;
        }
        return false;
    }

}
?>
