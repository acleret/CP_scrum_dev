<?php
require_once("../web/config.php");

if (!isset($_SESSION["id_dev"])){

    $s->head("Inscription");
    $s->header();
    $s->nav($db);
?>

    <article>
    <div class="col-sm-8 text-left">
    <h2>Inscription</h2>
    <form class="col-xs-offset-2" method="post" action="../web/creationDeveloppeur.php">
<?php
    if (isset($_GET["erreur"])){
        if(!strcmp($_GET["erreur"], "dev"))
            echo "Erreur : le developpeur n'a pas été créé";
    }
?>    
    <p>
    <input type="text" name="prenom" maxlength="255" placeholder="Prénom" required/>
    </p>
    <p>
    <input type="text" name="nom" maxlength="255" placeholder="Nom" required/>
    </p>
    <p>
    <input type="text" name="pseudo" maxlength="20" placeholder="Pseudo" required/>
<?php
    if (isset($_GET["erreur"])){
        if(!strcmp($_GET["erreur"], "pseudo"))
            echo "Erreur : le pseudo existe déjà";
    }
?>  
    </p>
    <p>
    <input type="password" name="mdp" maxlength="255" placeholder="Mot de passe" required/>
    </p>
    <p>
    <input type="password" name="repetemdp" maxlength="255" placeholder="Répéter mot de passe" required/>
<?php
    if (isset($_GET["erreur"])){
        if(!strcmp($_GET["erreur"], "repetemdp"))
            echo "Erreur : les mots de passe sont différents";
    }
?>
    </p>
    <p>
    <input type="text" name="mail" maxlength="255" placeholder="Adresse Email" required/>
<?php
    if (isset($_GET["erreur"])){
        if(!strcmp($_GET["erreur"], "mail"))
            echo "Erreur : le mail existe déjà";
    }
?>  
    </p>
    <p>
    <input type="text" name="repetemail"  maxlength="255" placeholder="Répéter adresse Email" required/>
<?php
    if (isset($_GET["erreur"])){
        if(!strcmp($_GET["erreur"], "repetemail"))
            echo "Erreur : les mails sont différents";
    }
?>  
    </p>
    <p>
    <input type="text" name="url" maxlength="255" placeholder="URL image avatar"/>
    </p>
    <p>
    <input class="btn btn-primary" type="submit" value="S'inscrire">
    </p>
  
    </form>
    </div>
    </article>

<?php $s->footer();
}
else
    header("Location: ../web/listeProjets.php");
?> 


