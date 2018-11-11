<?php

use yii\bootstrap\ActiveForm;
use yii\helpers\Html;

/**
 * @var \common\models\News $model
 */

?>
<div class="row">
    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
        <?php $form = ActiveForm::begin(); ?>
        <?= $form->field($model, 'poll_text')->textarea(); ?>
        <?php for ($i = 0; $i < 15; $i++) : ?>
            <?= $form->field($model, 'answer[' . $i . ']')->textarea(); ?>
        <?php endfor; ?>
        <div class="form-group">
            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 text-center">
                <?= Html::submitButton('Сохранить', ['class' => 'btn btn-default']); ?>
            </div>
        </div>
        <?php ActiveForm::end(); ?>
    </div>
</div>
