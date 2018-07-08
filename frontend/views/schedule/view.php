<?php

use common\components\ErrorHelper;
use common\components\HockeyHelper;
use common\models\Game;
use yii\grid\GridView;
use yii\helpers\Html;

/**
 * @var \yii\data\ActiveDataProvider $dataProvider
 * @var \common\models\Schedule $schedule
 */

?>
<div class="row">
    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
        <h1><?= $schedule->tournamentType->tournament_type_name; ?></h1>
    </div>
    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 text-center">
        <p>
            <?= Yii::$app->formatter->asDatetime($schedule->schedule_date); ?>,
            <?= $schedule->stage->stage_name; ?>,
            <?= Yii::t('app', '{n, ordinal} season', ['n' => $schedule->schedule_season_id]); ?>
        </p>
    </div>
</div>
<div class="row">
    <?php

    try {
        $columns = [
            [
                'contentOptions' => ['class' => 'col-47 text-right'],
                'format' => 'raw',
                'value' => function (Game $model) {
                    return HockeyHelper::teamOrNationalLink($model->teamHome, $model->nationalHome);
                }
            ],
            [
                'contentOptions' => ['class' => 'col-6 text-center'],
                'format' => 'raw',
                'value' => function (Game $model) {
                    return Html::a(
                        HockeyHelper::formatScore($model->game_home_score, $model->game_guest_score,
                            $model->game_played),
                        ['game/view', 'id' => $model->game_id]
                    );
                }
            ],
            [
                'contentOptions' => ['class' => 'col-47'],
                'format' => 'raw',
                'value' => function (Game $model) {
                    return HockeyHelper::teamOrNationalLink($model->teamGuest, $model->nationalGuest);
                }
            ],
        ];
        print GridView::widget([
            'columns' => $columns,
            'dataProvider' => $dataProvider,
            'showHeader' => false,
        ]);
    } catch (Exception $e) {
        ErrorHelper::log($e);
    }

    ?>
</div>