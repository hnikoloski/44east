jQuery(document).ready(function ($) {
    if ($(window).width() <= 768) {
        if ($('#our-services').length) {
            let btnTarget = $('#our-services .top-bar .btn');
            // Move the button to the bottom of the section
            btnTarget.appendTo('#our-services');
        }

        if ($('.home #our-services').length) {
            let theTitles = $('.home #our-services .services-wrapper .single-service .top h2');
            // Move theTitles to the single-service div
            theTitles.each(function () {
                $(this).prependTo($(this).parent().parent());
            });
        }
    }
});