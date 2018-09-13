<?php

use common\components\ErrorHelper;
use common\models\Schedule;
use yii\helpers\ArrayHelper;
use yii\helpers\Html;

/**
 * @var Schedule[] $scheduleArray
 * @var \common\models\Season[] $season
 * @var int $seasonId
 */

?>
<div class="row">
    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
        <h1>Schedule</h1>
    </div>
</div>
<?= Html::beginForm('', 'get'); ?>
<div class="row">
    <div class="col-lg-3 col-md-3 col-sm-3 col-xs-3"></div>
    <div class="col-lg-3 col-md-3 col-sm-3 col-xs-3 text-right">
        <?= Html::label('Season:', 'seasonId'); ?>
    </div>
    <div class="col-lg-1 col-md-1 col-sm-1 col-xs-2">
        <?= Html::dropDownList(
            'seasonId',
            $seasonId,
            ArrayHelper::map($season, 'season_id', 'season_id'),
            ['class' => 'form-control submit-on-change', 'id' => 'seasonId']
        ); ?>
    </div>
    <div class="col-lg-5 col-md-5 col-sm-5 col-xs-4"></div>
</div>
<?= Html::endForm(); ?>
<div class="row">
    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 table-responsive">
        <table class="table table-bordered table-hover">
            <tr>
                <th>Date</th>
                <th>Tournament</th>
                <th>Stage</th>
            </tr>
            <?php foreach ($scheduleArray as $item): ?>
                <tr>
                    <td class="text-center">
                        <?php

                        try {
                            print Yii::$app->formatter->asDatetime($item->schedule_date);
                        } catch (Exception $e) {
                            ErrorHelper::log($e);
                        }

                        ?>
                    </td>
                    <td class="text-center">
                        <?= Html::a(
                            $item->tournamentType->tournament_type_name,
                            ['view', 'id' => $item->schedule_id]
                        ); ?>
                    </td>
                    <td class="text-center">
                        <?= $item->stage->stage_name; ?>
                    </td>
                </tr>
            <?php endforeach; ?>
            <tr>
                <th>Date</th>
                <th>Tournament</th>
                <th>Stage</th>
            </tr>
        </table>
    </div>
</div>
