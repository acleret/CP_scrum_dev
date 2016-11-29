<?php
require_once("../web/config.php");

if (isset($_COOKIE["id_projet"])) {
  $id_pro = $_COOKIE["id_projet"];
  $infos_pro = $db->infosProjet($id_pro);
  $row_pro = $infos_pro->fetch_assoc();
  $s->head("Burdown Chart");
  $s->header($db);
  $s->nav($db);
?>
          <script type="text/javascript" src="http://code.jquery.com/jquery-1.11.1.min.js"></script>
          <script type="text/javascript" src="../web/js/jquery.canvasjs.min.js"></script>
          <script type="text/javascript">
          $(function () {
            //Better to construct options first and then pass it as a parameter
            var options = {
              title: {
                text: "Spline Chart using jQuery Plugin"
              },
              animationEnabled: true,
              data: [
                {
                  type: "spline", //change it to line, area, column, pie, etc
                  dataPoints: [
                    { x: 10, y: 10 },
                    { x: 20, y: 12 },
                    { x: 30, y: 8 },
                    { x: 40, y: 14 },
                    { x: 50, y: 6 },
                    { x: 60, y: 24 },
                    { x: 70, y: -4 },
                    { x: 80, y: 10 }
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
            </div>
          </article>
<?php
  $s->footer();
} else {
  header("Location: ../web/index.php");
  exit();
}
?>
