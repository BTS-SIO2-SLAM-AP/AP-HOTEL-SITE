<?php
//VUE Liste déroulante des classes et liste des étudiants
//Préparation flux HTML pour le template
ob_start();
// Affichage éventuel message suppression
if (isset($message))
{
	echo "<div class='message'>" . $message . "</div>";
}
?>
<h1>Liste des étudiants</h1>
<!-- Formulaire sélection d'une classe -->
<form action="index.php?action=listclaetu" method="post">
Classe <select name="clacod" onchange="form.submit()">
<option value=''></option>
<?php
// Affichage liste déroulante des classes
foreach ($clalist as $row)
{
	//Pré-selection de la classe
	if (isset($_REQUEST['clacod']) && $_REQUEST['clacod']==$row['clacod'])
		$sel=" selected='selected' ";
	else
		$sel="";
	echo "<option value='" . $row['clacod'] . "' $sel >" . $row['clalib'] . "</option>";
}
?>
</select>
<input type="submit" name="btnvalider" value="Afficher">
</form>
<hr/>
<?php
// Affichage éventuel liste des étudiants de la classe sélectionnée
if (count($etulist)>0)
{
	echo "<table width='400'>";
	// Parcours liste étudiants
	foreach ($etulist as $row)
	{
		echo "<tr class='alterne'><td width='40%'>". $row['etunom'] . "</td><td width='40%'>" . $row['etupre'] ."</td>" ;
		// Affichage icône modifier l'étudiant
		echo "<td width='10%'> &nbsp; <a href='index.php?action=updateetu&clacod=".$_REQUEST['clacod']."&modif=ok&etunum=" . $row['etunum'] . "'> <img src='style/modif.png' title='Modifier' /></a></td>";
		// Affichage icône supprimer l'étudiant
		echo "<td width='10%'> &nbsp; <a href='index.php?action=listclaetu&clacod=".$_REQUEST['clacod']."&suppr=ok&etunum=" . $row['etunum'] . "'> <img src='style/suppr.png' title='Supprimer' /></a></td></tr>";
	}
	echo '</table>';
}
else
{
	echo 'Aucun étudiant<br>';
}
// Affichage icône ajouter étudiant
if (isset($_REQUEST['clacod']))
	$classe="&clacod=".$_REQUEST['clacod'];
else
	$classe="";
echo "<a href='index.php?action=insertetu" . $classe . "'> <img src='style/ajout.png' title='Ajouter' /></a>";

?>
<?php
//Ouverture du template
$title = 'Liste des étudiants';
$content = ob_get_clean(); 
require('template.php'); 
?>