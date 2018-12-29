<?php

use common\components\ErrorHelper;
use common\models\Stadium;
use yii\helpers\Html;
use yii\widgets\DetailView;

/**
 * @var Stadium $model
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
        <?= Html::a('Список', ['stadium/index'], ['class' => 'btn btn-default']); ?>
    </li>
    <li>
        <?= Html::a('Изменить', ['stadium/update', 'id' => $model->stadium_id], ['class' => 'btn btn-default']); ?>
    </li>
</ul>
<div class="row">
    <?php

    try {
        $attributes = [
            [
                'captionOptions' => ['class' => 'col-lg-6'],
                'label' => 'ID',
                'value' => function (Stadium $model) {
                    return $model->stadium_id;
                },
            ],
            [
                'label' => 'Название',
                'value' => function (Stadium $model) {
                    return $model->stadium_name;
                },
            ],
            [
                'format' => 'raw',
                'label' => 'Город',
                'value' => function (Stadium $model) {
                    return Html::a(
                        $model->city->city_name,
                        ['city/view', 'id' => $model->city->city_id]
                    );
                },
            ],
            [
                'format' => 'raw',
                'label' => 'Страна',
                'value' => function (Stadium $model) {
                    return Html::a(
                        $model->city->country->country_name,
                        ['country/view', 'id' => $model->city->country->country_id]
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
