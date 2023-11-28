<?php
// CONTROLEUR de l'affichage de la liste des classes 

// Modèles nécessaires
require_once 'model/ClaManager.php';

// Récupération de la liste des classes pour affichage liste
$modcla = new ClaManager();
$clalist=$modcla->getAllCla();

// Affichage du résultat dans la vue
require_once 'view/listClaView.php';

//Absence de la balise fermeture php volontaire