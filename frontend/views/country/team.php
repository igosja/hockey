<?php

use common\components\ErrorHelper;
use common\models\Team;
use yii\grid\GridView;

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
                'footer' => 'Менеджер',
                'format' => 'raw',
                'headerOptions' => ['class' => 'col-40'],
                'label' => 'Менеджер',
                'value' => function (Team $model) {
                    return $model->manager->iconVip() . $model->manager->userLink();
                }
            ],
            [
                'attribute' => 'last_visit',
                'contentOptions' => ['class' => 'hidden-xs text-center'],
                'footer' => 'Последний визит',
                'format' => 'raw',
                'headerOptions' => ['class' => 'col-20 hidden-xs'],
                'label' => 'Последний визит',
                'value' => function (Team $model) {
                    return $model->manager->lastVisit();
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