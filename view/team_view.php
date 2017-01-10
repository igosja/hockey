<div class="row margin-top">
    <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
        <?php include(__DIR__ . '/include/team_view_left.php'); ?>
    </div>
    <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12 text-right">
        <?php include(__DIR__ . '/include/team_view_right.php'); ?>
    </div>
</div>
<div class="row margin-top">
    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
        Список с напоминаниями
    </div>
</div>
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
                <th title="Национальность" class="col-1">Нац</th>
                <th title="Позиция">Поз</th>
                <th title="Возраст">В</th>
                <th title="Номинальная сила">С</th>
                <th title="Усталость">У</th>
                <th title="Форма">Ф</th>
                <th title="Реальная сила">РС</th>
                <th title="Спецвозможности">Спец</th>
                <th title="Плюс/минус">+/-</th>
                <th title="Игр">И</th>
                <th title="Шайб">Ш</th>
                <th title="Результативных передач">П</th>
                <th>Цена</th>
                <th title="Играл/отдыхал подряд">И/О</th>
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
                    <td class="text-center">0</td>
                    <td class="text-center">0</td>
                    <td class="text-center">0</td>
                    <td class="text-center">0</td>
                    <td class="text-right"><?= f_igosja_money($item['player_price']); ?></td>
                    <td class="text-center"><?= $item['player_game_row']; ?></td>
                </tr>
            <?php } ?>
            <tr>
                <th>Игрок</th>
                <th title="Национальность">Нац</th>
                <th title="Позиция">Поз</th>
                <th title="Возраст">В</th>
                <th title="Номинальная сила">С</th>
                <th title="Усталость">У</th>
                <th title="Форма">Ф</th>
                <th title="Реальная сила">РС</th>
                <th title="Спецвозможности">Спец</th>
                <th title="Плюс/минус">+/-</th>
                <th title="Игр">И</th>
                <th title="Шайб">Ш</th>
                <th title="Результативных передач">П</th>
                <th>Цена</th>
                <th title="Играл/отдыхал подряд">И/О</th>
            </tr>
        </table>
    </div>
</div>
<div class="row">
    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
        <?php include(__DIR__ . '/include/team_table_link.php'); ?>
    </div>
</div>
<div class="row">
    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
        <div class="row text-size-4"><?= SPACE; ?></div>
    </div>
</div>
<div class="row">
    <div class="col-lg-6 col-md-6 col-sm-6 col-xs-6">
        Показатели команды
    </div>
    <div class="col-lg-6 col-md-6 col-sm-6 col-xs-6">
        Последнее с форума
    </div>
</div>