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
							<label class="control-label" for="nom">Nom du projet:</label>
							<input class="form-control" type="text" id="nom" name="nom" maxlength="255" placeholder="Nom du projet" value="<?php echo $nom; ?>" required />
						</div>
					</div>
					<div class="form-group">
						<div class="col-md-offset-0 col-md-8">
							<label class="control-label" for="client">Client:</label>
							<input class="form-control" type="text" id="client" name="client" maxlength="255" placeholder="Nom du client" value="<?php echo $client; ?>" required />
						</div>
					</div>
					<div class="form-group">
						<div class="col-md-offset-0 col-md-8">
							<label class="control-label" for="comment">Description:</label>
							<textarea class="form-control" rows="5" id="comment" name="descr" placeholder="Description du projet" ><?php echo $description; ?></textarea>
						</div>
					</div>
					<div class="checkbox">
						<label>
							<input type="checkbox" id="choisirPO" onclick="changeVisibilite()"> Associer un product owner
						</label>
					</div>
					<div class="form-group" id="monPO" style="display:none;">
						<div class="col-md-offset-0 col-md-8">
							<select class="form-control" name="PO">
<?php 					$listeDeveloppeurs = $db->listeDeveloppeurs(); 
								while($row_dev = $listeDeveloppeurs->fetch_assoc()) {								
									if(isset($_POST["id"]) && $db->estProductOwner($row_dev["DEV_id"], $_POST["id"])) {
?>						
										<option selected value="<?php echo $row_dev["DEV_id"]; ?>"><?php echo $row_dev["DEV_pseudo"]; ?></option>
<?php
									} else { ?>						
										<option value="<?php echo $row_dev["DEV_id"]; ?>"><?php echo $row_dev["DEV_pseudo"]; ?></option>
<?php 						}
								}
?>
							</select>
						</div>
					</div>
					<br>
					<div class="checkbox">
						<label>
							<input type="checkbox" id="choisirSM" onclick="changeVisibilite()"> Associer un scrum master
						</label>
					</div>
					<div class="form-group" id="monSM" style="display:none;">
						<div class="col-md-offset-0 col-md-8">
							<select class="form-control" name="SM">
<?php 					$listeDeveloppeurs = $db->listeDeveloppeurs(); 
								while($row_dev = $listeDeveloppeurs->fetch_assoc()) {								
									if(isset($_POST["id"]) && $db->estScrumMaster($row_dev["DEV_id"], $_POST["id"])) {
?>						
										<option selected value="<?php echo $row_dev["DEV_id"]; ?>"><?php echo $row_dev["DEV_pseudo"]; ?></option>
<?php
									} else { ?>						
										<option value="<?php echo $row_dev["DEV_id"]; ?>"><?php echo $row_dev["DEV_pseudo"]; ?></option>
<?php 						}
								}
?>
							</select>
						</div>
					</div>
					<br>
					<div class="checkbox">
						<label>
							<input type="checkbox" id="choisirDevs" onclick="changeVisibilite()"> Associer des développeurs
						</label>
					</div>
					<div class="form-group" id="mesDevs" style="display:none;">
						<div class="col-md-offset-0 col-md-8">
							<select multiple class="form-control" name="devs[]" size="5	">
<?php 					$listeDeveloppeurs = $db->listeDeveloppeurs(); 
								while($row_dev = $listeDeveloppeurs->fetch_assoc()) {
									if (isset($_POST["id"])) {
										if ($db->estMembreProjet($_POST["id"], $row_dev["DEV_id"])) {
?>						
											<option selected value="<?php echo $row_dev["DEV_id"]; ?>"><?php echo $row_dev["DEV_pseudo"]; ?></option>
<?php								} else { ?>						
											<option value="<?php echo $row_dev["DEV_id"]; ?>"><?php echo $row_dev["DEV_pseudo"]; ?></option>
<?php								}
									}	else { ?>						
										<option value="<?php echo $row_dev["DEV_id"]; ?>"><?php echo $row_dev["DEV_pseudo"]; ?></option>
<?php							}
								}
?>
							</select>
						</div>
					</div>
					<br>
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
		
		<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.7.2/jquery.min.js"></script> <!-- jQuery est inclus ! -->
   <script>
       jQuery(document).ready(function(){
       });
			 function changeVisibilite() {
				if($('#choisirPO').is(':checked')) {
					$('#monPO').css({'display':'block'});
				}
				else {
					$('#monPO').css({'display':'none'});
				}
				if($('#choisirSM').is(':checked')) {
					$('#monSM').css({'display':'block'});
				}
				else {
					$('#monSM').css({'display':'none'});
				}
				if($('#choisirDevs').is(':checked')) {
					$('#mesDevs').css({'display':'block'});
				}
				else {
					$('#mesDevs').css({'display':'none'});
				}
			}
			function VerifFormulaireProjet() {
				return true;
			}
		</script>
<?php
		$s->footer();
	}
}
else {
header("Location: index.php");
exit();
}
?>
