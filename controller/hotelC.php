<?php
// CONTROLEUR de l'affichage de la liste des classes 

// Modèles nécessaires
require_once 'model/HotelM.php';

// Récupération de la liste des hotel pour affichage liste
$hotelM = new HotelM();
if(isset($_POST["nohotel"]) && in_array($_POST["nohotel"],$hotelM->getAllIdHotel())) $infoHotel=$hotelM->getHotel($_POST["nohotel"]); else echo "<script>document.addEventListener('DOMContentLoaded', function() {pageRedirection('404', {messageErreur: 'Hotel inconnu'});});</script>";

// Affichage du résultat dans la vue
if (isset($infoHotel)) require_once 'view/hotel/ficheHotel.php';

//Absence de la balise fermeture php volontaire