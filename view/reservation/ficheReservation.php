<?php
//VUE liste des classes avec lien hypertexte
//Préparation flux HTML pour le template
ob_start();

echo $unHotel["nom"];
?>
<form id='form_<?php echo $unHotel["nohotel"] ?>' method='post' action="index.php">
    <input type="date" name="datedebut" value="<?php echo date("Y-m-d");  ?>" required>
    <input type="date" name="datefin" value="<?php echo date("Y-m-d");  ?>" style="background-color:pink;" required>
    <input type="email" name="txtmail" required>
    <input type="text" name="txtnom" required>
    <select name="chambres[]" multiple required>
        <?php
        foreach ($unHotel["chambres"] as $uneChambre) {
            echo "<option value='$uneChambre[nochambre]'>N°$uneChambre[nochambre]</option>";
        }
        ?>
    </select>

    <input type='submit' name='btnvalider' value='valider'>

    <input type='hidden' name='nohotel' value='<?php echo $unHotel["nohotel"] ?>'>
    <input type='hidden' name='page' value='saveReservation'>
    <input type='hidden' name='titre' value='<?php echo urlencode($unHotel["nom"]) ?>'>
</form>
<?php
//Ouverture du template
$title = "Balladins - Réservation hôtel $unHotel[nom]";
$content = ob_get_clean();
require('view/template.php');
?>