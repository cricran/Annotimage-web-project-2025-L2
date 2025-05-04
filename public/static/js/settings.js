$(document).ready(function () {
    $('#logout').on('submit', function (event) {
        handleFormSubmit(event, "Êtes vous sure de vouloire vous déconnecter ?", "Confirmer votre déconnexion");
    });
    $('#delete').on('submit', function (event) {
        handleFormSubmit(event, "Êtes vous sure de vouloire supprimer votre compte ?", "La supression de votre compte est irréversible et supprmiera toutes vos données. Confirmer la supression de votre compte ?");
    });
});