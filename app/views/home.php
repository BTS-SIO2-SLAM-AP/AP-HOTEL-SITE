<?php
    $title = "Balladins";
    $data = isset($data) ? $data : [];
    $content = isset($content) ? $content : "";
    $leshotels = DB::query("SELECT nom, prix FROM hotel ORDER BY nom");
?>

<?php require_once "app/views/layouts/navbar.php" ?>
<?php require_once "app/views/layouts/filtre.php" ?>
<div>
    <?php
    

    echo("<br/>Hotels :<br/>");

    Foreach ($leshotels as $unhotel)
    { 
        echo ("$unhotel[nom] - $unhotel[prix]€<br/>");
    }
    ?>
</div>