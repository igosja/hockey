<?php
/**
 * @var $auth_team_id integer
 * @var $notification_array array
 * @var $num_get integer
 * @var $player_array array
 * @var $playerposition_array array
 * @var $playerspecial_array array
 * @var $playerstatistic_array array
 * @var $scout_array array
 * @var $training_array array
 */
?>
<div class="row margin-top">
    <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
        <?php include(__DIR__ . '/include/team_view_top_left.php'); ?>
    </div>
    <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12 text-right">
        <?php include(__DIR__ . '/include/team_view_top_right.php'); ?>
    </div>
</div>
<?php if ($notification_array) { ?>
    <div class="row margin-top">
        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
            <ul>
                <?php foreach ($notification_array as $item) { ?>
                    <li><?= $item; ?></li>
                <?php } ?>
            </ul>
        </div>
    </div>
<?php } ?>
<div class="row margin-top">
    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
        <?php include(__DIR__ . '/include/team_table_link.php'); ?>
    </div>
</div>
<div class="row">
    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 table-responsive">
        <table class="table table-bordered table-hover" id="grid">
            <thead>
                <tr>
                    <th data-type="increment">№</th>
                    <th data-type="player">Игрок</th>
                    <th class="col-1 hidden-xs" data-type="country" title="Национальность">Нац</th>
                    <th class="col-5" data-type="position" title="Позиция">Поз</th>
                    <th class="col-5" data-type="number" title="Возраст">В</th>
                    <th class="col-5" data-type="number" title="Номинальная сила">С</th>
                    <th class="col-5" data-type="number" title="Усталость">У</th>
                    <th class="col-5" data-type="phisical" title="Форма">Ф</th>
                    <th class="col-5" data-type="number" title="Реальная сила">РС</th>
                    <th class="col-10 hidden-xs" data-type="string" title="Спецвозможности">Спец</th>
                    <th class="col-5 hidden-xs" data-type="number" title="Плюс/минус">+/-</th>
                    <th class="col-5 hidden-xs" data-type="number" title="Игр">И</th>
                    <th class="col-5 hidden-xs" data-type="number" title="Шайб">Ш</th>
                    <th class="col-5 hidden-xs" data-type="number" title="Результативных передач">П</th>
                    <th class="col-10 hidden-xs" data-type="price">Цена</th>
                    <th class="col-1 hidden-xs" data-type="style" title="Стиль">Ст</th>
                    <th class="col-5" data-type="number" title="Играл/отдыхал подряд">ИО</th>
                </tr>
            </thead>
            <tbody>
                <?php $i=0; $player_number=1; foreach ($player_array as $item) { ?>
                    <tr data-order="<?= $i; ?>" data-player="<?= $item['player_id']; ?>">
                        <td class="text-center">
                            <?= $player_number; ?>
                        </td>
                        <td<?php if (isset($auth_team_id) && $num_get == $auth_team_id && $item['line_color']) { ?> style="background-color: #<?= $item['line_color']; ?>"<?php } ?>>
                            <?php if ($num_get == $auth_team_id) { ?>
                                <img alt="Вверх" class="up" src="/img/up.png" style="display: none;" />
                                <img alt="Вниз" class="down" src="/img/down.png" style="display: none;" />
                            <?php } ?>
                            <a href="/player_view.php?num=<?= $item['player_id']; ?>">
                                <?= $item['name_name']; ?>
                                <?= $item['surname_name']; ?>
                            </a>
                            <?php if (39 == $item['player_age']) { ?>
                                <img
                                    alt="Завершает карьеру в конце сезона"
                                    src="/img/palm.png"
                                    title="Завершает карьеру в конце сезона"
                                />
                            <?php } ?>
                            <?php if (1 == $item['player_injury']) { ?>
                                <img
                                    alt="Травмирован на <?= $item['player_injury_day']; ?> <?= f_igosja_count_case($item['player_injury_day'], 'день', 'дня', 'дней'); ?>"
                                    src="/img/injury.png"
                                    title="Травмирован на <?= $item['player_injury_day']; ?> <?= f_igosja_count_case($item['player_injury_day'], 'день', 'дня', 'дней'); ?>"
                                />
                            <?php } ?>
                            <?php if (0 != $item['player_national_id']) { ?>
                                <img
                                    alt="Игрок сборной"
                                    src="/img/national.png"
                                    title="Игрок сборной"
                                />
                            <?php } ?>
                            <?php if (in_array(1, array($item['player_rent_on'], $item['player_transfer_on']))) { ?>
                                <img
                                    alt="Выставлен на трансфер/аренду"
                                    src="/img/market.png"
                                    title="Выставлен на трансфер/аренду"
                                />
                            <?php } ?>
                            <?= f_igosja_player_on_training($item['player_id'], $training_array); ?>
                        </td>
                        <td class="hidden-xs text-center">
                            <a href="/country_news.php?num=<?= $item['country_id']; ?>">
                                <img
                                    alt="<?= $item['country_name']; ?>"
                                    src="/img/country/12/<?= $item['country_id']; ?>.png"
                                    title="<?= $item['country_name']; ?>"
                                />
                            </a>
                        </td>
                        <td class="text-center"><?= f_igosja_player_position($item['player_id'], $playerposition_array); ?></td>
                        <td class="text-center"><?= $item['player_age']; ?></td>
                        <td
                            class="text-center
                            <?php if ($item['player_power_nominal'] > $item['player_power_old']) { ?>
                                font-green
                            <?php } elseif ($item['player_power_nominal'] < $item['player_power_old']) { ?>
                                font-red
                            <?php } ?>"
                        >
                            <?= $item['player_power_nominal']; ?>
                        </td>
                        <td class="text-center">
                            <?php if (isset($auth_team_id) && $auth_team_id == $num_get) { ?>
                                <?= $item['player_tire']; ?>
                            <?php } else { ?>
                                ?
                            <?php } ?>
                        </td>
                        <td class="text-center">
                            <?php if (isset($auth_team_id) && $auth_team_id == $num_get) { ?>
                                <img
                                    alt="<?= $item['phisical_name']; ?>"
                                    src="/img/phisical/<?= $item['phisical_id']; ?>.png"
                                    title="<?= $item['phisical_name']; ?>"
                                />
                            <?php } else { ?>
                                ?
                            <?php } ?>
                        </td>
                        <td class="text-center">
                            <?php if (isset($auth_team_id) && $auth_team_id == $num_get) { ?>
                                <?= $item['player_power_real']; ?>
                            <?php } else { ?>
                                ~<?= $item['player_power_nominal']; ?>
                            <?php } ?>
                        </td>
                        <td class="hidden-xs text-center"><?= f_igosja_player_special($item['player_id'], $playerspecial_array); ?></td>
                        <td class="hidden-xs text-center"><?= f_igosja_player_statistic($item['player_id'], $playerstatistic_array, 'statisticplayer_plus_minus'); ?></td>
                        <td class="hidden-xs text-center"><?= f_igosja_player_statistic($item['player_id'], $playerstatistic_array, 'statisticplayer_game'); ?></td>
                        <td class="hidden-xs text-center"><?= f_igosja_player_statistic($item['player_id'], $playerstatistic_array, 'statisticplayer_score'); ?></td>
                        <td class="hidden-xs text-center"><?= f_igosja_player_statistic($item['player_id'], $playerstatistic_array, 'statisticplayer_assist'); ?></td>
                        <td class="hidden-xs text-right"><?= f_igosja_money_format($item['player_price']); ?></td>
                        <td class="hidden-xs text-center"><?= f_igosja_player_style($item['player_id'], $item['style_id'], $item['style_name'], $scout_array); ?></td>
                        <td class="text-center"><?= $item['player_game_row']; ?></td>
                    </tr>
                <?php $i++; $player_number++; } ?>
            </tbody>
            <tfoot>
                <?php if ($player_rent_in_array) { ?>
                    <tr>
                        <th colspan="16">Взятые в аренду</th>
                    </tr>
                    <?php foreach ($player_rent_in_array as $item) { ?>
                        <tr>
                            <td class="text-center">
                                <?= $player_number; ?>
                            </td>
                            <td>
                                <a href="/player_view.php?num=<?= $item['player_id']; ?>">
                                    <?= $item['name_name']; ?>
                                    <?= $item['surname_name']; ?>
                                </a>
                                <?php if (39 == $item['player_age']) { ?>
                                    <img
                                        alt="Завершает карьеру в конце сезона"
                                        src="/img/palm.png"
                                        title="Завершает карьеру в конце сезона"
                                    />
                                <?php } ?>
                                <?php if (1 == $item['player_injury']) { ?>
                                    <img
                                        alt="Травмирован на <?= $item['player_injury_day']; ?> <?= f_igosja_count_case($item['player_injury_day'], 'день', 'дня', 'дней'); ?>"
                                        src="/img/injury.png"
                                        title="Травмирован на <?= $item['player_injury_day']; ?> <?= f_igosja_count_case($item['player_injury_day'], 'день', 'дня', 'дней'); ?>"
                                    />
                                <?php } ?>
                                <?php if (0 != $item['player_national_id']) { ?>
                                    <img
                                        alt="Игрок сборной"
                                        src="/img/national.png"
                                        title="Игрок сборной"
                                    />
                                <?php } ?>
                                <?php if (in_array(1, array($item['player_rent_on'], $item['player_transfer_on']))) { ?>
                                    <img
                                        alt="Выставлен на трансфер/аренду"
                                        src="/img/market.png"
                                        title="Выставлен на трансфер/аренду"
                                    />
                                <?php } ?>
                                (<?= $item['player_rent_day']; ?>)
                            </td>
                            <td class="hidden-xs text-center">
                                <a href="/country_news.php?num=<?= $item['country_id']; ?>">
                                    <img
                                        alt="<?= $item['country_name']; ?>"
                                        src="/img/country/12/<?= $item['country_id']; ?>.png"
                                        title="<?= $item['country_name']; ?>"
                                    />
                                </a>
                            </td>
                            <td class="text-center"><?= f_igosja_player_position($item['player_id'], $playerposition_array); ?></td>
                            <td class="text-center"><?= $item['player_age']; ?></td>
                            <td
                                class="text-center
                                <?php if ($item['player_power_nominal'] > $item['player_power_old']) { ?>
                                    font-green
                                <?php } elseif ($item['player_power_nominal'] < $item['player_power_old']) { ?>
                                    font-red
                                <?php } ?>"
                            >
                                <?= $item['player_power_nominal']; ?>
                            </td>
                            <td class="text-center">
                                <?php if (isset($auth_team_id) && $auth_team_id == $num_get) { ?>
                                    <?= $item['player_tire']; ?>
                                <?php } else { ?>
                                    ?
                                <?php } ?>
                            </td>
                            <td class="text-center">
                                <?php if (isset($auth_team_id) && $auth_team_id == $num_get) { ?>
                                    <img
                                        alt="<?= $item['phisical_name']; ?>"
                                        src="/img/phisical/<?= $item['phisical_id']; ?>.png"
                                        title="<?= $item['phisical_name']; ?>"
                                    />
                                <?php } else { ?>
                                    ?
                                <?php } ?>
                            </td>
                            <td class="text-center">
                                <?php if (isset($auth_team_id) && $auth_team_id == $num_get) { ?>
                                    <?= $item['player_power_real']; ?>
                                <?php } else { ?>
                                    ~<?= $item['player_power_nominal']; ?>
                                <?php } ?>
                            </td>
                            <td class="hidden-xs text-center"><?= f_igosja_player_special($item['player_id'], $playerspecial_array); ?></td>
                            <td class="hidden-xs text-center"><?= f_igosja_player_statistic($item['player_id'], $playerstatistic_array, 'statisticplayer_plus_minus'); ?></td>
                            <td class="hidden-xs text-center"><?= f_igosja_player_statistic($item['player_id'], $playerstatistic_array, 'statisticplayer_game'); ?></td>
                            <td class="hidden-xs text-center"><?= f_igosja_player_statistic($item['player_id'], $playerstatistic_array, 'statisticplayer_score'); ?></td>
                            <td class="hidden-xs text-center"><?= f_igosja_player_statistic($item['player_id'], $playerstatistic_array, 'statisticplayer_assist'); ?></td>
                            <td class="hidden-xs text-right"><?= f_igosja_money_format($item['player_price']); ?></td>
                            <td class="hidden-xs text-center"><?= f_igosja_player_style($item['player_id'], $item['style_id'], $item['style_name'], $scout_array); ?></td>
                            <td class="text-center"><?= $item['player_game_row']; ?></td>
                        </tr>
                    <?php $player_number++; } ?>
                <?php } ?>
                <?php if ($player_rent_out_array) { ?>
                    <tr>
                        <th colspan="16">Отданные в аренду</th>
                    </tr>
                    <?php foreach ($player_rent_out_array as $item) { ?>
                        <tr>
                            <td class="text-center">
                                <?= $player_number; ?>
                            </td>
                            <td>
                                <a href="/player_view.php?num=<?= $item['player_id']; ?>">
                                    <?= $item['name_name']; ?>
                                    <?= $item['surname_name']; ?>
                                </a>
                                <?php if (39 == $item['player_age']) { ?>
                                    <img
                                        alt="Завершает карьеру в конце сезона"
                                        src="/img/palm.png"
                                        title="Завершает карьеру в конце сезона"
                                    />
                                <?php } ?>
                                <?php if (1 == $item['player_injury']) { ?>
                                    <img
                                        alt="Травмирован на <?= $item['player_injury_day']; ?> <?= f_igosja_count_case($item['player_injury_day'], 'день', 'дня', 'дней'); ?>"
                                        src="/img/injury.png"
                                        title="Травмирован на <?= $item['player_injury_day']; ?> <?= f_igosja_count_case($item['player_injury_day'], 'день', 'дня', 'дней'); ?>"
                                    />
                                <?php } ?>
                                <?php if (0 != $item['player_national_id']) { ?>
                                    <img
                                        alt="Игрок сборной"
                                        src="/img/national.png"
                                        title="Игрок сборной"
                                    />
                                <?php } ?>
                                <?php if (in_array(1, array($item['player_rent_on'], $item['player_transfer_on']))) { ?>
                                    <img
                                        alt="Выставлен на трансфер/аренду"
                                        src="/img/market.png"
                                        title="Выставлен на трансфер/аренду"
                                    />
                                <?php } ?>
                                (<?= $item['player_rent_day']; ?>)
                            </td>
                            <td class="hidden-xs text-center">
                                <a href="/country_news.php?num=<?= $item['country_id']; ?>">
                                    <img
                                        alt="<?= $item['country_name']; ?>"
                                        src="/img/country/12/<?= $item['country_id']; ?>.png"
                                        title="<?= $item['country_name']; ?>"
                                    />
                                </a>
                            </td>
                            <td class="text-center"><?= f_igosja_player_position($item['player_id'], $playerposition_array); ?></td>
                            <td class="text-center"><?= $item['player_age']; ?></td>
                            <td
                                class="text-center
                                <?php if ($item['player_power_nominal'] > $item['player_power_old']) { ?>
                                    font-green
                                <?php } elseif ($item['player_power_nominal'] < $item['player_power_old']) { ?>
                                    font-red
                                <?php } ?>"
                            >
                                <?= $item['player_power_nominal']; ?>
                            </td>
                            <td class="text-center">
                                <?php if (isset($auth_team_id) && $auth_team_id == $num_get) { ?>
                                    <?= $item['player_tire']; ?>
                                <?php } else { ?>
                                    ?
                                <?php } ?>
                            </td>
                            <td class="text-center">
                                <?php if (isset($auth_team_id) && $auth_team_id == $num_get) { ?>
                                    <img
                                        alt="<?= $item['phisical_name']; ?>"
                                        src="/img/phisical/<?= $item['phisical_id']; ?>.png"
                                        title="<?= $item['phisical_name']; ?>"
                                    />
                                <?php } else { ?>
                                    ?
                                <?php } ?>
                            </td>
                            <td class="text-center">
                                <?php if (isset($auth_team_id) && $auth_team_id == $num_get) { ?>
                                    <?= $item['player_power_real']; ?>
                                <?php } else { ?>
                                    ~<?= $item['player_power_nominal']; ?>
                                <?php } ?>
                            </td>
                            <td class="hidden-xs text-center"><?= f_igosja_player_special($item['player_id'], $playerspecial_array); ?></td>
                            <td class="hidden-xs text-center"><?= f_igosja_player_statistic($item['player_id'], $playerstatistic_array, 'statisticplayer_plus_minus'); ?></td>
                            <td class="hidden-xs text-center"><?= f_igosja_player_statistic($item['player_id'], $playerstatistic_array, 'statisticplayer_game'); ?></td>
                            <td class="hidden-xs text-center"><?= f_igosja_player_statistic($item['player_id'], $playerstatistic_array, 'statisticplayer_score'); ?></td>
                            <td class="hidden-xs text-center"><?= f_igosja_player_statistic($item['player_id'], $playerstatistic_array, 'statisticplayer_assist'); ?></td>
                            <td class="hidden-xs text-right"><?= f_igosja_money_format($item['player_price']); ?></td>
                            <td class="hidden-xs text-center"><?= f_igosja_player_style($item['player_id'], $item['style_id'], $item['style_name'], $scout_array); ?></td>
                            <td class="text-center"><?= $item['player_game_row']; ?></td>
                        </tr>
                    <?php $player_number++; } ?>
                <?php } ?>
                <tr>
                    <th data-type="increment">№</th>
                    <th>
                        <?php if ($num_get == $auth_team_id) { ?>
                            <img alt="Тренерская сортировка" class="coach-sort" src="/img/sort.png" title="Тренерская сортировка" />
                        <?php } ?>
                        Игрок
                    </th>
                    <th class="hidden-xs" title="Национальность">Нац</th>
                    <th title="Позиция">Поз</th>
                    <th title="Возраст">В</th>
                    <th title="Номинальная сила">С</th>
                    <th title="Усталость">У</th>
                    <th title="Форма">Ф</th>
                    <th title="Реальная сила">РС</th>
                    <th class="hidden-xs" title="Спецвозможности">Спец</th>
                    <th title="Плюс/минус" class="hidden-xs">+/-</th>
                    <th class="hidden-xs" title="Игр">И</th>
                    <th class="hidden-xs" title="Шайб">Ш</th>
                    <th class="hidden-xs" title="Результативных передач">П</th>
                    <th class="hidden-xs">Цена</th>
                    <th class="col-1 hidden-xs" title="Стиль">Ст</th>
                    <th title="Играл/отдыхал подряд">ИО</th>
                </tr>
            </tfoot>
        </table>
    </div>
</div>
<div class="row">
    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
        <?php include(__DIR__ . '/include/team_table_link.php'); ?>
    </div>
</div>
<div class="row hidden-lg hidden-md hidden-sm">
    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
        <a class="btn show-full-table" href="javascript:">
            Показать полную таблицу
        </a>
    </div>
</div>
<div class="row margin-top">
    <div class="col-lg-5 col-md-5 col-sm-5 col-xs-12 text-size-2">
        <span class="italic">Показатели команды:</span>
        <div class="row">
            <div class="col-lg-8 col-md-8 col-sm-8 col-xs-8">
                - Рейтинг силы команды (Vs)
            </div>
            <div class="col-lg-4 col-md-4 col-sm-4 col-xs-4 text-right">
                <?= $rating_array[0]['team_power_vs']; ?>
            </div>
        </div>
        <div class="row">
            <div class="col-lg-8 col-md-8 col-sm-8 col-xs-8">
                - Сила 16 лучших (s16)
            </div>
            <div class="col-lg-4 col-md-4 col-sm-4 col-xs-4 text-right">
                <?= $rating_array[0]['team_power_s_16']; ?>
            </div>
        </div>
        <div class="row">
            <div class="col-lg-8 col-md-8 col-sm-8 col-xs-8">
                - Сила 21 лучшего (s21)
            </div>
            <div class="col-lg-4 col-md-4 col-sm-4 col-xs-4 text-right">
                <?= $rating_array[0]['team_power_s_21']; ?>
            </div>
        </div>
        <div class="row">
            <div class="col-lg-8 col-md-8 col-sm-8 col-xs-8">
                - Сила 27 лучших (s27)
            </div>
            <div class="col-lg-4 col-md-4 col-sm-4 col-xs-4 text-right">
                <?= $rating_array[0]['team_power_s_27']; ?>
            </div>
        </div>
        <div class="row">
            <div class="col-lg-8 col-md-8 col-sm-8 col-xs-8">
                - Стоимость строений
            </div>
            <div class="col-lg-4 col-md-4 col-sm-4 col-xs-4 text-right">
                <?= f_igosja_money_format($rating_array[0]['team_price_base']); ?>
            </div>
        </div>
        <div class="row">
            <div class="col-lg-8 col-md-8 col-sm-8 col-xs-8">
                - Общая стоимость
            </div>
            <div class="col-lg-4 col-md-4 col-sm-4 col-xs-4 text-right">
                <?= f_igosja_money_format($rating_array[0]['team_price_total']); ?>
            </div>
        </div>
    </div>
    <div class="col-lg-1 col-md-1 col-sm-1 hidden-xs"></div>
    <?php

    if (isset($auth_team_id))
    {
        if ($num_get == $auth_team_id)
        {
            include(__DIR__ . '/include/team_view_bottom_right_forum.php');
        }
        else
        {
            include(__DIR__ . '/include/team_view_bottom_right_my_team.php');
        }
    }

    ?>
</div>