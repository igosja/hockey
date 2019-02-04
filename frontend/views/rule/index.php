<?php

use yii\helpers\Html;

/**
 * @var \common\models\Rule[] $rule
 */

?>
<div class="row">
    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
        <div class="row">
            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 text-center">
                <h1>Правила</h1>
            </div>
        </div>
        <?= Html::beginForm(['rule/search'], 'get', ['class' => 'form-inline text-center']); ?>
        <?= Html::textInput('q', Yii::$app->request->get('q'), ['class' => 'form-control form-small']); ?>
        <?= Html::submitButton('Поиск', ['class' => 'btn']); ?>
        <?= Html::endForm(); ?>
        <ul>
            <?php foreach ($rule as $item) : ?>
                <li><?= Html::a($item->rule_title, ['rule/view', 'id' => $item->rule_id]); ?></li>
            <?php endforeach; ?>
        </ul>
    </div>
</div>