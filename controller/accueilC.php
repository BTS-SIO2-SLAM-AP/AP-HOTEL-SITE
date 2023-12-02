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
$listHotel=$hotelM->getAllHotel("prix", isset($_REQUEST["equipements"]) ? $_REQUEST["equipements"] : "", isset($_REQUEST["ville"]) ? $_REQUEST["ville"] : "", isset($_REQUEST["prix"]) ? $_REQUEST["prix"] : 9999);

$nbHotel = count($listHotel);

// Affichage du résultat dans la vue
require_once 'view/hotel/listHotel.php';

//Absence de la balise fermeture php volontaire