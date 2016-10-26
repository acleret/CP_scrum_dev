<?php
class requetes{

    var $conn;

    //créer la connexion
    function __construct($servername, $username, $password, $dbname){
        $this->conn = new mysqli($servername, $username, $password, $dbname);
    }

    //fermer la connexion
    function __destruct(){
        $this->conn->close();
    }
    
    //vérifier la connexion
    function verifConnexion(){
        return $this->conn->connect_error;
    }

    //ajoute un developpeur dans la BD
    function nouveauDeveloppeur($prenom, $nom, $pseudo, $mail, $mdp, $url_avatar){
        $sql = "INSERT INTO DEVELOPPEUR (DEV_prenom,DEV_nom,DEV_pseudo,DEV_mail,DEV_mdp,DEV_urlAvatar) VALUES ('".$prenom."','".$nom."','".$pseudo."','".$mail."','".$mdp."','".$url_avatar."');";
        $res=$this->conn->query($sql);
        return $res;
    }
}
?>