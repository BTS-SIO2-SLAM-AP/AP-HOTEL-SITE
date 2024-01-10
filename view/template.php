<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8" />
        <title><?php echo $title ?></title>

        <link href="assets/css/main.css" rel="stylesheet" /> 
        <link href="assets/css//mobiscroll.javascript.min.css" rel="stylesheet" />

        <script src="assets/js/mobiscroll.javascript.min.js"></script>
        <script src='assets/js/pageManager.js'></script>

        <link rel="icon" type="image/png" href="assets/media/logo/balladins-logo-min.svg" />
    </head>
    <body>
      <?php include 'view/layouts/navbar.php'; ?>
		  <?php echo $content ?>
    </body>
</html>