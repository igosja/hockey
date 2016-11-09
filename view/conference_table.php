<div class="row">
    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
        <h1>
            Конференция любительских клубов
        </h1>
    </div>
</div>
<div class="row">
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
                    <td class="text-center"><?= $item['conference_place']; ?></td>
                    <td>
                        <img src="/img/country/12/<?= $item['country_id']; ?>.png"/>
                        <a href="/team_view.php?num=<?= $item['team_id']; ?>">
                            <?= $item['team_name']; ?>
                            (<?= $item['city_name']; ?>, <?= $item['country_name']; ?>)
                        </a>
                    </td>
                    <td class="text-center"><?= $item['conference_game']; ?></td>
                    <td class="text-center"><?= $item['conference_win']; ?></td>
                    <td class="text-center"><?= $item['conference_win_over']; ?></td>
                    <td class="text-center"><?= $item['conference_loose_over']; ?></td>
                    <td class="text-center"><?= $item['conference_loose']; ?></td>
                    <td class="col-5 text-center"><?= $item['conference_score']; ?></td>
                    <td class="col-5 text-center"><?= $item['conference_pass']; ?></td>
                    <td class="text-center strong"><?= $item['conference_point']; ?></td>
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