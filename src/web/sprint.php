<?php
require_once("../web/config.php");

if (isset($_POST["ret_us"])){
    $retirer_us_sprint = $db->retirerUserStorySprint($_POST["ret_us"]);
}

if (isset($_POST["inser_us"])){
    $retirer_us_sprint = $db->affecterUserStorySprint($_POST["inser_us"], $_POST["id_sprint"]);
}

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
<?php if (isset($_SESSION["session"]) && $db->estMembreProjet($row["PRO_id"], $_SESSION["id_co"])) {?>
			        <th>Actions</th>
<?php
    }
?>
                  </tr>
                </thead>
                <tbody>
<?php
$listeUS = $db->listeUserStorySprint($id_spr);
while ($row3 = $listeUS->fetch_assoc()){
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
if (isset($_SESSION["session"]) && $db->estMembreProjet($row["PRO_id"], $_SESSION["id_co"])) {
?>
                    <td>
                      <form style="display: inline;" action="" method="post">
                        <input type="hidden" name="ret_us" value="<?php echo $id_us; ?>"/>
    				    <input type="hidden" name="id_sprint" value="<?php echo $id_spr;?>"/>
    				    <input type="hidden" name="nom_sprint" value="<?php echo $_POST["nom_sprint"];?>"/>
                        <input class="btn btn-default" type="submit" value="Retirer"/>
                      </form>
                    </td>
                  </tr>
<?php
}
}
?>
                </tbody>
              </table>
<?php
if (isset($_SESSION["session"]) && $db->estMembreProjet($row["PRO_id"], $_SESSION["id_co"])) {
?>
              <hr>
              <h3>Ajouter user stories</h3>
              <br>
              <table class="table table-bordered">
                <thead>
                  <tr>
			        <th>User story</th>
			        <th>Chiffrage abstrait</th>
			        <th>Priorité</th>
		  	        <th>Dernier commit</th>
			        <th>Actions</th>
                  </tr>
                </thead>
                <tbody>
<?php
$listeUS2 = $db->listeUserStoryOutOfSprint($id_spr, $id_pro);
while ($row4 = $listeUS2->fetch_assoc()){
    $id_us = $row4["US_id"];
    $infos_us = $db->infosUserStory($id_us);
    $row4 = $infos_us->fetch_assoc();
?>            
                  <tr>
                    <td><?php echo $row4["US_nom"]; ?></td>
                    <td><?php echo $row4["US_chiffrageAbstrait"]; ?></td>
                    <td><?php echo $row4["US_priorite"]; ?></td>
                    <td><?php echo $row4["US_dateDernierCommit"]; ?></td>
                    <td>
                      <form style="display: inline;" action="" method="post">
                        <input type="hidden" name="inser_us" value="<?php echo $id_us; ?>"/>
                        <input type="hidden" name="id_sprint" value="<?php echo $id_spr; ?>"/>
                        <input type="hidden" name="nom_sprint" value="<?php echo $_POST["nom_sprint"];?>"/>
                        <input class="btn btn-default" type="submit" value="Ajouter"/>
                      </form>
                    </td>
                  </tr>
<?php
}
?>
                </tbody>
              </table>
            </div>
		    <aside>
			  <div class="col-sm-2 sidenav">
				<form style="display: inline;" action="../web/kanban.php" method="post">
				  <input class="btn btn-primary" type="submit" value="Kanban"/>
				</form>
							</div>
		</aside>
<?php
}
?>
<?php $s->footer();?>
