<?php
require_once("../web/config.php");

$id_pro = $_COOKIE["id_projet"];
$infos = $db->infosProjet($id_pro);
$row = $infos->fetch_assoc();

$liste_sprints = $db->listeSprints($id_pro);
$row_sprints = $liste_sprints->fetch_assoc();

$s->head($row['PRO_nom']);
$s->header();
$s->nav($db);
?>
          <article>
            <div class="col-sm-8 text-left">
              <h2><?php echo $row["PRO_nom"];?> - Sprints</h2>
              <hr>
              <dl class="dl-horizontal">
                <dt>Durée des sprints</dt>
                <dd>
<?php
if ($row_sprints["SPR_duree"] == NULL)
  echo "-";
else
  echo $row_sprints["SPR_duree"]." jours\n";
?>
				</dd>
	      	  </dl>
	          <table class="table table-bordered">
		      <thead>
		        <tr>
		          <th>Numéro</th>
		          <th>Début</th>
<?php 
if (isset($_SESSION["session"]) && $db->estMembreProjet($row["PRO_id"], $_SESSION["id_co"]))
    echo "		          <th>Actions</th>\n" ;
?>
		        </tr>
      		  </thead>
      		  <tbody>
<?php
$liste_sprints = $db->listeSprints($id_pro);	// on réinitialiste liste_sprints
while ($row_sprints = $liste_sprints->fetch_assoc()) {
?>
    			<tr>
		  		  <td>
		    		<form style="display: inline;" action="../web/sprint.php" method="post">
<?php
    $id_spr = $row_sprints["SPR_id"];
    $infos_spr = $db->infosSprint($id_spr);
    $row_sprints = $infos_spr->fetch_assoc();
    $nom_spr = "Sprint#".$row_sprints["SPR_numero"];
?>
    				<input type="hidden" name="id_sprint" value="<?php echo $id_spr;?>"/>
		            <input class="url2" name="nom_sprint" type="submit" value="<?php echo $nom_spr;?>"/>
		          </form>
		        </td>
		        <td><?php echo $db->ordonnerDate($row_sprints["SPR_dateDebut"]); ?></td>
<?php
if (isset($_SESSION["session"]) && $db->estMembreProjet($row["PRO_id"], $_SESSION["id_co"])) {
?>
		        <td>
		          <form style="display: inline;" action="../web/suppressionSprint.php" method="post">
		            <input class="btn btn-default" type="submit" value="Supprimer"/>
		          </form>
		        </td>
<?php
}
?>
	          </tr>
<?php
}
?>
	        </tbody>
	      </table>
        </div>
      </article>
      <aside>
<?php
if (isset($_SESSION["session"]) && $db->estMembreProjet($row["PRO_id"], $_SESSION["id_co"])) {
?>
        <div class="col-sm-2 sidenav">
          <div class="well">
            <form style="display: inline;" action="formulaireSprint.php" method="post">
              <input type="hidden" name="action_page" value="ajouter"/>
              <input class="btn btn-primary" type="submit" value="Ajouter Sprint"/>
            </form>
          </div>
        </div>
<?php
}
?>
        </aside>
<?php $s->footer();?>
