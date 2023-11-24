<div>
    <form id="filtreForm" method="get" action="index.php">
        <input type="hidden" name="action" value="<?php echo $action ?>">

        <!-- Sélectionnez un équipement :
        <select name="equipements[]" id="equipement-select" onchange="this.form.submit()" multiple>
            <option hidden disabled selected value> -- aucun -- </option>
            <?php foreach ($listEquipement as $unequ) { ?>
                <option value='<?php echo $unequ["noequ"] ?>' <?php if (isset($_REQUEST["equipements[]"])) {
                                                                    echo in_array($unequ["noequ"], $_REQUEST["equipements[]"]) ? "selected" : "";
                                                                }; ?>>
                    <?php echo $unequ["lib"] ?></option>
            <?php } ?>
        </select> -->

        <label>
            Sélectionnez un équipement :
            <input mbsc-input id="demo-multiple-select-input" placeholder="Please select..." data-dropdown="true" data-input-style="outline" data-label-style="stacked" data-tags="true" />
        </label>
        <select name="equipements[]" id="demo-multiple-select" multiple>
            <?php foreach ($listEquipement as $unequ) { ?>
                <option value='<?php echo $unequ["noequ"] ?>' <?php if (isset($_REQUEST["equipements[]"])) {
                                                                    echo in_array($unequ["noequ"], $_REQUEST["equipements[]"]) ? "selected" : "";
                                                                }; ?>>
                    <?php echo $unequ["lib"] ?></option>
            <?php } ?>
        </select>
        <script>
            mobiscroll.select('#demo-multiple-select', {
                inputElement: document.getElementById('demo-multiple-select-input')
            });
        </script>

        <input type="hidden" name="action" value="<?php echo $action ?>">

        Indiquez une ville
        <input type="text" name="ville" id="ville-search" value="<?php if (isset($_REQUEST["ville"]) && !empty($_REQUEST["ville"])) {
                                                                        echo $_REQUEST["ville"];
                                                                    } ?>">

        <!-- slider min 0 et max 9999 -->
        <label for="prix">Indiquez un prix</label>
        <input type="range" name="prix" id="prix" min="0" max="300" value="<?php echo isset($_REQUEST["prix"]) && !empty($_REQUEST["prix"]) && $_REQUEST["prix"] <= 300 && $_REQUEST["prix"] >= 0 ?
                                                                                $_REQUEST["prix"] : 300;
                                                                            ?>" oninput="this.form.submit()">
        <output for="prix" id="prix-output">
            <?php if (isset($_REQUEST["prix"]) && !empty($_REQUEST["prix"])) {
                echo $_REQUEST["prix"];
            } ?>
        </output>

        <!-- Variable cachée pour stocker l'ID du dernier élément focus -->
        <input type="hidden" name="dernierFocus" id="dernier-focus">

        <button type="submit">Rechercher</button>
    </form>

    <script>
        // Mettre le focus sur l'élément approprié s'il existe
        document.addEventListener('DOMContentLoaded', function() {
            var dernierFocus = '<?php echo isset($_REQUEST["dernierFocus"]) ? $_REQUEST["dernierFocus"] : "" ?>';
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