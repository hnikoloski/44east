jQuery(document).ready(function ($) {
    $('.single-jobs .site .hero a').on('click', function (e) {
        e.preventDefault();
        $('html, body').animate({
            scrollTop: $('.application-section').offset().top
        }, 200);

    });
});