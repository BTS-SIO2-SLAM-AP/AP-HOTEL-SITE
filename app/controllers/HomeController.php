<?php
require_once "app/utils/DB.php";
$_SESSION = isset($_SESSION) ? $_SESSION : [];

class HomeController
{
    public static function index(){
        
        require_once "app/views/home.php";
    }
}