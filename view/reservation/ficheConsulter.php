<?php
ob_start();

if(!isset($_POST["btnSupprimer"])){
    if (!$isConsultation || isset($messageErreur)) {
    ?>
        <form method='post' action='index.php'>
            <label for='txtNoRes'> Rentrez votre numéro de réservation :</label></br>
            <input type='text' name='txtNoRes' value='<?php if (isset($_POST["txtNoRes"])) echo $_POST["txtNoRes"]; ?>' required>
            </br></br>
            <label for='txtCodeAcces'> Rentrez votre code d'accès :</label></br>
            <input type='text' name='txtCodeAcces' value='<?php if (isset($_POST["txtCodeAcces"])) echo $_POST["txtCodeAcces"]; ?>' required>
            </br></br>
            <input type='submit' name='btnConsulter' value='Consulter ma réservation'>
    
            <input type="hidden" name="page" value="ficheConsulter">
        </form>
    <?php
    } else if (!isset($messageErreur)) {
        // Créer un formateur pour afficher la date
        $formatter = new IntlDateFormatter('fr_FR');
        $formatter->setPattern('EEEE d MMMM y');
    
        // Convertir la chaîne en objet DateTime
        $dateDebutResConvert = DateTime::createFromFormat('d/m/Y', date("d/m/Y", strtotime($dateDebutRes)));
        $dateFinResConvert = DateTime::createFromFormat('d/m/Y', date("d/m/Y", strtotime($dateFinRes)));
    
        echo "<p>" .
            "Informations réservation :<br/>" .
            "Hôte : Hôtel $nomHotel<br/>" .
            "Nom Client $nomClient<br/>" .
            "Mail Client $mailClient<br/>" .
    
            "Réservation du " . $formatter->format($dateDebutResConvert) . " au " . $formatter->format($dateFinResConvert) . "<br/>" .
    
            "Réservation du " . date("d/m/Y", strtotime($dateDebutRes)) . " au " . date("d/m/Y", strtotime($dateFinRes)) . "<br/>" .
    
            "Chambres réservées : <br/>N°" .
            implode(", N°", array_column($chambresRes, 'nochambre')) .
            "</p>";
        ?>
        <!-- Ajout bouton suppression réservation -->
        <form method='post' action='index.php'>
            <input type='submit' name='btnSupprimer' value='Supprimer ma réservation'>
            <input type="hidden" name="page" value="deleteReservation">
            <input type="hidden" name="nores" value="<?php echo $noresglobale; ?>">
            <input type="hidden" name="codeacces" value="<?php echo $codeaccesRes; ?>">
        <?php
    }
    if (isset($messageErreur)) echo "<p>$messageErreur</p>";
}
else {
    echo "<p>Votre réservation a bien été supprimer.</p>";
}

?>
<?php
//Ouverture du template
$title = "Balladins - Consultation réservation";
$content = ob_get_clean();
require('view/template.php');
?>