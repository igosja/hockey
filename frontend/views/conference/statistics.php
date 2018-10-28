<?php

use yii\helpers\Html;

/**
 * @var int $count
 * @var array $seasonArray
 * @var int $seasonId
 */

?>
<div class="row">
    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
        <h1>
            Конференция любительских клубов
        </h1>
    </div>
</div>
<?= Html::beginForm('', 'get'); ?>
<?= Html::hiddenInput('seasonId', $seasonId); ?>
<div class="row">
    <div class="col-lg-4 col-md-4 col-sm-4 col-xs-4 text-right">
        <?= Html::label('Статистика', 'statisticType'); ?>
    </div>
    <div class="col-lg-5 col-md-5 col-sm-6 col-xs-8">
        <?= Html::dropDownList(
            'id',
            Yii::$app->request->get('id'),
            $seasonArray,
            ['class' => 'form-control submit-on-change', 'id' => 'statisticType']
        ); ?>
    </div>
    <div class="col-lg-5 col-md-5 col-sm-5 col-xs-4"></div>
</div>
<form method="GET">
    <input type="hidden" name="season_id" value="<?= $season_id; ?>" />
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
                            <a href="/team_view.php?num=<?= $statistic_array[$i]['team_id']; ?>">
                                <?= $statistic_array[$i]['team_name']; ?>
                                <span class="hidden-xs">(<?= $statistic_array[$i]['city_name']; ?>)</span>
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
                    <th class="col-10">№</th>
                    <th>Игрок</th>
                    <th class="hidden-xs">Команда</th>
                    <th class="col-10"></th>
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
                            <a href="/team_view.php?num=<?= $statistic_array[$i]['team_id']; ?>">
                                <?= $statistic_array[$i]['team_name']; ?>
                                (<?= $statistic_array[$i]['city_name']; ?>)
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
<?= $this->render('/site/_show-full-table'); ?>
<?= Html::beginForm('', 'get'); ?>
<div class="row">
    <div class="col-lg-3 col-md-3 col-sm-3 col-xs-3"></div>
    <div class="col-lg-3 col-md-3 col-sm-3 col-xs-3 text-right">
        <?= Html::label('Сезон', 'seasonId'); ?>
    </div>
    <div class="col-lg-1 col-md-1 col-sm-1 col-xs-2">
        <?= Html::dropDownList(
            'seasonId',
            $seasonId,
            $seasonArray,
            ['class' => 'form-control submit-on-change', 'id' => 'seasonId']
        ); ?>
    </div>
    <div class="col-lg-5 col-md-5 col-sm-5 col-xs-4"></div>
</div>
<?= Html::endForm(); ?>
<div class="row">
    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 text-center">
        <p class="text-justify">
            Турнир проводится среди новых команд и команд, не попавших в чемпионаты своих стран.
            <br/>
            Новые и вылетевшие в конференцию команды автоматически становятся участниками турнира,
            выйти из числа участников невозможно, в случае неотправки составов заявленная команда играет на
            автосоставах,
            определяемых компьютером.
            Всего команд в Конференции в этом сезоне - <span class="strong"><?= $count; ?></span>.
        </p>
        <p class="text-center">
            <?= Html::a('Турнирная таблица', ['conference/table', 'seasonId' => $seasonId]); ?>
            |
            <?= Html::a('Статистика', ['conference/statistics', 'seasonId' => $seasonId]); ?>
        </p>
        <p class="text-justify">
            Турнир играется по швейцарской системе, когда для каждого тура сводятся в пары команды одного ранга
            (расположенные достаточно близко друг от друга в турнирной таблице, но так, чтобы не нарушались принципы
            турнира).
        </p>
        <p class="text-justify">
            В матчах турнира есть домашний бонус - в родных стенах команды играют сильнее.
        </p>
        <p class="text-justify">
            Каждая команда имеет право сыграть 3 матча на супере и 3 матча на отдыхе во время розыгрыша кубка
            межсезонья.
        </p>
        <p class="text-justify">
            В кубке межсезонья участники не могут встречаться между собой более двух раз и сводятся в пары,
            имеющие ближайшие места в турнирной таблице, но такие,
            которые могут играть между собой в соответствии с принципами жеребьёвки:
        </p>
        <ul class="text-left">
            <li>две команды не могут играть между собой более двух матчей;</li>
            <li>ни одна из команд не может сыграть более половины матчей турнира дома или в гостях.</li>
        </ul>
    </div>
</div>