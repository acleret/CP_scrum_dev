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
            <a class="navbar-brand" href="accueil.php">CdP</a>
          </div>
          <div class="collapse navbar-collapse" id="myNavbar">
            <ul class="nav navbar-nav">
              <li class="active"><a href="../web/listeProjets.php">Accueil</a></li>
<?php
    if(isset($_COOKIE["id_projet"])) {
?>
              <li><a href="../web/projet.php">Projet</a></li>
              <li><a href="../web/backlog.php">Backlog</a></li>
              <li><a href="../web/listeSprints.php">Sprints</a></li>
              <li><a href="../web/tracabilite.php">Traçabilité</a></li>
<?php
    }
?>
            </ul>
						<form class="navbar-form navbar-right inline-form">
							<div class="form-group">
								<input type="search" class="input-sm form-control" placeholder="Recherche">
								<button type="submit" class="btn btn-primary btn-sm"><span class="glyphicon glyphicon-eye-open"></span> Chercher</button>
								</div>
							</form>

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
    if (isset($_SESSION["session"])) {
      if (empty($_SESSION["image_co"])) {
?>
              <p>
                <img src="../web/img/avatar-default.jpg" alt="Avatar" height="60" width="60" class="img-rounded"/>
                <br>
                <br>
<?php
      } else {
?>
              <p>
                <img src="<?php echo $_SESSION["image_co"]; ?>" alt="Avatar" height="60" width="60" class="img-rounded"/>
                <br>
                <br>
<?php
      }
?>
                <a href="profil.php"><?php echo $_SESSION["pseudo_co"]; ?></a>
              </p>
              <p> - </p>
              <p>
                <a href="../web/deconnexion.php">Déconnexion</a>
              </p>
              <p> - </p>
              <p>Mes collaborations:</p>
<?php
      $id_dev = $_SESSION["id_co"];
      $result = $db->listeProjetsDeveloppeur($id_dev);
      while ($row = $result->fetch_assoc()) {
?>
              <form style="display: inline;" action="../web/setProjet.php" method="post">
                <input type="hidden" name="id_projet" value="<?php echo $row["PRO_id"]; ?>"/>
                <input class="url" type="submit" value="<?php echo substr($row["PRO_nom"], 0, 19); ?>"/>
              </form>
              <br>
<?php
      }
   } else {
?>
              <p>
                <a href="../web/connexion.php">Connexion</a><br>
                <a href="../web/inscription.php">Inscription</a>
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
      <p>Copyright 2016 - Conduite de projet facile - Tous droits réservés</p>
    </footer>
		
		<script>
			function pagePrecedente(page_actuelle){
				var nouvelle_page = page_actuelle - 1;
				if(nouvelle_page > 0)
					document.location.href="listeProjets.php?page="+nouvelle_page;
			}
			function pageSuivante(page_actuelle, nombre_de_pages){
				var nouvelle_page = page_actuelle + 1;
				if(nouvelle_page < nombre_de_pages+1)
					document.location.href="listeProjets.php?page="+nouvelle_page;
			}
			</script>
  </body>
</html>
<?php
  }

  public function suppressionCookies() {
    // suppression du cookie qui contient l'id du projet courant
    if (isset($_COOKIE["id_projet"])){
      setcookie("id_projet", false, time() - 3600);
      unset($_COOKIE["id_projet"]);
    }
  }

}
?>
