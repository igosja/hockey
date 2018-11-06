<?php

use common\components\ErrorHelper;
use common\components\RosterPhrase;
use common\models\Team;
use yii\helpers\Html;

/**
 * @var \frontend\controllers\AbstractController $controller
 * @var \common\models\Game[] $latest
 * @var \common\models\Game[] $nearest
 * @var int $teamId
 * @var Team $team
 */

$controller = Yii::$app->controller;
list($teamId, $team, $latest, $nearest) = Team::getTopData();

$myTeamIds = [];
foreach ($controller->myTeamArray as $item) {
    $myTeamIds[] = $item->team_id;
}

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
                            Дивизион: <?= $team->division(); ?>
                        </div>
                    </div>
                    <div class="row margin-top-small">
                        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                            Менеджер:
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
                            Ник:
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
                                Заместитель:
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
                                Ник:
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
                            <span class="strong"><?= $team->base->base_level; ?></span> уровень
                            (<span class="strong"><?= $team->baseUsed(); ?></span>
                            из
                            <span class="strong"><?= $team->base->base_slot_max; ?></span>)
                        </div>
                    </div>
                    <div class="row margin-top-small">
                        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                            Финансы:
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
                                ['alt' => 'Зарегистрироваться', 'title' => 'Зарегистрироваться']
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
                                        'alt' => 'Организовать товарищеский матч',
                                        'title' => 'Организовать товарищеский матч',
                                    ]
                                ),
                                ['friendly/index'],
                                ['class' => 'no-underline']
                            ); ?>
                            <?= Html::a(
                                Html::img(
                                    '/img/roster/training.png',
                                    ['alt' => 'Тренировка хоккеистов', 'title' => 'Тренировка хоккеистов']
                                ),
                                ['training/index'],
                                ['class' => 'no-underline']
                            ); ?>
                            <?= Html::a(
                                Html::img(
                                    '/img/roster/scout.png',
                                    ['alt' => 'Изучение хоккеистов', 'title' => 'Изучение хоккеистов']
                                ),
                                ['scout/index'],
                                ['class' => 'no-underline']
                            ); ?>
                            <?= Html::a(
                                Html::img(
                                    '/img/roster/physical.png',
                                    ['alt' => 'Изменение физической формы', 'title' => 'Изменение физической формы']
                                ),
                                ['physical/index'],
                                ['class' => 'no-underline']
                            ); ?>
                            <?= Html::a(
                                Html::img(
                                    '/img/roster/school.png',
                                    ['alt' => 'Подготовка молодёжи', 'title' => 'Подготовка молодёжи']
                                ),
                                ['school/index'],
                                ['class' => 'no-underline']
                            ); ?>
                        <?php elseif (!in_array($teamId, $myTeamIds)): ?>
                            <?= Html::a(
                                Html::img(
                                    '/img/roster/free-team.png',
                                    [
                                        'alt' => 'Подать заявку на получение команды',
                                        'title' => 'Подать заявку на получение команды',
                                    ]
                                ),
                                ['team/change', 'id' => $teamId],
                                ['class' => 'no-underline']
                            ); ?>
                        <?php endif; ?>
                        <?= Html::a(
                            Html::img(
                                '/img/roster/questionnaire.png',
                                ['alt' => 'Личные данные', 'title' => 'Личные данные']
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
                        <?= $item->game_home_team_id == $teamId ? 'Д' : 'Г'; ?>
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
                        <?= $item->game_home_team_id == $teamId ? 'Д' : 'Г'; ?>
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
                                    ? 'Ред.'
                                    : 'Отпр.',
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