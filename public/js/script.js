// Тоггл меню
const html = document.documentElement;
const burger = document.querySelector('.burger-menu');
const sideMenu = document.getElementById('side-menu');
const overlay = document.querySelector('.menu-overlay');
const close_filter = document.getElementById('filterClose');

function openMenu(){
    html.classList.add('is-menu-open');
    burger.setAttribute('aria-expanded','true');
    sideMenu.setAttribute('aria-hidden','false');
    sideMenu.focus?.();
}
function closeMenu(){
    html.classList.remove('is-menu-open');
    burger.setAttribute('aria-expanded','false');
    sideMenu.setAttribute('aria-hidden','true');
}
burger.addEventListener('click', ()=>{
    const isOpen = html.classList.contains('is-menu-open');
    isOpen ? closeMenu() : openMenu();
});
overlay.addEventListener('click', closeMenu);
overlay.addEventListener('click', closeFilter);
close_filter.addEventListener('click', closeFilter);
document.addEventListener('keydown', (e)=>{
    if(e.key === 'Escape') closeMenu();
});

const filterBtns = document.querySelectorAll('.filter-btn');
const filterPanel = document.getElementById('filter');

function openFilter(){
    html.classList.add('is-filter-open');
    filterPanel.setAttribute('aria-hidden','false');
    filterPanel.focus?.();
}
function closeFilter(){
    html.classList.remove('is-filter-open');
    filterPanel.setAttribute('aria-hidden','true');
}

// Открытие фильтра по клику на кнопку(ы)
filterBtns.forEach(btn => {
    btn.addEventListener('click', () => {
        const isOpen = html.classList.contains('is-filter-open');
        isOpen ? closeFilter() : openFilter();
    });
});

// Закрытие по Esc
document.addEventListener('keydown', (e)=>{
    if(e.key === 'Escape') {
        closeFilter();
        closeMenu(); // на случай если оба открыты
    }
});

// Аккордеоны (без <details>)
document.querySelectorAll('.acc__btn').forEach((btn)=>{
    const panel = btn.nextElementSibling;
    btn.addEventListener('click', ()=>{
        const expanded = btn.getAttribute('aria-expanded') === 'true';
        // сворачиваем все остальные (аккордеон-режим)
        document.querySelectorAll('.acc__btn[aria-expanded="true"]').forEach(b=>{
            if(b!==btn){ b.setAttribute('aria-expanded','false'); b.nextElementSibling.hidden = true; }
        });
        btn.setAttribute('aria-expanded', String(!expanded));
        panel.hidden = expanded;
    });
});

function call(object) {
    const id = object.getAttribute('data-id');
    const city = object.getAttribute('data-city');
    const phone = object.getAttribute('data-phone');

    if (phone) {
        window.location.href = 'tel:+' + phone;
        return;
    }

    const token = document.querySelector('meta[name="csrf-token"]')?.getAttribute('content');

    fetch('/phone', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/x-www-form-urlencoded',
            'X-CSRF-TOKEN': token
        },
        body: `id=${encodeURIComponent(id)}&city=${encodeURIComponent(city)}`,
        cache: 'no-cache'
    })
        .then(response => {
            if (!response.ok) throw new Error(`HTTP error! status: ${response.status}`);
            return response.text();
        })
        .then(data => {
            if (data) {
                const formatted = formatPhone(data);
                object.textContent = formatted;
                object.setAttribute('data-phone', data);
                window.location.href = 'tel:+' + data;
            } else {
                console.warn('Пустой ответ от сервера');
            }
        })
        .catch(error => {
            console.error('Ошибка запроса:', error);
        });
}

function formatPhone(phone) {
    // Оставляем только цифры
    let digits = phone.replace(/\D/g, '');

    // Приводим к формату +7
    if (digits.startsWith('8')) {
        digits = '7' + digits.slice(1);
    }
    if (!digits.startsWith('7')) {
        digits = '7' + digits;
    }

    // Форматируем красиво
    if (digits.length === 11) {
        return digits.replace(/(\d)(\d{3})(\d{3})(\d{2})(\d{2})/, '+$1 ($2) $3-$4-$5');
    } else if (digits.length === 10) {
        return digits.replace(/(\d{3})(\d{3})(\d{2})(\d{2})/, '+7 ($1) $2-$3-$4');
    }

    // Если длина не совпала — просто возвращаем как есть
    return '+' + digits;
}

document.addEventListener("DOMContentLoaded", () => {
    const targets = document.querySelectorAll(".more-posts");
    if (!targets.length) return;

    const observer = new IntersectionObserver((entries) => {
        entries.forEach(entry => {
            if (entry.isIntersecting) {
                // передаём конкретный блок, который пересёк видимую область
                getMorePosts(entry.target);
            }
        });
    }, {
        root: null,
        threshold: 0.1 // срабатывает при 10% видимости блока
    });

    targets.forEach(el => observer.observe(el));
});

function getMorePosts(button) {
    const url = button.getAttribute('data-url');
    const token = document.querySelector('meta[name="csrf-token"]').getAttribute('content');

    fetch(url, {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': token
        },
        credentials: 'same-origin', // сохраняет куки
    })
        .then(response => response.text())
        .then(text => {
            let data;

            try {
                data = JSON.parse(text);
            } catch (e) {
                console.error('Ошибка парсинга JSON:', e);
                return;
            }

            if (data) {
                window.history.pushState('', document.title, url);

                if (data.posts) {
                    document.querySelector('.posts').insertAdjacentHTML('beforeend', data.posts);
                }

                if (data.next_page) {
                    button.setAttribute('data-url', data.next_page);
                } else {
                    button.remove();
                }
            }
        })
        .catch(error => {
            console.error('Ошибка при запросе:', error);
        });
}

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

document.addEventListener("DOMContentLoaded", function () {
    const mapElement = document.getElementById("map");

    // Если блока нет — ничего не делаем
    if (!mapElement) return;

    // Загружаем скрипт Яндекс.Карт
    const script = document.createElement("script");
    script.src = "https://api-maps.yandex.ru/2.1/?lang=ru_RU";
    script.type = "text/javascript";
    script.onload = function () {
        const lng = parseFloat(mapElement.dataset.y);
        const lat = parseFloat(mapElement.dataset.x);

        if (isNaN(lat) || isNaN(lng)) return;

        ymaps.ready(function () {
            const myMap = new ymaps.Map("map", {
                center: [lat, lng],
                zoom: 12
            });

            const myPlacemark = new ymaps.Placemark([lat, lng], {
                hintContent: 'Продавец'
            });

            myMap.geoObjects.add(myPlacemark);
        });
    };

    document.head.appendChild(script);
});

document.addEventListener("DOMContentLoaded", function () {
    // Проверка наличия хотя бы одного блока слайдера
    const ids = ['age', 'ves', 'grud', 'price'];
    const hasSlider = ids.some(id => document.getElementById(id));

    if (!hasSlider) return;

    // Подключение CSS
    const css = document.createElement('link');
    css.rel = 'stylesheet';
    css.href = '/css/nouislider.min.css';
    document.head.prepend(css);

    // Функция динамического подключения скриптов
    function loadScript(src) {
        return new Promise((resolve, reject) => {
            const script = document.createElement('script');
            script.src = src;
            script.defer = true;
            script.onload = resolve;
            script.onerror = reject;
            document.head.prepend(script);
        });
    }

    // Загружаем оба скрипта и после инициализируем слайдеры
    Promise.all([
        loadScript('/js/nouislider.min.js'),
        loadScript('/js/wNumb.min.js')
    ]).then(() => {
        // Вызываем createSlider только после полной загрузки скриптов
        createSlider('age', 'age-from', 'age-to', 18, 80, 1, '', '', true);
        createSlider('ves', 'ves-from', 'ves-to', 40, 100, 1, ' кг');
        createSlider('grud', 'grud-from', 'grud-to', 0, 8, 1, ' размер');
        createSlider('price', 'price-from', 'price-to', 1500, 50000, 100, ' ₽', ' ');
    }).catch(err => {
        console.error('Ошибка при загрузке скриптов:', err);
    });
});

function createSlider(sliderId, fromId, toId, min, max, step, suffix = '', thousandSeparator = '', useCustomFormat = false) {
    var slider = document.getElementById(sliderId);

    var formatOptions = useCustomFormat ? {
        to: function (value) {
            return ageSuffix(value);
        },
        from: function (value) {
            return Number(value.replace(/[^0-9]/g, ''));
        }
    } : wNumb({
        decimals: 0,
        thousand: thousandSeparator,
        suffix: suffix
    });

    noUiSlider.create(slider, {
        start: [
            document.getElementById(fromId).getAttribute('data-value'),
            document.getElementById(toId).getAttribute('data-value')
        ],
        connect: true,
        step: step,
        format: formatOptions,
        range: {
            'min': min,
            'max': max
        }
    });

    slider.noUiSlider.on('update', function (values) {
        document.getElementById(fromId).value = values[0];
        document.getElementById(toId).value = values[1];
    });
}

function ageSuffix(value) {
    value = parseInt(value);
    let mod10 = value % 10;
    let mod100 = value % 100;

    if (mod10 === 1 && mod100 !== 11) {
        return value + ' год';
    } else if (mod10 >= 2 && mod10 <= 4 && (mod100 < 10 || mod100 >= 20)) {
        return value + ' года';
    } else {
        return value + ' лет';
    }
}
