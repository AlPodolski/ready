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
