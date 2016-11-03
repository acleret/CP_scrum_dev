<?php
class Requetes {

    private $conn;

    // créé la connexion
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

    // ajoute un developpeur dans la BD (si le pseudo et le mail sont libre) et retourne vrai si il est ajouté
    public function ajoutNouveauDeveloppeur($prenom, $nom, $pseudo, $mail, $mdp, $url_avatar) {
        if ($this->testPseudoDeveloppeur($pseudo) || $this->testMailDeveloppeur($mail)) {
            return false;
        }
        $sql = "INSERT INTO DEVELOPPEUR (DEV_prenom, DEV_nom, DEV_pseudo, DEV_mail, DEV_mdp, DEV_urlAvatar, DEV_date_creation)
            VALUES ('".$prenom."', '".$nom."', '".$pseudo."', '".$mail."', '".$mdp."', '".$url_avatar."', Now());";
        if (!$result = $this->conn->query($sql)) {
            printf("Message d'erreur: %s<br>\n", $this->conn->error);
        }
        return true;
    }

    // si le pseudo d'un developpeur existe retourne vrai
    public function testPseudoDeveloppeur($pseudo) {
        $sql = "SELECT * FROM DEVELOPPEUR WHERE DEV_pseudo = '".$pseudo."';";
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
        $sql = "SELECT * FROM DEVELOPPEUR WHERE DEV_mail = '".$mail."';";
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
        $sql = "SELECT * FROM DEVELOPPEUR WHERE DEV_id = ".$id_dev.";";
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
        $sql = "SELECT * FROM DEVELOPPEUR WHERE DEV_id = ".$id_dev.";";
        if (!$result = $this->conn->query($sql)) {
            printf("Message d'erreur: %s<br>\n", $this->conn->error);
        }
        return $result;
    }

    // retourne la liste des projets lié à un developpeur
    public function listeProjetsDeveloppeur($id_dev) {
        $sql = "SELECT P.* FROM PROJET as P
            INNER JOIN INTER_DEV_PROJET AS DV ON P.PRO_id = DV.PRO_id
            WHERE DV.DEV_id = ".$id_dev."
            ORDER BY P.PRO_date_creation ASC;";
        if (!$result = $this->conn->query($sql)) {
            printf("Message d'erreur: %s<br>\n", $this->conn->error);
        }
        return $result;
    }

    // retourne le nombre de projets lié à un developpeur
    public function nombreProjetsDeveloppeur($id_dev) {
        $sql = "SELECT * FROM PROJET as P
            INNER JOIN INTER_DEV_PROJET AS DV ON P.PRO_id = DV.PRO_id
            WHERE DV.DEV_id = ".$id_dev.";";
        if (!$result = $this->conn->query($sql)) {
            printf("Message d'erreur: %s<br>\n", $this->conn->error);
        }
        return $result->num_rows;
    }

    // retourne la liste de tous les projets (parametres optionnels pour la pagination)
    public function listeProjets($id_premiere_ligne = 0, $nb_projets_par_pages = 2000) {
        $sql = "SELECT * FROM PROJET
    ORDER BY PRO_date_creation ASC
    LIMIT ".$id_premiere_ligne.", ".$nb_projets_par_pages.";";
        if (!$result = $this->conn->query($sql)) {
            printf("Message d'erreur: %s<br>\n", $this->conn->error);
        }
        return $result;
    }

    // retourne le nombre de projets
    public function nombreProjets() {
        $sql = "SELECT * FROM PROJET";
        if (!$result = $this->conn->query($sql)) {
            printf("Message d'erreur: %s<br>\n", $this->conn->error);
        }
        return $result->num_rows;
    }

    // retourne vrai si le developpeur est membre du projet
    public function estMembreProjet($id_projet, $id_dev) {
        $sql = "SELECT * FROM INTER_DEV_PROJET
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
        $sql = "SELECT * FROM PROJET WHERE PRO_id = ".$id_pro.";";
        if (!$result = $this->conn->query($sql)) {
            printf("Message d'erreur: %s<br>\n", $this->conn->error);
        }
        return $result;
    }

    // retourne vrai si un projet existe 
    public function testIDProjet($id_pro){
        $sql = "SELECT * FROM PROJET WHERE PRO_id = ".$id_pro.";";
        if (!$result = $this->conn->query($sql)) {
            printf("Message d'erreur: %s<br>\n", $this->conn->error);
        }
        $row = $result->fetch_assoc();
        if ($row["PRO_id"] == $id_pro) {
            return true;
        }
        return false;
    }

    // retourne la liste des développeurs d'un projet
    public function listeDeveloppeursProjet($id_pro){
        $sql = "SELECT D.* FROM DEVELOPPEUR as D
            INNER JOIN INTER_DEV_PROJET AS IDP ON D.DEV_id = IDP.DEV_id
            WHERE IDP.PRO_id = ".$id_pro."
            ORDER BY D.DEV_pseudo ASC;";
        if (!$result = $this->conn->query($sql)) {
            printf("Message d'erreur: %s<br>\n", $this->conn->error);
        }
        return $result;     
    }
      
  
}
?>
