<?php

use coderlex\wysibb\WysiBB;
use common\components\ErrorHelper;
use common\components\FormatHelper;
use common\components\HockeyHelper;
use common\models\Event;
use common\models\EventType;
use common\models\Position;
use yii\grid\GridView;
use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\widgets\ListView;

/**
 * @var \yii\data\ActiveDataProvider $commentDataProvider
 * @var \yii\data\ActiveDataProvider $eventDataProvider
 * @var \common\models\Game $game
 * @var \common\models\GameComment $model
 * @var \common\models\Lineup[] $lineupGuest
 * @var \common\models\Lineup[] $lineupHome
 * @var \common\models\User $user
 */

$user = Yii::$app->user->identity;

?>
    <div class="row margin-top">
        <div class="col-lg-6 col-md-6 col-sm-6 col-xs-6">
            <?php if (!Yii::$app->user->isGuest) : ?>
                <?= Html::a(
                    '<i class="fa fa-thumbs-up" aria-hidden="true"></i>',
                    ['game/vote', 'id' => $game->game_id, 'vote' => 1],
                    ['title' => 'Интересный и правильный матч, заслуживает внимания']
                ); ?>
            <?php endif; ?>
            <span title="Оценка матча"><?= $game->rating(); ?></span>
            <?php if (!Yii::$app->user->isGuest) : ?>
                <?= Html::a(
                    '<i class="fa fa-thumbs-down" aria-hidden="true"></i>',
                    ['game/vote', 'id' => $game->game_id, 'vote' => -1],
                    ['title' => 'Неинтересный и нелогичный матч, генератор не прав']
                ); ?>
            <?php endif; ?>
        </div>
        <div class="col-lg-6 col-md-6 col-sm-6 col-xs-6 text-right">
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
                            <?= HockeyHelper::teamOrNationalLink($game->teamHome, $game->nationalHome, false, true, 'img'); ?>
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
                            <?= HockeyHelper::teamOrNationalLink($game->teamGuest, $game->nationalGuest, false, true, 'img'); ?>
                            <?= HockeyHelper::formatAuto($game->game_guest_auto); ?>
                        </div>
                    </th>
                </tr>
            </table>
        </div>
    </div>
    <div class="row">
        <div class="col-lg-1 col-md-1 col-sm-1 col-xs-1 text-center">
            <?php if (file_exists(Yii::getAlias('@webroot') . '/img/team/125/' . $game->teamHome->team_id . '.png')) : ?>
                <?= Html::img(
                    '/img/team/125/' . $game->teamHome->team_id . '.png?v=' . filemtime(Yii::getAlias('@webroot') . '/img/team/125/' . $game->teamHome->team_id . '.png'),
                    [
                        'alt' => $game->teamHome->team_name,
                        'class' => 'team-logo-game',
                        'title' => $game->teamHome->team_name,
                    ]
                ); ?>
            <?php endif; ?>
        </div>
        <div class="col-lg-10 col-md-10 col-sm-10 col-xs-10 text-center">
            <div class="row">
                <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 text-center">
                    <?= FormatHelper::asDatetime($game->schedule->schedule_date); ?>,
                    <?= $game->tournamentLink(); ?>
                </div>
            </div>
            <div class="row">
                <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 text-center">
                    <?= Html::a($game->stadium->stadium_name, ['team/view', 'id' => $game->stadium->team->team_id]); ?>
                    (<?= $game->stadium->stadium_capacity; ?>),
                    Зрителей: <?= $game->game_visitor; ?>.
                    Билет: <?= FormatHelper::asCurrency($game->game_ticket); ?>
                </div>
            </div>
        </div>
        <div class="col-lg-1 col-md-1 col-sm-1 col-xs-1 text-center">
            <?php if (file_exists(Yii::getAlias('@webroot') . '/img/team/125/' . $game->teamGuest->team_id . '.png')) : ?>
                <?= Html::img(
                    '/img/team/125/' . $game->teamGuest->team_id . '.png?v=' . filemtime(Yii::getAlias('@webroot') . '/img/team/125/' . $game->teamGuest->team_id . '.png'),
                    [
                        'alt' => $game->teamGuest->team_name,
                        'class' => 'team-logo-game',
                        'title' => $game->teamGuest->team_name,
                    ]
                ); ?>
            <?php endif; ?>
        </div>
    </div>
    <div class="row">
        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 table-responsive">
            <table class="table table-bordered">
                <tr>
                    <td class="col-35 text-center">
                        <span title="Первое звено"><?= $game->tacticHome1->tactic_name; ?></span>
                        |
                        <span title="Второе звено"><?= $game->tacticHome2->tactic_name; ?></span>
                        |
                        <span title="Третье звено"><?= $game->tacticHome3->tactic_name; ?></span>
                        |
                        <span title="Четвёртое звено"><?= $game->tacticHome4->tactic_name; ?></span>
                    </td>
                    <td class="text-center">Тактика</td>
                    <td class="col-35 text-center">
                        <span title="Первое звено"><?= $game->tacticGuest1->tactic_name; ?></span>
                        |
                        <span title="Второе звено"><?= $game->tacticGuest2->tactic_name; ?></span>
                        |
                        <span title="Третье звено"><?= $game->tacticGuest3->tactic_name; ?></span>
                        |
                        <span title="Четвёртое звено"><?= $game->tacticGuest4->tactic_name; ?></span>
                    </td>
                </tr>
                <tr>
                    <td class="text-center">
                    <span class="<?= $game->cssStyle('home', 1); ?>" title="Первое звено">
                        <?= $game->styleHome1->style_name; ?>
                    </span>
                        |
                        <span class="<?= $game->cssStyle('home', 2); ?>" title="Второе звено">
                        <?= $game->styleHome2->style_name; ?>
                    </span>
                        |
                        <span class="<?= $game->cssStyle('home', 3); ?>" title="Третье звено">
                        <?= $game->styleHome3->style_name; ?>
                    </span>
                        |
                        <span class="<?= $game->cssStyle('home', 4); ?>" title="Четвёртое звено">
                        <?= $game->styleHome4->style_name; ?>
                    </span>
                    </td>
                    <td class="text-center">Стиль</td>
                    <td class="text-center">
                    <span class="<?= $game->cssStyle('guest', 1); ?>" title="Первое звено">
                        <?= $game->styleGuest1->style_name; ?>
                    </span>
                        |
                        <span class="<?= $game->cssStyle('guest', 2); ?>" title="Второе звено">
                        <?= $game->styleGuest2->style_name; ?>
                    </span>
                        |
                        <span class="<?= $game->cssStyle('guest', 3); ?>" title="Третье звено">
                        <?= $game->styleGuest3->style_name; ?>
                    </span>
                        |
                        <span class="<?= $game->cssStyle('guest', 4); ?>" title="Четвёртое звено">
                        <?= $game->styleGuest4->style_name; ?>
                    </span>
                    </td>
                </tr>
                <tr>
                    <td class="text-center">
                        <span title="Первое звено"><?= $game->rudenessHome1->rudeness_name; ?></span> |
                        <span title="Второе звено"><?= $game->rudenessHome2->rudeness_name; ?></span> |
                        <span title="Третье звено"><?= $game->rudenessHome3->rudeness_name; ?></span> |
                        <span title="Четвёртое звено"><?= $game->rudenessHome4->rudeness_name; ?></span>
                    </td>
                    <td class="text-center">Грубость</td>
                    <td class="text-center">
                        <span title="Первое звено"><?= $game->rudenessGuest1->rudeness_name; ?></span> |
                        <span title="Второе звено"><?= $game->rudenessGuest2->rudeness_name; ?></span> |
                        <span title="Третье звено"><?= $game->rudenessGuest3->rudeness_name; ?></span> |
                        <span title="Четвёртое звено"><?= $game->rudenessGuest4->rudeness_name; ?></span>
                    </td>
                </tr>
                <tr>
                    <td class="text-center">
                    <span class="<?= $game->cssMood('home'); ?>">
                        <?= $game->moodHome->mood_name; ?>
                    </span>
                    </td>
                    <td class="text-center">Настрой</td>
                    <td class="text-center">
                    <span class="<?= $game->cssMood('guest'); ?>">
                        <?= $game->moodGuest->mood_name; ?>
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
                $team = $game->teamHome;
                $national = $game->nationalHome;
                $lineupArray = $lineupHome;
            } else {
                $team = $game->teamGuest;
                $national = $game->nationalGuest;
                $lineupArray = $lineupGuest;
            }
            ?>
            <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12 table-responsive">
                <table class="table table-bordered">
                    <tr>
                        <th class="col-6" title="Позиция">П</th>
                        <th>
                            <?= HockeyHelper::teamOrNationalLink($team, $national, false); ?>
                        </th>
                        <th class="col-6 hidden-xs" title="Возраст">В</th>
                        <th class="col-6 hidden-xs" title="Номинальная сила">НС</th>
                        <th class="col-6" title="Реальная сила">РС</th>
                        <th class="hidden-xs hidden-sm" title="Спецвозможности">Сп</th>
                        <th class="col-6 hidden-xs" title="Штрафные минуты">ШМ</th>
                        <th class="col-6 hidden-xs" title="Броски">Б</th>
                        <th class="col-6" title="Заброшенные шайбы (Пропушенные шайбы для вратарей)">Ш</th>
                        <th class="col-6" title="Голевые передачи">П</th>
                        <th class="col-6" title="Плюс/минус">+/-</th>
                    </tr>
                    <?php $power = 0; ?>
                    <?php for ($j = 0, $countLineup = count($lineupArray); $j < $countLineup; $j++) : ?>
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
                        <?php $power = $power + $lineupArray[$j]->lineup_power_real; ?>
                        <tr>
                            <td class="text-center <?php if (1 == $j) : ?>border-bottom-blue<?php endif; ?>">
                                <?= $lineupArray[$j]->position->position_name; ?>
                            </td>
                            <td <?php if (1 == $j) : ?>class="border-bottom-blue"<?php endif; ?>>
                                <?= $lineupArray[$j]->player->playerLink(); ?>
                                <?= $lineupArray[$j]->iconCaptain(); ?>
                                <?= $lineupArray[$j]->iconPowerChange(); ?>
                            </td>
                            <td class="hidden-xs text-center <?php if (1 == $j): ?>border-bottom-blue<?php endif; ?>">
                                <?= $lineupArray[$j]->lineup_age; ?>
                            </td>
                            <td class="hidden-xs text-center <?php if (1 == $j) : ?>border-bottom-blue<?php endif; ?>">
                                <?= $lineupArray[$j]->lineup_power_nominal; ?>
                            </td>
                            <td class="text-center <?php if (1 == $j): ?>border-bottom-blue<?php endif; ?>">
                                <?= $lineupArray[$j]->lineup_power_real; ?>
                            </td>
                            <td class="text-size-2 hidden-xs hidden-sm text-center <?php if (1 == $j): ?>border-bottom-blue<?php endif; ?>">
                                <?= $lineupArray[$j]->special(); ?>
                            </td>
                            <td class="hidden-xs text-center <?php if (1 == $j) : ?>border-bottom-blue<?php endif; ?>">
                                <?= $lineupArray[$j]->lineup_penalty; ?>
                            </td>
                            <td class="hidden-xs text-center <?php if (1 == $j) : ?>border-bottom-blue<?php endif; ?>">
                                <?= $lineupArray[$j]->lineup_shot; ?>
                            </td>
                            <td class="text-center <?php if (1 == $j) : ?>border-bottom-blue<?php endif; ?>">
                                <?php if (Position::GK == $lineupArray[$j]->lineup_position_id) : ?>
                                    <?= $lineupArray[$j]->lineup_pass; ?>
                                <?php else : ?>
                                    <?= $lineupArray[$j]->lineup_score; ?>
                                <?php endif; ?>
                            </td>
                            <td class="text-center <?php if (1 == $j) : ?>border-bottom-blue<?php endif; ?>">
                                <?= $lineupArray[$j]->lineup_assist; ?>
                            </td>
                            <td class="text-center <?php if (1 == $j) : ?>border-bottom-blue<?php endif; ?>">
                                <?= $lineupArray[$j]->lineup_plus_minus; ?>
                            </td>
                        </tr>
                        <?php if (in_array($j, [6, 11, 16, 21])) : ?>
                            <tr>
                                <td class="text-center border-bottom-blue" colspan="11">
                                    <span class="text-size-2">Общая сила звена -</span> <?= $power; ?>
                                </td>
                            </tr>
                        <?php endif; ?>
                    <?php endfor; ?>
                </table>
            </div>
        <?php endfor; ?>
    </div>
<?= $this->render('//site/_show-full-table'); ?>
    <div class="row margin-top">
        <?php

        try {
            $columns = [
                [
                    'contentOptions' => ['class' => 'text-center'],
                    'header' => 'Время',
                    'value' => function (Event $model) {
                        return sprintf("%02d", $model->event_minute) . ':' . sprintf("%02d", $model->event_second);
                    }
                ],
                [
                    'contentOptions' => ['class' => 'text-center'],
                    'format' => 'raw',
                    'header' => 'Команда',
                    'value' => function (Event $model) {
                        return HockeyHelper::teamOrNationalLink($model->team, $model->national, false);
                    }
                ],
                [
                    'contentOptions' => ['class' => 'text-center hidden-xs'],
                    'header' => 'Тип',
                    'headerOptions' => ['class' => 'text-center hidden-xs'],
                    'value' => function (Event $model) {
                        return $model->eventType->event_type_text;
                    }
                ],
                [
                    'contentOptions' => ['class' => 'text-center hidden-xs'],
                    'format' => 'raw',
                    'header' => 'Событие',
                    'headerOptions' => ['class' => 'hidden-xs'],
                    'value' => function (Event $model) {
                        $result = '';
                        if ($model->eventTextGoal) {
                            $result = $result . $model->eventTextGoal->event_text_goal_text;
                        }
                        if ($model->eventTextPenalty) {
                            $result = $result . $model->eventTextPenalty->event_text_penalty_text;
                        }
                        if ($model->eventTextShootout) {
                            $result = $result . $model->eventTextShootout->event_text_shootout_text;
                        }
                        if ($model->playerPenalty) {
                            $result = $result . ' Удаление - ' . $model->playerPenalty->playerLink();
                        }
                        if ($model->playerScore) {
                            $result = $result . ' Шайба - ' . $model->playerScore->playerLink();
                        }
                        if ($model->playerAssist1) {
                            $result = $result . ' (' . $model->playerAssist1->playerLink();
                            if ($model->playerAssist2) {
                                $result = $result . ', ' . $model->playerAssist2->playerLink();
                            }
                            $result = $result . ')';
                        }
                        return $result;
                    }
                ],
                [
                    'contentOptions' => ['class' => 'text-center'],
                    'header' => 'Счёт',
                    'value' => function (Event $model) {
                        if (in_array($model->event_event_type_id, [EventType::GOAL, EventType::SHOOTOUT])) {
                            return $model->event_home_score . ':' . $model->event_guest_score;
                        }
                        return '';
                    }
                ],
            ];
            print GridView::widget([
                'columns' => $columns,
                'dataProvider' => $eventDataProvider,
                'summary' => false,
            ]);
        } catch (Exception $e) {
            ErrorHelper::log($e);
        }

        ?>
    </div>
<?= $this->render('//site/_show-full-table'); ?>
<?php if ($commentDataProvider->models) : ?>
    <div class="row margin-top">
        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 text-center">
            <span class="strong">Последние комментарии:</span>
        </div>
    </div>
    <div class="row">
        <?php

        try {
            print ListView::widget([
                'dataProvider' => $commentDataProvider,
                'itemView' => '_comment',
            ]);
        } catch (Exception $e) {
            ErrorHelper::log($e);
        }

        ?>
    </div>
<?php endif; ?>
<?php if (!Yii::$app->user->isGuest) : ?>
    <?php if (!$user->user_date_confirm) : ?>
        <div class="row margin-top">
            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 text-center alert warning">
                Вам заблокирован доступ к комментированию матчей
                <br/>
                Причина - ваш почтовый адрес не подтверждён
            </div>
        </div>
    <?php elseif ($user->user_date_block_comment_game >= time()) : ?>
        <div class="row margin-top">
            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 text-center alert warning">
                Вам заблокирован доступ к комментированию матчей до
                <?= FormatHelper::asDatetime($user->user_date_block_comment_game); ?>
                <br/>
                Причина - <?= $user->reasonBlockCommentGame->block_reason_text; ?>
            </div>
        </div>
    <?php elseif ($user->user_date_block_comment >= time()) : ?>
        <div class="row margin-top">
            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 text-center alert warning">
                Вам заблокирован доступ к комментированию матчей до
                <?= FormatHelper::asDatetime($user->user_date_block_comment); ?>
                <br/>
                Причина - <?= $user->reasonBlockComment->block_reason_text; ?>
            </div>
        </div>
    <?php else: ?>
        <?php $form = ActiveForm::begin([
            'fieldConfig' => [
                'errorOptions' => [
                    'class' => 'col-lg-12 col-md-12 col-sm-12 col-xs-12 text-center notification-error',
                    'tag' => 'div'
                ],
                'options' => ['class' => 'row'],
                'template' =>
                    '<div class="row">
                <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 text-center strong">{label}</div>
                </div>
                <div class="row">
                <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">{input}</div>
                </div>
                <div class="row">{error}</div>',
            ],
        ]); ?>
        <?= $form->field($model, 'game_comment_text')->widget(WysiBB::class)->label('Ваш комментарий:'); ?>
        <div class="row margin-top-small">
            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 text-center">
                <?= Html::submitButton('Комментировать', ['class' => 'btn margin']); ?>
            </div>
        </div>
        <?php ActiveForm::end(); ?>
    <?php endif; ?>
<?php endif; ?>