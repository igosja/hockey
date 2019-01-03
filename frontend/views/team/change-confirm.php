<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/**
 * @var array $leaveArray
 * @var \common\models\Team $team
 * @var \yii\web\View $this
 */

?>
<div class="row">
    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 text-center">
        <h1>Смена команды</h1>
    </div>
</div>
<div class="row">
    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 text-center">
        <p>Здесь вы можете подать заявку на смену текущего клуба либо получения дополнительного.</p>
    </div>
</div>
<div class="row">
    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
        <p class="text-center">
            Вы подаете заяку на управление командой
            <span class="strong"><?= $team->fullName(); ?></span>.
        </p>
    </div>
</div>
<?php $form = ActiveForm::begin([
    'action' => ['team/change', 'id' => $team->team_id, 'ok' => 1],
    'fieldConfig' => [
        'errorOptions' => ['class' => 'col-lg-12 col-md-12 col-sm-12 col-xs-12 text-center'],
        'options' => ['class' => 'row'],
        'template' =>
            '<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 text-center">{label}</div>
            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 text-center">{input}</div>
            {error}',
    ],
    'options' => ['class' => 'form-inline'],
]); ?>
<?= $form
    ->field($model, 'leaveId')
    ->dropDownList($leaveArray, ['class' => 'form-control form-small'])
    ->label('Какую команду вы отдаете взамен'); ?>
<div class="row">
    <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12 text-right xs-text-center">
        <?= Html::submitButton('Подать заяку', ['class' => 'btn margin']); ?>
    </div>
    <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12 text-left xs-text-center">
        <?= Html::a('Вернуться', ['team/change'], ['class' => 'btn margin']); ?>
    </div>
</div>
<?php ActiveForm::end(); ?>
