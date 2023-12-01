<div id="filtre" class="filter-bar">
    Sélectionnez un équipement :
    <select name="equipements-list[]" id="equipements-list" onchange="filterHotels()" multiple>
        <?php foreach ($listEquipement as $unequ) { ?>
            <option value='<?php echo $unequ["noequ"] ?>'><?php echo $unequ["lib"] ?></option>
        <?php } ?>
    </select>
    <br /><br />
    <label for="price-range">Prix Max :</label>
    <input type="range" id="price-range" name="price_range" min="0" max="100" value="60" oninput="updatePriceLabel()">
    <span id="price-label">60</span>€
    <br /><br />
    <label for="city-search">Rechercher par ville :</label>
    <input type="text" id="city-search" name="city_search" oninput="filterHotels()" placeholder="Entrez le nom de la ville">

    <p id="hotel-count">Nombre d'hôtels trouvé : <span>0</span></p>

    <label for="sorting">Trier par :</label>
    <select id="sorting" onchange="sortHotels()">
        <option value="prixAsc">Prix -/+</option>
        <option value="prixDesc">Prix +/-</option>
        <option value="nom" selected>Nom A-Z</option>
    </select>

    <script>
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
            document.getElementById("hotel-count").querySelector("span").textContent = displayedHotelCount;
        }

        function updatePriceLabel() {
            var priceLabel = document.getElementById("price-label");
            var priceRange = document.getElementById("price-range").value;
            priceLabel.textContent = priceRange;
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
    </script>

    <form method="post" action="index.php">
        <input type="hidden" name="page" value="<?php echo $page ?>">
        <button type="submit">Reset Filtre</button>
    </form>
</div>