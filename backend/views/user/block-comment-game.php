<?php

use common\models\User;
use yii\helpers\Html;
use yii\widgets\ActiveForm;

/**
 * @var array $blockReasonArray
 * @var User $model
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
        <?= Html::a('Список', ['user/index'], ['class' => 'btn btn-default']); ?>
    </li>
    <li>
        <?= Html::a('Просмотр', ['user/view', 'id' => $model->user_id], ['class' => 'btn btn-default']); ?>
    </li>
</ul>
<div class="row">
    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
        <?php $form = ActiveForm::begin(); ?>
        <?= $form->field($model, 'time')->dropDownList([
            2 => '2 дня',
            5 => '5 дней',
            7 => '7 дней',
            30 => '1 месяц',
            365 => '1 год'
        ]); ?>
        <?= $form->field($model, 'user_block_comment_game_block_reason_id')->dropDownList($blockReasonArray); ?>
        <div class="form-group">
            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 text-center">
                <?= Html::submitButton('Сохранить', ['class' => 'btn btn-default']); ?>
            </div>
        </div>
        <?php ActiveForm::end(); ?>
    </div>
</div>
