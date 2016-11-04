<?php
require_once("../web/config.php");

if(isset($_SESSION["session"]) and $_SESSION["session"]==true) {
	$id_dev = $_SESSION["id_co"];

	$infos = $db->infosDeveloppeur($id_dev);
	$row = $infos->fetch_assoc();  

	$s->head("Mon profil");
	$s->header();
	$s->nav($db);  
?>
	<article>
	<div class="col-sm-8 text-left">
		<h2><?php echo $row["DEV_pseudo"];?></h2>
		<hr>
		
		<h4>Mon nom : </h4>
		<?php echo $row["DEV_nom"];?>
		<h4>Mon prénom : </h4>
		<?php echo $row["DEV_prenom"];?>
		<h4>Mon mail : </h4>
		<?php echo $row["DEV_mail"];?>
		<hr>
		
		<h4>Mes projets :</h4>
		<ul>
<?php
		$projets = $db->listeProjetsParDev($id_dev);
		while ($projet = $projets->fetch_assoc()) {
			echo '<li><a href="projet.php">'.$projet["PRO_nom"].'</a></li>';
			echo '<p>'.$projet["PRO_description"].'<br>';
			echo 'Créé le '.$projet["PRO_date_creation"].' pour '.$projet["PRO_client"].'.</p>';
		}
?>
		</ul>
		<hr>
		
		<h4>Mes collaborations :</h4>
		<ul>
<?php
		$projets = $db->listeProjetsParDev($id_dev);
		while ($projet = $projets->fetch_assoc()) {
			echo '<li><a href="projet.php">'.$projet["PRO_nom"].'</a></li>';
			echo '<p>'.$projet["PRO_description"].'<br>';
			echo 'Créé le '.$projet["PRO_date_creation"].' pour '.$projet["PRO_client"].'.<br>';
			
			echo 'Participation en tant que développeur';
			if ($db->estScrumMaster($id_dev, $projet["PRO_id"]))
				echo ' et Scrum Master';
			echo '.</p>';
			
		}
?>
		</ul>
		<hr>
	</div>
	</article>
    
	<aside>
		<div class="col-sm-2 sidenav">
		<div class="well">
			<form style="display: inline;" action="../web/formulaireProfil.php" method="post">
			<input class="btn btn-primary" type="submit" value="Éditer le profil"/>
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
    $url = $_SERVER["REQUEST_URI"];
    header("Location: ../web/listeProjets.php?url=".$url);
	header("Location: index.php");
}
?>