<?php
//VUE liste des classes avec lien hypertexte
//Préparation flux HTML pour le template
ob_start();

echo $unHotel["nom"];

echo $nom."<br/>";
echo $mail."<br/>";
echo $datedebut."<br/>";
echo $datefin."<br/>";
echo $codeacces."<br/>";

// affichage des chambre réservées
foreach ($chambres as $uneChambre) {
    echo $uneChambre."<br/>";
}

?>

<?php
//Ouverture du template
$title = "Balladins - Réservation $unHotel[nom]";
$content = ob_get_clean();
require('view/template.php');
?>