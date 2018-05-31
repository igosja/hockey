<?php
/**
 * @var $count_statistictype integer
 * @var $division_id integer
 * @var $num_get integer
 * @var $season_id integer
 * @var $select string
 * @var $statistic_array array
 * @var $statistictype_array array
 */
?>
<div class="row">
    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
        <h1>
            Чемпионат мира, сезон <?= $season_id; ?>
        </h1>
    </div>
</div>
<div class="row">
    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 text-center">
        <a href="/worldcup.php?season_id=<?= $season_id; ?>&division_id=<?= $division_id; ?>">
            Турнирная таблица
        </a>
    </div>
</div>
<form method="GET">
    <input name="country_id" type="hidden" value="<?= $country_id; ?>" />
    <input name="season_id" type="hidden" value="<?= $season_id; ?>" />
    <input name="division_id" type="hidden" value="<?= $division_id; ?>" />
    <div class="row">
        <div class="col-lg-4 col-md-4 col-sm-4 col-xs-4 text-right">
            <label for="statistictype">Статистика:</label>
        </div>
        <div class="col-lg-5 col-md-5 col-sm-6 col-xs-8">
            <select class="form-control submit-on-change" id="statistictype" name="num">
                <?php for ($i=0; $i<$count_statistictype; $i++) { ?>
                    <?php if (0 == $i || $statistictype_array[$i]['statisticchapter_name'] != $statistictype_array[$i-1]['statisticchapter_name']) { ?>
                        <optgroup label="<?= $statistictype_array[$i]['statisticchapter_name']; ?>">
                    <?php } ?>
                        <option
                            value="<?= $statistictype_array[$i]['statistictype_id']; ?>"
                            <?php if ($num_get == $statistictype_array[$i]['statistictype_id']) { ?>
                                selected
                            <?php } ?>
                        >
                            <?= $statistictype_array[$i]['statistictype_name']; ?>
                        </option>
                    <?php if ($count_statistictype == $i+1 || $statistictype_array[$i]['statisticchapter_name'] != $statistictype_array[$i+1]['statisticchapter_name']) { ?>
                        </optgroup>
                    <?php } ?>
                <?php } ?>
            </select>
        </div>
    </div>
</form>
<div class="row">
    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
        <?php if (in_array($num_get, array(
            STATISTIC_TEAM_NO_PASS,
            STATISTIC_TEAM_NO_SCORE,
            STATISTIC_TEAM_LOOSE,
            STATISTIC_TEAM_LOOSE_BULLET,
            STATISTIC_TEAM_LOOSE_OVER,
            STATISTIC_TEAM_PASS,
            STATISTIC_TEAM_SCORE,
            STATISTIC_TEAM_PENALTY,
            STATISTIC_TEAM_PENALTY_OPPONENT,
            STATISTIC_TEAM_WIN,
            STATISTIC_TEAM_WIN_BULLET,
            STATISTIC_TEAM_WIN_OVER,
            STATISTIC_TEAM_WIN_PERCENT,
        ))) { ?>
            <table class="table table-bordered table-hover">
                <tr>
                    <th>№</th>
                    <th>Команда</th>
                    <th></th>
                </tr>
                <?php for ($i=0; $i<$count_statistic; $i++) { ?>
                    <tr>
                        <td class="text-center"><?= $i + 1; ?></td>
                        <td>
                            <img src="/img/country/12/<?= $statistic_array[$i]['country_id']; ?>.png" title="<?= $statistic_array[$i]['country_name']; ?>"/>
                            <a href="/national_view.php?num=<?= $statistic_array[$i]['country_id']; ?>">
                                <?= $statistic_array[$i]['national_name']; ?>
                            </a>
                        </td>
                        <td class="text-center"><?= $statistic_array[$i][$select]; ?></td>
                    </tr>
                <?php } ?>
                <tr>
                    <th>№</th>
                    <th>Команда</th>
                    <th></th>
                </tr>
            </table>
        <?php } elseif (in_array($num_get, array(
            STATISTIC_PLAYER_ASSIST,
            STATISTIC_PLAYER_ASSIST_POWER,
            STATISTIC_PLAYER_ASSIST_SHORT,
            STATISTIC_PLAYER_BULLET_WIN,
            STATISTIC_PLAYER_FACE_OFF,
            STATISTIC_PLAYER_FACE_OFF_PERCENT,
            STATISTIC_PLAYER_FACE_OFF_WIN,
            STATISTIC_PLAYER_GAME,
            STATISTIC_PLAYER_LOOSE,
            STATISTIC_PLAYER_PASS,
            STATISTIC_PLAYER_PASS_PER_GAME,
            STATISTIC_PLAYER_PENALTY,
            STATISTIC_PLAYER_PLUS_MINUS,
            STATISTIC_PLAYER_POINT,
            STATISTIC_PLAYER_SAVE,
            STATISTIC_PLAYER_SAVE_PERCENT,
            STATISTIC_PLAYER_SCORE,
            STATISTIC_PLAYER_SCORE_DRAW,
            STATISTIC_PLAYER_SCORE_POWER,
            STATISTIC_PLAYER_SCORE_SHORT,
            STATISTIC_PLAYER_SCORE_SHOT_PERCENT,
            STATISTIC_PLAYER_SCORE_WIN,
            STATISTIC_PLAYER_SHOT,
            STATISTIC_PLAYER_SHOT_GK,
            STATISTIC_PLAYER_SHOT_PER_GAME,
            STATISTIC_PLAYER_SHUTOUT,
            STATISTIC_PLAYER_WIN,
        ))) { ?>
            <table class="table table-bordered table-hover">
                <tr>
                    <th>№</th>
                    <th>Игрок</th>
                    <th class="hidden-xs">Команда</th>
                    <th></th>
                </tr>
                <?php for ($i=0; $i<$count_statistic; $i++) { ?>
                    <tr>
                        <td class="text-center"><?= $i + 1; ?></td>
                        <td>
                            <a href="/player_view.php?num=<?= $statistic_array[$i]['player_id']; ?>">
                                <?= $statistic_array[$i]['name_name']; ?>
                                <?= $statistic_array[$i]['surname_name']; ?>
                            </a>
                        </td>
                        <td class="hidden-xs">
                            <img src="/img/country/12/<?= $statistic_array[$i]['country_id']; ?>.png" title="<?= $statistic_array[$i]['country_name']; ?>"/>
                            <a href="/national_view.php?num=<?= $statistic_array[$i]['country_id']; ?>">
                                <?= $statistic_array[$i]['national_name']; ?>
                            </a>
                        </td>
                        <td class="text-center"><?= $statistic_array[$i][$select]; ?></td>
                    </tr>
                <?php } ?>
                <tr>
                    <th>№</th>
                    <th>Игрок</th>
                    <th class="hidden-xs">Команда</th>
                    <th></th>
                </tr>
            </table>
        <?php } ?>
    </div>
</div>
<div class="row hidden-lg hidden-md hidden-sm">
    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
        <a class="btn show-full-table" href="javascript:">
            Показать полную таблицу
        </a>
    </div>
</div>