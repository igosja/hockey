<?php

use common\components\ErrorHelper;
use common\models\Game;
use common\models\RosterPhrase;
use common\models\Team;
use yii\helpers\Html;

$teamId = Yii::$app->request->get('id', 1);

$team = Team::find()
    ->where(['team_id' => $teamId])
    ->limit(1)
    ->one();

$latest = Game::find()
    ->joinWith(['schedule'])
    ->where(['or', ['game_home_team_id' => $teamId], ['game_guest_team_id' => $teamId]])
    ->andWhere(['game_played' => 1])
    ->orderBy(['schedule_date' => SORT_DESC])
    ->limit(3)
    ->all();

$nearest = Game::find()
    ->joinWith(['schedule'])
    ->where(['or', ['game_home_team_id' => $teamId], ['game_guest_team_id' => $teamId]])
    ->andWhere(['game_played' => 0])
    ->orderBy(['schedule_date' => SORT_ASC])
    ->limit(2)
    ->all();

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
                            Division: <?= $team->division(); ?>
                        </div>
                    </div>
                    <div class="row margin-top-small">
                        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                            Manager:
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
                            Nick:
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
                                Vice:
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
                                Nick:
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
                            Stadium:
                            <?= $team->stadium->stadium_name; ?>,
                            <strong><?= Yii::$app->formatter->asInteger($team->stadium->stadium_capacity); ?></strong>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                            Base: <span class="strong"><?= $team->base->base_level; ?></span> level
                            (<span class="strong"><?= $team->baseUsed(); ?></span>
                            of
                            <span class="strong"><?= $team->base->base_slot_max; ?></span> slots)
                        </div>
                    </div>
                    <div class="row margin-top-small">
                        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                            Finances:
                            <span class="strong">
                                <?php

                                try {
                                    print Yii::$app->formatter->asCurrency($team->team_finance);
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
                <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                    <?php if (Yii::$app->user->isGuest) : ?>
                        <?= Html::a(
                            Html::img(
                                '/img/roster/questionnaire.png',
                                ['alt' => 'Sign Up', 'title' => 'Sign Up']
                            ),
                            ['site/sign-up'],
                            ['class' => 'no-underline']
                        ); ?>
                    <?php else : ?>
                        <?= Html::a(
                            Html::img(
                                '/img/roster/friendly.png',
                                ['alt' => 'Организовать товарищеский матч', 'title' => 'Personal data']
                            ),
                            ['friendly/index'],
                            ['class' => 'no-underline']
                        ); ?>
                        <?= Html::a(
                            Html::img(
                                '/img/roster/training.png',
                                ['alt' => 'Тренировка хоккеистов', 'title' => 'Personal data']
                            ),
                            ['training/index'],
                            ['class' => 'no-underline']
                        ); ?>
                        <?= Html::a(
                            Html::img(
                                '/img/roster/scout.png',
                                ['alt' => 'Изучение хоккеистов', 'title' => 'Personal data']
                            ),
                            ['scout/index'],
                            ['class' => 'no-underline']
                        ); ?>
                        <?= Html::a(
                            Html::img(
                                '/img/roster/physical.png',
                                ['alt' => 'Изменение физической формы', 'title' => 'Personal data']
                            ),
                            ['physical/index'],
                            ['class' => 'no-underline']
                        ); ?>
                        <?= Html::a(
                            Html::img(
                                '/img/roster/school.png',
                                ['alt' => 'Подготовка молодёжи', 'title' => 'Personal data']
                            ),
                            ['school/index'],
                            ['class' => 'no-underline']
                        ); ?>
                        <?= Html::a(
                            Html::img(
                                '/img/roster/free-team.png',
                                ['alt' => 'Подать заявку на получение команды', 'title' => 'Personal data']
                            ),
                            ['change'],
                            ['class' => 'no-underline']
                        ); ?>
                        <?= Html::a(
                            Html::img(
                                '/img/roster/questionnaire.png',
                                ['alt' => 'Personal data', 'title' => 'Personal data']
                            ),
                            ['user/questionnaire'],
                            ['class' => 'no-underline']
                        ); ?>
                    <?php endif; ?>
                </div>
                <?php foreach ($latest as $item) { ?>
                    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 text-size-3 italic">
                        <?php

                        try {
                            print Yii::$app->formatter->asDatetime($item->schedule->schedule_date);
                        } catch (Exception $e) {
                            ErrorHelper::log($e);
                        }

                        ?>
                        -
                        <?= $item->schedule->tournamentType->tournament_type_name; ?>
                        -
                        H/G
                        -
                        <?= Html::a(
                            $item->teamHome->team_name,
                            ['team/view', 'id' => $item->teamHome->team_id]
                        ); ?>
                        -
                        <?= Html::a(
                            $item->game_home_score . ':' . $item->game_guest_score,
                            ['game/view', 'id' => $item->game_id]
                        ); ?>
                    </div>
                <?php } ?>
                <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                    <div class="row text-size-4">&nbsp;</div>
                </div>
                <?php foreach ($nearest as $item) { ?>
                    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 text-size-3 italic">
                        <?php

                        try {
                            print Yii::$app->formatter->asDatetime($item->schedule->schedule_date);
                        } catch (Exception $e) {
                            ErrorHelper::log($e);
                        }

                        ?>
                        -
                        <?= $item->schedule->tournamentType->tournament_type_name; ?>
                        -
                        H/G
                        -
                        <?= Html::a(
                            $item->teamHome->team_name,
                            ['team/view', 'id' => $item->teamHome->team_id]
                        ); ?>
                        -
                        <?= Html::a(
                            'Send',
                            ['lineup/index', 'id' => $item->game_id]
                        ); ?>
                        <?= Html::a(
                            '?:?',
                            ['game/preview', 'id' => $item->game_id]
                        ); ?>
                    </div>
                <?php } ?>
            </div>
        </div>
    </div>
<?php if ($notification_array = []) { ?>
    <div class="row margin-top">
        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
            <ul>
                <?php foreach ($notification_array as $item) { ?>
                    <li><?= $item; ?></li>
                <?php } ?>
            </ul>
        </div>
    </div>
<?php } ?>