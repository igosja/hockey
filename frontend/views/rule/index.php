<?php

use yii\helpers\Html;

/**
 * @var \common\models\Rule[] $rules
 */

?>
<div class="row">
    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
        <div class="row">
            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 text-center">
                <h1>Правила</h1>
            </div>
        </div>
        <ul>
            <?php foreach ($rules as $item) { ?>
                <li><?= Html::a($item->rule_title, ['rule/view', 'id' => $item->rule_id]); ?></li>
            <?php } ?>
        </ul>
    </div>
</div>