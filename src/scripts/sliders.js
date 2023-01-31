import Swiper, { Autoplay, Navigation } from 'swiper';
jQuery(document).ready(function ($) {
    const swiper = new Swiper('.testimonials-swiper .swiper', {
        slidesPerView: 1,
        spaceBetween: 0,
        modules: [Navigation],
        navigation: {
            nextEl: '.testimonials-swiper .swiper-button-next',
            prevEl: '.testimonials-swiper .swiper-button-prev',
        },

    });

    const partnersSwiper = new Swiper('#our-partners .swiper', {
        slidesPerView: 9,
        spaceBetween: 70,
        modules: [Autoplay],
        autoplay: {
            delay: 5000,
            disableOnInteraction: false,
        },

    });
});