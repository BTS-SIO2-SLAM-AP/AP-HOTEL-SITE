<?php
//VUE liste des classes avec lien hypertexte
//Préparation flux HTML pour le template
ob_start();
?>
<h1>Liste des classes</h1><hr/>
<?php
// Parcours liste des classes 
foreach ($clalist as $row)
{
	// Avec affichage lien hypertexte
	echo "<a href='index.php?action=listetu&clacod=" . $row['clacod'] . "' >" . $row['clalib'] . "</a><br/>";
}
?>
<?php
//Ouverture du template
$title = 'Liste des classes';
$content = ob_get_clean(); 
require('template.php'); 
?>