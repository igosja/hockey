<?php

use common\components\ErrorHelper;
use common\models\Player;
use yii\grid\GridView;
use yii\helpers\Html;

/**
 * @var \common\models\Lineup $lineup
 * @var \yii\data\ActiveDataProvider $dataProvider
 * @var \yii\web\View $this
 */

?>
<div class="row margin-top">
    Заменяемый игрок
    <?php if ($lineup) : ?>
        <?= Html::a(
            $lineup->player->playerName(),
            ['player/view', 'id' => $lineup->player->player_id],
            ['target' => '_blank', 'data-pjax' => 0]
        ); ?>
    <?php endif; ?>
</div>
<div class="row margin-top">
    <?php

    try {
        $columns = [
            [
                'attribute' => 'Change',
                'contentOptions' => ['class' => 'text-center'],
                'format' => 'raw',
                'value' => function (Player $model) {
                    return Html::a(
                        'Change',
                        [
                            'lineup/change',
                            'id' => Yii::$app->request->get('id'),
                            'player_id' => $model->player_id,
                            'position_id' => Yii::$app->request->get('position_id'),
                            'line_id' => Yii::$app->request->get('line_id'),
                        ]
                    );
                }
            ],
            [
                'attribute' => 'player',
                'contentOptions' => ['class' => 'text-center'],
                'format' => 'raw',
                'value' => function (Player $model) {
                    return Html::a(
                        $model->playerName(),
                        ['player/view', 'id' => $model->player_id],
                        ['data-pjax' => 0, 'target' => '_blank']
                    );
                }
            ],
        ];
        print GridView::widget([
            'columns' => $columns,
            'dataProvider' => $dataProvider,
            'showOnEmpty' => false,
            'summary' => false,
        ]);
    } catch (Exception $e) {
        ErrorHelper::log($e);
    }

    ?>
</div>
<div class="row hidden-lg hidden-md hidden-sm">
    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
        <a class="btn show-full-table" href="javascript:">
            Show full table
        </a>
    </div>
</div>