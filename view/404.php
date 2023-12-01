<?php
ob_start();

echo $_POST["messageErreur"];

$title = "Balladins - 404";
$content = ob_get_clean();
require('view/template.php');
?>