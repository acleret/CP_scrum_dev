<?php
require_once("../web/config.php");

if (isset($_SESSION["session"])) {
  $id_dev = $_SESSION["id_co"];

  $infos = $db->infosDeveloppeur($id_dev);
  $row = $infos->fetch_assoc();

  $s->suppressionCookies();
  $s->head("Mon profil");
  $s->header();
  $s->nav($db);
?>
          <article>
            <div class="col-sm-8 text-left">
              <h2>Profil : <?php echo $row["DEV_pseudo"];?></h2>
              <hr>
<?php
  if (isset($_GET["url"])) {
    if (!strcmp($_GET["url"], "OK")) {
      echo "<p>le profil a bien été modifié</p><br>\n";
    }
  }
?>
              <div class="row">
                <div class="col-sm-2 text-left">
<?php
  if (empty($_SESSION["image_co"])) {
?>
                  <img src="../web/img/avatar-default.jpg" alt="Avatar" height="180" width="180" class="img-rounded"/>
<?php
  } else {
?>
                  <img src="<?php echo $_SESSION["image_co"]; ?>" alt="Avatar" height="180" width="180" class="img-rounded"/>
<?php
  }
?>
                </div>
                <div class="col-sm-8">
                  <h4>Mon nom : </h4>
                  <?php echo $row["DEV_nom"];?>
                  <h4>Mon prénom : </h4>
                  <?php echo $row["DEV_prenom"];?>
                  <h4>Mon mail : </h4>
                  <?php echo $row["DEV_mail"];?>
                </div>
              </div>
              <hr>
              <h4>Mes projets :</h4>
              <p>(en tant que ProductOwner)</p>
              <ul>
<?php
  $projets = $db->listeProjetsDeveloppeurProductOwner($id_dev);
  while ($projet = $projets->fetch_assoc()) {
?>
                <li>
                  <form style="display: inline;" action="../web/setProjet.php" method="post">
                    <input type="hidden" name="id_projet" value="<?php echo $projet["PRO_id"]; ?>"/>
                    <input class="url2" type="submit" value="<?php echo $projet["PRO_nom"]; ?>"/>
                  </form><br>
                  <?php echo $projet["PRO_description"]; ?><br>
                  Créé le <?php echo $projet["PRO_date_creation"]; ?> pour <?php echo $projet["PRO_client"]; ?>
                </li>
<?php
  }
?>
              </ul>
              <hr>
              <h4>Mes collaborations :</h4>
              <ul>
<?php
  $projets = $db->listeProjetsDeveloppeur($id_dev);
  while ($projet = $projets->fetch_assoc()) {
?>
                <li>
                  <form style="display: inline;" action="../web/setProjet.php" method="post">
                    <input type="hidden" name="id_projet" value="<?php echo $projet["PRO_id"]; ?>"/>
                    <input class="url2" type="submit" value="<?php echo $projet["PRO_nom"]; ?>"/>
                  </form><br>
                  <?php echo $projet["PRO_description"]; ?><br>
                  Créé le <?php echo $projet["PRO_date_creation"]; ?> pour <?php echo $projet["PRO_client"]; ?><br>
                  Participation en tant que développeur
<?php
    if ($db->estScrumMaster($id_dev, $projet["PRO_id"]))
?>
                  et Scrum Master
                </li>
<?php
  }
?>
              </ul>
              <br>
            </div>
          </article>
          <aside>
            <div class="col-sm-2 sidenav">
              <div class="well">
              <form style="display: inline;" action="../web/formulaireProfil.php" method="post">
                <input class="btn btn-primary" type="submit" value="Éditer mon profil"/>
              </form>
              <br>
              <br>
              <form style="display: inline;" action="../web/modificationMotDePasse.php" method="post">
                <input class="btn btn-primary" type="submit" value="Changer mon mot de passe"/>
              </form>
              <br>
              <br>
              <form style="display: inline;" action="../web/supprimerProfil.php" method="post">
                <input class="btn btn-primary" type="submit" value="Supprimer le profil"/>
              </form>
              </div>
            </div>
          </aside>

<?php
  $s->footer();
} else {
  header("Location: ../web/index.php");
  exit();
}
?>
