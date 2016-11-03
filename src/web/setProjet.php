<?php
require_once("../web/config.php");

if(isset($_POST["id_projet"])) {
  $expire = time() + 60 * 60 * 24; // 24 heures
  setcookie("id_projet", $_POST["id_projet"], $expire);
  header("Location: ../web/projet.php");
} else {
  header("Location: ../web/listeProjets.php");
}
?>
