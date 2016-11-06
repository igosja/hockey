<div class="row">
    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
        <h1><?= $shedule_array[0]['tournamenttype_name']; ?></h1>
    </div>
    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 text-center">
        <p>
            <?= f_igosja_ufu_date_time($shedule_array[0]['shedule_date']); ?>,
            <?= $shedule_array[0]['stage_name']; ?>,
            <?= $shedule_array[0]['shedule_season_id']; ?>-й сезон
        </p>
    </div>
</div>
<div class="row">
    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 table-responsive table-hover">
        <table class="table table-bordered">
            <?php foreach ($game_array as $item) { ?>
                <tr>
                    <td class="text-right">
                        <a href="/team_view.php?num=<?= $item['home_team_id']; ?>">
                            <?= $item['home_team_name']; ?>
                            (<?= $item['home_city_name']; ?>, <?= $item['home_country_name']; ?>)
                        </a>
                        <?= f_igosja_game_auto($item['game_home_auto']); ?>
                    </td>
                    <td class="text-center">
                        <a href="/game_view.php?num=<?= $item['game_id']; ?>">
                            <?= f_igosja_game_score($item['game_played'], $item['game_home_score'], $item['game_guest_score']); ?>
                        </a>
                    </td>
                    <td>
                        <a href="/team_view.php?num=<?= $item['home_team_id']; ?>">
                            <?= $item['guest_team_name']; ?>
                            (<?= $item['guest_city_name']; ?>, <?= $item['guest_country_name']; ?>)
                        </a>
                        <?= f_igosja_game_auto($item['game_guest_auto']); ?>
                    </td>
                </tr>
            <?php } ?>
        </table>
    </div>
</div>