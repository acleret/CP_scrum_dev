<?php
require_once("../web/config.php");

$s->suppressionCookies();
$s->head("Liste des Projets");
$s->header($db);
$s->nav($db);
?>
          <article>
            <div class="col-sm-8 text-left">
              <h2>Projets</h2>
              <hr>
              <table class="table table-bordered">
                <thead>
                  <tr>
                    <th>Titre</th>
<?php
if (isset($_SESSION["session"])) {
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
$nb_projets_par_pages = 15;

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
  if (isset($_SESSION["session"])) {
?>
                    <td>
<?php
    if ($db->estMembreProjet($row["PRO_id"], $_SESSION["id_co"])) {
?>
                      <form style="display: inline;" action="../web/formulaireProjet.php" method="post">
                        <input type="hidden" name="id_atelier" value="<?php echo $row["PRO_id"]; ?>"/>
                        <input class="btn btn-default" type="submit" value="Modifier"/>
                      </form>
                      <form style="display: inline;" action="../web/suppressionProjet.php" method="post">
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
              <div class="container">
                <ul class="pagination">
                  <li><a href="javascript:pagePrecedente(<?php echo $page_actuelle; ?>);">&laquo;</a></li>
<?php
// affichage de la liste des pages
if ($nombre_de_pages > 1) {
  for ($i = 1; $i <= $nombre_de_pages; $i++) {
    if ($i == $page_actuelle) {
?>
                  <li class="active"><a href="#"><?php echo $i; ?></a></li>
<?php
    //echo ' [ '.$i.' ] ';
    } else {
?>
                  <li><a href="listeProjets.php?page=<?php echo $i; ?>"><?php echo $i; ?></a></li>
<?php
    // echo ' <a href="listeProjets.php?page='.$i.'\">'.$i.'</a> ';
    }
  }
}
?>
                  <li><a href="javascript:pageSuivante(<?php echo $page_actuelle; ?>, <?php echo $nombre_de_pages; ?>);">&raquo;</a></li>
                </ul>
              </div>
            </div>
          </article>
          <aside>
<?php
if (isset($_SESSION["session"])) {
?>
            <div class="col-sm-2 sidenav">
              <form style="display: inline;" action="formulaireProjet.php" method="post">
                <input type="hidden" name="action" value="ajouter"/>
                <input class="btn btn-primary" type="submit" value="Ajouter Projet"/>
              </form>
            </div>
<?php
}
?>
          </aside>
<?php $s->footer(); ?>
