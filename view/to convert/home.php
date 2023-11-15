<?php
    //VUE d'affichage accueil
    //Préparation flux HTML pour le template
    // ob_start();
    $title = "Balladins";
    $content = isset($content) ? $content : "";
    $data = isset($data) ? $data : [];
?>

<div>
    test
    <?php

    echo("<br/>Hotels :<br/>");

    Foreach ($data["leshotels"] as $unhotel)
    { 
        echo ("$unhotel[nom] - $unhotel[prix]€<br/>");
    }
    ?>
</div>
<?php 
require_once "layouts/navbar.php";
require_once "layouts/filtre.php";
?>