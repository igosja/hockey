<div class="row margin-top">
    <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
        <div class="row">
            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 text-size-1 strong">
                <?= $team_array[0]['team_name']; ?>
                (<?= $team_array[0]['city_name']; ?>, <?= $team_array[0]['country_name']; ?>)
            </div>
        </div>
        <div class="row text-size-4"><?= SPACE; ?></div>
        <div class="row">
            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 text-size-3">
                Кубок межсезонья: <a href="javascript:;">12345 место</a>
            </div>
        </div>
        <div class="row">
            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 text-size-3">
                Дивизон: <a href="javascript:;">Страна, Дивизион, 12 место</a>
            </div>
        </div>
        <div class="row text-size-4"><?= SPACE; ?></div>
        <div class="row">
            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                Менежер:
                (Письмо) <a class="strong" href="javascript:;"><?= $team_array[0]['user_login']; ?></a>
            </div>
        </div>
        <div class="row">
            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                Ник:
                (ВИП)
                <a class="strong" href="javascript:;">
                    <?= $team_array[0]['user_name']; ?> <?= $team_array[0]['user_surname']; ?>
                </a>
            </div>
        </div>
        <div class="row text-size-4"><?= SPACE; ?></div>
        <div class="row">
            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                Заместитель: (Письмо) <a class="strong" href="javascript:;">Имя</a>
            </div>
        </div>
        <div class="row">
            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                Ник: (ВИП) <a class="strong" href="javascript:;">Логин</a>
            </div>
        </div>
        <div class="row text-size-4"><?= SPACE; ?></div>
        <div class="row">
            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                Стадион:
                <?= $team_array[0]['stadium_name']; ?>,
                <strong><?= $team_array[0]['stadium_capacity']; ?></strong>
                <img src="/img/cog.png"/>
                <img src="/img/loupe.png"/>
            </div>
        </div>
        <div class="row">
            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                База: <span class="strong"><?= $team_array[0]['team_base_id']; ?></span> уровень
                (<span class="italic"><?= $team_array[0]['team_base_slot_used']; ?></span>
                из
                <span class="strong">22</span> слотов)
                <img src="/img/cog.png"/>
                <a href="base.php?num=<?= $num_get; ?>"><img src="/img/loupe.png"/></a>
            </div>
        </div>
        <div class="row text-size-4"><?= SPACE; ?></div>
        <div class="row">
            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                Финансы:
                <span class="strong"><?= f_igosja_money($team_array[0]['team_finance']); ?></span>
            </div>
        </div>
    </div>
    <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12 text-right">
        <div class="row">
            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 text-size-3 italic">
                - Уезжая надолго и без интернета - не забудьте поставить статус "в отпуске" -
            </div>
            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                <img src="http://virtualsoccer.ru/menu/new/squad_big.gif"/>
                <img src="http://virtualsoccer.ru/menu/new/squad_big.gif"/>
                <img src="http://virtualsoccer.ru/menu/new/squad_big.gif"/>
                <img src="http://virtualsoccer.ru/menu/new/squad_big.gif"/>
                <img src="http://virtualsoccer.ru/menu/new/squad_big.gif"/>
                <img src="http://virtualsoccer.ru/menu/new/squad_big.gif"/>
                <img src="http://virtualsoccer.ru/menu/new/squad_big.gif"/>
                <img src="http://virtualsoccer.ru/menu/new/squad_big.gif"/>
                <img src="http://virtualsoccer.ru/menu/new/squad_big.gif"/>
                <img src="http://virtualsoccer.ru/menu/new/squad_big.gif"/>
            </div>
            <?php foreach ($latest_array as $item) { ?>
                <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 text-size-3 italic">
                    <?= f_igosja_ufu_date_time($item['shedule_date']); ?>
                    -
                    <?= $item['tournamenttype_name']; ?>
                    -
                    <?= $item['home_guest']; ?>
                    -
                    <a href="/team_view.php?num=<?= $item['team_id']; ?>">
                        <?= $item['team_name']; ?>
                    </a>
                    -
                    <a href="/game_view.php?num=<?= $item['game_id']; ?>">
                        <?= $item['home_score']; ?>:<?= $item['guest_score']; ?>
                    </a>
                </div>
            <?php } ?>
            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                <div class="row text-size-4"><?= SPACE; ?></div>
            </div>
            <?php foreach ($nearest_array as $item) { ?>
                <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 text-size-3 italic">
                    <?= f_igosja_ufu_date_time($item['shedule_date']); ?>
                    -
                    <?= $item['tournamenttype_name']; ?>
                    -
                    <?= $item['home_guest']; ?>
                    -
                    <a href="/team_view.php?num=<?= $item['team_id']; ?>">
                        <?= $item['team_name']; ?>
                    </a>
                    -
                    <a href="/game_send.php?num=<?= $item['game_id']; ?>">
                        Отпр.
                    </a>
                </div>
            <?php } ?>
        </div>
    </div>
</div>
<div class="row">
    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
        <div class="row text-size-4"><?= SPACE; ?></div>
    </div>
</div>
<div class="row">
    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
        Список с напоминаниями
    </div>
</div>
<div class="row">
    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
        <div class="row text-size-4"><?= SPACE; ?></div>
    </div>
</div>
<div class="row">
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
                    <td class="text-center"><?= f_igosja_player_position($item['player_id']); ?></td>
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
                    <td class="text-center"><?= f_igosja_player_special($item['player_id']); ?></td>
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