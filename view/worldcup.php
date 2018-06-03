<?php
/**
 * @var $auth_date_vip integer
 * @var $division_id integer
 * @var $national_array array
 * @var $season_array array
 * @var $season_id integer
 * @var $schedule_id integer
 * @var $stage_id integer
 * @var $stage_array array
 */
?>
<div class="row">
    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
        <h1>
            Чемпионат мира
        </h1>
    </div>
</div>
<div class="row">
    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 text-center">
        <?php include(__DIR__ . '/include/worldcup_table_link.php'); ?>
    </div>
</div>
<form method="GET">
    <input name="division_id" type="hidden" value="<?= $division_id; ?>">
    <div class="row">
        <div class="col-lg-3 col-md-3 col-sm-3 col-xs-3"></div>
        <div class="col-lg-3 col-md-3 col-sm-3 col-xs-3 text-right">
            <label for="season_id">Сезон:</label>
        </div>
        <div class="col-lg-1 col-md-1 col-sm-1 col-xs-2">
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
        <div class="col-lg-5 col-md-5 col-sm-5 col-xs-4"></div>
    </div>
</form>
<div class="row">
    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
        <p class="text-justify">
            Чемпионат мира - это главный турнир для сборных в Лиге.
            Чемпионат мира проводится один раз в сезон.
        </p>
        <p>
            В чемпионате мира может быть несколько дивизионов, в зависимости от числа стран в Лиге.
            Победители низших дивизионов получают право в следующем сезоне играть в более высоком дивизионе.
            Проигравшие вылетают в более низкий дивизион.
        </p>
    </div>
</div>
<form method="GET">
    <input name="division_id" type="hidden" value="<?= $division_id; ?>">
    <input name="season_id" type="hidden" value="<?= $season_id; ?>">
    <div class="row">
        <div class="col-lg-3 col-md-3 col-sm-3 col-xs-3"></div>
        <div class="col-lg-3 col-md-3 col-sm-3 col-xs-3 text-right">
            <label for="stage_id">Тур:</label>
        </div>
        <div class="col-lg-1 col-md-1 col-sm-1 col-xs-2">
            <select class="form-control submit-on-change" name="stage_id" id="stage_id">
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
                        <a href="/national_view.php?num=<?= $item['home_national_id']; ?>">
                            <?= $item['home_country_name']; ?>
                        </a>
                        <?= f_igosja_game_auto($item['game_home_auto']); ?>
                    </td>
                    <td class="text-center col-10">
                        <a href="/game_view.php?num=<?= $item['game_id']; ?>">
                            <?= f_igosja_game_score($item['game_played'], $item['game_home_score'], $item['game_guest_score']); ?>
                        </a>
                    </td>
                    <td>
                        <a href="/national_view.php?num=<?= $item['guest_national_id']; ?>">
                            <?= $item['guest_country_name']; ?>
                        </a>
                        <?= f_igosja_game_auto($item['game_guest_auto']); ?>
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
                <th class="col-5" title="Победы в овертайте">ВО</th>
                <th class="col-5" title="Победы по буллитам">ВБ</th>
                <th class="col-5" title="Поражения по буллитам">ПБ</th>
                <th class="col-5" title="Поражения в овертайте">ПО</th>
                <th class="col-5" title="Поражения">П</th>
                <th class="hidden-xs" colspan="2" title="Шайбы">Ш</th>
                <th class="col-5" title="Очки">О</th>
                <th class="col-5 <?php if ((!isset($auth_user_id) || $auth_date_vip < time())) { ?>hidden<?php } ?>" title="Рейтинг силы команды">Vs</th>
            </tr>
            <?php foreach ($national_array as $item) { ?>
                <tr>
                    <td class="text-center"><?= $item['worldcup_place']; ?></td>
                    <td>
                        <img src="/img/country/12/<?= $item['country_id']; ?>.png" title="<?= $item['country_name']; ?>"/>
                        <a href="/national_view.php?num=<?= $item['national_id']; ?>">
                            <?= $item['country_name']; ?>
                        </a>
                    </td>
                    <td class="text-center"><?= $item['worldcup_game']; ?></td>
                    <td class="text-center"><?= $item['worldcup_win']; ?></td>
                    <td class="text-center"><?= $item['worldcup_win_over']; ?></td>
                    <td class="text-center"><?= $item['worldcup_win_bullet']; ?></td>
                    <td class="text-center"><?= $item['worldcup_loose_bullet']; ?></td>
                    <td class="text-center"><?= $item['worldcup_loose_over']; ?></td>
                    <td class="text-center"><?= $item['worldcup_loose']; ?></td>
                    <td class="col-5 hidden-xs text-center"><?= $item['worldcup_score']; ?></td>
                    <td class="col-5 hidden-xs text-center"><?= $item['worldcup_pass']; ?></td>
                    <td class="text-center strong"><?= $item['worldcup_point']; ?></td>
                    <td class="text-center <?php if (!isset($auth_user_id) || $auth_date_vip < time()) { ?>hidden<?php } ?>"><?= $item['national_power_vs']; ?></td>
                </tr>
            <?php } ?>
            <tr>
                <th title="Место">М</th>
                <th>Команда</th>
                <th title="Игры">И</th>
                <th title="Победы">В</th>
                <th title="Победы в овертайте">ВО</th>
                <th title="Победы по буллитам">ВБ</th>
                <th title="Поражения по буллитам">ПБ</th>
                <th title="Поражения в овертайте">ПО</th>
                <th title="Поражения">П</th>
                <th class="hidden-xs" colspan="2" title="Шайбы">Ш</th>
                <th title="Очки">О</th>
                <th class="<?php if ((!isset($auth_user_id) || $auth_date_vip < time())) { ?>hidden<?php } ?>" title="Рейтинг силы команды">Vs</th>
            </tr>
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
<div class="row">
    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 text-center">
        <p>
            <a href="/worldcup_statistic.php?division_id=<?= $division_id; ?>&season_id=<?= $season_id; ?>" class="btn">
                Статистика
            </a>
        </p>
    </div>
</div>