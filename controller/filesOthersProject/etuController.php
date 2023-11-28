<?php
// CONTROLEUR de l'affichage d'une classe et des étudiants associés

// Modèles nécessaires
require_once 'model/ClaManager.php';
require_once 'model/EtuManager.php';

// Récupération éventuelle de la classe sélectionnée et des étudiants de cette classe
if (isset($_GET["clacod"]) && $_GET["clacod"]!="")
{
	$modcla = new ClaManager();
	$clalist=$modcla->getCla($_GET["clacod"]);
	$modetu = new EtuManager();
	$etulist=$modetu->getAllEtu($_GET["clacod"]);
}
else
{
	$clalist=array();
	$etulist=array();
}
// Affichage du résultat dans la vue
require_once 'view/listEtuView.php';

//Absence volontaire de la balise fermeture php