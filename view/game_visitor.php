<?php
/**
 * @var $visitor_array array
 */
?>
<script src="/js/highchart/highcharts.js"></script>
<!--<style type="text/css">-->
<!--    #container {-->
<!--        min-width: 310px;-->
<!--        max-width: 800px;-->
<!--        height: 400px;-->
<!--        margin: 0 auto-->
<!--    }-->
<!--</style>-->
<div class="row margin-top">
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