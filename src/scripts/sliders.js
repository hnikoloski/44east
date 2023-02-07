import Swiper, { Autoplay, Navigation, Pagination } from 'swiper';
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
        breakpoints: {
            1024: {
                slidesPerView: 8,
                spaceBetween: 50,
            },
            768: {
                slidesPerView: 6,
                spaceBetween: 30,
            },
            640: {
                slidesPerView: 5,
                spaceBetween: 20,
            },
            320: {
                slidesPerView: 4,
                spaceBetween: 10,
            }
        }

    });

    // Mob Sliders and disables
    if ($(window).width() <= 768) {
        if ($('#featured-blogs').length) {
            let slideTarget = $('#featured-blogs .blogs-wrapper');
            slideTarget.addClass('swiper');
            // wrap each blog post in a div
            slideTarget.children().wrapAll('<div class="swiper-wrapper"></div>');
            // add swiper-slide class to each blog post
            slideTarget.children().children().addClass('swiper-slide');

            // Append pagination
            slideTarget.append('<div class="swiper-pagination"></div>');

            const featuredBlogsSwiper = new Swiper('#featured-blogs .swiper', {
                slidesPerView: 1.5,
                spaceBetween: 20,
                modules: [Pagination],
                // centeredSlides: true,
                // Add Some space after the last slide
                slidesOffsetAfter: 40,
                pagination: {
                    el: '.swiper-pagination',
                    clickable: true,
                },
            });




        }
    }
});