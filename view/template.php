<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8" />
        <title><?php echo $title ?></title>
        <link href="assets/css/main.css" rel="stylesheet" /> 
        <link href="assets/css//mobiscroll.javascript.min.css" rel="stylesheet" />
        <script src="assets/js/mobiscroll.javascript.min.js"></script>

        <link rel="icon" type="image/png" href="assets/media/logo/balladins-logo-min.svg" />
    </head>
    <body>
		<header>
      <img src="assets/media/logo/logo-balladins.svg" style="height: 50px;" alt="logo" class="logo"/>
      <!-- image svg -->

      
			<a href="index.php" class="menu">Accueil</a>
			<!-- <a href="index.php?action=listhotel" class="menu">Liste Hôtel</a> -->
			<hr/>
		</header>
		<?php echo $content ?>
    <script src="assets/js/gestion404.js"></script>
    </body>
</html>