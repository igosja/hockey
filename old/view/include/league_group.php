<?php
/**
 * @var $auth_date_vip integer
 * @var $group_array array
 * @var $round_id integer
 * @var $season_id integer
 * @var $stage_array array
 * @var $stage_id integer
 */
?>
<form method="GET">
    <input name="season_id" type="hidden" value="<?= $season_id; ?>" />
    <input name="round_id" type="hidden" value="<?= $round_id; ?>" />
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
<?php foreach ($group_array as $group) { ?>
    <div class="row margin-top">
        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 text-center">
            Группа <span class="strong"><?= $group['name']; ?></span>
        </div>
    </div>
    <div class="row margin-top">
        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 table-responsive">
            <table class="table">
                <?php foreach ($group['game'] as $item) { ?>
                    <tr>
                        <td class="text-right col-45">
                            <a href="/team_view.php?num=<?= $item['home_team_id']; ?>">
                                <?= $item['home_team_name']; ?>
                                <span class="hidden-xs">(<?= $item['home_city_name']; ?>, <?= $item['home_country_name']; ?>)</span>
                            </a>
                            <?= f_igosja_game_auto($item['game_home_auto']); ?>
                        </td>
                        <td class="text-center col-10">
                            <a href="/game_view.php?num=<?= $item['game_id']; ?>">
                                <?= f_igosja_game_score($item['game_played'], $item['game_home_score'], $item['game_guest_score']); ?>
                            </a>
                        </td>
                        <td>
                            <a href="/team_view.php?num=<?= $item['guest_team_id']; ?>">
                                <?= $item['guest_team_name']; ?>
                                <span class="hidden-xs">(<?= $item['guest_city_name']; ?>, <?= $item['guest_country_name']; ?>)</span>
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
                <?php foreach ($group['team'] as $item) { ?>
                    <tr
                        <?php if ($item['league_place'] <= 2) { ?>class="tournament-table-up" title="Выход из группы"<?php } ?>
                    >
                        <td class="text-center"><?= $item['league_place']; ?></td>
                        <td>
                            <img
                                alt="<?= $item['team_name']; ?>"
                                src="/img/country/12/<?= $item['country_id']; ?>.png"
                                title="<?= $item['team_name']; ?>"
                            />
                            <a href="/team_view.php?num=<?= $item['team_id']; ?>">
                                <?= $item['team_name']; ?>
                                <span class="hidden-xs">(<?= $item['city_name']; ?>)</span>
                            </a>
                        </td>
                        <td class="text-center"><?= $item['league_game']; ?></td>
                        <td class="text-center"><?= $item['league_win']; ?></td>
                        <td class="text-center"><?= $item['league_win_over']; ?></td>
                        <td class="text-center"><?= $item['league_win_bullet']; ?></td>
                        <td class="text-center"><?= $item['league_loose_bullet']; ?></td>
                        <td class="text-center"><?= $item['league_loose_over']; ?></td>
                        <td class="text-center"><?= $item['league_loose']; ?></td>
                        <td class="col-5 hidden-xs text-center"><?= $item['league_score']; ?></td>
                        <td class="col-5 hidden-xs text-center"><?= $item['league_pass']; ?></td>
                        <td class="text-center strong"><?= $item['league_point']; ?></td>
                        <td class="text-center <?php if (!isset($auth_user_id) || $auth_date_vip < time()) { ?>hidden<?php } ?>"><?= $item['team_power_vs']; ?></td>
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
<?php } ?>