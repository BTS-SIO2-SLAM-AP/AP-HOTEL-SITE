<?php
//VUE liste des classes avec lien hypertexte
//Préparation flux HTML pour le template
ob_start();
include 'view/layouts/filtre.php';
?>
<div class="list-hotels">
	<?php
	// Parcours liste des hotels
	foreach ($listHotel as $unHotel) {
		$noHotel = $unHotel["nohotel"];
	?>
		<div class='hotel-item' onclick="pageRedirection('ficheHotel', {nohotel: <?php echo $unHotel['nohotel'] ?>})" style='cursor: pointer' data-equipements="<?php echo implode(",", array_column($unHotel["equipements"], "noequ")); ?>" data-ville="<?php echo $unHotel["ville"] ?>" data-prix="<?php echo $unHotel["prix"] ?>" data-nom="<?php echo $unHotel["nom"] ?>">
			<div class="hotel-item-content">
				<?php echo "<h1>$unHotel[nom]</h1>"; ?>

				<div class="photo-container">
					<img src='assets/media/photo/<?php echo $unHotel["photos"][0]["nomfichier"] ?>' title='Hôtel <?php echo $unHotel["nom"] ?>'>
				</div>
				<p><?php echo "$unHotel[adr1]"; ?>
					<?php if (isset($unHotel["adr2"])) {
						echo " - " . $unHotel["adr2"];
					}; ?></p>
				<?php echo $unHotel["tel"] ?><br />
				<div class="prix"><?php echo $unHotel["prix"] ?>€/nuit</div>
				<div class="equipements-container">
					<?php
					// Parcours liste des equipements
					foreach ($unHotel["equipements"] as $unEquipement) { ?>
						<div class="equipement-item">
							<img src='assets/media/logo/<?php echo $unEquipement["imgequ"] ?>' title='<?php echo $unEquipement["lib"] ?>'>
						</div>
					<?php } ?>
				</div>
			</div>
		</div>
	<?php } ?>
</div>




<?php
//Ouverture du template
$title = 'Balladins - Accueil';
$content = ob_get_clean();
$filtre = true;
require('view/template.php');
?>