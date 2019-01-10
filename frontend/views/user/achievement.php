<?php

use common\components\ErrorHelper;
use common\models\Achievement;
use yii\grid\GridView;

/**
 * @var \yii\data\ActiveDataProvider $dataProvider
 */

print $this->render('_top');

?>
<div class="row margin-top">
    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
        <?= $this->render('_user-links'); ?>
    </div>
</div>
<div class="row">
    <?php

    try {
        $columns = [
            [
                'contentOptions' => ['class' => 'text-center'],
                'footer' => 'С',
                'footerOptions' => ['title' => 'Сезон'],
                'header' => 'С',
                'headerOptions' => ['class' => 'col-5', 'title' => 'Сезон'],
                'value' => function (Achievement $model) {
                    return $model->achievement_season_id;
                }
            ],
            [
                'footer' => 'Команда',
                'header' => 'Команда',
                'value' => function (Achievement $model) {
                    return $model->team->teamLink('img');
                }
            ],
            [
                'footer' => 'Турнир',
                'header' => 'Турнир',
                'value' => function (Achievement $model) {
                    return $model->getTournament();
                }
            ],
            [
                'contentOptions' => ['class' => 'text-center'],
                'footer' => 'Позиция',
                'header' => 'Позиция',
                'headerOptions' => ['class' => 'col-10'],
                'value' => function (Achievement $model) {
                    return $model->getPosition();
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
        <?= $this->render('_user-links'); ?>
    </div>
</div>
<?= $this->render('//site/_show-full-table'); ?>
