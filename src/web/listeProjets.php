<?php
require_once("../web/config.php");

// supperssion du cookie qui contient l'id du projet courrant
if (isset($_COOKIE["id_projet"])){
  setcookie("id_projet", false, time() - 3600);
  unset($_COOKIE["id_projet"]);
}

$s->head("Liste des Projets");
$s->header();
$s->nav($db);
?>
          <article>
            <div class="col-sm-8 text-left">
              <h2>Projets</h2>
              <table class="table table-bordered">
                <thead>
                  <tr>
                    <th>Titre</th>
<?php
if (isset($_SESSION["id_dev"])) {
?>
                    <th>Actions</th>
<?php
}
?>
                  </tr>
                </thead>
                <tbody>
<?php
// calcul du nombre de pages
$nb_projets_par_pages = 20;

$nombre_lignes = $db->nombreProjets();
$nombre_de_pages = ceil($nombre_lignes / $nb_projets_par_pages);

// affichage des ateliers de la page en cours
if (isset($_GET["page"])) {
  $page_actuelle = intval($_GET["page"]);

  if($page_actuelle > $nombre_de_pages) {
    $page_actuelle = $nombre_de_pages;
  }
} else {
  $page_actuelle = 1;
}

$id_premiere_ligne = ($page_actuelle - 1) * $nb_projets_par_pages;

$result = $db->listeProjets($id_premiere_ligne, $nb_projets_par_pages);
while ($row = $result->fetch_assoc()) {
?>
                  <tr>
                    <td>
                      <form style="display: inline;" action="../web/setProjet.php" method="post">
                        <input type="hidden" name="id_projet" value="<?php echo $row["PRO_id"]; ?>"/>
                        <input class="url2" type="submit" value="<?php echo $row["PRO_nom"]; ?>"/>
                      </form>
                    </td>
<?php
  if (isset($_SESSION["id_dev"])) {
?>
                    <td>
<?php
    if ($db->estMembreProjet($row["PRO_id"], $_SESSION["id_dev"])) {
?>
                      <form style="display: inline;" action="../web/formulaireProjet.php" method="post">
                        <input type="hidden" name="id_atelier" value="<?php echo $row["PRO_id"]; ?>"/>
                        <input class="btn btn-default" type="submit" value="Modifier"/>
                      </form>
                      <form style="display: inline;" action="../web/supperssionProjet.php" method="post">
                        <input type="hidden" name="id_atelier" value="<?php echo $row["PRO_id"]; ?>"/>
                        <input type="hidden" name="page_actuelle" value="<?php echo $page_actuelle; ?>"/>
                        <input class="btn btn-default" type="submit" value="Supprimer"/>
                      </form>
<?php
    }
?>
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
              <hr>
              <p style="text-align:center">Page :
<?php
// affichage de la liste des pages
for ($i = 1; $i <= $nombre_de_pages; $i++) {
  if ($i == $page_actuelle) {
    echo ' [ '.$i.' ] ';
  } else {
    echo ' <a href="listeProjets.php?page='.$i.'\">'.$i.'</a> ';
  }
}
?>
              </p>
            </div>
          </article>
          <aside>
<?php
if (isset($_SESSION["id_dev"])) {
?>
            <div class="col-sm-2 sidenav">

              <div class="well">
                <form style="display: inline;" action="formulaireProjet.php" method="post">
                    <input type="hidden" name="action_page" value="ajouter"/>
                    <input class="btn btn-primary" type="submit" value="Ajouter Projet"/>
                </form>
              </div>
            </div>
<?php
}
?>
          </aside>
<?php $s->footer();?>
