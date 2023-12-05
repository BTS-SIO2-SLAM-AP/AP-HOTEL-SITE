<?php
//VUE liste des classes avec lien hypertexte
//Préparation flux HTML pour le template
ob_start();

echo $nomHotel . "<br/>";

echo $nom."<br/>";
echo $mail."<br/>";
echo date("d-m-Y", strtotime($datedebut))."<br/>";
echo date("d-m-Y", strtotime($datefin))."<br/>";
echo $codeacces."<br/>";

// affichage des chambre réservées
foreach ($chambres as $uneChambre) {
    echo $uneChambre["nochambre"]."<br/>";
}

?>

<?php
//Ouverture du template
$title = "Balladins - Réservation hôtel $nomHotel";
$content = ob_get_clean();
require('view/template.php');
?>