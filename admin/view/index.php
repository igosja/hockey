<?php
/**
 * @var $freeteam_array array
 * @var $payment_categories string
 * @var $payment_data string
 * @var $teamask_array array
 * @var $support_array array
 */
?>
<script src="/js/highchart/highcharts.js"></script>
<div class="row">
    <div class="col-lg-12">
        <h1 class="page-header">Админ</h1>
    </div>
</div>
<div class="row">
    <div class="col-lg-3 col-md-6 col-sm-12 col-xs-12">
        <div class="panel panel-green">
            <div class="panel-heading">
                <div class="row">
                    <div class="col-xs-3">
                        <i class="fa fa-dribbble fa-5x"></i>
                    </div>
                    <div class="col-xs-9 text-right">
                        <div class="huge"><?= $freeteam_array[0]['count']; ?></div>
                        <div>Свободные команды</div>
                    </div>
                </div>
            </div>
            <a href="/admin/team_list.php">
                <div class="panel-footer">
                    <span class="pull-left">Список команд</span>
                    <span class="pull-right"><i class="fa fa-arrow-circle-right"></i></span>
                    <div class="clearfix"></div>
                </div>
            </a>
        </div>
    </div>
    <?php if ($teamask_array[0]['count']) { ?>
        <div class="col-lg-3 col-md-6 col-sm-12 col-xs-12">
            <div class="panel panel-primary">
                <div class="panel-heading">
                    <div class="row">
                        <div class="col-xs-3">
                            <i class="fa fa-user fa-5x"></i>
                        </div>
                        <div class="col-xs-9 text-right">
                            <div class="huge"><?= $teamask_array[0]['count']; ?></div>
                            <div>Заявки на команды!</div>
                        </div>
                    </div>
                </div>
                <a href="/admin/teamask_list.php">
                    <div class="panel-footer">
                        <span class="pull-left">Подробнее</span>
                        <span class="pull-right"><i class="fa fa-arrow-circle-right"></i></span>
                        <div class="clearfix"></div>
                    </div>
                </a>
            </div>
        </div>
    <?php } ?>
    <?php if ($support_array[0]['count']) { ?>
        <div class="col-lg-3 col-md-6 col-sm-12 col-xs-12">
            <div class="panel panel-yellow">
                <div class="panel-heading">
                    <div class="row">
                        <div class="col-xs-3">
                            <i class="fa fa-comments fa-5x"></i>
                        </div>
                        <div class="col-xs-9 text-right">
                            <div class="huge"><?= $support_array[0]['count']; ?></div>
                            <div>Новые вопросы</div>
                        </div>
                    </div>
                </div>
                <a href="/admin/support_list.php">
                    <div class="panel-footer">
                        <span class="pull-left">Подробнее</span>
                        <span class="pull-right"><i class="fa fa-arrow-circle-right"></i></span>
                        <div class="clearfix"></div>
                    </div>
                </a>
            </div>
        </div>
    <?php } ?>
    <?php if ($vote_array[0]['count']) { ?>
        <div class="col-lg-3 col-md-6 col-sm-12 col-xs-12">
            <div class="panel panel-red">
                <div class="panel-heading">
                    <div class="row">
                        <div class="col-xs-3">
                            <i class="fa fa-bar-chart fa-5x"></i>
                        </div>
                        <div class="col-xs-9 text-right">
                            <div class="huge"><?= $vote_array[0]['count']; ?></div>
                            <div>Новые опросы</div>
                        </div>
                    </div>
                </div>
                <a href="/admin/vote_list.php">
                    <div class="panel-footer">
                        <span class="pull-left">Подробнее</span>
                        <span class="pull-right"><i class="fa fa-arrow-circle-right"></i></span>
                        <div class="clearfix"></div>
                    </div>
                </a>
            </div>
        </div>
    <?php } ?>
</div>
<div class="row">
    <div class="col-lg-8">
        <div class="panel panel-default">
            <div class="panel-heading">
                <i class="fa fa-bar-chart-o fa-fw"></i> Оплаты
            </div>
            <div class="panel-body">
                <div id="chart-payment"></div>
            </div>
        </div>
    </div>
</div>
<script type="text/javascript">
    Highcharts.chart('chart-payment', {
        credits: {
            enabled: false
        },
        legend: {
            enabled: false
        },
        series: [{
            name: 'Оплаты',
            data: [<?= $payment_data; ?>]
        }],
        title: {
            text: 'Оплаты'
        },
        tooltip: {
            headerFormat: '<b>{point.key}</b><br/>',
            pointFormat: '{series.name}: <b>{point.y}</b>'
        },
        xAxis: {
            categories: [<?= $payment_categories; ?>],
            title: {
                text: 'Месяц'
            }
        },
        yAxis: {
            title: {
                text: 'Сумма'
            }
        }
    });
</script>