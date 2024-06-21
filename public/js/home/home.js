import { updateCart } from "../script.js";

const SWIPER_OPTIONS = {
    slidesPerView: 4,
    spaceBetween: 10,
    breakpoints: {
        320: { slidesPerView: 2 },  // small devices
        // 768: { slidesPerView: 3 },  // medium-sized devices
        1024: { slidesPerView: 4 }, // larger devices
        1440: { slidesPerView: 5 }  // extra-large devices
    },
    navigation: {
        nextEl: '.swiper-button-next',
        prevEl: '.swiper-button-prev',
    },
};

new Swiper(".swiper-slide-categories", SWIPER_OPTIONS);

updateCart();