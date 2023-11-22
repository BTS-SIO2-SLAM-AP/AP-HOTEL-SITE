<div>
    <form method="post" action="index.php">
        <input type="hidden" name="action" value="<?php echo $action ?>">
        Sélectionnez un équipement :
        <select name="equipements" id="equipement-select" onchange="this.form.submit()">
            <option hidden disabled selected value> -- aucun -- </option>
            <?php Foreach ($listEquipement as $unequ) { ?>
            <option value='<?php echo $unequ["noequ"]?>'
                <?php echo isset($_POST["equipements"]) && $_POST["equipements"] == $unequ["noequ"] ? "selected" : ""; ?>>
                <?php echo $unequ["lib"] ?></option>
            <?php } ?>
        </select>

        <input type="hidden" name="action" value="<?php echo $action ?>">
        Indiquez une ville
        <input type="text" name="ville" id="ville-search" value="<?php if(isset($_POST["ville"]) && !empty($_POST["ville"])) {echo $_POST["ville"];} {} ?>" onchange="this.form.submit()">

    </form>
    <form method="post" action="index.php">
        <input type="hidden" name="action" value="<?php echo $action ?>">
        <button type="submit">Reset Filtre</button>
    </form>
</div>