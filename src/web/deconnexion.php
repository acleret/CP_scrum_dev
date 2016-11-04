<?php
require_once("../web/config.php");

if ((isset($_SESSION["session"]) and $_SESSION["session"] == true) || (time() > $_SESSION["expire"])) {
  session_destroy();
}

header("Location: index.php");
?>