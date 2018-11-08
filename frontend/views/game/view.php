<?php

use common\components\ErrorHelper;
use common\components\HockeyHelper;
use common\models\Position;
use yii\helpers\Html;

/**
 * @var \common\models\Game $game
 */

?>
<div class="row margin-top">
    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 text-right">
        <span class="strong">Результат</span>
        |
        <?= Html::a(
            'Перед матчем',
            ['game/preview', 'id' => Yii::$app->request->get('id')]
        ); ?>
    </div>
</div>
<div class="row">
    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 table-responsive">
        <table class="table table-bordered">
            <tr>
                <th>
                    <div class="col-lg-4 col-md-4 col-sm-4 col-xs-12 text-center">
                        <?= HockeyHelper::teamOrNationalLink($game->teamHome, $game->nationalHome, false); ?>
                        <?= HockeyHelper::formatAuto($game->game_home_auto); ?>
                    </div>
                    <div class="col-lg-4 col-md-4 col-sm-4 col-xs-12 text-center">
                        <?= $game->game_home_score; ?>:<?= $game->game_guest_score; ?>
                        (<?= $game->game_home_score_1; ?>:<?= $game->game_guest_score_1; ?>
                        |
                        <?= $game->game_home_score_2; ?>:<?= $game->game_guest_score_2; ?>
                        |
                        <?= $game->game_home_score_3; ?>:<?= $game->game_guest_score_3; ?><?php
                        if ($game->game_home_score_overtime || $game->game_guest_score_overtime) {
                            print ' | ' . $game->game_home_score_overtime . ':' . $game->game_guest_score_overtime . ' ОТ';
                        }
                        ?><?php
                        if ($game->game_home_score_shootout || $game->game_guest_score_shootout) {
                            print ' | ' . $game->game_home_score_shootout . ':' . $game->game_guest_score_shootout . ' Б';
                        }
                        ?>)
                    </div>
                    <div class="col-lg-4 col-md-4 col-sm-4 col-xs-12 text-center">
                        <?= HockeyHelper::teamOrNationalLink($game->teamGuest, $game->nationalGuest, false); ?>
                        <?= HockeyHelper::formatAuto($game->game_guest_auto); ?>
                    </div>
                </th>
            </tr>
        </table>
    </div>
</div>
<div class="row">
    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 text-center">
            <?php

            try {
                print Yii::$app->formatter->asDatetime($game->schedule->schedule_date, 'short');
            } catch (Exception $e) {
                ErrorHelper::log($e);
            }

            ?>,
            <?= $game->tournamentLink(); ?>
    </div>
</div>
<div class="row">
    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 text-center">
        <?= Html::a($game->stadium->stadium_name, ['team/view', $game->stadium->team->team_id]); ?>
        (<?= $game->stadium->stadium_capacity; ?>),
        Зрителей: <?= $game->game_visitor; ?>.
        Билет: <?php

        try {
            print Yii::$app->formatter->asCurrency($game->game_ticket, 'USD');
        } catch (Exception $e) {
            ErrorHelper::log($e);
        }

        ?>
    </div>
</div>
<div class="row">
    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 table-responsive">
        <table class="table table-bordered">
            <tr>
                <td class="col-35 text-center">
                    <span title="Первое звено"><?= $game->game_home_tactic_id_1; ?></span>
                    |
                    <span title="Второе звено"><?= $game->game_home_tactic_id_2; ?></span>
                    |
                    <span title="Третье звено"><?= $game->game_home_tactic_id_3; ?></span>
                    |
                    <span title="Четвёртое звено"><?= $game->game_home_tactic_id_4; ?></span>
                </td>
                <td class="text-center">Тактика</td>
                <td class="col-35 text-center">
                    <span title="Первое звено"><?= $game->game_guest_tactic_id_1; ?></span>
                    |
                    <span title="Второе звено"><?= $game->game_guest_tactic_id_2; ?></span>
                    |
                    <span title="Третье звено"><?= $game->game_guest_tactic_id_3; ?></span>
                    |
                    <span title="Четвёртое звено"><?= $game->game_guest_tactic_id_4; ?></span>
                </td>
            </tr>
            <tr>
                <td class="text-center">
                    <span class="<?= $game->cssStyle('home', 1); ?>" title="Первое звено">
                        <?= $game->game_home_style_id_1; ?>
                    </span>
                    |
                    <span class="<?= $game->cssStyle('home', 2); ?>" title="Второе звено">
                        <?= $game->game_home_style_id_2; ?>
                    </span>
                    |
                    <span class="<?= $game->cssStyle('home', 3); ?>" title="Третье звено">
                        <?= $game->game_home_style_id_3; ?>
                    </span>
                    |
                    <span class="<?= $game->cssStyle('home', 4); ?>" title="Четвёртое звено">
                        <?= $game->game_home_style_id_4; ?>
                    </span>
                </td>
                <td class="text-center">Стиль</td>
                <td class="text-center">
                    <span class="<?= $game->cssStyle('guest', 1); ?>" title="Первое звено">
                        <?= $game->game_guest_style_id_1; ?>
                    </span>
                    |
                    <span class="<?= $game->cssStyle('guest', 2); ?>" title="Второе звено">
                        <?= $game->game_guest_style_id_2; ?>
                    </span>
                    |
                    <span class="<?= $game->cssStyle('guest', 3); ?>" title="Третье звено">
                        <?= $game->game_guest_style_id_3; ?>
                    </span>
                    |
                    <span class="<?= $game->cssStyle('guest', 4); ?>" title="Четвёртое звено">
                        <?= $game->game_guest_style_id_4; ?>
                    </span>
                </td>
            </tr>
            <tr>
                <td class="text-center">
                    <span title="Первое звено"><?= $game->game_home_rudeness_id_1; ?></span> |
                    <span title="Второе звено"><?= $game->game_home_rudeness_id_2; ?></span> |
                    <span title="Третье звено"><?= $game->game_home_rudeness_id_3; ?></span> |
                    <span title="Четвёртое звено"><?= $game->game_home_rudeness_id_4; ?></span>
                </td>
                <td class="text-center">Грубость</td>
                <td class="text-center">
                    <span title="Первое звено"><?= $game->game_guest_rudeness_id_1; ?></span> |
                    <span title="Второе звено"><?= $game->game_guest_rudeness_id_2; ?></span> |
                    <span title="Третье звено"><?= $game->game_guest_rudeness_id_3; ?></span> |
                    <span title="Четвёртое звено"><?= $game->game_guest_rudeness_id_4; ?></span>
                </td>
            </tr>
            <tr>
                <td class="text-center">
                    <span class="<?= $game->cssMood('home'); ?>">
                        <?= $game->game_home_mood_id; ?>
                    </span>
                </td>
                <td class="text-center">Настрой</td>
                <td class="text-center">
                    <span class="<?= $game->cssMood('guest'); ?>">
                        <?= $game->game_guest_mood_id; ?>
                    </span>
                </td>
            </tr>
            <tr>
                <td class="text-center">
                    <?= $game->game_home_power_percent; ?>%
                </td>
                <td class="text-center">Соотношение сил</td>
                <td class="text-center">
                    <?= $game->game_guest_power_percent; ?>%
                </td>
            </tr>
            <tr>
                <td class="text-center">
                    <span title="Расстановка сил по позициям"><?= $game->game_home_optimality_1; ?>%</span> |
                    <span title="Соотношение силы состава к ретингу команды"><?= $game->game_home_optimality_2; ?>
                        %</span>
                </td>
                <td class="text-center">Оптимальность</td>
                <td class="text-center">
                    <span title="Расстановка сил по позициям"><?= $game->game_guest_optimality_1; ?>%</span> |
                    <span title="Соотношение силы состава к ретингу команды"><?= $game->game_guest_optimality_2; ?>
                        %</span>
                </td>
            </tr>
            <tr>
                <td class="text-center">
                    <span title="Первое звено"><?= $game->game_home_teamwork_1; ?>%</span> |
                    <span title="Второе звено"><?= $game->game_home_teamwork_2; ?>%</span> |
                    <span title="Третье звено"><?= $game->game_home_teamwork_3; ?>%</span> |
                    <span title="Четвёртое звено"><?= $game->game_home_teamwork_4; ?>%</span>
                </td>
                <td class="text-center">Сыгранность</td>
                <td class="text-center">
                    <span title="Первое звено"><?= $game->game_guest_teamwork_1; ?>%</span> |
                    <span title="Второе звено"><?= $game->game_guest_teamwork_2; ?>%</span> |
                    <span title="Третье звено"><?= $game->game_guest_teamwork_3; ?>%</span> |
                    <span title="Четвёртое звено"><?= $game->game_guest_teamwork_4; ?>%</span>
                </td>
            </tr>
            <tr>
                <td class="text-center">
                    <?= $game->game_home_shot; ?>
                    (<?= $game->game_home_shot_1; ?> | <?= $game->game_home_shot_2; ?>
                    | <?= $game->game_home_shot_3; ?><?php if ($game->game_home_shot_overtime) : ?> | <?= $game->game_home_shot_overtime; ?><?php endif; ?>
                    )
                </td>
                <td class="text-center">Броски</td>
                <td class="text-center">
                    <?= $game->game_guest_shot; ?>
                    (<?= $game->game_guest_shot_1; ?> | <?= $game->game_guest_shot_2; ?>
                    | <?= $game->game_guest_shot_3; ?><?php if ($game->game_guest_shot_overtime) : ?> | <?= $game->game_guest_shot_overtime; ?><?php endif; ?>
                    )
                </td>
            </tr>
            <tr>
                <td class="text-center">
                    <?= $game->game_home_penalty; ?>
                    (<?= $game->game_home_penalty_1; ?> | <?= $game->game_home_penalty_2; ?>
                    | <?= $game->game_home_penalty_3; ?><?php if ($game->game_home_penalty_overtime) : ?> | <?= $game->game_home_penalty_overtime; ?><?php endif; ?>
                    )
                </td>
                <td class="text-center">Штрафные минуты</td>
                <td class="text-center">
                    <?= $game->game_guest_penalty; ?>
                    (<?= $game->game_guest_penalty_1; ?> | <?= $game->game_guest_penalty_2; ?>
                    | <?= $game->game_guest_penalty_3; ?><?php if ($game->game_guest_penalty_overtime) : ?> | <?= $game->game_guest_penalty_overtime; ?><?php endif; ?>
                    )
                </td>
            </tr>
        </table>
    </div>
</div>
<div class="row margin-top">
    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 table-responsive">
        <table class="table table-bordered">
            <tr>
                <td class="text-center">Прогноз на матч</td>
                <td
                        class="col-35 text-center
                    <?php if ($game->game_home_forecast > $game->game_guest_forecast) : ?>
                        font-green
                    <?php elseif ($game->game_home_forecast < $game->game_guest_forecast) : ?>
                        font-red
                    <?php endif; ?>"
                >
                    <?= $game->game_home_forecast; ?>
                </td>
                <td
                        class="col-35 text-center
                    <?php if ($game->game_home_forecast < $game->game_guest_forecast) : ?>
                        font-green
                    <?php elseif ($game->game_home_forecast > $game->game_guest_forecast): ?>
                        font-red
                    <?php endif; ?>"
                >
                    <?= $game->game_guest_forecast; ?>
                </td>
            </tr>
            <tr>
                <td class="text-center">Сила состава</td>
                <td class="text-center
                    <?php if ($game->game_home_power > $game->game_guest_power) : ?>
                        font-green
                    <?php elseif ($game->game_home_power < $game->game_guest_power) : ?>
                        font-red
                    <?php endif; ?>"
                >
                    <?= $game->game_home_power; ?>
                </td>
                <td
                        class="text-center
                    <?php if ($game->game_home_power < $game->game_guest_power) : ?>
                        font-green
                    <?php elseif ($game->game_home_power > $game->game_guest_power) : ?>
                        font-red
                    <?php endif; ?>"
                >
                    <?= $game->game_guest_power; ?>
                </td>
            </tr>
        </table>
    </div>
</div>
    <div class="row margin-top">
        <?php for ($i = 0; $i < 2; $i++) : ?>
            <?php
            if (0 == $i) {
                $team = 'teamHome';
                $national = 'nationalHome';
                $lineupArray = 'lineupHome';
            } else {
                $team = 'teamGuest';
                $national = 'nationalGuest';
                $lineupArray = 'lineupGuest';
            }
            ?>
            <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12 table-responsive">
                <table class="table table-bordered">
                    <tr>
                        <th title="Позиция">П</th>
                        <th>
                            <?= HockeyHelper::teamOrNationalLink($game->$team, $game->$national, false); ?>
                        </th>
                        <th class="hidden-xs" title="Возраст">В</th>
                        <th class="hidden-xs" title="Номинальная сила">НС</th>
                        <th title="Реальная сила">РС</th>
                        <th class="hidden-xs" title="Штрафные минуты">ШМ</th>
                        <th class="hidden-xs" title="Броски">Б</th>
                        <th title="Заброшенные шайбы (Пропушенные шайбы для вратарей)">Ш</th>
                        <th title="Голевые передачи">П</th>
                        <th title="Плюс/минус">+/-</th>
                    </tr>
                    <?php $power = 0; ?>
                    <?php for ($j = 0, $countLineup = count($game->$lineupArray); $j < $countLineup; $j++) : ?>
                        <?php if (in_array($j, [2, 7, 12, 17])) : ?>
                            <tr>
                                <td class="text-center text-size-2" colspan="10">
                                    <?php if (2 == $j) : ?>
                                        Первое
                                    <?php elseif (7 == $j) : ?>
                                        Второе
                                    <?php elseif (12 == $j) : ?>
                                        Третье
                                    <?php else : ?>
                                        Четвертое
                                    <?php endif; ?>
                                    звено
                                </td>
                            </tr>
                            <?php $power = 0; ?>
                        <?php endif; ?>
                        <?php $power = $power + $game->$lineupArray[$j]->lineup_power_real; ?>
                        <tr>
                            <td class="text-center <?php if (0 == $j) : ?>border-bottom-blue<?php endif; ?>">
                                <?= $game->$lineupArray[$j]->position->position_name; ?>
                            </td>
                            <td <?php if (0 == $j) : ?>class="border-bottom-blue"<?php endif; ?>>
                                <?= $game->$lineupArray[$j]->player->playerLink(); ?>
                                <?= $game->$lineupArray[$j]->iconPowerChange(); ?>
                            </td>
                            <td class="hidden-xs text-center <?php if (0 == $j): ?>border-bottom-blue<?php endif; ?>">
                                <?= $game->$lineupArray[$j]->lineup_age; ?>
                            </td>
                            <td class="hidden-xs text-center <?php if (0 == $j) : ?>border-bottom-blue<?php endif; ?>">
                                <?= $game->$lineupArray[$j]->lineup_power_nominal; ?>
                            </td>
                            <td class="text-center <?php if (0 == $j): ?>border-bottom-blue<?php endif; ?>">
                                <?= $game->$lineupArray[$j]->lineup_power_real; ?>
                            </td>
                            <td class="hidden-xs text-center <?php if (0 == $j) : ?>border-bottom-blue<?php endif; ?>">
                                <?= $game->$lineupArray[$j]->lineup_penalty; ?>
                            </td>
                            <td class="hidden-xs text-center <?php if (0 == $j) : ?>border-bottom-blue<?php endif; ?>">
                                <?= $game->$lineupArray[$j]->lineup_shot; ?>
                            </td>
                            <td class="text-center <?php if (0 == $j) : ?>border-bottom-blue<?php endif; ?>">
                                <?php if (Position::GK == $game->$lineupArray[$j]->position_id) : ?>
                                    <?= $game->$lineupArray[$j]->lineup_pass; ?>
                                <?php else : ?>
                                    <?= $game->$lineupArray[$j]->lineup_score; ?>
                                <?php endif; ?>
                            </td>
                            <td class="text-center <?php if (0 == $j) : ?>border-bottom-blue<?php endif; ?>">
                                <?= $game->$lineupArray[$j]->lineup_assist; ?>
                            </td>
                            <td class="text-center <?php if (0 == $j) : ?>border-bottom-blue<?php endif; ?>">
                                <?= $game->$lineupArray[$j]->lineup_plus_minus; ?>
                            </td>
                        </tr>
                        <?php if (in_array($j, [6, 11, 16, 21])) : ?>
                            <tr>
                                <td class="text-center border-bottom-blue" colspan="10">
                                    <span class="text-size-2">Общая сила звена -</span> <?= $power; ?>
                                </td>
                            </tr>
                        <?php endif; ?>
                    <?php endfor; ?>
                </table>
            </div>
        <?php endfor; ?>
    </div>
<?= $this->render('/site/_show-full-table'); ?>
<?php if (false) : ?>
    <div class="row margin-top">
        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 table-responsive">
            <table class="table table-bordered">
                <tr>
                    <th>Время</th>
                    <th>Команда</th>
                    <th class="hidden-xs">Тип</th>
                    <th>Событие</th>
                    <th>Счет</th>
                </tr>
                <?php foreach ($event_array as $item) { ?>
                    <tr>
                        <td class="text-center">
                            <?= sprintf("%02d", $item['event_minute']); ?>:<?= sprintf("%02d",
                                $item['event_second']); ?>
                        </td>
                        <td class="text-center">
                            <?= f_igosja_team_or_national_link(
                                array(
                                    'team_id' => $item['team_id'],
                                    'team_name' => $item['team_name'],
                                ),
                                array(
                                    'country_name' => $item['country_name'],
                                    'national_id' => $item['national_id'],
                                ),
                                false
                            ); ?>
                        </td>
                        <td class="hidden-xs text-center"><?= $item['eventtype_text']; ?></td>
                        <td>
                        <span class="hidden-xs">
                            <?= $item['eventtextbullet_text']; ?>
                            <?= $item['eventtextgoal_text']; ?>
                            <?= $item['eventtextpenalty_text']; ?>
                        </span>
                            <?php if ($item['event_player_penalty_id']) { ?>
                                Удаление -
                                <a href="/player_view.php?num=<?= $item['event_player_penalty_id']; ?>">
                                    <?= $item['name_penalty_name']; ?>
                                    <?= $item['surname_penalty_name']; ?>
                                </a>
                            <?php } ?>
                            <?php if ($item['event_player_score_id']) { ?>
                                <?php if ($item['eventtextgoal_text']) { ?>
                                    Шайба -
                                <?php } ?>
                                <a href="/player_view.php?num=<?= $item['event_player_score_id']; ?>">
                                    <?= $item['name_score_name']; ?>
                                    <?= $item['surname_score_name']; ?>
                                </a>
                            <?php } ?>
                            <?php if ($item['event_player_assist_1_id']) { ?>
                                (<a href="/player_view.php?num=<?= $item['event_player_assist_1_id']; ?>"><?=
                                $item['name_assist_1_name']; ?>
                                <?= $item['surname_assist_1_name'];
                                ?></a><?php if ($item['event_player_assist_2_id']) { ?>,
                                <a href="/player_view.php?num=<?= $item['event_player_assist_2_id']; ?>">
                                    <?= $item['name_assist_2_name']; ?>
                                    <?= $item['surname_assist_2_name']; ?></a><?php } ?>)
                            <?php } ?>
                        </td>
                        <td class="text-center">
                            <?php if (in_array($item['eventtype_id'], array(EVENTTYPE_GOAL, EVENTTYPE_BULLET))) { ?>
                                <?= $item['event_home_score']; ?>:<?= $item['event_guest_score']; ?>
                            <?php } ?>
                        </td>
                    </tr>
                <?php } ?>
            </table>
        </div>
    </div>
    <?= $this->render('/site/_show-full-table'); ?>
    <?php if ($gamecomment_array) { ?>
        <div class="row margin-top">
            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 text-center">
                <span class="strong">Последние комментарии:</span>
        </div>
    </div>
    <div class="row">
        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
            Всего комментариев: <?= $total; ?>
        </div>
    </div>
        <?php foreach ($gamecomment_array as $item) { ?>
            <div class="row border-top">
                <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 text-size-2">
                    <a class="strong" href="/user_view.php?num=<?= $item['user_id']; ?>">
                        <?= $item['user_login']; ?>
                    </a>
                </div>
                <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                    <?= nl2br($item['gamecomment_text']); ?>
                </div>
                <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 text-size-3 font-grey">
                    <?= f_igosja_ufu_date_time($item['gamecomment_date']); ?>
                    <?php if (isset($auth_user_id) && USERROLE_USER != $auth_userrole_id) { ?>
                        |
                        <a href="/gamecomment_delete.php?num=<?= $item['gamecomment_id']; ?>&game_id=<?= $num_get; ?>">
                            Удалить
                        </a>
                    <?php } ?>
                </div>
            </div>
        <?php } ?>
        <?php include(__DIR__ . '/include/pagination.php'); ?>
    <?php } ?>
    <?php if (isset($auth_user_id)) { ?>
        <?php if ($auth_date_block_gamecomment < time() && $auth_date_block_comment < time()) { ?>
            <div class="row margin-top">
                <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 text-center strong">
                    <label for="gamecomment">Ваш комментарий:</label>
                </div>
            </div>
            <form id="gamecomment-form" method="POST">
                <div class="row">
                    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                        <textarea class="form-control" id="gamecomment" name="data[text]" rows="5"></textarea>
                    </div>
                </div>
                <div class="row">
                    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 text-center gamecomment-error notification-error"></div>
                </div>
                <div class="row">
                    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 text-center">
                        <button class="btn margin">Комментировать</button>
                    </div>
                </div>
            </form>
        <?php } elseif ($auth_date_block_gamecomment >= time()) { ?>
            <div class="row margin-top">
                <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 text-center alert warning">
                    Вам заблокирован доступ к комментированию матчей
                    до <?= f_igosja_ufu_date_time($auth_date_block_gamecomment); ?>.
                    <br/>
                    Причина - <?= $auth_blockgame_text; ?>
                </div>
            </div>
        <?php } elseif ($auth_date_block_comment >= time()) { ?>
            <div class="row margin-top">
                <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 text-center alert warning">
                    Вам заблокирован доступ к комментированию матчей
                    до <?= f_igosja_ufu_date_time($auth_date_block_comment); ?>.
                    <br/>
                    Причина - <?= $auth_blockcomment_text; ?>
                </div>
            </div>
        <?php } ?>
    <?php } ?>
<?php endif; ?>