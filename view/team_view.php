<div class="row margin-top">
    <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
        <?php include(__DIR__ . '/include/team_view_top_left.php'); ?>
    </div>
    <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12 text-right">
        <?php include(__DIR__ . '/include/team_view_top_right.php'); ?>
    </div>
</div>
<?php if (isset($auth_team_id) && $auth_team_id == $num_get) { ?>
    <div class="row margin-top">
        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
            Список с напоминаниями
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
        <table class="table table-bordered table-hover">
            <tr>
                <th>Игрок</th>
                <th class="col-1 hidden-xs" title="Национальность">Нац</th>
                <th class="col-5" title="Позиция">Поз</th>
                <th class="col-5" title="Возраст">В</th>
                <th class="col-5" title="Номинальная сила">С</th>
                <th class="col-5" title="Усталость">У</th>
                <th class="col-5" title="Форма">Ф</th>
                <th class="col-5" title="Реальная сила">РС</th>
                <th class="col-10" title="Спецвозможности">Спец</th>
                <th class="col-5 hidden-xs" title="Плюс/минус">+/-</th>
                <th class="col-5 hidden-xs" title="Игр">И</th>
                <th class="col-5 hidden-xs" title="Шайб">Ш</th>
                <th class="col-5 hidden-xs" title="Результативных передач">П</th>
                <th class="col-10 hidden-xs">Цена</th>
                <th class="col-5" title="Играл/отдыхал подряд">ИО</th>
            </tr>
            <?php foreach ($player_array as $item) { ?>
                <tr>
                    <td>
                        <a href="/player_view.php?num=<?= $item['player_id']; ?>">
                            <?= $item['name_name']; ?>
                            <?= $item['surname_name']; ?>
                        </a>
                    </td>
                    <td class="hidden-xs text-center">
                        <a href="/country_view.php?num=<?= $item['country_id']; ?>">
                            <img
                                src="/img/country/12/<?= $item['country_id']; ?>.png"
                                title="<?= $item['country_name']; ?>"
                            />
                        </a>
                    </td>
                    <td class="text-center"><?= f_igosja_player_position($item['playerposition_position_id']); ?></td>
                    <td class="text-center"><?= $item['player_age']; ?></td>
                    <td class="text-center"><?= $item['player_power_nominal']; ?></td>
                    <td class="text-center"><?= $item['player_tire']; ?></td>
                    <td class="text-center">
                        <img
                            src="/img/phisical/<?= $item['phisical_id']; ?>.png"
                            title="<?= $item['phisical_value']; ?>%"
                        />
                    </td>
                    <td class="text-center"><?= $item['player_power_real']; ?></td>
                    <td class="text-center"><?= f_igosja_player_special($item['playerspecial_special_id']); ?></td>
                    <td class="hidden-xs text-center">0</td>
                    <td class="hidden-xs text-center">0</td>
                    <td class="hidden-xs text-center">0</td>
                    <td class="hidden-xs text-center">0</td>
                    <td class="hidden-xs text-right"><?= f_igosja_money($item['player_price']); ?></td>
                    <td class="text-center"><?= $item['player_game_row']; ?></td>
                </tr>
            <?php } ?>
            <tr>
                <th>Игрок</th>
                <th class="hidden-xs" title="Национальность">Нац</th>
                <th title="Позиция">Поз</th>
                <th title="Возраст">В</th>
                <th title="Номинальная сила">С</th>
                <th title="Усталость">У</th>
                <th title="Форма">Ф</th>
                <th title="Реальная сила">РС</th>
                <th title="Спецвозможности">Спец</th>
                <th title="Плюс/минус" class="hidden-xs">+/-</th>
                <th class="hidden-xs" title="Игр">И</th>
                <th class="hidden-xs" title="Шайб">Ш</th>
                <th class="hidden-xs" title="Результативных передач">П</th>
                <th class="hidden-xs">Цена</th>
                <th title="Играл/отдыхал подряд">ИО</th>
            </tr>
        </table>
    </div>
</div>
<div class="row">
    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
        <?php include(__DIR__ . '/include/team_table_link.php'); ?>
    </div>
</div>
<div class="row margin-top">
    <div class="col-lg-5 col-md-5 col-sm-5 col-xs-12">
        <span class="italic">Показатели команды:</span>
        <div class="row">
            <div class="col-lg-8 col-md-8 col-sm-8 col-xs-8">
                - Рейтинг силы команды (Vs)
            </div>
            <div class="col-lg-4 col-md-4 col-sm-4 col-xs-4 text-right">
                0
            </div>
        </div>
        <div class="row">
            <div class="col-lg-8 col-md-8 col-sm-8 col-xs-8">
                - Сила 16 лучших (s16)
            </div>
            <div class="col-lg-4 col-md-4 col-sm-4 col-xs-4 text-right">
                0
            </div>
        </div>
        <div class="row">
            <div class="col-lg-8 col-md-8 col-sm-8 col-xs-8">
                - Сила 21 лучшего (s21)
            </div>
            <div class="col-lg-4 col-md-4 col-sm-4 col-xs-4 text-right">
                0
            </div>
        </div>
        <div class="row">
            <div class="col-lg-8 col-md-8 col-sm-8 col-xs-8">
                - Сила 27 лучших (s27)
            </div>
            <div class="col-lg-4 col-md-4 col-sm-4 col-xs-4 text-right">
                0
            </div>
        </div>
        <div class="row">
            <div class="col-lg-8 col-md-8 col-sm-8 col-xs-8">
                - Стоимость строений
            </div>
            <div class="col-lg-4 col-md-4 col-sm-4 col-xs-4 text-right">
                <?= f_igosja_money(0); ?>
            </div>
        </div>
        <div class="row">
            <div class="col-lg-8 col-md-8 col-sm-8 col-xs-8">
                - Общая стоимость
            </div>
            <div class="col-lg-4 col-md-4 col-sm-4 col-xs-4 text-right">
                <?= f_igosja_money(0); ?>
            </div>
        </div>
        <div class="row margin-top">
            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                Расскажите всем о лиге - vk, fb, ok, tw
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