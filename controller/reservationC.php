<?php
// CONTROLEUR de l'affichage de la liste des classes 

// Modèles nécessaires
require_once 'model/HotelM.php';
require_once 'model/ReservationM.php';

class reservationC
{
    // Affichage de la page de réservation
    function loadView()
    {
        // Récupération de la liste des hotel pour affichage liste
        $hotelM = new HotelM();
        $chambreM = new ChambreM();
        // Vérification de l'existence de l'hotel demandé
        if (isset($_POST["nohotel"]) && in_array($_POST["nohotel"], $hotelM->getAllIdHotel())) {
            $unHotel = $hotelM->getHotel($_POST["nohotel"]);
            $lesChambres = $chambreM->getAllChambres($unHotel["nohotel"]);
        } else echo "<script src='assets/js/pageManager.js'></script><script></script><script>document.addEventListener('DOMContentLoaded', function() {pageRedirection('404', {messageErreur: 'Hotel inconnu'});});</script>";

        // Affichage du résultat dans la vue
        if (isset($unHotel)) require_once 'view/reservation/formReservation.php';
    }

    // Procédure de sauvegarde de la réservation dans la base de données
    function saveReservation()
    {
        $hotelM = new HotelM();
        // Vérification de l'existence de l'hotel demandé
        if (isset($_POST["nohotel"]) && in_array($_POST["nohotel"], $hotelM->getAllIdHotel())) $unHotel = $hotelM->getHotel($_POST["nohotel"]);
        else echo "<script src='assets/js/pageManager.js'></script><script></script><script>document.addEventListener('DOMContentLoaded', function() {pageRedirection('404', {messageErreur: 'Hotel inconnu'});});</script>";

        // Vérification de l'existence des champs du formulaire
        if (isset($unHotel) && isset($_POST["txtnom"]) && isset($_POST["txtmail"]) && isset($_POST["datedebut"]) && isset($_POST["datefin"]) && isset($_POST["listchambres"])) {
            $nohotel = $unHotel["nohotel"];
            $nom = $_POST["txtnom"];
            $mail = $_POST["txtmail"];
            $datedebut = $_POST["datedebut"];
            $datefin = $_POST["datefin"];
            $chambres = array_map('intval', explode(',', trim($_POST["listchambres"])));;

            // génération du code d'accès à 5 chiffres
            // $codeacces = str_pad(rand(0, 99999), 5, "0", STR_PAD_LEFT);

            // génération d'un code d'accès (a-z, A-Z, 0-9) de 5 caractères
            $codeacces = substr(str_shuffle(str_repeat("0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ", 5)), 0, 5);

            $modelRes = new ReservationM();
            // Sauvegarde de la réservation dans la base de données
            $noresglobale = $modelRes->saveReservation($nohotel, $chambres, $datedebut, $datefin, $nom, $mail, $codeacces);
        }
        ob_start();
        if ($noresglobale != 0) {
            // Affichage de la page d'information de la réservation
            echo "<script src='assets/js/pageManager.js'></script><script></script><script>document.addEventListener('DOMContentLoaded', function() {pageRedirection('ficheConsulter', {txtNoRes: $noresglobale, txtCodeAcces: '$codeacces', consultation: 'consultation'});});</script>";
        } else {
            // Affichage de la page d'erreur en cas d'échec de la réservation
            echo "<script src='assets/js/pageManager.js'></script><script></script><script>document.addEventListener('DOMContentLoaded', function() {pageRedirection('404', {messageErreur: 'Erreur pendant la réservation'});});</script>";
        }
        $content = ob_get_clean();
        require('view/template.php');
    }

    // Retourne la liste des chambres disponibles d'un hôtel pour une période donnée
    function getChambresDisponibles()
    {
        $modelChambre = new ChambreM();
        $modelHotel = new HotelM();
        if (isset($_POST['nohotel']) && isset($_POST['datedebut']) && isset($_POST['datefin'])) {
            $nohotel = $_POST['nohotel'];
            $datedebut = $_POST['datedebut'];
            $datefin = $_POST['datefin'];

            // Vérification de l'existence de l'hotel demandé
            if (in_array($nohotel, $modelHotel->getAllIdHotel())) {
                // Récupération de la liste des chambres disponibles pour l'hotel et la période demandée
                $chambresDisponibles = $modelChambre->getChambresDispo($nohotel, $datedebut, $datefin);
                echo json_encode($chambresDisponibles);
            }
        } else {
            // Si les paramètres ne sont pas définis, on renvoie un tableau vide
            echo json_encode(array());
        }
    }
}
    


//Absence de la balise fermeture php volontaire