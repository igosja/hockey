<?php
/**
 * @var $auth_relation_id integer
 * @var $auth_relation_name string
 * @var $auth_team_id integer
 * @var $notification_array array
 * @var $num_get integer
 * @var $player_array array
 * @var $playerposition_array array
 * @var $playerspecial_array array
 * @var $relation_array array
 */
?>
<div class="row margin-top">
    <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
        <?php include(__DIR__ . '/include/national_view_top_left.php'); ?>
    </div>
    <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12 text-right">
        <?php include(__DIR__ . '/include/national_view_top_right.php'); ?>
    </div>
</div>
<?php if (isset($relation_array)) { ?>
    <form method="post">
        <div class="row text-center">
            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 relation-head">
                Ваше отношение к тренеру:
                <a href="javascript:" id="relation-link"><?= $auth_relation_name; ?></a>
            </div>
            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 relation-body hidden">
                <div class="row text-left">
                    <div class="col-lg-3 col-md-3 col-sm-2"></div>
                    <?php foreach ($relation_array as $item) { ?>
                        <div class="hidden-lg hidden-md hidden-sm col-xs-3"></div>
                        <div class="col-lg-2 col-md-2 col-sm-3 col-xs-9">
                            <input
                                id="rating-<?= $item['relation_id']; ?>"
                                name="data[vote_national]"
                                type="radio"
                                value="<?= $item['relation_id']; ?>"
                                <?php if ($auth_relation_id == $item['relation_id']) { ?>
                                    checked
                                <?php } ?>
                            />
                            <label for="rating-<?= $item['relation_id']; ?>"><?= $item['relation_name']; ?></label>
                        </div>
                    <?php } ?>
                </div>
                <div class="row">
                    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                        <p>
                            <input type="submit" class="btn" value="Изменить отношение"/>
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </form>
<?php } ?>
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
        <?php include(__DIR__ . '/include/national_table_link.php'); ?>
    </div>
</div>
<div class="row">
    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 table-responsive">
        <table class="table table-bordered table-hover">
            <tr>
                <th>Игрок</th>
                <th class="col-5" title="Позиция">Поз</th>
                <th class="col-5" title="Возраст">В</th>
                <th class="col-5" title="Номинальная сила">С</th>
                <th class="col-5" title="Усталость">У</th>
                <th class="col-5" title="Форма">Ф</th>
                <th class="col-5" title="Реальная сила">РС</th>
                <th class="col-10 hidden-xs" title="Спецвозможности">Спец</th>
                <th class="col-5 hidden-xs" title="Плюс/минус">+/-</th>
                <th class="col-5 hidden-xs" title="Игр">И</th>
                <th class="col-5 hidden-xs" title="Шайб">Ш</th>
                <th class="col-5 hidden-xs" title="Результативных передач">П</th>
                <th class="col-10 hidden-xs">Цена</th>
                <th class="col-5 hidden-xs" title="Играл/отдыхал подряд">ИО</th>
            </tr>
            <?php foreach ($player_array as $item) { ?>
                <tr>
                    <td>
                        <a href="/player_view.php?num=<?= $item['player_id']; ?>">
                            <?= $item['name_name']; ?>
                            <?= $item['surname_name']; ?>
                        </a>
                        <br/>
                        <span class="font-grey text-size-3">
                            <a href="/team_view.php?num=<?= $item['team_id']; ?>">
                                <?= $item['team_name']; ?>
                                (<?= $item['city_name']; ?>, <?= $item['country_name']; ?>)
                            </a>
                        </span>
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
                        <?php if (isset($auth_national_id) && $auth_national_id == $num_get) { ?>
                            <?= $item['player_tire']; ?>
                        <?php } else { ?>
                            ?
                        <?php } ?>
                    </td>
                    <td class="text-center">
                        <?php if (isset($auth_national_id) && $auth_national_id == $num_get) { ?>
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
                        <?php if (isset($auth_national_id) && $auth_national_id == $num_get) { ?>
                            <?= $item['player_power_real']; ?>
                        <?php } else { ?>
                            ~<?= $item['player_power_nominal']; ?>
                        <?php } ?>
                    </td>
                    <td class="hidden-xs text-center"><?= f_igosja_player_special($item['player_id'], $playerspecial_array); ?></td>
                    <td class="hidden-xs text-center">0</td>
                    <td class="hidden-xs text-center">0</td>
                    <td class="hidden-xs text-center">0</td>
                    <td class="hidden-xs text-center">0</td>
                    <td class="hidden-xs text-right"><?= f_igosja_money_format($item['player_price']); ?></td>
                    <td class="hidden-xs text-center"><?= $item['player_game_row']; ?></td>
                </tr>
            <?php } ?>
            <tr>
                <th>Игрок</th>
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
                <th class="hidden-xs" title="Играл/отдыхал подряд">ИО</th>
            </tr>
        </table>
    </div>
</div>
<div class="row">
    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
        <?php include(__DIR__ . '/include/national_table_link.php'); ?>
    </div>
</div>
<div class="row hidden-lg hidden-md hidden-sm">
    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
        <a class="btn show-full-table" href="javascript:">
            Показать полную таблицу
        </a>
    </div>
</div>