<?php
require_once("../web/config.php");

$test = $db;


/*****************************************************/
/** Tests des fonctions concernant les développeurs **/
/*****************************************************/

// test ajoutNouveauDeveloppeur
echo "// test ajoutNouveauDeveloppeur<br>";
// expect "Développeur ajouté" (lancé la première fois)
if ($test->ajoutNouveauDeveloppeur('ptest2', 'ntest', 'pstest', 'mdptest', 'mtest', NULL)) {
  echo "* Développeur ajouté<br>";
} else {
  echo "* Erreur pseudo ou mail déjà pris<br>";
}
// expect "Erreur pseudo ou mail déjà pris"
if ($test->ajoutNouveauDeveloppeur('ptest2', 'ntest', 'pstest', 'mdptest', 'mtest2', NULL)) {
  echo "* Développeur ajouté<br>";
} else {
  echo "* Erreur pseudo ou mail déjà pris<br>";
}
// expect "Erreur pseudo ou mail déjà pris"
if ($test->ajoutNouveauDeveloppeur('ptest2', 'ntest', 'pstest2', 'mdptest', 'mtest', NULL)) {
  echo "* Développeur ajouté<br>";
} else {
  echo "* Erreur pseudo ou mail déjà pris<br>";
}
// expect "Développeur ajouté" (lancé la première fois)
if ($test->ajoutNouveauDeveloppeur('ptest2', 'ntest', 'pstest2', 'mdptest', 'mtest2', NULL)) {
  echo "* Développeur ajouté<br>";
} else {
  echo "* Erreur pseudo ou mail déjà pris<br><br>";
}

// test modifDeveloppeur
echo "// test modifDeveloppeur<br>";
if ($test->modifDeveloppeur(2, "bob", "bob", "pstest2", "")) {
  echo "* Développeur modifié<br><br>";
} else {
  echo "* Erreur modification dev<br><br>";
}

// test testPseudoDeveloppeur
echo "// test testPseudoDeveloppeur<br>";
$pseudo = "pstest";
// expect "Le développeur existe déjà"
if ($test->testPseudoDeveloppeur($pseudo)) {
  echo "* Le développeur ".$pseudo." existe déjà<br>";
} else {
  echo "* Le développeur ".$pseudo." n'existe pas<br>";
}
$pseudo = "rien";
// expect "Le développeur n'existe pas"
if ($test->testPseudoDeveloppeur($pseudo)) {
  echo "*Le developpeur ".$pseudo." existe déjà<br><br>";
} else {
  echo "* Le développeur ".$pseudo." n'existe pas<br><br>";
}

// test testMailDeveloppeur
echo "// test testMailDeveloppeur<br>";
$mail = "mtest";
// expect "Le mail existe bien"
if ($test->testMailDeveloppeur($mail)) {
  echo "* Le mail ".$mail." existe bien<br>";
} else {
  echo "* Le mail ".$mail." n'existe pas<br>";
}
$mail = "rien";
// expect "Le mail n'existe pas"
if ($test->testMailDeveloppeur($mail)) {
  echo "* Le mail ".$mail." existe bien<br><br>";
} else {
  echo "* Le mail ".$mail." n'existe pas<br><br>";
}

// test testIDDeveloppeur
echo "// test testIDDeveloppeur<br>";
$id = 1;
// expect "L'id existe déjà"
if ($test->testIDDeveloppeur($id)) {
  echo "* L'id ".$id." existe déjà<br>";
} else {
  echo "* L'id ".$id." n'existe pas<br>";
}
$id = 20000000;
// expect "L'id n'existe pas"
if ($test->testIDDeveloppeur($id)) {
  echo "id ".$id." existe<br><br>";
} else {
  echo "id ".$id." n'existe pas<br><br>";
}

// test infosDeveloppeur
echo "// test infosDeveloppeur<br>";
$id_dev = 1;
if ($test->testIDDeveloppeur($id_dev)) {
  $result = $test->infosDeveloppeur($id_dev);
  $row = $result->fetch_assoc();
  echo $row["DEV_id"]." | ".$row["DEV_prenom"]." | ".$row["DEV_nom"]." | ".$row["DEV_pseudo"]." | ".$row["DEV_mdp"]." | ".$row["DEV_mail"]." | ".$row["DEV_urlAvatar"]." | ".$row["DEV_date_creation"]."<br><br>\n\n";
} else {
  echo "* Erreur le dév ".$id_dev." est inconnu<br><br>";
}

// test listeProjetsDeveloppeur
echo "// test listeProjetsDeveloppeur<br>";
$id_dev = 1; // le dev 1 est lié au projet 1, 2 et 4
$result = $test->listeProjetsDeveloppeur($id_dev);
while ($row = $result->fetch_assoc()) {
  echo $row["PRO_id"]." | ".$row["PRO_nom"]." | ".$row["PRO_client"]." | ".$row["PRO_description"]." | ".$row["PRO_date_creation"]." | ".$row["DEV_idProductOwner"]." | ".$row["DEV_idScrumMaster"]."<br>";
}
echo "<br>";

// test listeProjetsDeveloppeurProductOwner
echo "// test listeProjetsDeveloppeurProductOwner<br>";
$id_dev = 1; // le dev 1 est lié au projet 1, 2 et 4
$result = $test->listeProjetsDeveloppeurProductOwner($id_dev);
while ($row = $result->fetch_assoc()) {
  echo $row["PRO_id"]." | ".$row["PRO_nom"]." | ".$row["PRO_client"]." | ".$row["PRO_description"]." | ".$row["PRO_date_creation"]." | ".$row["DEV_idProductOwner"]." | ".$row["DEV_idScrumMaster"]."<br>";
}
echo "<br>";

// test nombreProjetsDeveloppeur
echo "// test nombreProjetsDeveloppeur<br>";
echo "Le dév n°".$id_dev." est lié à ".$test->nombreProjetsDeveloppeur($id_dev)." projets<br>";
echo "<br>";


/************************************************/
/** Tests des fonctions concernant les projets **/
/************************************************/

// test listeProjets
echo "// test listeProjets<br>";
$result = $test->listeProjets();
while ($row = $result->fetch_assoc()) {
  echo $row["PRO_id"]." | ".$row["PRO_nom"]." | ".$row["PRO_client"]." | ".$row["PRO_description"]." | ".$row["PRO_date_creation"]." | ".$row["DEV_idProductOwner"]." | ".$row["DEV_idScrumMaster"]."<br>";
}
echo "<br>";

// test nombreProjets
echo "// test nombreProjets<br>";
$nb_projets = $test->nombreProjets();
echo ($nb_projets == $test->listeProjets()->num_rows)? "bon calcul<br>":"mauvais calcul<br>";
echo "<br>";

// test ajoutNouveauProjet
echo "// test ajoutNouveauProjet<br>";
// expect "Projet créé"
if ($test->ajoutNouveauProjet("MonNouveauProjet", "Anonymous", "Projet test dans la BD", 1, 1)) {
  echo "* Projet créé<br><br>";
} else {
    echo "* Erreur dans la création du projet<br><br>";
}

// test modifProjet
echo "// test modifProjet<br>";
// expect "Projet modifié"
if ($test->modifProjet($nb_projets+1, "MonSupeeerProjet", "Anonymous", "Projet test dans la BD", 1, 1)) {
  echo "* Projet modifié<br><br>";
} else {
    echo "* Erreur dans la modification des données du projet 1<br><br>";
}

// test suppressionProjet
echo "// test suppressionProjet<br>";
// expect "Projet supprimé"
if ($test->suppressionProjet($nb_projets+1)) {
echo "* Projet supprimé<br><br>";
} else {
echo "* Erreur lors de la suppression d'un projet<br><br>";
}

// test testIDProjet
echo "// test testIDProjet<br>";
// expect "Le projet 1 existe bien"
if ($test->testIDProjet(1)) {
  echo "* Le projet 1 existe bien<br>";
} else {
    echo "* Le projet 1 n'existe pas<br>";
}
echo "<br>";

// test estMembreProjet
echo "// test estMembreProjet<br>";
// expect "Le développeur 1 est membre du projet 1"
if ($test->estMembreProjet(1, 1)) {
  echo "* Le développeur 1 est membre du projet 1<br>";
} else {
    echo "* Le développeur 1 n'est pas membre du projet 1<br>";
}
// expect "Le développeur 1 est membre du projet 1"
if ($test->estMembreProjet(3, 1)) {
  echo "* Le développeur 1 est membre du projet 3<br>";
} else {
    echo "* Le développeur 1 n'est pas membre du projet 3<br>";
}
echo "<br>";

// test infosProjet
echo "// test infosProjet<br>";
$id_pro = 1;
if ($test->testIDProjet($id_pro)) {
  $result = $test->infosProjet($id_pro);
  $row = $result->fetch_assoc();
  echo $row["PRO_id"]." | ".$row["PRO_nom"]." | ".$row["PRO_client"]." | ".$row["PRO_description"]." | ".$row["PRO_date_creation"]." | ".$row["DEV_idProductOwner"]." | ".$row["DEV_idScrumMaster"]."<br>";
} else {
  echo "* Erreur le projet ".$id_pro." est inconnu<br>";
}
echo "<br>";


// test listeDeveloppeurs
echo "// test listeDeveloppeurs<br>";
$result = $test->listeDeveloppeurs();
while ($row = $result->fetch_assoc()) {
  echo $row["DEV_id"]." | ".$row["DEV_prenom"]." | ".$row["DEV_nom"]." | ".$row["DEV_pseudo"]." | ".$row["DEV_mdp"]." | ".$row["DEV_mail"]." | ".$row["DEV_urlAvatar"]." | ".$row["DEV_date_creation"]."<br>";
}
echo "<br>";

// test listeDeveloppeursProjet
echo "// test listeDeveloppeursProjet<br>";
$id_pro = 1; // le projet contient plusieurs développeurs
$result = $test->listeDeveloppeursProjet($id_pro);
while ($row = $result->fetch_assoc()) {
  echo $row["DEV_id"]." | ".$row["DEV_prenom"]." | ".$row["DEV_nom"]." | ".$row["DEV_pseudo"]." | ".$row["DEV_mdp"]." | ".$row["DEV_mail"]." | ".$row["DEV_urlAvatar"]." | ".$row["DEV_date_creation"]."<br>";
}
echo "<br>";

// test testDeveloppeurConnexion
echo "// test testDeveloppeurConnexion<br>\n";
$pseudo = "pstest";
$mdp = "mdptest";
$result = $test->testDeveloppeurConnexion($pseudo, $mdp);
$row = $result->fetch_assoc();
if ($result->num_rows == 1) {
  echo $row["DEV_id"]." | ".$row["DEV_prenom"]." | ".$row["DEV_nom"]." | ".$row["DEV_pseudo"]." | ".$row["DEV_mdp"]." | ".$row["DEV_mail"]." | ".$row["DEV_urlAvatar"]." | ".$row["DEV_date_creation"]."<br><br>";
} else {
  echo "* Mauvaise combinaison pseudo et mot de passe<br><br>";
}

// test estScrumMaster
echo "// test estScrumMaster<br>";
$id_dev = 1;
$id_pro = 1;
if ($test->estScrumMaster($id_dev, $id_pro)) {
  echo "* Le développeur ".$id_dev." est Scrum Master sur le projet ".$id_pro."<br><br>";
} else {
  echo "* Le développeur ".$id_dev." n'est pas Scrum Master sur le projet ".$id_pro."<br><br>";
}

// test estProductOwner
echo "// test estProductOwner<br>";
$id_dev = 1;
$id_pro = 1;
if ($test->estProductOwner($id_dev, $id_pro)) {
  echo "* Le développeur ".$id_dev." est ProductOwner sur le projet ".$id_pro."<br><br>";
} else {
  echo "* Le développeur ".$id_dev." n'est pas ProductOwner sur le projet ".$id_pro."<br><br>";
}


/************************************************/
/** Tests des fonctions concernant les sprints **/
/************************************************/

// test listeSprints
echo "// test listeSprints<br>";
$id_pro = 1;
$result = $test->listeSprints($id_pro);
while ($row = $result->fetch_assoc()) {
  echo $row["SPR_id"]." | ".$row["SPR_nom"]." | ".$row["SPR_dateDebut"]." | ".$row["SPR_duree"]." | ".$row["PRO_id"]."<br>";
}
echo "<br>";

/*// test infosSprint
echo "// test infosSprint<br>";
$id_spr = 2;
$result = $test->infosProjet($id_spr);
$row = $result->fetch_assoc();
echo "bonjour";/*
echo $result[1];//."SPR_id"]." | ".$row["SPR_nom"]." | ".$row["SPR_dateDebut"]." | ".$row["SPR_duree"]." | ".$row["PRO_id"]."<br>";
echo "<br>";*/

?>
