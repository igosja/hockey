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
            <?= $this->render('//team/_team-top-left', ['team' => $team, 'teamId' => $team->team_id]); ?>
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
                                ['lineup/view', 'id' => $item->game_id]
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