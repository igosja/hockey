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
<?php if ($lineup) : ?>
    <div class="row margin-top">
        Заменяемый игрок
        <?= Html::a(
            $lineup->player->playerName(),
            ['player/view', 'id' => $lineup->player->player_id],
            ['target' => '_blank']
        ); ?>
    </div>
<?php endif; ?>
<div class="row margin-top">
    <?php

    try {
        $columns = [
            [
                'contentOptions' => ['class' => 'text-center'],
                'format' => 'raw',
                'headerOptions' => ['class' => 'col-5'],
                'value' => function (Player $model) {
                    return Html::a(
                        '<i class="fa fa-exchange" aria-hidden="true"></i>',
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
                'format' => 'raw',
                'header' => 'Игрок',
                'value' => function (Player $model) {
                    return Html::a(
                        $model->playerName(),
                        ['player/view', 'id' => $model->player_id],
                        ['target' => '_blank']
                    );
                }
            ],
            [
                'contentOptions' => ['class' => 'text-center'],
                'header' => 'Поз',
                'headerOptions' => ['class' => 'col-5', 'title' => 'Позиция'],
                'value' => function (Player $model) {
                    return $model->position();
                }
            ],
            [
                'contentOptions' => ['class' => 'text-center'],
                'header' => 'В',
                'headerOptions' => ['class' => 'col-5', 'title' => 'Возраст'],
                'value' => function (Player $model) {
                    return $model->player_age;
                }
            ],
            [
                'contentOptions' => ['class' => 'text-center'],
                'header' => 'С',
                'headerOptions' => ['class' => 'col-5', 'title' => 'Сила'],
                'value' => function (Player $model) {
                    return $model->player_power_nominal;
                }
            ],
            [
                'contentOptions' => ['class' => 'text-center'],
                'header' => 'У',
                'headerOptions' => ['class' => 'col-5', 'title' => 'Усталость'],
                'value' => function (Player $model) {
                    return $model->player_tire;
                }
            ],
            [
                'contentOptions' => ['class' => 'text-center'],
                'format' => 'raw',
                'header' => 'Ф',
                'headerOptions' => ['class' => 'col-5', 'title' => 'Форма'],
                'value' => function (Player $model) {
                    return Html::img(
                        '/img/physical/' . $model->player_physical_id . '.png',
                        [
                            'alt' => $model->physical->physical_name,
                            'title' => $model->physical->physical_name,
                        ]
                    );
                }
            ],
            [
                'contentOptions' => ['class' => 'text-center'],
                'header' => 'Спец',
                'headerOptions' => ['class' => 'col-10', 'title' => 'Спецвозможности'],
                'value' => function (Player $model) {
                    return $model->special();
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