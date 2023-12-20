// paramètres de button d'item
titleAvailable = "Add";
titleSelected = "Remove";
innerHTMLLeftAvailable = "";
innerHTMLLeftSelected = "";
innerHTMLRightAvailable = "";
innerHTMLRightSelected = " ✖";
idItem = "item";

// Function to move an item from one list to another (available to selected or selected to available)
function moveItem(item) {
    var itemParent = item.parentNode;
    var itemParentId = itemParent.getAttribute('id');
    var itemsSelected = document.querySelector('#items-selected');
    var itemsAvailable = document.querySelector('#items-available');
    var itemsSelectedData = itemsSelected.getAttribute('data-items-selected');
    var itemsAvailableData = itemsAvailable.getAttribute('data-items-available');

    if (itemParentId == 'items-selected') {
        itemsSelected.removeChild(item);
        item.title = titleAvailable;
        item.innerHTML = innerHTMLLeftAvailable + item.value + innerHTMLRightAvailable;
        itemsAvailable.appendChild(item);

        var newListItemsAvailable = itemsAvailableData ? itemsAvailableData.split(',').concat([item.value]).join(',') : item.value;
        var newListItemsSelected = itemsSelectedData.split(',').map(String).filter(function (value) { return value !== item.value; });

        itemsAvailable.setAttribute('data-items-available', newListItemsAvailable);
        itemsSelected.setAttribute('data-items-selected', newListItemsSelected);

    } else if (itemParentId == 'items-available') {
        itemsAvailable.removeChild(item);
        item.title = titleSelected;
        item.innerHTML = innerHTMLLeftSelected + item.value + innerHTMLRightSelected;
        itemsSelected.appendChild(item);

        var newListItemsAvailable = itemsAvailableData.split(',').map(String).filter(function (value) { return value !== item.value; });
        var newListItemsSelected = itemsSelectedData ? itemsSelectedData.split(',').concat([item.value]).join(',') : item.value;

        itemsAvailable.setAttribute('data-items-available', newListItemsAvailable);
        itemsSelected.setAttribute('data-items-selected', newListItemsSelected);
    }
    switchVisibilityLabel();
}

// Function to update the value of the hidden input containing the list of selected items
function updateItemSelectionInput() {
    document.getElementById('inputSelectedItems').value = document.getElementById('items-selected').getAttribute('data-items-selected').split(',').join(',');
}

// Function to switch the visibility of the labels of the lists of available and selected items (if there are no items in the list, the label is hidden)
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
            itemsAvailable.appendChild(CreateButton(item, titleAvailable, innerHTMLLeftAvailable, innerHTMLRightAvailable));
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
            itemsSelected.appendChild(CreateButton(item, titleSelected, innerHTMLLeftSelected, innerHTMLRightSelected));
        });
    }
}

// Function to create a button
function CreateButton(value, title = "", innerHTMLLeft = "", innerHTMLRight = "") {
    var button = document.createElement('button');
    button.type = 'button';
    button.id = idItem;
    button.value = value;
    button.title = title;
    button.style.order = value;
    button.addEventListener('click', function () {
        moveItem(this);
        updateItemSelectionInput();
    });
    button.innerHTML = innerHTMLLeft + value + innerHTMLRight;
    return button;
}

// Function to update the lists of available and selected items
function UpdateItems(listItemsUpdateStr, listAllItemsStr) {
    var itemsAvailable = document.querySelector('#items-available');
    var itemsSelected = document.querySelector('#items-selected');

    var listItemsUpdate = listItemsUpdateStr.map(String);
    var listChambresHotel = listAllItemsStr.split(", ").map(String);

    var itemsToRemove = listChambresHotel.filter(function(item) {
        return !listItemsUpdate.includes(item);
    });

    var oldItemsSelectedData = itemsSelected.getAttribute('data-items-selected').split(',').map(String);

    var newItemsSelectedData = oldItemsSelectedData.filter(function(item) {
        return !itemsToRemove.includes(item);
    }).map(String);

    var newItemsAvailableData = [];

    listItemsUpdate.forEach(function (item) {
        if (!newItemsSelectedData.includes(item) && !newItemsAvailableData.includes(item)) {
            newItemsAvailableData.push(item);
        }
    });

    itemsAvailable.setAttribute('data-items-available', newItemsAvailableData);
    itemsSelected.setAttribute('data-items-selected', newItemsSelectedData);

    InitItemsButton();
    switchVisibilityLabel();
}