<div>
    <form id="filtreForm" method="post" action="index.php">
        <input type="hidden" name="action" value="<?php echo $action ?>">

        Sélectionnez un équipement :
        <select name="equipements" id="equipement-select" onchange="this.form.submit()">
            <option hidden disabled selected value> -- aucun -- </option>
            <?php foreach ($listEquipement as $unequ) { ?>
                <option value='<?php echo $unequ["noequ"] ?>' <?php echo isset($_POST["equipements"]) && $_POST["equipements"] == $unequ["noequ"] ? "selected" : ""; ?>>
                    <?php echo $unequ["lib"] ?></option>
            <?php } ?>
        </select>

        <input type="hidden" name="action" value="<?php echo $action ?>">

        Indiquez une ville
        <input type="text" name="ville" id="ville-search" value="<?php if (isset($_POST["ville"]) && !empty($_POST["ville"])) {
                                                                        echo $_POST["ville"];
                                                                    } ?>" oninput="this.form.submit()">

        <!-- Variable cachée pour stocker l'ID du dernier élément focus -->
        <input type="hidden" name="dernierFocus" id="dernier-focus">
    </form>

    <script>
        // Mettre le focus sur l'élément approprié s'il existe
        document.addEventListener('DOMContentLoaded', function() {
            var dernierFocus = '<?php echo isset($_POST["dernierFocus"]) ? $_POST["dernierFocus"] : "" ?>';
            if (dernierFocus) {
                document.getElementById(dernierFocus).focus();
                positionnerCurseurALaFin(document.getElementById(dernierFocus));
            }
        });

        // Ajouter un écouteur à chaque champ d'entrée pour enregistrer l'ID de l'élément qui a le focus
        document.querySelectorAll('input').forEach(function(input) {
            input.addEventListener('focus', function() {
                document.getElementById('dernier-focus').value = this.id;
                positionnerCurseurALaFin(this);
            });
        });

        // Fonction pour positionner le curseur à la fin du texte dans un champ de saisie
        function positionnerCurseurALaFin(element) {
            var longueurTexte = element.value.length;
            element.setSelectionRange(longueurTexte, longueurTexte);
        }
    </script>

    <form method="post" action="index.php">
        <input type="hidden" name="action" value="<?php echo $action ?>">
        <button type="submit">Reset Filtre</button>
    </form>
</div>