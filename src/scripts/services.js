jQuery(document).ready(function ($) {
    if ($('.ffeast-services-block .container .row .single-service').length) {
        // Put 2 single services in one div with a class services-row
        $('.ffeast-services-block .container .row .single-service').each(function (index) {
            if (index % 2 === 0) {
                $(this).next().andSelf().wrapAll('<div class="services-row"></div>');
            }
        });
    }
});