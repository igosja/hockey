<?php

use common\components\ErrorHelper;
use common\models\History;
use yii\grid\GridView;

/**
 * @var \yii\data\ActiveDataProvider $dataProvider
 * @var \yii\web\View $this
 */

print $this->render('_player');

?>
    <div class="row margin-top-small">
        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
            <?= $this->render('_links'); ?>
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
                    'headerOptions' => ['class' => 'col-1', 'title' => 'Сезон'],
                    'value' => function (History $model): string {
                        return $model->history_season_id;
                    }
                ],
                [
                    'contentOptions' => ['class' => 'text-center'],
                    'footer' => 'Дата',
                    'header' => 'Дата',
                    'headerOptions' => ['class' => 'col-15'],
                    'value' => function (History $model): string {
                        return Yii::$app->formatter->asDate($model->history_date, 'short');
                    }
                ],
                [
                    'footer' => 'Событие',
                    'format' => 'raw',
                    'header' => 'Событие',
                    'value' => function (History $model): string {
                        return $model->getText();
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
            <?= $this->render('_links'); ?>
        </div>
    </div>
<?= $this->render('/site/_show-full-table'); ?>