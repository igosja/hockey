<?php

use common\components\ErrorHelper;
use common\models\City;
use yii\helpers\Html;
use yii\widgets\DetailView;

/**
 * @var City $model
 * @var \yii\web\View $this
 */

?>
<div class="row">
    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 text-center">
        <h3 class="page-header"><?= Html::encode($this->title); ?></h3>
    </div>
</div>
<ul class="list-inline preview-links text-center">
    <li>
        <?= Html::a('Список', ['city/index'], ['class' => 'btn btn-default']); ?>
    </li>
    <li>
        <?= Html::a('Изменить', ['city/update', 'id' => $model->city_id], ['class' => 'btn btn-default']); ?>
    </li>
</ul>
<div class="row">
    <?php

    try {
        $attributes = [
            [
                'captionOptions' => ['class' => 'col-lg-6'],
                'label' => 'ID',
                'value' => function (City $model) {
                    return $model->city_id;
                },
            ],
            [
                'label' => 'Название',
                'value' => function (City $model) {
                    return $model->city_name;
                },
            ],
            [
                'format' => 'raw',
                'label' => 'Количество стадионов',
                'value' => function (City $model) {
                    return Html::a(
                        count($model->stadium),
                        ['stadium/index', 'StadiumSearch' => ['stadium_city_id' => $model->city_id]]
                    );
                },
            ],
            [
                'format' => 'raw',
                'label' => 'Страна',
                'value' => function (City $model) {
                    return Html::a(
                        $model->country->country_name,
                        ['country/view', 'id' => $model->country->country_id]
                    );
                },
            ],
        ];
        print DetailView::widget([
            'attributes' => $attributes,
            'model' => $model,
        ]);
    } catch (Exception $e) {
        ErrorHelper::log($e);
    }

    ?>
</div>
