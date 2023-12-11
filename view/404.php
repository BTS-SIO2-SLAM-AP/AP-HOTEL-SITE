<?php
ob_start();

if(isset($_POST["messageErreur"])) {
    echo $_POST["messageErreur"];
}
else header('Location: index.php');

// retourner à la page d'accueil
echo "<br /><br /><a href='index.php'>Retourner à l'accueil</a>";

$title = "Balladins - 404";
$content = ob_get_clean();
require('view/template.php');
?>