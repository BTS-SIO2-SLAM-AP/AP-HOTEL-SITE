<?php
if (isset($_POST['page'])) {
	$page = $_POST['page'];
} else {
	$page = "";
}
switch ($page) {
	case 'listhotel': {
			require('controller/accueilC.php');
			break;
		}
	case 'ficheHotel': {
			require('controller/hotelC.php');
			break;
		}
	case 'formReservation': {
			require_once 'controller/reservationC.php';
			$classReservation = new reservationC();
			$classReservation->loadView();
			break;
		}
	case 'saveReservation': {
			require_once 'controller/reservationC.php';
			$classReservation = new reservationC();
			$classReservation->saveReservation();
			break;
		}
	case 'ficheConsulter': {
			require_once 'controller/consultationC.php';
			$classConsultation = new consultationC();
			$classConsultation->loadConsultation();
			break;
		}
	case 'deleteReservation': {
			require_once 'controller/consultationC.php';
			$classConsultation = new consultationC();
			$classConsultation->deleteReservation();
			break;
		}
	case 'getChambreDisponible': {
			require_once 'controller/reservationC.php';
			$classReservation = new reservationC();
			$classReservation->getChambresDisponibles();
			break;
		}
	case '404': {
			require('view/404.php');
			break;
		}
	default: {
			require('controller/accueilC.php');
			break;
		}
}
// }

//Absence volontaire de la balise fermeture php  (préconisation)