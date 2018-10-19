<?php

use common\components\ErrorHelper;

/**
 * @var \frontend\controllers\BaseController $controller
 */

$controller = Yii::$app->controller;
$model = $controller->myTeam;

?>
<div class="col-lg-5 col-md-5 col-sm-5 col-xs-12 text-size-2">
    <span class="italic">Показатели вашей команды:</span>
    <div class="row">
        <div class="col-lg-8 col-md-8 col-sm-8 col-xs-8">
            - Рейтинг силы команды (Vs)
        </div>
        <div class="col-lg-4 col-md-4 col-sm-4 col-xs-4 text-right">
            <?= $model->team_power_vs; ?>
        </div>
    </div>
    <div class="row">
        <div class="col-lg-8 col-md-8 col-sm-8 col-xs-8">
            - Сила 21 лучшего (s21)
        </div>
        <div class="col-lg-4 col-md-4 col-sm-4 col-xs-4 text-right">
            <?= $model->team_power_s_21; ?>
        </div>
    </div>
    <div class="row">
        <div class="col-lg-8 col-md-8 col-sm-8 col-xs-8">
            - Сила 26 лучших (s26)
        </div>
        <div class="col-lg-4 col-md-4 col-sm-4 col-xs-4 text-right">
            <?= $model->team_power_s_26; ?>
        </div>
    </div>
    <div class="row">
        <div class="col-lg-8 col-md-8 col-sm-8 col-xs-8">
            - Сила 32 лучших (s32)
        </div>
        <div class="col-lg-4 col-md-4 col-sm-4 col-xs-4 text-right">
            <?= $model->team_power_s_32; ?>
        </div>
    </div>
    <div class="row">
        <div class="col-lg-8 col-md-8 col-sm-8 col-xs-8">
            - Стоимость строений
        </div>
        <div class="col-lg-4 col-md-4 col-sm-4 col-xs-4 text-right">
            <?php

            try {
                print Yii::$app->formatter->asCurrency($model->team_price_base, 'USD');
            } catch (Exception $e) {
                ErrorHelper::log($e);
            }

            ?>
        </div>
    </div>
    <div class="row">
        <div class="col-lg-8 col-md-8 col-sm-8 col-xs-8">
            - Общая стоимость
        </div>
        <div class="col-lg-4 col-md-4 col-sm-4 col-xs-4 text-right">
            <?php

            try {
                print Yii::$app->formatter->asCurrency($model->team_price_total, 'USD');
            } catch (Exception $e) {
                ErrorHelper::log($e);
            }

            ?>
        </div>
    </div>
</div>
