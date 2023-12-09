function moveItem(item) {
    var itemValue = item.getAttribute('data-value');
    var itemParent = item.parentNode;
    var itemParentId = itemParent.getAttribute('id');
    var itemsSelected = document.querySelector('#items-selected');
    var itemsAvailable = document.querySelector('#items-available');
    var itemsSelectedData = itemsSelected.getAttribute('data-items-selected');
    var itemsAvailableData = itemsAvailable.getAttribute('data-items-available');

    if (itemParentId == 'items-selected') {
        itemsSelected.removeChild(item);
        item.title = "Ajouter la chambre";
        item.innerHTML = 'N°' + itemValue;
        itemsAvailable.appendChild(item);

        var newListItemsAvailable = itemsAvailableData ? itemsAvailableData.split(',').concat([itemValue]).join(',') : itemValue;
        var newListItemsSelected = itemsSelectedData ? itemsSelectedData.split(',').filter(function (value) {
            return value !== itemValue;
        }).join(',') : '';

        itemsAvailable.setAttribute('data-items-available', newListItemsAvailable);
        itemsSelected.setAttribute('data-items-selected', newListItemsSelected);

    } else if (itemParentId == 'items-available') {
        itemsAvailable.removeChild(item);
        item.title = "Retirer la chambre";
        item.innerHTML = 'N°' + itemValue + ' ✖';
        itemsSelected.appendChild(item);

        var newListItemsAvailable = itemsAvailableData ? itemsAvailableData.split(',').filter(function (value) {
            return value !== itemValue;
        }).join(',') : '';
        var newListItemsSelected = itemsSelectedData ? itemsSelectedData.split(',').concat([itemValue]).join(',') : itemValue;

        itemsAvailable.setAttribute('data-items-available', newListItemsAvailable);
        itemsSelected.setAttribute('data-items-selected', newListItemsSelected);
    }
    switchVisibilityLabel();
}

function switchVisibilityLabel() {
    var itemsSelected = document.querySelector('#items-selected');
    var itemsAvailable = document.querySelector('#items-available');
    var itemsSelectedData = itemsSelected.getAttribute('data-items-selected');
    var itemsAvailableData = itemsAvailable.getAttribute('data-items-available');

    if (itemsSelectedData == '') {
        document.querySelector('label[for="items-selected"]').style.display = 'none';
    } else {
        document.querySelector('label[for="items-selected"]').style.display = 'block';
    }

    if (itemsAvailableData == '') {
        document.querySelector('label[for="items-available"]').style.display = 'none';
    } else {
        document.querySelector('label[for="items-available"]').style.display = 'block';
    }
}

// Fonction pour ajouter un element button dans la liste des items disponibles pour chaque chambre de data-all-items
function CreateButtonsItems() {
    var itemsAvailable = document.querySelector('#items-available');
    var itemsAvailableDataArray = itemsAvailable.getAttribute('data-items-available').split(',');

    // suppression de tout les boutons de la liste des items disponibles
    while (itemsAvailable.firstChild) {
        itemsAvailable.removeChild(itemsAvailable.firstChild);
    }
    if (itemsAvailableDataArray.length != "" && itemsAvailableDataArray[0] != "") {
        // ajout des boutons de la liste des items disponibles
        itemsAvailableDataArray.forEach(function (item) {
            if (item != "") {
                var button = document.createElement('button');
                button.setAttribute('type', 'button');
                button.setAttribute('id', 'item');
                button.setAttribute('data-value', item);
                button.title = "Ajouter la chambre";
                button.style.order = item;
                button.addEventListener('click', function () {
                    moveItem(this);
                });
                button.innerHTML = 'N°' + item;
                itemsAvailable.appendChild(button);
            }
        });
    }

    var itemsSelected = document.querySelector('#items-selected');
    var itemsSelectedDataArray = itemsSelected.getAttribute('data-items-selected').split(',');

    // suppression de tout les boutons de la liste des items sélectionnés
    while (itemsSelected.firstChild) {
        itemsSelected.removeChild(itemsSelected.firstChild);
    }
    // ajout des boutons de la liste des items sélectionnés
    if (itemsSelectedDataArray != "" && itemsSelectedDataArray[0] != "") {
        itemsSelectedDataArray.forEach(function (item) {
            var button = document.createElement('button');
            button.setAttribute('type', 'button');
            button.setAttribute('id', 'item');
            button.setAttribute('data-value', item);
            button.title = "Retirer la chambre";
            button.style.order = item;
            button.addEventListener('click', function () {
                moveItem(this);
            });
            button.innerHTML = 'N°' + item + ' ✖';
            itemsSelected.appendChild(button);
        });
    }
}

// Fonction pour update data-all-items avec une liste json de chambres via une liste php
function UpdateItems(listChambresDisponible, listChambresHotel) {
    var itemsAvailable = document.querySelector('#items-available');

    var itemsSelected = document.querySelector('#items-selected');
    var oldItemsSelectedData = itemsSelected.getAttribute('data-items-selected');

    var newItemsSelectedData = oldItemsSelectedData.endsWith(',') ? oldItemsSelectedData.slice(0, -1) : oldItemsSelectedData;

    // Récupération de la liste des chambres indisponibles
    var itemsToRemove = '';

    listChambresHotel.split(',').forEach(item => {
        if (!listChambresDisponible.includes(item)) {
            itemsToRemove = itemsToRemove.length === 0 ? item : itemsToRemove + ',' + item;
        }
    });

    itemsToRemove = Array.from(new Set(itemsToRemove.split(','))).join(',');
    alert(itemsToRemove);
    itemsToRemove = Array(itemsToRemove);
    alert(itemsToRemove);

    // Pour chaque chambre de la liste des chambres disponibles, on ajoute un bouton dans la liste des items disponibles si elle n'est pas déjà dans la liste des items sélectionnés
    itemsToRemove.forEach(item => {
        if (oldItemsSelectedData.split(',').includes(item)) {
            newItemsSelectedData = newItemsSelectedData.length === 0 ? item : newItemsSelectedData.split(',').filter(i => i !== item).join(',');
            alert(item);
        }
    });

    alert(newItemsSelectedData);

    // supprime le contenu de la liste des items disponibles data-items-available
    newItemsAvailableData = '';

    // Ajout des nouvelles chambres disponibles
    listChambresDisponible.forEach(function (item) {
        if (!newItemsSelectedData.includes(item) && !newItemsAvailableData.includes(item)) {
            newItemsAvailableData = newItemsAvailableData.length == 0 ? item : newItemsAvailableData.split(',').concat([item]).join(',');
        }
    });

    itemsAvailable.setAttribute('data-items-available', newItemsAvailableData);
    itemsSelected.setAttribute('data-items-selected', newItemsSelectedData);

    CreateButtonsItems();
    switchVisibilityLabel();
}