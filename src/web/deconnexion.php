<?php
require_once("../web/config.php");

if (isset($_SESSION["id_dev"]) || time() > $_SESSION["expire"]) {
  session_destroy();
}

header("Location: ../web/listeProjets.php");
?>
