<link rel="stylesheet" href="assets/css/filterbar.css">
<div class="filter-bar">
    <div class="content">
        <div class="reservation-equipments-list">
            <?php
            foreach ($listEquipement as $unequ) { ?>
                <label class="equipement-item">
                    <input type="checkbox" checked>
                    <img class="img-unchecked" src="assets/media/logo/handicapes.png">
                    <img class="img-checked" src="assets/media/logo/<?php echo $unequ["imgequ"] ?>">
                </label>

                <!-- <input type="checkbox" name="equipement-<?php echo $unequ["noequ"] ?>" value="<?php echo $unequ["lib"] ?>" class="reservation__equipment__checkbox || icon--equipment__checkbox || tooltip-parent" id="equipement-<?php echo $unequ["noequ"] ?>" style="display: none;">
                <label class="reservation__equipment__label || icon--equipment__label" for="equipement-<?php echo $unequ["noequ"] ?>" style="background-image: url('');">
                </label> -->
            <?php } ?>

            <!-- <li class="reservation__equipments__item || icon--equipment">
                <label class="reservation__equipment__label || icon--equipment__label">
                    <input type="checkbox" name="animaux-admis" value="animaux-admis" class="reservation__equipment__checkbox || icon--equipment__checkbox || tooltip-parent"><span class="reservation__equipment__icon || icon--equipment__icon">
                        <svg class="svg svg_i-animaux-admis" viewBox="0 0 44 44">
                            <use xlink:href="/assets/svg/sprite.svg#svg-i-animaux-admis"></use>
                        </svg></span>
                    <span class="tooltip || icon--equipment__tooltip">animaux admis</span>
                </label>
            </li> -->
        </div>



        <!-- <script>
            var equipementsList = document.querySelector(".reservation__equipments__list");
            <?php
            foreach ($listEquipement as $unequ) { ?>
                <input type="checkbox" name="equipement-<?php echo $unequ["noequ"] ?>" value="<?php echo $unequ["lib"] ?>" class="reservation__equipment__checkbox || icon--equipment__checkbox || tooltip-parent" id="equipement-<?php echo $unequ["noequ"] ?>">
                // var equipementItem = document.createElement("li");
                // equipementItem.classList.add("reservation__equipments__item", "||", "icon--equipment");

                // var equipementLabel = document.createElement("label");
                // equipementLabel.classList.add("reservation__equipment__label", "||", "icon--equipment__label");

                // var equipementCheckbox = document.createElement("input");
                // equipementCheckbox.type = "checkbox";
                // equipementCheckbox.name = "equipement-<?php echo $unequ["noequ"] ?>";
                // equipementCheckbox.value = <?php echo json_encode($unequ["lib"]) ?>;
                // equipementCheckbox.classList.add("reservation__equipment__checkbox", "||", "icon--equipment__checkbox", "||", "tooltip-parent");

                // var equipementIcon = document.createElement("span");
                // equipementIcon.classList.add("reservation__equipment__icon", "||", "icon--equipment__icon");

                // var equipementSvg = document.createElement("svg");
                // equipementSvg.classList.add("svg", "svg_i-<?php echo $unequ["imgequ"] ?>");
                // equipementSvg.setAttribute("viewBox", "0 0 44 44");

                // var equipementSvgUse = document.createElement("use");
                // equipementSvgUse.setAttribute("xlink:href", "/assets/svg/sprite.svg#svg-i-<?php echo $unequ["imgequ"] ?>");

                // var equipementTooltip = document.createElement("span");
                // equipementTooltip.classList.add("tooltip", "||", "icon--equipment__tooltip");
                // equipementTooltip.textContent = <?php echo json_encode($unequ["lib"]) ?>;

                // equipementSvg.appendChild(equipementSvgUse);
                // equipementIcon.appendChild(equipementSvg);
                // equipementLabel.appendChild(equipementCheckbox);
                // equipementLabel.appendChild(equipementIcon);
                // equipementLabel.appendChild(equipementTooltip);
                // equipementItem.appendChild(equipementLabel);
                // equipementsList.appendChild(equipementItem);
            <?php } ?>
        </script> -->


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
            <input type="range" id="price-range" name="price_range" min="0" max="<?php echo $prixMax; ?>" value="<?php echo $prixMax; ?>" oninput="updatePriceLabel()">
            <span id="price-label"></span>
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
                updatePriceLabel();
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
                if (priceRange > <?php echo $prixMax; ?>) {
                    priceRange = <?php echo $prixMax; ?>;
                }
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

                // get valeur par défaut du range
                document.getElementById("price-range").value = <?php echo $prixMax; ?>;
                updatePriceLabel();
                document.getElementById("city-search").value = "";
                document.getElementById("equipements-list").value = [];
                filterHotels();
            }
        </script>
    </div>
</div>