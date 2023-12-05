<?php
//VUE liste des classes avec lien hypertexte
//Préparation flux HTML pour le template
ob_start();

echo "Réserver dans l'hôtel " . $unHotel["nom"];
?>
<form method='post' action="index.php">
    <label for="datedebut">Sélectionnez une date de début :</label>
    <input type="date" id="datedebut" name="datedebut" value="<?php echo date("Y-m-d"); ?>" min="<?php echo date("Y-m-d"); ?>" onchange="dateDebutChange()" required>

    <label for="datefin">Sélectionnez une date de fin :</label>
    <input type="date" id="datefin" name="datefin" value="<?php echo date('Y-m-d', strtotime('+1 day')); ?>" min="<?php echo date('Y-m-d', strtotime('+1 day')); ?>" onchange="dateFinChange()" required style="background-color:pink;">

    <script>
        function dateDebutChange() {
            var datedebut = new Date(document.getElementById('datedebut').value);
            var datefin = new Date(document.getElementById('datefin').value);
            var datemin = new Date(document.getElementById('datedebut').min);

            if (datedebut < datemin) {
                document.getElementById('datedebut').value = document.getElementById('datedebut').min;
            }

            // Si la date de début est supérieure à la date de fin, ajuster la date de fin
            if (datedebut >= datefin) {
                document.getElementById('datefin').value = formatDate(new Date(datedebut.getFullYear(), datedebut.getMonth(), datedebut.getDate() + 1));
            }
        }

        function dateFinChange() {
            var datedebut = new Date(document.getElementById('datedebut').value);
            var datefin = new Date(document.getElementById('datefin').value);
            var datemin = new Date(document.getElementById('datefin').min);

            if (datefin < datemin) {
                document.getElementById('datefin').value = formatDate(new Date(datemin.getFullYear(), datemin.getMonth(), datemin.getDate() + 1));
            }

            // Si la date de fin est inférieure à la date de début, ajuster la date de début
            if (datefin <= datedebut) {
                document.getElementById('datedebut').value = formatDate(new Date(datefin.getFullYear(), datefin.getMonth(), datefin.getDate() - 1));
            }
        }

        function formatDate(date) {
            var year = date.getFullYear();
            var month = ('0' + (date.getMonth() + 1)).slice(-2);
            var day = ('0' + date.getDate()).slice(-2);
            return year + '-' + month + '-' + day;
        }
    </script>

    <label for="email">Email :</label>
    <input type="email" name="txtmail" required>

    <label for="txtnom">Nom :</label>
    <input type="text" name="txtnom" required>

    <label for="chambres">Chambres disponibles :</label>
    <select name="chambres[]" multiple required>
        <?php
        foreach ($unHotel["chambres"] as $uneChambre) {
            echo "<option value='$uneChambre[nochambre]'>N°$uneChambre[nochambre]</option>";
        }
        ?>
    </select>

    <input type='submit' name='btnvalider' value='valider'>

    <input type='hidden' name='nohotel' value='<?php echo $unHotel["nohotel"] ?>'>
    <input type='hidden' name='page' value='saveReservation'>
    <input type='hidden' name='titre' value='<?php echo urlencode($unHotel["nom"]) ?>'>
</form>
<?php
//Ouverture du template
$title = "Balladins - Réservation hôtel $unHotel[nom]";
$content = ob_get_clean();
require('view/template.php');
?>