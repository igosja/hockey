<?php

use yii\helpers\Html;

/**
 * @var \common\models\User $model
 */

print $this->render('_top');

?>
<div class="row margin-top-small">
    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
        <?= $this->render('_user-links'); ?>
    </div>
</div>
<div class="row">
    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 table-responsive">
        <table class="table">
            <tr>
                <th>Удаление аккаунта</th>
            </tr>
        </table>
    </div>
</div>
<div class="row margin-top">
    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 text-center">
        Вы собираетесь удалить свой аккаунт
    </div>
</div>
<div class="row">
    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
        <p class="text-center">
            <?= Html::a('Удалить аккаунт', ['user/delete', 'ok' => 1], ['class' => 'btn margin']); ?>
            <?= Html::a('Вернуться', ['user/view'], ['class' => 'btn margin']); ?>
        </p>
    </div>
</div>