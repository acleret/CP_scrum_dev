<?php
require_once("config.php");

if (isset($_SESSION["session"])) {

	if (isset($_POST["action"])){
	
		if ($_POST["action"] == "ajouter"){
			$s->suppressionCookies();
		  $s->head("Page projet - Création");
		}
		else if ($_POST["action"] == "éditer"){
			$s->head("Page projet - Édition");
		}
	
		$s->header($db);
		$s->nav($db);

		$nom = "";
		if (isset($_POST["nom"])) {
			$nom = $_POST["nom"];
		}
		$client = "";
		if (isset($_POST["client"])) {
			$client = $_POST["client"];
		}
		$description = "";
		if (isset($_POST["descr"])) {
			$description = $_POST["descr"];
		}
?>
		<script>
		function VerifFormulaireProjet() {
		  return true;
		}
		</script>
		<article>
			<div class="col-sm-8 text-left">
				<h2>
<?php 	if ($_POST["action"] == "ajouter") { ?>
					Nouveau projet
<?php 	} else { ?>
					Édition du projet '<?php echo $nom; ?>'
<?php 	} ?>
				</h2>
				<hr>
				
<?php 	if ($_POST["action"] == "ajouter") { ?>
				<form class="form-horizontal" action="modificationProjet.php?action=ajouter" method="post">
<?php   } else { ?>
				<form class="form-horizontal" action="modificationProjet.php?action=éditer" method="post">
<?php 	} ?>
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
							<label for="comment">Description:</label>
							<textarea class="form-control" rows="5" id="comment" name="descr" placeholder="Description du projet" ><?php echo $description; ?></textarea>
						</div>
					</div>
					<div class="form-group">
						<div class="col-md-offset-0 col-md-8">
<?php 			// depuis le bouton "Modifier" de listeProjets.php
						if (isset($_POST["idProjet"]) && isset($_POST["pageActuelle"])) { 
?>												
							<input type="hidden" name="idProjet" value="<?php echo $_POST["idProjet"]; ?>"/>
							<input type="hidden" name="pageActuelle" value="<?php echo $_POST["pageActuelle"]; ?>"/>
<?php 			} ?>
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
