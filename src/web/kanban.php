<?php
require_once("config.php");

if (isset($_COOKIE["id_projet"]) && isset($_COOKIE["id_sprint"])) {
  $id_sprint = $_COOKIE["id_sprint"];
  //$infos_sprint = $db->infosProjet($id_sprint);
  //$row_sprint = $infos_sprint->fetch_assoc();

	$id_pro = $_COOKIE["id_projet"];
  $infos_pro = $db->infosProjet($id_pro);
  $row_pro = $infos_pro->fetch_assoc();

  $s->head("CDP - Kanban");
  $s->header($db);
  $s->nav($db);
?>

	<script>
		$(document).ready(function() {
			$('#tableTaches').DataTable( {
				"order": [[ 0, "asc" ]],
				"oLanguage": {
					"sLengthMenu": "Afficher _MENU_ entrées",
					"sSearch": "<span class=\"glyphicon glyphicon-search\"></span> Recherche:",
					"sEmptyTable": "Aucune donnée",
					"sInfo": "Affichage de _START_ à _END_ sur _TOTAL_ entrées",
					"sInfoEmpty": "",
					"oPaginate": {
						"sPrevious": "Précédent",
						"sNext": "Suivant"
					}
				}
			} );
		} );
	</script>
	<article>
		<div class="col-sm-8 text-left">
			<h2><?php echo $row_pro["PRO_nom"];?> - Kanban du Sprint n°<?php echo $id_sprint; ?></h2>
			<hr>
			<h3>Le suivi des tâches</h3>

			<table id="tableTaches" class="table table-striped table-hover">
				<thead>
					<tr>
						<th>US</th>
<?php			$etats = array("TO DO", "ON GOING", "TO TEST", "DONE");
					foreach ($etats as $etat) {
?>
						<th><?php echo $etat; ?></th>
<?php			}
?>
<?php
				if (isset($_SESSION["session"])) {
					if ($db->estMembreProjet($row_pro["PRO_id"], $_SESSION["id_co"])) {
?>
						<th>Actions</th>
<?php
					}
				}
?>
						</tr>
					</thead>
					<tbody>
<?php
			$listeUS = $db->listeUserStorySprint($id_sprint);
			while ($row_us = $listeUS->fetch_assoc()) {
        $id_us = $row_us['US_id'];
?>
						<tr>
							<td><?php echo ($row_us["US_numero"] < 10) ?  'US#0'.$row_us["US_numero"] : 'US#'.$row_us["US_numero"]; ?></td>
<?php
				$result = $db->listeTachesUSEtats($id_us);
				$varHtmlToDo = null;
				$varHtmlOnGoing = null;
				$varHtmlToTest = null;
				$varHtmlDone = null;
				while ($row_etat = $result->fetch_assoc()) { // une ligne = un état
					switch ($row_etat["TAC_etat"]) {
						case "TO DO":
							$varHtmlToDo = "<td>";
								$lesTaches = explode(";", $row_etat["MesTaches"]);
								foreach($lesTaches as $key => $tacheInfo) {
									$infosTrouveesTache = explode(" ", $tacheInfo);
									$varHtmlToDo .= "T (Id: $infosTrouveesTache[0] - Nom: $infosTrouveesTache[1]) <br>\n";
								}
							$varHtmlToDo .= "</td>";
							break;
						case "ON GOING":
							$varHtmlOnGoing = "<td>";
								$lesTaches = explode(";", $row_etat["MesTaches"]);
								foreach($lesTaches as $key => $tacheInfo) {
									$infosTrouveesTache = explode(" ", $tacheInfo);
									$varHtmlOnGoing .= "T (Id: $infosTrouveesTache[0] - Nom: $infosTrouveesTache[1]) <br>\n";
								}
							$varHtmlOnGoing .= "</td>";
							break;
						case "TO TEST":
							$varHtmlToTest = "<td>";
								$lesTaches = explode(";", $row_etat["MesTaches"]);
								foreach($lesTaches as $key => $tacheInfo) {
									$infosTrouveesTache = explode(" ", $tacheInfo);
									$varHtmlToTest .= "T (Id: $infosTrouveesTache[0] - Nom: $infosTrouveesTache[1]) <br>\n";
								}
							$varHtmlToTest .= "</td>";
							break;
						case "DONE":
							$varHtmlDone = "<td>";
								$lesTaches = explode(";", $row_etat["MesTaches"]);
								foreach($lesTaches as $key => $tacheInfo) {
									$infosTrouveesTache = explode(" ", $tacheInfo);
									$varHtmlDone .= "T (Id: $infosTrouveesTache[0] - Nom: $infosTrouveesTache[1]) <br>\n";
								}
							$varHtmlDone .= "</td>";
							break;
					}

				}
				if ($varHtmlToDo == null) $varHtmlToDo = "<td></td>";
				if ($varHtmlOnGoing == null) $varHtmlOnGoing = "<td></td>";
				if ($varHtmlToTest == null) $varHtmlToTest = "<td></td>";
				if ($varHtmlDone == null) $varHtmlDone = "<td></td>";

				echo $varHtmlToDo.$varHtmlOnGoing.$varHtmlToTest.$varHtmlDone;

				if (isset($_SESSION["session"])) {
					if ($db->estMembreProjet($id_pro, $_SESSION["id_co"])) {
?>
						<td>
							<button type="button" class="btn btn-default" data-toggle="modal" data-target="#modificationModal<?php echo $id_us; ?>">Modifier la ligne</button>
							<button type="button" class="btn btn-danger" data-toggle="modal" data-target="#supprimerModal<?php echo $id_us; ?>">Supprimer</button>
						</td>
						<!-- Modal Modification -->
						<div id="modificationModal<?php echo $id_us; ?>" class="modal fade" role="dialog">
							<div class="modal-dialog">
								<!-- Modal content-->
								<div class="modal-content">
									<form style="display: inline;" action="../web/modificationUserStory.php" method="post">
										<div class="modal-header">
											<button type="button" class="close" data-dismiss="modal">&times;</button>
											<h4 class="modal-title">Modification d'une User Story</h4>
										</div>
										<div class="modal-body">
											<div class="form-group">
												<label for="nomInput">Nom</label>
												<input type="text" class="form-control" id="nomInput" placeholder="En tant que... je souhaite..." name="nom_us" value="<?php echo $row_us["US_nom"]; ?>" required>
											</div>
										</div>
										<div class="modal-footer">
											<button type="button" class="btn btn-default" data-dismiss="modal">Annuler</button>
											<input type="hidden" name="id_us" value="<?php echo $id_us; ?>"/>
											<input class="btn btn-primary" type="submit" value="Valider"/>
										</div>
									</form>
								</div>
							</div>
						</div>
						<!-- Modal Suppression -->
						<div id="supprimerModal<?php echo $id_us; ?>" class="modal fade" role="dialog">
							<div class="modal-dialog">
								<!-- Modal content-->
								<div class="modal-content">
									<div class="modal-header">
										<button type="button" class="close" data-dismiss="modal">&times;</button>
										<h4 class="modal-title">Confirmation de suppression d'une tâche</h4>
									</div>
									<div class="modal-body">
										<p>Attention action irréversible</p>
									</div>
									<div class="modal-footer">
										<button type="button" class="btn btn-default" data-dismiss="modal">Annuler</button>
										<form style="display: inline;" action="../web/suppressionUserStory.php" method="post">
											<input type="hidden" name="id_us" value="<?php echo $id_us; ?>"/>
											<input class="btn btn-danger" type="submit" value="Supprimer"/>
										</form>
									</div>
								</div>
							</div>
						</div>
<?php
					}
				}
				echo "</tr>";
			}
?>
					</tbody>
				</table>
			</div>
		</article>

<?php
  $s->footer();
}  else {
  header("Location: index.php");
  exit();
}
?>
