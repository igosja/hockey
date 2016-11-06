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
                <img src="/img/loupe.png"/>
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
            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 text-size-3 italic">
                5 октября, 22:00 - Кубок межсезонья - Д - Команда - 3:2
            </div>
            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 text-size-3 italic">
                5 октября, 22:00 - Кубок межсезонья - Д - Команда - 3:2
            </div>
            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                <div class="row text-size-4"><?= SPACE; ?></div>
            </div>
            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 text-size-3 italic">
                5 октября, 22:00 - Кубок межсезонья - Д - Команда - Ред.
            </div>
            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 text-size-3 italic">
                5 октября, 22:00 - Кубок межсезонья - Д - Команда - Отпр.
            </div>
            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 text-size-3 italic">
                5 октября, 22:00 - Кубок межсезонья - Д - Команда - Отпр.
            </div>
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
        <?php include(__DIR__ . '/include/team_table_link.php'); ?>
    </div>
</div>
<div class="row">
    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 table-responsive">
        <table class="table table-bordered table-hover">
            <tr>
                <th>Дата</th>
                <th>Турнир</th>
                <th>Стадия</th>
                <th>Соперник</th>
                <th title="Автосостав">А</th>
                <th>Счёт</th>
            </tr>
            <?php foreach ($game_array as $item) { ?>
                <tr>
                    <td class="text-center"><?= f_igosja_ufu_date_time($item['shedule_date']); ?></td>
                    <td class="text-center"><?= $item['tournamenttype_name']; ?></td>
                    <td class="text-center"><?= $item['stage_name']; ?></td>
                    <td>
                        <a href="/team_view.php?num=<?= $item['team_id']; ?>">
                            <?= $item['team_name']; ?> (<?= $item['city_name']; ?>, <?= $item['country_name']; ?>)
                        </a>
                    </td>
                    <td class="text-center"><?= f_igosja_game_auto($item['game_auto']); ?></td>
                    <td class="text-center">
                        <a href="/game_view.php?num=<?= $item['game_id']; ?>">
                            <?= f_igosja_game_score($item['game_played'], $item['game_home_score'], $item['game_guest_score']); ?>
                        </a>
                    </td>
                </tr>
            <?php } ?>
            <tr>
                <th>Дата</th>
                <th>Турнир</th>
                <th>Стадия</th>
                <th>Соперник</th>
                <th title="Автосостав">А</th>
                <th>Счёт</th>
            </tr>
        </table>
    </div>
</div>
<div class="row">
    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
        <?php include(__DIR__ . '/include/team_table_link.php'); ?>
    </div>
</div>