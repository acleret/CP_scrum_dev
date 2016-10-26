<?php
require_once($_SERVER['DOCUMENT_ROOT'].'/web/requetes.php');

$test = new requetes('dbserver', 'acleret', 'azerty', 'acleret');

if ($test->verifConnexion()) {die("Connection failed: " .$test->verifConnexion());}

echo $test->nouveauDeveloppeur('ptest2', 'ntest', 'pstest', 'mtest', 'mdptest', NULL);

?>