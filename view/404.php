<?php
ob_start();

if(isset($_POST["messageErreur"])) {
    echo $_POST["messageErreur"];
}
else header('Location: index.php');

$title = "Balladins - 404";
$content = ob_get_clean();
require('view/template.php');
?>