<?php

use common\components\ErrorHelper;
use common\models\RatingTeam;
use common\models\RatingType;
use yii\grid\GridView;
use yii\helpers\Html;

/**
 * @var \yii\data\ActiveDataProvider $dataProvider
 * @var RatingType $ratingType
 * @var array $ratingTypeArray
 */

?>
<div class="row">
    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
        <h1>
            Рейтинги
        </h1>
    </div>
</div>
<?= Html::beginForm(['rating/index'], 'get'); ?>
<div class="row">
    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
        <?= Html::label('Рейтинг', 'ratingTypeId'); ?>
        <?= Html::dropDownList(
            'id',
            Yii::$app->request->get('id', RatingType::TEAM_POWER),
            $ratingTypeArray,
            ['class' => 'form-control submit-on-change', 'id' => 'ratingTypeId']
        ); ?>
    </div>
</div>
<?= Html::endForm(); ?>
<div class="row">
    <?php

    try {
        $columns = [
            [
                'contentOptions' => ['class' => 'text-center'],
                'footer' => '№',
                'footerOptions' => ['title' => 'Место'],
                'headerOptions' => ['title' => 'Место'],
                'label' => '№',
                'value' => function (RatingTeam $model) use ($ratingType): string {
                    $attribute = $ratingType->rating_type_order;
                    return $model->$attribute;
                }
            ],
            [
                'footer' => 'Команда',
                'format' => 'raw',
                'label' => 'Команда',
                'value' => function (RatingTeam $model): string {
                    return $model->team->teamLink('img');
                }
            ],
            [
                'contentOptions' => ['class' => 'text-center'],
                'footer' => 's21',
                'label' => 's21',
                'headerOptions' => ['title' => 'Сумма сил 21 лучшего игрока'],
                'footerOptions' => ['title' => 'Сумма сил 21 лучшего игрока'],
                'value' => function (RatingTeam $model): string {
                    return $model->team->team_power_s_21;
                }
            ],
            [
                'contentOptions' => ['class' => 'text-center'],
                'footer' => 's26',
                'label' => 's26',
                'headerOptions' => ['title' => 'Сумма сил 26 лучших игроков'],
                'footerOptions' => ['title' => 'Сумма сил 26 лучших игроков'],
                'value' => function (RatingTeam $model): string {
                    return $model->team->team_power_s_26;
                }
            ],
            [
                'contentOptions' => ['class' => 'text-center'],
                'footer' => 's32',
                'label' => 's32',
                'headerOptions' => ['title' => 'Сумма сил 32 лучших игроков'],
                'footerOptions' => ['title' => 'Сумма сил 32 лучших игроков'],
                'value' => function (RatingTeam $model): string {
                    return $model->team->team_power_s_32;
                }
            ],
        ];
        print GridView::widget([
            'columns' => $columns,
            'dataProvider' => $dataProvider,
            'showFooter' => true,
            'showOnEmpty' => false,
            'summary' => false,
        ]);
    } catch (Exception $e) {
        ErrorHelper::log($e);
    }

    ?>
</div>