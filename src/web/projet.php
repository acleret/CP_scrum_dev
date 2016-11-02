<?php
require_once("../web/config.php");

if(isset($_COOKIE["id_projet"])) {
  $s->head("Liste des Projets");
  $s->header();
  $s->nav($db);
?>

<?php
  $s->footer();
} else {
  $url = $_SERVER["REQUEST_URI"];
	header("Location: ../web/listeProjets.php?url=".$url);
}
?>
