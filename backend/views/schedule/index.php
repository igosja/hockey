<?php

use yii\helpers\Html;

/**
 * @var \common\models\Schedule $schedule
 * @var \yii\web\View $this
 */

?>
<div class="row">
    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 text-center">
        <h3 class="page-header">
            <?= Html::encode($this->title); ?>
        </h3>
    </div>
</div>
<div class="row">
    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 text-center">
        <p>
            Сегодня:
            <?= $schedule->tournamentType->tournament_type_name ?? ''; ?>,
            <?= $schedule->stage->stage_name ?? ''; ?>
        </p>
    </div>
</div>
<ul class="list-inline preview-links text-center">
    <li>
        <?= Html::a(
            'Назад в прошлое',
            ['schedule/index', 'id' => 1],
            ['class' => 'btn btn-default']
        ); ?>
    </li>
    <li>
        <?= Html::a(
            'Вперед в будущее',
            ['schedule/index', 'id' => -1],
            ['class' => 'btn btn-default']
        ); ?>
    </li>
</ul>
