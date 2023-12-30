<?php
ob_start();
?>
<link rel="stylesheet" href="assets/css/ficheConsultation.css">
<div class="fiche-consultation">
    <h1>Consultation de réservation</h1>
    <?php
    if (!isset($_POST["deleted"])) {
        if (!$isConsultation || isset($messageFormErreur)) {
    ?>
            <form method='post' action='index.php'>
                <label for='txtNoRes'> Saisissez votre numéro de réservation :</label></br>
                <input type='number' name='txtNoRes' value='<?php if (isset($_POST["txtNoRes"])) echo $_POST["txtNoRes"]; ?>' required>
                </br></br>
                <label for='txtCodeAcces'> Saisissez votre code d'accès :</label></br>
                <input type='text' name='txtCodeAcces' value='<?php if (isset($_POST["txtCodeAcces"])) echo $_POST["txtCodeAcces"]; ?>' required>
                </br></br>
                <input type='submit' name='consultation' value='Consulter ma réservation'>

                <input type="hidden" name="page" value="ficheConsulter">
            </form>
        <?php
            if (isset($messageFormErreur)) echo "<p style='color: red; font-weight: bold;'>$messageFormErreur</p>";
        } else if (!isset($messageFormErreur)) { ?>
            <table>
                <tr><td class="tdl">Numéro de réservation : </td><td class="tdr"><b><?php echo $noresglobale ?></b></td></tr>
                
                <tr><td class="tdl">Code d'accès : </td><td class="tdr"><b><?php echo $codeacces ?></b></td></tr>
                <td colspan="2" class="tdc"><b>Hôtel <?php echo $nomHotel ?></b></td>
                <tr><td class="tdl">Nom : </td><td class="tdr"><b><?php echo $nomClient ?></b></td></tr>
                <tr><td class="tdl">Email : </td><td class="tdr"><b><?php echo $mailClient ?></b></td></tr>
                <td colspan="2" class="tdc">Réservation du <b><?php echo $dateDebutStr ?></b> au <b><?php echo $dateFinStr ?></b></td>
                <tr><td class="tdl">Chambres réservées : <b><?php echo "N°" . implode(", N°", array_column($chambresRes, 'nochambre')) ?></b></td></tr>
            </table>

            <button onclick="confirmationDelete()">Annuler cette réservation.</button>

            <script>
                function confirmationDelete() {
                    if (confirm("Êtes-vous sûr de vouloir annuler cette réservation ?")) {
                        pageRedirection('deleteReservation', {
                            nores: <?php echo $noresglobale; ?>,
                            codeacces: '<?php echo $codeaccesRes; ?>'
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
</div>
<?php }

    //Ouverture du template
    $title = "Balladins - Consultation réservation";
    $content = ob_get_clean();
    require('view/template.php');
?>