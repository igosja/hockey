<?php
/**
 * @var $country_array array
 * @var $country_id integer
 * @var $division_id integer
 * @var $review_array array
 * @var $review_create boolean
 * @var $season_array array
 * @var $season_id integer
 * @var $schedule_id integer
 * @var $stage_id integer
 */
?>
<div class="row">
    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
        <h1>
            <?= $country_array[0]['country_name']; ?>
        </h1>
    </div>
</div>
<div class="row">
    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 text-center">
        <?php include(__DIR__ . '/include/championship_table_link.php'); ?>
    </div>
</div>
<form method="GET">
    <input name="country_id" type="hidden" value="<?= $country_id; ?>">
    <input name="division_id" type="hidden" value="<?= $division_id; ?>">
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
<div class="row">
    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
        <p class="text-justify">
            Чемпионаты стран - это основные турниры в Лиге.
            В каждой из стран, где зарегистрированы 16 или более клубов, проводятся национальные чемпионаты.
            Все команды, которые были созданы на момент старта очередных чемпионатов, принимают в них участие.
            Национальные чемпионаты проводятся один раз в сезон.
        </p>
        <p>
            В одном национальном чемпионате может быть от двух до четырех дивизионов, в зависимости от числа команд в стране.
            Победители низших дивизионов получают право в следующем сезоне играть в более высоком дивизионе.
            Проигравшие вылетают в более низкий дивизион.
        </p>
    </div>
</div>
<form method="GET">
    <input name="country_id" type="hidden" value="<?= $country_id; ?>">
    <input name="division_id" type="hidden" value="<?= $division_id; ?>">
    <input name="season_id" type="hidden" value="<?= $season_id; ?>">
    <div class="row">
        <div class="col-lg-3 col-md-3 col-sm-3 col-xs-3"></div>
        <div class="col-lg-3 col-md-3 col-sm-3 col-xs-3 text-right">
            <label for="stage_id">Тур:</label>
        </div>
        <div class="col-lg-1 col-md-1 col-sm-1 col-xs-2">
            <select class="form-control" name="stage_id" id="stage_id">
                <?php foreach ($stage_array as $item) { ?>
                    <option
                        value="<?= $item['stage_id']; ?>"
                        <?php if ($stage_id == $item['stage_id']) { ?>
                            selected
                        <?php } ?>
                    >
                        <?= $item['stage_name']; ?>, <?= f_igosja_ufu_date($item['schedule_date']); ?>
                    </option>
                <?php } ?>
            </select>
        </div>
        <div class="col-lg-5 col-md-5 col-sm-5 col-xs-4"></div>
    </div>
</form>
<div class="row">
    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 table-responsive">
        <table class="table">
            <?php foreach ($game_array as $item) { ?>
                <tr>
                    <td class="text-right col-45">
                        <a href="/team_view.php?num=<?= $item['home_team_id']; ?>">
                            <?= $item['home_team_name']; ?>
                            (<?= $item['home_city_name']; ?>)
                        </a>
                    </td>
                    <td class="text-center col-10">
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
<?php if ($review_array) { ?>
    <div class="row">
        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 strong margin-top text-center">
            Обзоры:
        </div>
    </div>
    <?php foreach ($review_array as $item) { ?>
        <div class="row">
            <div class="col-lg-2 col-md-2 col-sm-1 hidden-xs"></div>
            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                <?= $item['stage_name']; ?> - <?= $item['review_title']; ?> - <?= $item['user_login']; ?>
            </div>
        </div>
    <?php } ?>
<?php } ?>
<div class="row">
    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 margin-top text-center">
        <a href="/championship_statistic.php?country_id=<?= $country_id; ?>&division_id=<?= $division_id; ?>&season_id=<?= $season_id; ?>" class="btn">
            Статистика
        </a>
        <?php if ($review_create) { ?>
            <a href="/review_create.php?country_id=<?= $country_id; ?>&division_id=<?= $division_id; ?>&season_id=<?= $season_id; ?>&stage_id=<?= $stage_id; ?>&schedule_id=<?= $schedule_id; ?>" class="btn">
                Написать обзор
            </a>
        <?php } ?>
    </div>
</div>