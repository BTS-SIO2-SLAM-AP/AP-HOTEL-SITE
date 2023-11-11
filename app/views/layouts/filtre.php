<?php
    require_once("app/utils/DB.php");
    $lesequ = DB::query("SELECT noequ, lib FROM equipement ORDER BY noequ");
?>

<div>
    <label for="equipement-select">Sélecctionnez un équipement :</label>

    <select name="equipements" id="equipement-select">
        <?php
        Foreach ($lesequ as $unequ)
        { 
            echo ("<option value='$unequ[noequ]'>$unequ[lib]</option>");
        }
        ?>
    </select>
    
</div>