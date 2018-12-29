<?php

use common\components\ErrorHelper;
use common\models\Team;
use yii\helpers\Html;
use yii\widgets\DetailView;

/**
 * @var Team $model
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
        <?= Html::a('Список', ['team/index'], ['class' => 'btn btn-default']); ?>
    </li>
    <li>
        <?= Html::a('Изменить', ['team/update', 'id' => $model->team_id], ['class' => 'btn btn-default']); ?>
    </li>
</ul>
<div class="row">
    <?php

    try {
        $attributes = [
            [
                'captionOptions' => ['class' => 'col-lg-6'],
                'label' => 'ID',
                'value' => function (Team $model) {
                    return $model->team_id;
                },
            ],
            [
                'label' => 'Название',
                'value' => function (Team $model) {
                    return $model->team_name;
                },
            ],
            [
                'format' => 'raw',
                'label' => 'Стадион',
                'value' => function (Team $model) {
                    return Html::a(
                        $model->stadium->stadium_name,
                        ['stadium/view', 'id' => $model->stadium->stadium_id]
                    );
                },
            ],
            [
                'format' => 'raw',
                'label' => 'Город',
                'value' => function (Team $model) {
                    return Html::a(
                        $model->stadium->city->city_name,
                        ['city/view', 'id' => $model->stadium->city->city_id]
                    );
                },
            ],
            [
                'format' => 'raw',
                'label' => 'Страна',
                'value' => function (Team $model) {
                    return Html::a(
                        $model->stadium->city->country->country_name,
                        ['country/view', 'id' => $model->stadium->city->country->country_id]
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
