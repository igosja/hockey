<?php
/**
 * @var $s_data array
 * @var $x_data array
 */
?>
<script src="/js/highchart/highcharts.js"></script>
<div class="row">
    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
        <h1>
            Прогноз посещаемости
        </h1>
    </div>
</div>
<div class="row margin-top">
    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
        <div class="row">
            <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
                <p class="strong text-center">Расписание</p>
                <div class="row">
                    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12"></div>
                </div>
                Сезон:	45
                День:	163
                Дата:	сегодня, 22:00
                Вид матча:	Чемпионат, D4-C
                Этап:	12 тур
            </div>
            <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
                Прогноз
                Температура:	0°-6° C
                Погода:	дождь
                Зрительский интерес к этому игровому дню
                Рейтинг интереса к туру:	1.00
                Поправочный коэффициент к рейтингу команд: (D4-C)	0.70
            </div>
        </div>
    </div>
</div>
<div class="row margin-top">
    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
        <div class="row">
            <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
                Посещаемость матча
                Число болельщиков хозяев:	42 000
                Число болельщиков гостей:	38 000
                Стадион "Мюнисипаль Хемис Земамра":	40 000
                Итого максимально болельщиков на матче:	40 000
            </div>
            <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
                Зрительский интерес к матчу
                Рейтинг посещаемости хозяев:	0.870 * 0.70 = 0.609
                Рейтинг посещаемости гостей:	0.750 * 0.70 = 0.525
                Формула подсчёта итогового интереса:	( 2 * R1 + R2 ) / 3
                Итоговый интерес к матчу:	0.581
            </div>
        </div>
    </div>
</div>
<div class="row margin-top">
    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
        <div class="row">
            <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
                График посещаемости
            </div>
            <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
                График суммарной выручки за все билеты
            </div>
        </div>
    </div>
</div>
<div class="row margin-top">
    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
        <div class="row">
            <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
                Хозяева
                От продажи билетов получают:	100%
                Содержание стадиона:	250 720 $
                Зарплата игроков за матч:	112 426 $
                Сумма расходов хозяев:	363 146 $
            </div>
            <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
                Гости
                От продажи билетов получают:	0%
                Содержание стадиона:	0 $
                Зарплата игроков за матч:	87 745 $
                Сумма расходов гостей:	87 745 $
            </div>
        </div>
    </div>
</div>
<div class="row">
    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
        <div id="container"></div>
        <script type="text/javascript">
            Highcharts.chart('container', {
                credits: {
                    enabled: false
                },
                legend: {
                    enabled: false
                },
                series: [{
                    name: 'Посещаемость',
                    data: [<?= $s_data; ?>]
                }],
                title: {
                    text: 'Посещаемость матча'
                },
                tooltip: {
                    headerFormat: 'Цена билета: <b>{point.key}</b><br/>',
                    pointFormat: '{series.name}: <b>{point.y}</b>'
                },
                xAxis: {
                    categories: [<?= $x_data; ?>],
                    title: {
                        text: 'Цена билета'
                    }
                },
                yAxis: {
                    title: {
                        text: 'Посещаемость'
                    }
                }
            });
        </script>
    </div>
</div>