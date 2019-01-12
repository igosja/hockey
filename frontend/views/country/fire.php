<?php

use yii\helpers\Html;

/**
 * @var \yii\data\ActiveDataProvider $dataProvider
 * @var \yii\web\View $this
 */

print $this->render('_country');

?>
<div class="row">
    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
        <table class="table table-bordered">
            <tr>
                <th>Отказ от должности</th>
            </tr>
        </table>
    </div>
</div>
<div class="row">
    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 text-center">
        <p>Вы собираетесь отказаться от своей должности в федерации</p>
        <?= Html::a('Отказаться от должности', ['country/fire', 'id' => $id, 'ok' => 1], ['class' => 'btn margin']); ?>
    </div>
</div>
