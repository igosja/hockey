<?php
/**
 * @var $num_get integer
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
                        <a href="/team_view.php?num=<?= $game_array[0]['home_team_id']; ?>">
                            <?= $game_array[0]['home_team_name']; ?>
                        </a>
                    </div>
                    <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12 text-center">
                        <a href="/team_view.php?num=<?= $game_array[0]['guest_team_id']; ?>">
                            <?= $game_array[0]['guest_team_name']; ?>
                        </a>
                    </div>
                </th>
            </tr>
        </table>
    </div>
</div>
<div class="row">
    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 text-center">
        <?= f_igosja_ufu_date_time($game_array[0]['shedule_date']); ?>,
        <?= $game_array[0]['tournamenttype_name']; ?>,
        <?= $game_array[0]['stage_name']; ?>
    </div>
</div>
<div class="row">
    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 text-center">
        <a href="/team_view.php?num=<?= $game_array[0]['stadium_team_id']; ?>">
            <?= $game_array[0]['stadium_name']; ?>
        </a>
        (<?= $game_array[0]['stadium_capacity']; ?>)
    </div>
</div>
<div class="row margin-top">
    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
        <div class="row">
            <div class="col-lg-4 col-md-4 col-sm-4 col-xs-12 text-center">
                Прогноз на матч
            </div>
            <div class="col-lg-8 col-md-8 col-sm-8 col-xs-12 table-responsive">
                <table class="table table-bordered">
                    <tr>
                        <td class="text-center"><?= $game_array[0]['home_team_power_vs']; ?></td>
                        <td class="text-center"><?= $game_array[0]['guest_team_power_vs']; ?></td>
                    </tr>
                </table>
            </div>
        </div>
    </div>
</div>
<div class="row margin-top">
    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 table-responsive">
        <table class="table table-bordered">
            <tr>
                <th class="col-15">Дата</th>
                <th>Турнир</th>
                <th class="col-15">Стадия</th>
                <th>Игра</th>
                <th class="col-10">Результат</th>
            </tr>
            <?php foreach ($previous_array as $item) { ?>
                <tr>
                    <td class="text-center"><?= f_igosja_ufu_date_time($item['shedule_date']); ?></td>
                    <td class="text-center"><?= $item['tournamenttype_name']; ?></td>
                    <td class="text-center"><?= $item['stage_name']; ?></td>
                    <td>
                        <a href="/team_view.php?num=<?= $item['home_team_id']; ?>">
                            <?= $item['home_team_name']; ?>
                        </a>
                        -
                        <a href="/team_view.php?num=<?= $item['guest_team_id']; ?>">
                            <?= $item['guest_team_name']; ?>
                        </a>
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