<?php
// CONTROLEUR de l'affichage de la liste des classes 

// Mod�les n�cessaires
require_once 'model/ClaManager.php';

// R�cup�ration de la liste des classes pour affichage liste
$modcla = new ClaManager();
$clalist=$modcla->getAllCla();

// Affichage du r�sultat dans la vue
require_once 'view/listClaView.php';

//Absence de la balise fermeture php volontaire