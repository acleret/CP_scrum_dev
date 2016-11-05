<?php
require_once("../web/config.php");

$test = $db;

// test ajoutNouveauDeveloppeur
echo "// test ajoutNouveauDeveloppeur<br>\n";
// expect ajout dev (la première fois)
if ($test->ajoutNouveauDeveloppeur('ptest2', 'ntest', 'pstest', 'mdptest', 'mtest', NULL)) {
  echo "ajout dev<br>\n";
} else {
  echo "erreur pseudo ou mail déjà pris<br>\n";
}
// expect erreur pseudo ou mail déjà pris
if ($test->ajoutNouveauDeveloppeur('ptest2', 'ntest', 'pstest', 'mdptest', 'mtest2', NULL)) {
  echo "ajout dev<br>\n";
} else {
  echo "erreur pseudo ou mail déjà pris<br>\n";
}
// expect erreur pseudo ou mail déjà pris
if ($test->ajoutNouveauDeveloppeur('ptest2', 'ntest', 'pstest2', 'mdptest', 'mtest', NULL)) {
  echo "ajout dev<br>\n";
} else {
  echo "erreur pseudo ou mail déjà pris<br>\n";
}
// expect ajout dev (la première fois)
if ($test->ajoutNouveauDeveloppeur('ptest2', 'ntest', 'pstest2', 'mdptest', 'mtest2', NULL)) {
  echo "ajout dev<br>\n";
} else {
  echo "erreur pseudo ou mail déjà pris<br><br>\n\n";
}

// test modifDeveloppeur
echo "// test modifDeveloppeur<br>\n";
if ($test->modifDeveloppeur(2, "bob", "bob", "pstest2", "")) {
  echo "dev modifier<br><br>\n\n";
} else {
  echo "erreur modification dev<br><br>\n\n";
}

// test testPseudoDeveloppeur
echo "// test testPseudoDeveloppeur<br>\n";
$pseudo = "pstest";
// expect dev existe
if ($test->testPseudoDeveloppeur($pseudo)) {
  echo "developpeur ".$pseudo." existe<br>\n";
} else {
  echo "developpeur ".$pseudo." n'existe pas<br>\n";
}
$pseudo = "rien";
// expect dev n'existe pas
if ($test->testPseudoDeveloppeur($pseudo)) {
  echo "developpeur ".$pseudo." existe<br><br>\n\n";
} else {
  echo "developpeur ".$pseudo." n'existe pas<br><br>\n\n";
}

// test testMailDeveloppeur
echo "// test testMailDeveloppeur<br>\n";
$mail = "mtest";
// expect mail existe
if ($test->testMailDeveloppeur($mail)) {
  echo "mail ".$mail." existe<br>\n";
} else {
  echo "mail ".$mail." n'existe pas<br>\n";
}
$mail = "rien";
// expect mail n'existe pas
if ($test->testMailDeveloppeur($mail)) {
  echo "mail ".$mail." existe<br><br>\n\n";
} else {
  echo "mail ".$mail." n'existe pas<br><br>\n\n";
}

// test testIDDeveloppeur
echo "// test testIDDeveloppeur<br>\n";
$id = 1;
// expect mail existe
if ($test->testIDDeveloppeur($id)) {
  echo "id ".$id." existe<br>\n";
} else {
  echo "id ".$id." n'existe pas<br>\n";
}
$id = 20000000;
// expect mail n'existe pas
if ($test->testIDDeveloppeur($id)) {
  echo "id ".$id." existe<br><br>\n\n";
} else {
  echo "id ".$id." n'existe pas<br><br>\n\n";
}

// test infosDeveloppeur
echo "// test infosDeveloppeur<br>\n";
$id_dev = 1;
if ($test->testIDDeveloppeur($id_dev)) {
  $result = $test->infosDeveloppeur($id_dev);
  $row = $result->fetch_assoc();
  echo $row["DEV_id"]." | ".$row["DEV_prenom"]." | ".$row["DEV_nom"]." | ".$row["DEV_pseudo"]." | ".$row["DEV_mdp"]." | ".$row["DEV_mail"]." | ".$row["DEV_urlAvatar"]." | ".$row["DEV_date_creation"]."<br><br>\n\n";
} else {
  echo "erreur dev ".$id_dev." inconnu<br><br>\n\n";
}

/***** Jeux de test (temporaire)******
INSERT INTO `DEVELOPPEUR` (`DEV_id`, `DEV_prenom`, `DEV_nom`, `DEV_pseudo`, `DEV_mdp`, `DEV_mail`, `DEV_urlAvatar`, `DEV_date_creation`) VALUES
(1, 'ptest2', 'ntest', 'pstest', 'mdptest', 'mtest', 'urltest', Now()),
(2, 'ptest2', 'ntest', 'pstest2', 'mdptest', 'mtest2', 'urltest', Now());

INSERT INTO `PROJET` (`PRO_id`, `PRO_nom`, `PRO_client`, `PRO_description`, `PRO_date_creation`, `DEV_idProductOwner`, `DEV_idScrumMaster`) VALUES
(1, 'projet1', 'client1', 'description1', Now(), 1, 1),
(2, 'projet2', 'client2', 'description2', Now(), 1, 2),
(3, 'projet3', 'client3', 'description3', Now(), 2, 2),
(4, 'projet4', 'client4', 'description4', Now(), 2, 1);

INSERT INTO `INTER_DEV_PROJET` (`DEV_id`, `PRO_id`) VALUES
(1, 1),
(2, 1),
(1, 2),
(2, 3),
(1, 4);
*/
// test listeProjetsDeveloppeur
echo "// test listeProjetsDeveloppeur<br>\n";
$id_dev = 1; // le dev 1 est lié au projet 1, 2 et 4
$result = $test->listeProjetsDeveloppeur($id_dev);
while ($row = $result->fetch_assoc()) {
  echo $row["PRO_id"]." | ".$row["PRO_nom"]." | ".$row["PRO_client"]." | ".$row["PRO_description"]." | ".$row["PRO_date_creation"]." | ".$row["DEV_idProductOwner"]." | ".$row["DEV_idScrumMaster"]."<br>\n";
}
echo "<br>\n";

// test listeProjetsDeveloppeurProductOwner
echo "// test listeProjetsDeveloppeurProductOwner<br>\n";
$id_dev = 1; // le dev 1 est lié au projet 1, 2 et 4
$result = $test->listeProjetsDeveloppeurProductOwner($id_dev);
while ($row = $result->fetch_assoc()) {
  echo $row["PRO_id"]." | ".$row["PRO_nom"]." | ".$row["PRO_client"]." | ".$row["PRO_description"]." | ".$row["PRO_date_creation"]." | ".$row["DEV_idProductOwner"]." | ".$row["DEV_idScrumMaster"]."<br>\n";
}
echo "<br>\n";

// test nombreProjetsDeveloppeur
echo "// test nombreProjetsDeveloppeur<br>\n";
echo "dev ".$id_dev." lié à ".$test->nombreProjetsDeveloppeur($id_dev)." projets<br>\n";
echo "<br>\n";

// test listeProjets
echo "// test listeProjets<br>\n";
$result = $test->listeProjets();
while ($row = $result->fetch_assoc()) {
  echo $row["PRO_id"]." | ".$row["PRO_nom"]." | ".$row["PRO_client"]." | ".$row["PRO_description"]." | ".$row["PRO_date_creation"]." | ".$row["DEV_idProductOwner"]." | ".$row["DEV_idScrumMaster"]."<br>\n";
}
echo "<br>\n";

// test nombreProjets
echo "// test nombreProjets<br>\n";
echo $test->nombreProjets()." projets<br>\n";
  // on peut faire comme ça aussi:
echo $test->listeProjets()->num_rows." projets<br>\n";
echo "<br>\n";

// test estMembreProjet
echo "// test estMembreProjet<br>\n";
if ($test->estMembreProjet(1, 1)) {
  echo "le dev 1 est membre du projet 1<br>\n";
} else {
    echo "le dev 1 n'est pas membre du projet 1<br>\n";
}
if ($test->estMembreProjet(3, 1)) {
  echo "le dev 1 est membre du projet 3<br>\n";
} else {
    echo "le dev 1 n'est pas membre du projet 3<br>\n";
}
echo "<br>\n";

// test infosProjet
echo "// test infosProjet<br>\n";
$id_pro = 1;
if ($test->testIDProjet($id_pro)) {
  $result = $test->infosProjet($id_pro);
  $row = $result->fetch_assoc();
  echo $row["PRO_id"]." | ".$row["PRO_nom"]." | ".$row["PRO_client"]." | ".$row["PRO_description"]." | ".$row["PRO_date_creation"]." | ".$row["DEV_idProductOwner"]." | ".$row["DEV_idScrumMaster"]."<br>\n";
} else {
  echo "erreur dev ".$id_dev." inconnu<br>\n";
}
echo "<br>\n";

// test testIDProjet
echo "// test testIDProjet<br>\n";
if ($test->testIDProjet(1)) {
  echo "le projet 1 existe<br>\n";
} else {
    echo "le projet 1 n'existe pas<br>\n";
}
echo "<br>\n";

// test listeDeveloppeurs
echo "// test listeDeveloppeurs<br>\n";
$result = $test->listeDeveloppeurs();
while ($row = $result->fetch_assoc()) {
  echo $row["DEV_id"]." | ".$row["DEV_prenom"]." | ".$row["DEV_nom"]." | ".$row["DEV_pseudo"]." | ".$row["DEV_mdp"]." | ".$row["DEV_mail"]." | ".$row["DEV_urlAvatar"]." | ".$row["DEV_date_creation"]."<br>\n";
}
echo "<br>\n";

// test listeDeveloppeursProjet
echo "// test listeDeveloppeursProjet<br>\n";
$id_pro = 1; // le projet contient plusieurs développeurs
$result = $test->listeDeveloppeursProjet($id_pro);
while ($row = $result->fetch_assoc()) {
  echo $row["DEV_id"]." | ".$row["DEV_prenom"]." | ".$row["DEV_nom"]." | ".$row["DEV_pseudo"]." | ".$row["DEV_mdp"]." | ".$row["DEV_mail"]." | ".$row["DEV_urlAvatar"]." | ".$row["DEV_date_creation"]."<br>\n";
}
echo "<br>\n";

// test testDeveloppeurConnexion
echo "// test testDeveloppeurConnexion<br>\n";
$pseudo = "pstest";
$mdp = "mdptest";
$result = $test->testDeveloppeurConnexion($pseudo, $mdp);
$row = $result->fetch_assoc();
if ($result->num_rows == 1) {
  echo $row["DEV_id"]." | ".$row["DEV_prenom"]." | ".$row["DEV_nom"]." | ".$row["DEV_pseudo"]." | ".$row["DEV_mdp"]." | ".$row["DEV_mail"]." | ".$row["DEV_urlAvatar"]." | ".$row["DEV_date_creation"]."<br><br>\n\n";
} else {
  echo "mauvaise combinaison pseudo et mot de passe<br><br>\n\n";
}

// test estScrumMaster
echo "// test estScrumMaster<br>\n";
$id_dev = 1;
$id_pro = 1;
if ($test->estScrumMaster($id_dev, $id_pro)) {
  echo "dev ".$id_dev." est ScrumMaster sur le projet ".$id_pro."<br><br>\n\n";
} else {
  echo "dev ".$id_dev." n'est pas ScrumMaster sur le projet ".$id_pro."<br><br>\n\n";
}

// test estProductOwner
echo "// test estProductOwner<br>\n";
$id_dev = 1;
$id_pro = 1;
if ($test->estProductOwner($id_dev, $id_pro)) {
  echo "dev ".$id_dev." est ProductOwner sur le projet ".$id_pro."<br><br>\n\n";
} else {
  echo "dev ".$id_dev." n'est pas ProductOwner sur le projet ".$id_pro."<br><br>\n\n";
}
?>
