<?php

use yii\helpers\Html;

/**
 * @var array $confirmData
 * @var \common\models\Team $team
 * @var \common\models\User $user
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
                Бонусные тренировки
            </div>
        </div>
        <div class="row margin-top">
            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                Осталось тренировок силы:
                <span class="strong"><?= $user->user_shop_point; ?></span>
            </div>
        </div>
        <div class="row">
            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                Осталось спецвозможностей:
                <span class="strong"><?= $user->user_shop_position; ?></span>
            </div>
        </div>
        <div class="row">
            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                Осталось совмещений:
                <span class="strong"><?= $user->user_shop_special; ?></span>
            </div>
        </div>
    </div>
</div>
<div class="row margin-top">
    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 text-center">
        Здесь - <span class="strong">в тренировочном центре</span> -
        вы можете назначить тренировки силы, спецвозможностей или совмещений своим игрокам:
    </div>
</div>
<?= Html::beginForm(['training-free/train', 'ok' => 1], 'get'); ?>
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
    </div>
</div>
<div class="row">
    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 text-center">
        <?= Html::submitButton('Начать тренировку', ['class' => 'btn margin']); ?>
        <?= Html::a('Отказаться', ['training-free/index'], ['class' => 'btn margin']); ?>
    </div>
</div>
<?= Html::endForm(); ?>
