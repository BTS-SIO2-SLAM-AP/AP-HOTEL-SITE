<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8" />
        <title><?php echo $title ?></title>
        <link href="assets/css/main.css" rel="stylesheet" /> 
        <link href="assets/css//mobiscroll.javascript.min.css" rel="stylesheet" />
        <script src="assets/js/mobiscroll.javascript.min.js"></script>
    </head>
    <body>
		<header>
      <img src="assets/media/logo/logo-balladins.png" alt="logo" class="logo"/>
			<a href="index.php" class="menu">Accueil</a>
			<a href="index.php?action=listhotel" class="menu">Liste Hôtel</a>
			<hr/>
		</header>
    <?php if(isset($filtre)) include 'view/layouts/filtre.php';  ?>
		<?php echo $content ?>
    </body>
</html>