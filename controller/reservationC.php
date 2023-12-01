<?php
// CONTROLEUR de l'affichage de la liste des classes 

// Modèles nécessaires
require_once 'model/HotelM.php';

// Récupération de la liste des hotel pour affichage liste
$hotelM = new HotelM();
if(isset($_POST["nohotel"]) && in_array($_POST["nohotel"],$hotelM->getAllIdHotel())) $unHotel=$hotelM->getHotel($_POST["nohotel"]); else header("Location: index.php");

// Affichage du résultat dans la vue
require_once 'view/reservation/ficheReservation.php';

//Absence de la balise fermeture php volontaire