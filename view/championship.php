<div class="row">
    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
        <h1>
            <?= $country_array[0]['country_name']; ?>,
            <?= $country_array[0]['division_name']; ?>
        </h1>
    </div>
</div>
<div class="row">
    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 table-responsive">
        <table class="table">
            <?php foreach ($game_array as $item) { ?>
                <tr>
                    <td class="text-right">
                        <a href="/team_view.php?num=<?= $item['home_team_id']; ?>">
                            <?= $item['home_team_name']; ?>
                            (<?= $item['home_city_name']; ?>)
                        </a>
                    </td>
                    <td class="text-center">
                        <?= f_igosja_game_score($item['game_home_score'], $item['game_guest_score'], $item['game_played']); ?>
                    </td>
                    <td>
                        <a href="/team_view.php?num=<?= $item['guest_team_id']; ?>">
                            <?= $item['guest_team_name']; ?>
                            (<?= $item['guest_city_name']; ?>)
                        </a>
                    </td>
                </tr>
            <?php } ?>
        </table>
    </div>
</div>
<div class="row margin-top">
    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 table-responsive">
        <table class="table table-bordered table-hover">
            <tr>
                <th class="col-5" title="Место">М</th>
                <th>Команда</th>
                <th class="col-5" title="Игры">И</th>
                <th class="col-5" title="Победы">В</th>
                <th class="col-5" title="Победы в овертайте/по буллитам">ВО</th>
                <th class="col-5" title="Поражения в овертайте/по буллитам">ПО</th>
                <th class="col-5" title="Поражения">П</th>
                <th colspan="2" title="Шайбы">Ш</th>
                <th class="col-5" title="Очки">О</th>
            </tr>
            <?php foreach ($team_array as $item) { ?>
                <tr>
                    <td class="text-center"><?= $item['championship_place']; ?></td>
                    <td>
                        <a href="/team_view.php?num=<?= $item['team_id']; ?>">
                            <?= $item['team_name']; ?>
                            (<?= $item['city_name']; ?>)
                        </a>
                    </td>
                    <td class="text-center"><?= $item['championship_game']; ?></td>
                    <td class="text-center"><?= $item['championship_win']; ?></td>
                    <td class="text-center"><?= $item['championship_win_over']; ?></td>
                    <td class="text-center"><?= $item['championship_loose_over']; ?></td>
                    <td class="text-center"><?= $item['championship_loose']; ?></td>
                    <td class="col-5 text-center"><?= $item['championship_score']; ?></td>
                    <td class="col-5 text-center"><?= $item['championship_pass']; ?></td>
                    <td class="text-center strong"><?= $item['championship_point']; ?></td>
                </tr>
            <?php } ?>
            <tr>
                <th title="Место">М</th>
                <th>Команда</th>
                <th title="Игры">И</th>
                <th title="Победы">В</th>
                <th title="Победы в овертайте/по буллитам">ВО</th>
                <th title="Поражения в овертайте/по буллитам">ПО</th>
                <th title="Поражения">П</th>
                <th colspan="2" title="Шайбы">Ш</th>
                <th title="Очки">О</th>
            </tr>
        </table>
    </div>
</div>