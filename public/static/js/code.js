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