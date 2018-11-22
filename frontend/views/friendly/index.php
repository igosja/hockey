<?php

use yii\helpers\Html;

/**
 * @var \common\models\Team $team
 */

?>
<div class="row margin-top">
    <div class="col-lg-6 col-md-6 col-sm-6 col-xs-6">
        <div class="row">
            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 strong text-size-1">
                <?= $team->team_name; ?>
                (<?= $team->stadium->city->city_name; ?>, <?= $team->stadium->city->country->country_name; ?>)
            </div>
            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                <?= Html::a(
                    $team->friendlyInviteStatus->friendly_invite_status_name,
                    ['friendly/status']
                ); ?>
            </div>
        </div>
    </div>
    <div class="col-lg-6 col-md-6 col-sm-6 col-xs-6">
        <div class="row">
            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 strong text-right text-size-1">
                Организация товарищеских матчей
            </div>
        </div>
    </div>
</div>
