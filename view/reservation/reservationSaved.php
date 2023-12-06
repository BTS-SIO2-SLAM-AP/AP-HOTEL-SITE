<?php
//VUE liste des classes avec lien hypertexte
//Préparation flux HTML pour le template
ob_start();

// Créer un formateur pour afficher la date
$formatter = new IntlDateFormatter('fr_FR');
$formatter->setPattern('EEEE d MMMM y');

// Convertir la chaîne en objet DateTime
$dateDebutResConvert = DateTime::createFromFormat('d/m/Y', date("d/m/Y", strtotime($datedebut)));
$dateFinResConvert = DateTime::createFromFormat('d/m/Y', date("d/m/Y", strtotime($datefin)));

echo "Hôte : Hôtel $nomHotel<br/>";

echo "Numéro de réservation : $noresglobale<br/>".
    "Code d'accès : $codeacces<br/>".
    "Réserver du " . $formatter->format($dateDebutResConvert) . " au " . $formatter->format($dateFinResConvert) . "<br/>" .
    "Nom : $nom<br/>".
    "Email : $mail<br/>".
    "Chambres réservées : <br/>N°" .
        implode(", N°", array_column($chambres, 'nochambre'));

?>

<?php
//Ouverture du template
$title = "Balladins - Réservation hôtel $nomHotel";
$content = ob_get_clean();
require('view/template.php');
?>