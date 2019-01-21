<?php

use common\components\ErrorHelper;
use yii\helpers\Html;
use yii\widgets\DetailView;

/**
 * @var \common\models\BlockReason $model
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
        <?= Html::a('Список', ['block-reason/index'], ['class' => 'btn btn-default']); ?>
    </li>
    <li>
        <?= Html::a('Изменить', ['block-reason/update', 'id' => $model->block_reason_id],
            ['class' => 'btn btn-default']); ?>
    </li>
    <li>
        <?= Html::a('Удалить', ['block-reason/delete', 'id' => $model->block_reason_id],
            ['class' => 'btn btn-default']); ?>
    </li>
</ul>
<div class="row">
    <?php

    try {
        $attributes = [
            'block_reason_id',
            'block_reason_text',
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
