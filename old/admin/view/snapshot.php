<?php
/**
 * @var $category_array array
 * @var $num_get integer
 * @var $season_array array
 * @var $season_id integer
 * @var $snapshot_categories string
 * @var $snapshot_data string
 */
?>
<script src="/js/highchart/highcharts.js"></script>
<div class="row">
    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 text-center">
        <h3 class="page-header">Статистические данные</h3>
    </div>
</div>
<div class="row">
    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
        <form action="/admin/snapshot.php" class="form-inline" method="GET">
            <div class="form-group">
                <label for="num">Показатель</label>
                <select class="form-control" id="num" name="num">
                    <?php foreach ($category_array as $key => $value) { ?>
                        <option
                            value="<?= $key; ?>"
                            <?php if ($num_get == $key) { ?>
                                selected
                            <?php } ?>
                        >
                            <?= $value['name']; ?>
                        </option>
                    <?php } ?>
                </select>
            </div>
            <div class="form-group">
                <label for="season">Сезон</label>
                <select class="form-control" id="season"  name="season_id">
                    <?php foreach ($season_array as $item) { ?>
                        <option
                            value="<?= $item['snapshot_season_id']; ?>"
                            <?php if ($season_id == $item['snapshot_season_id']) { ?>
                                selected
                            <?php } ?>
                        >
                            <?= $item['snapshot_season_id']; ?>
                        </option>
                    <?php } ?>
                </select>
            </div>
            <button class="btn btn btn-default">Показать</button>
        </form>
    </div>
</div>
<div class="row">
    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
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
            name: '<?= $category_array[$num_get]['name']; ?>',
            data: [<?= $snapshot_data; ?>]
        }],
        title: {
            text: '<?= $category_array[$num_get]['name']; ?>'
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
                text: '<?= $category_array[$num_get]['name']; ?>'
            }
        }
    });
</script>