function redirection404(messageErreur = '') {
    // Créez dynamiquement un formulaire
    var formulaire = document.createElement('form');
    formulaire.method = 'post';
    formulaire.action = 'index.php';

    // Ajoutez un champ de formulaire pour chaque paramètre
    var page = document.createElement('input');
    page.type = 'hidden';
    page.name = 'page';
    page.value = '404';
    formulaire.appendChild(page);

    var message = document.createElement('input');
    message.type = 'hidden';
    message.name = 'messageErreur';
    message.value = messageErreur;
    formulaire.appendChild(message);

    // Ajoutez le formulaire à la page
    document.body.appendChild(formulaire);

    // Soumettez le formulaire
    formulaire.submit();
}