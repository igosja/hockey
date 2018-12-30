<?php

use common\components\ErrorHelper;
use common\models\Squad;
use yii\helpers\Html;
use yii\widgets\DetailView;

/**
 * @var Squad $model
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
        <?= Html::a('Список', ['squad/index'], ['class' => 'btn btn-default']); ?>
    </li>
    <li>
        <?= Html::a('Изменить', ['squad/update', 'id' => $model->squad_id], ['class' => 'btn btn-default']); ?>
    </li>
</ul>
<div class="row">
    <?php

    try {
        $attributes = [
            [
                'captionOptions' => ['class' => 'col-lg-6'],
                'label' => 'ID',
                'value' => function (Squad $model) {
                    return $model->squad_id;
                },
            ],
            [
                'label' => 'Название',
                'value' => function (Squad $model) {
                    return $model->squad_name;
                },
            ],
            [
                'label' => 'Цвет',
                'value' => function (Squad $model) {
                    return $model->squad_color;
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
