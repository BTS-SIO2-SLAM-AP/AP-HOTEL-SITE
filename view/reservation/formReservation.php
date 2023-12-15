<?php
//VUE liste des classes avec lien hypertexte
//Préparation flux HTML pour le template
ob_start();
?>
<link rel="stylesheet" href="assets/css/formReservation.css">
Réserver dans l'hôtel <?php echo $unHotel["nom"] ?>
<br /><br />

<div class="formReservation">
    <form method='post' action="index.php">
        <div class="datesReservation inputForm">
            <label for="datedebut">Réserver du</label>
            <input type="date" id="datedebut" name="datedebut" value="<?php echo date("Y-m-d"); ?>" min="<?php echo date("Y-m-d"); ?>" onchange="dateDebutChange()" onclick="click()" required>

            <label for="datefin">au</label>
            <input type="date" id="datefin" name="datefin" value="<?php echo date('Y-m-d', strtotime('+1 day')); ?>" min="<?php echo date('Y-m-d', strtotime('+1 day')); ?>" onchange="dateFinChange()" required style="background-color:pink;">
        </div>
        <table>
            <td>
                <div class="inputForm">
                    <label for="email">Email :</label>
                    <input type="email" name="txtmail" required>
                </div>

                <div class="inputForm">
                    <label for="txtnom">Nom :</label>
                    <input type="text" name="txtnom" required>
                </div>
            </td>
            <td id="chambreSelector">
                <link rel="stylesheet" href="assets/css/multi-select.css">
                <div id="multi-select">
                    <label for="items-selected" style="display: none;">Chambre(s) sélectionnée(s)</label>
                    <div id="items-selected" data-items-selected></div>
                    <label for="items-available">Chambre(s) disponible(s)</label>
                    <div id="items-available" data-items-available></div>
                </div>
                <script src="assets/js/multi-select.js"></script>
                <script>
                    // paramètres de button d'item
                    titleAvailable = "Ajouter la chambre";
                    titleSelected = "Retirer la chambre";
                    innerHTMLLeftAvailable = "N°";
                    innerHTMLLeftSelected = "N°";
                    innerHTMLRightAvailable = "";
                    innerHTMLRightSelected = " ✖";
                    idItem = "item";
                </script>
            </td>
        </table>

        <input type='submit' id="btnSubmit" name='btnvalider' value='Valider la réservation'>

        <input type='hidden' name='nohotel' value='<?php echo $unHotel["nohotel"] ?>'>
        <input type='hidden' name='page' value='saveReservation'>
        <input type='hidden' name='listchambres'>

        <p id="noneChambreSelected" hidden>Veuillez sélectionner au moins une chambre.</p>
        <p id="aucuneChambreDispo" hidden>Aucune chambre disponible pour ces dates.</p>
    </form>


    <script src="assets/js/jquery-3.6.4.min.js"></script>
    <script>
        var lesChambresDisponiblesListe = [];

        // filter les hotels après que la page soit chargée
        window.addEventListener("load", function() {
            updateChambresDispo();
            updateAffichage();
        });

        document.getElementsByName('btnvalider')[0].addEventListener('click', function() {
            var lesChambresDisponibles = document.getElementById('items-selected').getAttribute('data-items-selected').split(',');
            document.getElementsByName('listchambres')[0].value = lesChambresDisponibles.join(',');
        });

        // Gestion de la date de début
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

        // Gestion de la date de fin
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

        // Formater une date en YYYY-MM-DD
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
            xhr.open('POST', 'index.php', true);

            // Définir le type de données à envoyer au serveur
            xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');

            // Gérer l'événement de changement d'état de la requête
            xhr.onreadystatechange = function() {
                // Vérifier si la requête est terminée et la réponse est prête
                if (xhr.readyState === 4 && xhr.status === 200) {
                    // Parsez la réponse JSON
                    var lesChambresDisponibles = JSON.parse(xhr.responseText);

                    UpdateItems(lesChambresDisponibles, <?php echo json_encode(implode(', ', array_column($unHotel['chambres'], 'nochambre'))) ?>);
                    updateAffichage();
                }
            };

            // Envoyer la requête avec les dates en tant que données
            var data = 'page=getChambreDisponible&nohotel=' + encodeURIComponent(<?php echo $unHotel["nohotel"] ?>) + '&datedebut=' + encodeURIComponent(datedebutValue) + '&datefin=' + encodeURIComponent(datefinValue);
            xhr.send(data);
        }

        // Modifie les éléments informatifs à afficher
        function updateAffichage() {
            var btnSubmit = document.getElementById('btnSubmit');
            var chambreSelector = document.getElementById('chambreSelector');
            var aucuneChambreDispo = document.getElementById('aucuneChambreDispo');
            var noneChambreSelected = document.getElementById('noneChambreSelected');
            btnSubmit.style.display = 'none';
            chambreSelector.hidden = true;
            aucuneChambreDispo.hidden = true;
            noneChambreSelected.hidden = true;

            var HasChambresDispo = document.getElementById('items-available').getAttribute('data-items-available').split(',') != "";
            var HasChambreSelected = document.getElementById('items-selected').getAttribute('data-items-selected').split(',') != "";

            if (!HasChambresDispo && !HasChambreSelected) {
                aucuneChambreDispo.hidden = false;
            } else {
                chambreSelector.hidden = false;
                if (HasChambreSelected) {
                    btnSubmit.style.display = 'block';
                } else {
                    noneChambreSelected.hidden = false;
                }

            }
        }

        // détecter si un button d'item est cliqué
        document.addEventListener('click', function(e) {
            if (e.target && e.target.id == idItem) {
                updateAffichage();
            }
        });
    </script>

</div>
<?php
//Ouverture du template
$title = "Balladins - Réservation hôtel $unHotel[nom]";
$content = ob_get_clean();
require('view/template.php');
?>