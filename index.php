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
	case 'listclaetu' :
	{ 
		require('controller/claEtuController.php');
		break;
	}
	case 'listcla' :
	{
		require('controller/claController.php');
		break;
	}
	case 'listetu' :
	{
		require('controller/etuController.php');
		break;
	}
	case 'insertetu' :
	{
		require('controller/insertEtuController.php');
		break;
	}
	case 'updateetu' :
	{
		require('controller/updateEtuController.php');
		break;
	}
	default :
	{
		require('controller/accueilController.php');
		break;
	}
}

//Absence volontaire de la balise fermeture php  (préconisation)