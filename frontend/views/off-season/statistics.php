<?php

use common\components\ErrorHelper;
use common\models\StatisticPlayer;
use common\models\StatisticTeam;
use common\models\StatisticType;
use yii\grid\GridView;
use yii\grid\SerialColumn;
use yii\helpers\Html;

/**
 * @var int $count
 * @var \yii\data\ActiveDataProvider $dataProvider
 * @var int $seasonId
 * @var string $select
 * @var array $statisticTypeArray
 */

?>
<div class="row">
    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
        <h1>
            Кубок межсезонья
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
            $statisticTypeArray,
            ['class' => 'form-control submit-on-change', 'id' => 'statisticType']
        ); ?>
    </div>
    <div class="col-lg-5 col-md-5 col-sm-5 col-xs-4"></div>
</div>
<?php

if (in_array(Yii::$app->request->get('id'), [
    StatisticType::TEAM_NO_PASS,
    StatisticType::TEAM_NO_SCORE,
    StatisticType::TEAM_LOOSE,
    StatisticType::TEAM_LOOSE_BULLET,
    StatisticType::TEAM_LOOSE_OVER,
    StatisticType::TEAM_PASS,
    StatisticType::TEAM_SCORE,
    StatisticType::TEAM_PENALTY,
    StatisticType::TEAM_PENALTY_OPPONENT,
    StatisticType::TEAM_WIN,
    StatisticType::TEAM_WIN_BULLET,
    StatisticType::TEAM_WIN_OVER,
    StatisticType::TEAM_WIN_PERCENT,
])) {
    $columns = [
        [
            'class' => SerialColumn::class,
            'contentOptions' => ['class' => 'text-center'],
            'header' => '№',
            'headerOptions' => ['class' => 'col-10'],
            'footer' => '№',
        ],
        [
            'header' => 'Команда',
            'footer' => 'Команда',
            'format' => 'raw',
            'value' => function (StatisticTeam $model) {
                return $model->team->teamLink('img');
            }
        ],
        [
            'contentOptions' => ['class' => 'text-center'],
            'headerOptions' => ['class' => 'col-10'],
            'value' => function (StatisticTeam $model) use ($select) {
                return $model->$select;
            }
        ],
    ];
} else {
    $columns = [
        [
            'class' => SerialColumn::class,
            'contentOptions' => ['class' => 'text-center'],
            'header' => '№',
            'headerOptions' => ['class' => 'col-10'],
            'footer' => '№',
        ],
        [
            'header' => 'Игрок',
            'footer' => 'Игрок',
            'format' => 'raw',
            'value' => function (StatisticPlayer $model) {
                return $model->player->playerLink();
            }
        ],
        [
            'header' => 'Команда',
            'footer' => 'Команда',
            'format' => 'raw',
            'value' => function (StatisticPlayer $model) {
                return $model->team->teamLink('img');
            }
        ],
        [
            'contentOptions' => ['class' => 'text-center'],
            'value' => function (StatisticTeam $model) use ($select) {
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
            'showFooter' => true,
            'showOnEmpty' => false,
        ]);
    } catch (Exception $e) {
        ErrorHelper::log($e);
    }

    ?>
</div>
<?= $this->render('/site/_show-full-table'); ?>
