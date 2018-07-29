<?php

use common\components\ErrorHelper;
use common\models\Team;
use yii\grid\GridView;
use yii\helpers\Html;

/**
 * @var \yii\data\ActiveDataProvider $dataProvider
 * @var \common\models\TeamAsk[] $teamAskArray
 * @var \yii\web\View $this
 */

?>
<div class="row">
    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 text-center">
        <h1>Getting the team</h1>
    </div>
</div>
<?php if ($teamAskArray) : ?>
    <div class="row">
        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
            <table class="table table-bordered table-hover">
                <tr>
                    <th></th>
                    <th>Your requests</th>
                    <th>Vs</th>
                </tr>
                <?php foreach ($teamAskArray as $item) : ?>
                    <tr>
                        <td class="text-center">
                            <?= Html::a(
                                '<i class="fa fa-times-circle"></i>',
                                ['ask', 'delete' => $item->team_ask_id],
                                ['title' => 'Delete request']
                            ) ?>
                        </td>
                        <td>
                            <?= Html::a(
                                $item->team->team_name . ' (' . $item->team->stadium->city->city_name . ', ' . $item->team->stadium->city->country->country_name . ')',
                                ['view', $item->team->team_id]
                            ) ?>
                        </td>
                        <td class="hidden-xs text-center">
                            <?= $item->team->team_power_vs; ?>
                        </td>
                    </tr>
                <?php endforeach; ?>
                <tr>
                    <th></th>
                    <th>Team</th>
                    <th>Vs</th>
                </tr>
            </table>
        </div>
    </div>
<?php endif; ?>
<div class="row">
    <?php

    try {
        $columns = [
            [
                'contentOptions' => ['class' => 'text-center'],
                'format' => 'raw',
                'value' => function (Team $model) {
                    return Html::a(
                        '<i class="fa fa-check-circle"></i>',
                        ['ask', 'id' => $model->team_id],
                        ['title' => 'Choose']
                    );
                }
            ],
            [
                'attribute' => 'team',
                'footer' => 'Team',
                'format' => 'raw',
                'value' => function (Team $model) {
                    return Html::a(
                        $model->team_name . ' (' . $model->stadium->city->city_name . ')',
                        ['view', 'id' => $model->team_id]
                    );
                }
            ],
            [
                'attribute' => 'country',
                'contentOptions' => ['class' => 'hidden-xs text-center'],
                'footer' => 'Country',
                'format' => 'raw',
                'value' => function (Team $model) {
                    return Html::a(
                        Html::img(
                            '/img/country/12/' . $model->stadium->city->country->country_id . '.png',
                            [
                                'alt' => $model->stadium->city->country->country_name,
                                'title' => $model->stadium->city->country->country_name,
                            ]
                        ) . ' <span class="hidden-xs">' . $model->stadium->city->country->country_name . '</span>',
                        ['country/team', 'id' => $model->stadium->city->country->country_id]
                    );
                }
            ],
            [
                'attribute' => 'base',
                'contentOptions' => ['class' => 'hidden-xs text-center'],
                'footer' => 'Base',
                'value' => function (Team $model) {
                    return $model->baseUsed() . ' of ' . $model->base->base_slot_max;
                }
            ],
            [
                'attribute' => 'stadium',
                'contentOptions' => ['class' => 'hidden-xs text-center'],
                'footer' => 'Stadium',
                'value' => function (Team $model) {
                    return $model->stadium->stadium_capacity;
                }
            ],
            [
                'attribute' => 'finance',
                'contentOptions' => ['class' => 'hidden-xs text-center'],
                'footer' => 'Finance',
                'value' => function (Team $model) {
                    return Yii::$app->formatter->asCurrency($model->team_finance, 'USD');
                }
            ],
            [
                'attribute' => 'vs',
                'contentOptions' => ['class' => 'hidden-xs text-center'],
                'footer' => 'Vs',
                'value' => function (Team $model) {
                    return $model->team_power_vs;
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
<div class="row hidden-lg hidden-md hidden-sm">
    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
        <a class="btn show-full-table" href="javascript:">
            Show full table
        </a>
    </div>
</div>