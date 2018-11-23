<?php

use common\components\ErrorHelper;
use common\models\Country;
use common\models\National;
use common\models\Team;
use yii\grid\GridView;
use yii\helpers\Html;

/**
 * @var \yii\data\ActiveDataProvider $countryDataProvider
 * @var \yii\data\ActiveDataProvider $nationalDataProvider
 * @var \yii\data\ActiveDataProvider $teamDataProvider
 */

print $this->render('_top');

?>
<div class="row">
    <?php

    try {
        $columns = [
            [
                'footer' => 'Роль в игре',
                'label' => 'Роль в игре',
                'value' => function (Country $model): string {
                    $result = $model->country_name . ' ';
                    if (Yii::$app->user->id == $model->country_president_id) {
                        $result = $result . '(Президент федерации)';
                    } else {
                        $result = $result . '(Заместитель президента федерации)';
                    }
                    return $result;
                }
            ],
        ];
        print GridView::widget([
            'columns' => $columns,
            'dataProvider' => $countryDataProvider,
            'emptyText' => false,
            'showFooter' => true,
            'showOnEmpty' => false,
            'summary' => false,
        ]);
    } catch (Exception $e) {
        ErrorHelper::log($e);
    }

    ?>
</div>
<div class="row">
    <?php

    try {
        $columns = [
            [
                'footer' => 'Команда',
                'format' => 'raw',
                'label' => 'Команда',
                'value' => function (National $model): string {
                    $name = $model->country->country_name . ', ' . $model->nationalType->national_type_name;
                    if (Yii::$app->user->id == $model->national_vice_id) {
                        $name = $name . ' (заместитель)';
                    }
                    return Html::a(
                        $name,
                        ['national/view', 'id' => $model->national_id]
                    );
                }
            ],
            [
                'contentOptions' => ['class' => 'hidden-xs text-center'],
                'footer' => 'Дивизион',
                'footerOptions' => ['class' => 'hidden-xs'],
                'format' => 'raw',
                'headerOptions' => ['class' => 'col-20 hidden-xs'],
                'label' => 'Дивизион',
                'value' => function (National $model): string {
                    return $model->worldCup->division->division_name;
                }
            ],
            [
                'contentOptions' => ['class' => 'text-center'],
                'footer' => 'Vs',
                'footerOptions' => ['title' => 'Рейтинг силы команды в длительных соревнованиях'],
                'headerOptions' => ['class' => 'col-10', 'title' => 'Рейтинг силы команды в длительных соревнованиях'],
                'label' => 'Vs',
                'value' => function (National $model): string {
                    return $model->national_power_vs;
                }
            ],
        ];
        print GridView::widget([
            'columns' => $columns,
            'dataProvider' => $nationalDataProvider,
            'emptyText' => false,
            'showFooter' => true,
            'showOnEmpty' => false,
            'summary' => false,
        ]);
    } catch (Exception $e) {
        ErrorHelper::log($e);
    }

    ?>
</div>
<div class="row">
    <?php

    try {
        $columns = [
            [
                'footer' => 'Команда',
                'format' => 'raw',
                'label' => 'Команда',
                'value' => function (Team $model): string {
                    return $model->teamLink('img');
                }
            ],
            [
                'contentOptions' => ['class' => 'hidden-xs text-center'],
                'footer' => 'Дивизион',
                'footerOptions' => ['class' => 'hidden-xs'],
                'format' => 'raw',
                'headerOptions' => ['class' => 'col-20 hidden-xs'],
                'label' => 'Дивизион',
                'value' => function (Team $model): string {
                    return $model->division();
                }
            ],
            [
                'contentOptions' => ['class' => 'text-center'],
                'footer' => 'Vs',
                'footerOptions' => ['title' => 'Рейтинг силы команды в длительных соревнованиях'],
                'headerOptions' => ['class' => 'col-10', 'title' => 'Рейтинг силы команды в длительных соревнованиях'],
                'label' => 'Vs',
                'value' => function (Team $model): string {
                    return $model->team_power_vs;
                }
            ],
            [
                'contentOptions' => ['class' => 'hidden-xs text-right'],
                'footer' => 'Стоимость',
                'footerOptions' => ['class' => 'hidden-xs'],
                'headerOptions' => ['class' => 'col-20 hidden-xs'],
                'label' => 'Стоимость',
                'value' => function (Team $model): string {
                    return Yii::$app->formatter->asCurrency($model->team_price_total, 'USD');
                }
            ],
        ];
        print GridView::widget([
            'columns' => $columns,
            'dataProvider' => $teamDataProvider,
            'emptyText' => false,
            'showFooter' => true,
            'showOnEmpty' => false,
            'summary' => false,
        ]);
    } catch (Exception $e) {
        ErrorHelper::log($e);
    }

    ?>
</div>
