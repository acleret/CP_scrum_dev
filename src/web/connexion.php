<?php
require_once("../web/config.php");

/********** pour tester avec un developpeur connecter **********/
$_SESSION["id_dev"] = 1;
$_SESSION["expire"] = time() + (30 * 60); // 30 mn plus tard

header("Location: ../web/listeProjets.php");
/********** ***************************************** **********/
?>
