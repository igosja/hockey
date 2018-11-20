<!DOCTYPE html>
<html>
<head>
    <script src="//ajax.googleapis.com/ajax/libs/jquery/1.11.0/jquery.min.js"></script>
    <script src="//maps.googleapis.com/maps/api/js?v=3.exp&language=uk"></script>
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
        let myLatlng = new google.maps.LatLng(lat, lng);
        let mapOptions = {
            zoom: 6,
            center: myLatlng
        };
        let map = new google.maps.Map(document.getElementById('map'), mapOptions);
        let marker = [
            new google.maps.Marker({
                position: new google.maps.LatLng(51.404742, 30.055595), //Припять
                map: map
            }),
            new google.maps.Marker({
                position: new google.maps.LatLng(51.273951, 30.226863), //Чорнобиль
                map: map
            }),
            new google.maps.Marker({
                position: new google.maps.LatLng(48.669171, 33.117331), //Олександрія
                map: map
            }),
            new google.maps.Marker({
                position: new google.maps.LatLng(48.507083, 32.264202), //Кропивницький
                map: map
            }),
            new google.maps.Marker({
                position: new google.maps.LatLng(47.910408, 33.391706), //Кривий Ріг
                map: map
            }),
            new google.maps.Marker({
                position: new google.maps.LatLng(48.464187, 35.046566), //Дніпро
                map: map
            }),
            new google.maps.Marker({
                position: new google.maps.LatLng(49.835836, 36.686567), //Чугуїв
                map: map
            }),
            new google.maps.Marker({
                position: new google.maps.LatLng(49.987885, 36.231571), //Харків
                map: map
            }),
            new google.maps.Marker({
                position: new google.maps.LatLng(50.328045, 26.521886), //Острог
                map: map
            }),
            new google.maps.Marker({
                position: new google.maps.LatLng(50.619169, 26.252130), //Рівне
                map: map
            }),
            new google.maps.Marker({
                position: new google.maps.LatLng(48.689164, 26.579659), //Кам'янець-Подільський
                map: map
            }),
            new google.maps.Marker({
                position: new google.maps.LatLng(49.422815, 26.989420), //Хмельницький
                map: map
            }),
            new google.maps.Marker({
                position: new google.maps.LatLng(50.003700, 25.508912), //Почаїв
                map: map
            }),
            new google.maps.Marker({
                position: new google.maps.LatLng(49.550566, 25.589158), //Тернопіль
                map: map
            }),
            new google.maps.Marker({
                position: new google.maps.LatLng(49.964430, 24.894155), //Олесько
                map: map
            }),
            new google.maps.Marker({
                position: new google.maps.LatLng(49.843961, 24.025966), //Львів
                map: map
            }),
            new google.maps.Marker({
                position: new google.maps.LatLng(51.218192, 24.695277), //Ковель
                map: map
            }),
            new google.maps.Marker({
                position: new google.maps.LatLng(50.752370, 25.338809), //Луцьк
                map: map
            }),
            new google.maps.Marker({
                position: new google.maps.LatLng(46.617719, 31.537735), //Очаків
                map: map
            }),
            new google.maps.Marker({
                position: new google.maps.LatLng(46.966728, 32.003868), //Миколаїв
                map: map
            }),
            new google.maps.Marker({
                position: new google.maps.LatLng(46.623821, 32.721286), //Олешки
                map: map
            }),
            new google.maps.Marker({
                position: new google.maps.LatLng(46.634864, 32.619957), //Херсон
                map: map
            }),
            new google.maps.Marker({
                position: new google.maps.LatLng(49.235602, 28.485806), //Вінниця
                map: map
            }),
            new google.maps.Marker({
                position: new google.maps.LatLng(48.673435, 28.856218), //Тульчин
                map: map
            }),
            new google.maps.Marker({
                position: new google.maps.LatLng(48.293860, 25.938716), //Чернівці
                map: map
            }),
            new google.maps.Marker({
                position: new google.maps.LatLng(48.509610, 26.490794), //Хотин
                map: map
            }),
            new google.maps.Marker({
                position: new google.maps.LatLng(49.441373, 32.064454), //Черкаси
                map: map
            }),
            new google.maps.Marker({
                position: new google.maps.LatLng(48.758797, 30.216787), //Умань
                map: map
            }),
            new google.maps.Marker({
                position: new google.maps.LatLng(48.531018, 25.041839), //Коломия
                map: map
            }),
            new google.maps.Marker({
                position: new google.maps.LatLng(48.922243, 24.711977), //Івано-Франківськ
                map: map
            }),
            new google.maps.Marker({
                position: new google.maps.LatLng(46.853784, 35.364523), //Мелітополь
                map: map
            }),
            new google.maps.Marker({
                position: new google.maps.LatLng(47.838367, 35.136873), //Запоріжжя
                map: map
            }),
            new google.maps.Marker({
                position: new google.maps.LatLng(50.351244, 31.319146), //Баришівка
                map: map
            }),
            new google.maps.Marker({
                position: new google.maps.LatLng(50.907789, 34.799106), //Суми
                map: map
            }),
            new google.maps.Marker({
                position: new google.maps.LatLng(51.498110, 31.290536), //Чернігів
                map: map
            }),
            new google.maps.Marker({
                position: new google.maps.LatLng(51.037953, 31.885692), //Ніжин
                map: map
            }),
            new google.maps.Marker({
                position: new google.maps.LatLng(46.481643, 30.726198), //Одеса
                map: map
            }),
            new google.maps.Marker({
                position: new google.maps.LatLng(49.066292, 33.423388), //Кременчук
                map: map
            }),
            new google.maps.Marker({
                position: new google.maps.LatLng(49.588226, 34.551400), //Полтава
                map: map
            }),
            new google.maps.Marker({
                position: new google.maps.LatLng(48.448643, 22.709668), //Мукачево
                map: map
            }),
            new google.maps.Marker({
                position: new google.maps.LatLng(48.620498, 22.288776), //Ужгород
                map: map
            }),
            new google.maps.Marker({
                position: new google.maps.LatLng(50.450696, 30.529093), //Київ
                map: map
            }),
            new google.maps.Marker({
                position: new google.maps.LatLng(49.792533, 30.1101753), //Біла Церква
                map: map
            }),
            new google.maps.Marker({
                position: new google.maps.LatLng(50.2540414, 28.6550473), //Житомир
                map: map
            })
        ];
        marker.setMap(map);
    }

    jQuery(document).ready(function ($) {
        let map_div = $("#map");
        if (map_div.length) {
            initialize(48.5505313, 30.6270735);
        }
    });
</script>
</body>
</html>