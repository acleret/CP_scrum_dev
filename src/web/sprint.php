<?php
require_once("../web/config.php");

$id_pro = $_COOKIE["id_projet"];
$infos = $db->infosProjet($id_pro);
$row = $infos->fetch_assoc();
$id_spr = $_POST["id_sprint"];
$infos_spr = $db->infosSprint($id_spr);

$nom_spr = $_POST["nom_sprint"];

$s->head("Sprints");
$s->header();
$s->nav($db);
?>
          <article>
            <div class="col-sm-8 text-left">
              <h2><?php echo $row["PRO_nom"]." - ".$nom_spr;?></h2>
              <hr>
              <dl class="dl-horizontal">
<?php
$row2 = $infos_spr->fetch_assoc();
?>
                <dt>Début</dt>
                <dd><?php echo $row2["SPR_dateDebut"]; ?></dd>
                <dt>Durée</dt>
                <dd><?php echo $row2["SPR_duree"]." jours"; ?></dd>
              </dl>
              <table class="table table-bordered">
                <thead>
                  <tr>
			        <th>User story</th>
			        <th>Chiffrage abstrait</th>
			        <th>Priorité</th>
		  	        <th>Dernier commit</th>
<?php if (isset($_SESSION["session"])) {?>
			        <th>Actions</th>
<?php
    }
?>
                  </tr>
                </thead>
                <tbody>
<?php
$listeUS = $db->listeUserStorySprint($id_spr);
$i=0;
while ($i<2){
    $row3 = $listeUS->fetch_assoc();
    $id_us = $row3["US_id"];
    $infos_us = $db->infosUserStory($id_us);
    $row3 = $infos_us->fetch_assoc();
?>            
                  <tr>
                    <td><?php echo $row3["US_nom"]; ?></td>
                    <td><?php echo $row3["US_chiffrageAbstrait"]; ?></td>
                    <td><?php echo $row3["US_priorite"]; ?></td>
                    <td><?php echo $row3["US_dateDernierCommit"]; ?></td>
<?php
if (isset($_SESSION["session"])) {
?>
                    <td>
<?php
if ($db->estMembreProjet($row["PRO_id"], $_SESSION["id_co"])) {
?>
                      <form style="display: inline;" action="../web/retirerUSSprint.php" method="post">
                        <input type="hidden" name="id_us" value="<?php echo $id_us; ?>"/>
                        <input class="btn btn-default" type="submit" value="Retirer"/>
                      </form>
<?php
}
}$i++;
?>
                    </td>
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
if (isset($_SESSION["session"])) {
?>
            <div class="col-sm-2 sidenav">
              <div class="well">
                <form style="display: inline;" action="selectionUS.php" method="post">
	              <input type="hidden" name="id_projet" value="<?php echo $id_pro; ?>"/>
	              <input type="hidden" name="id_sprint" value="<?php echo $id_spr; ?>"/>
	              <input type="hidden" name="nom_sprint" value="<?php echo $nom_spr; ?>"/>
	              <input class="btn btn-primary" type="submit" value="Ajouter US"/>
                </form>
              </div>
            </div>
<?php
}
?>
          </aside>
<?php $s->footer();?>
