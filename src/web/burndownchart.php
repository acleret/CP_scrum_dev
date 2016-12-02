<?php
require_once("../web/config.php");

if (isset($_COOKIE["id_projet"])) {
  $id_pro = $_COOKIE["id_projet"];
  $infos_pro = $db->infosProjet($id_pro);
  $row_pro = $infos_pro->fetch_assoc();
  $s->head("Burdown Chart");
  $s->header($db);
  $s->nav($db);

  $tab = [];
  if($db->listeUserStoriesAvecCommit($id_pro)->num_rows > 0) {
      if (($db->listeUserStoryOutOfSprints($id_pro)->num_rows == 0) && ($db->listeUserStories($id_pro)->num_rows > 0)) {
          $tab = $db->listeChiffrageReel($id_pro);
      }
?>
    <!--<button class="btn btn-primary disabled" data-toggle="tooltip" title="Au moins une US a été commiter">calcul du Burndown Chart planifié</button>-->
<?php
  } else {
    if (($db->listeUserStoryOutOfSprints($id_pro)->num_rows > 0) || ($db->listeUserStories($id_pro)->num_rows == 0)) {
?>
    <!--<button class="btn btn-primary disabled" data-toggle="tooltip" title="Toutes les US ne sont pas dans un sprint">calcul du Burndown Chart planifié</button>-->
<?php
    } else {
      $db->modifChiffragePlanifie($id_pro);
?>
    <!--<form style="display: inline;" action="../web/calculBurndownChart.php" method="post">
      <input type="hidden" name="calculBurndownChart" value="1" />
      <input class="btn btn-primary" type="submit" value="calcul du Burndown Chart planifié" />
    </form>-->
<?php
    }
  }
?>
          <script type="text/javascript" src="http://code.jquery.com/jquery-1.11.1.min.js"></script>
          <script type="text/javascript" src="../web/js/jquery.canvasjs.min.js"></script>
          <script type="text/javascript">
            $(function () {
              //Better to construct options first and then pass it as a parameter
              var options = {
                title: {
                  text: "Burdown Chart"
                },
                legend: {
                  horizontalAlign: "right", // left, center ,right
                  verticalAlign: "top",  // top, center, bottom
                },
                animationEnabled: true,
                axisX: {
                  minimum: 0,
                  interval: 1,
                  title : "Sprints",
                },
                axisY:{
                  title : "Effort",
                },
                data: [
                  {
                    type: "spline",
                    showInLegend: true,
                    name: "series1",
                    legendText: "planifié",
                    dataPoints: [
                      <?php
                        $resultat = $db->listeChiffragePlanifie($id_pro);
                        $somme = $db->sommeChiffragePlanifie($id_pro);
                        echo "{ x: 0, y : ".$somme."},";
                        while ($row = $resultat->fetch_assoc()) {
                            echo "{ x: ".$db->numeroSprint($row["SPR_id"]).", y : ".($somme-=$row['BDC_chargePlanifie'])."},";
                        }
                      ?>
                    ]
                  },
                  {
                    type: "spline",
                    showInLegend: true,
                    name: "series2",
                    legendText: "réel",
                    dataPoints: [
                      <?php
                        $somme = $db->sommeChiffrageBacklog($id_pro);
                        echo "{ x: 0, y : ".$somme."},";
                        foreach ($tab as $key => $value) {
                          echo "{ x: ".$db->numeroSprint($key).", y : ".($somme-=$value)."},";
                        }
                      ?>
                    ]
                  }
                ]
              };
              $("#chartContainer").CanvasJSChart(options);
            });
          </script>
          <article>
            <div class="col-sm-8 text-left">
              <h2><?php echo $row_pro["PRO_nom"]; ?> - Burdown Chart</h2>
              <hr>
              <div id="chartContainer" style="height: 500px; width: 100%;"></div>
              <br />
            </div>
          </article>
<?php
  $s->footer();
} else {
  header("Location: ../web/index.php");
  exit();
}
?>
