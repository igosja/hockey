<?php
/**
 * @var $basescout_array array
 * @var $cancel_array array
 * @var $cancel_get integer
 * @var $cancel_price integer
 * @var $confirm_data array
 * @var $on_building boolean
 * @var $playerposition_array array
 * @var $playerspecial_array array
 * @var $scoutplayerposition_array array
 * @var $scoutplayerspecial_array array
 * @var $scout_array array
 * @var $scout_available integer
 */
?>
<div class="row margin-top">
    <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
        <?php include(__DIR__ . '/include/team_view_top_left.php'); ?>
    </div>
    <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12 text-right">
        <div class="row">
            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 strong text-size-1">
                Скаут центр
            </div>
        </div>
        <div class="row">
            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12<?php if ($on_building) { ?> del<?php } ?>">
                Уровень:
                <span class="strong"><?= $basescout_array[0]['basescout_level']; ?></span>
            </div>
        </div>
        <div class="row">
            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12<?php if ($on_building) { ?> del<?php } ?>">
                Скорость изучения:
                <span class="strong"><?= $basescout_array[0]['basescout_scout_speed_min']; ?>%</span>
                -
                <span class="strong"><?= $basescout_array[0]['basescout_scout_speed_max']; ?>%</span>
                за тур
            </div>
        </div>
        <div class="row">
            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12<?php if ($on_building) { ?> del<?php } ?>">
                Осталось изучений стилей:
                <span class="strong"><?= $scout_available; ?></span>
                из
                <span class="strong"><?= $basescout_array[0]['basescout_my_style_count']; ?></span>
            </div>
        </div>
    </div>
</div>
<div class="row margin-top">
    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 text-center<?php if ($on_building) { ?> del<?php } ?>">
        <span class="strong">Стоимость изучения:</span>
        Стиля
        <span class="strong"><?= f_igosja_money_format($basescout_array[0]['basescout_my_style_price']); ?></span>
    </div>
</div>
<div class="row margin-top">
    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 text-center">
        Здесь - <span class="strong">в скаут центре</span> -
        вы можете изучить любимые стили игроков:
    </div>
</div>
<?php if (isset($confirm_data)) { ?>
    <form method="POST">
        <div class="row margin-top">
            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                Будут проведены следующие изучения:
                <ul>
                    <?php foreach ($confirm_data['style'] as $item) { ?>
                        <li><?= $item['name']; ?> - любимый стиль</li>
                        <input name="data[style][]" type="hidden" value="<?= $item['id']; ?>">
                    <?php } ?>
                </ul>
                Общая стоимость изучений <span class="strong"><?= f_igosja_money_format($confirm_data['price']); ?></span>
            </div>
        </div>
        <div class="row">
            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 text-center">
                <input name="data[ok]" type="hidden" value="1">
                <input class="btn margin" type="submit" value="Начать изучение"/>
                <a href="/scout.php" class="btn margin">Отказаться</a>
            </div>
        </div>
    </form>
<?php } elseif (isset($cancel_array)) { ?>
    <div class="row margin-top">
        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
            Будут отменены следующие изучения:
            <ul>
                <li><?= $cancel_array[0]['name_name']; ?> <?= $cancel_array[0]['surname_name']; ?> - любимый стиль</li>
            </ul>
            Общая компенсация за отмену изучений <span class="strong"><?= f_igosja_money_format($cancel_price); ?></span>
        </div>
    </div>
    <div class="row">
        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 text-center">
            <a href="/scout.php?cancel=<?= $cancel_get; ?>&ok=1" class="btn margin">Отменить изучение</a>
            <a href="/scout.php" class="btn margin">Вернуться</a>
        </div>
    </div>
<?php } else { ?>
    <?php if ($scout_array) { ?>
        <div class="row margin-top">
            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 text-center">
                Игроки вашей команды, находящиеся на изучении:
            </div>
        </div>
        <div class="row">
            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 table-responsive">
                <table class="table table-bordered table-hover">
                    <tr>
                        <th>Игрок</th>
                        <th class="col-1 hidden-xs" title="Национальность">Нац</th>
                        <th class="col-10" title="Позиция">Поз</th>
                        <th class="col-5" title="Возраст">В</th>
                        <th class="col-10" title="Номинальная сила">С</th>
                        <th class="col-15 hidden-xs" title="Спецвозможности">Спец</th>
                        <th class="col-10">Изучение</th>
                        <th class="col-10" title="Прогресс изучения">%</th>
                        <th class="col-1"></th>
                    </tr>
                    <?php foreach ($scout_array as $item) { ?>
                        <tr>
                            <td>
                                <a href="/player_view.php?num=<?= $item['player_id']; ?>">
                                    <?= $item['name_name']; ?>
                                    <?= $item['surname_name']; ?>
                                </a>
                            </td>
                            <td class="hidden-xs text-center">
                                <a href="/country_news.php?num=<?= $item['country_id']; ?>">
                                    <img
                                        src="/img/country/12/<?= $item['country_id']; ?>.png"
                                        title="<?= $item['country_name']; ?>"
                                    />
                                </a>
                            </td>
                            <td class="text-center"><?= f_igosja_player_position($item['player_id'], $scoutplayerposition_array); ?></td>
                            <td class="text-center"><?= $item['player_age']; ?></td>
                            <td class="text-center"><?= $item['player_power_nominal']; ?></td>
                            <td class="hidden-xs text-center"><?= f_igosja_player_special($item['player_id'], $scoutplayerspecial_array); ?></td>
                            <td class="text-center">Стиль</td>
                            <td class="text-center"><?= $item['scout_percent']; ?>%</td>
                            <td class="text-center">
                                <a href="/scout.php?cancel=<?= $item['scout_id']; ?>">
                                    <img alt="Отменить изучение стиля" src="/img/delete.png" title="Отменить изучение стиля" />
                                </a>
                            </td>
                        </tr>
                    <?php } ?>
                    <tr>
                        <th>Игрок</th>
                        <th class="hidden-xs" title="Национальность">Нац</th>
                        <th title="Позиция">Поз</th>
                        <th title="Возраст">В</th>
                        <th title="Номинальная сила">С</th>
                        <th class="hidden-xs" title="Спецвозможности">Спец</th>
                        <th>Изучение</th>
                        <th title="Прогресс изучения">%</th>
                        <th class="col-1"></th>
                    </tr>
                </table>
            </div>
        </div>
        <div class="row hidden-lg hidden-md hidden-sm">
            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                <a class="btn show-full-table" href="javascript:">
                    Показать полную таблицу
                </a>
            </div>
        </div>
    <?php } ?>
    <form method="POST">
        <div class="row margin-top">
            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 table-responsive">
                <table class="table table-bordered table-hover" id="grid">
                    <thead>
                        <tr>
                            <th data-type="player">Игрок</th>
                            <th class="col-1 hidden-xs" data-type="country" title="Национальность">Нац</th>
                            <th class="col-10" data-type="position" title="Позиция">Поз</th>
                            <th class="col-5" data-type="number" title="Возраст">В</th>
                            <th class="col-10" data-type="number" title="Номинальная сила">С</th>
                            <th class="col-15 hidden-xs" data-type="string" title="Спецвозможности">Спец</th>
                            <th class="col-15" data-type="string">Стиль</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php $i=0; foreach ($player_array as $item) { ?>
                            <tr data-order="<?= $i; ?>">
                                <td<?php if ($item['line_color']) { ?> style="background-color: #<?= $item['line_color']; ?>"<?php } ?>>
                                    <a href="/player_view.php?num=<?= $item['player_id']; ?>">
                                        <?= $item['name_name']; ?>
                                        <?= $item['surname_name']; ?>
                                    </a>
                                </td>
                                <td class="hidden-xs text-center">
                                    <a href="/country_news.php?num=<?= $item['country_id']; ?>">
                                        <img
                                            src="/img/country/12/<?= $item['country_id']; ?>.png"
                                            title="<?= $item['country_name']; ?>"
                                        />
                                    </a>
                                </td>
                                <td class="text-center">
                                    <?= f_igosja_player_position($item['player_id'], $playerposition_array); ?>
                                </td>
                                <td class="text-center"><?= $item['player_age']; ?></td>
                                <td class="text-center">
                                    <?= $item['player_power_nominal']; ?>
                                </td>
                                <td class="text-center hidden-xs">
                                    <?= f_igosja_player_special($item['player_id'], $playerspecial_array); ?>
                                </td>
                                <td class="text-center">
                                    <?php if ($item['count_scout'] < 2) { ?>
                                        <label class="hidden" for="style-<?= $item['player_id']; ?>"></label>
                                        <input id="style-<?= $item['player_id']; ?>" name="data[style][]" type="checkbox" value="<?= $item['player_id']; ?>" />
                                    <?php } ?>
                                    <?= f_igosja_style_scout($item['player_style_id'], $item['count_scout']); ?>
                                </td>
                            </tr>
                        <?php $i++; } ?>
                    </tbody>
                    <tfoot>
                        <tr>
                            <th>Игрок</th>
                            <th class="hidden-xs" title="Национальность">Нац</th>
                            <th title="Позиция">Поз</th>
                            <th title="Возраст">В</th>
                            <th title="Номинальная сила">С</th>
                            <th class="hidden-xs" title="Спецвозможности">Спец</th>
                            <th>Стиль</th>
                        </tr>
                    </tfoot>
                </table>
            </div>
        </div>
        <div class="row hidden-lg hidden-md hidden-sm">
            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                <a class="btn show-full-table" href="javascript:">
                    Показать полную таблицу
                </a>
            </div>
        </div>
        <div class="row">
            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 text-center">
                <input class="btn margin" type="submit" value="Продолжить" />
            </div>
        </div>
    </form>
<?php } ?>