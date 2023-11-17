<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8" />
        <title><?php echo $title ?></title>
        <link href="style/style.css" rel="stylesheet" /> 
    </head>
    <body>
		<header>
      <img src="assets/media/logo/logo-balladins.png" alt="logo" class="logo"/>
			<span class="libsite">Balladins</span>
			<a href="index.php" class="menu">Accueil</a>
			<a href="index.php?action=listhotel" class="menu">Liste Hôtel</a>
			<hr/>
		</header>
		<?php echo $content ?>
    </body>
</html>