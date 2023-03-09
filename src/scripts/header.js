jQuery(document).ready(function ($) {
    // $("#page").css("padding-top", $("#masthead").outerHeight());
    $(window).scroll(function () {
        var scroll = $(window).scrollTop();
        if (scroll >= 100) {
            $("#masthead").addClass("sticky");
        } else {
            $("#masthead").removeClass("sticky");
        }
    });
    // on window resize, run the function
    $(window).resize(function () {
        if ($(window).width() > 768) {
            if ($('.page-template-legal-page').length) {
                $('.page-template-legal-page .hero').css('margin-top', $('#masthead').outerHeight());
            }

        }
    }).resize(); // trigger the resize event on page load


    $('.lang-switcher p').on('click', function (e) {
        e.preventDefault();
        $(this).parent().toggleClass('active');
    })

    $(window).resize(function () {
        if ($(window).width() <= 768) {
            // Get the #site-navigation and .lang-switcher elements and wrap them in a div
            var nav = $('#site-navigation');
            var lang = $('.lang-switcher');
            var wrapper = $('<div class="mobile-nav-wrapper"></div>');
            // Wrap both elements in the same div if they are not already wrapped
            if (!nav.parent().hasClass('mobile-nav-wrapper')) {
                nav.add(lang).wrapAll(wrapper);
            }
            $('#menu-trigger').on('click', function (e) {
                e.preventDefault();
                $(this).toggleClass('active');
                $('body').toggleClass('overflow-hidden');
                $('.mobile-nav-wrapper, .mobile-nav-wrapper').toggleClass('active');
            });
        } else {
            //  Remove the wrapper div if the window is resized to desktop size
            if ($('#site-navigation').parent().hasClass('mobile-nav-wrapper')) {
                $('#site-navigation, .lang-switcher').unwrap();
            }



        }
    }).resize(); // trigger the resize event on page load
});
