<?php
//VUE ajout d'un étudiant
//Préparation flux HTML pour le template
ob_start();
// Affichage éventuel message ajout
if (isset($message))
{
	echo "<div class='message'>" . $message . "</div>";
}
?>
<h1>Ajouter un nouvel étudiant</h1>
<!-- Formulaire de saisie de l'étudiant -->
<form action="index.php?action=insertetu" method="post">
<table width="400">
<tr><td>Nom</td><td><input type="text" name="txtnom"></td></tr>
<tr><td>Prénom</td><td><input type="text" name="txtprenom"></td></tr>
<tr><td>Classe</td><td><select name="clacod">
<?php
// Affichage liste déroulante des classes
foreach ($clalist as $row)
{
	//Pré-selection éventuelle d'une classe
	if (isset($_REQUEST['clacod']) && $_REQUEST['clacod']==$row['clacod'])
		$sel=" selected='selected' ";
	else
		$sel="";
	echo "<option value='" . $row['clacod'] . "' $sel >" . $row['clalib'] . "</option>";
}
?>
</select></td></tr>
<tr><td></td><td><input type="submit" name="btnajouter" value="Ajouter"></td></tr>
</table>
</form>
<?php
//Ouverture du template
$title = 'Ajout étudiant';
$content = ob_get_clean(); 
require('template.php'); 
?>