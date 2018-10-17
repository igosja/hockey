<?php

use common\components\ErrorHelper;
use common\components\RosterPhrase;
use common\models\Team;
use yii\helpers\Html;

/**
 * @var \frontend\controllers\BaseController $controller
 * @var \common\models\Game[] $latest
 * @var \common\models\Game[] $nearest
 * @var int $teamId
 * @var Team $team
 */

$controller = Yii::$app->controller;
list($teamId, $team, $latest, $nearest) = Team::getTopData();

?>
    <div class="row margin-top">
        <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
            <div class="row">
                <div class="col-lg-3 col-md-4 col-sm-3 col-xs-4 text-center team-logo-div">
                    <?= Html::a(
                        $team->logo(),
                        ['logo', 'id' => $teamId],
                        ['class' => 'team-logo-link']
                    ); ?>
                </div>
                <div class="col-lg-9 col-md-8 col-sm-9 col-xs-8">
                    <div class="row">
                        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 text-size-1 strong">
                            <?= $team->team_name; ?>
                            <?= '('
                            . $team->stadium->city->city_name
                            . ', '
                            . $team->stadium->city->country->country_name
                            . ')'; ?>
                        </div>
                    </div>
                    <div class="row margin-top-small">
                        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 text-size-3">
                            <?= Yii::t('frontend-views-team-team-top', 'division'); ?>: <?= $team->division(); ?>
                        </div>
                    </div>
                    <div class="row margin-top-small">
                        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                            <?= Yii::t('frontend-views-team-team-top', 'manager'); ?>:
                            <?php if ($team->manager->canDialog()) : ?>
                                <?= Html::a(
                                    '<i class="fa fa-envelope-o"></i>',
                                    ['dialog/view', 'id' => $team->manager->user_id]
                                ); ?>
                            <?php endif; ?>
                            <?= Html::a(
                                $team->manager->fullName(),
                                ['user/view', 'id' => $team->manager->user_id],
                                ['class' => 'strong']
                            ); ?>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                            <?= Yii::t('frontend-views-team-team-top', 'nickname'); ?>:
                            <?= $team->manager->iconVip(); ?>
                            <?= Html::a(
                                $team->manager->user_login,
                                ['user/view', 'id' => $team->manager->user_id],
                                ['class' => 'strong']
                            ); ?>
                        </div>
                    </div>
                    <?php if ($team->team_vice_id) { ?>
                        <div class="row margin-top-small">
                            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                                <?= Yii::t('frontend-views-team-team-top', 'vice'); ?>:
                                <?php if ($team->vice->canDialog()) : ?>
                                    <?= Html::a(
                                        '<i class="fa fa-envelope-o"></i>',
                                        ['dialog/view', 'id' => $team->vice->user_id]
                                    ); ?>
                                <?php endif; ?>
                                <?= Html::a(
                                    $team->vice->fullName(),
                                    ['user/view', 'id' => $team->vice->user_id],
                                    ['class' => 'strong']
                                ); ?>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                                <?= Yii::t('frontend-views-team-team-top', 'nickname'); ?>:
                                <?= $team->manager->iconVip(); ?>
                                <?= Html::a(
                                    $team->vice->user_login,
                                    ['user/view', 'id' => $team->vice->user_id],
                                    ['class' => 'strong']
                                ); ?>
                            </div>
                        </div>
                    <?php } ?>
                    <div class="row margin-top-small">
                        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                            <?= $team->getAttributeLabel('stadium'); ?>:
                            <?= $team->stadium->stadium_name; ?>,
                            <strong><?= Yii::$app->formatter->asInteger($team->stadium->stadium_capacity); ?></strong>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                            <?= $team->getAttributeLabel('base'); ?>:
                            <span class="strong"><?= $team->base->base_level; ?></span>
                            <?= Yii::t('frontend-views-team-team-top', 'level'); ?>
                            (<?= Yii::t('frontend-views-team', 'base-used', [
                                'used' => '<span class="strong">' . $team->baseUsed() . '</span>',
                                'max' => '<span class="strong">' . $team->base->base_slot_max . '</span>'
                            ]); ?>)
                        </div>
                    </div>
                    <div class="row margin-top-small">
                        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                            <?= Yii::t('frontend-views-team-team-top', 'finance'); ?>:
                            <span class="strong">
                                <?php

                                try {
                                    print Yii::$app->formatter->asCurrency($team->team_finance, 'USD');
                                } catch (Exception $e) {
                                    ErrorHelper::log($e);
                                }

                                ?>
                            </span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12 text-right">
            <div class="row">
                <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 text-size-3 italic">
                    - <?= RosterPhrase::rand(); ?> -
                </div>
                <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 margin-top-small">
                    <?php if (Yii::$app->user->isGuest) : ?>
                        <?= Html::a(
                            Html::img(
                                '/img/roster/questionnaire.png',
                                [
                                    'alt' => Yii::t('frontend-views-team-team-top', 'link-sign-up'),
                                    'title' => Yii::t('frontend-views-team-team-top', 'link-sign-up'),
                                ]
                            ),
                            ['site/sign-up'],
                            ['class' => 'no-underline']
                        ); ?>
                    <?php else: ?>
                        <?php if ($controller->myTeam && $controller->myTeam->team_id == $teamId) : ?>
                            <?= Html::a(
                                Html::img(
                                    '/img/roster/friendly.png',
                                    [
                                        'alt' => Yii::t('frontend-views-team-team-top', 'link-friendly'),
                                        'title' => Yii::t('frontend-views-team-team-top', 'link-friendly'),
                                    ]
                                ),
                                ['friendly/index'],
                                ['class' => 'no-underline']
                            ); ?>
                            <?= Html::a(
                                Html::img(
                                    '/img/roster/training.png',
                                    [
                                        'alt' => Yii::t('frontend-views-team-team-top', 'link-training'),
                                        'title' => Yii::t('frontend-views-team-team-top', 'link-training'),
                                    ]
                                ),
                                ['training/index'],
                                ['class' => 'no-underline']
                            ); ?>
                            <?= Html::a(
                                Html::img(
                                    '/img/roster/scout.png',
                                    [
                                        'alt' => Yii::t('frontend-views-team-team-top', 'link-scout'),
                                        'title' => Yii::t('frontend-views-team-team-top', 'link-scout'),
                                    ]
                                ),
                                ['scout/index'],
                                ['class' => 'no-underline']
                            ); ?>
                            <?= Html::a(
                                Html::img(
                                    '/img/roster/physical.png',
                                    [
                                        'alt' => Yii::t('frontend-views-team-team-top', 'link-physical'),
                                        'title' => Yii::t('frontend-views-team-team-top', 'link-physical'),
                                    ]
                                ),
                                ['physical/index'],
                                ['class' => 'no-underline']
                            ); ?>
                            <?= Html::a(
                                Html::img(
                                    '/img/roster/school.png',
                                    [
                                        'alt' => Yii::t('frontend-views-team-team-top', 'link-school'),
                                        'title' => Yii::t('frontend-views-team-team-top', 'link-school'),
                                    ]
                                ),
                                ['school/index'],
                                ['class' => 'no-underline']
                            ); ?>
                        <?php else: ?>
                            <?= Html::a(
                                Html::img(
                                    '/img/roster/free-team.png',
                                    [
                                        'alt' => Yii::t('frontend-views-team-team-top', 'link-change-team'),
                                        'title' => Yii::t('frontend-views-team-team-top', 'link-change-team'),
                                    ]
                                ),
                                ['team/change'],
                                ['class' => 'no-underline']
                            ); ?>
                        <?php endif; ?>
                        <?= Html::a(
                            Html::img(
                                '/img/roster/questionnaire.png',
                                [
                                    'alt' => Yii::t('frontend-views-team-team-top', 'link-questionnaire'),
                                    'title' => Yii::t('frontend-views-team-team-top', 'link-questionnaire'),
                                ]
                            ),
                            ['user/questionnaire'],
                            ['class' => 'no-underline']
                        ); ?>
                    <?php endif; ?>
                </div>
                <?php foreach ($latest as $item) : ?>
                    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 text-size-3 italic">
                        <?php

                        try {
                            print Yii::$app->formatter->asDatetime($item->schedule->schedule_date, 'short');
                        } catch (Exception $e) {
                            ErrorHelper::log($e);
                        }

                        ?>
                        -
                        <?= $item->schedule->tournamentType->tournament_type_name; ?>
                        -
                        <?= $item->game_home_team_id == $teamId
                            ? Yii::t('frontend-views-team-team-top', 'letter-home')
                            : Yii::t('frontend-views-team-team-top', 'letter-guest'); ?>
                        -
                        <?= Html::a(
                            $item->game_home_team_id == $teamId ? $item->teamGuest->team_name : $item->teamHome->team_name,
                            ['team/view', 'id' => $item->game_home_team_id == $teamId ? $item->game_guest_team_id : $item->game_home_team_id]
                        ); ?>
                        -
                        <?= Html::a(
                            $item->game_home_team_id == $teamId ? $item->game_home_score . ':' . $item->game_guest_score : $item->game_guest_score . ':' . $item->game_home_score,
                            ['game/view', 'id' => $item->game_id]
                        ); ?>
                    </div>
                <?php endforeach; ?>
                <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                    <div class="row text-size-4">&nbsp;</div>
                </div>
                <?php foreach ($nearest as $item) : ?>
                    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 text-size-3 italic">
                        <?php

                        try {
                            print Yii::$app->formatter->asDatetime($item->schedule->schedule_date, 'short');
                        } catch (Exception $e) {
                            ErrorHelper::log($e);
                        }

                        ?>
                        -
                        <?= $item->schedule->tournamentType->tournament_type_name; ?>
                        -
                        <?= $item->game_home_team_id == $teamId
                            ? Yii::t('frontend-views-team-team-top', 'letter-home')
                            : Yii::t('frontend-views-team-team-top', 'letter-guest'); ?>
                        -
                        <?= Html::a(
                            $item->game_home_team_id == $teamId ? $item->teamGuest->team_name : $item->teamHome->team_name,
                            ['team/view', 'id' => $item->game_home_team_id == $teamId ? $item->game_guest_team_id : $item->game_home_team_id]
                        ); ?>
                        -
                        <?php if ($controller->myTeam && $controller->myTeam->team_id == $teamId) : ?>
                            <?= Html::a(
                                (($item->game_home_team_id == $teamId && $item->game_home_tactic_id_1)
                                    || ($item->game_guest_team_id == $teamId && $item->game_guest_tactic_id_1))
                                    ? Yii::t('frontend-views-team-team-top', 'link-edit')
                                    : Yii::t('frontend-views-team-team-top', 'link-send'),
                                ['lineup/index', 'id' => $item->game_id]
                            ); ?>
                        <?php else: ?>
                            <?= Html::a(
                                '?:?',
                                ['game/preview', 'id' => $item->game_id]
                            ); ?>
                        <?php endif; ?>
                    </div>
                <?php endforeach; ?>
            </div>
        </div>
    </div>
<?php if ($notification_array = []) : ?>
    <div class="row margin-top">
        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
            <ul>
                <?php foreach ($notification_array as $item) : ?>
                    <li><?= $item; ?></li>
                <?php endforeach; ?>
            </ul>
        </div>
    </div>
<?php endif; ?>