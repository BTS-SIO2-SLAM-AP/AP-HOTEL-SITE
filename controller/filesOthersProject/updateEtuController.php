<?php
// CONTROLEUR de la modification d'un étudiant

// Modèles nécessaires
require_once 'model/ClaManager.php';
require_once 'model/EtuManager.php';

// Sauvegarde éventuelle de la modification d'un étudiant
$modetu = new EtuManager();
if (isset($_POST["btnmodifier"]))
{
	$res = $modetu->updateEtu($_POST["etunum"],$_POST["etunom"],$_POST["etupre"],$_POST["clacod"]);
	if ($res)
	{
		$message="Modification effectuée";
	}
	else
	{
		$message="Impossible de modifier l'étudiant";
	}
}

// Récupération de la liste des classes pour affichage liste
$modcla = new ClaManager();
$clalist=$modcla->getAllCla();
// Récupération de l'étudiant à modifier pour affichage
$etu=$modetu->getEtu($_REQUEST["etunum"]);

// Affichage du résultat dans la vue
require_once 'view/updateEtuView.php';

//Absence volontaire de la balise fermeture php