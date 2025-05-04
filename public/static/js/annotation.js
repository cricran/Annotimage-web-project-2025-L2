$(document).ready(function () {
    let imageArea = $('#image_area');
    let image = $('#image_selected');

    image.on('load', function () {
        let annoteArea = $('#annote_area');
        let imageDimensions = {
            width: image.width(),
            height: image.height()
        };
        let realImageDimensions = {
            width: image[0].naturalWidth,
            height: image[0].naturalHeight
        };

        //create canva
        imageArea.append('<canvas></canvas>')
        let canvas = imageArea.find('canvas').last();
        //init size as the same as the image
        canvas.attr('width', imageDimensions.width);
        canvas.attr('height', imageDimensions.height);
        canvas.css({
            width: imageDimensions.width + 'px',
            height: imageDimensions.height + 'px'
        });
        //move image in the canvas
        let ctx = canvas[0].getContext('2d');
        ctx.drawImage(image[0], 0, 0, imageDimensions.width, imageDimensions.height);
        ctx.fillStyle = "rgba(250, 100, 0, 0.5)";
        image.remove();

        //draw zonne
        var startX;
        var startY;
        var isDrawing = false;

        function startDrawing(e) {
            var rect = canvas[0].getBoundingClientRect();
            var clientX = e.type.startsWith('touch') ? e.originalEvent.touches[0].clientX : e.clientX;
            var clientY = e.type.startsWith('touch') ? e.originalEvent.touches[0].clientY : e.clientY;
            startX = clientX - rect.left;
            startY = clientY - rect.top;
            isDrawing = true;
        }

        function draw(e) {
            if (isDrawing) {
                var rect = canvas[0].getBoundingClientRect();
                var clientX = e.type.startsWith('touch') ? e.originalEvent.touches[0].clientX : e.clientX;
                var clientY = e.type.startsWith('touch') ? e.originalEvent.touches[0].clientY : e.clientY;
                var x = clientX - rect.left;
                var y = clientY - rect.top;
                var left = Math.min(startX, x);
                var top = Math.min(startY, y);
                var width = Math.abs(x - startX);
                var height = Math.abs(y - startY);
                ctx.clearRect(0, 0, canvas[0].width, canvas[0].height);
                ctx.drawImage(image[0], 0, 0, imageDimensions.width, imageDimensions.height);
                ctx.fillRect(left, top, width, height);
            }
        }

        function endDrawing(e) {
            if (isDrawing) {
                var rect = canvas[0].getBoundingClientRect();
                var clientX = e.type.startsWith('touch') ? e.originalEvent.changedTouches[0].clientX : e.clientX;
                var clientY = e.type.startsWith('touch') ? e.originalEvent.changedTouches[0].clientY : e.clientY;
                var x = clientX - rect.left;
                var y = clientY - rect.top;
                var left = Math.min(startX, x);
                var top = Math.min(startY, y);
                var width = Math.abs(x - startX);
                var height = Math.abs(y - startY);
                confirmDialogText('Donner un nom', 'Donner un nom à la sélection que vous venez de faire. C\'est le nom de votre annotation', function (value) {
                    $('#confirmDialog').remove();
                    if (value) {
                        let pStart = translatePoint({ x: startX, y: startY }, imageDimensions, realImageDimensions);
                        let pEnd = translatePoint({ x: x - startX, y: y - startY }, imageDimensions, realImageDimensions);
                        var annot = { name: value, start: pStart, end: pEnd }
                        annot = JSON.stringify(annot);
                        addAnnotList(value, '#annote_area', annot);
                    }
                    return;
                })
                ctx.clearRect(0, 0, canvas[0].width, canvas[0].height);
                ctx.drawImage(image[0], 0, 0, imageDimensions.width, imageDimensions.height);
                isDrawing = false;
            }
        }

        // souris event
        canvas.on('mousedown', startDrawing);
        canvas.on('mousemove', draw);
        canvas.on('mouseup', endDrawing);

        // tactile events
        canvas.on('touchstart', startDrawing);
        canvas.on('touchmove', draw);
        canvas.on('touchend', endDrawing);
    });
    if (image[0].complete) {
        image.trigger('load');
    }
});