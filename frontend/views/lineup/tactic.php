<?php

use common\models\Game;
use common\models\Rudeness;
use common\models\Style;
use common\models\Tactic;
use yii\helpers\ArrayHelper;
use yii\helpers\Html;
use yii\widgets\ActiveForm;

/**
 * @var \yii\data\ActiveDataProvider $dataProvider
 * @var Game $game
 * @var \common\models\Lineup[] $lineupArray
 * @var array $substitutionArray
 * @var \yii\web\View $this
 */

?>
<?= Html::a('main', ['lineup/index', 'id' => $game->game_id]); ?>
<?php $form = ActiveForm::begin(); ?>
<?= $form
    ->field($game, 'game_guest_rude_1_id')
    ->dropDownList(ArrayHelper::map(Rudeness::find()->all(), 'rudeness_id', 'rudeness_name')); ?>
<?= $form
    ->field($game, 'game_guest_rude_2_id')
    ->dropDownList(ArrayHelper::map(Rudeness::find()->all(), 'rudeness_id', 'rudeness_name')); ?>
<?= $form
    ->field($game, 'game_guest_rude_3_id')
    ->dropDownList(ArrayHelper::map(Rudeness::find()->all(), 'rudeness_id', 'rudeness_name')); ?>
<?= $form
    ->field($game, 'game_guest_rude_4_id')
    ->dropDownList(ArrayHelper::map(Rudeness::find()->all(), 'rudeness_id', 'rudeness_name')); ?>
<?= $form
    ->field($game, 'game_guest_style_id_1')
    ->dropDownList(ArrayHelper::map(Style::find()->all(), 'style_id', 'style_name')); ?>
<?= $form
    ->field($game, 'game_guest_style_id_2')
    ->dropDownList(ArrayHelper::map(Style::find()->all(), 'style_id', 'style_name')); ?>
<?= $form
    ->field($game, 'game_guest_style_id_3')
    ->dropDownList(ArrayHelper::map(Style::find()->all(), 'style_id', 'style_name')); ?>
<?= $form
    ->field($game, 'game_guest_style_id_4')
    ->dropDownList(ArrayHelper::map(Style::find()->all(), 'style_id', 'style_name')); ?>
<?= $form
    ->field($game, 'game_guest_tactic_id_1')
    ->dropDownList(ArrayHelper::map(Tactic::find()->all(), 'tactic_id', 'tactic_name')); ?>
<?= $form
    ->field($game, 'game_guest_tactic_id_2')
    ->dropDownList(ArrayHelper::map(Tactic::find()->all(), 'tactic_id', 'tactic_name')); ?>
<?= $form
    ->field($game, 'game_guest_tactic_id_3')
    ->dropDownList(ArrayHelper::map(Tactic::find()->all(), 'tactic_id', 'tactic_name')); ?>
<?= $form
    ->field($game, 'game_guest_tactic_id_4')
    ->dropDownList(ArrayHelper::map(Tactic::find()->all(), 'tactic_id', 'tactic_name')); ?>
<?= Html::submitButton('Submit') ?>
<?php ActiveForm::end(); ?>