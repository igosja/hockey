<?php

use common\models\Game;
use common\models\Rudeness;
use common\models\Style;
use common\models\Tactic;
use yii\helpers\ArrayHelper;
use yii\helpers\Html;
use yii\widgets\ActiveForm;

/**
 * @var Game $game
 * @var string $team
 */

?>
    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 margin-top">
        <?= Html::a('Основные линии', ['lineup/view', 'id' => $game->game_id]); ?>
        |
        <?= Html::a('Спецбригады', ['lineup/special', 'id' => $game->game_id]); ?>
        |
        <?= Html::a('Буллиты', ['lineup/shootout', 'id' => $game->game_id]); ?>
        |
        <span class="strong">Тактика</span>
        |
        <?= Html::a('Сохранения', ['lineup/saves', 'id' => $game->game_id]); ?>
    </div>
<?php $form = ActiveForm::begin(); ?>
<?= $form
    ->field($game, 'game_' . $team . '_rudeness_id_1')
    ->dropDownList(ArrayHelper::map(Rudeness::find()->all(), 'rudeness_id', 'rudeness_name')); ?>
<?= $form
    ->field($game, 'game_' . $team . '_rudeness_id_2')
    ->dropDownList(ArrayHelper::map(Rudeness::find()->all(), 'rudeness_id', 'rudeness_name')); ?>
<?= $form
    ->field($game, 'game_' . $team . '_rudeness_id_3')
    ->dropDownList(ArrayHelper::map(Rudeness::find()->all(), 'rudeness_id', 'rudeness_name')); ?>
<?= $form
    ->field($game, 'game_' . $team . '_rudeness_id_4')
    ->dropDownList(ArrayHelper::map(Rudeness::find()->all(), 'rudeness_id', 'rudeness_name')); ?>
<?= $form
    ->field($game, 'game_' . $team . '_style_id_1')
    ->dropDownList(ArrayHelper::map(Style::find()->all(), 'style_id', 'style_name')); ?>
<?= $form
    ->field($game, 'game_' . $team . '_style_id_2')
    ->dropDownList(ArrayHelper::map(Style::find()->all(), 'style_id', 'style_name')); ?>
<?= $form
    ->field($game, 'game_' . $team . '_style_id_3')
    ->dropDownList(ArrayHelper::map(Style::find()->all(), 'style_id', 'style_name')); ?>
<?= $form
    ->field($game, 'game_' . $team . '_style_id_4')
    ->dropDownList(ArrayHelper::map(Style::find()->all(), 'style_id', 'style_name')); ?>
<?= $form
    ->field($game, 'game_' . $team . '_tactic_id_1')
    ->dropDownList(ArrayHelper::map(Tactic::find()->all(), 'tactic_id', 'tactic_name')); ?>
<?= $form
    ->field($game, 'game_' . $team . '_tactic_id_2')
    ->dropDownList(ArrayHelper::map(Tactic::find()->all(), 'tactic_id', 'tactic_name')); ?>
<?= $form
    ->field($game, 'game_' . $team . '_tactic_id_3')
    ->dropDownList(ArrayHelper::map(Tactic::find()->all(), 'tactic_id', 'tactic_name')); ?>
<?= $form
    ->field($game, 'game_' . $team . '_tactic_id_4')
    ->dropDownList(ArrayHelper::map(Tactic::find()->all(), 'tactic_id', 'tactic_name')); ?>
<?= Html::submitButton('Submit') ?>
<?php ActiveForm::end(); ?>