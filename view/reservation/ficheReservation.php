<?php
//VUE liste des classes avec lien hypertexte
//Préparation flux HTML pour le template
ob_start();
?>
<link rel="stylesheet" href="assets/css/ficheReservation.css">
Réserver dans l'hôtel <?php echo $unHotel["nom"] ?>
<br /><br />

<div class="ficheReservation">
    <form method='post' action="index.php">
        <label for="datedebut">Réserver du </label>
        <input type="date" id="datedebut" name="datedebut" value="<?php echo date("Y-m-d"); ?>" min="<?php echo date("Y-m-d"); ?>" onchange="dateDebutChange()" required>

        <label for="datefin"> au </label>
        <input type="date" id="datefin" name="datefin" value="<?php echo date('Y-m-d', strtotime('+1 day')); ?>" min="<?php echo date('Y-m-d', strtotime('+1 day')); ?>" onchange="dateFinChange()" required style="background-color:pink;">



        <br />
        <label for="email">Email :</label>
        <input type="email" name="txtmail" required>

        <br />
        <label for="txtnom">Nom :</label>
        <input type="text" name="txtnom" required>

        <br />
        <label for="chambres">Chambres disponibles :</label>
        <select id="listeChambres" name="chambres[]" multiple required>
            <?php
            foreach ($unHotel["chambres"] as $uneChambre) {
                echo "<option value='$uneChambre[nochambre]'>N°$uneChambre[nochambre]</option>";
            }
            ?>
        </select>
        <br /><br />
        <input type='submit' name='btnvalider' value='valider'>

        <input type='hidden' name='nohotel' value='<?php echo $unHotel["nohotel"] ?>'>
        <input type='hidden' name='page' value='saveReservation'>
        <input type='hidden' name='titre' value='<?php echo urlencode($unHotel["nom"]) ?>'>
    </form>

    <script>
        function dateDebutChange() {
            var datedebut = new Date(document.getElementById('datedebut').value);
            var datefin = new Date(document.getElementById('datefin').value);
            var datemin = new Date(document.getElementById('datedebut').min);

            if (datedebut < datemin) {
                document.getElementById('datedebut').value = document.getElementById('datedebut').min;
            }

            // Si la date de début est supérieure à la date de fin, ajuster la date de fin
            if (datedebut >= datefin) {
                document.getElementById('datefin').value = formatDate(new Date(datedebut.getFullYear(), datedebut.getMonth(), datedebut.getDate() + 1));
            }
            updateChambres();
        }

        function dateFinChange() {
            var datedebut = new Date(document.getElementById('datedebut').value);
            var datefin = new Date(document.getElementById('datefin').value);
            var datemin = new Date(document.getElementById('datefin').min);

            if (datefin <= datemin) {
                document.getElementById('datefin').value = document.getElementById('datefin').min;
            }

            // Si la date de fin est inférieure à la date de début, ajuster la date de début
            if (datefin <= datedebut && datefin >= datemin) {
                document.getElementById('datedebut').value = formatDate(new Date(datefin.getFullYear(), datefin.getMonth(), datefin.getDate() - 1));
            }
            updateChambres();
        }

        function formatDate(date) {
            var year = date.getFullYear();
            var month = ('0' + (date.getMonth() + 1)).slice(-2);
            var day = ('0' + date.getDate()).slice(-2);
            return year + '-' + month + '-' + day;
        }

        // // Update liste des chambres disponibles en fonction des dates sélectionnées
        // function updateChambres() {
        //     var datedebut = new Date(document.getElementById('datedebut').value);
        //     var datefin = new Date(document.getElementById('datefin').value);

        //     var chambresSelector = document.getElementById('listeChambres');

        //     var lesChambres = <?php echo json_encode($lesChambres); ?>;

        //     // On parcourt les chambres
        //     for (var i = 0; i < lesChambres.length; i++) {
        //         var chambre = lesChambres[i];
        //         var chambreDisponible = true; // Drapeau pour indiquer si la chambre est disponible

        //         // On parcourt les réservations de la chambre
        //         for (var j = 0; j < chambre.reservations.length; j++) {
        //             var reservation = chambre.reservations[j];

        //             // On vérifie si la réservation est dans l'intervalle de dates sélectionnées
        //             if (reservation.datedebut <= datefin && reservation.datefin >= datedebut) {
        //                 // La chambre est réservée, on met à jour le drapeau
        //                 chambreDisponible = false;
        //                 break;
        //             }
        //         }

        //         // On met à jour la visibilité de l'option en fonction du drapeau
        //         chambresSelector.options[i].hidden = !chambreDisponible;
        //     }
        // }

        // // Update liste des chambres disponibles en fonction des dates sélectionnées
        // function updateChambres() {
        //     var datedebutValue = document.getElementById('datedebut').value;
        //     var datefinValue = document.getElementById('datefin').value;
        //     var chambresSelector = document.getElementById('listeChambres');

        //     // Vérifier si les dates sont valides
        //     if (!datedebutValue || !datefinValue) {
        //         // Gérer le cas où une ou les deux dates ne sont pas sélectionnées
        //         return;
        //     }

        //     // Créer une instance XMLHttpRequest
        //     var xhr = new XMLHttpRequest();

        //     // Spécifier le type de requête, l'URL et si la requête doit être asynchrone
        //     xhr.open('POST', 'votre_script_php.php', true);

        //     // Définir le type de données à envoyer au serveur
        //     xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');

        //     // Gérer l'événement de changement d'état de la requête
        //     xhr.onreadystatechange = function() {
        //         // Vérifier si la requête est terminée et la réponse est prête
        //         if (xhr.readyState === 4 && xhr.status === 200) {
        //             // Parsez la réponse JSON
        //             var lesChambres = JSON.parse(xhr.responseText);

        //             // Effacer les options actuelles du sélecteur de chambres
        //             chambresSelector.innerHTML = '';

        //             // Ajouter les nouvelles options en fonction des chambres disponibles
        //             for (var i = 0; i < lesChambres.length; i++) {
        //                 var option = document.createElement('option');
        //                 option.value = lesChambres[i].nochambre;
        //                 option.text = 'Chambre ' + lesChambres[i].nochambre;
        //                 chambresSelector.add(option);
        //             }
        //         }
        //     };

        //     // Envoyer la requête avec les dates en tant que données
        //     var data = 'datedebut=' + encodeURIComponent(datedebutValue) + '&datefin=' + encodeURIComponent(datefinValue);
        //     xhr.send(data);
        // }
    </script>
</div>
<?php
//Ouverture du template
$title = "Balladins - Réservation hôtel $unHotel[nom]";
$content = ob_get_clean();
require('view/template.php');
?>