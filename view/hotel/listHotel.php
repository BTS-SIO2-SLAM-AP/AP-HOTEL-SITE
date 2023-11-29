<?php
//VUE liste des classes avec lien hypertexte
//Préparation flux HTML pour le template
ob_start();
include 'view/layouts/filtre.php';
?>

<h1>Liste des hôtels (<?php echo $nbHotel ?> hôtel trouvé)</h1>

<div class="list-hotels">
	<?php
	// Parcours liste des hotels
	foreach ($listHotel as $unHotel) { 
		$noHotel = $unHotel["nohotel"];
		?>
		<div class='hotel-item' onclick="document.getElementById('form_<?php echo $noHotel?>').submit()" style='cursor: pointer' data-equipements="<?php echo implode(",", array_column($unHotel["equipements"], "noequ")); ?>" data-ville="<?php echo $unHotel["ville"] ?>" data-prix="<?php echo $unHotel["prix"] ?>" data-nom="<?php echo $unHotel["nom"] ?>">
			<?php
			echo "<h1>$unHotel[nom]</h1>";
			echo "$unHotel[adr1]";
			if (isset($unHotel["adr2"])) {
				echo " - " . $unHotel["adr2"];
			};
			echo "<br/>";
			echo "$unHotel[tel]<br/>";
			echo "$unHotel[prix]€/nuit<br/>";?>

			Les équipements : <br/>
			<div class="equipements-container">
				
				<?php
				// Parcours liste des equipements
				foreach ($unHotel["equipements"] as $unEquipement) { ?>
					<div class="equipement-item">
						<img src='assets/media/logo/<?php echo $unEquipement["imgequ"] ?>' title='<?php echo $unEquipement["lib"] ?>'>
					</div>
				<?php } ?>
			</div>
			
			<form id='form_<?php echo $unHotel["nohotel"] ?>' method='post' action="index.php">
				<input type='hidden' name='nohotel' value='<?php echo $unHotel["nohotel"] ?>'>
				<input type='hidden' name='action' value='ficheHotel'>
				<input type='hidden' name='titre' value='<?php echo urlencode($unHotel["nom"]) ?>'>
			</form>
		</div>
	<?php } ?>
</div>




<?php
//Ouverture du template
$title = 'Accueil';
$content = ob_get_clean();
$filtre = true;
require('view/template.php');
?>