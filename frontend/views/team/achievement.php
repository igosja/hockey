<?php

use common\components\ErrorHelper;
use common\models\Achievement;
use yii\grid\GridView;

/**
 * @var \yii\data\ActiveDataProvider $dataProvider
 * @var \yii\web\View $this
 */

print $this->render('_team-top');

?>
<div class="row margin-top-small">
    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
        <?= $this->render('_team-links'); ?>
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
                'value' => function (Achievement $model): string {
                    return $model->achievement_season_id;
                }
            ],
            [
                'footer' => 'Турнир',
                'header' => 'Турнир',
                'value' => function (Achievement $model): string {
                    return $model->getTournament();
                }
            ],
            [
                'contentOptions' => ['class' => 'text-center'],
                'footer' => 'Позиция',
                'header' => 'Позиция',
                'headerOptions' => ['class' => 'col-10'],
                'value' => function (Achievement $model): string {
                    return $model->getPosition();
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
<div class="row">
    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
        <?= $this->render('_team-links'); ?>
    </div>
</div>
<?= $this->render('/site/_show-full-table'); ?>
