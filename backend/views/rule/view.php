<?php

use common\components\ErrorHelper;
use yii\helpers\Html;
use yii\widgets\DetailView;

/**
 * @var \common\models\Rule $model
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
        <?= Html::a('Список', ['rule/index'], ['class' => 'btn btn-default']); ?>
    </li>
    <li>
        <?= Html::a('Изменить', ['rule/update', 'id' => $model->rule_id], ['class' => 'btn btn-default']); ?>
    </li>
    <li>
        <?= Html::a('Удалить', ['rule/delete', 'id' => $model->rule_id], ['class' => 'btn btn-default']); ?>
    </li>
</ul>
<div class="row">
    <?php

    try {
        $attributes = [
            'rule_id',
            'rule_order',
            'rule_title',
            [
                'attribute' => 'rule_text',
                'format' => 'raw',
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
