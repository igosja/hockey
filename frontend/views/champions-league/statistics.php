<?php

use common\components\ErrorHelper;
use common\models\StatisticPlayer;
use common\models\StatisticTeam;
use yii\grid\GridView;
use yii\grid\SerialColumn;
use yii\helpers\Html;

/**
 * @var \common\models\Country $country
 * @var \yii\data\ActiveDataProvider $dataProvider
 * @var array $divisionArray
 * @var int $divisionId
 * @var array $roundArray
 * @var int $roundId
 * @var int $seasonId
 * @var \common\models\StatisticType $statisticType
 * @var array $statisticTypeArray
 */

?>
<div class="row">
    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
        <h1>
            Лига Чемпионов
        </h1>
    </div>
</div>
<?= Html::beginForm(['champions-league/statistics'], 'get'); ?>
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
                return $model->team->teamLink('img');
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
                return $model->team->teamLink('img');
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
                    'champions-league/index',
                    'seasonId' => $seasonId,
                ],
                ['class' => 'btn margin']
            ); ?>
        </p>
    </div>
</div>