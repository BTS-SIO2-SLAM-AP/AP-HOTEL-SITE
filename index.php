<?php
// ROUTEUR de l'application
// Permet de sélectionner le controleur adapté, en fonction de la page dans l'URL
if (isset($_POST['page'])) 
{
	$page=$_POST['page'];
}
else
{
	$page="";
}
switch ($page)
{
	case 'listhotel' :
	{ 
		require('controller/accueilC.php');
		break;
	}
	case 'ficheHotel' :
	{
		require('controller/hotelC.php');
		break;
	}	
	case 'ficheReservation':
	{
		require_once 'controller/reservationC.php';
		$classReservation = new reservationC();
		$classReservation->loadView();
		break;
	}
	case 'ficheConsulter' :
	{
		require_once 'controller/reservationC.php';
		$classReservation = new reservationC();
		$classReservation->loadConsultation();
		break;
	}
	case 'saveReservation':
	{
		require_once 'controller/reservationC.php';
		$classReservation = new reservationC();
		$classReservation->saveReservation();
		break;
	}
	case 'reservationSaved':
	{
		require_once 'controller/reservationC.php';
		$classReservation = new reservationC();
		$classReservation->loadReservationSaved();
		break;
	}
	case '404' :
	{
		require('view/404.php');
		break;
	}
	case '_____' :
	{
		require('controller/_____.php');
		break;
	}	
	default :
	{
		require('controller/accueilC.php');
		break;
	}
}

//Absence volontaire de la balise fermeture php  (préconisation)