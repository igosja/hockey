<?php
/**
 * @var $snapshot_categories string
 * @var $snapshot_data string
 */
?>
<script src="/js/highchart/highcharts.js"></script>
<div class="row">
    <div class="col-lg-12">
        <h1 class="page-header">Графики состояния системы</h1>
        <div id="chart-snapshot"></div>
    </div>
</div>
<script type="text/javascript">
    Highcharts.chart('chart-snapshot', {
        credits: {
            enabled: false
        },
        legend: {
            enabled: false
        },
        series: [{
            name: 'График',
            data: [<?= $snapshot_data; ?>]
        }],
        title: {
            text: 'График'
        },
        tooltip: {
            headerFormat: '<b>{point.key}</b><br/>',
            pointFormat: '{series.name}: <b>{point.y}</b>'
        },
        xAxis: {
            categories: [<?= $snapshot_categories; ?>],
            title: {
                text: 'Дата'
            }
        },
        yAxis: {
            title: {
                text: 'Значение'
            }
        }
    });
</script>