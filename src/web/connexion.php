<?php
require_once("../web/config.php");

/********** pour tester avec un developpeur connecté **********/
/*$_SESSION["id_co"] = 1;*/
if (!isset($_SESSION["session"])){

    $_SESSION["expire"] = time() + (30 * 60); // 30 mn plus tard

    $s->head("Connexion");
    $s->header();
    $s->nav($db);
?>

    <article>
		<div class="col-sm-8 text-left">
			<h2>Connexion</h2> 
			<form action="verification.php" class="form-horizontal" method="post" accept-charset="utf-8">
				<div class="form-group">
				<div class="col-md-8"><input name="identifiant" placeholder="Idenfiant" class="form-control" type="text" id="DevPseudo" required /></div>
				</div> 
				
				<div class="form-group">
				<div class="col-md-8"><input name="motDePasse" placeholder="Mot de passe" class="form-control" type="password" id="DevMDP" required /></div>
				</div> 
				
				<div class="form-group">
				<div class="col-md-offset-0 col-md-8"><input class="btn btn-primary" type="submit" value="Se connecter"/></div>
				</div>
			</form>
		</div>
    </article>
        

<?php
    $s->footer();
}
else
    header("Location: ../web/index.php");
?>
