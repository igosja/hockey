<?php

use common\components\ErrorHelper;
use common\components\FormatHelper;
use common\models\History;
use yii\grid\GridView;

/**
 * @var \yii\data\ActiveDataProvider $dataProvider
 * @var \common\models\Player $player
 * @var \yii\web\View $this
 */

print $this->render('//player/_player', ['player' => $player]);

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
                    'headerOptions' => ['class' => 'col-1', 'title' => 'Сезон'],
                    'label' => 'С',
                    'value' => function (History $model): string {
                        return $model->history_season_id;
                    }
                ],
                [
                    'contentOptions' => ['class' => 'text-center'],
                    'footer' => 'Дата',
                    'headerOptions' => ['class' => 'col-15'],
                    'label' => 'Дата',
                    'value' => function (History $model): string {
                        return FormatHelper::asDate($model->history_date);
                    }
                ],
                [
                    'footer' => 'Событие',
                    'format' => 'raw',
                    'label' => 'Событие',
                    'value' => function (History $model): string {
                        return $model->text();
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
            <?= $this->render('_links'); ?>
        </div>
    </div>
<?= $this->render('/site/_show-full-table'); ?>