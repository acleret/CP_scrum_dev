<?php
require_once("config.php");
/*
if (isset($_POST["action"]) && $_POST["action"] == "ajouter")
echo "ajouter !<br>";
else
echo "éditer !<br>";
*/
if (isset($_SESSION["session"])) {
  $s->suppressionCookies();

	if (isset($_POST["action"])){

		if ($_POST["action"] == "ajouter"){
		  $s->head("Page projet - Création");
		}
		else if ($_POST["action"] == "éditer"){
			$s->head("Page projet - Édition");
		}
	
		$s->header();
		$s->nav($db);

		$nom = "";
		if (isset($_GET["nom"])) {
			$nom = $_GET["nom"];
		}
		$client = "";
		if (isset($_GET["client"])) {
			$client = $_GET["client"];
		}
		$description = "";
		if (isset($_GET["descr"])) {
			$description = $_GET["descr"];
		}
?>
		<script>
		function VerifFormulaireProjet() {
		  return true;
		}
		</script>
		<article>
			<div class="col-sm-8 text-left">
				<?php if ($_POST["action"] == "ajouter") { ?>
					<h2>Nouveau projet</h2>
				<?php } else {?>
					<h2>Édition du projet '<?php echo $nom; ?>'</h2>
				<?php } ?>
				<hr>
				<?php if ($_POST["action"] == "ajouter") { ?>
				<form class="form-horizontal" action="modificationProjet.php?action=ajouter" method="post">
				<?php } else {?>
				<form class="form-horizontal" action="modificationProjet.php?action=éditer" method="post">
				<?php } ?>
				<!--onsubmit="VerifFormulaireProjet()"-->
					<div class="form-group">
						<div class="col-md-offset-0 col-md-8">
							<input class="form-control" type="text" name="nom" maxlength="255" placeholder="Nom du projet" value="<?php echo $nom; ?>" required />
						</div>
					</div>
					<div class="form-group">
						<div class="col-md-offset-0 col-md-8">
							<input class="form-control" type="text" name="client" maxlength="255" placeholder="Nom du client" value="<?php echo $client; ?>" required />
						</div>
					</div>
					<div class="form-group">
						<div class="col-md-offset-0 col-md-8">
							<input class="form-control" type="text" name="descr" placeholder="Description du projet" value="<?php echo $description; ?>" required />
						</div>
					</div>
					<div class="form-group">
						<div class="col-md-offset-0 col-md-8">
							<input class="btn btn-primary" type="submit" value="Valider">
						</div>
					</div>
				</form>
			</div>
		</article>
<?php
		$s->footer();
	}
}
else {
header("Location: index.php");
exit();
}
?>
