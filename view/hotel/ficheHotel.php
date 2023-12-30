<?php
//VUE liste des classes avec lien hypertexte
//Préparation flux HTML pour le template
ob_start();
?>
<link rel="stylesheet" href="assets/css/ficheHotel.css">

<div class="fiche-hotel">
    <div class="fiche-hotel-info">
        <h1>Hôtel <?php echo $infoHotel["nom"] ?></h1>
        <table>
            <td style="width: 50%; padding: 20px">
                <p>Adresse : <b><?php echo $infoHotel["cp"] . " " . $infoHotel["ville"] . ", " . $infoHotel["adr1"] ?><?php if (isset($infoHotel["adr2"])) {
                                                                                                                            echo " - " . $infoHotel["adr2"];
                                                                                                                        };   ?></b></p>

                <p>Téléphone : <b><?php echo $infoHotel["tel"] ?></b></p>
                <p class="prix"><?php echo $infoHotel["prix"] ?>€/nuit</p>
                <p class="description"><?php echo $infoHotel["deslong"] ?></p>

                Contient <?php echo count($infoHotel["chambres"]) ?> chambres<br />


                <h3>Equipements</h3>
                <div class="fiche-hotel-equipements">
                    <?php
                    // Parcours liste des equipements
                    foreach ($infoHotel["equipements"] as $unEquipement) { ?>
                        <div class="equipement-item">
                            <img src='assets/media/logo/<?php echo $unEquipement["imgequ"] ?>' title='<?php echo $unEquipement["lib"] ?>'>
                        </div>
                    <?php } ?>
                </div>
            </td>
            <td style="width: 50%;">
                <?php
                // Affichage de la photo de l'hotel si elle existe
                if (isset($infoHotel["photos"][0])) { ?>
                    <img class="photo-item" src='assets/media/photo/<?php echo $infoHotel["photos"][0]["nomfichier"] ?>' title='Photo hôtel <?php echo $infoHotel["nom"] ?>'>
                <?php } ?>
            </td>
        </table>
        <!-- Bouton de redirection vers la page de réservation -->
        <button class="button-reservation" onclick="pageRedirection('formReservation', {nohotel: <?php echo $infoHotel['nohotel'] ?>})">Réserver dans cet hôtel</button>
    </div>
</div>
<?php
//Ouverture du template
$title = "Balladins - Hotel $infoHotel[nom]";
$content = ob_get_clean();
require('view/template.php');
?>