<?php
//VUE une classe avec liste des étudiants
//Préparation flux HTML pour le template
ob_start();
?>
<h1>Liste des étudiants</h1>
<?php
// Affichage éventuel de la classe sélectionnée
if (count($clalist)>0)
{
	$row = $clalist[0];
	echo "Classe : " . $row['clacod'] . "<br/> " . $row['clalib'] . "<br/>";
}
?>
<a href='index.php?action=listcla'>Retour à la liste des classes</a><hr/>
<?php
// Affichage éventuel des étudiants de la classe sélectionnée
if (count($etulist)>0)
{
	echo "<table width='400'>";
	// Parcours liste étudiants
	foreach ($etulist as $row)
	{
		echo "<tr class='alterne'><td width='40%'>". $row['etunom'] . "</td><td width='40%'>" . $row['etupre'] ."</td>" ;
	}
	echo '</table>';
}
else
{
	echo 'Aucun étudiant<br>';
}
?>

<?php
//Ouverture du template
$title = 'Liste des étudiants';
$content = ob_get_clean(); 
require('template.php'); 
?>