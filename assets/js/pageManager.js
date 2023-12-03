function pageRedirection(targetPage = 'index.php', datas = {}) {
    // Créez dynamiquement un formulaire
    var formulaire = document.createElement('form');
    formulaire.method = 'post';
    formulaire.action = 'index.php';

    // Ajoutez un champ de formulaire pour chaque paramètre
    var page = document.createElement('input');
    page.type = 'hidden';
    page.name = 'page';
    page.value = targetPage;
    formulaire.appendChild(page);

    if (datas != null) {
        for (var champKey in datas) {
            var champ = document.createElement('input');
            champ.type = 'hidden';
            champ.name = champKey;
            champ.value = datas[champKey];
            formulaire.appendChild(champ);
        }
    }

    // Ajoutez le formulaire à la page
    document.body.appendChild(formulaire);

    // Soumettez le formulaire
    formulaire.submit();
}