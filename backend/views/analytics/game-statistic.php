<?php

use yii\helpers\Html;

/**
 * @var \common\models\Game $game
 */

?>
<div class="row">
    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 text-center">
        <h3 class="page-header"><?= Html::encode($this->title); ?></h3>
    </div>
</div>
<div class="row">
    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 table-responsive">
        <table class="table table-striped table-bordered table-hover table-condensed">
            <tr>
                <th class="col-lg-4 col-md-4 col-sm-4 col-xs-4">
                    Показатель
                </th>
                <th class="col-lg-4 col-md-4 col-sm-4 col-xs-4">
                    Результат сайта
                </th>
                <th>
                    НХЛ
                </th>
            </tr>
            <tr>
                <td>
                    Средняя результативность
                </td>
                <td>
                    <?= $game->score; ?>
                </td>
                <td>
                    6
                </td>
            </tr>
            <tr>
                <td>
                    Среднее количество бросков
                </td>
                <td>
                    <?= $game->shot; ?>
                </td>
                <td>
                    60
                </td>
            </tr>
            <tr>
                <td>
                    Среднее количество штрафов
                </td>
                <td>
                    <?= $game->penalty; ?>
                </td>
                <td>
                    10
                </td>
            </tr>
        </table>
    </div>
</div>
