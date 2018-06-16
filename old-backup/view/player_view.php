<?php
/**
 * @var $game_array array
 * @var $num_get integer
 * @var $season_array array
 * @var $season_id integer
 */
?>
<?php include(__DIR__ . '/include/player_view.php'); ?>
<form method="GET">
    <input name="num" type="hidden" value="<?= $num_get; ?>">
    <div class="row margin-top">
        <div class="col-lg-10 col-md-10 col-sm-10 col-xs-10">
            <?php include(__DIR__ . '/include/player_table_link.php'); ?>
        </div>
        <div class="col-lg-2 col-md-2 col-sm-2 col-xs-2">
            <div class="row">
                <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12 text-right">
                    <label for="season_id">Сезон:</label>
                </div>
                <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
                    <select class="form-control submit-on-change" name="season_id" id="season_id">
                        <?php foreach ($season_array as $item) { ?>
                            <option
                                value="<?= $item['season_id']; ?>"
                                <?php if ($season_id == $item['season_id']) { ?>
                                    selected
                                <?php } ?>
                            >
                                <?= $item['season_id']; ?>
                            </option>
                        <?php } ?>
                    </select>
                </div>
            </div>
        </div>
    </div>
</form>
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
                <th title="Плюс/минус">+/-</th>
                <th title="Изменение силы"></th>
            </tr>
            <?php foreach ($game_array as $item) { ?>
                <tr>
                    <td class="text-center"><?= f_igosja_ufu_date($item['schedule_date']); ?></td>
                    <td class="text-center">
                        <?= f_igosja_team_or_national_link(
                            array(
                                'city_name'     => $item['home_city_name'],
                                'country_name'  => $item['home_country_name'],
                                'team_id'       => $item['home_team_id'],
                                'team_name'     => $item['home_team_name'],
                            ),
                            array(
                                'country_name'      => $item['home_national_name'],
                                'national_id'       => $item['home_national_id'],
                                'nationaltype_name' => $item['home_nationaltype_name'],
                            ),
                            false
                        ); ?>
                        -
                        <?= f_igosja_team_or_national_link(
                            array(
                                'city_name'     => $item['guest_city_name'],
                                'country_name'  => $item['guest_country_name'],
                                'team_id'       => $item['guest_team_id'],
                                'team_name'     => $item['guest_team_name'],
                            ),
                            array(
                                'country_name'      => $item['guest_national_name'],
                                'national_id'       => $item['guest_national_id'],
                                'nationaltype_name' => $item['guest_nationaltype_name'],
                            ),
                            false
                        ); ?>
                    </td>
                    <td class="text-center">
                        <a href="/game_view.php?num=<?= $item['game_id']; ?>">
                            <?= $item['game_home_score']; ?>:<?= $item['game_guest_score']; ?>
                        </a>
                    </td>
                    <td class="text-center"><?= $item['tournamenttype_name']; ?></td>
                    <td class="text-center"><?= $item['stage_name']; ?></td>
                    <td class="text-center"><?= $item['position_short']; ?></td>
                    <td class="text-center"><?= $item['lineup_power_real']; ?></td>
                    <td class="text-center"><?= $item['lineup_score']; ?></td>
                    <td class="text-center"><?= $item['lineup_assist']; ?></td>
                    <td class="text-center"><?= $item['lineup_plus_minus']; ?></td>
                    <td class="text-center">
                        <?= f_igosja_player_power_change($item['lineup_power_change']); ?>
                    </td>
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
                <th title="Плюс/минус">+/-</th>
                <th title="Изменение силы"></th>
            </tr>
        </table>
    </div>
</div>
<div class="row">
    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
        <?php include(__DIR__ . '/include/player_table_link.php'); ?>
    </div>
</div>