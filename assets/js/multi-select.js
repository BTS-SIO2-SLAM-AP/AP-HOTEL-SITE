// paramètres de button d'item 3
titleAvailable = "Ajouter la chambre";
titleSelected = "Retirer la chambre";
innerHTMLLeftAvailable = "N°";
innerHTMLLeftSelected = "N°";
innerHTMLRightAvailable = "";
innerHTMLRightSelected = " ✖";
idItem = "item";


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
        item.title = titleAvailable;
        item.innerHTML = innerHTMLLeftAvailable + itemValue + innerHTMLRightAvailable;
        itemsAvailable.appendChild(item);

        var newListItemsAvailable = itemsAvailableData ? itemsAvailableData.split(',').concat([itemValue]).join(',') : itemValue;
        var newListItemsSelected = itemsSelectedData ? itemsSelectedData.split(',').filter(function (value) {
            return value !== itemValue;
        }).join(',') : '';

        itemsAvailable.setAttribute('data-items-available', newListItemsAvailable);
        itemsSelected.setAttribute('data-items-selected', newListItemsSelected);

    } else if (itemParentId == 'items-available') {
        itemsAvailable.removeChild(item);
        item.title = titleSelected;
        item.innerHTML = innerHTMLLeftSelected + itemValue + innerHTMLRightSelected;
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

// Function to initialize the buttons associated to the items lists (available and selected)
function InitItemsButton() {
    var itemsAvailable = document.querySelector('#items-available');
    var itemsAvailableDataArray = itemsAvailable.getAttribute('data-items-available').split(',');

    // deletion of all buttons of the list of available items
    while (itemsAvailable.firstChild) {
        itemsAvailable.removeChild(itemsAvailable.firstChild);
    }
    if (itemsAvailableDataArray.length != "" && itemsAvailableDataArray[0] != "") {
        // addition of buttons of the list of available items
        itemsAvailableDataArray.forEach(function (item) {
            if (item != "") {
                var button = document.createElement('button');
                button.setAttribute('type', 'button');
                button.setAttribute('id', idItem);
                button.setAttribute('data-value', item);
                button.title = titleAvailable;
                button.style.order = item;
                button.addEventListener('click', function () {
                    moveItem(this);
                });
                button.innerHTML = innerHTMLLeftAvailable + item + innerHTMLRightAvailable;
                itemsAvailable.appendChild(button);
            }
        });
    }

    var itemsSelected = document.querySelector('#items-selected');
    var itemsSelectedDataArray = itemsSelected.getAttribute('data-items-selected').split(',');

    // deletion of all buttons of the list of selected items
    while (itemsSelected.firstChild) {
        itemsSelected.removeChild(itemsSelected.firstChild);
    }
    if (itemsSelectedDataArray != "" && itemsSelectedDataArray[0] != "") {
        // addition of buttons of the list of selected items
        itemsSelectedDataArray.forEach(function (item) {
            var button = document.createElement('button');
            button.setAttribute('type', 'button');
            button.setAttribute('id', idItem);
            button.setAttribute('data-value', item);
            button.title = titleSelected;
            button.style.order = item;
            button.addEventListener('click', function () {
                moveItem(this);
            });
            button.innerHTML = innerHTMLLeftSelected + item + innerHTMLRightSelected;
            itemsSelected.appendChild(button);
        });
    }
}

// Function to update the lists of available and selected items
function UpdateItems(listChambresDisponibleStr, listChambresHotelStr) {
    var itemsAvailable = document.querySelector('#items-available');
    var itemsSelected = document.querySelector('#items-selected');

    var oldItemsSelectedData = [];
    itemsSelected.getAttribute('data-items-selected').split(',').map(Number).forEach(function (item) {
        if (item != "") {
            oldItemsSelectedData.push(item);
        }
    });

    var listChambresDisponible = listChambresDisponibleStr.map(Number);
    var listChambresHotel = listChambresHotelStr.split(", ").map(Number);

    var itemsToRemove = listChambresHotel.filter(function(item) {
        return !listChambresDisponible.includes(item);
    });

    var newItemsSelectedData = oldItemsSelectedData.filter(function(item) {
        return !itemsToRemove.includes(item);
    }).map(Number);

    var newItemsAvailableData = [];

    // Ajout des nouvelles chambres disponibles
    listChambresDisponible.forEach(function (item) {
        if (!newItemsSelectedData.includes(item) && !newItemsAvailableData.includes(item)) {
            newItemsAvailableData.push(item);
        }
    });

    itemsAvailable.setAttribute('data-items-available', newItemsAvailableData);
    itemsSelected.setAttribute('data-items-selected', newItemsSelectedData);

    InitItemsButton();
    switchVisibilityLabel();
}