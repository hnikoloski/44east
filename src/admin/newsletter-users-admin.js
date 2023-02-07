jQuery(document).ready(function ($) {
    $('#deleteNewsLettersBtn').on('click', function (e) {
        e.preventDefault();
        // Append a popup to the body
        $('body').append('<div class="deletePopup"><div class="popup-content"><h3>Are you sure you want to delete all newsletter users?</h3><div class="popup-btns"><button class="button button-primary" id="confirmDeleteNewsLetters">Yes</button><button class="button button-secondary" id="cancelDeleteNewsLetters">No</button></div></div></div>');
    });

    $('body').on('click', '#cancelDeleteNewsLetters', function (e) {
        e.preventDefault();
        $('.deletePopup').remove();
    })

    $('body').on('click', '#confirmDeleteNewsLetters', function (e) {
        e.preventDefault();
        $('#deleteNewsLetters').submit();
    })

});

