<?php
require_once("config.php");

if (!isset($_POST["id_sprint"]) && isset($_COOKIE["id_sprint"])) {
	$id_sprint = $_COOKIE["id_sprint"];
} else if (isset($_POST["id_sprint"])) {
  $id_sprint = $_POST["id_sprint"];
} else {
	header("Location: ../web/index.php");
  exit();

}
 
$infos_sprint = $db->infosSprint($id_sprint);
$row_sprint = $infos_sprint->fetch_assoc();
$num_sprint = $row_sprint["SPR_numero"];
	
if (isset($_COOKIE["id_projet"])) {
	$id_pro = $_COOKIE["id_projet"];
  $infos_pro = $db->infosProjet($id_pro);
  $row_pro = $infos_pro->fetch_assoc();

  $s->head("CDP - Kanban");
  $s->header($db);
  $s->nav($db);
?>
	<article>
		<div class="col-sm-8 text-left">
			<h2><?php echo $row_pro["PRO_nom"];?> - Kanban du Sprint n°<?php echo $num_sprint; ?></h2>
			<h5><a href="#suivi">Suivi des tâches</a> | <a href="#interdépendance">Interdépendance des tâches</a> | <a href="#liste">Liste détaillée des tâches par user story</a></h5>
			<hr>
			<h3 id="suivi">Suivi des tâches</h3>
			<p>Pour mettre à jour l'état d'une tâche, veuillez la déplacer à l'aide de la souris (méthode du "drag and drop").<br>
					Pour en modifier une, cliquez-dessus.</p>

<?php
  if (isset($_GET["ajout"])) {
    if (!strcmp($_GET["ajout"], "OK")) {
?>
              <div class="alert alert-success alert-dismissible">
                <a href="" class="close" data-dismiss="alert" aria-label="close">&times;</a>
                <strong>OK!</strong> Tâche ajoutée.
              </div>
<?php
    }
  }
?>
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
								$varHtmlToDo = "<td class=\"reçoit$id_us\">";
								$lesTaches = explode(";", $row_etat["MesTaches"]);
								foreach($lesTaches as $key => $tacheInfo) {
									$infosTrouveesTache = explode(" ", $tacheInfo);
									$varHtmlToDo .= "<span class=\"sedeplace$id_us\" id=\"TODO$id_us\">T (Id: $infosTrouveesTache[0] - Nom: $infosTrouveesTache[1])</span><br>\n";
								}
							$varHtmlToDo .= "</td>";
							break;
						case "ON GOING":
								$varHtmlOnGoing = "<td class=\"reçoit$id_us\">";
								$lesTaches = explode(";", $row_etat["MesTaches"]);
								foreach($lesTaches as $key => $tacheInfo) {
									$infosTrouveesTache = explode(" ", $tacheInfo);
									$varHtmlOnGoing .= "<span class=\"sedeplace$id_us\" id=\"ONGOING$id_us\">T (Id: $infosTrouveesTache[0] - Nom: $infosTrouveesTache[1])</span><br>\n";
								}
							$varHtmlOnGoing .= "</td>";
							break;
						case "TO TEST":
								$varHtmlToTest = "<td class=\"reçoit$id_us\">";
								$lesTaches = explode(";", $row_etat["MesTaches"]);
								foreach($lesTaches as $key => $tacheInfo) {
									$infosTrouveesTache = explode(" ", $tacheInfo);
									$varHtmlToTest .= "<span class=\"sedeplace$id_us\" id=\"TOTEST$id_us\">T (Id: $infosTrouveesTache[0] - Nom: $infosTrouveesTache[1])</span><br>\n";
								}
							$varHtmlToTest .= "</td>";
							break;
						case "DONE":
								$varHtmlDone = "<td class=\"reçoit$id_us\">";
								$lesTaches = explode(";", $row_etat["MesTaches"]);
								foreach($lesTaches as $key => $tacheInfo) {
									$infosTrouveesTache = explode(" ", $tacheInfo);
									$varHtmlDone .= "<span id=\"essai\"><span class=\"sedeplace$id_us\" id=\"DONE$id_us\">[Id: $infosTrouveesTache[0] - Nom: $infosTrouveesTache[1]]</span></span> <br>\n";
								}
							$varHtmlDone .= "</td>";
							break;
					}
				}
				if ($varHtmlToDo == null) $varHtmlToDo = "<td class=\"reçoit$id_us\"></td>";
				if ($varHtmlOnGoing == null) $varHtmlOnGoing = "<td class=\"reçoit$id_us\"></td>";
				if ($varHtmlToTest == null) $varHtmlToTest = "<td class=\"reçoit$id_us\"></td>";
				if ($varHtmlDone == null) $varHtmlDone = "<td class=\"reçoit$id_us\"></td>";

				echo $varHtmlToDo.$varHtmlOnGoing.$varHtmlToTest.$varHtmlDone;

				if (isset($_SESSION["session"])) {
					if ($db->estMembreProjet($id_pro, $_SESSION["id_co"])) {
?>
						<td class="reçoit$id_us">
							<button type="button" class="btn btn-default" data-toggle="modal" data-target="#ajoutModal<?php echo $id_us; ?>">Ajouter une tâche</button>
							<button type="button" class="btn btn-danger" data-toggle="modal" data-target="#supprimerModal<?php echo $id_us; ?>">Supprimer</button>
						</td>
						<!-- Modal Ajout -->
						<div id="ajoutModal<?php echo $id_us; ?>" class="modal fade" role="dialog">
							<div class="modal-dialog">
								<!-- Modal content-->
								<div class="modal-content">
									<form style="display: inline;" action="../web/ajoutTache.php" method="post">
										<div class="modal-header">
											<button type="button" class="close" data-dismiss="modal">&times;</button>
											<h4 class="modal-title">Ajout d'une tâche dans l'US#<?php echo $row_us['US_numero']; ?> </h4>
										</div>
										<div class="modal-body">
											<div class="form-group">
												<label for="nom">Nom</label>
												<input type="text" class="form-control" id="nom" placeholder="Nom" name="nom" value="" required>
											</div>
											<div class="form-group">
												<label for="description">Description</label>
												<textarea class="form-control" rows="3" id="description" name="description" placeholder="Description..." ></textarea>
											</div>
											<div class="form-group">
												<label for="nbJours">Nombre de jours</label>
                        <input class="form-control" type="number" name="nbJours" placeholder="Nombre de jours" required/>
											</div>
											<div class="form-group">
												<label for="dateDebut">Date de début</label>
                        <input class="form-control" type="date" name="dateDepart" placeholder="Date de début" required/>
											</div>
											<div class="form-group">
												<label for="responsable">Pseudo du responsable</label>
													<select class="form-control" name="responsable">
					<?php 					$listeDeveloppeurs = $db->listeDeveloppeurs(); 
													while ($row_dev = $listeDeveloppeurs->fetch_assoc()) {							
					?>
														<option value="<?php echo $row_dev["DEV_id"]; ?>"><?php echo $row_dev["DEV_pseudo"]; ?></option>
					<?php 					}		?>
													</select>
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
			<h3 id="interdépendance">Interdépendance des tâches</h3>
			<br>
			<br>
			<br>
			<br>
			<h3 id="liste">Liste détaillée des tâches par user story (classées par ordre de priorité)</h3> 
<?php
	$result_us = $db->listeUserStorySprint($id_sprint);
	echo "<ul>";
	while ($row_us = $result_us->fetch_assoc()) {
		echo "<li id=\"us".$row_us['US_numero']."\">US#".$row_us['US_numero']." : ".$row_us['US_nom']."</li>";
		
		echo "<ul>";
		$result_taches = $db->listeTachesUS($row_us['US_id']);
		while ($row_tache = $result_taches->fetch_assoc()) {
			echo "<li id=\tache".$row_tache['TAC_id']."\">Tache#".$row_tache['TAC_id']." : ".$row_tache['TAC_description']."</li>";
		}
		echo "</ul>";
	}
	echo "</ul>";		
?>			
			</div>
		</article>

<?php
  $s->footer();
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
			});
			
			$('.sedeplace43, .sedeplace2').on("dragstart", function (event) {
          var dt = event.originalEvent.dataTransfer;
          dt.setData('Text', $(this).attr('id'));
        });
        $('.reçoit43').on("dragenter dragover drop", function (event) {	
         event.preventDefault();
         if (event.type === 'drop') {
					alert(event.target.id);
          var data = event.originalEvent.dataTransfer.getData('Text',$(this).attr('id'));
          //if(data == "a" ||data == "c" ||data == "d" ){
					//changer le texte : ("id").html();
					//changer l'id :
						alert("data:"+data);
            de=$('#'+data).detach();
            de.appendTo($(this));	
					//}
         };
       });
		});
	</script>

<?php
}  else {
	header("Location: ../web/index.php");
  exit();
}
?>
