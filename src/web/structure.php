<?php
class Structure {

  public function head($titrePage) {
?>
<!doctype html>
<html>
  <head>
    <title><?php echo $titrePage ?></title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
    <link rel="stylesheet" type="text/css" href="../web/css/style.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.1.1/jquery.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
  </head>
<?php
  }

  public function header() {
?>
  <body>
    <header>
      <nav class="navbar navbar-inverse">
        <div class="container-fluid">
          <div class="navbar-header">
            <button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#myNavbar">
              <span class="icon-bar"></span>
              <span class="icon-bar"></span>
              <span class="icon-bar"></span>
            </button>
            <a class="navbar-brand" href="#">CdP</a>
          </div>
          <div class="collapse navbar-collapse" id="myNavbar">
            <ul class="nav navbar-nav">
              <li class="active"><a href="../web/listeProjets.php">Accueil</a></li>
<?php
    if(isset($_COOKIE["id_projet"])) {
?>
              <li><a href="../web/projet.php">Projet</a></li>
              <li><a href="../web/backlog.php">Backlog</a></li>
              <li><a href="../web/sprints.php">Sprints</a></li>
              <li><a href="../web/tracabilite.php">Traçabilité</a></li>
<?php
    }
?>
            </ul>
            <!--
            <ul class="nav navbar-nav navbar-right">
              <li><a href="#"><span class="glyphicon glyphicon-log-in"></span> Login</a></li>
            </ul>
            -->
          </div>
        </div>
      </nav>
    </header>
    <section>
      <div class="container-fluid text-center">
        <div class="row content">
<?php
  }

  public function nav($db) {
?>
          <nav>
            <div class="col-sm-2 sidenav">
<?php
    if (isset($_SESSION["id_dev"])) {
      $id_dev = $_SESSION["id_dev"];
      if ($db->testIDDeveloppeur($id_dev)) {
        $result = $db->infosDeveloppeur($id_dev);
        $row = $result->fetch_assoc();
        if (empty($row["DEV_urlAvatar"])) {
?>
              <p><img src="../web/img/avatar-default.jpg" alt="Avatar" height="42" width="42"/></p>
<?php
        } else {
?>
              <p><img src="<?php echo $row["DEV_urlAvatar"]; ?>" alt="Avatar" height="42" width="42"/></p>
<?php
        }
?>
              <p>
                <a href="../web/profil.php"><?php echo $row["DEV_pseudo"]; ?></a><br>
                <a href="../web/deconnexion.php">déconnexion</a>
              </p>
              <br>
              <p>Mes projets:</p>
<?php
      $result = $db->listeProjetsDeveloppeur($id_dev);
        while ($row = $result->fetch_assoc()) {
?>
              <form style="display: inline;" action="../web/setProjet.php" method="post">
                <input type="hidden" name="id_projet" value="<?php echo $row["PRO_id"]; ?>"/>
                <input class="url" type="submit" value="<?php echo substr($row["PRO_nom"], 0, 19); ?>" />
              </form>
              <br>
<?php
        }
      } else {
        echo "<p>erreur dev ".$id_dev." inconnu<p>\n";
      }
?>
              <br>
<?php
    } else {
?>
              <p>
                <a href="../web/connexion.php">connexion</a><br>
                <a href="../web/inscription.php">inscription</a>
              </p>
<?php
    }
?>
            </div>
          </nav>
<?php
  }

  public function footer() {
?>
        </div>
      </div>
    </section>
    <footer class="container-fluid text-center">
      <p>Footer Text</p>
    </footer>
  </body>
</html>
<?php
  }
}
?>
