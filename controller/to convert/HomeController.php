<?php
require_once "app/utils/DB.php";
$_SESSION = isset($_SESSION) ? $_SESSION : [];

class HomeController
{
    public static function home(){
        
        $leshotels = DB::query("SELECT nom, prix FROM hotel ORDER BY nom");
        if(!$leshotels){$leshotels = [];}
        $data = [
            "leshotels" => $leshotels
        ];
        require_once "views/home.php";
    }
}