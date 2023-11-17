<?php
//VUE liste des classes avec lien hypertexte
//Préparation flux HTML pour le template
ob_start();
?>

<h1>Liste des hôtels (<?php echo $nbHotel ?> hôtel trouvé)</h1>
<hr />
<?php
// echo $listHotel[1]["equipements"][1]["lib"];
echo "<br/><br/>";
// Parcours liste des classes 
foreach ($listHotel as $unHotel)
{
	// Avec affichage lien hypertexte
	echo "<b>$unHotel[nom]</b> > $unHotel[prix] € - $unHotel[adr1]<br/>";
	
	echo "Les équipements : ";
	foreach ($unHotel["equipements"] as $unEquipement)
	{
		echo "$unEquipement[lib], ";
	}
	echo "<br/>";

	echo "Nombre de chambres : ".count($unHotel["chambres"]);
	echo "<br/>";
	echo "<br/>";
}
?>
<?php
//Ouverture du template
$title = 'Liste des hôtels';
$content = ob_get_clean(); 
$filtre = true;
require('view/template.php'); 
?>