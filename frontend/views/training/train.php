<?php

use common\components\FormatHelper;
use yii\helpers\Html;

/**
 * @var array $confirmData
 * @var \common\models\Team $team
 * @var \yii\web\View $this
 */

?>
<div class="row margin-top">
    <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
        <?= $this->render('//team/_team-top-left', ['team' => $team]); ?>
    </div>
    <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12 text-right">
        <div class="row">
            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 strong text-size-1">
                Тренировочный центр
            </div>
        </div>
        <div class="row">
            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                Уровень:
                <span class="strong"><?= $team->baseTraining->base_training_level; ?></span>
            </div>
        </div>
        <div class="row">
            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                Скорость тренировки:
                <span class="strong"><?= $team->baseTraining->base_training_training_speed_min; ?>%</span>
                -
                <span class="strong"><?= $team->baseTraining->base_training_training_speed_max; ?>%</span>
                за тур
            </div>
        </div>
        <div class="row">
            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                Осталось тренировок силы:
                <span class="strong"><?= 0; ?></span>
                из
                <span class="strong"><?= $team->baseTraining->base_training_power_count; ?></span>
            </div>
        </div>
        <div class="row">
            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                Осталось спецвозможностей:
                <span class="strong"><?= 0; ?></span>
                из
                <span class="strong"><?= $team->baseTraining->base_training_special_count; ?></span>
            </div>
        </div>
        <div class="row">
            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                Осталось совмещений:
                <span class="strong"><?= 0; ?></span>
                из
                <span class="strong"><?= $team->baseTraining->base_training_position_count; ?></span>
            </div>
        </div>
    </div>
</div>
<div class="row margin-top">
    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 text-center">
        <span class="strong">Стоимость тренировок:</span>
        Балл силы
        <span class="strong">
            <?= FormatHelper::asCurrency($team->baseTraining->base_training_power_price); ?>
        </span>
        Спецвозможность
        <span class="strong">
            <?= FormatHelper::asCurrency($team->baseTraining->base_training_special_price); ?>
        </span>
        Совмещение
        <span class="strong">
            <?= FormatHelper::asCurrency($team->baseTraining->base_training_position_price); ?>
        </span>
    </div>
</div>
<div class="row margin-top">
    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 text-center">
        Здесь - <span class="strong">в тренировочном центре</span> -
        вы можете назначить тренировки силы, спецвозможностей или совмещений своим игрокам:
    </div>
</div>
<?= Html::beginForm(['training/train', 'ok' => 1], 'get'); ?>
<div class="row margin-top">
    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
        Будут проведены следующие тренировки:
        <ul>
            <?php foreach ($confirmData['power'] as $item) : ?>
                <li><?= $item['name']; ?> +1 балл силы</li>
                <?= Html::hiddenInput('power[' . $item['id'] . ']', 1); ?>
            <?php endforeach; ?>
            <?php foreach ($confirmData['position'] as $item) : ?>
                <li><?= $item['name']; ?> позиция <?= $item['position']['name']; ?></li>
                <?= Html::hiddenInput('position[' . $item['id'] . ']', $item['position']['id']); ?>
            <?php endforeach; ?>
            <?php foreach ($confirmData['special'] as $item) : ?>
                <li><?= $item['name']; ?> спецвозможность <?= $item['special']['name']; ?></li>
                <?= Html::hiddenInput('special[' . $item['id'] . ']', $item['special']['id']); ?>
            <?php endforeach; ?>
        </ul>
        Общая стоимость тренировок <span class="strong"><?= FormatHelper::asCurrency($confirmData['price']); ?></span>
    </div>
</div>
<div class="row">
    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 text-center">
        <?= Html::submitButton('Начать тренировку', ['class' => 'btn margin']); ?>
        <?= Html::a('Отказаться', ['training/index'], ['class' => 'btn margin']); ?>
    </div>
</div>
<?= Html::endForm(); ?>
