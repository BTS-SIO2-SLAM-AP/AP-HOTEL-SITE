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
        if(isset($_POST["nohotel"]) && in_array($_POST["nohotel"],$hotelM->getAllIdHotel())) $unHotel=$hotelM->getHotel($_POST["nohotel"]); else echo "<script src='assets/js/pageManager.js'></script><script></script><script>document.addEventListener('DOMContentLoaded', function() {pageRedirection('404', {messageErreur: 'Hotel inconnu'});});</script>";

        // Affichage du résultat dans la vue
        if (isset($unHotel)) require_once 'view/reservation/ficheReservation.php';
    }

    function loadConsultation() {
        require_once 'view/reservation/ficheConsulter.php';
    }

    function saveReservation() {
        
        $hotelM = new HotelM();
        if (isset($_POST["nohotel"]) && in_array($_POST["nohotel"],$hotelM->getAllIdHotel())) $unHotel=$hotelM->getHotel($_POST["nohotel"]); else echo "<script src='assets/js/pageManager.js'></script><script></script><script>document.addEventListener('DOMContentLoaded', function() {pageRedirection('404', {messageErreur: 'Hotel inconnu'});});</script>";
        
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
            $noresglobale = $modelRes->saveReservation($nohotel, $chambres, $datedebut, $datefin, $nom, $mail, $codeacces);

            if ($noresglobale != 0) 
            {
                ob_start();
                echo "<script src='assets/js/pageManager.js'></script><script></script><script>document.addEventListener('DOMContentLoaded', function() {pageRedirection('reservationSaved', {noresglobale: $noresglobale});});</script>";
                $content = ob_get_clean();
                require('view/template.php');
            }

            else {
                ob_start();
                echo "<script src='assets/js/pageManager.js'></script><script></script><script>document.addEventListener('DOMContentLoaded', function() {pageRedirection('404', {messageErreur: 'Erreur pendant la réservation'});});</script>";
                $content = ob_get_clean();
                require('view/template.php');
            }
        }
    }

    function loadReservationSaved() {
        $modelRes = new ReservationM();
        $modelHotel = new HotelM();

        if (isset($_POST["noresglobale"]) && in_array($_POST["noresglobale"],$modelRes->getAllIdReservation())) {
            $infoReservation=$modelRes->getReservation($_POST["noresglobale"]); 
            $infoHotel=$modelHotel->getHotel($infoReservation["nohotel"]);

            $nomHotel = $infoHotel["nom"];
            $nom = $infoReservation["nom"];
            $mail = $infoReservation["email"];
            $datedebut = $infoReservation["datedeb"];
            $datefin = $infoReservation["datefin"];
            $codeacces = $infoReservation["codeacces"];
            $chambres = $infoReservation["chambres"];
            $noresglobale = $infoReservation["noresglobale"];
        }
        else {
            echo "<script src='assets/js/pageManager.js'></script>".
            "<script>document.addEventListener('DOMContentLoaded', function() {pageRedirection('404', {messageErreur: 'Réservation inconnue'});});</script>";
        }

        if (isset($infoReservation)) require_once 'view/reservation/reservationSaved.php';
    }

    public function getReservation($nores, $codeacces) {
        $modelRes = new ReservationM();
        $modelHotel = new HotelM();

        $infoReservation=$modelRes->getReservation($nores);
        if ($infoReservation!=null) {
            $infoHotel=$modelHotel->getHotel($infoReservation["nohotel"]);
            if($codeacces == $infoReservation["codeacces"]) {
                echo 
                "<p> Hôtel :" . $infoHotel["nom"].
                " Nom Client" . $infoReservation["nom"] .
                " Mail Client" .$infoReservation["email"] .
                " Dates reservation " . $infoReservation["datedeb"]     . $infoReservation["datefin"] .
                "chambres réservées" ;
                foreach ($infoReservation["chambres"] as $chambre) {
                    echo "apagnan". $chambre    ["nochambre"];
                } 
                echo "</p>";
            }
        }

    }
}
    


//Absence de la balise fermeture php volontaire