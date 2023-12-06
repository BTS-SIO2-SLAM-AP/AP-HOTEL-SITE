<?php 
ob_start();



?>
<form method='post' action='index.php'>
    <label for='txtConsulter'> Rentrez votre numéro de réservation :</label></br>
    <input type='text' name='txtConsulter'>
</br></br>
    <label for='txtCodeAcces'> Rentrez votre code d'accès :</label></br>
    <input type='text' name='txtCodeAcces'> 
</br></br>
    <input type='submit' name='btnConsulter' value='Consulter ma réservation'>
    
    <input type="hidden" name="page" value="ficheConsulter">

</form>

<?php 

if(isset($_POST["btnConsulter"])==true) {
    $classReservation = new reservationC();

	$classReservation->getReservation($_POST["txtConsulter"],$_POST["txtCodeAcces"]);
}



?>
<?php
//Ouverture du template
$title = "Balladins - Consultation réservation";
$content = ob_get_clean();
require('view/template.php');
?>