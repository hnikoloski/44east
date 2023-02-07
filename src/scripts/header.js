jQuery(document).ready(function ($) {
    // $("#page").css("padding-top", $("#masthead").outerHeight());
    // $(window).scroll(function () {
    //     var sticky = $("#masthead .top-bar"),
    //         scroll = $(window).scrollTop();

    //     if (scroll >= 100) {
    //         sticky.slideUp();
    //         if ($(window).width() > 768) {
    //             $("#to-top").slideDown();
    //         }
    //         $("#masthead").addClass("sticky");
    //     } else {
    //         sticky.slideDown();
    //         if ($(window).width() > 768) {
    //             $("#to-top").slideUp();
    //         }
    //         $("#masthead").removeClass("sticky");
    //     }
    // });
    $('.lang-switcher p').on('click', function (e) {
        e.preventDefault();
        $(this).parent().toggleClass('active');
    })

    if ($(window).width() <= 768) {
        // Get the #site-navigation and .lang-switcher elements and wrap them in a div
        var nav = $('#site-navigation');
        var lang = $('.lang-switcher');
        var wrapper = $('<div class="mobile-nav-wrapper"></div>');
        // Wrap both elements in the same div
        nav.add(lang).wrapAll(wrapper);

        $('#menu-trigger').on('click', function (e) {
            e.preventDefault();
            $(this).toggleClass('active');
            $('body').toggleClass('overflow-hidden');
            $('.mobile-nav-wrapper, .mobile-nav-wrapper').toggleClass('active');
        });
    }
});
