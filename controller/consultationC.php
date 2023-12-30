<?php
// CONTROLEUR de l'affichage de la liste des classes 

// Modèles nécessaires
require_once 'model/HotelM.php';
require_once 'model/ReservationM.php';

class consultationC
{

    // Affichage de la page de consultation de réservation
    function loadConsultation()
    {
        $isConsultation = isset($_POST["consultation"]);

        // Mode consultation
        if ($isConsultation) {
            if (isset($_POST["txtNoRes"]) && isset($_POST["txtCodeAcces"])) {
                $modelRes = new ReservationM();
                $infoReservation = $modelRes->getReservation($_POST["txtNoRes"]);
                // Vérifie que la réservation existe
                if ($infoReservation !== null) {
                    $codeacces = $_POST["txtCodeAcces"];
                    // Vérifie que le code d'accès est correct
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

                        // Créer un formateur pour afficher la date
                        $formatter = new IntlDateFormatter('fr_FR');
                        $formatter->setPattern('EEEE d MMMM y');

                        // Convertir la chaîne en objet DateTime
                        $dateDebutResConvert = DateTime::createFromFormat('d/m/Y', date("d/m/Y", strtotime($dateDebutRes)));
                        $dateFinResConvert = DateTime::createFromFormat('d/m/Y', date("d/m/Y", strtotime($dateFinRes)));

                        $dateDebutStr = $formatter->format($dateDebutResConvert);
                        $dateFinStr = $formatter->format($dateFinResConvert);
                    } else {
                        $messageFormErreur = "Code d'accès incorrect";
                    }
                } else {
                    $messageFormErreur = "Réservation inconnue";
                }
            } else {
                $messageFormErreur = "Champs invalides";
            }
        }

        require_once 'view/reservation/ficheConsulter.php';
    }

    // Suppression d'une réservation
    function deleteReservation()
    {
        $modelRes = new ReservationM();
        $modelHotel = new HotelM();

        // Vérifie que la réservation existe
        if (isset($_POST["nores"]) && in_array($_POST["nores"], $modelRes->getAllIdReservation())) {
            $suppressionWork = $modelRes->deleteReservation($_POST["nores"], $_POST["codeacces"]);
        } else {
            // Si la réservation n'existe pas, on redirige vers la page d'erreur 404 avec un message d'erreur
            echo "<script>document.addEventListener('DOMContentLoaded', function() {pageRedirection('404', {messageErreur: 'Réservation inconnue'});});</script>";
        }

        ob_start();
        // Vérifie que la suppression a bien fonctionné
        if ($suppressionWork) {
            // Si oui, on affiche que la suppression a bien fonctionné
            echo "<script>document.addEventListener('DOMContentLoaded', function() {pageRedirection('ficheConsulter', {deleted: 'deleted' });});</script>";
        } else {
            // Sinon, on redirige vers la page d'erreur 404 avec un message d'erreur
            echo "<script></script><script>document.addEventListener('DOMContentLoaded', function() {pageRedirection('404', {messageErreur: 'Erreur pendant la suppression'});});</script>";
        }
        $content = ob_get_clean();
        require('view/template.php');
    }
}
    


//Absence de la balise fermeture php volontaire