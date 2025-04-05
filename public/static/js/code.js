"use strict";
// Load
$(document).ready(function () {
    showNotifications();
});




// Notification
function showNotifications() {
    var notif = $("#notification div");
    notif.toggleClass("show");
    notif.on("click", "button", function () {
        hideNotifications($(this).closest("div"));
    });
    setTimeout(function () {
        hideNotifications(notif);
    }, 10000);
}

function hideNotifications(notif) {
    notif.removeClass("show");
    setTimeout(function () {
        notif.css("display", "none");
    }, 500);
}

// Confirmation dialog

function confirmDialog(title, message, callback) {
    var contenue = `
    <dialog id="confirmDialog" class="dialog">
        <div class="dialog-content">
            <h2>${title}</h2>
            <p>${message}</p>
            <div>
                <button id="cancel">Annuler</button>
                <button id="confirm">Valider</button>
            </div>
        </div>
    </dialog>
    `;
    $('body').append(contenue);
    var dialog = document.getElementById('confirmDialog');
    dialog.showModal();

    $('#confirm').on('click', function () {
        console.log("Confirmed");
        dialog.close();
        $('#confirmDialog').remove();
        if (callback) {
            callback(true);
        }
        return false;
    });
    $('#cancel').on('click', function () {
        console.log("Canceled");
        dialog.close();
        $('#confirmDialog').remove();
        if (callback) {
            callback(false);
        }
    });
}
function handleFormSubmit(event, dialogTitle, dialogMessage) {
    event.preventDefault();
    var form = $(event.target);

    confirmDialog(dialogTitle, dialogMessage, function (confirmed) {
        if (confirmed) {
            form.off('submit').submit();
        }
    });
}

