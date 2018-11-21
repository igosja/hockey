<?php

use common\components\ErrorHelper;
use common\models\Team;
use yii\grid\GridView;
use yii\helpers\Html;

/**
 * @var \yii\data\ActiveDataProvider $dataProvider
 * @var \common\models\Team $model
 * @var \common\models\TeamAsk[] $teamAskArray
 * @var \yii\web\View $this
 */

?>
<div class="row">
    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 text-center">
        <h1>Получение команды</h1>
    </div>
</div>
<?php if ($teamAskArray) : ?>
    <div class="row">
        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
            <table class="table table-bordered table-hover">
                <tr>
                    <th class="col-1"></th>
                    <th>Ваши заявки</th>
                    <th><?= $model->getAttributeLabel('vs'); ?></th>
                </tr>
                <?php foreach ($teamAskArray as $item) : ?>
                    <tr>
                        <td class="text-center">
                            <?= Html::a(
                                '<i class="fa fa-times-circle"></i>',
                                ['team/ask', 'delete' => $item->team_ask_id],
                                ['title' => 'Удалить заявку']
                            ) ?>
                        </td>
                        <td>
                            <?= $item->team->teamLink('img') ?>
                        </td>
                        <td class="hidden-xs text-center">
                            <?= $item->team->team_power_vs; ?>
                        </td>
                    </tr>
                <?php endforeach; ?>
                <tr>
                    <th></th>
                    <th><?= $model->getAttributeLabel('team'); ?></th>
                    <th><?= $model->getAttributeLabel('vs'); ?></th>
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
                'headerOptions' => ['class' => 'col-1'],
                'value' => function (Team $model) {
                    return Html::a(
                        '<i class="fa fa-check-circle"></i>',
                        ['team/ask', 'id' => $model->team_id],
                        ['title' => 'Выбрать']
                    );
                }
            ],
            [
                'attribute' => 'team',
                'footer' => $model->getAttributeLabel('team'),
                'format' => 'raw',
                'value' => function (Team $model) {
                    return Html::a(
                        $model->team_name . ' (' . $model->stadium->city->city_name . ')',
                        ['team/view', 'id' => $model->team_id]
                    );
                }
            ],
            [
                'attribute' => 'country',
                'contentOptions' => ['class' => 'hidden-xs text-center'],
                'footer' => $model->getAttributeLabel('country'),
                'footerOptions' => ['class' => 'hidden-xs'],
                'format' => 'raw',
                'headerOptions' => ['class' => 'hidden-xs'],
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
                'footer' => $model->getAttributeLabel('base'),
                'footerOptions' => ['class' => 'hidden-xs'],
                'headerOptions' => ['class' => 'hidden-xs'],
                'value' => function (Team $model) {
                    return $model->baseUsed() . ' из ' . $model->base->base_slot_max;
                }
            ],
            [
                'attribute' => 'stadium',
                'contentOptions' => ['class' => 'hidden-xs text-center'],
                'footer' => $model->getAttributeLabel('stadium'),
                'footerOptions' => ['class' => 'hidden-xs'],
                'headerOptions' => ['class' => 'hidden-xs'],
                'value' => function (Team $model) {
                    return $model->stadium->stadium_capacity;
                }
            ],
            [
                'attribute' => 'finance',
                'contentOptions' => ['class' => 'hidden-xs text-center'],
                'footer' => $model->getAttributeLabel('finance'),
                'footerOptions' => ['class' => 'hidden-xs'],
                'headerOptions' => ['class' => 'hidden-xs'],
                'value' => function (Team $model) {
                    return Yii::$app->formatter->asCurrency($model->team_finance, 'USD');
                }
            ],
            [
                'attribute' => 'vs',
                'contentOptions' => ['class' => 'hidden-xs text-center'],
                'footer' => $model->getAttributeLabel('vs'),
                'footerOptions' => ['class' => 'hidden-xs'],
                'headerOptions' => [
                    'class' => 'hidden-xs',
                    'title' => 'Рейтинг силы команды в длительных соревнованиях'
                ],
                'value' => function (Team $model) {
                    return $model->team_power_vs;
                }
            ],
            [
                'label' => $model->getAttributeLabel('number_of_application'),
                'contentOptions' => ['class' => 'hidden-xs text-center'],
                'footer' => $model->getAttributeLabel('number_of_application'),
                'footerOptions' => ['class' => 'hidden-xs'],
                'headerOptions' => [
                    'class' => 'hidden-xs',
                    'title' => 'Число заявок'
                ],
                'value' => function (Team $model) {
                    return count($model->teamAsk);
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
<?= $this->render('/site/_show-full-table'); ?>
