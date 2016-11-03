<?php
require_once("../web/config.php");

$test = $db;

// test ajoutNouveauDeveloppeur
// expect ajout dev (la première fois)
if ($test->ajoutNouveauDeveloppeur('ptest2', 'ntest', 'pstest', 'mtest', 'mdptest', NULL)) {
  echo "ajout dev<br>\n";
} else {
  echo "erreur pseudo ou mail déjà pris<br>\n";
}
// expect erreur pseudo ou mail déjà pris
if ($test->ajoutNouveauDeveloppeur('ptest2', 'ntest', 'pstest', 'mtest2', 'mdptest', NULL)) {
  echo "ajout dev<br>\n";
} else {
  echo "erreur pseudo ou mail déjà pris<br>\n";
}
// expect erreur pseudo ou mail déjà pris
if ($test->ajoutNouveauDeveloppeur('ptest2', 'ntest', 'pstest2', 'mtest', 'mdptest', NULL)) {
  echo "ajout dev<br>\n";
} else {
  echo "erreur pseudo ou mail déjà pris<br>\n";
}
// expect ajout dev (la première fois)
if ($test->ajoutNouveauDeveloppeur('ptest2', 'ntest', 'pstest2', 'mtest2', 'mdptest', NULL)) {
  echo "ajout dev<br>\n";
} else {
  echo "erreur pseudo ou mail déjà pris<br><br>\n\n";
}

// test infosDeveloppeur
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
$id_dev = 1; // le dev 1 est lié au projet 1, 2 et 4
$result = $test->listeProjetsDeveloppeur($id_dev);
while ($row = $result->fetch_assoc()) {
  echo $row["PRO_id"]." | ".$row["PRO_nom"]." | ".$row["PRO_client"]." | ".$row["PRO_description"]." | ".$row["PRO_date_creation"]." | ".$row["DEV_idProductOwner"]." | ".$row["DEV_idScrumMaster"]."<br>\n";
}
echo "<br>\n";

// test nombreProjetsDeveloppeur
echo "dev ".$id_dev." lié à ".$test->nombreProjetsDeveloppeur($id_dev)." projets<br>\n";
echo "<br>\n";

// test listeProjets
$result = $test->listeProjets();
while ($row = $result->fetch_assoc()) {
  echo $row["PRO_id"]." | ".$row["PRO_nom"]." | ".$row["PRO_client"]." | ".$row["PRO_description"]." | ".$row["PRO_date_creation"]." | ".$row["DEV_idProductOwner"]." | ".$row["DEV_idScrumMaster"]."<br>\n";
}
echo "<br>\n";

// test nombreProjets
echo $test->nombreProjets()." projets<br>\n";
  // on peut faire comme ça aussi:
echo $test->listeProjets()->num_rows." projets<br>\n";
echo "<br>\n";

// test estMembreProjet
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
$id_pro = 1;
if ($test->testIDProjet($id_pro)) {
  $result = $test->infosProjet($id_pro);
  $row = $result->fetch_assoc();
  echo $row["PRO_id"]." | ".$row["PRO_nom"]." | ".$row["PRO_client"]." | ".$row["PRO_description"]." | ".$row["PRO_date_creation"]." | ".$row["DEV_idProductOwner"]." | ".$row["DEV_idScrumMaster"]."<br>\n";
} else {
  echo "erreur dev ".$id_dev." inconnu<br>\n";
}
echo "<br>\n";

// test listeDeveloppeursProjet
$id_pro = 1; // le projet contient plusieurs développeurs
$result = $test->listeDeveloppeursProjet($id_pro);
while ($row = $result->fetch_assoc()) {
  echo $row["DEV_id"]." | ".$row["DEV_prenom"]." | ".$row["DEV_nom"]." | ".$row["DEV_pseudo"]." | ".$row["DEV_mdp"]." | ".$row["DEV_mail"]." | ".$row["DEV_urlAvatar"]." | ".$row["DEV_date_creation"]."<br>\n";
}
echo "<br>\n";


?>
