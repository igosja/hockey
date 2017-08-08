<?php
/**
 * @var $auth_team_id integer
 * @var $notification_array array
 * @var $num_get integer
 * @var $player_array array
 * @var $playerposition_array array
 * @var $playerspecial_array array
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
                        <a href="/team_view.php?num=<?= $item['team_id']; ?>">
                            <?= $item['team_name']; ?>
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
                    <td class="text-center"><?= $item['player_tire']; ?></td>
                    <td class="text-center">
                        <img
                            alt="<?= $item['phisical_value']; ?>%"
                            src="/img/phisical/<?= $item['phisical_id']; ?>.png"
                            title="<?= $item['phisical_value']; ?>%"
                        />
                    </td>
                    <td class="text-center"><?= $item['player_power_real']; ?></td>
                    <td class="hidden-xs text-center"><?= f_igosja_player_special($item['player_id'], $playerspecial_array); ?></td>
                    <td class="hidden-xs text-center">0</td>
                    <td class="hidden-xs text-center">0</td>
                    <td class="hidden-xs text-center">0</td>
                    <td class="hidden-xs text-center">0</td>
                    <td class="hidden-xs text-right"><?= f_igosja_money($item['player_price']); ?></td>
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