<?php
//VUE liste des classes avec lien hypertexte
//Préparation flux HTML pour le template
ob_start();

echo $unHotel["nom"];
?>
<form id='form_<?php echo $unHotel["nohotel"] ?>' method='post' action="index.php">
    <input type="date" name="datedebut" value="<?php echo date("Y-m-d");  ?>">
    <input type="date" name="datefin" value="<?php echo date("Y-m-d");  ?>" style="background-color:pink;">
    <input type="email" name="txtmail">
    <input type="text" name="txtnom">

    <input type='submit' name='btnvalider' value='valider'>

    <input type='hidden' name='nohotel' value='<?php echo $unHotel["nohotel"] ?>'>
    <input type='hidden' name='page' value='saveReservation'>
    <input type='hidden' name='titre' value='<?php echo urlencode($unHotel["nom"]) ?>'>
</form>
<?php
foreach ($unHotel["chambres"] as $uneChambre) {
echo $uneChambre["nochambre"]."<br />";
}

//Ouverture du template
$title = "Balladins - Réservation $unHotel[nom]";
$content = ob_get_clean();
require('view/template.php');
?>