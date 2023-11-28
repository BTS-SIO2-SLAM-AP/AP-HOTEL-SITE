<div id="filtre" class="filter-bar">
    Sélectionnez un équipement :
    <select name="equipements[]" id="equipements" onchange="filterHotels()" multiple>
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


    <script>
        function filterHotels() {
            var maxPrice = document.getElementById("price-range").value;
            var selectedEquipement = document.getElementById("equipements").value;
            var citySearch = document.getElementById("city-search").value.toLowerCase();

            var hotels = document.querySelectorAll(".hotel-item");
            var displayedHotelCount = 0; // Variable de comptage

            hotels.forEach(function(hotel) {
                var price = hotel.getAttribute("data-prix");
                var equipements = hotel.getAttribute("data-equipements");
                var ville = hotel.getAttribute("data-ville").toLowerCase();


                // faire multiselect
                var isEquipementMatch = equipements.split(",").includes(selectedEquipement) || selectedEquipement == "";

                var isPriceMatch = price <= maxPrice;

                var isCityMatch = ville.includes(citySearch);

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
    </script>

    <form method="post" action="index.php">
        <input type="hidden" name="action" value="<?php echo $action ?>">
        <button type="submit">Reset Filtre</button>
    </form>
</div>