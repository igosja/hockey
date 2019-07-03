<?php

use common\components\ErrorHelper;
use common\models\Team;
use yii\data\ActiveDataProvider;
use yii\grid\GridView;
use yii\helpers\Html;
use yii\web\View;

/**
 * @var ActiveDataProvider $dataProvider
 * @var View $this
 */

print $this->render('_country');

?>
<div class="row margin-top">
    <?php

    try {
        $columns = [
            [
                'attribute' => 'team',
                'footer' => 'Команда',
                'format' => 'raw',
                'label' => 'Команда',
                'value' => function (Team $model) {
                    return $model->teamLink('string', true);
                }
            ],
            [
                'attribute' => 'manager',
                'contentOptions' => ['class' => 'text-center'],
                'footer' => 'Рекомендация',
                'format' => 'raw',
                'headerOptions' => ['class' => 'col-40'],
                'label' => 'Рекомендация',
                'value' => function (Team $model) {
                    return $model->recommendation ? $model->recommendation->user->userLink() : '-';
                }
            ],
            [
                'contentOptions' => ['class' => 'text-center'],
                'footer' => '',
                'format' => 'raw',
                'headerOptions' => ['class' => 'col-1'],
                'label' => '',
                'value' => function (Team $model) {
                    if ($model->recommendation) {
                        $result = Html::a(
                            '<i class="fa fa-minus-circle"></i>',
                            ['country/recommendation-delete', 'id' => $model->stadium->city->city_country_id, 'teamId' => $model->team_id],
                            ['title' => 'Удалить рекомендацию']
                        );
                    } else {
                        $result = Html::a(
                            '<i class="fa fa-plus-circle"></i>',
                            ['country/recommendation-create', 'id' => $model->stadium->city->city_country_id, 'teamId' => $model->team_id],
                            ['title' => 'Добавить рекомендацию']
                        );
                    }

                    return $result;
                }
            ],
        ];
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

