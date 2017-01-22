<div class="row margin-top">
    <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
        <?php include(__DIR__ . '/include/team_view_top_left.php'); ?>
    </div>
    <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12 text-right">
        <div class="row">
            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                Тренировочный центр
            </div>
        </div>
        <div class="row margin-top">
            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                Уровень:
                <span class="strong"><?= $basetraining_array[0]['basetraining_level']; ?></span>
            </div>
        </div>
        <div class="row">
            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                Скорость тренировки:
                <span class="strong"><?= $basetraining_array[0]['basetraining_training_speed_min']; ?>%</span>
                -
                <span class="strong"><?= $basetraining_array[0]['basetraining_training_speed_max']; ?>%</span>
                за тур
            </div>
        </div>
        <div class="row">
            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                Осталось тренировок силы:
                <span class="strong"><?= $basetraining_array[0]['basetraining_power_count']; ?></span>
                из
                <span class="strong"><?= $basetraining_array[0]['basetraining_power_count']; ?></span>
            </div>
        </div>
        <div class="row">
            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                Осталось спецвозможностей:
                <span class="strong"><?= $basetraining_array[0]['basetraining_special_count']; ?></span>
                из
                <span class="strong"><?= $basetraining_array[0]['basetraining_special_count']; ?></span>
            </div>
        </div>
        <div class="row">
            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                Осталось совмещений:
                <span class="strong"><?= $basetraining_array[0]['basetraining_position_count']; ?></span>
                из
                <span class="strong"><?= $basetraining_array[0]['basetraining_position_count']; ?></span>
            </div>
        </div>
    </div>
</div>
<div class="row margin-top">
    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 text-center">
        <span class="strong">Стоимость тренировок:</span>
        Балл силы
        <span class="strong"><?= f_igosja_money($basetraining_array[0]['basetraining_power_price']); ?></span>
        Спецвозможность
        <span class="strong"><?= f_igosja_money($basetraining_array[0]['basetraining_special_price']); ?></span>
        Совмещение
        <span class="strong"><?= f_igosja_money($basetraining_array[0]['basetraining_position_price']); ?></span>
    </div>
</div>
<div class="row margin-top">
    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 text-center">
        Здесь - <span class="strong">в тренировочном центре</span> -
        вы можете назначить тренировки силы, спецвозможностей или совмещений своим игрокам:
    </div>
</div>
<?php if (isset($confirm_data)) { ?>
    <?php if ($confirm_data['error']) { ?>
        <div class="row margin-top">
            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 text-center alert error">
                <?= $confirm_data['error']; ?>
            </div>
        </div>
    <?php } else { ?>
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
                    Общая стоимость тренировок <?= f_igosja_money($confirm_data['price']); ?>
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
    <?php } ?>
<?php } ?>
<form method="POST">
    <div class="row margin-top">
        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 table-responsive">
            <table class="table table-bordered table-hover">
                <tr>
                    <th>Игрок</th>
                    <th class="col-1" title="Национальность">Нац</th>
                    <th class="col-5" title="Возраст">В</th>
                    <th class="col-10" title="Номинальная сила">С</th>
                    <th class="col-15" title="Позиция">Поз</th>
                    <th class="col-15" title="Спецвозможности">Спец</th>
                </tr>
                <?php foreach ($player_array as $item) { ?>
                    <tr>
                        <td>
                            <a href="/player_view.php?num=<?= $item['player_id']; ?>">
                                <?= $item['name_name']; ?>
                                <?= $item['surname_name']; ?>
                            </a>
                        </td>
                        <td class="text-center">
                            <a href="/country_view.php?num=<?= $item['country_id']; ?>">
                                <img
                                    src="/img/country/12/<?= $item['country_id']; ?>.png"
                                    title="<?= $item['country_name']; ?>"
                                />
                            </a>
                        </td>
                        <td class="text-center"><?= $item['player_age']; ?></td>
                        <td class="text-center">
                            <?= $item['player_power_nominal']; ?>
                            <input name="data[power][]" type="checkbox" value="<?= $item['player_id']; ?>" />
                        </td>
                        <td class="text-center">
                            <div class="row">
                                <div class="col-lg-6 col-md-6 col-sm-6 col-xs-6">
                                    <?= f_igosja_player_position($item['player_id']); ?>
                                </div>
                                <div class="col-lg-6 col-md-6 col-sm-6 col-xs-6">
                                    <?= f_igosja_player_position_training($item['player_id']); ?>
                                </div>
                            </div>
                        </td>
                        <td class="text-center">
                            <div class="row">
                                <div class="col-lg-6 col-md-6 col-sm-6 col-xs-6">
                                    <?= f_igosja_player_special($item['player_id']); ?>
                                </div>
                                <div class="col-lg-6 col-md-6 col-sm-6 col-xs-6">
                                    <?= f_igosja_player_special_training($item['player_id']); ?>
                                </div>
                            </div>
                        </td>
                    </tr>
                <?php } ?>
                <tr>
                    <th>Игрок</th>
                    <th title="Национальность">Нац</th>
                    <th title="Возраст">В</th>
                    <th title="Позиция">Поз</th>
                    <th title="Номинальная сила">С</th>
                    <th title="Спецвозможности">Спец</th>
                </tr>
            </table>
        </div>
    </div>
    <div class="row">
        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 text-center">
            <input class="btn margin" type="submit" value="Продолжить" />
        </div>
    </div>
</form>