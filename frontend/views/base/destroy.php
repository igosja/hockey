<?php

use yii\helpers\Html;

/**
 * @var int $building
 * @var string $message
 * @var \common\models\Team $team
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
        <?= $message; ?>
    </div>
</div>
<div class="row">
    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 text-center">
        <?= Html::a('Строить', ['base/destroy', 'building' => $building, 'ok' => 1], ['class' => 'btn margin']); ?>
        <?= Html::a('Отказаться', ['base/view', 'id' => $team->team_id], ['class' => 'btn margin']); ?>
    </div>
</div>