<?php
ob_start();

if (!isset($_POST["deleted"])) {
    if (!$isConsultation || isset($messageFormErreur)) {
?>
        <form method='post' action='index.php'>
            <label for='txtNoRes'> Rentrez votre numéro de réservation :</label></br>
            <input type='number' name='txtNoRes' value='<?php if (isset($_POST["txtNoRes"])) echo $_POST["txtNoRes"]; ?>' required>
            </br></br>
            <label for='txtCodeAcces'> Rentrez votre code d'accès :</label></br>
            <input type='text' name='txtCodeAcces' value='<?php if (isset($_POST["txtCodeAcces"])) echo $_POST["txtCodeAcces"]; ?>' required>
            </br></br>
            <input type='submit' name='consultation' value='Consulter ma réservation'>

            <input type="hidden" name="page" value="ficheConsulter">
        </form>
    <?php
        if (isset($messageFormErreur)) echo "<p>$messageFormErreur</p>";
    } else if (!isset($messageFormErreur)) { ?>
        <p>
            Informations réservation :<br />
            Numéro de réservation : <?php echo $noresglobale ?><br />
            Code d'accès : <?php echo $codeacces ?><br />
            Hôtel <?php echo $nomHotel ?><br />
            Nom : <?php echo $nomClient ?><br />
            Email : <?php echo $mailClient ?><br />
            Réservation du <?php echo $dateDebutStr ?> au <?php echo $dateFinStr ?> <br />
            Chambres réservées : <br />
            <?php echo "N°" . implode(", N°", array_column($chambresRes, 'nochambre')) ?>
        </p>

        <button onclick="confirmationDelete()">Supprimer cette réservation.</button>

        <script>
            function confirmationDelete() {
                if (confirm("Êtes-vous sûr de vouloir supprimer cette réservation ?")) {
                    pageRedirection('deleteReservation', {
                        nores: <?php echo $noresglobale; ?>,
                        codeacces: <?php echo $codeaccesRes; ?>
                    });
                }
            }
        </script>
    <?php
    }
} else { ?>
    <p>Votre réservation a bien été supprimée.</p>
    <p>Vous allez être redirigé vers la page d'accueil...</p>
    <META http-equiv="refresh" content="3; URL=index.php">
<?php }

//Ouverture du template
$title = "Balladins - Consultation réservation";
$content = ob_get_clean();
require('view/template.php');
?>