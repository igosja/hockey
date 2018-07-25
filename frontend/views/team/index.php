<?php

use yii\helpers\ArrayHelper;
use yii\helpers\Html;

/**
 * @var \common\models\Team[] $countryArray
 */

?>
<div class="row">
    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
        <h1>
            Teams
        </h1>
    </div>
</div>
<div class="row">
    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
        <table class="table table-bordered table-hover">
            <tr>
                <th class="col-1"></th>
                <th>Country</th>
                <th class="col-25">Teams</th>
            </tr>
            <?php foreach ($countryArray as $item): ?>
                <tr>
                    <td>
                        <?= Html::a(
                            Html::img(
                                '/img/country/12/' . $item->stadium->city->country->country_id . '.png',
                                [
                                    'alt' => $item->stadium->city->country->country_name,
                                    'title' => $item->stadium->city->country->country_name,
                                ]
                            ),
                            ['country/team', 'id' => $item->stadium->city->country->country_id]
                        ); ?>
                    </td>
                    <td>
                        <?= Html::a(
                            $item->stadium->city->country->country_name,
                            ['country/team', 'id' => $item->stadium->city->country->country_id]
                        ); ?>
                    </td>
                    <td class="text-center">
                        <?= $item->team_player; ?>
                    </td>
                </tr>
            <?php endforeach; ?>
            <tr>
                <th></th>
                <th>Country</th>
                <th>Teams</th>
            </tr>
        </table>
    </div>
</div>
