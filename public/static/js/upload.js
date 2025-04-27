function previewImage() {
    const file = $('input[type=file]')[0].files[0];
    const preview = $('#imagePreview');
    if (file) {
        const reader = new FileReader();
        reader.onload = function (e) {
            preview.attr('src', e.target.result).show();
        };
        reader.readAsDataURL(file);
    }
}
$(document).ready(function () {
    $('#fileInput').on('change', function () {
        previewImage();
    });
    $('form').on('submit', function (event) {
        event.preventDefault();
    });
    $('#add_tag').on('click', function (event) {
        console.log("test");
        var name = $('#name_add_tag').val();
        if (name !== "") {
            addTagList(name, '#selected_tag');
        }
        $('#name_add_tag').val('');
    })
    $('input[type="submit"]').on('click', function (event) {
        let now = new Date();
        let formattedDate = now.getFullYear() + '-' +
            String(now.getMonth() + 1).padStart(2, '0') + '-' +
            String(now.getDate()).padStart(2, '0') + ' ' +
            String(now.getHours()).padStart(2, '0') + ':' +
            String(now.getMinutes()).padStart(2, '0') + ':' +
            String(now.getSeconds()).padStart(2, '0');
        $("form").append('<input type="hidden" name="date" id="date" value="' + formattedDate + '">')
        $(event.target).closest("form").off('submit').submit();
    })
    $('#name_add_tag').on('keypress', function (event) {
        if (event.which == 13) {
            event.preventDefault();
            console.log("add");
            var name = $(this).val();
            if (name !== "") {
                addTagList($(this).val(), '#selected_tag')
            }
            $(this).val('');
        }
    })
});