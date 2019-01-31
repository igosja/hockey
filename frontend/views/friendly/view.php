<?php

use common\components\ErrorHelper;
use common\components\FormatHelper;
use common\models\FriendlyInvite;
use common\models\FriendlyInviteStatus;
use common\models\FriendlyStatus;
use common\models\Schedule;
use common\models\Team;
use yii\grid\GridView;
use yii\helpers\Html;

/**
 * @var \yii\data\ActiveDataProvider $receivedDataProvider
 * @var \yii\data\ActiveDataProvider $sentDataProvider
 * @var array $scheduleStatusArray
 * @var \yii\data\ActiveDataProvider $scheduleDataProvider
 * @var \common\models\Team $team
 * @var \yii\data\ActiveDataProvider $teamDataProvider
 */

?>
<div class="row margin-top">
    <div class="col-lg-6 col-md-6 col-sm-6 col-xs-6">
        <div class="row">
            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 strong text-size-1">
                <?= $team->team_name; ?>
                (<?= $team->stadium->city->city_name; ?>, <?= $team->stadium->city->country->country_name; ?>)
            </div>
            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                <?= Html::a(
                    $team->friendlyStatus->friendly_status_name,
                    ['friendly/status']
                ); ?>
            </div>
        </div>
    </div>
    <div class="col-lg-6 col-md-6 col-sm-6 col-xs-6">
        <div class="row">
            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 strong text-right text-size-1">
                Организация товарищеских матчей
            </div>
        </div>
    </div>
</div>
<div class="row margin-top">
    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 strong">
        Ближайшие дни товарищеских матчей:
    </div>
</div>
<div class="row">
    <?php

    try {
        $columns = [
            [
                'contentOptions' => ['class' => 'text-center'],
                'format' => 'raw',
                'headerOptions' => ['class' => 'col-25'],
                'label' => 'День',
                'value' => function (Schedule $model) {
                    return Html::a(
                        FormatHelper::asDate($model->schedule_date),
                        ['friendly/view', 'id' => $model->schedule_id]
                    );
                }
            ],
            [
                'format' => 'raw',
                'label' => 'Статус',
                'value' => function (Schedule $model) use ($scheduleStatusArray) {
                    return $scheduleStatusArray[$model->schedule_id];
                }
            ],
        ];
        print GridView::widget([
            'columns' => $columns,
            'dataProvider' => $scheduleDataProvider,
            'emptyText' => 'В ближаещие дни не запланировано товарищеских матчей.',
            'rowOptions' => function (Schedule $model) {
                $result = [];
                if ($model->schedule_id == Yii::$app->request->get('id')) {
                    $result['class'] = 'info';
                }
                return $result;
            },
            'summary' => false,
        ]);
    } catch (Exception $e) {
        ErrorHelper::log($e);
    }

    ?>
</div>
<div class="row margin-top">
    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 strong">
        Полученные приглашения на выбранный день:
    </div>
</div>
<div class="row">
    <?php

    try {
        $columns = [
            [
                'contentOptions' => ['class' => 'text-center'],
                'format' => 'raw',
                'headerOptions' => ['class' => 'col-5'],
                'value' => function (FriendlyInvite $model) {
                    if (FriendlyInviteStatus::NEW_ONE == $model->friendly_invite_friendly_invite_status_id) {
                        return Html::a(
                                '<i class="fa fa-check-circle"></i>',
                                ['friendly/accept', 'id' => $model->friendly_invite_id],
                                ['title' => 'Принять']
                            ) . ' ' . Html::a(
                                '<i class="fa fa-times-circle"></i>',
                                ['friendly/cancel', 'id' => $model->friendly_invite_id],
                                ['title' => 'Отклонить']
                            );
                    }
                    return '';
                }
            ],
            [
                'format' => 'raw',
                'label' => 'Команда',
                'value' => function (FriendlyInvite $model) {
                    return $model->homeTeam->teamLink('img');
                }
            ],
            [
                'contentOptions' => ['class' => 'text-center'],
                'headerOptions' => ['class' => 'col-10', 'title' => 'Рейтинг силы команды в длительных соревнованиях'],
                'label' => 'Vs',
                'value' => function (FriendlyInvite $model) {
                    return $model->homeTeam->team_power_vs;
                }
            ],
            [
                'contentOptions' => ['class' => 'text-center'],
                'headerOptions' => [
                    'class' => 'col-10',
                    'title' => 'Соотношение сил (чем больше это число, тем сильнее соперник)',
                ],
                'label' => 'С/С',
                'value' => function (FriendlyInvite $model) use ($team) {
                    return round(
                            $model->homeTeam->team_power_vs / $team->team_power_vs * 100
                        ) . '%';
                }
            ],
            [
                'contentOptions' => ['class' => 'text-center'],
                'headerOptions' => ['class' => 'col-10'],
                'label' => 'Стадион',
                'value' => function (FriendlyInvite $model) {
                    return Yii::$app->formatter->asInteger($model->homeTeam->stadium->stadium_capacity);
                }
            ],
            [
                'contentOptions' => ['class' => 'text-center'],
                'headerOptions' => ['class' => 'col-10', 'title' => 'Рейтинг посещаемости'],
                'label' => 'РП',
                'value' => function (FriendlyInvite $model) {
                    return Yii::$app->formatter->asDecimal($model->homeTeam->team_visitor / 100);
                }
            ],
        ];
        print GridView::widget([
            'columns' => $columns,
            'dataProvider' => $receivedDataProvider,
            'summary' => false,
        ]);
    } catch (Exception $e) {
        ErrorHelper::log($e);
    }

    ?>
</div>
<div class="row margin-top">
    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 strong">
        Отправленные приглашения на выбранный день:
    </div>
</div>
<div class="row">
    <?php

    try {
        $columns = [
            [
                'contentOptions' => ['class' => 'text-center'],
                'format' => 'raw',
                'headerOptions' => ['class' => 'col-5'],
                'value' => function (FriendlyInvite $model) {
                    if (FriendlyInviteStatus::NEW_ONE == $model->friendly_invite_friendly_invite_status_id) {
                        return Html::a(
                            '<i class="fa fa-times-circle"></i>',
                            ['friendly/cancel', 'id' => $model->friendly_invite_id],
                            ['title' => 'Отклонить']
                        );
                    }
                    return '';
                }
            ],
            [
                'format' => 'raw',
                'label' => 'Команда',
                'value' => function (FriendlyInvite $model) {
                    return $model->guestTeam->teamLink('img');
                }
            ],
            [
                'headerOptions' => ['class' => 'col-40'],
                'label' => 'Статус',
                'value' => function (FriendlyInvite $model) {
                    return $model->friendlyInviteStatus->friendly_invite_status_name;
                }
            ],
        ];
        print GridView::widget([
            'columns' => $columns,
            'dataProvider' => $sentDataProvider,
            'summary' => false,
        ]);
    } catch (Exception $e) {
        ErrorHelper::log($e);
    }

    ?>
</div>
<div class="row margin-top">
    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 strong">
        Доступные соперники:
    </div>
</div>
<div class="row">
    <?php

    try {
        $columns = [
            [
                'contentOptions' => ['class' => 'text-center'],
                'format' => 'raw',
                'headerOptions' => ['class' => 'col-5'],
                'value' => function (Team $model) {
                    return Html::a(
                        '<i class="fa fa-check-circle"></i>',
                        ['friendly/send', 'id' => Yii::$app->request->get('id'), 'teamId' => $model->team_id],
                        ['title' => 'Отправить приглашение']
                    );
                }
            ],
            [
                'format' => 'raw',
                'label' => 'Команда',
                'value' => function (Team $model) {
                    return $model->teamLink('img');
                }
            ],
            [
                'contentOptions' => ['class' => 'text-center'],
                'headerOptions' => ['class' => 'col-10', 'title' => 'Рейтинг силы команды в длительных соревнованиях'],
                'label' => 'Vs',
                'value' => function (Team $model) {
                    return $model->team_power_vs;
                }
            ],
            [
                'contentOptions' => ['class' => 'text-center'],
                'headerOptions' => [
                    'class' => 'col-10',
                    'title' => 'Соотношение сил (чем больше это число, тем сильнее соперник)',
                ],
                'label' => 'С/С',
                'value' => function (Team $model) use ($team) {
                    return round($model->team_power_vs / $team->team_power_vs * 100) . '%';
                }
            ],
            [
                'contentOptions' => ['class' => 'text-center'],
                'headerOptions' => ['class' => 'col-10', 'title' => 'Рейтинг посещаемости'],
                'label' => 'РП',
                'value' => function (Team $model) {
                    return Yii::$app->formatter->asDecimal($model->team_visitor / 100);
                }
            ],
        ];
        print GridView::widget([
            'columns' => $columns,
            'dataProvider' => $teamDataProvider,
            'rowOptions' => function (Team $model) {
                if ($model->team_friendly_status_id == FriendlyStatus::ALL) {
                    return ['class' => 'success', 'title' => 'Игра будет организована мгновенно'];
                }
                return [];
            },
            'summary' => false,
        ]);
    } catch (Exception $e) {
        ErrorHelper::log($e);
    }

    ?>
</div>
