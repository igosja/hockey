<?php

use common\components\ErrorHelper;
use common\models\StatisticPlayer;
use common\models\StatisticTeam;
use yii\grid\GridView;
use yii\grid\SerialColumn;
use yii\helpers\Html;

/**
 * @var \yii\data\ActiveDataProvider $dataProvider
 * @var array $divisionArray
 * @var int $divisionId
 * @var \common\models\Team $myTeam
 * @var int $seasonId
 * @var \common\models\StatisticType $statisticType
 * @var array $statisticTypeArray
 */

?>
<div class="row">
    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
        <h1>
            Чемпионат мира среди сборных
        </h1>
    </div>
</div>
<div class="row">
    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 text-center">
        <?= $this->render('//world-championship/_division-links', ['divisionArray' => $divisionArray]); ?>
    </div>
</div>
<?= Html::beginForm(['world-championship/statistics'], 'get'); ?>
<?= Html::hiddenInput('seasonId', $seasonId); ?>
<?= Html::hiddenInput('divisionId', $divisionId); ?>
<div class="row">
    <div class="col-lg-4 col-md-4 col-sm-4 col-xs-4 text-right">
        <?= Html::label('Статистика', 'statisticType'); ?>
    </div>
    <div class="col-lg-5 col-md-5 col-sm-6 col-xs-8">
        <?= Html::dropDownList(
            'id',
            Yii::$app->request->get('id'),
            $statisticTypeArray,
            ['class' => 'form-control submit-on-change', 'id' => 'statisticType']
        ); ?>
    </div>
    <div class="col-lg-5 col-md-5 col-sm-5 col-xs-4"></div>
</div>
<?php

if ($statisticType->isTeamChapter()) {
    $columns = [
        [
            'class' => SerialColumn::class,
            'contentOptions' => ['class' => 'text-center'],
            'footer' => '№',
            'header' => '№',
            'headerOptions' => ['class' => 'col-10'],
        ],
        [
            'footer' => 'Команда',
            'format' => 'raw',
            'label' => 'Команда',
            'value' => function (StatisticTeam $model) {
                return $model->national->nationalLink(true);
            }
        ],
        [
            'contentOptions' => ['class' => 'text-center'],
            'headerOptions' => ['class' => 'col-10'],
            'value' => function (StatisticTeam $model) use ($statisticType) {
                $select = $statisticType->statistic_type_select;
                return $model->$select;
            }
        ],
    ];
} else {
    $columns = [
        [
            'class' => SerialColumn::class,
            'contentOptions' => ['class' => 'text-center'],
            'footer' => '№',
            'header' => '№',
            'headerOptions' => ['class' => 'col-10'],
        ],
        [
            'footer' => 'Игрок',
            'format' => 'raw',
            'label' => 'Игрок',
            'value' => function (StatisticPlayer $model) {
                return $model->player->playerLink();
            }
        ],
        [
            'footer' => 'Команда',
            'format' => 'raw',
            'label' => 'Команда',
            'value' => function (StatisticPlayer $model) {
                return $model->national->nationalLink(true);
            }
        ],
        [
            'contentOptions' => ['class' => 'text-center'],
            'value' => function (StatisticPlayer $model) use ($statisticType) {
                $select = $statisticType->statistic_type_select;
                return $model->$select;
            }
        ],
    ];
}

?>
<div class="row">
    <?php

    try {
        print GridView::widget([
            'columns' => $columns,
            'dataProvider' => $dataProvider,
            'rowOptions' => function ($model) use ($myTeam, $statisticType): array {
                if (!$myTeam) {
                    return [];
                }
                $class = '';
                if ($statisticType->isTeamChapter() && $model->statistic_team_team_id == $myTeam->team_id) {
                    $class = 'info';
                } elseif (!$statisticType->isTeamChapter() && $model->statistic_player_team_id == $myTeam->team_id) {
                    $class = 'info';
                }
                return ['class' => $class];
            },
            'showFooter' => true,
        ]);
    } catch (Exception $e) {
        ErrorHelper::log($e);
    }

    ?>
</div>
<?= $this->render('//site/_show-full-table'); ?>
<div class="row">
    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 text-center">
        <p>
            <?= Html::a(
                'Турнирная таблица',
                [
                    'world-championship/index',
                    'divisionId' => $divisionId,
                    'seasonId' => $seasonId,
                ],
                ['class' => 'btn margin']
            ); ?>
        </p>
    </div>
</div>
