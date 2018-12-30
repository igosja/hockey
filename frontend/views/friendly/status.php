<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/**
 * @var array $friendlyStatusArray
 * @var \common\models\Team $team
 */

?>
<div class="row margin-top">
    <div class="col-lg-6 col-md-6 col-sm-6 col-xs-6">
        <div class="row">
            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 strong text-size-1">
                <?= $team->team_name; ?>
                (<?= $team->stadium->city->city_name; ?>, <?= $team->stadium->city->country->country_name; ?>)
            </div>
        </div>
    </div>
</div>
<div class="row margin-top">
    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 strong">
        Ваш статус в товарищеских матчах:
    </div>
</div>
<?php $form = ActiveForm::begin(); ?>
<?= $form
    ->field($team, 'team_friendly_status_id')
    ->radioList($friendlyStatusArray, [
        'item' => function ($index, $label, $name, $checked, $value) {
            return Html::radio($name, $checked, [
                    'index' => $index,
                    'label' => $label,
                    'value' => $value,
                ]) . '<br/>';
        }
    ])
    ->label(false); ?>
<div class="row">
    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 text-center">
        <?= Html::submitButton('Сохранить', ['class' => 'btn margin']); ?>
    </div>
</div>
<?php ActiveForm::end(); ?>
