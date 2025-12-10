document.addEventListener("DOMContentLoaded", function () {
    const swiperBlock = document.querySelector(".mySwiper");
    if (!swiperBlock) return;

    // Подключаем CSS
    const swiperStyle = document.createElement("link");
    swiperStyle.rel = "stylesheet";
    swiperStyle.href = "/css/swiper-bundle.min.css";
    document.head.prepend(swiperStyle);

    // Подключаем JS
    const swiperScript = document.createElement("script");
    swiperScript.src = "/js/swiper-bundle.min.js";
    swiperScript.defer = true;

    swiperScript.onload = function () {
        new Swiper(".mySwiper", {
            navigation: {
                nextEl: ".swiper-button-next",
                prevEl: ".swiper-button-prev",
            },
            pagination: {
                el: ".swiper-pagination",
            },
        });
    };

    document.head.prepend(swiperScript);
});


document.addEventListener('DOMContentLoaded', function () {
    const body = document.body;
    const burger = document.querySelector('.menu-burger');
    const sideMenu = document.getElementById('side-menu');
    const overlay = document.querySelector('.menu-overlay');

    // Открыть меню
    if (burger) {
        burger.addEventListener('click', function () {
            body.classList.add('is-menu-open');
            sideMenu.setAttribute('aria-hidden', 'false');
        });
    }

    // Закрыть меню по клику на оверлей или любой элемент с [data-close]
    [overlay, ...document.querySelectorAll('[data-close]')].forEach(el => {
        if (!el) return;
        el.addEventListener('click', function () {
            body.classList.remove('is-menu-open');
            sideMenu.setAttribute('aria-hidden', 'true');
        });
    });

    // Аккордеон
    document.querySelectorAll('.menu__acc .acc__btn').forEach(btn => {
        btn.addEventListener('click', function () {
            const acc = btn.closest('.menu__acc');
            const panel = acc.querySelector('.acc__panel');

            const isOpen = acc.classList.contains('open');
            acc.classList.toggle('open', !isOpen);

            if (isOpen) {
                panel.setAttribute('hidden', 'hidden');
                btn.setAttribute('aria-expanded', 'false');
            } else {
                panel.removeAttribute('hidden');
                btn.setAttribute('aria-expanded', 'true');
            }
        });
    });
});
