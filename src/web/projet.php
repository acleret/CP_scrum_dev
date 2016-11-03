<?php
require_once("../web/config.php");

if(isset($_COOKIE["id_projet"])) {
    $id_pro = $_COOKIE["id_projet"];
    if (!$db->testIDProjet($id_pro))+
        header("Location: ../web/listeProjets.php");
    else {
        $infos = $db->infosProjet($id_pro);
        $row = $infos->fetch_assoc();  

        $s->head("Liste des Projets");
        $s->header();
        $s->nav($db);  
?>

        <article>
        <div class="col-sm-8 text-left">
        <h2><?php echo $row["PRO_nom"];?></h2>
        <hr>
        <h4>Équipe de développement</h4>
        <h5>Product owner : </h5>
<?php
        $id_PO = $row["DEV_idProductOwner"];
        $infos_PO = $db->infosDeveloppeur($id_PO);
        $row_PO = $infos_PO->fetch_assoc();
        echo $row_PO["DEV_pseudo"];
?>
        <h5>Scrum master : </h5>
<?php
        $id_SM = $row["DEV_idScrumMaster"];
        $infos_SM = $db->infosDeveloppeur($id_SM);
        $row_SM = $infos_SM->fetch_assoc();
        echo $row_SM["DEV_pseudo"];
?>        
        <h5>Développeurs : </h5>
        <ul>

<?php
        $result = $db->listeDeveloppeursProjet($id_pro);
        while ($row_dev = $result->fetch_assoc()) {
            echo "<li>".$row_dev["DEV_pseudo"]."</li>\n";
        }        
?>
        </ul>
        <h5>Client :</h5>
<?php
        echo $row["PRO_client"];
?>
        <h5>Description :</h5>
<?php
        echo $row["PRO_description"];
?>

    
        </div>
        </article>
    
        <aside>
<?php
        if (isset($_SESSION["id_dev"])) {
            if ($db->estMembreProjet($row["PRO_id"], $_SESSION["id_dev"])) {
?>
                <div class="col-sm-2 sidenav">
                <div class="well">
                <form style="display: inline;" action="../web/formulaireProjet.php" method="post">
                <input class="btn btn-primary" type="submit" value="Modifier Projet"/>
                </form>
                <br><br>
                <form style="display: inline;" action="../web/supprimerProjet.php" method="post">
                <input class="btn btn-primary" type="submit" value="Supprimer Projet"/>
                </form>
                </div>
                </div>
<?php
            }
        }
            
?>
        </aside>
   
<?php
        $s->footer();
    }
} else {
    $url = $_SERVER["REQUEST_URI"];
    header("Location: ../web/listeProjets.php?url=".$url);
}
?>

