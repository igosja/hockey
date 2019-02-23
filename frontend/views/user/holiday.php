<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/**
 * @var \common\models\User $model
 * @var array $teamArray
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
<div class="row">
    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 text-center margin-top strong">
        Заместители:
    </div>
</div>
<?php foreach ($teamArray as $item) : ?>
    <?php /** @var \common\models\Team $team */
    $team = $item['team']; ?>
    <div class="row">
        <div class="col-lg-5 col-md-4 col-sm-4 col-xs-12 text-right">
            <?= Html::label(
                $team->team_name . ' (' . $team->stadium->city->country->country_name . ')',
                $team->team_id
            ); ?>
        </div>
        <div class="col-lg-3 col-md-5 col-sm-5 col-xs-12">
            <?= Html::dropDownList(
                'vice[' . $team->team_id . ']',
                $team->team_vice_id,
                $item['userArray'],
                ['prompt' => 'Нет', 'id' => 'vice-' . $team->team_id, 'class' => 'form-control']
            ); ?>
        </div>
    </div>
<?php endforeach; ?>
<div class="row margin-top-small">
    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 text-center">
        <?= Html::submitButton('Сохранить', ['class' => 'btn']); ?>
    </div>
</div>
<?php ActiveForm::end(); ?>
