<?php

use yii\helpers\Html;

/**
 * @var int $id
 * @var string $price
 */

?>
<div class="row margin-top">
    <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
        <?= $this->render('//team/_team-top-left', ['team' => $team, 'teamId' => $team->team_id]); ?>
    </div>
    <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12"></div>
</div>
<div class="row margin-top">
    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 text-center">
        Вы собираетесь отменить строительство здания.
        <?php if ($price > 0) : ?>
            Компенсансация за отмену строительства составит <span class="strong"><?= $price; ?></span>.
        <?php else : ?>
            Оплата за отмену строительства составит <span class="strong"><?= $price; ?></span>.
        <?php endif; ?>
    </div>
</div>
<div class="row">
    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 text-center">
        <?= Html::a('Отменить строительство', ['base/cancel', 'id' => $id, 'ok' => 1], ['class' => 'btn margin']); ?>
        <?= Html::a('Вернуться', ['base/view', 'id' => $team->team_id], ['class' => 'btn margin']); ?>
    </div>
</div>
