<?php

use common\components\ErrorHelper;
use common\components\HockeyHelper;
use common\models\Lineup;
use yii\helpers\Html;

/**
 * @var Lineup[] $gameArray
 * @var \yii\web\View $this
 */

print $this->render('_player');
print $this->render('_links');

?>
<div class="row">
    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 table-responsive">
        <table class="table table-bordered table-hover">
            <tr>
                <th>Date</th>
                <th>Game</th>
                <th>Score</th>
                <th>Match type</th>
                <th>Stage</th>
                <th>Position</th>
                <th>Power</th>
                <th>Score</th>
                <th>Assist</th>
                <th>+/-</th>
                <th>Power change</th>
            </tr>
            <?php foreach ($gameArray as $item) { ?>
                <tr>
                    <td class="text-center">
                        <?php

                        try {
                            Yii::$app->formatter->asDate($item->game->schedule->schedule_date);
                        } catch (Exception $e) {
                            ErrorHelper::log($e);
                        }

                        ?>
                    </td>
                    <td class="text-center">
                        <?= HockeyHelper::teamOrNationalLink(
                            $item->game->teamHome,
                            $item->game->nationalHome,
                            false
                        ); ?>
                        -
                        <?= HockeyHelper::teamOrNationalLink(
                            $item->game->teamGuest,
                            $item->game->nationalGuest,
                            false
                        ); ?>
                    </td>
                    <td class="text-center">
                        <?= Html::a(
                            $item->game->game_home_score . ':' . $item->game->game_guest_score,
                            ['game/view', 'id' => $item->game->game_id]
                        ); ?>
                    </td>
                    <td class="text-center">
                        <?= $item->game->schedule->tournamentType->tournament_type_name; ?>
                    </td>
                    <td class="text-center">
                        <?= $item->game->schedule->stage->stage_name; ?>
                        </td>
                    <td class="text-center">
                        <?= $item->position->position_name; ?>
                    </td>
                    <td class="text-center">
                        <?= $item->lineup_power_real; ?>
                    </td>
                    <td class="text-center">
                        <?= $item->lineup_score; ?>
                    </td>
                    <td class="text-center">
                        <?= $item->lineup_assist; ?>
                    </td>
                    <td class="text-center">
                        <?= $item->lineup_plus_minus; ?>
                    </td>
                    <td class="text-center">
                        <?= $item->iconPowerChange(); ?>
                    </td>
                </tr>
            <?php } ?>
            <tr>
                <th>Date</th>
                <th>Game</th>
                <th>Score</th>
                <th>Match type</th>
                <th>Stage</th>
                <th>Position</th>
                <th>Power</th>
                <th>Score</th>
                <th>Assist</th>
                <th>+/-</th>
                <th>Power change</th>
            </tr>
        </table>
    </div>
</div>
<?= $this->render('_links'); ?>
<div class="row hidden-lg hidden-md hidden-sm">
    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
        <a class="btn show-full-table" href="javascript:">
            Show full table
        </a>
    </div>
</div>