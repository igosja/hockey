<?php

use coderlex\wysibb\WysiBB;
use common\models\ElectionNationalViceApplication;
use yii\helpers\Html;
use yii\widgets\ActiveForm;

/**
 * @var ElectionNationalViceApplication $model
 */

print $this->render('//country/_country');

?>
<div class="row">
    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 text-center">
        <h4>Подача заявки на пост заместителя тренера национальной сборной</h4>
    </div>
</div>
<?php $form = ActiveForm::begin([
    'fieldConfig' => [
        'errorOptions' => ['class' => 'col-lg-12 col-md-12 col-sm-12 col-xs-12 notification-error'],
        'labelOptions' => ['class' => 'strong'],
        'options' => ['class' => 'row'],
        'template' =>
            '<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 text-center">{label}</div>
            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">{input}</div>
            {error}',
    ],
]); ?>
<?= $form
    ->field($model, 'election_national_vice_application_text')
    ->widget(WysiBB::class)
    ->label('Ваша программа'); ?>
<div class="row">
    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 text-center">
        <?= Html::submitButton('Сохранить', ['class' => 'btn margin']); ?>
        <?php if (!$model->isNewRecord) : ?>
            <?= Html::a('Удалить', ['delete-application'], ['class' => 'btn margin']); ?>
        <?php endif; ?>
    </div>
</div>
<?php ActiveForm::end(); ?>
