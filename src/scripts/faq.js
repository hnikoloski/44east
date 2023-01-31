jQuery(document).ready(function ($) {
    $('.ffeast-faq-block .accordion-item .icon').on('click', function (e) {
        e.preventDefault();
        $(this).toggleClass('active');
        $(this).parent().siblings().slideToggle();
    });
});