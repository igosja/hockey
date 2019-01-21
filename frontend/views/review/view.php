<?php

use common\components\FormatHelper;
use common\components\HockeyHelper;
use common\models\UserRole;
use yii\helpers\Html;

/**
 * @var \common\models\Review $review
 * @var \common\models\User $user
 */

$user = Yii::$app->user->identity;

?>
<div class="row">
    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
        <h1>
            <?= $review->review_title; ?>
        </h1>
    </div>
</div>
<div class="row">
    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
        <p class="text-center">
            <?= $review->country->country_name; ?>,
            <?= $review->division->division_name; ?>,
            <?= $review->stage->stage_name; ?>,
            <?= $review->review_season_id; ?> сезон
        </p>
    </div>
</div>
<?php if (!Yii::$app->user->isGuest && UserRole::USER != $user->user_user_role_id) : ?>
    <div class="row">
        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 text-center">
            <?= Html::a('Удалить', ['review/delete', 'id' => $review->review_id]); ?>
        </div>
    </div>
<?php endif; ?>
<div class="row">
    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
        <?= HockeyHelper::bbDecode($review->review_text); ?>
    </div>
</div>
<?php foreach ($review->reviewGame as $reviewGame) : ?>
    <div class="row margin-top">
        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 table-responsive">
            <table class="table">
                <tr>
                    <td class="text-right col-45">
                        <?= $reviewGame->game->teamHome->teamLink('string', true); ?>
                        <?= HockeyHelper::formatAuto($reviewGame->game->game_home_auto); ?>
                    </td>
                    <td class="text-center col-10">
                        <?= Html::a(
                            $reviewGame->game->formatScore(),
                            ['game/view', 'id' => $reviewGame->game->game_id]
                        ); ?>
                    </td>
                    <td>
                        <?= $reviewGame->game->teamGuest->teamLink('string', true); ?>
                        <?= HockeyHelper::formatAuto($reviewGame->game->game_guest_auto); ?>
                    </td>
                </tr>
            </table>
        </div>
    </div>
    <div class="row">
        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
            <?= HockeyHelper::bbDecode($reviewGame->review_game_text); ?>
        </div>
    </div>
<?php endforeach; ?>
<div class="row margin-top-small">
    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
        <p>
            <?= FormatHelper::asDate($review->review_date); ?>,
            <?= $review->user->userLink(); ?>
        </p>
    </div>
</div>
<div class="row">
    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 text-center">
        <?= Html::a(
            'Турнирная таблица',
            [
                'championship/index',
                'countryId' => $review->review_country_id,
                'divisionId' => $review->review_division_id,
                'seasonId' => $review->review_season_id,
            ],
            ['class' => 'btn margin']
        ); ?>
    </div>
</div>
