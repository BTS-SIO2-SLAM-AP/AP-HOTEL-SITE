<?php

class ReservationController
{
    public static function create(){

        require_once "app/views/reservation/creation.php";
    }

    public static function view(){

        require_once "app/views/reservation/visualisation.php";
    }
}