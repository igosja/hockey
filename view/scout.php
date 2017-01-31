<div class="row margin-top">
    <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
        <?php include(__DIR__ . '/include/team_view_top_left.php'); ?>
    </div>
    <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12 text-right">
        <div class="row">
            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                Скаут центр
            </div>
        </div>
        <div class="row margin-top">
            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                Уровень:
                <span class="strong"><?= $basescout_array[0]['basescout_level']; ?></span>
            </div>
        </div>
        <div class="row">
            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                Скорость изучения:
                <span class="strong"><?= $basescout_array[0]['basescout_scout_speed_min']; ?>%</span>
                -
                <span class="strong"><?= $basescout_array[0]['basescout_scout_speed_max']; ?>%</span>
                за тур
            </div>
        </div>
        <div class="row">
            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                Осталось изучений стилей:
                <span class="strong"><?= $basescout_array[0]['basescout_my_style_count']; ?></span>
                из
                <span class="strong"><?= $basescout_array[0]['basescout_my_style_count']; ?></span>
            </div>
        </div>
    </div>
</div>
<div class="row margin-top">
    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 text-center">
        <span class="strong">Стоимость изучения:</span>
        Стиля
        <span class="strong"><?= f_igosja_money($basescout_array[0]['basescout_my_style_price']); ?></span>
    </div>
</div>
<div class="row margin-top">
    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 text-center">
        Здесь - <span class="strong">в скаут центре</span> -
        вы можете изучить любимые стили игроков:
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
                    Будут проведены следующие изучения:
                    <ul>
                        <?php foreach ($confirm_data['style'] as $item) { ?>
                            <li><?= $item['name']; ?> - любимый стиль</li>
                            <input name="data[style][]" type="hidden" value="<?= $item['id']; ?>">
                        <?php } ?>
                    </ul>
                    Общая стоимость изучений <?= f_igosja_money($confirm_data['price']); ?>
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
    <?php } ?>
<?php } ?>
<?php if ($scout_sql->num_rows) { ?>
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
                <th class="col-1" title="Национальность">Нац</th>
                <th class="col-10" title="Позиция">Поз</th>
                <th class="col-5" title="Возраст">В</th>
                <th class="col-10" title="Номинальная сила">С</th>
                <th class="col-15" title="Спецвозможности">Спец</th>
                <th class="col-10">Изучение</th>
                <th class="col-10" title="Прогресс тренировки">%</th>
            </tr>
            <?php foreach ($scout_array as $item) { ?>
                <tr>
                    <td>
                        <a href="/player_view.php?num=<?= $item['player_id']; ?>">
                            <?= $item['name_name']; ?>
                            <?= $item['surname_name']; ?>
                        </a>
                    </td>
                    <td class="text-center">
                        <a href="/country_news.php?num=<?= $item['country_id']; ?>">
                            <img
                                src="/img/country/12/<?= $item['country_id']; ?>.png"
                                title="<?= $item['country_name']; ?>"
                            />
                        </a>
                    </td>
                    <td class="text-center"><?= f_igosja_player_position($item['player_id']); ?></td>
                    <td class="text-center"><?= $item['player_age']; ?></td>
                    <td class="text-center"><?= $item['player_power_nominal']; ?></td>
                    <td class="text-center"><?= f_igosja_player_special($item['player_id']); ?></td>
                    <td class="text-center">Стиль</td>
                    <td class="text-center"><?= $item['scout_percent']; ?>%</td>
                </tr>
            <?php } ?>
            <tr>
                <th>Игрок</th>
                <th title="Национальность">Нац</th>
                <th title="Позиция">Поз</th>
                <th title="Возраст">В</th>
                <th title="Номинальная сила">С</th>
                <th title="Спецвозможности">Спец</th>
                <th>Изучение</th>
                <th title="Прогресс тренировки">%</th>
            </tr>
        </table>
    </div>
</div>
<?php } ?>
<form method="POST">
    <div class="row margin-top">
        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 table-responsive">
            <table class="table table-bordered table-hover">
                <tr>
                    <th>Игрок</th>
                    <th class="col-1" title="Национальность">Нац</th>
                    <th class="col-10" title="Позиция">Поз</th>
                    <th class="col-5" title="Возраст">В</th>
                    <th class="col-10" title="Номинальная сила">С</th>
                    <th class="col-15" title="Спецвозможности">Спец</th>
                    <th class="col-10">Стиль</th>
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
                            <a href="/country_news.php?num=<?= $item['country_id']; ?>">
                                <img
                                    src="/img/country/12/<?= $item['country_id']; ?>.png"
                                    title="<?= $item['country_name']; ?>"
                                />
                            </a>
                        </td>
                        <td class="text-center">
                            <?= f_igosja_player_position($item['player_id']); ?>
                        </td>
                        <td class="text-center"><?= $item['player_age']; ?></td>
                        <td class="text-center">
                            <?= $item['player_power_nominal']; ?>
                        </td>
                        <td class="text-center">
                            <?= f_igosja_player_special($item['player_id']); ?>
                        </td>
                        <td class="text-center">
                            <input name="data[style][]" type="checkbox" value="<?= $item['player_id']; ?>" />
                        </td>
                    </tr>
                <?php } ?>
                <tr>
                    <th>Игрок</th>
                    <th title="Национальность">Нац</th>
                    <th title="Позиция">Поз</th>
                    <th title="Возраст">В</th>
                    <th title="Номинальная сила">С</th>
                    <th title="Спецвозможности">Спец</th>
                    <th>Стиль</th>
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