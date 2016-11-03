<?php
   require_once("../web/config.php");

if (isset($_POST["prenom"]) && isset($_POST["nom"]) && isset($_POST["pseudo"]) && isset($_POST["mdp"]) && isset($_POST["repetemdp"]) && isset($_POST["mail"]) && isset($_POST["repetemail"])){
    echo "bonjour";

    echo $_POST["prenom"]." | ".$_POST["nom"]." | ".$_POST["pseudo"]." | ".$_POST["mdp"]." | ".$_POST["repetemdp"]." | ".$_POST["mail"]." | ".$_POST["repetemail"];
    
    if (strcmp($_POST["mdp"], $_POST["repetemdp"]) != 0){
        header("Location:../web/inscription.php?erreur=repetemdp");
    } else {
        if (strcmp($_POST["mail"], $_POST["repetemail"]) != 0) {
        header("Location:../web/inscription.php?erreur=repetemail");
        } else {
            if ($db->testPseudoDeveloppeur($_POST["pseudo"])) {
                header("Location:../web/inscription.php?erreur=pseudo");
            } else {
                if ($db->testMailDeveloppeur($_POST["mail"])) {
                    header("Location:../web/inscription.php?erreur=mail");
                } else {
                    if (isset($_POST["url"])) {
                        $url = $_POST["url"];
                    }
                    else
                        $url = "";

  
                    if ($db->ajoutNouveauDeveloppeur($_POST["prenom"], $_POST["nom"], $_POST["pseudo"], $_POST["mdp"], $_POST["mail"], $url))
                        header("Location: ../web/listeProjets.php");
                    else
                        header("Location: ../web/inscription.php?erreur=dev");
                }
            }
        }
    }
}

else
    header("Location: ../web/inscription.php");

?>
