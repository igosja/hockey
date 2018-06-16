<?php
/**
 * @var $basetraining_array array
 * @var $cancel_array array
 * @var $cancel_get integer
 * @var $cancel_price integer
 * @var $confirm_data array
 * @var $count_training integer
 * @var $on_building boolean
 * @var $player_array array
 * @var $training_array array
 * @var $training_available_position array
 * @var $training_available_power array
 * @var $training_available_special array
 * @var $training_error string
 */
?>
<div class="row margin-top">
    <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
        <?php include(__DIR__ . '/include/team_view_top_left.php'); ?>
    </div>
    <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12 text-right">
        <div class="row">
            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 strong text-size-1">
                Тренировочный центр
            </div>
        </div>
        <div class="row">
            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12<?php if ($on_building) { ?> del<?php } ?>">
                Уровень:
                <span class="strong"><?= $basetraining_array[0]['basetraining_level']; ?></span>
            </div>
        </div>
        <div class="row">
            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12<?php if ($on_building) { ?> del<?php } ?>">
                Скорость тренировки:
                <span class="strong"><?= $basetraining_array[0]['basetraining_training_speed_min']; ?>%</span>
                -
                <span class="strong"><?= $basetraining_array[0]['basetraining_training_speed_max']; ?>%</span>
                за тур
            </div>
        </div>
        <div class="row">
            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12<?php if ($on_building) { ?> del<?php } ?>">
                Осталось тренировок силы:
                <span class="strong"><?= $training_available_power; ?></span>
                из
                <span class="strong"><?= $basetraining_array[0]['basetraining_power_count']; ?></span>
            </div>
        </div>
        <div class="row">
            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12<?php if ($on_building) { ?> del<?php } ?>">
                Осталось спецвозможностей:
                <span class="strong"><?= $training_available_special; ?></span>
                из
                <span class="strong"><?= $basetraining_array[0]['basetraining_special_count']; ?></span>
            </div>
        </div>
        <div class="row">
            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12<?php if ($on_building) { ?> del<?php } ?>">
                Осталось совмещений:
                <span class="strong"><?= $training_available_position; ?></span>
                из
                <span class="strong"><?= $basetraining_array[0]['basetraining_position_count']; ?></span>
            </div>
        </div>
    </div>
</div>
<div class="row margin-top">
    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 text-center<?php if ($on_building) { ?> del<?php } ?>">
        <span class="strong">Стоимость тренировок:</span>
        Балл силы
        <span class="strong"><?= f_igosja_money_format($basetraining_array[0]['basetraining_power_price']); ?></span>
        Спецвозможность
        <span class="strong"><?= f_igosja_money_format($basetraining_array[0]['basetraining_special_price']); ?></span>
        Совмещение
        <span class="strong"><?= f_igosja_money_format($basetraining_array[0]['basetraining_position_price']); ?></span>
    </div>
</div>
<div class="row margin-top">
    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 text-center">
        Здесь - <span class="strong">в тренировочном центре</span> -
        вы можете назначить тренировки силы, спецвозможностей или совмещений своим игрокам:
    </div>
</div>
<?php if (isset($confirm_data)) { ?>
    <form method="POST">
        <div class="row margin-top">
            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                Будут проведены следующие тренировки:
                <ul>
                    <?php foreach ($confirm_data['power'] as $item) { ?>
                        <li><?= $item['name']; ?> +1 балл силы</li>
                        <input name="data[power][]" type="hidden" value="<?= $item['id']; ?>">
                    <?php } ?>
                    <?php foreach ($confirm_data['position'] as $item) { ?>
                        <li><?= $item['name']; ?> позиция <?= $item['position']['name']; ?></li>
                        <input name="data[position][]" type="hidden" value="<?= $item['id']; ?>:<?= $item['position']['id']; ?>">
                    <?php } ?>
                    <?php foreach ($confirm_data['special'] as $item) { ?>
                        <li><?= $item['name']; ?> спецвозможность <?= $item['special']['name']; ?></li>
                        <input name="data[special][]" type="hidden" value="<?= $item['id']; ?>:<?= $item['special']['id']; ?>">
                    <?php } ?>
                </ul>
                Общая стоимость тренировок <span class="strong"><?= f_igosja_money_format($confirm_data['price']); ?></span>
            </div>
        </div>
        <div class="row">
            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 text-center">
                <input name="data[ok]" type="hidden" value="1">
                <input class="btn margin" type="submit" value="Начать тренировку"/>
                <a href="/training.php" class="btn margin">Отказаться</a>
            </div>
        </div>
    </form>
<?php } elseif (isset($cancel_array)) { ?>
    <div class="row margin-top">
        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
            Будут отменены следующие тренировки:
            <ul>
                <li>
                    <?= $cancel_array[0]['name_name']; ?> <?= $cancel_array[0]['surname_name']; ?>
                    <?php if ($cancel_array[0]['position_short']) { ?>
                        позиция <?= $cancel_array[0]['position_short']; ?>
                    <?php } elseif ($cancel_array[0]['special_name']) { ?>
                        спецвозможность <?= $cancel_array[0]['special_name']; ?>
                    <?php } else { ?>
                        +1 балл силы
                    <?php } ?>
                </li>
            </ul>
            Общая компенсация за отмену тренировок <span class="strong"><?= f_igosja_money_format($cancel_price); ?></span>
        </div>
    </div>
    <div class="row">
        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 text-center">
            <a href="/training.php?cancel=<?= $cancel_get; ?>&ok=1" class="btn margin">Отменить тренировку</a>
            <a href="/training.php" class="btn margin">Вернуться</a>
        </div>
    </div>
<?php } else { ?>
    <?php if ($count_training) { ?>
        <div class="row margin-top">
            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 text-center">
                Игроки вашей команды, находящиеся на тренировке:
            </div>
        </div>
        <div class="row">
            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 table-responsive">
                <table class="table table-bordered table-hover">
                    <tr>
                        <th>Игрок</th>
                        <th class="col-1 hidden-xs" title="Национальность">Нац</th>
                        <th class="col-5" title="Возраст">В</th>
                        <th class="col-10" title="Номинальная сила">С</th>
                        <th class="col-10" title="Позиция">Поз</th>
                        <th class="col-10" title="Спецвозможности">Спец</th>
                        <th class="col-10" title="Прогресс тренировки">%</th>
                        <th class="col-1"></th>
                    </tr>
                    <?php foreach ($training_array as $item) { ?>
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
                                        alt="<?= $item['country_name']; ?>"
                                        src="/img/country/12/<?= $item['country_id']; ?>.png"
                                        title="<?= $item['country_name']; ?>"
                                    />
                                </a>
                            </td>
                            <td class="text-center"><?= $item['player_age']; ?></td>
                            <td class="text-center">
                                <?= $item['player_power_nominal']; ?>
                                <?php if ($item['training_power']) { ?>
                                    + 1
                                <?php } ?>
                            </td>
                            <td class="text-center">
                                <?= f_igosja_player_position($item['player_id'], $playerposition_array); ?>
                                <?php if ($item['position_short']) { ?>
                                    + <?= $item['position_short']; ?>
                                <?php } ?>
                            </td>
                            <td class="text-center">
                                <?= f_igosja_player_special($item['player_id'], $playerspecial_array); ?>
                                <?php if ($item['special_name']) { ?>
                                    + <?= $item['special_name']; ?>
                                <?php } ?>
                            </td>
                            <td class="text-center">
                                <?= $item['training_percent']; ?>%
                            </td>
                            <td class="text-center">
                                <a href="/training.php?cancel=<?= $item['training_id']; ?>">
                                    <img alt="Отменить тренировку" src="/img/delete.png" title="Отменить тренировку" />
                                </a>
                            </td>
                        </tr>
                    <?php } ?>
                    <tr>
                        <th>Игрок</th>
                        <th class="hidden-xs" title="Национальность">Нац</th>
                        <th title="Возраст">В</th>
                        <th title="Позиция">Поз</th>
                        <th title="Номинальная сила">С</th>
                        <th title="Спецвозможности">Спец</th>
                        <th title="Прогресс тренировки">%</th>
                        <th></th>
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
                            <th class="col-5" data-type="number" title="Возраст">В</th>
                            <th class="col-10" data-type="number" title="Номинальная сила">С</th>
                            <th class="col-15" data-type="position" title="Позиция">Поз</th>
                            <th class="col-15" data-type="string" title="Спецвозможности">Спец</th>
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
                                            alt="<?= $item['country_name']; ?>"
                                            src="/img/country/12/<?= $item['country_id']; ?>.png"
                                            title="<?= $item['country_name']; ?>"
                                        />
                                    </a>
                                </td>
                                <td class="text-center"><?= $item['player_age']; ?></td>
                                <td class="text-center">
                                    <?= $item['player_power_nominal']; ?>
                                    <?php if ($item['player_noaction'] < time()) { ?>
                                        <label class="hidden" for="power-<?= $item['player_id']; ?>">+1</label>
                                        <input id="power-<?= $item['player_id']; ?>" name="data[power][]" type="checkbox" value="<?= $item['player_id']; ?>" />
                                    <?php } ?>
                                </td>
                                <td class="text-center">
                                    <div class="row">
                                        <div class="col-lg-6 col-md-6 col-sm-6 col-xs-6">
                                            <?= f_igosja_player_position($item['player_id'], $playerposition_array); ?>
                                        </div>
                                        <div class="col-lg-6 col-md-6 col-sm-6 col-xs-6">
                                            <?php if ($item['player_noaction'] < time()) { ?>
                                                <?= f_igosja_player_position_training($item['player_id']); ?>
                                            <?php } ?>
                                        </div>
                                    </div>
                                </td>
                                <td class="text-center">
                                    <div class="row">
                                        <div class="col-lg-6 col-md-6 col-sm-6 col-xs-6">
                                            <?= f_igosja_player_special($item['player_id'], $playerspecial_array); ?>
                                        </div>
                                        <div class="col-lg-6 col-md-6 col-sm-6 col-xs-6">
                                            <?php if ($item['player_noaction'] < time()) { ?>
                                                <?= f_igosja_player_special_training($item['player_id']); ?>
                                            <?php } ?>
                                        </div>
                                    </div>
                                </td>
                            </tr>
                        <?php $i++; } ?>
                    </tbody>
                    <tfoot>
                        <tr>
                            <th>Игрок</th>
                            <th class="hidden-xs" title="Национальность">Нац</th>
                            <th title="Возраст">В</th>
                            <th title="Позиция">Поз</th>
                            <th title="Номинальная сила">С</th>
                            <th title="Спецвозможности">Спец</th>
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