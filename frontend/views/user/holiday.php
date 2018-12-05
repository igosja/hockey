<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/**
 * @var \common\models\User $model
 */

print $this->render('_top');

?>
<div class="row margin-top-small">
    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
        <?= $this->render('_user-links'); ?>
    </div>
</div>
<div class="row">
    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 table-responsive">
        <table class="table">
            <tr>
                <th>Отпуск менеджера</th>
            </tr>
        </table>
    </div>
</div>
<?php $form = ActiveForm::begin([
    'fieldConfig' => [
        'labelOptions' => ['class' => 'strong'],
        'options' => ['class' => 'row'],
        'template' =>
            '<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 text-center margin-top">
            {label}
            {input}
            </div>',
    ],
]); ?>
<div class="row">
    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 text-center">
        На этой странице вы можете <span class="strong">изменить свои анкетные данные</span>:
    </div>
</div>
<?= $form->field($model, 'user_holiday')->checkbox(['label' => false])->label(
    'Поставьте здесь галочку, если собираетесь уехать в отпуск и временно не сможете управлять своими командами'
); ?>
<div class="row margin-top-small">
    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 text-center">
        <?= Html::submitButton('Сохранить', ['class' => 'btn']); ?>
    </div>
</div>
<?php ActiveForm::end(); ?>
