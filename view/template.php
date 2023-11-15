<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8" />
        <title><?php echo $title ?></title>
        <link href="style/style.css" rel="stylesheet" /> 
    </head>
    <body>
		<header>
			<span class="libsite">Gestion des BTS </span>
			<a href="index.php" class="menu">Accueil</a>
			<a href="index.php?action=listcla" class="menu">Liste Classes</a>
			<a href="index.php?action=listclaetu" class="menu">Liste Etudiants</a> 
			<a href="index.php?action=insertetu" class="menu">Ajouter Etudiant</a>
			<hr/>
		</header>
		<?php echo $content ?>
    </body>
</html>