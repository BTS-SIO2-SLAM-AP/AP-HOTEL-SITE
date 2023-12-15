<?php
// CONTROLEUR de l'affichage de la liste des classes 

// Modèles nécessaires
require_once 'model/HotelM.php';
require_once 'model/ReservationM.php';

class reservationC
{
    function loadView()
    {
        // Récupération de la liste des hotel pour affichage liste
        $hotelM = new HotelM();
        $chambreM = new ChambreM();
        if (isset($_POST["nohotel"]) && in_array($_POST["nohotel"], $hotelM->getAllIdHotel())) {
            $unHotel = $hotelM->getHotel($_POST["nohotel"]);
            $lesChambres = $chambreM->getAllChambres($unHotel["nohotel"]);
        } else echo "<script src='assets/js/pageManager.js'></script><script></script><script>document.addEventListener('DOMContentLoaded', function() {pageRedirection('404', {messageErreur: 'Hotel inconnu'});});</script>";

        // Affichage du résultat dans la vue
        if (isset($unHotel)) require_once 'view/reservation/formReservation.php';
    }

    function saveReservation()
    {

        $hotelM = new HotelM();
        if (isset($_POST["nohotel"]) && in_array($_POST["nohotel"], $hotelM->getAllIdHotel())) $unHotel = $hotelM->getHotel($_POST["nohotel"]);
        else echo "<script src='assets/js/pageManager.js'></script><script></script><script>document.addEventListener('DOMContentLoaded', function() {pageRedirection('404', {messageErreur: 'Hotel inconnu'});});</script>";

        if (isset($unHotel) && isset($_POST["txtnom"]) && isset($_POST["txtmail"]) && isset($_POST["datedebut"]) && isset($_POST["datefin"]) && isset($_POST["listchambres"])) {
            $nohotel = $unHotel["nohotel"];
            $nom = $_POST["txtnom"];
            $mail = $_POST["txtmail"];
            $datedebut = $_POST["datedebut"];
            $datefin = $_POST["datefin"];
            $chambres = array_map('intval', explode(',', trim($_POST["listchambres"])));;

            // génération du code d'accès à 5 chiffres
            $codeacces = str_pad(rand(0, 99999), 5, "0", STR_PAD_LEFT);

            $modelRes = new ReservationM();
            $noresglobale = $modelRes->saveReservation($nohotel, $chambres, $datedebut, $datefin, $nom, $mail, $codeacces);
            
        }
        ob_start();
        if ($noresglobale != 0) {
            echo "<script src='assets/js/pageManager.js'></script><script></script><script>document.addEventListener('DOMContentLoaded', function() {pageRedirection('ficheConsulter', {txtNoRes: $noresglobale, txtCodeAcces: $codeacces, consultation: 'consultation'});});</script>";
        } else {
            echo "<script src='assets/js/pageManager.js'></script><script></script><script>document.addEventListener('DOMContentLoaded', function() {pageRedirection('404', {messageErreur: 'Erreur pendant la réservation'});});</script>";
        }
        $content = ob_get_clean();
        require('view/template.php');
    }

    // Retourne la liste des chambres disponibles pour une période donnée à afficher dans un select
    function getChambresDisponibles()
    {
        $modelChambre = new ChambreM();
        $modelHotel = new HotelM();
        if (isset($_POST['nohotel']) && isset($_POST['datedebut']) && isset($_POST['datefin'])) {
            $nohotel = $_POST['nohotel'];
            $datedebut = $_POST['datedebut'];
            $datefin = $_POST['datefin'];
            if (in_array($nohotel, $modelHotel->getAllIdHotel())) {
                $chambresDisponibles = $modelChambre->getChambresDispo($nohotel, $datedebut, $datefin);
                echo json_encode($chambresDisponibles);
            }
        } else {
            echo json_encode(array());
        }
    }
}
    


//Absence de la balise fermeture php volontaire