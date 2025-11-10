// helper'ы
function createImg(src, link) {
    return `
    <a target="_blank" href="/post/${link}">
      <img src="${src}" class="yandex-map-img">
    </a>`;
}

function createBalloonContent(item) {
    return (
        createImg(item.avatar, item.url) + "<br>" +
        `<a href="tel:+${item.phone}" class="map-phone">${item.phone}</a><br>` +
        `<a target="_blank" class="map-link" href="${item.url}">Подробнее</a>` +
        `<div class="small-red-text">${item.price} р.</div>`
    );
}

// ждём готовности API Яндекс.Карт
ymaps.ready(initMapWithPosts);

function initMapWithPosts() {
    const myMap = new ymaps.Map("yandex-map", {
        center: [55.76, 37.64],
        zoom: 10
    }, {
        searchControlProvider: "yandex#search"
    });

    // берём JSON из .map-data (например <script type="application/json" class="map-data">...</script>)
    const mapDataEl = document.querySelector(".map-data");
    if (!mapDataEl) {
        console.warn("Элемент .map-data не найден");
        return;
    }

    let data = [];
    try {
        // textContent безопаснее, чем innerHTML
        data = JSON.parse(mapDataEl.textContent.trim() || "[]");
    } catch (e) {
        console.error("Не могу распарсить JSON в .map-data", e);
        return;
    }

    const presetName = "twirl#violetIcon";
    const points = data.map(item => new ymaps.GeoObject(
        {
            geometry: {type: "Point", coordinates: [item.x, item.y]},
            properties: {
                clusterCaption: item.name,
                hintContent: item.name,
                balloonContent: createBalloonContent(item)
            }
        },
        {preset: presetName}
    ));

    const clusterer = new ymaps.Clusterer({
        preset: "twirl#redClusterIcons",
        gridSize: 100
    });

    clusterer.add(points);
    myMap.geoObjects.add(clusterer);
}
