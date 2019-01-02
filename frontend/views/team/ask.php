<?php

use common\components\ErrorHelper;
use common\components\FormatHelper;
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
                    <th>Vs</th>
                </tr>
                <?php foreach ($teamAskArray as $item) : ?>
                    <tr>
                        <td class="text-center">
                            <?= Html::a(
                                '<i class="fa fa-times-circle"></i>',
                                ['team/ask', 'delete' => $item->team_ask_id],
                                ['title' => 'Удалить заявку']
                            ); ?>
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
                    <th>Ваши заявки</th>
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
                'footer' => 'Команда',
                'format' => 'raw',
                'label' => 'Команда',
                'value' => function (Team $model) {
                    return $model->teamLink('string', true);
                }
            ],
            [
                'attribute' => 'country',
                'contentOptions' => ['class' => 'hidden-xs'],
                'footer' => 'Страна',
                'footerOptions' => ['class' => 'hidden-xs'],
                'format' => 'raw',
                'headerOptions' => ['class' => 'hidden-xs'],
                'label' => 'Страна',
                'value' => function (Team $model) {
                    return $model->stadium->city->country->countryLink();
                }
            ],
            [
                'attribute' => 'base',
                'contentOptions' => ['class' => 'hidden-xs text-center'],
                'footer' => 'База',
                'footerOptions' => ['class' => 'hidden-xs'],
                'headerOptions' => ['class' => 'hidden-xs'],
                'label' => 'База',
                'value' => function (Team $model) {
                    return $model->baseUsed() . ' из ' . $model->base->base_slot_max;
                }
            ],
            [
                'attribute' => 'stadium',
                'contentOptions' => ['class' => 'hidden-xs text-center'],
                'footer' => 'Стадион',
                'footerOptions' => ['class' => 'hidden-xs'],
                'headerOptions' => ['class' => 'hidden-xs'],
                'label' => 'Стадион',
                'value' => function (Team $model) {
                    return Yii::$app->formatter->asInteger($model->stadium->stadium_capacity);
                }
            ],
            [
                'attribute' => 'finance',
                'contentOptions' => ['class' => 'hidden-xs text-center'],
                'footer' => 'Финансы',
                'footerOptions' => ['class' => 'hidden-xs'],
                'headerOptions' => ['class' => 'hidden-xs'],
                'label' => 'Финансы',
                'value' => function (Team $model) {
                    return FormatHelper::asCurrency($model->team_finance);
                }
            ],
            [
                'attribute' => 'vs',
                'contentOptions' => ['class' => 'hidden-xs text-center'],
                'footer' => 'Vs',
                'footerOptions' => ['class' => 'hidden-xs'],
                'headerOptions' => [
                    'class' => 'hidden-xs',
                    'title' => 'Рейтинг силы команды в длительных соревнованиях'
                ],
                'label' => 'Vs',
                'value' => function (Team $model) {
                    return $model->team_power_vs;
                }
            ],
            [
                'contentOptions' => ['class' => 'hidden-xs text-center'],
                'footer' => 'ЧЗ',
                'footerOptions' => ['class' => 'hidden-xs'],
                'headerOptions' => [
                    'class' => 'hidden-xs',
                    'title' => 'Число заявок'
                ],
                'label' => 'ЧЗ',
                'value' => function (Team $model) {
                    return count($model->teamAsk);
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
<?= $this->render('//site/_show-full-table'); ?>
