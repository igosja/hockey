<?php

use yii\bootstrap\ActiveForm;
use yii\helpers\Html;

/**
 * @var \common\models\Stage $model
 */

?>
<div class="row">
    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
        <?php $form = ActiveForm::begin(); ?>
        <?= $form->field($model, 'stage_name')->textInput(); ?>
        <div class="form-group">
            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 text-center">
                <?= Html::submitButton('Сохранить', ['class' => 'btn btn-default']); ?>
            </div>
        </div>
        <?php ActiveForm::end(); ?>
    </div>
</div>
