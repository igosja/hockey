<?php

use common\components\ErrorHelper;
use yii\helpers\Html;

/**
 * @var \common\models\Rule $rule
 */

?>
<div class="row">
    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
        <div class="row">
            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 text-center">
                <h1><?= $rule->rule_title; ?></h1>
            </div>
        </div>
        <div class="row">
            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 text-center text-size-3">
                <?php

                try {
                    print Yii::$app->formatter->asDatetime($rule->rule_date, 'short');
                } catch (Exception $e) {
                    ErrorHelper::log($e);
                }

                ?>
            </div>
        </div>
        <div class="row">
            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                <?= $rule->rule_text; ?>
            </div>
        </div>
        <div class="row margin-top">
            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 text-center">
                <?= Html::a('Назад', ['rule/index']); ?>
            </div>
        </div>
    </div>
</div>