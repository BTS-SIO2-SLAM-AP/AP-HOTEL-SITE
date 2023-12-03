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
        if(isset($_POST["nohotel"]) && in_array($_POST["nohotel"],$hotelM->getAllIdHotel())) $unHotel=$hotelM->getHotel($_POST["nohotel"]); else echo "<script src='assets/js/pageManager.js'></script><script></script><script>document.addEventListener('DOMContentLoaded', function() {pageRedirection('404', 'Hotel inconnu');});</script>";

        // Affichage du résultat dans la vue
        if (isset($unHotel)) require_once 'view/reservation/ficheReservation.php';
    }

    function saveReservation() {
        
        $hotelM = new HotelM();
        if (isset($_POST["nohotel"]) && in_array($_POST["nohotel"],$hotelM->getAllIdHotel())) $unHotel=$hotelM->getHotel($_POST["nohotel"]); else echo "<script src='assets/js/pageManager.js'></script><script></script><script>document.addEventListener('DOMContentLoaded', function() {pageRedirection('404', 'Hotel inconnu');});</script>";
        
        if (isset($unHotel)) {
            $nohotel = $_POST["nohotel"];
            $nom = $_POST["txtnom"];
            $mail = $_POST["txtmail"];
            $datedebut = $_POST["datedebut"];
            $datefin = $_POST["datefin"];
            $chambres = $_POST["chambres"];

            // génération du code d'accès à 5 chiffres
            $codeacces = str_pad(rand(0, 99999), 5, "0", STR_PAD_LEFT);
    
            $modelRes = new ReservationM();
            $no = $modelRes->saveReservation($nohotel, $chambres, $datedebut, $datefin, $nom, $mail, $codeacces);

            require_once 'view/reservation/reservationSaved.php';
        }
    }
}
    


//Absence de la balise fermeture php volontaire