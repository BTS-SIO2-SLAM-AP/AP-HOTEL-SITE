<?php     
session_start();
require_once("app/utils/DB.php");
require_once("app/utils/assets.php");
require_once("app/controllers/HomeController.php");
require_once("app/controllers/ReservationController.php");


$server="VGTom\\SQLSERVEREXPRESS"; // à modifier en fonction du serveur

// Connexion à la base de données
DB::init($server, "bdhotel_lepers-vieillard", "sa", "mdpsa");


Asset::init(
    str_replace("/","\\",
        // Permet de récupérer le chemin du dossier racine du site (/tests/)
        str_replace(
            str_replace("\\","/", $_SERVER['DOCUMENT_ROOT'])."","",
            str_replace("\\","/", dirname(__FILE__))."/"
        )
    )
);

if(!isset($_GET['page'])){
    header("Location:".Asset::url("/home"));
    exit;
} else {
    $page = $_GET['page'];
    if (str_starts_with($page, '/home')) HomeController::index();
    if (str_starts_with($page, '/create')) ReservationController::create();
    if (str_starts_with($page, '/view')) ReservationController::view();
}