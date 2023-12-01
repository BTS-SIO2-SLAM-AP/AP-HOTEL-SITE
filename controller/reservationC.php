<?php
// CONTROLEUR de l'affichage de la liste des classes 

// Modèles nécessaires
require_once 'model/HotelM.php';
require_once 'model/ReservationM.php';

class reservationC
{
    function loadView(){
        // Récupération de la liste des hotel pour affichage liste
        $hotelM = new HotelM();
        if(isset($_POST["nohotel"]) && in_array($_POST["nohotel"],$hotelM->getAllIdHotel())) $unHotel=$hotelM->getHotel($_POST["nohotel"]); else echo "<script src='assets/js/gestion404.js'></script><script></script><script>document.addEventListener('DOMContentLoaded', function() {redirection404('Hotel inconnu');});</script>";

        // Affichage du résultat dans la vue
        require_once 'view/reservation/ficheReservation.php';
    }

    function saveReservation() {
        
        $hotelM = new HotelM();
        if(isset($_POST["nohotel"]) && in_array($_POST["nohotel"],$hotelM->getAllIdHotel())) $unHotel=$hotelM->getHotel($_POST["nohotel"]); else echo "<script src='assets/js/gestion404.js'></script><script></script><script>document.addEventListener('DOMContentLoaded', function() {redirection404('Hotel inconnu');});</script>";
        
        $mail = $_POST["txtmail"];
        $nom = $_POST["txtnom"];
        $datedebut = $_POST["datedebut"];
        $datefin = $_POST["datefin"];
        $modelRes = new ReservationM();
        $no = $modelRes->saveReservation($_POST["nohotel"]);
        

        require_once 'view/reservation/reservationSaved.php';
    }
}
    


//Absence de la balise fermeture php volontaire