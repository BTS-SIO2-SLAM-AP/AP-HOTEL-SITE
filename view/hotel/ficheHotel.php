<?php
//VUE liste des classes avec lien hypertexte
//Préparation flux HTML pour le template
ob_start();
?>
<!-- photo de l'hotel -->
<div class="fiche-hotel">
    <div class="fiche-hotel-info">
        <h1><?php echo $infoHotel["nom"] ?></h1>

        <div class="fiche-hotel-photo">
            <?php
            // Parcours liste des photos
            foreach ($infoHotel["photos"] as $unePhoto) { ?>
                <div class="photo-item">
                    <img src='assets/media/photo/<?php echo $unePhoto["nomfichier"] ?>' title='Photo hôtel <?php echo $infoHotel["nom"] ?>'>
                </div>
            <?php } ?>
        </div>

        <?php echo $infoHotel["ville"] ?><br />
        <?php echo $infoHotel["adr1"] ?>
        <?php if (isset($infoHotel["adr2"])) {
            echo " - " . $infoHotel["adr2"];
        }; ?><br />

        <?php echo $infoHotel["tel"] ?><br />
        <?php echo $infoHotel["prix"] ?>€/nuit<br /><br />
        <?php echo $infoHotel["deslong"] ?><br /><br />

        <?php /*echo $infoHotel["nbchambresdispo"] */?> chambres disponibles / <?php echo count($infoHotel["chambres"]) ?>
        <br />


    </div>
    <div class="fiche-hotel-equipements">
        <h1>Equipements</h1>
        <?php
        // Parcours liste des equipements
        foreach ($infoHotel["equipements"] as $unEquipement) { ?>
            <div class="equipement-item">
                <img src='assets/media/logo/<?php echo $unEquipement["imgequ"] ?>' title='<?php echo $unEquipement["lib"] ?>'>
            </div>
        <?php } ?>
    </div>
</div>

<div class="button-reservation">
    <form action="index.php" method="post">
        <button onclick="this.submit()">Réserver dans cette hôtel</button>
        <input type="hidden" name="page" value="ficheReservation">
        <input type="hidden" name="nohotel" value="<?php echo $infoHotel["nohotel"] ?>">
    </form>
</div>
<?php
//Ouverture du template
$title = "Balladins - Hotel $infoHotel[nom]";
$content = ob_get_clean();
require('view/template.php');
?>