<?php
/**
 * @var $country_array array
 * @var $country_id integer
 * @var $season_id integer
 */
?>
<div class="row">
    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
        <h1>
            Конференция любительских клубов
        </h1>
    </div>
</div>
<form method="GET">
    <input name="country_id" type="hidden" value="<?= $country_id; ?>" />
    <div class="row">
        <div class="col-lg-3 col-md-3 col-sm-3 col-xs-3"></div>
        <div class="col-lg-3 col-md-3 col-sm-3 col-xs-3 text-right">
            <label for="season_id">Сезон:</label>
        </div>
        <div class="col-lg-1 col-md-1 col-sm-1 col-xs-2">
            <select class="form-control" name="season_id" id="season_id">
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
        <div class="col-lg-5 col-md-5 col-sm-5 col-xs-4"></div>
    </div>
</form>
<form method="GET">
    <input name="season_id" type="hidden" value="<?= $season_id; ?>" />
    <div class="row">
        <div class="col-lg-3 col-md-3 col-sm-3 col-xs-3"></div>
        <div class="col-lg-3 col-md-3 col-sm-3 col-xs-3 text-right">
            <label for="country_id">Страна:</label>
        </div>
        <div class="col-lg-1 col-md-1 col-sm-1 col-xs-2">
            <select class="form-control" name="country_id" id="country_id">
                <option value="0">Все</option>
                <?php foreach ($country_array as $item) { ?>
                    <option
                        value="<?= $item['country_id']; ?>"
                        <?php if ($country_id == $item['country_id']) { ?>
                            selected
                        <?php } ?>
                    >
                        <?= $item['country_name']; ?>
                    </option>
                <?php } ?>
            </select>
        </div>
        <div class="col-lg-5 col-md-5 col-sm-5 col-xs-4"></div>
    </div>
</form>
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
                        <img
                            alt="<?= $item['country_name']; ?>"
                            src="/img/country/12/<?= $item['country_id']; ?>.png"
                            title="<?= $item['country_name']; ?>"
                        />
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