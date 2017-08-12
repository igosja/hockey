<?php
/**
 * @var $basephisical_array array
 * @var $on_building boolean
 * @var $phisical_available integer
 * @var $player_array array
 * @var $schedule_array array
 */
?>
<div class="row margin-top">
    <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
        <?php include(__DIR__ . '/include/team_view_top_left.php'); ?>
    </div>
    <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12 text-right">
        <div class="row">
            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 strong text-size-1">
                Центр физподготовки
            </div>
        </div>
        <div class="row">
            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12<?php if ($on_building) { ?> del<?php } ?>">
                Уровень:
                <span class="strong"><?= $basephisical_array[0]['basephisical_level']; ?></span>
            </div>
        </div>
        <div class="row">
            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12<?php if ($on_building) { ?> del<?php } ?>">
                Бонус к изменению услатости:
                <span class="strong"><?= $basephisical_array[0]['basephisical_tire_bonus']; ?>%</span>
            </div>
        </div>
        <div class="row">
            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12<?php if ($on_building) { ?> del<?php } ?>">
                Осталось изменений формы:
                <span class="strong" id="phisical-available"><?= $phisical_available; ?></span>
                из
                <span class="strong"><?= $basephisical_array[0]['basephisical_change_count']; ?></span>
            </div>
        </div>
    </div>
</div>
<div class="row margin-top">
    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 text-center">
        Здесь - <span class="strong">в физцентре</span> -
        вы можете поменять физическую форму для игроков своей команды:
    </div>
</div>
<div class="row margin-top">
    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 table-responsive">
        <table class="table table-bordered table-hover">
            <tr>
                <th>Игрок</th>
                <th title="Позиция">Поз</th>
                <th title="Возраст">В</th>
                <th title="Номинальная сила">С</th>
                <?php foreach ($schedule_array as $schedule) { ?>
                    <th>
                        <img src="/phisical_image.php?num=<?= $schedule['schedule_date']; ?>"/>
                    </th>
                <?php } ?>
            </tr>
            <?php foreach ($player_array as $item) { ?>
                <tr class="phisical-change-row">
                    <td>
                        <a href="/player_view.php?num=<?= $item['player_id']; ?>">
                            <?= $item['name_name']; ?>&nbsp;<?= $item['surname_name']; ?>
                        </a>
                    </td>
                    <td class="text-center"><?= f_igosja_player_position($item['player_id'], $playerposition_array); ?></td>
                    <td class="text-center"><?= $item['player_age']; ?></td>
                    <td class="text-center"><?= $item['player_power_nominal']; ?></td>
                    <?php foreach ($item['phisical_array'] as $phisical) { ?>
                        <td
                            class="text-center <?= $phisical['class']; ?>"
                            data-phisical="<?= $phisical['phisical_id']; ?>"
                            data-player="<?= $phisical['player_id']; ?>"
                            data-schedule="<?= $phisical['schedule_id']; ?>"
                            id="<?= $phisical['id']; ?>"
                        >
                            <img
                                src="/img/phisical/<?= $phisical['phisical_id']; ?>.png"
                                title="<?= $phisical['phisical_value']; ?>%"
                            />
                        </td>
                    <?php } ?>
                </tr>
            <?php } ?>
            <tr>
                <th>Игрок</th>
                <th title="Позиция">Поз</th>
                <th title="Возраст">В</th>
                <th title="Номинальная сила">С</th>
                <?php foreach ($schedule_array as $schedule) { ?>
                    <th>
                        <img src="/phisical_image.php?num=<?= $schedule['schedule_date']; ?>"/>
                    </th>
                <?php } ?>
            </tr>
        </table>
    </div>
</div>