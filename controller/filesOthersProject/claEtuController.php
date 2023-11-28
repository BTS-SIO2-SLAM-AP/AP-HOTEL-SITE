<?php
// CONTROLEUR de l'affichage de la liste des classes 
// avec Gestion (modifier/supprimer) des étudiants 

// Modèles nécessaires
require_once 'model/ClaManager.php';
require_once 'model/EtuManager.php';

// Sauvegarde éventuelle de la suppression d'un étudiant
$modetu = new EtuManager();
if (isset($_GET["suppr"]) && isset($_GET["etunum"]))
{
	$res = $modetu->deleteEtu($_GET["etunum"]);
	if ($res)
	{
		$message="Suppression effectuée";
	}
	else
	{
		$message="Impossible de supprimer l'étudiant";
	}
}

// Récupération de la liste des classes pour affichage liste
$modcla = new ClaManager();
$clalist=$modcla->getAllCla();
// Récupération éventuelle de la liste des étudiants de la classe sélectionnée
if (isset($_REQUEST["clacod"]) && $_REQUEST["clacod"]!="")
{
	$etulist=$modetu->getAllEtu($_REQUEST["clacod"]);
}
else
{
	$etulist=array();
}
// Affichage du résultat dans la vue
require_once 'view/listClaEtuView.php';

//Absence volontaire de la balise fermeture php