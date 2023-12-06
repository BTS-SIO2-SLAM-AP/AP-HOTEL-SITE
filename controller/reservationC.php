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
        if (isset($_POST["nohotel"]) && in_array($_POST["nohotel"], $hotelM->getAllIdHotel())) $unHotel = $hotelM->getHotel($_POST["nohotel"]);
        else echo "<script src='assets/js/pageManager.js'></script><script></script><script>document.addEventListener('DOMContentLoaded', function() {pageRedirection('404', {messageErreur: 'Hotel inconnu'});});</script>";

        // Affichage du résultat dans la vue
        if (isset($unHotel)) require_once 'view/reservation/ficheReservation.php';
    }

    function loadConsultation()
    {
        $isConsultation = isset($_POST["btnConsulter"]);

        if ($isConsultation) {
            if (isset($_POST["txtNoRes"]) && isset($_POST["txtCodeAcces"])) {
                $modelRes = new ReservationM();
                $infoReservation = $modelRes->getReservation($_POST["txtNoRes"]);
                if ($infoReservation !== null) {
                    $codeacces = $_POST["txtCodeAcces"];
                    if ($codeacces == $infoReservation["codeacces"]) {
                        $modelHotel = new HotelM();
                        $infoHotel = $modelHotel->getHotel($infoReservation["nohotel"]);
                        $nomHotel = $infoHotel["nom"];
                        $nomClient = $infoReservation["nom"];
                        $mailClient = $infoReservation["email"];
                        $dateDebutRes = $infoReservation["datedeb"];
                        $dateFinRes = $infoReservation["datefin"];
                        $codeaccesRes = $infoReservation["codeacces"];
                        $chambresRes = $infoReservation["chambres"];
                        $noresglobale = $infoReservation["noresglobale"];
                    } else {
                        $messageErreur = "Code d'accès incorrect";
                        // echo "<script src='assets/js/pageManager.js'></script>".
                        // "<script>document.addEventListener('DOMContentLoaded', function() {pageRedirection('404', {messageErreur: 'Code d\'accès incorrect'});});</script>";
                    }
                } else {
                    $messageErreur = "Réservation inconnue";
                    // echo "<script src='assets/js/pageManager.js'></script>".
                    // "<script>document.addEventListener('DOMContentLoaded', function() {pageRedirection('404', {messageErreur: 'Réservation inconnue'});});</script>";
                }
            } else {
                $messageErreur = "Champs invalides";
                // echo "<script src='assets/js/pageManager.js'></script>".
                // "<script>document.addEventListener('DOMContentLoaded', function() {pageRedirection('404', {messageErreur: 'Réservation inconnue'});});</script>";
            }
        }

        require_once 'view/reservation/ficheConsulter.php';
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

    // Suppression d'une réservation
    function deleteReservation()
    {
        $modelRes = new ReservationM();
        $modelHotel = new HotelM();

        if (isset($_POST["nores"]) && in_array($_POST["nores"], $modelRes->getAllIdReservation())) {
            $suppressionWork = $modelRes->deleteReservation($_POST["nores"], $_POST["codeacces"]);
        } else {
            echo "<script src='assets/js/pageManager.js'></script>" .
                "<script>document.addEventListener('DOMContentLoaded', function() {pageRedirection('404', {messageErreur: 'Réservation inconnue'});});</script>";
        }

        ob_start();
        if ($suppressionWork) {
            echo "<script src='assets/js/pageManager.js'></script><script>document.addEventListener('DOMContentLoaded', function() {pageRedirection('ficheConsulter', {btnSupprimer: 'deleted' });});</script>";
        } else {
            echo "<script src='assets/js/pageManager.js'></script><script></script><script>document.addEventListener('DOMContentLoaded', function() {pageRedirection('404', {messageErreur: 'Erreur pendant la suppression'});});</script>";
        }
        $content = ob_get_clean();
        require('view/template.php');
    }
}
    


//Absence de la balise fermeture php volontaire