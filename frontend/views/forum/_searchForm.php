<?php

use yii\helpers\Html;

?>
<?= Html::beginForm(['forum/search', 'get', ['class' => 'form-inline']]); ?>
<?= Html::textInput('q', Yii::$app->request->get('q'), ['class' => 'form-control form-small']); ?>
<?= Html::submitButton('Поиск', ['class' => 'btn']); ?>
<?= Html::endForm(); ?>
