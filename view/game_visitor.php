<?php
/**
 * @var $game_array array
 * @var $s_data_income array
 * @var $s_data_visitor array
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
    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 table-responsive">
        <table class="table table-bordered table-hover">
            <tr>
                <th colspan="2">
                    <?= f_igosja_team_or_national_link(
                        array(
                            'city_name'     => $game_array[0]['home_city_name'],
                            'country_name'  => $game_array[0]['home_country_name'],
                            'team_id'       => $game_array[0]['home_team_id'],
                            'team_name'     => $game_array[0]['home_team_name'],
                        ),
                        array(
                            'country_name'      => $game_array[0]['home_national_name'],
                            'national_id'       => $game_array[0]['home_national_id'],
                            'nationaltype_name' => $game_array[0]['home_nationaltype_name'],
                        )
                    ); ?>
                    -
                    <?= f_igosja_team_or_national_link(
                        array(
                            'city_name'     => $game_array[0]['guest_city_name'],
                            'country_name'  => $game_array[0]['guest_country_name'],
                            'team_id'       => $game_array[0]['guest_team_id'],
                            'team_name'     => $game_array[0]['guest_team_name'],
                        ),
                        array(
                            'country_name'      => $game_array[0]['guest_national_name'],
                            'national_id'       => $game_array[0]['guest_national_id'],
                            'nationaltype_name' => $game_array[0]['guest_nationaltype_name'],
                        )
                    ); ?>
                </th>
            </tr>
            <tr>
                <td class="col-50">
                    Сезон
                </td>
                <td class="text-right">
                    <?= $game_array[0]['schedule_season_id']; ?>
                </td>
            </tr>
            <tr>
                <td>
                    Дата
                </td>
                <td class="text-right">
                    <?= f_igosja_ufu_date($game_array[0]['schedule_date']); ?>
                </td>
            </tr>
            <tr>
                <td>
                    Тип турнира
                </td>
                <td class="text-right">
                    <?= $game_array[0]['tournamenttype_name']; ?>
                </td>
            </tr>
            <tr>
                <td>
                    Коэффициент типа турнира
                </td>
                <td class="text-right">
                    <?= $game_array[0]['tournamenttype_visitor'] / 100; ?>
                </td>
            </tr>
            <tr>
                <td>
                    Стадия
                </td>
                <td class="text-right">
                    <?= $game_array[0]['stage_name']; ?>
                </td>
            </tr>
            <tr>
                <td>
                    Коэффициент стадии турнира
                </td>
                <td class="text-right">
                    <?= $game_array[0]['stage_visitor'] / 100; ?>
                </td>
            </tr>
            <tr>
                <td>
                    <?= $game_array[0]['stadium_name']; ?> (вместимость)
                </td>
                <td class="text-right">
                    <?= $game_array[0]['stadium_capacity']; ?>
                </td>
            </tr>
            <tr>
                <td>
                    Рейтинг посещаемости хозяев
                </td>
                <td class="text-right">
                    <?= $game_array[0]['home_team_visitor'] / 100; ?>
                </td>
            </tr>
            <tr>
                <td>
                    Рейтинг посещаемости гостей
                </td>
                <td class="text-right">
                    <?= $game_array[0]['guest_team_visitor'] / 100; ?>
                </td>
            </tr>
            <tr>
                <td>
                    Количество кумиров в заявке на матч
                </td>
                <td class="text-right">
                    <?= $game_array[0]['playerspecial_level']; ?>
                </td>
            </tr>
        </table>
    </div>
</div>
<div class="row margin-top">
    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
        <div class="row">
            <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
                <div id="visitor"></div>
            </div>
            <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
                <div id="income"></div>
            </div>
        </div>
    </div>
</div>
<div class="row margin-top">
    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
        <div class="row">
            <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12 table-responsive">
                <table class="table table-bordered table-hover">
                    <tr>
                        <th colspan="2">Хозяева</th>
                    </tr>
                    <tr>
                        <td>От продажи билетов получают</td>
                        <td>
                            <?php if (TOURNAMENTTYPE_FRIENDLY == $game_array[0]['tournamenttype_id']) { ?>
                                50%
                            <?php } elseif (TOURNAMENTTYPE_NATIONAL == $game_array[0]['tournamenttype_id']) { ?>
                                33%
                            <?php } else { ?>
                                100%
                            <?php } ?>
                        </td>
                    </tr>
                    <tr>
                        <td>Содержание стадиона</td>
                        <td>
                            <?php if (TOURNAMENTTYPE_FRIENDLY == $game_array[0]['tournamenttype_id']) { ?>
                                <?= f_igosja_money_format($game_array[0]['stadium_maintenance'] / 2); ?>
                            <?php } elseif (TOURNAMENTTYPE_NATIONAL == $game_array[0]['tournamenttype_id']) { ?>
                                <?= f_igosja_money_format(0); ?>
                            <?php } else { ?>
                                <?= f_igosja_money_format($game_array[0]['stadium_maintenance']); ?>
                            <?php } ?>
                        </td>
                    </tr>
                    <tr>
                        <td>Зарплата игроков за день</td>
                        <td>
                            <?php if (TOURNAMENTTYPE_NATIONAL == $game_array[0]['tournamenttype_id']) { ?>
                                <?= f_igosja_money_format(0); ?>
                            <?php } else { ?>
                                <?= f_igosja_money_format($game_array[0]['home_team_salary']); ?>
                            <?php } ?>
                        </td>
                    </tr>
                    <tr>
                        <td>Сумма расходов хозяев</td>
                        <td>
                            <?php if (TOURNAMENTTYPE_FRIENDLY == $game_array[0]['tournamenttype_id']) { ?>
                                <?= f_igosja_money_format($game_array[0]['stadium_maintenance'] / 2 + $game_array[0]['home_team_salary']); ?>
                            <?php } elseif (TOURNAMENTTYPE_NATIONAL == $game_array[0]['tournamenttype_id']) { ?>
                                <?= f_igosja_money_format(0); ?>
                            <?php } else { ?>
                                <?= f_igosja_money_format($game_array[0]['stadium_maintenance'] + $game_array[0]['home_team_salary']); ?>
                            <?php } ?>
                        </td>
                    </tr>
                </table>
            </div>
            <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
                <table class="table table-bordered table-hover table-responsive">
                    <tr>
                        <th colspan="2">Гости</th>
                    </tr>
                    <tr>
                        <td>От продажи билетов получают</td>
                        <td>
                            <?php if (TOURNAMENTTYPE_FRIENDLY == $game_array[0]['tournamenttype_id']) { ?>
                                50%
                            <?php } elseif (TOURNAMENTTYPE_NATIONAL == $game_array[0]['tournamenttype_id']) { ?>
                                33%
                            <?php } else { ?>
                                0%
                            <?php } ?>
                        </td>
                    </tr>
                    <tr>
                        <td>Содержание стадиона</td>
                        <td>
                            <?php if (TOURNAMENTTYPE_FRIENDLY == $game_array[0]['tournamenttype_id']) { ?>
                                <?= f_igosja_money_format($game_array[0]['stadium_maintenance'] / 2); ?>
                            <?php } else { ?>
                                <?= f_igosja_money_format(0); ?>
                            <?php } ?>
                        </td>
                    </tr>
                    <tr>
                        <td>Зарплата игроков за день</td>
                        <td>
                            <?php if (TOURNAMENTTYPE_NATIONAL == $game_array[0]['tournamenttype_id']) { ?>
                                <?= f_igosja_money_format(0); ?>
                            <?php } else { ?>
                                <?= f_igosja_money_format($game_array[0]['guest_team_salary']); ?>
                            <?php } ?>
                        </td>
                    </tr>
                    <tr>
                        <td>Сумма расходов гостей</td>
                        <td>
                            <?php if (TOURNAMENTTYPE_FRIENDLY == $game_array[0]['tournamenttype_id']) { ?>
                                <?= f_igosja_money_format($game_array[0]['stadium_maintenance'] / 2 + $game_array[0]['guest_team_salary']); ?>
                            <?php } elseif (TOURNAMENTTYPE_NATIONAL == $game_array[0]['tournamenttype_id']) { ?>
                                <?= f_igosja_money_format(0); ?>
                            <?php } else { ?>
                                <?= f_igosja_money_format($game_array[0]['guest_team_salary']); ?>
                            <?php } ?>
                        </td>
                    </tr>
                </table>
            </div>
        </div>
    </div>
</div>
<script type="text/javascript">
    Highcharts.chart('visitor', {
        credits: {
            enabled: false
        },
        legend: {
            enabled: false
        },
        series: [{
            name: 'Посещаемость',
            data: [<?= $s_data_visitor; ?>]
        }],
        title: {
            text: 'Посещаемость матча'
        },
        tooltip: {
            headerFormat: 'Цена билета <b>{point.key}</b><br/>',
            pointFormat: '{series.name} <b>{point.y}</b>'
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
    Highcharts.chart('income', {
        credits: {
            enabled: false
        },
        legend: {
            enabled: false
        },
        series: [{
            name: 'Выручка',
            data: [<?= $s_data_income; ?>]
        }],
        title: {
            text: 'Выручка за билеты'
        },
        tooltip: {
            headerFormat: 'Цена билета <b>{point.key}</b><br/>',
            pointFormat: '{series.name} <b>{point.y}</b>'
        },
        xAxis: {
            categories: [<?= $x_data; ?>],
            title: {
                text: 'Цена билета'
            }
        },
        yAxis: {
            title: {
                text: 'Выручка'
            }
        }
    });
</script>