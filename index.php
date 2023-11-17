<?php
// ROUTEUR de l'application
// Permet de sélectionner le controleur adapté, en fonction de l'action dans l'URL
if (isset($_POST['action'])) 
{
	$action=$_POST['action'];
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
		require('controller/hotelController.php');
		break;
	}
}

//Absence volontaire de la balise fermeture php  (préconisation)