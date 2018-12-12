<?php

use common\components\ErrorHelper;
use common\components\HockeyHelper;
use common\models\Game;
use yii\grid\GridView;
use yii\helpers\Html;

/**
 * @var \yii\data\ActiveDataProvider $dataProvider
 * @var array $seasonArray
 * @var int $seasonId
 * @var \yii\web\View $this
 */

print $this->render('_team-top');

?>
<?= Html::beginForm('', 'get'); ?>
    <div class="row margin-top-small">
        <div class="col-lg-10 col-md-10 col-sm-10 col-xs-10">
            <?= $this->render('_team-links'); ?>
        </div>
        <div class="col-lg-2 col-md-2 col-sm-2 col-xs-2">
            <div class="row">
                <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12 text-right">
                    <?= Html::label('Сезон', 'seasonId') ?>
                </div>
                <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
                    <?= Html::dropDownList(
                        'season_id',
                        $seasonId,
                        $seasonArray,
                        ['class' => 'form-control submit-on-change', 'id' => 'seasonId']
                    ); ?>
                </div>
            </div>
        </div>
    </div>
<?= Html::endForm(); ?>
<div class="row">
    <?php

    try {
        $columns = [
            [
                'contentOptions' => ['class' => 'text-center'],
                'footer' => 'Дата',
                'header' => 'Дата',
                'headerOptions' => ['class' => 'col-15'],
                'value' => function (Game $model): string {
                    return Yii::$app->formatter->asDate($model->schedule->schedule_date, 'short');
                }
            ],
            [
                'contentOptions' => ['class' => 'hidden-xs text-center'],
                'footer' => 'Турнир',
                'footerOptions' => ['class' => 'hidden-xs'],
                'header' => 'Турнир',
                'headerOptions' => ['class' => 'col-30 hidden-xs'],
                'value' => function (Game $model): string {
                    return $model->schedule->tournamentType->tournament_type_name;
                }
            ],
            [
                'contentOptions' => ['class' => 'hidden-xs text-center'],
                'footer' => 'Стадия',
                'footerOptions' => ['class' => 'hidden-xs'],
                'header' => 'Стадия',
                'headerOptions' => ['class' => 'col-10 hidden-xs'],
                'value' => function (Game $model): string {
                    return $model->schedule->stage->stage_name;
                }
            ],
            [
                'contentOptions' => ['class' => 'hidden-xs text-center'],
                'footerOptions' => ['class' => 'hidden-xs', 'title' => 'Дома/В гостях'],
                'headerOptions' => ['class' => 'col-1 hidden-xs', 'title' => 'Дома/В гостях'],
                'value' => function (Game $model): string {
                    return HockeyHelper::gameHomeGuest($model, Yii::$app->request->get('id'));
                }
            ],
            [
                'contentOptions' => ['class' => 'hidden-xs text-center'],
                'footer' => 'С/С',
                'footerOptions' => [
                    'class' => 'hidden-xs',
                    'title' => 'Соотношение сил (чем больше это число, тем сильнее соперник)'
                ],
                'header' => 'С/С',
                'headerOptions' => [
                    'class' => 'col-5 hidden-xs',
                    'title' => 'Соотношение сил (чем больше это число, тем сильнее соперник)'
                ],
                'value' => function (Game $model): string {
                    return HockeyHelper::gamePowerPercent($model, Yii::$app->request->get('id'));
                }
            ],
            [
                'footer' => 'Соперник',
                'format' => 'raw',
                'header' => 'Соперник',
                'value' => function (Game $model): string {
                    return HockeyHelper::opponentLink($model, Yii::$app->request->get('id'));
                }
            ],
            [
                'contentOptions' => ['class' => 'hidden-xs text-center'],
                'footer' => 'А',
                'footerOptions' => ['class' => 'hidden-xs', 'title' => 'Автосостав'],
                'header' => 'А',
                'headerOptions' => ['class' => 'col-1 hidden-xs', 'title' => 'Автосостав'],
                'value' => function (Game $model): string {
                    return HockeyHelper::gameAuto($model, Yii::$app->request->get('id'));
                }
            ],
            [
                'contentOptions' => ['class' => 'text-center'],
                'footer' => 'Счёт',
                'format' => 'raw',
                'header' => 'Счёт',
                'value' => function (Game $model): string {
                    return Html::a(
                        HockeyHelper::formatTeamScore($model, Yii::$app->request->get('id')),
                        ['game/view', 'id' => $model->game_id]
                    );
                }
            ],
            [
                'contentOptions' => ['class' => 'hidden-xs text-center'],
                'footerOptions' => ['class' => 'hidden-xs', 'title' => 'Количество набранных/потерянных баллов'],
                'headerOptions' => ['class' => 'col-1 hidden-xs', 'title' => 'Количество набранных/потерянных баллов'],
                'value' => function (Game $model): string {
                    return HockeyHelper::gamePlusMinus($model, Yii::$app->request->get('id'));
                }
            ],
        ];
        print GridView::widget([
            'columns' => $columns,
            'dataProvider' => $dataProvider,
            'showFooter' => true,
            'summary' => false,
        ]);
    } catch (Exception $e) {
        ErrorHelper::log($e);
    }

    ?>
</div>
<div class="row">
    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
        <?= $this->render('_team-links'); ?>
    </div>
</div>
<?= $this->render('//site/_show-full-table'); ?>
