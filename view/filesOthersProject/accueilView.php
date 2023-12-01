<?php
//VUE d'affichage accueil
//Préparation flux HTML pour le template
ob_start();
?>
<h1>Application de gestion des BTS</h1>
<img src="style/etudiants.jpg" width="300" />
<?php
//Ouverture du template
$title = 'Gestion des BTS';
$content = ob_get_clean(); 
require('template.php'); 
?>