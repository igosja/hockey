<?php
/**
 * @var $complain_array array
 * @var $count_moderation integer
 * @var $forummessage_array array
 * @var $freeteam_array array
 * @var $logo_array array
 * @var $news_array array
 * @var $newscomment_array array
 * @var $payment_array array
 * @var $payment_categories string
 * @var $payment_data string
 * @var $rentcomment_array string
 * @var $review_array string
 * @var $teamask_array array
 * @var $transfercomment_array array
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
                        <div class="huge admin-freeteam"><?= $freeteam_array[0]['count']; ?></div>
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
    <div class="col-lg-3 col-md-6 col-sm-12 col-xs-12 panel-teamask" <?php if (0 == $teamask_array[0]['count']) { ?>style="display:none;"<?php } ?>>
        <div class="panel panel-primary">
            <div class="panel-heading">
                <div class="row">
                    <div class="col-xs-3">
                        <i class="fa fa-user fa-5x"></i>
                    </div>
                    <div class="col-xs-9 text-right">
                        <div class="huge admin-teamask"><?= $teamask_array[0]['count']; ?></div>
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
    <div class="col-lg-3 col-md-6 col-sm-12 col-xs-12 panel-logo" <?php if (0 == $logo_array[0]['count']) { ?>style="display:none;"<?php } ?>>
        <div class="panel panel-primary">
            <div class="panel-heading">
                <div class="row">
                    <div class="col-xs-3">
                        <i class="fa fa-shield fa-5x"></i>
                    </div>
                    <div class="col-xs-9 text-right">
                        <div class="huge admin-logo"><?= $logo_array[0]['count']; ?></div>
                        <div>Логотипы!</div>
                    </div>
                </div>
            </div>
            <a href="/admin/logo_list.php">
                <div class="panel-footer">
                    <span class="pull-left">Подробнее</span>
                    <span class="pull-right"><i class="fa fa-arrow-circle-right"></i></span>
                    <div class="clearfix"></div>
                </div>
            </a>
        </div>
    </div>
    <div class="col-lg-3 col-md-6 col-sm-12 col-xs-12 panel-support" <?php if (0 == $support_array[0]['count']) { ?>style="display:none;"<?php } ?>>
        <div class="panel panel-red panel-support">
            <div class="panel-heading">
                <div class="row">
                    <div class="col-xs-3">
                        <i class="fa fa-comments fa-5x"></i>
                    </div>
                    <div class="col-xs-9 text-right">
                        <div class="huge admin-support"><?= $support_array[0]['count']; ?></div>
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
    <div class="col-lg-3 col-md-6 col-sm-12 col-xs-12 panel-complain" <?php if (0 == $complain_array[0]['count']) { ?>style="display:none;"<?php } ?>>
        <div class="panel panel-red panel-complain">
            <div class="panel-heading">
                <div class="row">
                    <div class="col-xs-3">
                        <i class="fa fa-exclamation-circle fa-5x"></i>
                    </div>
                    <div class="col-xs-9 text-right">
                        <div class="huge admin-complain"><?= $complain_array[0]['count']; ?></div>
                        <div>Новые жалобы</div>
                    </div>
                </div>
            </div>
            <a href="/admin/complain_list.php">
                <div class="panel-footer">
                    <span class="pull-left">Подробнее</span>
                    <span class="pull-right"><i class="fa fa-arrow-circle-right"></i></span>
                    <div class="clearfix"></div>
                </div>
            </a>
        </div>
    </div>
    <div class="col-lg-3 col-md-6 col-sm-12 col-xs-12 panel-vote" <?php if (0 == $vote_array[0]['count']) { ?>style="display:none;"<?php } ?>>
        <div class="panel panel-yellow">
            <div class="panel-heading">
                <div class="row">
                    <div class="col-xs-3">
                        <i class="fa fa-bar-chart fa-5x"></i>
                    </div>
                    <div class="col-xs-9 text-right">
                        <div class="huge admin-vote"><?= $vote_array[0]['count']; ?></div>
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
</div>
<div class="row">
    <div class="col-lg-8">
        <div class="panel panel-default">
            <div class="panel-heading">
                <i class="fa fa-bar-chart-o fa-fw"></i> Оплаты
            </div>
            <div class="panel-body">
                <div id="chart-payment"></div>
                <div class="table-responsive">
                    <table class="table table-bordered table-hover table-striped table-condensed">
                        <tr>
                            <th>Время</th>
                            <th>Сумма</th>
                            <th>Пользователь</th>
                        </tr>
                        <?php foreach ($payment_array as $item) { ?>
                            <tr>
                                <td><?= f_igosja_ufu_date_time($item['payment_date']); ?></td>
                                <td><?= $item['payment_sum']; ?></td>
                                <td>
                                    <a href="/admin/user_view.php?num=<?= $item['user_id']; ?>" target="_blank">
                                        <?= $item['user_login']; ?>
                                    </a>
                                </td>
                            </tr>
                        <?php } ?>
                    </table>
                </div>
            </div>
        </div>
    </div>
    <div class="col-lg-4">
        <div class="panel panel-default">
            <div class="panel-heading">
                <i class="fa fa-bar-chart-o fa-fw"></i> К модерации (<?= $count_moderation; ?>)
            </div>
            <div class="panel-body">
                <div class="list-group">
                    <a href="/admin/moderation_forummessage.php" class="list-group-item">
                        Сообщения на форуме
                        <span class="pull-right text-muted small">
                            <em><?= $forummessage_array[0]['count']; ?></em>
                        </span>
                    </a>
                    <a href="/admin/moderation_gamecomment.php" class="list-group-item">
                        Комментарии к матчам
                        <span class="pull-right text-muted small">
                            <em><?= $gamecomment_array[0]['count']; ?></em>
                        </span>
                    </a>
                    <a href="/admin/moderation_news.php" class="list-group-item">
                        Новости
                        <span class="pull-right text-muted small">
                            <em><?= $news_array[0]['count']; ?></em>
                        </span>
                    </a>
                    <a href="/admin/moderation_newscomment.php" class="list-group-item">
                        Комментарии к новостям
                        <span class="pull-right text-muted small">
                            <em><?= $newscomment_array[0]['count']; ?></em>
                        </span>
                    </a>
                    <a href="/admin/moderation_rentcomment.php" class="list-group-item">
                        Комментарии к арендне
                        <span class="pull-right text-muted small">
                            <em><?= $rentcomment_array[0]['count']; ?></em>
                        </span>
                    </a>
                    <a href="/admin/moderation_transfercomment.php" class="list-group-item">
                        Комментарии к трансферам
                        <span class="pull-right text-muted small">
                            <em><?= $transfercomment_array[0]['count']; ?></em>
                        </span>
                    </a>
                    <a href="/admin/moderation_review.php" class="list-group-item">
                        Обзоры
                        <span class="pull-right text-muted small">
                            <em><?= $review_array[0]['count']; ?></em>
                        </span>
                    </a>
                </div>
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