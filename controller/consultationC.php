<?php
// CONTROLEUR de l'affichage de la liste des classes 

// Modèles nécessaires
require_once 'model/HotelM.php';
require_once 'model/ReservationM.php';

class consultationC
{

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
                    }
                } else {
                    $messageErreur = "Réservation inconnue";
                }
            } else {
                $messageErreur = "Champs invalides";
            }
        }

        require_once 'view/reservation/ficheConsulter.php';
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