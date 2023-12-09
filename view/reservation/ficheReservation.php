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
        <p id="aucuneChambreDispo" hidden>Aucune chambre disponible pour ces dates</p>
        <select id="listeChambres" name="chambres[]" multiple required>
            <?php
            foreach ($unHotel["chambres"] as $uneChambre) {
                echo "<option value='$uneChambre[nochambre]'>N°$uneChambre[nochambre]</option>";
            }
            ?>
        </select>
        <br /><br />
        <input type='submit' id="btnSubmit" name='btnvalider' value='Valider la réservation'>

        <input type='hidden' name='nohotel' value='<?php echo $unHotel["nohotel"] ?>'>
        <input type='hidden' name='page' value='saveReservation'>
        <input type='hidden' name='titre' value='<?php echo urlencode($unHotel["nom"]) ?>'>
    </form>

    <script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
    <script>
        var lesChambresDisponiblesListe = [];

        // filter les hotels après que la page soit chargée
        window.addEventListener("load", function() {
            dateDebutChange();
            dateFinChange();
            updateChambresDispo();
            updateAffichage();
        });

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
            updateChambresDispo();
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
            updateChambresDispo();
        }

        function formatDate(date) {
            var year = date.getFullYear();
            var month = ('0' + (date.getMonth() + 1)).slice(-2);
            var day = ('0' + date.getDate()).slice(-2);
            return year + '-' + month + '-' + day;
        }

        // Update liste des chambres disponibles en fonction des dates sélectionnées
        function updateChambresDispo() {
            var datedebutValue = document.getElementById('datedebut').value;
            var datefinValue = document.getElementById('datefin').value;
            var chambresSelector = document.getElementById('listeChambres');
            var labelInfo = document.getElementById('aucuneChambreDispo');
            var btnSubmit = document.getElementById('btnSubmit');

            // Vérifier si les dates sont valides
            if (!datedebutValue || !datefinValue) {
                // Gérer le cas où une ou les deux dates ne sont pas sélectionnées
                return;
            }

            // Créer une instance XMLHttpRequest
            var xhr = new XMLHttpRequest();

            // Spécifier le type de requête, l'URL et si la requête doit être asynchrone
            // méthode getChambreDisponible() dans le fichier reservationC.php
            xhr.open('POST', 'index.php?page=getChambreDisponible', true);

            // Définir le type de données à envoyer au serveur
            xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');

            // Gérer l'événement de changement d'état de la requête
            xhr.onreadystatechange = function() {
                // Vérifier si la requête est terminée et la réponse est prête
                if (xhr.readyState === 4 && xhr.status === 200) {
                    // Parsez la réponse JSON
                    var lesChambresDisponibles = JSON.parse(xhr.responseText);

                    // afficher toutes les chambresSelector
                    for (var i = 0; i < chambresSelector.options.length; i++) {
                        chambresSelector.options[i].hidden = false;
                    }

                    // On parcourt les chambres et si la chambre n'est pas dans la liste des chambres disponibles (lesChambresDisponibles), on la cache
                    for (var i = 0; i < chambresSelector.options.length; i++) {
                        var chambre = chambresSelector.options[i].value;
                        chambresSelector.options[i].hidden = !lesChambresDisponibles.includes(chambre);
                        // desélect la chambre si elle n'est pas disponible
                        if (chambresSelector.options[i].hidden) {
                            chambresSelector.options[i].selected = false;
                        }
                    }
                    updateAffichage();
                    
                }
            };

            // Envoyer la requête avec les dates en tant que données
            var data = 'nohotel=' + encodeURIComponent(<?php echo $unHotel["nohotel"] ?>) + '&datedebut=' + encodeURIComponent(datedebutValue) + '&datefin=' + encodeURIComponent(datefinValue);
            xhr.send(data);
        }

        function updateAffichage() {
            var btnSubmit = document.getElementById('btnSubmit');
            var chambresSelector = document.getElementById('listeChambres');
            var labelInfo = document.getElementById('aucuneChambreDispo');
        
            // recupération du nombre d'options visibles dans le select
            var nbChambresDispo = Array.from(chambresSelector.options).filter(option => !option.hidden);

            if (nbChambresDispo == 0) {
                btnSubmit.style.display = 'none';
                labelInfo.style.display = 'block';
                chambresSelector.style.display = 'none';

            } else {
                btnSubmit.style.display = 'block';
                labelInfo.style.display = 'none';
                chambresSelector.style.display = 'block';
            }
        }
    </script>
</div>
<?php
//Ouverture du template
$title = "Balladins - Réservation hôtel $unHotel[nom]";
$content = ob_get_clean();
require('view/template.php');
?>