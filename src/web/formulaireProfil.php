<?php
require_once("../web/config.php");

if (isset($_SESSION["session"]) and $_SESSION["session"] == true){

    $s->head("Mon profil - Édition");
    $s->header();
    $s->nav($db);
?>
   <SCRIPT language="JavaScript">
function verifMail() {
	a = document.Co.mail.value;
	valide1 = false;
	
	for(var j=1;j<(a.length);j++){
		if(a.charAt(j)=='@'){
			if(j<(a.length-4)){
				for(var k=j;k<(a.length-2);k++){
					if(a.charAt(k)=='.') valide1=true;
				}
			}
		}
	}
	if(valide1==false) header("Location:../web/formulaireProfil.php?erreur=mail2");
	return valide1;
}
function VerifFormulaire() {
	return verifMail();
}
</SCRIPT>

    <article>
    <div class="col-sm-8 text-left">
    <h2>Édition de mon profil</h2>
    <form class="col-xs-offset-2" method="post" name="Co" action="../web/validationDeveloppeur.php"> <!--onsubmit="VerifFormulaire()"-->
<?php
    if (isset($_GET["erreur"])){
        if(!strcmp($_GET["erreur"], "dev"))
            echo "Erreur : le développeur n'a pas été trouvé.";
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
            echo "Erreur : le pseudo existe déjà.";
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
            echo "Erreur : les mots de passe sont différents.";
    }
?>
    </p>
    <p>
    <input type="text" name="mail" maxlength="255" placeholder="Adresse mail" required/>
<?php
    if (isset($_GET["erreur"])){
        if(!strcmp($_GET["erreur"], "mail1"))
            echo "Erreur : le mail existe déjà.";
		else if(!strcmp($_GET["erreur"], "mail2"))
			echo "Erreur de format : veuillez saisir une adresse mail valide.";
    }
?>  
    </p>
    <p>
    <input type="text" name="repetemail"  maxlength="255" placeholder="Répéter adresse Email" required/>
<?php
    if (isset($_GET["erreur"])){
        if(!strcmp($_GET["erreur"], "repetemail"))
            echo "Erreur : les mails sont différents.";
    }
?>  
    </p>
    <p>
    <input type="text" name="url" maxlength="255" placeholder="URL image avatar"/>
    </p>
    <p>
    <input class="btn btn-primary" type="submit" value="Valider">
    </p>
  
    </form>
    </div>
    </article>

<?php 
	$s->footer();
} else
    header("Location: index.php");
?>