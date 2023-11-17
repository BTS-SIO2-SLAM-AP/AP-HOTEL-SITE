<?php
//VUE liste des classes avec lien hypertexte
//Préparation flux HTML pour le template
ob_start();
?>
<h1>Liste des hôtels</h1>
<hr />
<?php
// Parcours liste des classes 
foreach ($hotelList as $row)
{
	// Avec affichage lien hypertexte
	echo "$row[nom] > $row[prix] € - $row[adr1]<br/>";
	
	
	foreach ($row["equipements"] as $equip)
{
	echo $equip;
}
}
?>
<?php
//Ouverture du template
$title = 'Liste des hôtels';
$content = ob_get_clean(); 
require('view/template.php'); 
?>