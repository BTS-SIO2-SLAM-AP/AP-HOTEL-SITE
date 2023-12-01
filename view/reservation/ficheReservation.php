<?php
//VUE liste des classes avec lien hypertexte
//Préparation flux HTML pour le template
ob_start();

echo $unHotel["nom"];

foreach ($unHotel["chambres"] as $uneChambre) {
    echo $uneChambre["nochambre"]."<br/>";
}

//Ouverture du template
$title = "Balladins - Réservation $unHotel[nom]";
$content = ob_get_clean();
require('view/template.php');
?>