<?php
/**
 * @var $game_array array
 * @var $num_get integer
 * @var $season_array array
 * @var $season_id integer
 */
?>
<div class="row margin-top">
    <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
        <?php include(__DIR__ . '/include/team_view_top_left.php'); ?>
    </div>
    <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12 text-right">
        <?php include(__DIR__ . '/include/team_view_top_right.php'); ?>
    </div>
</div>
<form method="GET">
    <input name="num" type="hidden" value="<?= $num_get; ?>">
    <div class="row margin-top">
        <div class="col-lg-10 col-md-10 col-sm-10 col-xs-10">
            <?php include(__DIR__ . '/include/team_table_link.php'); ?>
        </div>
        <div class="col-lg-2 col-md-2 col-sm-2 col-xs-2">
            <div class="row">
                <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12 text-right">
                    <label for="season_id">Сезон:</label>
                </div>
                <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
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
            </div>
        </div>
    </div>
</form>
<div class="row">
    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 table-responsive">
        <table class="table table-bordered table-hover">
            <tr>
                <th class="col-15">Дата</th>
                <th class="col-30 hidden-xs">Турнир</th>
                <th class="col-10 hidden-xs">Стадия</th>
                <th class="col-1 hidden-xs" title="Дома/В гостях"></th>
                <th class="col-5 hidden-xs" title="Соотношение сил (чем больше это число, тем сильнее соперник)">С/С</th>
                <th>Соперник</th>
                <th class="col-1 hidden-xs" title="Автосостав">А</th>
                <th class="col-5">Счёт</th>
                <th class="col-1 hidden-xs" title="Количество набранных/потерянных баллов"></th>
            </tr>
            <?php foreach ($game_array as $item) { ?>
                <tr>
                    <td class="text-center"><?= f_igosja_ufu_date($item['schedule_date']); ?></td>
                    <td class="hidden-xs text-center"><?= $item['tournamenttype_name']; ?></td>
                    <td class="hidden-xs text-center"><?= $item['stage_name']; ?></td>
                    <td class="hidden-xs text-center"><?= $item['game_home_team_id'] == $num_get ? 'Д' : 'Г'; ?></td>
                    <td class="hidden-xs text-center"><?= $item['power_percent'] ? $item['power_percent'] : 100; ?>%</td>
                    <td>
                        <a href="/team_view.php?num=<?= $item['team_id']; ?>">
                            <?= $item['team_name']; ?>
                            <span class="hidden-xs">
                                (<?= $item['city_name']; ?>, <?= $item['country_name']; ?>)
                            </span>
                        </a>
                    </td>
                    <td class="hidden-xs text-center"><?= f_igosja_game_auto($item['game_auto']); ?></td>
                    <td class="text-center">
                        <a class="<?php if ($item['game_home_score'] > $item['game_guest_score']) { ?>font-green<?php } elseif ($item['game_home_score'] < $item['game_guest_score']) { ?>font-red<?php } ?>" href="/game_view.php?num=<?= $item['game_id']; ?>">
                            <?= f_igosja_game_score($item['game_played'], $item['game_home_score'], $item['game_guest_score']); ?>
                        </a>
                    </td>
                    <td class="hidden-xs text-center"><?= f_igosja_plus_necessary($item['game_plus_minus']); ?></td>
                </tr>
            <?php } ?>
            <tr>
                <th>Дата</th>
                <th class="hidden-xs">Турнир</th>
                <th class="hidden-xs">Стадия</th>
                <th class="hidden-xs"></th>
                <th class="hidden-xs" title="Соотношение сил (чем больше это число, тем сильнее соперник)">C/C</th>
                <th>Соперник</th>
                <th class="hidden-xs" title="Автосостав">А</th>
                <th>Счёт</th>
                <th class="hidden-xs" title="Количество набранных/потерянных баллов"></th>
            </tr>
        </table>
    </div>
</div>
<div class="row">
    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
        <?php include(__DIR__ . '/include/team_table_link.php'); ?>
    </div>
</div>
<div class="row hidden-lg hidden-md hidden-sm">
    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
        <a class="btn show-full-table" href="javascript:">
            Показать полную таблицу
        </a>
    </div>
</div>