<?php
//VUE modification d'un étudiant
//Préparation flux HTML pour le template
ob_start();
// Affichage éventuel message suppression
if (isset($message))
{
	echo "<div class='message'>" . $message . "</div>";
}
?>
<h1>Modifier un étudiant</h1>
<a href='index.php?action=listclaetu&clacod=<?php echo $etu['clacod'] ?>'>Retour à la classe</a><hr/>
<!-- Formulaire affichage de l'étudiant sélectionné -->
<form action="index.php?action=updateetu" method="post">
<table width="400">
<tr><td>N°</td><td><?php echo $etu['etunum'] ?><input type="hidden" name="etunum" value="<?php echo $etu['etunum'] ?>"></td></tr>
<tr><td>Nom</td><td><input type="text" name="etunom" value="<?php echo $etu['etunom'] ?>"></td></tr>
<tr><td>Prénom</td><td><input type="text" name="etupre" value="<?php echo $etu['etupre'] ?>"></td></tr>
<tr><td>Classe</td><td><select name="clacod">
<?php
// Affichage liste déroulante des classes
foreach ($clalist as $row)
{
	//Pré-selection de la classe de l'étudiant
	if ($etu['clacod']==$row['clacod'])
		$sel=" selected='selected' ";
	else
		$sel="";
	echo "<option value='" . $row['clacod'] . "' $sel >" . $row['clalib'] . "</option>";
}
?>
</select></td></tr>
<tr><td></td><td><input type="submit" name="btnmodifier" value="Modifier"></td></tr>
</table>
</form>
<?php
//Ouverture du template
$title = 'Modifier étudiant';
$content = ob_get_clean(); 
require('template.php'); 
?>