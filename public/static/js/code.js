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
        dialog.close();
        $('#confirmDialog').remove();
        if (callback) {
            callback(true);
        }
        return false;
    });
    $('#cancel').on('click', function () {
        dialog.close();
        $('#confirmDialog').remove();
        if (callback) {
            callback(false);
        }
    });
}

function confirmDialogText(title, message, callback) {
    var contenue = `
    <dialog id="confirmDialog" class="dialog">
        <div class="dialog-content">
            <h2>${title}</h2>
            <p>${message}</p>
            <input type="text" id="promptInput" style="width: 100%; margin-bottom: 1em;">
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
        var value = $('#promptInput').val();
        dialog.close();
        $('#confirmDialog').remove();
        if (callback) {
            callback(value);
        }
        return false;
    });
    $('#cancel').on('click', function () {
        dialog.close();
        $('#promptDialog').remove();
        if (callback) {
            callback(null);
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


function addTagList(name, place) {
    var content = `
    <div>
        <span>${name}</span>
        <button><img src="../static/images/close.svg" alt="suprimer"></button>
        <input type="hidden" name="tags[]" id="tags" value="${name}">
    </div>
    `;
    $(place).prepend(content);
    var addedButton = $(place + " div:first-of-type button");
    addedButton.on('click', function (event) {
        $(this).closest("div").remove();
    })
}

function addAnnotList(name, place, value) {
    var content = `
    <div>
        <span>${name}</span>
        <button><img src="../static/images/close.svg" alt="suprimer"></button>
        <input type="hidden" name="annot[]" value='${value.replace(/'/g, "&#39;")}'>
    </div>
    `;
    $(place).prepend(content);
    var addedButton = $(place + " div:first-of-type button");
    addedButton.on('click', function (event) {
        $(this).closest("div").remove();
    })
}

// translate point

function translatePoint(point, srcRect, destRect) {
    return {
        x: (point.x * (destRect.width / srcRect.width)),
        y: (point.y * (destRect.height / srcRect.height))
    };
}