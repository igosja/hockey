<?php

use common\models\TournamentType;
use yii\bootstrap\ActiveForm;
use yii\helpers\Html;

/**
 * @var TournamentType $model
 */

?>
<div class="row">
    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
        <?php $form = ActiveForm::begin(); ?>
        <?= $form->field($model, 'tournament_type_name')->textInput(); ?>
        <?= $form->field($model, 'tournament_type_day_type_id')->textInput(); ?>
        <?= $form->field($model, 'tournament_type_visitor')->textInput(); ?>
        <div class="form-group">
            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 text-center">
                <?= Html::submitButton('Сохранить', ['class' => 'btn btn-default']); ?>
            </div>
        </div>
        <?php ActiveForm::end(); ?>
    </div>
</div>
