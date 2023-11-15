<?php
$_SESSION = isset($_SESSION) ? $_SESSION : [];

class HomeController
{
    public static function home(){
        
        require_once "app/views/home.php";
    }
}