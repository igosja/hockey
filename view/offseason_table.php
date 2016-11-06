<div class="row">
    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
        <h1>
            Кубок межсезонья
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
                    <td class="text-center"><?= $item['offseason_place']; ?></td>
                    <td>
                        <img src="/img/country/12/<?= $item['country_id']; ?>.png"/>
                        <a href="/team_view.php?num=<?= $item['team_id']; ?>">
                            <?= $item['team_name']; ?>
                            (<?= $item['city_name']; ?>, <?= $item['country_name']; ?>)
                        </a>
                    </td>
                    <td class="text-center"><?= $item['offseason_game']; ?></td>
                    <td class="text-center"><?= $item['offseason_win']; ?></td>
                    <td class="text-center"><?= $item['offseason_win_over']; ?></td>
                    <td class="text-center"><?= $item['offseason_loose_over']; ?></td>
                    <td class="text-center"><?= $item['offseason_loose']; ?></td>
                    <td class="col-5 text-center"><?= $item['offseason_score']; ?></td>
                    <td class="col-5 text-center"><?= $item['offseason_pass']; ?></td>
                    <td class="text-center strong"><?= $item['offseason_point']; ?></td>
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