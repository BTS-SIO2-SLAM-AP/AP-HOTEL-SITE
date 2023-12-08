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
        if (isset($_POST["nohotel"]) && in_array($_POST["nohotel"], $hotelM->getAllIdHotel())) {$unHotel = $hotelM->getHotel($_POST["nohotel"]); $lesChambres = $chambreM->getAllChambres($unHotel["nohotel"]);}
        else echo "<script src='assets/js/pageManager.js'></script><script></script><script>document.addEventListener('DOMContentLoaded', function() {pageRedirection('404', {messageErreur: 'Hotel inconnu'});});</script>";

        // Affichage du résultat dans la vue
        if (isset($unHotel)) require_once 'view/reservation/ficheReservation.php';
    }

    function saveReservation()
    {

        $hotelM = new HotelM();
        if (isset($_POST["nohotel"]) && in_array($_POST["nohotel"], $hotelM->getAllIdHotel())) $unHotel = $hotelM->getHotel($_POST["nohotel"]);
        else echo "<script src='assets/js/pageManager.js'></script><script></script><script>document.addEventListener('DOMContentLoaded', function() {pageRedirection('404', {messageErreur: 'Hotel inconnu'});});</script>";

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

            ob_start();
            if ($noresglobale != 0) {
                echo "<script src='assets/js/pageManager.js'></script><script></script><script>document.addEventListener('DOMContentLoaded', function() {pageRedirection('reservationSaved', {noresglobale: $noresglobale});});</script>";
            } else {
                echo "<script src='assets/js/pageManager.js'></script><script></script><script>document.addEventListener('DOMContentLoaded', function() {pageRedirection('404', {messageErreur: 'Erreur pendant la réservation'});});</script>";
            }
            $content = ob_get_clean();
            require('view/template.php');
        }
    }

    function loadReservationSaved()
    {
        $modelRes = new ReservationM();
        $modelHotel = new HotelM();

        if (isset($_POST["noresglobale"]) && in_array($_POST["noresglobale"], $modelRes->getAllIdReservation())) {
            $infoReservation = $modelRes->getReservation($_POST["noresglobale"]);
            $infoHotel = $modelHotel->getHotel($infoReservation["nohotel"]);

            $nomHotel = $infoHotel["nom"];
            $nom = $infoReservation["nom"];
            $mail = $infoReservation["email"];
            $datedebut = $infoReservation["datedeb"];
            $datefin = $infoReservation["datefin"];
            $codeacces = $infoReservation["codeacces"];
            $chambres = $infoReservation["chambres"];
            $noresglobale = $infoReservation["noresglobale"];
        } else {
            echo "<script src='assets/js/pageManager.js'></script>" .
                "<script>document.addEventListener('DOMContentLoaded', function() {pageRedirection('404', {messageErreur: 'Réservation inconnue'});});</script>";
        }

        if (isset($infoReservation)) require_once 'view/reservation/reservationSaved.php';
    }

    // Retourne la liste des chambres disponibles pour une période donnée à afficher dans un select
    function getChambresDisponibles($nohotel, $datedebut, $datefin)
    {
        $modelChambre = new ChambreM();
        $modelHotel = new HotelM();

        if (in_array($nohotel, $modelHotel->getAllIdHotel())) {
            // echo $nohotel ."-". $datedebut ."-". $datefin;
            $chambresDisponibles = $modelChambre->getChambresDispo($nohotel, $datedebut, $datefin);
            echo json_encode($chambresDisponibles);
        }
    }
}
    


//Absence de la balise fermeture php volontaire