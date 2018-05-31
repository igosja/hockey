<?php
/**
 * @var $game_array array
 * @var $num_get integer
 * @var $previous_array array
 */
?>
<?php if ($game_array[0]['game_played']) { ?>
    <div class="row margin-top">
        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 text-right">
            <a href="/game_view.php?num=<?= $num_get; ?>">
                Результат
            </a>
            |
            <span class="strong">Перед матчем</span>
        </div>
    </div>
<?php } ?>
<div class="row <?php if (0 == $game_array[0]['game_played']) { ?>margin-top<?php } ?>">
    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 table-responsive">
        <table class="table table-bordered">
            <tr>
                <th>
                    <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12 text-center">
                        <?= f_igosja_team_or_national_link(
                            array(
                                'team_id'   => $game_array[0]['home_team_id'],
                                'team_name' => $game_array[0]['home_team_name'],
                            ),
                            array(
                                'country_name'  => $game_array[0]['home_national_name'],
                                'national_id'   => $game_array[0]['home_national_id'],
                            ),
                            false
                        ); ?>
                    </div>
                    <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12 text-center">
                        <?= f_igosja_team_or_national_link(
                            array(
                                'team_id'   => $game_array[0]['guest_team_id'],
                                'team_name' => $game_array[0]['guest_team_name'],
                            ),
                            array(
                                'country_name'  => $game_array[0]['guest_national_name'],
                                'national_id'   => $game_array[0]['guest_national_id'],
                            ),
                            false
                        ); ?>
                    </div>
                </th>
            </tr>
        </table>
    </div>
</div>
<div class="row">
    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 text-center">
        <?= f_igosja_ufu_date_time($game_array[0]['schedule_date']); ?>,
        <?= f_igosja_game_tournament_link($game_array); ?>
    </div>
</div>
<?php if (0 != $game_array[0]['stadium_team_id']) { ?>
    <div class="row">
        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 text-center">
            <a href="/team_view.php?num=<?= $game_array[0]['stadium_team_id']; ?>">
                <?= $game_array[0]['stadium_name']; ?>
            </a>
            (<?= $game_array[0]['stadium_capacity']; ?>)
        </div>
    </div>
<?php } ?>
<div class="row margin-top">
    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
        <div class="row">
            <div class="col-lg-4 col-md-4 col-sm-4 col-xs-12 text-center">
                Прогноз на матч
            </div>
            <div class="col-lg-8 col-md-8 col-sm-8 col-xs-12 table-responsive">
                <?php if (0 != $game_array[0]['home_team_id']) { ?>
                    <table class="table table-bordered">
                        <tr>
                            <td
                                class="text-center
                                <?php if ($game_array[0]['home_team_power_vs'] > $game_array[0]['guest_team_power_vs']) { ?>
                                    font-green
                                <?php } elseif ($game_array[0]['home_team_power_vs'] < $game_array[0]['guest_team_power_vs']) { ?>
                                    font-red
                                <?php } ?>"
                            >
                                <?= $game_array[0]['home_team_power_vs']; ?>
                            </td>
                            <td
                                class="text-center
                                <?php if ($game_array[0]['home_team_power_vs'] < $game_array[0]['guest_team_power_vs']) { ?>
                                    font-green
                                <?php } elseif ($game_array[0]['home_team_power_vs'] > $game_array[0]['guest_team_power_vs']) { ?>
                                    font-red
                                <?php } ?>"
                            >
                                <?= $game_array[0]['guest_team_power_vs']; ?>
                            </td>
                        </tr>
                    </table>
                <?php } else { ?>
                    <table class="table table-bordered">
                        <tr>
                            <td
                                class="text-center
                                <?php if ($game_array[0]['home_national_power_vs'] > $game_array[0]['guest_national_power_vs']) { ?>
                                    font-green
                                <?php } elseif ($game_array[0]['home_national_power_vs'] < $game_array[0]['guest_national_power_vs']) { ?>
                                    font-red
                                <?php } ?>"
                            >
                                <?= $game_array[0]['home_national_power_vs']; ?>
                            </td>
                            <td
                                class="text-center
                                <?php if ($game_array[0]['home_national_power_vs'] < $game_array[0]['guest_national_power_vs']) { ?>
                                    font-green
                                <?php } elseif ($game_array[0]['home_national_power_vs'] > $game_array[0]['guest_national_power_vs']) { ?>
                                    font-red
                                <?php } ?>"
                            >
                                <?= $game_array[0]['guest_national_power_vs']; ?>
                            </td>
                        </tr>
                    </table>
                <?php } ?>
            </div>
        </div>
    </div>
</div>
<div class="row margin-top">
    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 table-responsive">
        <table class="table table-bordered">
            <tr>
                <th class="col-15">Дата</th>
                <th class="hidden-xs">Турнир</th>
                <th class="col-15 hidden-xs">Стадия</th>
                <th>Игра</th>
                <th class="col-10">Результат</th>
            </tr>
            <?php foreach ($previous_array as $item) { ?>
                <tr>
                    <td class="text-center"><?= f_igosja_ufu_date($item['schedule_date']); ?></td>
                    <td class="hidden-xs text-center"><?= $item['tournamenttype_name']; ?></td>
                    <td class="hidden-xs text-center"><?= $item['stage_name']; ?></td>
                    <td>
                        <?= f_igosja_team_or_national_link(
                            array(
                                'team_id'   => $item['home_team_id'],
                                'team_name' => $item['home_team_name'],
                            ),
                            array(
                                'country_name'  => $item['home_national_name'],
                                'national_id'   => $item['home_national_id'],
                            ),
                            false
                        ); ?>
                        -
                        <?= f_igosja_team_or_national_link(
                            array(
                                'team_id'   => $item['guest_team_id'],
                                'team_name' => $item['guest_team_name'],
                            ),
                            array(
                                'country_name'  => $item['guest_national_name'],
                                'national_id'   => $item['guest_national_id'],
                            ),
                            false
                        ); ?>
                    </td>
                    <td class="text-center">
                        <a href="game_view.php?num=<?= $item['game_id']; ?>">
                            <?= f_igosja_game_score($item['game_played'], $item['game_home_score'], $item['game_guest_score']); ?>
                        </a>
                    </td>
                </tr>
            <?php } ?>
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