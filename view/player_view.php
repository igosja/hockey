<div class="row margin-top">
    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 text-size-1 strong">
        <?= $player_array[0]['name_name']; ?> <?= $player_array[0]['surname_name']; ?>
    </div>
    <div class="row margin-top">
        <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
            <div class="row">
                <div class="col-lg-6 col-md-6 col-sm-6 col-xs-6">
                    Национальность:
                </div>
                <div class="col-lg-6 col-md-6 col-sm-6 col-xs-6">
                    <img
                        src="/img/country/12/<?= $player_array[0]['country_id']; ?>.png"
                    />
                    <a href="/country_view.php?num=<?= $player_array[0]['country_id']; ?>">
                        <?= $player_array[0]['country_name']; ?>
                    </a>
                </div>
            </div>
            <div class="row">
                <div class="col-lg-6 col-md-6 col-sm-6 col-xs-6">
                    Возраст:
                </div>
                <div class="col-lg-6 col-md-6 col-sm-6 col-xs-6">
                    <?= $player_array[0]['player_age']; ?>
                </div>
            </div>
            <div class="row">
                <div class="col-lg-6 col-md-6 col-sm-6 col-xs-6">
                    Сила:
                </div>
                <div class="col-lg-6 col-md-6 col-sm-6 col-xs-6">
                    <?= $player_array[0]['player_power_nominal']; ?>
                </div>
            </div>
            <div class="row">
                <div class="col-lg-6 col-md-6 col-sm-6 col-xs-6">
                    Усталость:
                </div>
                <div class="col-lg-6 col-md-6 col-sm-6 col-xs-6">
                    <?= $player_array[0]['player_tire']; ?>%
                </div>
            </div>
            <div class="row">
                <div class="col-lg-6 col-md-6 col-sm-6 col-xs-6">
                    Форма на сегодня:
                </div>
                <div class="col-lg-6 col-md-6 col-sm-6 col-xs-6">
                    <img
                        src="/img/phisical/<?= $player_array[0]['phisical_id']; ?>.png"
                        title="<?= $player_array[0]['phisical_value']; ?>%"
                    />
                </div>
            </div>
            <div class="row">
                <div class="col-lg-6 col-md-6 col-sm-6 col-xs-6">
                    Реальная сила:
                </div>
                <div class="col-lg-6 col-md-6 col-sm-6 col-xs-6">
                    <?= $player_array[0]['player_power_real']; ?>
                </div>
            </div>
        </div>
        <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
            <div class="row">
                <div class="col-lg-6 col-md-6 col-sm-6 col-xs-6">
                    Команда:
                </div>
                <div class="col-lg-6 col-md-6 col-sm-6 col-xs-6">
                    <a href="/team_view.php?num=<?= $player_array[0]['team_id']; ?>">
                        <?= $player_array[0]['team_name']; ?>
                    </a>
                </div>
            </div>
            <div class="row">
                <div class="col-lg-6 col-md-6 col-sm-6 col-xs-6">
                    Позиция:
                </div>
                <div class="col-lg-6 col-md-6 col-sm-6 col-xs-6">
                    <?= f_igosja_player_position($player_array[0]['player_id']); ?>
                </div>
            </div>
            <div class="row">
                <div class="col-lg-6 col-md-6 col-sm-6 col-xs-6">
                    Спецвозможности:
                </div>
                <div class="col-lg-6 col-md-6 col-sm-6 col-xs-6">
                    <?= f_igosja_player_special($player_array[0]['player_id']); ?>
                </div>
            </div>
            <div class="row">
                <div class="col-lg-6 col-md-6 col-sm-6 col-xs-6">
                    Зарплата за тур:
                </div>
                <div class="col-lg-6 col-md-6 col-sm-6 col-xs-6">
                    <?= f_igosja_money($player_array[0]['player_salary']); ?>
                </div>
            </div>
            <div class="row">
                <div class="col-lg-6 col-md-6 col-sm-6 col-xs-6">
                    Стоимость:
                </div>
                <div class="col-lg-6 col-md-6 col-sm-6 col-xs-6">
                    <?= f_igosja_money($player_array[0]['player_salary']); ?>
                </div>
            </div>
        </div>
    </div>
</div>
<div class="row margin-top">
    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
        <?php include(__DIR__ . '/include/player_table_link.php'); ?>
    </div>
</div>
<div class="row">
    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 table-responsive">
        <table class="table table-bordered table-hover">
            <tr>
                <th>Дата</th>
                <th>Матч</th>
                <th title="Счёт">Сч</th>
                <th>Тип матча</th>
                <th>Стадия</th>
                <th title="Позиция">Поз</th>
                <th title="Сила">С</th>
                <th title="Шайбы">Ш</th>
                <th title="Голевые передачи">П</th>
            </tr>
            <?php foreach ($game_array as $item) { ?>
                <tr>
                    <td class="text-right"><?= f_igosja_ufu_date($item['shedule_date']); ?></td>
                    <td class="text-center">
                        <a href="/team_view.php?num=<?= $item['home_team_id']; ?>">
                            <?= $item['home_team_name']; ?>
                        </a>
                        -
                        <a href="/team_view.php?num=<?= $item['guest_team_id']; ?>">
                            <?= $item['guest_team_name']; ?>
                        </a>
                    </td>
                    <td class="text-center">
                        <a href="/game_view.php?num=<?= $item['game_id']; ?>">
                            <?= $item['game_home_score']; ?>:<?= $item['game_guest_score']; ?>
                        </a>
                    </td>
                    <td class="text-center"><?= $item['tournamenttype_name']; ?></td>
                    <td class="text-center"><?= $item['stage_name']; ?></td>
                    <td class="text-center"><?= $item['position_name']; ?></td>
                    <td class="text-center"><?= $item['lineup_power_real']; ?></td>
                    <td class="text-center"><?= $item['lineup_score']; ?></td>
                    <td class="text-center"><?= $item['lineup_assist']; ?></td>
                </tr>
            <?php } ?>
            <tr>
                <th>Дата</th>
                <th>Матч</th>
                <th title="Счёт">Сч</th>
                <th>Тип матча</th>
                <th>Стадия</th>
                <th title="Позиция">Поз</th>
                <th title="Сила">С</th>
                <th title="Шайбы">Ш</th>
                <th title="Голевые передачи">П</th>
            </tr>
        </table>
    </div>
</div>
<div class="row">
    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
        <?php include(__DIR__ . '/include/player_table_link.php'); ?>
    </div>
</div>