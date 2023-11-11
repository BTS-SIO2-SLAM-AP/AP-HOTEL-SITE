<?php
    $title = isset($title) ? $title : "";
    $content = isset($content) ? $content : "";
?>

<!doctype html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible">
    <title><?= $title ?></title>
    <link rel="icon" type="image" href="/assets/media/logo.png" />
    <link rel="stylesheet" href="<?= Asset::get("/assets/css/app.css"); ?>">
</head>
<body>
    <nav>
        <div>
            <img class="nav-brand" src="<?= Asset::get("/assets/media/logo/logo-balladins.svg") ?>" alt="logo"/>
            <a class="nav-link" href="<?= Asset::url("/home") ?>">Accueil</a>
            
            <a class="nav-link" href="<?= Asset::url("/create") ?>">Res Create</a>

            <a class="nav-link" href="<?= Asset::url("/view") ?>">Res View</a>
        </div>
    </nav>
    <div class="main">
        <?= $content ?>
    </div>
</body>
</html>