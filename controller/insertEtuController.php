<?php
// CONTROLEUR de l'ajout d'un étudiant

// Modèles nécessaires
require_once 'model/ClaManager.php';
require_once 'model/EtuManager.php';

// Sauvegarde éventuelle de l'ajout d'un étudiant
$modetu = new EtuManager();
if (isset($_POST["btnajouter"]))
{
	$res = $modetu->insertEtu($_POST["txtnom"],$_POST["txtprenom"],$_POST["clacod"]);
	if ($res)
	{
		$message="Ajout effectué";
	}
	else
	{
		$message="Impossible d'ajouter l'étudiant";
	}
}

// Récupération de la liste des classes pour affichage liste
$modcla = new ClaManager();
$clalist=$modcla->getAllCla();

// Affichage du résultat dans la vue
require_once 'view/insertEtuView.php';

//Absence volontaire de la balise fermeture php