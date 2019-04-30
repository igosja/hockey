<!DOCTYPE html>
<html lang="uk">
<head>
    <script src="//ajax.googleapis.com/ajax/libs/jquery/1.11.0/jquery.min.js"></script>
    <script src="//maps.googleapis.com/maps/api/js?v=3.exp&language=uk"></script>
    <title>Карта</title>
</head>
<body>
<style>
    html, body {
        height: 100%;
    }

    #map {
        width: 100%;
        height: 100%;
    }
</style>
<div id="map"></div>
<script>
    function initialize(lat, lng) {
        var myLatlng = new google.maps.LatLng(lat, lng);
        var mapOptions = {
            zoom: 6,
            center: myLatlng
        };
        var map = new google.maps.Map(document.getElementById('map'), mapOptions);
        var marker = [
            new google.maps.Marker({
                position: new google.maps.LatLng(48.713611, 32.673333), //Знам'янка
                map: map
            }),
            new google.maps.Marker({
                position: new google.maps.LatLng(49.0525, 33.205), //Світловодськ
                map: map
            }),
            new google.maps.Marker({
                position: new google.maps.LatLng(48.478056, 34.028056), //Вільногірськ
                map: map
            }),
            new google.maps.Marker({
                position: new google.maps.LatLng(48.366389, 33.5025), //Жовті Води
                map: map
            }),
            new google.maps.Marker({
                position: new google.maps.LatLng(48.528889, 34.596944), //Кам'янське
                map: map
            }),
            new google.maps.Marker({
                position: new google.maps.LatLng(47.644722, 34.604167), //Марганець
                map: map
            }),
            new google.maps.Marker({
                position: new google.maps.LatLng(47.577222, 34.3575), //Нікополь
                map: map
            }),
            new google.maps.Marker({
                position: new google.maps.LatLng(48.637778, 35.228611), //Новомосковськ
                map: map
            }),
            new google.maps.Marker({
                position: new google.maps.LatLng(48.52, 35.87), //Павлоград
                map: map
            }),
            new google.maps.Marker({
                position: new google.maps.LatLng(47.653333, 34.084167), //Покров
                map: map
            }),
            new google.maps.Marker({
                position: new google.maps.LatLng(48.3475, 36.401667), //Першотравенськ
                map: map
            }),
            new google.maps.Marker({
                position: new google.maps.LatLng(48.3112, 35.5119), //Синельникове
                map: map
            }),
            new google.maps.Marker({
                position: new google.maps.LatLng(48.524444, 36.0825), //Тернівка
                map: map
            }),
            new google.maps.Marker({
                position: new google.maps.LatLng(49.3805, 36.214), //Первомайський
                map: map
            }),
            new google.maps.Marker({
                position: new google.maps.LatLng(49.195833, 37.280278), //Ізюм
                map: map
            }),
            new google.maps.Marker({
                position: new google.maps.LatLng(49.7002, 37.6165), //Куп'янськ
                map: map
            }),
            new google.maps.Marker({
                position: new google.maps.LatLng(48.8827, 36.316), //Лозова
                map: map
            }),
            new google.maps.Marker({
                position: new google.maps.LatLng(49.948333, 35.929444), //Люботин
                map: map
            }),
            new google.maps.Marker({
                position: new google.maps.LatLng(51.344444, 25.850833), //Вараш
                map: map
            }),
            new google.maps.Marker({
                position: new google.maps.LatLng(50.393056, 25.735), //Дубно
                map: map
            }),
            new google.maps.Marker({
                position: new google.maps.LatLng(50.2938, 26.8667), //Славута
                map: map
            }),
            new google.maps.Marker({
                position: new google.maps.LatLng(49.753889, 27.220278), //Старокостянтинів
                map: map
            }),
            new google.maps.Marker({
                position: new google.maps.LatLng(50.3237, 26.6401), //Нетішин
                map: map
            }),
            new google.maps.Marker({
                position: new google.maps.LatLng(50.177, 27.0665), //Шепетівка
                map: map
            }),
            new google.maps.Marker({
                position: new google.maps.LatLng(49.446111, 24.938611), //Бережани
                map: map
            }),
            new google.maps.Marker({
                position: new google.maps.LatLng(50.101111, 25.736667), //Кременець
                map: map
            }),
            new google.maps.Marker({
                position: new google.maps.LatLng(49.0075, 25.790556), //Чортків
                map: map
            }),
            new google.maps.Marker({
                position: new google.maps.LatLng(49.289167, 23.418889), //Борислав
                map: map
            }),
            new google.maps.Marker({
                position: new google.maps.LatLng(49.3436, 23.5001), //Дрогобич
                map: map
            }),
            new google.maps.Marker({
                position: new google.maps.LatLng(49.154722, 23.868611), //Моршин
                map: map
            }),
            new google.maps.Marker({
                position: new google.maps.LatLng(49.470278, 24.129722), //Новий Розділ
                map: map
            }),
            new google.maps.Marker({
                position: new google.maps.LatLng(49.5104, 23.2), //Самбір
                map: map
            }),
            new google.maps.Marker({
                position: new google.maps.LatLng(49.2437, 23.8499), //Стрий
                map: map
            }),
            new google.maps.Marker({
                position: new google.maps.LatLng(49.2715, 23.5077), //Трускавець
                map: map
            }),
            new google.maps.Marker({
                position: new google.maps.LatLng(50.386667, 24.228889), //Червоноград
                map: map
            }),
            new google.maps.Marker({
                position: new google.maps.LatLng(50.848056, 24.322222), //Володимир-Волинський
                map: map
            }),
            new google.maps.Marker({
                position: new google.maps.LatLng(50.726944, 24.165), //Нововолинськ
                map: map
            }),
            new google.maps.Marker({
                position: new google.maps.LatLng(47.5725, 31.311944), //Вознесенськ
                map: map
            }),
            new google.maps.Marker({
                position: new google.maps.LatLng(48.043889, 30.85), //Первомайськ
                map: map
            }),
            new google.maps.Marker({
                position: new google.maps.LatLng(47.821667, 31.175), //Южноукраїнськ
                map: map
            }),
            new google.maps.Marker({
                position: new google.maps.LatLng(46.522778, 32.515833), //Гола Пристань
                map: map
            }),
            new google.maps.Marker({
                position: new google.maps.LatLng(46.797778, 33.475), //Каховка
                map: map
            }),
            new google.maps.Marker({
                position: new google.maps.LatLng(46.751111, 33.360556), //Нова Каховка
                map: map
            }),
            new google.maps.Marker({
                position: new google.maps.LatLng(49.556944, 27.957222), //Хмільник
                map: map
            }),
            new google.maps.Marker({
                position: new google.maps.LatLng(49.0425, 28.099167), //Жмеринка
                map: map
            }),
            new google.maps.Marker({
                position: new google.maps.LatLng(49.716667, 28.833333), //Козятин
                map: map
            }),
            new google.maps.Marker({
                position: new google.maps.LatLng(48.689722, 29.241667), //Ладижин
                map: map
            }),
            new google.maps.Marker({
                position: new google.maps.LatLng(48.455, 27.808056), //Могилів-Подільський
                map: map
            }),
            new google.maps.Marker({
                position: new google.maps.LatLng(48.5758, 27.437), //Новодністровськ
                map: map
            }),
            new google.maps.Marker({
                position: new google.maps.LatLng(49.2103, 31.8665), //Сміла
                map: map
            }),
            new google.maps.Marker({
                position: new google.maps.LatLng(49.744722, 31.455833), //Канів
                map: map
            }),
            new google.maps.Marker({
                position: new google.maps.LatLng(49.668889, 32.0475), //Золотоноша
                map: map
            }),
            new google.maps.Marker({
                position: new google.maps.LatLng(49.0103, 31.0666), //Ватутіне
                map: map
            }),
            new google.maps.Marker({
                position: new google.maps.LatLng(49.066944, 23.851389), //Болехів
                map: map
            }),
            new google.maps.Marker({
                position: new google.maps.LatLng(49.262222, 24.627778), //Бурштин
                map: map
            }),
            new google.maps.Marker({
                position: new google.maps.LatLng(49.044167, 24.359722), //Калуш
                map: map
            }),
            new google.maps.Marker({
                position: new google.maps.LatLng(48.4537, 24.5586), //Яремче
                map: map
            }),
            new google.maps.Marker({
                position: new google.maps.LatLng(46.759786, 36.7845), //Бердянськ
                map: map
            }),
            new google.maps.Marker({
                position: new google.maps.LatLng(47.498889, 34.655833), //Енергодар
                map: map
            }),
            new google.maps.Marker({
                position: new google.maps.LatLng(47.2423, 35.7032), //Токмак
                map: map
            }),
            new google.maps.Marker({
                position: new google.maps.LatLng(51.2309, 33.2027), //Конотоп
                map: map
            }),
            new google.maps.Marker({
                position: new google.maps.LatLng(50.576667, 34.481944), //Лебедин
                map: map
            }),
            new google.maps.Marker({
                position: new google.maps.LatLng(50.313333, 34.898889), //Охтирка
                map: map
            }),
            new google.maps.Marker({
                position: new google.maps.LatLng(50.7366, 33.488), //Ромни
                map: map
            }),
            new google.maps.Marker({
                position: new google.maps.LatLng(52.008611, 33.273611), //Новгород-Сіверський
                map: map
            }),
            new google.maps.Marker({
                position: new google.maps.LatLng(47.94, 29.621944), //Балта
                map: map
            }),
            new google.maps.Marker({
                position: new google.maps.LatLng(46.48275, 30.201389), //Біляївка
                map: map
            }),
            new google.maps.Marker({
                position: new google.maps.LatLng(45.360056, 28.8125), //Ізмаїл
                map: map
            }),
            new google.maps.Marker({
                position: new google.maps.LatLng(47.741944, 29.535), //Подільськ
                map: map
            }),
            new google.maps.Marker({
                position: new google.maps.LatLng(46.4969, 30.3243), //Теплодар
                map: map
            }),
            new google.maps.Marker({
                position: new google.maps.LatLng(46.301667, 30.656944), //Чорноморськ
                map: map
            }),
            new google.maps.Marker({
                position: new google.maps.LatLng(46.623611, 31.101111), //Южне
                map: map
            }),
            new google.maps.Marker({
                position: new google.maps.LatLng(50.367222, 33.988889), //Гадяч
                map: map
            }),
            new google.maps.Marker({
                position: new google.maps.LatLng(49.044722, 33.588611), //Горішні Плавні
                map: map
            }),
            new google.maps.Marker({
                position: new google.maps.LatLng(50.016111, 32.988611), //Лубни
                map: map
            }),
            new google.maps.Marker({
                position: new google.maps.LatLng(49.965833, 33.611389), //Миргород
                map: map
            }),
            new google.maps.Marker({
                position: new google.maps.LatLng(48.430833, 22.211944), //Чоп
                map: map
            }),
            new google.maps.Marker({
                position: new google.maps.LatLng(48.174167, 23.289722), //Хуст
                map: map
            }),
            new google.maps.Marker({
                position: new google.maps.LatLng(48.2025, 22.6375), //Берегове
                map: map
            }),
            new google.maps.Marker({
                position: new google.maps.LatLng(50.3075, 31.485), //Березань
                map: map
            }),
            new google.maps.Marker({
                position: new google.maps.LatLng(50.351111, 30.950833), //Бориспіль
                map: map
            }),
            new google.maps.Marker({
                position: new google.maps.LatLng(50.511389, 30.790278), //Бровари
                map: map
            }),
            new google.maps.Marker({
                position: new google.maps.LatLng(50.546389, 30.235), //Буча
                map: map
            }),
            new google.maps.Marker({
                position: new google.maps.LatLng(50.186389, 30.330556), //Васильків
                map: map
            }),
            new google.maps.Marker({
                position: new google.maps.LatLng(50.519444, 30.244722), //Ірпінь
                map: map
            }),
            new google.maps.Marker({
                position: new google.maps.LatLng(50.13, 30.656667), //Обухів
                map: map
            }),
            new google.maps.Marker({
                position: new google.maps.LatLng(50.066111, 31.442222), //Переяслав-Хмельницький
                map: map
            }),
            new google.maps.Marker({
                position: new google.maps.LatLng(49.9549, 31.0436), //Ржищів
                map: map
            }),
            new google.maps.Marker({
                position: new google.maps.LatLng(51.5225, 30.718056), //Славутич
                map: map
            }),
            new google.maps.Marker({
                position: new google.maps.LatLng(50.0685, 29.9182), //Фастів
                map: map
            }),
            new google.maps.Marker({
                position: new google.maps.LatLng(50.583333, 27.620278), //Новоград-Волинський
                map: map
            }),
            new google.maps.Marker({
                position: new google.maps.LatLng(49.891944, 28.6), //Бердичів
                map: map
            }),
            new google.maps.Marker({
                position: new google.maps.LatLng(44.593, 33.5334), //Севастополь
                map: map
            }),
            new google.maps.Marker({
                position: new google.maps.LatLng(44.669167, 34.403056), //Алушта
                map: map
            }),
            new google.maps.Marker({
                position: new google.maps.LatLng(46.111389, 33.691667), //Армянськ
                map: map
            }),
            new google.maps.Marker({
                position: new google.maps.LatLng(45.709444, 34.393333), //Джанкой
                map: map
            }),
            new google.maps.Marker({
                position: new google.maps.LatLng(45.2, 33.366667), //Євпаторія
                map: map
            }),
            new google.maps.Marker({
                position: new google.maps.LatLng(45.35, 36.466667), //Керч
                map: map
            }),
            new google.maps.Marker({
                position: new google.maps.LatLng(45.954167, 33.791944), //Красноперекопськ
                map: map
            }),
            new google.maps.Marker({
                position: new google.maps.LatLng(45.133333, 33.6), //Саки
                map: map
            }),
            new google.maps.Marker({
                position: new google.maps.LatLng(44.95, 34.1), //Сімферополь
                map: map
            }),
            new google.maps.Marker({
                position: new google.maps.LatLng(44.85, 34.966667), //Судак
                map: map
            }),
            new google.maps.Marker({
                position: new google.maps.LatLng(45.0419, 35.3791), //Феодосія
                map: map
            }),
            new google.maps.Marker({
                position: new google.maps.LatLng(44.492, 34.1699), //Ялта
                map: map
            }),
            new google.maps.Marker({
                position: new google.maps.LatLng(48.134722, 37.744444), //Авдіївка
                map: map
            }),
            new google.maps.Marker({
                position: new google.maps.LatLng(48.604444, 38.006667), //Бахмут
                map: map
            }),
            new google.maps.Marker({
                position: new google.maps.LatLng(47.779167, 37.248333), //Вугледар
                map: map
            }),
            new google.maps.Marker({
                position: new google.maps.LatLng(48.333611, 38.0925), //Горлівка
                map: map
            }),
            new google.maps.Marker({
                position: new google.maps.LatLng(48.341111, 38.427778), //Дебальцеве
                map: map
            }),
            new google.maps.Marker({
                position: new google.maps.LatLng(48.468889, 37.082778), //Добропілля
                map: map
            }),
            new google.maps.Marker({
                position: new google.maps.LatLng(47.751944, 37.678333), //Докучаєвськ
                map: map
            }),
            new google.maps.Marker({
                position: new google.maps.LatLng(48.008889, 37.804167), //Донецьк
                map: map
            }),
            new google.maps.Marker({
                position: new google.maps.LatLng(48.6137, 37.5279), //Дружківка
                map: map
            }),
            new google.maps.Marker({
                position: new google.maps.LatLng(48.231111, 38.205278), //Єнакієве
                map: map
            }),
            new google.maps.Marker({
                position: new google.maps.LatLng(48.1375, 38.260833), //Жданівка
                map: map
            }),
            new google.maps.Marker({
                position: new google.maps.LatLng(48.526667, 37.704167), //Костянтинівка
                map: map
            }),
            new google.maps.Marker({
                position: new google.maps.LatLng(48.720833, 37.555556), //Краматорськ
                map: map
            }),
            new google.maps.Marker({
                position: new google.maps.LatLng(48.985278, 37.811111), //Лиман
                map: map
            }),
            new google.maps.Marker({
                position: new google.maps.LatLng(48.055556, 37.961111), //Макіївка
                map: map
            }),
            new google.maps.Marker({
                position: new google.maps.LatLng(47.1158, 37.5787), //Маріуполь
                map: map
            }),
            new google.maps.Marker({
                position: new google.maps.LatLng(48.2956, 37.2615), //Мирноград
                map: map
            }),
            new google.maps.Marker({
                position: new google.maps.LatLng(48.2, 37.339444), //Новогродівка
                map: map
            }),
            new google.maps.Marker({
                position: new google.maps.LatLng(48.280833, 37.179444), //Покровськ
                map: map
            }),
            new google.maps.Marker({
                position: new google.maps.LatLng(48.15, 37.303889), //Селидове
                map: map
            }),
            new google.maps.Marker({
                position: new google.maps.LatLng(48.8635, 37.6251), //Слов'янськ
                map: map
            }),
            new google.maps.Marker({
                position: new google.maps.LatLng(48.039444, 38.768056), //Сніжне
                map: map
            }),
            new google.maps.Marker({
                position: new google.maps.LatLng(48.391667, 37.873333), //Торецьк
                map: map
            }),
            new google.maps.Marker({
                position: new google.maps.LatLng(48.042778, 38.1425), //Харцизьк
                map: map
            }),
            new google.maps.Marker({
                position: new google.maps.LatLng(48.146389, 38.360556), //Хрестівка
                map: map
            }),
            new google.maps.Marker({
                position: new google.maps.LatLng(48.027, 38.6214), //Чистякове
                map: map
            }),
            new google.maps.Marker({
                position: new google.maps.LatLng(48.0625, 38.416944), //Шахтарськ
                map: map
            }),
            new google.maps.Marker({
                position: new google.maps.LatLng(48.1213, 37.8627), //Ясинувата
                map: map
            }),
            new google.maps.Marker({
                position: new google.maps.LatLng(48.480278, 38.797778), //Алчевськ
                map: map
            }),
            new google.maps.Marker({
                position: new google.maps.LatLng(48.129722, 39.104167), //Антрацит
                map: map
            }),
            new google.maps.Marker({
                position: new google.maps.LatLng(48.484722, 38.677778), //Брянка
                map: map
            }),
            new google.maps.Marker({
                position: new google.maps.LatLng(48.058333, 39.658333), //Довжанськ
                map: map
            }),
            new google.maps.Marker({
                position: new google.maps.LatLng(48.6375, 38.643333), //Голубівка
                map: map
            }),
            new google.maps.Marker({
                position: new google.maps.LatLng(48.127222, 38.919167), //Хрустальний
                map: map
            }),
            new google.maps.Marker({
                position: new google.maps.LatLng(48.299167, 39.749722), //Сорокине
                map: map
            }),
            new google.maps.Marker({
                position: new google.maps.LatLng(48.89, 38.43), //Лисичанськ
                map: map
            }),
            new google.maps.Marker({
                position: new google.maps.LatLng(48.568333, 39.308611), //Луганськ
                map: map
            }),
            new google.maps.Marker({
                position: new google.maps.LatLng(48.629722, 38.561944), //Первомайськ
                map: map
            }),
            new google.maps.Marker({
                position: new google.maps.LatLng(48.071111, 39.342778), //Ровеньки
                map: map
            }),
            new google.maps.Marker({
                position: new google.maps.LatLng(49.0103, 38.3667), //Рубіжне
                map: map
            }),
            new google.maps.Marker({
                position: new google.maps.LatLng(48.9436, 38.4834), //Сєвєродонецьк
                map: map
            }),
            new google.maps.Marker({
                position: new google.maps.LatLng(48.568056, 38.658611), //Кадіївка
                map: map
            }),
        ];
        marker.setMap(map);
    }

    jQuery(document).ready(function ($) {
        var map_div = $("#map");
        if (map_div.length) {
            initialize(48.5505313, 30.6270735);
        }
    });
</script>
</body>
</html>