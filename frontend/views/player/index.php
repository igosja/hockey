<?php

use common\components\ErrorHelper;
use common\models\Player;
use yii\grid\GridView;
use yii\helpers\Html;
use yii\widgets\ActiveForm;

/**
 * @var array $countryArray
 * @var \yii\data\ActiveDataProvider $dataProvider
 * @var array $positionArray
 * @var \yii\web\View $this
 */

?>
    <div class="row">
        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
            <h1>
                Список хоккеистов
            </h1>
        </div>
    </div>
<?php $form = ActiveForm::begin([
    'action' => ['player/index'],
    'fieldConfig' => [
        'template' => '{input}',
    ],
    'method' => 'get',
]); ?>
    <div class="row">
        <div class="col-lg-2 col-md-2 col-sm-2 col-xs-6">
            Условия поиска:
        </div>
        <div class="col-lg-3 col-md-3 col-sm-3 col-xs-6">
            <?= $form->field($model, 'country')->dropDownList($countryArray,
                ['class' => 'form-control', 'prompt' => 'Национальность']); ?>
        </div>
        <div class="col-lg-3 col-md-3 col-sm-3 col-xs-5">
            <?= $form->field($model, 'name')->textInput([
                'class' => 'form-control',
                'placeholder' => 'Имя',
            ]); ?>
        </div>
        <div class="col-lg-4 col-md-4 col-sm-4 col-xs-7">
            <?= $form->field($model, 'surname')->textInput([
                'class' => 'form-control',
                'placeholder' => 'Фамилия',
            ]); ?>
        </div>
        <div class="col-lg-2 col-md-2 col-sm-2 col-xs-4">
            <?= $form->field($model, 'position')->dropDownList(
                $positionArray,
                ['class' => 'form-control', 'prompt' => 'Позиция']
            ); ?>
        </div>
        <div class="col-lg-1 col-md-1 col-sm-1 col-xs-2">
            <?= $form->field($model, 'ageMin')->textInput([
                'class' => 'form-control',
                'placeholder' => 'Возраст, от',
                'type' => 'number',
            ]); ?>
        </div>
        <div class="col-lg-1 col-md-1 col-sm-1 col-xs-2">
            <?= $form->field($model, 'ageMax')->textInput([
                'class' => 'form-control',
                'placeholder' => 'Возраст, до',
                'type' => 'number',
            ]); ?>
        </div>
        <div class="col-lg-1 col-md-1 col-sm-1 col-xs-2">
            <?= $form->field($model, 'powerMin')->textInput([
                'class' => 'form-control',
                'placeholder' => 'Сила, от',
                'type' => 'number',
            ]); ?>
        </div>
        <div class="col-lg-1 col-md-1 col-sm-1 col-xs-2">
            <?= $form->field($model, 'powerMax')->textInput([
                'class' => 'form-control',
                'placeholder' => 'Сила, до',
                'type' => 'number',
            ]); ?>
        </div>
        <div class="col-lg-2 col-md-2 col-sm-2 col-xs-4">
            <?= $form->field($model, 'priceMin')->textInput([
                'class' => 'form-control',
                'placeholder' => 'Цена, от',
                'type' => 'number',
            ]); ?>
        </div>
        <div class="col-lg-2 col-md-2 col-sm-2 col-xs-4">
            <?= $form->field($model, 'priceMax')->textInput([
                'class' => 'form-control',
                'placeholder' => 'Цена, до',
                'type' => 'number',


            ]); ?>
        </div>
        <div class="col-lg-2 col-md-2 col-sm-2 col-xs-4">
            <?= Html::submitButton('Поиск', ['class' => 'form-control submit-blue']); ?>
        </div>
    </div>
<?php ActiveForm::end(); ?>
    <div class="row">

        <div class="row">
            <?php

            try {
                $columns = [
                    [
                        'class' => 'yii\grid\SerialColumn',
                        'contentOptions' => ['class' => 'text-center'],
                        'footer' => '№',
                        'header' => '№',
                    ],
                    [
                        'attribute' => 'surname',
                        'footer' => 'Игрок',
                        'format' => 'raw',
                        'label' => 'Игрок',
                        'value' => function (Player $model): string {
                            return $model->playerLink();
                        }
                    ],
                    [
                        'attribute' => 'country',
                        'contentOptions' => ['class' => 'hidden-xs text-center'],
                        'footer' => 'Нац',
                        'footerOptions' => ['class' => 'hidden-xs', 'title' => 'Национальность'],
                        'format' => 'raw',
                        'headerOptions' => ['class' => 'hidden-xs col-1', 'title' => 'Национальность'],
                        'label' => 'Нац',
                        'value' => function (Player $model): string {
                            return Html::a(
                                Html::img(
                                    '/img/country/12/' . $model->player_country_id . '.png',
                                    [
                                        'alt' => $model->country->country_name,
                                        'title' => $model->country->country_name,
                                    ]
                                ),
                                ['country/news', 'id' => $model->player_country_id]
                            );
                        }
                    ],
                    [
                        'attribute' => 'position',
                        'contentOptions' => ['class' => 'text-center'],
                        'footer' => 'Поз',
                        'footerOptions' => ['title' => 'Позиция'],
                        'headerOptions' => ['title' => 'Позиция'],
                        'label' => 'Поз',
                        'value' => function (Player $model): string {
                            return $model->position();
                        }
                    ],
                    [
                        'attribute' => 'age',
                        'contentOptions' => ['class' => 'text-center'],
                        'footer' => 'В',
                        'footerOptions' => ['title' => 'Возраст'],
                        'headerOptions' => ['title' => 'Возраст'],
                        'label' => 'В',
                        'value' => function (Player $model): string {
                            return $model->player_age;
                        }
                    ],
                    [
                        'attribute' => 'power',
                        'contentOptions' => ['class' => 'text-center'],
                        'footer' => 'С',
                        'footerOptions' => ['title' => 'Сила'],
                        'headerOptions' => ['title' => 'Сила'],
                        'label' => 'С',
                        'value' => function (Player $model): string {
                            return $model->player_power_nominal;
                        }
                    ],
                    [
                        'contentOptions' => ['class' => 'hidden-xs text-center'],
                        'footer' => 'Спец',
                        'footerOptions' => ['class' => 'hidden-xs', 'title' => 'Спецсозможности'],
                        'header' => 'Спец',
                        'headerOptions' => ['class' => 'hidden-xs', 'title' => 'Спецсозможности'],
                        'value' => function (Player $model): string {
                            return $model->special();
                        }
                    ],
                    [
                        'attribute' => 'team',
                        'footer' => 'Команда',
                        'format' => 'raw',
                        'label' => 'Команда',
                        'value' => function (Player $model): string {
                            return $model->team->teamLink('img');
                        }
                    ],
                    [
                        'attribute' => 'price',
                        'contentOptions' => ['class' => 'hidden-xs text-right'],
                        'footer' => 'Цена',
                        'label' => 'Цена',
                        'value' => function (Player $model): string {
                            return Yii::$app->formatter->asCurrency($model->player_price, 'USD');
                        }
                    ],
                ];
                print GridView::widget([
                    'columns' => $columns,
                    'dataProvider' => $dataProvider,
                    'showFooter' => true,
                    'showOnEmpty' => false,
                ]);
            } catch (Exception $e) {
                ErrorHelper::log($e);
            }

            ?>
        </div>
    </div>
<?= $this->render('/site/_show-full-table'); ?>