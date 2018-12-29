<?php

use common\components\ErrorHelper;
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
                        <th title="Позиция">П</th>
                        <th>
                            <?= HockeyHelper::teamOrNationalLink($team, $national, false); ?>
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
<?= $this->render('//site/_show-full-table'); ?>
    <div class="row margin-top">
        <?php

        try {
            $columns = [
                [
                    'contentOptions' => ['class' => 'text-center'],
                    'header' => 'Время',
                    'value' => function (Event $model): string {
                        return sprintf("%02d", $model->event_minute) . ':' . sprintf("%02d", $model->event_second);
                    }
                ],
                [
                    'contentOptions' => ['class' => 'text-center'],
                    'format' => 'raw',
                    'header' => 'Команда',
                    'value' => function (Event $model): string {
                        return HockeyHelper::teamOrNationalLink($model->team, $model->national, false);
                    }
                ],
                [
                    'contentOptions' => ['class' => 'text-center hidden-xs'],
                    'header' => 'Тип',
                    'headerOptions' => ['class' => 'text-center hidden-xs'],
                    'value' => function (Event $model): string {
                        return $model->eventType->event_type_text;
                    }
                ],
                [
                    'contentOptions' => ['class' => 'text-center hidden-xs'],
                    'format' => 'raw',
                    'header' => 'Событие',
                    'headerOptions' => ['class' => 'hidden-xs'],
                    'value' => function (Event $model): string {
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
                    'value' => function (Event $model): string {
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
<?php if (!Yii::$app->user->isGuest) : ?>
    <?php if ($user->user_date_block_comment_game >= time()) : ?>
        <div class="row margin-top">
            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 text-center alert warning">
                Вам заблокирован доступ к комментированию матчей до
                <?php

                try {
                    Yii::$app->formatter->asDatetime($user->user_date_block_comment_news, 'short');
                } catch (Exception $e) {
                    ErrorHelper::log($e);
                }

                ?>
                <br/>
                Причина - <?= $user->reasonBlockCommentGame->block_reason_text; ?>
            </div>
        </div>
    <?php elseif ($user->user_date_block_comment >= time()) : ?>
        <div class="row margin-top">
            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 text-center alert warning">
                Вам заблокирован доступ к комментированию матчей до
                <?php

                try {
                    Yii::$app->formatter->asDatetime($user->user_date_block_comment, 'short');
                } catch (Exception $e) {
                    ErrorHelper::log($e);
                }

                ?>
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
        <?= $form->field($model, 'game_comment_text')->textarea(['rows' => 5])->label('Ваш комментарий:'); ?>
        <div class="row margin-top-small">
            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 text-center">
                <?= Html::submitButton('Комментировать', ['class' => 'btn margin']); ?>
            </div>
        </div>
        <?php ActiveForm::end(); ?>
    <?php endif; ?>
<?php endif; ?>