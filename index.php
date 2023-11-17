<?php
// ROUTEUR de l'application
// Permet de sélectionner le controleur adapté, en fonction de l'action dans l'URL
if (isset($_GET['action'])) 
{
	$action=$_GET['action'];
}
else
{
	$action="";
}
switch ($action)
{
	case 'listhotel' :
	{ 
		require('controller/hotelController.php');
		break;
	}
	case '_____' :
	{
		require('controller/_____.php');
		break;
	}
	default :
	{
		require('controller/accueilController.php');
		break;
	}
}

//Absence volontaire de la balise fermeture php  (préconisation)