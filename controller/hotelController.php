<?php
// CONTROLEUR de l'affichage de la liste des classes 

// Modèles nécessaires
require_once 'model/HotelM.php';

// Récupération de la liste des hotel pour affichage liste
$hotelM = new HotelM();
$hotelList=$hotelM->getAllHotel($hotelM->ColumnNameIsValid("nom"));

// Affichage du résultat dans la vue
require_once 'view/hotel/listHotel.php';

//Absence de la balise fermeture php volontaire