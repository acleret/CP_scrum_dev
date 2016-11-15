<?php
require_once("config.php");

if (isset($_POST["suppr_projet"])) { 
	$res = $db->suppressionProjet($_POST["suppr_projet"]);
	$s->suppressionCookies();
	if($res) header("Location: index.php");
	exit();
}

if (isset($_COOKIE["id_projet"])) {
		$id_pro = $_COOKIE["id_projet"];
		$infos = $db->infosProjet($id_pro);
		$row = $infos->fetch_assoc();
		$s->head("Page projet");
		$s->header($db);
		$s->nav($db);
?>
		<article>
			<div class="col-sm-8 text-left">
				<h2><?php echo $row["PRO_nom"];?></h2>
				<hr>

				<dl class="dl-horizontal">
					<dt>Client</dt>
					<dd><?php echo $row["PRO_client"];?></dd>
					<dt>Product owner</dt>
					<dd><?php
						$id_PO = $row["DEV_idProductOwner"];
						$infos_PO = $db->infosDeveloppeur($id_PO);
						$row_PO = $infos_PO->fetch_assoc();
						echo "<a href=\"profil.php?profil=".$row_PO["DEV_pseudo"]."\">".$row_PO["DEV_pseudo"]."</a>";
						?></dd>
					<dt>Scrum master</dt>		
					<dd><?php
								$id_SM = $row["DEV_idScrumMaster"];
								$infos_SM = $db->infosDeveloppeur($id_SM);
								$row_SM = $infos_SM->fetch_assoc();
								echo "<a href=\"profil.php?profil=".$row_SM["DEV_pseudo"]."\">".$row_SM["DEV_pseudo"]."</a>";
						?></dd>
				</dl>
					
				<dl class="dl-horizontal">
					<dt>Développeurs</dt>
					<dd>
					<ul class="list-inline">
							<?php
								$result = $db->listeDeveloppeursProjet($id_pro);
								while ($row_dev = $result->fetch_assoc()) {
									echo "<li><a href=\"profil.php?profil=".$row_dev["DEV_pseudo"]."\">".$row_dev["DEV_pseudo"]."</a></li>";
								}
							?>
						</ul>
					</dd>
				</dl>
					
				<hr>
				<p class="text-justify"><?php echo $row["PRO_description"]; ?></p>
				<br>
				<br>
			</div>
		</article>
		<aside>
<?php
		if (isset($_SESSION["session"])) {
			if ($db->estMembreProjet($row["PRO_id"], $_SESSION["id_co"])) {
?>
		<aside>
			<div class="col-sm-2 sidenav">
				<form style="display: inline;" action="../web/formulaireProjet.php" method="post">
					<input class="btn btn-primary" type="submit" value="Éditer le projet"/>
				</form>
				<br>
				<br>
				<form style="display: inline;" action="" method="post">
					<input type="hidden" name="suppr_projet" value="<?php echo $_COOKIE["id_projet"]; ?>"/>
					<input class="btn btn-primary" type="submit" value="Supprimer le projet"/>
				</form>
			</div>
		</aside>
<?php
			}
		}
		$s->footer();
	//}
}	else {
	$url = $_SERVER["REQUEST_URI"];
	header("Location: ../web/index.php?url=".$url);
	exit();
}
?>