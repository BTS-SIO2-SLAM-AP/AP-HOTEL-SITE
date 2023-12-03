<?php
// CONTROLEUR de l'affichage de la liste des classes 

// Modèles nécessaires
require_once 'model/HotelM.php';
require_once 'model/EquipementM.php';

// Récupération de la liste des equipements pour affichage liste
$equipementM = new EquipementM();
$listEquipement=$equipementM->getAllEquipement();

// Récupération de la liste des hotel pour affichage liste
$hotelM = new HotelM();
$listHotel=$hotelM->getAllHotel("nom");

$prixMax = $hotelM->getMaxPrice();

// Affichage du résultat dans la vue
require_once 'view/hotel/listHotel.php';

//Absence de la balise fermeture php volontaire