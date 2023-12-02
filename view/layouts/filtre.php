<link rel="stylesheet" href="assets/css/filterbar.css">
<div class="filter-bar">
    <div class="content">
        <div class="filter-equipements">
            Sélectionnez un équipement :
            <select name="equipements-list[]" id="equipements-list" onchange="filterHotels()" multiple>
                <?php foreach ($listEquipement as $unequ) { ?>
                    <option value='<?php echo $unequ["noequ"] ?>'><?php echo $unequ["lib"] ?></option>
                <?php } ?>
            </select>
        </div>
        
        <div class="filter-prix">
            <label for="price-range">Prix maximum :</label>
            <input type="range" id="price-range" name="price_range" min="0" max="100" value="60" oninput="updatePriceLabel()">
            <span id="price-label">60€</span>
        </div>

        <div class="filter-ville">
            <label for="city-search">Rechercher par ville :</label>
            <input type="text" id="city-search" name="city_search" oninput="filterHotels()" placeholder="Entrez le nom de la ville">
        </div>

        <!-- bouton pour remettre les filtres par défaut -->
        <button onclick="resetFilters()">Réinitialiser les filtres</button>

        <p id="hotel-count"></p>

        <div class="filter-equipements">
            <label for="sorting">Trier par :</label>
            <select id="sorting" onchange="sortHotels()">
                <option value="nom">Nom</option>
                <option value="prixAsc">Prix -/+</option>
                <option value="prixDesc">Prix +/-</option>
            </select>
        </div>

        <script>
            // filter les hotels après que la page soit chargée
            window.addEventListener("load", function() {
                filterHotels();
                sortHotels();
            });

            function filterHotels() {
                var maxPrice = parseFloat(document.getElementById("price-range").value);

                var selectedEquipements = Array.from(document.getElementById("equipements-list").selectedOptions).map(option => option.value);


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

            function updatePriceLabel() {
                var priceLabel = document.getElementById("price-label");
                var priceRange = document.getElementById("price-range").value;
                priceLabel.textContent = priceRange + "€";
                filterHotels();
            }

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

            function resetFilters() {
                document.getElementById("price-range").value = 60;
                updatePriceLabel();
                document.getElementById("city-search").value = "";
                document.getElementById("equipements-list").value = [];
                filterHotels();
            }
        </script>
    </div>
</div>