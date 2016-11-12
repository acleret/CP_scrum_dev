<?php
require_once("../web/config.php");

$test = $db;

/*****************************************************/
/** Tests des fonctions concernant les développeurs **/
/*****************************************************/

echo ("<b>/**********************************************/<br>
/** Tests des fonctions concernant les développeurs **/<br>
/*********************************************/</b><br>\n");
echo "<br>\n";

// test infosDeveloppeur
echo "<b>// test infosDeveloppeur</b><br>\n";
$id_dev = 1;
if ($test->testIDDeveloppeur($id_dev)) {
  $result = $test->infosDeveloppeur($id_dev);
  $row = $result->fetch_assoc();
  echo $row["DEV_id"]." | ".$row["DEV_prenom"]." | ".$row["DEV_nom"]." | ".$row["DEV_pseudo"]." | ".$row["DEV_mdp"]." | ".$row["DEV_mail"]." | ".$row["DEV_urlAvatar"]." | ".$row["DEV_date_creation"]."<br>\n<br>\n\n\n";
} else {
  echo "* Erreur le dév ".$id_dev." est inconnu<br>\n<br>\n";
}

// test listeDeveloppeurs
echo "<b>// test listeDeveloppeurs</b><br>\n";
$result = $test->listeDeveloppeurs();
while ($row = $result->fetch_assoc()) {
  echo $row["DEV_id"]." | ".$row["DEV_prenom"]." | ".$row["DEV_nom"]." | ".$row["DEV_pseudo"]." | ".$row["DEV_mdp"]." | ".$row["DEV_mail"]." | ".$row["DEV_urlAvatar"]." | ".$row["DEV_date_creation"]."<br>\n";
}
echo "<br>\n";

// test ajoutNouveauDeveloppeur
echo "<b>// test ajoutNouveauDeveloppeur</b><br>\n";
// expect "Développeur ajouté" (lancé la première fois)
if ($test->ajoutNouveauDeveloppeur('ptest', 'ntest', 'pstest', 'mdptest', 'mtest', NULL)) {
  echo "* Développeur ajouté<br>\n";
} else {
  echo "* Erreur pseudo ou mail déjà pris<br>\n";
}
// expect "Erreur pseudo ou mail déjà pris"
if ($test->ajoutNouveauDeveloppeur('ptest', 'ntest', 'pstest', 'mdptest', 'mtest2', NULL)) {
  echo "* Développeur ajouté<br>\n";
} else {
  echo "* Erreur pseudo ou mail déjà pris<br>\n";
}
// expect "Erreur pseudo ou mail déjà pris"
if ($test->ajoutNouveauDeveloppeur('ptest', 'ntest', 'pstest2', 'mdptest', 'mtest', NULL)) {
  echo "* Développeur ajouté<br>\n";
} else {
  echo "* Erreur pseudo ou mail déjà pris<br>\n";
}
// expect "Développeur ajouté" (lancé la première fois)
if ($test->ajoutNouveauDeveloppeur('ptest2', 'ntest2', 'pstest2', 'mdptest2', 'mtest2', NULL)) {
  echo "* Développeur ajouté<br>\n";
} else {
  echo "* Erreur pseudo ou mail déjà pris<br>\n<br>\n";
}

// test testPseudoDeveloppeur
echo "<b>// test testPseudoDeveloppeur</b><br>\n";
$pseudo = "pstest";
// expect "Le développeur existe déjà"
if ($test->testPseudoDeveloppeur($pseudo)) {
  echo "* Le développeur ".$pseudo." existe déjà<br>\n";
} else {
  echo "* Le développeur ".$pseudo." n'existe pas<br>\n";
}
$pseudo = "rien";
// expect "Le développeur n'existe pas"
if ($test->testPseudoDeveloppeur($pseudo)) {
  echo "*Le developpeur ".$pseudo." existe déjà<br>\n<br>\n";
} else {
  echo "* Le développeur ".$pseudo." n'existe pas<br>\n<br>\n";
}

// test testMailDeveloppeur
echo "<b>// test testMailDeveloppeur</b><br>\n";
$mail = "mtest";
// expect "Le mail existe bien"
if ($test->testMailDeveloppeur($mail)) {
  echo "* Le mail ".$mail." existe bien<br>\n";
} else {
  echo "* Le mail ".$mail." n'existe pas<br>\n";
}
$mail = "rien";
// expect "Le mail n'existe pas"
if ($test->testMailDeveloppeur($mail)) {
  echo "* Le mail ".$mail." existe bien<br>\n<br>\n";
} else {
  echo "* Le mail ".$mail." n'existe pas<br>\n<br>\n";
}

// test modifDeveloppeur
echo "<b>// test modifDeveloppeur</b><br>\n";
$newpseudo = "newpstest";
if (!$test->testPseudoDeveloppeur($newpseudo)) {
  $id_dev = $test->maxIDDeveloppeur();
  if ($test->modifDeveloppeur($id_dev, "bob", "bob", $newpseudo, "")) {
    echo "* Développeur modifié<br>\n<br>\n";
  } else {
    echo "* Erreur modification dev<br>\n";
  }
}
echo "<br>\n";

// test estMembreProjet
echo "<b>// test estMembreProjet</b><br>\n";
// expect "Le développeur 1 est membre du projet 1"
if ($test->estMembreProjet(1, 1)) {
  echo "* Le développeur 1 est membre du projet 1<br>\n";
} else {
    echo "* Le développeur 1 n'est pas membre du projet 1<br>\n";
}
// expect "Le développeur 1 est membre du projet 1"
if ($test->estMembreProjet(3, 1)) {
  echo "* Le développeur 1 est membre du projet 3<br>\n";
} else {
    echo "* Le développeur 1 n'est pas membre du projet 3<br>\n";
}
echo "<br>\n";

// test estScrumMaster
echo "<b>// test estScrumMaster</b><br>\n";
$id_dev = 1;
$id_pro = 1;
if ($test->estScrumMaster($id_dev, $id_pro)) {
  echo "* Le développeur ".$id_dev." est Scrum Master sur le projet ".$id_pro."<br>\n<br>\n";
} else {
  echo "* Le développeur ".$id_dev." n'est pas Scrum Master sur le projet ".$id_pro."<br>\n<br>\n";
}

// test estProductOwner
echo "<b>// test estProductOwner</b><br>\n";
$id_dev = 1;
$id_pro = 1;
if ($test->estProductOwner($id_dev, $id_pro)) {
  echo "* Le développeur ".$id_dev." est ProductOwner sur le projet ".$id_pro."<br>\n<br>\n";
} else {
  echo "* Le développeur ".$id_dev." n'est pas ProductOwner sur le projet ".$id_pro."<br>\n<br>\n";
}

// test testIDDeveloppeur
echo "<b>// test testIDDeveloppeur</b><br>\n";
$id = 1;
// expect "L'id existe déjà"
if ($test->testIDDeveloppeur($id)) {
  echo "* L'id ".$id." existe déjà<br>\n";
} else {
  echo "* L'id ".$id." n'existe pas<br>\n";
}
$id = 20000000;
// expect "L'id n'existe pas"
if ($test->testIDDeveloppeur($id)) {
  echo "* id ".$id." existe<br>\n<br>\n";
} else {
  echo "* id ".$id." n'existe pas<br>\n<br>\n";
}

// test listeProjetsDeveloppeurProductOwner
echo "<b>// test listeProjetsDeveloppeurProductOwner</b><br>\n";
$id_dev = 1; // le dev 1 est lié au projet 1, 2 et 4
$result = $test->listeProjetsDeveloppeurProductOwner($id_dev);
while ($row = $result->fetch_assoc()) {
  echo $row["PRO_id"]." | ".$row["PRO_nom"]." | ".$row["PRO_client"]." | ".$row["PRO_description"]." | ".$row["PRO_date_creation"]." | ".$row["DEV_idProductOwner"]." | ".$row["DEV_idScrumMaster"]."<br>\n";
}
echo "<br>\n";

// test listeProjetsDeveloppeur
echo "<b>// test listeProjetsDeveloppeur</b><br>\n";
$id_dev = 1; // le dev 1 est lié au projet 1, 2 et 4
$result = $test->listeProjetsDeveloppeur($id_dev);
while ($row = $result->fetch_assoc()) {
  echo $row["PRO_id"]." | ".$row["PRO_nom"]." | ".$row["PRO_client"]." | ".$row["PRO_description"]." | ".$row["PRO_date_creation"]." | ".$row["DEV_idProductOwner"]." | ".$row["DEV_idScrumMaster"]."<br>\n";
}
echo "<br>\n";

// test nombreProjetsDeveloppeur
echo "<b>// test nombreProjetsDeveloppeur</b><br>\n";
echo "Le dév n°".$id_dev." est lié à ".$test->nombreProjetsDeveloppeur($id_dev)." projets<br>\n";
echo "<br>\n";

// test testDeveloppeurConnexion
echo "<b>// test testDeveloppeurConnexion</b><br>\n\n";
$pseudo = "pstest";
$mdp = "mdptest";
$result = $test->testDeveloppeurConnexion($pseudo, $mdp);
$row = $result->fetch_assoc();
if ($result->num_rows == 1) {
  echo $row["DEV_id"]." | ".$row["DEV_prenom"]." | ".$row["DEV_nom"]." | ".$row["DEV_pseudo"]." | ".$row["DEV_mdp"]." | ".$row["DEV_mail"]." | ".$row["DEV_urlAvatar"]." | ".$row["DEV_date_creation"]."<br>\n<br>\n";
} else {
  echo "* Mauvaise combinaison pseudo et mot de passe<br>\n<br>\n";
}

/************************************************/
/** Tests des fonctions concernant les projets **/
/************************************************/

echo ("<b>/****************************************/<br>
/** Tests des fonctions concernant les projets **/<br>
/****************************************/</b><br>\n");
echo "<br>\n";

// test infosProjet
echo "<b>// test infosProjet</b><br>\n";
$id_pro = 1;
if ($test->testIDProjet($id_pro)) {
  $result = $test->infosProjet($id_pro);
  $row = $result->fetch_assoc();
  echo $row["PRO_id"]." | ".$row["PRO_nom"]." | ".$row["PRO_client"]." | ".$row["PRO_description"]." | ".$row["PRO_date_creation"]." | ".$row["DEV_idProductOwner"]." | ".$row["DEV_idScrumMaster"]."<br>\n";
} else {
  echo "* Erreur le projet ".$id_pro." est inconnu<br>\n";
}
echo "<br>\n";

// test listeProjets
echo "<b>// test listeProjets</b><br>\n";
$result = $test->listeProjets();
while ($row = $result->fetch_assoc()) {
  echo $row["PRO_id"]." | ".$row["PRO_nom"]." | ".$row["PRO_client"]." | ".$row["PRO_description"]." | ".$row["PRO_date_creation"]." | ".$row["DEV_idProductOwner"]." | ".$row["DEV_idScrumMaster"]."<br>\n";
}
echo "<br>\n";

// test nombreProjets
echo "<b>// test nombreProjets</b><br>\n";
$nb_projets = $test->nombreProjets();
echo ($nb_projets == $test->listeProjets()->num_rows)? "* bon calcul : "
.$nb_projets." projets<br>\n" : "* mauvais calcul<br>\n";
echo "<br>\n";

// test ajoutNouveauProjet
echo "<b>// test ajoutNouveauProjet</b><br>\n";
// expect "Projet créé"
if ($test->ajoutNouveauProjet("MonNouveauProjet", "Anonymous", "Projet test dans la BD", 1, 1)) {
  echo "* Projet créé<br>\n<br>\n";
} else {
  echo "* Erreur dans la création du projet<br>\n<br>\n";
}

// test modifProjet
echo "<b>// test modifProjet</b><br>\n";
// expect "Projet modifié"
$idprojet = $test->maxIDProjet();
if ($test->modifProjet($idprojet, "MonSupeeerProjet", "Anonymous", "Projet test dans la BD", 1, 1)) {
  echo "* Projet ".$idprojet." modifié<br>\n<br>\n";
} else {
  echo "* Erreur dans la modification des données du projet  ".$idprojet."<br>\n<br>\n";
}

// test suppressionProjet
echo "<b>// test suppressionProjet</b><br>\n";
// expect "Projet supprimé"
$idprojet = $test->maxIDProjet();
if ($test->suppressionProjet($test->maxIDProjet())) {
  echo "* Projet ".$idprojet." supprimé<br>\n<br>\n";
} else {
  echo "* Erreur lors de la suppression d'un projet<br>\n<br>\n";
}

// test listeDeveloppeursProjet
echo "<b>// test listeDeveloppeursProjet</b><br>\n";
$id_pro = 1; // le projet contient plusieurs développeurs
$result = $test->listeDeveloppeursProjet($id_pro);
while ($row = $result->fetch_assoc()) {
  echo $row["DEV_id"]." | ".$row["DEV_prenom"]." | ".$row["DEV_nom"]." | ".$row["DEV_pseudo"]." | ".$row["DEV_mdp"]." | ".$row["DEV_mail"]." | ".$row["DEV_urlAvatar"]." | ".$row["DEV_date_creation"]."<br>\n";
}
echo "<br>\n";

// test testIDProjet
echo "<b>// test testIDProjet</b><br>\n";
// expect "Le projet 1 existe bien"
if ($test->testIDProjet(1)) {
  echo "* Le projet 1 existe bien<br>\n";
} else {
  echo "* Le projet 1 n'existe pas<br>\n";
}
echo "<br>\n";

/******************************************************/
/** Tests des fonctions concernant les User Strories **/
/******************************************************/

echo ("<b>/**********************************************/<br>
/** Tests des fonctions concernant les User Strories **/<br>
/*********************************************/</b><br>\n");
echo "<br>\n";

// test infosUserStory
echo "<b>// test infosUserStory</b><br>\n";
$id_us = 1;
if ($test->testIDUserStory($id_us)) {
  $result = $test->infosUserStory($id_us);
  $row = $result->fetch_assoc();
  echo $row["US_id"]." | ".$row["US_nom"]." | ".$row["US_chiffrageAbstrait"]." | ".$row["US_priorite"]." | ".$row["US_dateDernierCommit"]." | ".$row["US_idDernierCommit"]." | ".$row["US_auteurDernierCommit"]." |
  ".$row["PRO_id"]." |
  ".$row["SPR_id"]."<br>\n";
} else {
  echo "* Erreur l'US ".$id_us." est inconnu<br>\n";
}
echo "<br>\n";

// test listeUserStories
echo "<b>// test listeUserStories</b><br>\n";
$id_pro = 4;
$result = $test->listeUserStories($id_pro);
while ($row = $result->fetch_assoc()) {
  echo $row["US_id"]." | ".$row["US_nom"]." | ".$row["US_chiffrageAbstrait"]." | ".$row["US_priorite"]." | ".$row["US_dateDernierCommit"]." | ".$row["US_idDernierCommit"]." | ".$row["US_auteurDernierCommit"]." |
  ".$row["PRO_id"]." |
  ".$row["SPR_id"]."<br>\n";
}
echo "<br>\n";

// test listeUserStorySprint
echo "<b>// test listeUserStorySprint</b><br>";
$id_spr = 1;
$result = $test->listeUserStorySprint($id_spr);
echo "US dans le sprint#".$id_spr."<br>";
while ($row = $result->fetch_assoc()) {
  echo $row["US_id"]." | ".$row["US_nom"]." | ".$row["US_chiffrageAbstrait"]." | ".$row["US_priorite"]." | ".$row["US_dateDernierCommit"]." | ".$row["US_idDernierCommit"]." | ".$row["US_auteurDernierCommit"]." |
  ".$row["PRO_id"]." |
  ".$row["SPR_id"]."<br>\n";
}
echo "<br>\n";

// test listeUserStoryOutOfSprint
echo "<b>// test listeUserStoryOutOfSprint</b><br>";
$id_spr = 1;
$id_pro = 1;
$result = $test->listeUserStoryOutOfSprint($id_spr, $id_pro);
echo "US dans du projet ".$id_pro." or du sprint#".$id_spr."<br>";
while ($row = $result->fetch_assoc()) {
  echo $row["US_id"]." | ".$row["US_nom"]." | ".$row["US_chiffrageAbstrait"]." | ".$row["US_priorite"]." | ".$row["US_dateDernierCommit"]." | ".$row["US_idDernierCommit"]." | ".$row["US_auteurDernierCommit"]." |
  ".$row["PRO_id"]." |
  ".$row["SPR_id"]."<br>\n";
}
echo "<br>\n";

// test ajoutUserStory
echo "<b>// test ajoutUserStory</b><br>\n";
// expect "US créé"
if ($test->ajoutUserStory("us1", 5, "NULL", 1)) {
  echo "* US créé<br>\n";
} else {
  echo "* Erreur dans la création d'une US<br>\n";
}
echo "<br>\n";

// test modifUserStory
echo "<b>// test modifUserStory</b><br>\n";
// expect "US modifié"
$id_us = $test->maxIDUserStory();
if ($test->modifUserStory($id_us, "US1Modifié", 8, "NULL", "NULL")) {
  echo "* US ".$id_us." modifié<br>\n";
} else {
  echo "* Erreur dans la modification des données d'une US ".$id_us."<br>\n";
}
echo "<br>\n";

// test modifUserStoryTracabilite
echo "<b>// test modifUserStoryTracabilite</b><br>\n";
// expect "US modifié"
$id_us = $test->maxIDUserStory();
if ($test->modifUserStoryTracabilite($id_us, "Now()", "commit_id", "developpeur responsable du commit")) {
  echo "* US ".$id_us." modifié<br>\n";
} else {
  echo "* Erreur dans la modification des données d'une US ".$id_us."<br>\n";
}
echo "<br>\n";

// test affecterUserStorySprint
echo "<b>// test affecterUserStorySprint</b><br>\n";
// expect "US affecté a u sprint"
$id_us = $test->maxIDUserStory();
$id_spr = 4;
if ($test->affecterUserStorySprint($id_us, $id_spr)) {
  echo "* US ".$id_us." affecté au sprint ".$id_spr."<br>\n";
} else {
  echo "* Erreur dans la modification des données d'une US ".$id_us."<br>\n";
}
echo "<br>\n";

// test retirerUserStorySprint
echo "<b>// test retirerUserStorySprint</b><br>\n";
// expect "US retiré du sprint"
$id_us = $test->maxIDUserStory();
$id_spr = 4;
if ($test->retirerUserStorySprint($id_us)) {
  echo "* US ".$id_us." retiré du sprint ".$id_spr."<br>\n";
} else {
  echo "* Erreur dans la modification des données d'une US ".$id_us."<br>\n";
}
echo "<br>\n";

// test suppressionUserStory
echo "<b>// test suppressionUserStory</b><br>\n";
// expect "US supprimé"
$id_us = $test->maxIDUserStory();
if ($test->testIDUserStory($id_us)) {
  if ($test->suppressionUserStory($id_us)) {
    echo "* US ".$id_us." supprimé<br>\n";
  } else {
    echo "* Erreur lors de la suppression d'une US<br>\n";
  }
} else {
  echo "* L'US ".$id_us." n'existe pas<br>\n";
}
echo "<br>\n";

// test testIDUserStory
echo "<b>// test testIDUserStory</b><br>\n";
// expect "L'US 1 existe bien"
$id_us = 1;
if ($test->testIDUserStory($id_us)) {
  echo "* L'US ".$id_us." existe bien<br>\n";
} else {
  echo "* L'US ".$id_us." n'existe pas<br>\n";
}
echo "<br>\n";



/************************************************/
/** Tests des fonctions concernant les sprints **/
/************************************************/

echo ("<b>/****************************************/<br>
/** Tests des fonctions concernant les sprints **/<br>
/****************************************/</b><br>\n");
echo "<br>\n";

// test listeSprints
echo "<b>// test listeSprints</b><br>\n";
$id_pro = 4;
$result = $test->listeSprints($id_pro);
while ($row = $result->fetch_assoc()) {
  echo $row["SPR_id"]." | ".$row["SPR_numero"]." | ".$row["SPR_dateDebut"]." | ".$row["SPR_duree"]." | ".$row["PRO_id"]."<br>\n";
}
echo "<br>\n";

// test infosSprint
echo "<b>// test infosSprint</b><br>\n";
$id_spr = 5;
$result = $test->infosSprint($id_spr);
$row = $result->fetch_assoc();
echo $row["SPR_id"]." | ".$row["SPR_numero"]." | ".$row["SPR_dateDebut"]." | ".$row["SPR_duree"]." | ".$row["PRO_id"]."<br>\n";
echo "<br>\n";

// test ordonnerDate
echo "<b>// test ordonnerDate</b><br>";
$id_pro = 1;
$id_spr = 1;
$result = $test->infosSprint($id_spr);
$date = $row["SPR_dateDebut"];
echo $date." -> ";
echo $test->ordonnerDate($date);
echo "<br>\n<br>\n";

?>
