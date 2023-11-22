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

if(isset($_POST["equipements"]))
{
    $listHotelFiltred = [];
    $equipements = isset($_POST["equipements"]) ? $_POST["equipements"] : [];
    
    foreach ($equipementM->getHotelsEquipement($equipements) as $unHotel) {
        // J'assume que $listHotel est une variable existante
        $hotel = $hotelM->getHotel($listHotel, $unHotel["nohotel"]);
    
        // Assurez-vous que l'hôtel n'est pas vide avant de l'ajouter à la liste filtrée
        if (!empty($hotel)) {
            $listHotelFiltred[] = $hotel;
        }
    }
}

if(isset($_POST["ville"]) && !empty($_POST["ville"]))
{
    $listHotelFiltred=[];
    $ville = isset($_POST["ville"]) ? $_POST["ville"] : [];

    foreach ($hotelM->getHotelsVille($ville) as $unHotel) {
        $hotel = $hotelM->getHotel($listHotel, $unHotel["nohotel"]);

        if (!empty($hotel)) {
            $listHotelFiltred[] = $hotel;
        }
    }
}

if(isset($listHotelFiltred)){
    $listHotel=$listHotelFiltred;
}

$nbHotel = count($listHotel);

// Affichage du résultat dans la vue
require_once 'view/hotel/listHotel.php';

//Absence de la balise fermeture php volontaire