<?php

use common\components\ErrorHelper;
use common\components\FormatHelper;
use common\components\HockeyHelper;
use common\models\Game;
use yii\grid\GridView;
use yii\helpers\Html;

/**
 * @var \yii\data\ActiveDataProvider $dataProvider
 * @var array $seasonArray
 * @var int $seasonId
 * @var \common\models\National $national
 * @var \yii\web\View $this
 * @var int $totalPoint
 */

?>
<div class="row margin-top">
    <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
        <?= $this->render('//national/_national-top-left', ['national' => $national]); ?>
    </div>
    <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12 text-right">
        <?= $this->render('//national/_national-top-right', ['national' => $national]); ?>
    </div>
</div>
<?= Html::beginForm(['national/game', 'id' => $national->national_id], 'get'); ?>
<div class="row margin-top-small">
    <div class="col-lg-10 col-md-10 col-sm-10 col-xs-10">
        <?= $this->render('//national/_national-links'); ?>
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
                'headerOptions' => ['class' => 'col-15'],
                'label' => 'Дата',
                'value' => function (Game $model) {
                    return FormatHelper::asDate($model->schedule->schedule_date);
                }
            ],
            [
                'contentOptions' => ['class' => 'hidden-xs text-center'],
                'footer' => 'Турнир',
                'footerOptions' => ['class' => 'hidden-xs'],
                'headerOptions' => ['class' => 'col-30 hidden-xs'],
                'label' => 'Турнир',
                'value' => function (Game $model) {
                    return $model->schedule->tournamentType->tournament_type_name;
                }
            ],
            [
                'contentOptions' => ['class' => 'hidden-xs text-center'],
                'footer' => 'Стадия',
                'footerOptions' => ['class' => 'hidden-xs'],
                'headerOptions' => ['class' => 'col-10 hidden-xs'],
                'label' => 'Стадия',
                'value' => function (Game $model) {
                    return $model->schedule->stage->stage_name;
                }
            ],
            [
                'contentOptions' => ['class' => 'hidden-xs text-center'],
                'footerOptions' => ['class' => 'hidden-xs', 'title' => 'Дома/В гостях'],
                'headerOptions' => ['class' => 'col-1 hidden-xs', 'title' => 'Дома/В гостях'],
                'value' => function (Game $model) {
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
                'headerOptions' => [
                    'class' => 'col-5 hidden-xs',
                    'title' => 'Соотношение сил (чем больше это число, тем сильнее соперник)'
                ],
                'label' => 'С/С',
                'value' => function (Game $model) {
                    return HockeyHelper::gamePowerPercent($model, Yii::$app->request->get('id'));
                }
            ],
            [
                'footer' => 'Соперник',
                'format' => 'raw',
                'label' => 'Соперник',
                'value' => function (Game $model) {
                    return HockeyHelper::opponentLink($model, Yii::$app->request->get('id'));
                }
            ],
            [
                'contentOptions' => ['class' => 'hidden-xs text-center'],
                'footer' => 'А',
                'footerOptions' => ['class' => 'hidden-xs', 'title' => 'Автосостав'],
                'headerOptions' => ['class' => 'col-1 hidden-xs', 'title' => 'Автосостав'],
                'label' => 'А',
                'value' => function (Game $model) {
                    return HockeyHelper::gameAuto($model, Yii::$app->request->get('id'));
                }
            ],
            [
                'contentOptions' => ['class' => 'text-center'],
                'footer' => 'Счёт',
                'format' => 'raw',
                'label' => 'Счёт',
                'value' => function (Game $model) {
                    return Html::a(
                        HockeyHelper::formatTeamScore($model, Yii::$app->request->get('id')),
                        ['game/view', 'id' => $model->game_id]
                    );
                }
            ],
            [
                'contentOptions' => ['class' => 'hidden-xs text-center'],
                'footer' => HockeyHelper::plusNecessary($totalPoint),
                'footerOptions' => ['class' => 'hidden-xs', 'title' => 'Количество набранных/потерянных баллов'],
                'headerOptions' => ['class' => 'col-1 hidden-xs', 'title' => 'Количество набранных/потерянных баллов'],
                'value' => function (Game $model) {
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
        <?= $this->render('//national/_national-links'); ?>
    </div>
</div>
<?= $this->render('//site/_show-full-table'); ?>
