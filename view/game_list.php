
<?php
/**
 * @var $auth_team_id integer
 * @var $count_page integer
 * @var $game_array array
 * @var $num_get integer
 * @var $schedule_array array
 * @var $total integer
 */
?>
<div class="row">
    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
        <h1><?= $schedule_array[0]['tournamenttype_name']; ?></h1>
    </div>
    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 text-center">
        <p>
            <?= f_igosja_ufu_date_time($schedule_array[0]['schedule_date']); ?>,
            <?= $schedule_array[0]['stage_name']; ?>,
            <?= $schedule_array[0]['schedule_season_id']; ?>-й сезон
        </p>
    </div>
</div>
<div class="row">
    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
        Всего матчей: <?= $total; ?>
    </div>
</div>
<div class="row">
    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 table-responsive table-hover">
        <table class="table table-bordered">
            <?php foreach ($game_array as $item) { ?>
                <tr<?php if (isset($auth_team_id) && in_array($auth_team_id, array($item['home_team_id'], $item['guest_team_id']))) { ?> class="info"<?php } ?>>
                    <td class="col-47 text-right">
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
                            )
                        ); ?>
                        <?= f_igosja_game_auto($item['game_home_auto']); ?>
                    </td>
                    <td class="col-6 text-center">
                        <a href="/game_view.php?num=<?= $item['game_id']; ?>">
                            <?= f_igosja_game_score($item['game_played'], $item['game_home_score'], $item['game_guest_score']); ?>
                        </a>
                    </td>
                    <td class="col-47">
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
                            )
                        ); ?>
                        <?= f_igosja_game_auto($item['game_guest_auto']); ?>
                    </td>
                </tr>
            <?php } ?>
        </table>
    </div>
</div>
<?php include(__DIR__ . '/include/pagination.php'); ?>