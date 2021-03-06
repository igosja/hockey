<?php

use common\components\FormatHelper;
use yii\helpers\Html;

/**
 * @var int $id
 * @var string $price
 * @var \common\models\Team $team
 */

?>
<div class="row margin-top">
    <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
        <?= $this->render('//team/_team-top-left', ['team' => $team]); ?>
    </div>
    <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12 text-right">
        <div class="row">
            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 strong text-size-1">
                Отмена строительства стадиона
            </div>
        </div>
    </div>
</div>
<div class="row margin-top">
    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 text-center">
        Вы собираетесь отменить строительство стадиона.
        <?php if ($price > 0) : ?>
            Компенсансация за отмену строительства составит
            <span class="strong"><?= FormatHelper::asCurrency($price); ?></span>.
        <?php else : ?>
            Оплата за отмену строительства составит
            <span class="strong"><?= FormatHelper::asCurrency(-$price); ?></span>.
        <?php endif; ?>
    </div>
</div>
<div class="row">
    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 text-center">
        <?= Html::a('Отменить строительство', ['stadium/cancel', 'id' => $id, 'ok' => 1], ['class' => 'btn margin']); ?>
        <?= Html::a('Вернуться', ['stadium/increase'], ['class' => 'btn margin']); ?>
    </div>
</div>
