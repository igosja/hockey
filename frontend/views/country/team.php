<?php

use common\components\ErrorHelper;
use common\models\Team;
use yii\grid\GridView;
use yii\helpers\Html;

/**
 * @var \yii\data\ActiveDataProvider $dataProvider
 * @var \yii\web\View $this
 */

print $this->render('_country');

?>
<div class="row margin-top">
    <?php

    try {
        $columns = [
            [
                'attribute' => 'team',
                'footer' => 'Team',
                'format' => 'raw',
                'value' => function (Team $model) {
                    return Html::a(
                        $model->team_name . ' ' . Html::tag(
                            'span',
                            '(' . $model->stadium->city->city_name . ')',
                            ['class' => 'hidden-xs']
                        ),
                        ['team/view', 'id' => $model->team_id]
                    );
                }
            ],
            [
                'attribute' => 'manager',
                'contentOptions' => ['class' => 'text-center'],
                'footer' => 'Manager',
                'format' => 'raw',
                'headerOptions' => ['class' => 'col-40'],
                'value' => function (Team $model) {
                    return $model->manager->iconVip() . $model->manager->userLink();
                }
            ],
            [
                'attribute' => 'last_visit',
                'contentOptions' => ['class' => 'hidden-xs text-center'],
                'footer' => 'Last Visit',
                'headerOptions' => ['class' => 'col-20 hidden-xs'],
                'value' => function (Team $model) {
                    return $model->manager->lastVisit();
                }
            ],
        ];
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