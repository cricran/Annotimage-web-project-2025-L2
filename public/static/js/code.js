"use strict";
// Load
$(document).ready(function () {
    showNotifications();
    $('article').on('click', function () {
        const id = $(this).attr('id');
        if (id) {
            showImage(id);
        }
    });
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

// Image show
function showImage(id) {
    $.getJSON(`/imageInfo.php?id=${id}`, function (data) {
        // L'image
        var tagsList = "Aucun";
        if (data['tags'] && data['tags'].length !== 0) {
            tagsList = data['tags']
                .map(tag => `<a href="/index.php/tag?tag=${encodeURIComponent(tag['name'])}">#${tag['name']}</a>`)
                .join(', ');
        }

        var contenue = `
        <dialog id="showImg">
            <button id="cancel"><img src="../static/images/close.svg" alt="close"></button>
            <diV>
                <div id="imgZonne">
                    <img src="/image.php?image=${data['image']['path']}" alt="${data['image']['description']}" id="imgZonne_img">
                    <div class="tooltip" id="annotation-tooltip"></div>
                </div>
                <div>
                    <h2>${data['image']['description']}</h2>
                    <p>Utilisateur : <a href="/index.php/user?user=${data['image']['user']['username']}">@${data['image']['user']['username']}</a></p>
                    <p>Tags : ${tagsList}</p>
                </div>
            </div>
            <div>
                <p>Image :</p>
                <a href=""><img src="../static/images/edit.svg" alt=""></a>
                <a href=""><img src="../static/images/del.svg" alt=""></a>
                <p>Annotation :</p>
                <a href=""><img src="../static/images/edit.svg" alt=""></a>
                <a href=""><img src="../static/images/show.svg" alt=""></a>
            </div>
        </dialog>
        `

        $('body').append(contenue);
        var dialog = document.getElementById('showImg');
        dialog.showModal();

        $('#cancel').on('click', function () {
            dialog.close();
            dialog.remove();
            return;
        });

        //Les annotations
        if (data['annotations'] && data['annotations'].length !== 0) {
            let annotZonne = $('#imgZonne');
            let image = $('#imgZonne_img');
            image.on('load', function () {
                let imageDimensions = {
                    width: image.width(),
                    height: image.height()
                };
                let realImageDimensions = {
                    width: image[0].naturalWidth,
                    height: image[0].naturalHeight
                };

                data['annotations'].forEach(function (annotation) {
                    let div = $('<div class="annot"></div>');

                    let start = translatePoint({ x: annotation.startX, y: annotation.startY }, realImageDimensions, imageDimensions);
                    let end = translatePoint({ x: annotation.endX, y: annotation.endY }, realImageDimensions, imageDimensions);

                    let offset = image.position();
                    let left = Math.min(start.x, end.x) + offset.left;
                    let top = Math.min(start.y, end.y) + offset.top;
                    let width = Math.abs(end.x - start.x);
                    let height = Math.abs(end.y - start.y);

                    div.css({
                        // "position": "absolute",
                        "left": left + "px",
                        "top": top + "px",
                        "width": width + "px",
                        "height": height + "px",
                        "pointerEvents": "auto"
                    });
                    div.on('mousemove', function (e) {
                        let tooltip = $('#annotation-tooltip');
                        if (tooltip.length === 0) {
                            tooltip = $('<div id="annotation-tooltip" class="tooltip"></div>');
                            $('body').append(tooltip);
                        }
                        tooltip.text(annotation['description']);
                        tooltip.css({
                            visibility: 'visible',
                            opacity: 1,
                            position: 'fixed',
                            left: (e.clientX - tooltip.outerWidth() / 2) + 'px',
                            top: (e.clientY - tooltip.outerHeight() - 10) + 'px',
                            zIndex: 9999,
                            pointerEvents: 'none'
                        });
                    });
                    div.on('mouseleave', function () {
                        $('#annotation-tooltip').css({
                            visibility: 'hidden',
                            opacity: 0
                        });
                    });
                    annotZonne.append(div);
                });
            });
        }

    });
}

// List dynamique
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