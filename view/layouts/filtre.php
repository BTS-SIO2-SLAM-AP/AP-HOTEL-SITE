<link rel="stylesheet" href="assets/css/filterbar.css">
<div class="filter-bar">
    <!-- Filtre Équipements -->
    <div class="filter-section">
        <div class="filter-title">Équipements :</div>
        <div class="filter-input-equipements">
            <?php foreach ($listEquipement as $unequ) { ?>
                <label class="equipement-item" title="<?php echo $unequ["lib"] ?>">
                    <input type="checkbox" id="equipement-checkbox" data-noequ="<?php echo $unequ["noequ"] ?>" onchange="filterHotels()">
                    <img class="img-checkbox" src="assets/media/logo/<?php echo $unequ["imgequ"] ?>">
                </label>
            <?php } ?>
        </div>
    </div>

    <!-- Filtre Prix -->
    <div class="filter-section">
        <div class="filter-title">
            <label for="price-range">Prix maximum :</label>
        </div>
        <div class="filter-input">
            <input type="range" id="price-range" name="price_range" min="0" max="<?php echo $prixMax; ?>" value="<?php echo $prixMax; ?>" oninput="updatePriceLabel()">
            <span id="price-label"></span>
        </div>
    </div>

    <!-- Filtre Ville -->
    <div class="filter-section">
        <div class="filter-title">
            <label for="city-search">Rechercher par ville :</label>
        </div>
        <div class="filter-input">
            <input type="text" list="city-list" id="city-search" name="city_search" oninput="filterHotels()" placeholder="Entrez le nom de la ville">
            <datalist id="city-list">
                <?php foreach ($listVille as $uneville) { ?>
                    <option value="<?php echo $uneville ?>"></option>
                <?php } ?>
            </datalist>
        </div>
    </div>

    <!-- Bouton de Réinitialisation -->
    <div class="filter-section">
        <div class="filter-title"></div>
        <div class="filter-input">
            <button onclick="resetFilters()">Réinitialiser les filtres</button>
        </div>
    </div>

    <!-- Nombre d'hôtels affichés -->
    <div class="filter-section">
        <div class="filter-title"></div>
        <div class="filter-input">
            <p id="hotel-count"></p>
        </div>
    </div>

    <!-- Filtre de Tri -->
    <div class="filter-section">
        <div class="filter-title">
            <label for="sorting">Trier par :</label>
        </div>
        <div class="filter-input">
            <select id="sorting" onchange="sortHotels()">
                <option value="nom">Nom</option>
                <option value="prixAsc">Prix -/+</option>
                <option value="prixDesc">Prix +/-</option>
            </select>
        </div>
    </div>
    <script>
        // filter les hotels après que la page soit chargée
        window.addEventListener("load", function() {
            updatePriceLabel();
            filterHotels();
            sortHotels();
        });

        // Filtre les hôtels en fonction des critères sélectionnés par l'utilisateur (prix, équipements, ville)
        function filterHotels() {
            var maxPrice = parseFloat(document.getElementById("price-range").value);

            var selectedEquipements = Array.from(document.querySelectorAll("#equipement-checkbox:checked")).map(checkbox => checkbox.getAttribute("data-noequ"));

            var citySearch = document.getElementById("city-search").value.toLowerCase();

            var hotels = document.querySelectorAll(".hotel-item");
            var displayedHotelCount = 0; // Variable de comptage

            hotels.forEach(function(hotel) {
                var priceHotel = parseFloat(hotel.getAttribute("data-prix"));
                var equipementsHotel = hotel.getAttribute("data-equipements");
                var villeHotel = hotel.getAttribute("data-ville").toLowerCase();

                var isEquipementMatch = selectedEquipements == "" || selectedEquipements.every(function(selected) {
                    return equipementsHotel.split(",").includes(selected);
                });

                var isPriceMatch = priceHotel <= maxPrice;

                var isCityMatch = villeHotel.includes(citySearch);

                if (isEquipementMatch && isPriceMatch && isCityMatch) {
                    hotel.style.display = "block";
                    displayedHotelCount++; // Incrémente le compteur
                } else {
                    hotel.style.display = "none";
                }
            });

            // Met à jour le nombre affiché dans l'interface utilisateur
            switch (displayedHotelCount) {
                case 0:
                    displayedHotelCountStr = "Aucun hôtel trouvé";
                    break;
                case 1:
                    displayedHotelCountStr = displayedHotelCount + " hôtel trouvé";
                    break;
                default:
                    displayedHotelCountStr = displayedHotelCount + " hôtels trouvés";
            }
            document.getElementById("hotel-count").textContent = displayedHotelCountStr
        }

        // Met à jour le label du prix
        function updatePriceLabel() {
            var priceLabel = document.getElementById("price-label");
            var priceRange = document.getElementById("price-range").value;
            if (priceRange > <?php echo $prixMax; ?>) {
                priceRange = <?php echo $prixMax; ?>;
            }
            priceLabel.textContent = priceRange + "€";
            filterHotels();
        }

        // Tri des hôtels par prix ou par nom
        function sortHotels() {
            var sortingSelect = document.getElementById("sorting");
            var sortOrder = sortingSelect.value;

            var hotels = document.querySelectorAll(".hotel-item");

            hotels.forEach(function(hotel) {
                var orderValue;

                switch (sortOrder) {
                    case "prixAsc":
                        orderValue = parseFloat(hotel.getAttribute("data-prix"));
                        break;
                    case "prixDesc":
                        orderValue = -parseFloat(hotel.getAttribute("data-prix"));
                        break;
                    case "nom":
                        orderValue = 0;
                        break;
                    default:
                        orderValue = 0; // Valeur par défaut
                }

                hotel.style.order = orderValue;
            });
        }

        // Réinitialise les filtres
        function resetFilters() {
            // unchecked all checkboxes
            document.querySelectorAll("#equipement-checkbox:checked").forEach(function(checkbox) {
                checkbox.checked = false;
            });
            document.getElementById("price-range").value = <?php echo $prixMax; ?>;
            updatePriceLabel();
            document.getElementById("city-search").value = "";
            filterHotels();
        }
    </script>
</div>