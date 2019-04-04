<?php

use common\components\ErrorHelper;
use common\components\HockeyHelper;
use common\models\Game;
use common\models\League;
use common\models\User;
use yii\grid\GridView;
use yii\helpers\Html;

/**
 * @var array $groupArray
 * @var array $roundArray
 * @var array $seasonArray
 * @var int $seasonId
 * @var array $stageArray
 * @var int $stageId
 * @var User $user
 */

$user = Yii::$app->user->identity;

?>
<div class="row">
    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
        <h1>
            Лига Чемпионов
        </h1>
    </div>
</div>
<?= Html::beginForm(['champions-league/qualification'], 'get'); ?>
<div class="row margin-top-small">
    <div class="col-lg-3 col-md-3 col-sm-3 col-xs-3"></div>
    <div class="col-lg-3 col-md-3 col-sm-3 col-xs-3 text-right">
        <?= Html::label('Сезон', 'seasonId'); ?>
    </div>
    <div class="col-lg-1 col-md-1 col-sm-1 col-xs-2">
        <?= Html::dropDownList(
            'seasonId',
            $seasonId,
            $seasonArray,
            ['class' => 'form-control submit-on-change', 'id' => 'seasonId']
        ); ?>
    </div>
    <div class="col-lg-5 col-md-5 col-sm-5 col-xs-4"></div>
</div>
<?= Html::endForm(); ?>
<div class="row">
    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
        <p class="text-justify">
            Лига чемпионов - самый престижный клубный турнир Лиги, куда попадают лучшие команды предыдущего сезона.
            Число мест в розыгрыше от каждой федерации и стартовый этап для каждой команды определяется согласно
            клубному рейтингу стран.
            В турнире есть отборочные раунды, групповой двухкруговой турнир, раунды плей-офф и финал.
        </p>
    </div>
</div>
<div class="row">
    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 text-center">
        <?= $this->render('//champions-league/_round-links', ['roundArray' => $roundArray]); ?>
    </div>
</div>
<?= Html::beginForm(
    ['champions-league/table', 'seasonId' => $seasonId],
    'get'
); ?>
<div class="row margin-top-small">
    <div class="col-lg-3 col-md-3 col-sm-3 col-xs-3"></div>
    <div class="col-lg-3 col-md-3 col-sm-3 col-xs-3 text-right">
        <?= Html::label('Тур', 'stageId'); ?>
    </div>
    <div class="col-lg-1 col-md-1 col-sm-1 col-xs-2">
        <?= Html::dropDownList(
            'stageId',
            $stageId,
            $stageArray,
            ['class' => 'form-control submit-on-change', 'id' => 'stageId']
        ); ?>
    </div>
    <div class="col-lg-5 col-md-5 col-sm-5 col-xs-4"></div>
</div>
<?= Html::endForm(); ?>
<?php foreach ($groupArray as $groupNumber => $groupData) : ?>
    <div class="row margin-top-small">
        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
            <p class="text-center strong">
                Группа <?= $groupData['name']; ?>
            </p>
        </div>
    </div>
    <div class="row">
        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 table-responsive">
            <table class="table">
                <?php foreach ($groupData['game'] as $item) : ?>
                    <?php /** @var Game $item */ ?>
                    <tr>
                        <td class="text-right col-45">
                            <?= $item->teamHome->teamLink('img'); ?>
                            <?= HockeyHelper::formatAuto($item->game_home_auto); ?>
                        </td>
                        <td class="text-center col-10">
                            <?= Html::a(
                                $item->formatScore(),
                                ['game/view', 'id' => $item->game_id]
                            ); ?>
                        </td>
                        <td>
                            <?= $item->teamGuest->teamLink('img'); ?>
                            <?= HockeyHelper::formatAuto($item->game_guest_auto); ?>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </table>
        </div>
    </div>
    <div class="row margin-top-small">
        <?php

        try {
            $columns = [
                [
                    'contentOptions' => ['class' => 'text-center'],
                    'footer' => 'М',
                    'footerOptions' => ['title' => 'Место'],
                    'header' => 'М',
                    'headerOptions' => ['class' => 'col-5', 'title' => 'Место'],
                    'value' => function (League $model) {
                        return $model->league_place;
                    }
                ],
                [
                    'footer' => 'Команда',
                    'format' => 'raw',
                    'header' => 'Команда',
                    'value' => function (League $model) {
                        return $model->team->iconFreeTeam() . $model->team->teamLink('img');
                    }
                ],
                [
                    'contentOptions' => ['class' => 'hidden-xs text-center'],
                    'footer' => 'И',
                    'footerOptions' => ['class' => 'hidden-xs', 'title' => 'Игры'],
                    'header' => 'И',
                    'headerOptions' => ['class' => 'col-5 hidden-xs', 'title' => 'Игры'],
                    'value' => function (League $model) {
                        return $model->league_game;
                    }
                ],
                [
                    'contentOptions' => ['class' => 'text-center'],
                    'footer' => 'B',
                    'footerOptions' => ['title' => 'Победы'],
                    'header' => 'B',
                    'headerOptions' => ['class' => 'col-5', 'title' => 'Победы'],
                    'value' => function (League $model) {
                        return $model->league_win;
                    }
                ],
                [
                    'contentOptions' => ['class' => 'text-center'],
                    'footer' => 'ВО',
                    'footerOptions' => ['title' => 'Победы в овертайте'],
                    'header' => 'ВО',
                    'headerOptions' => ['class' => 'col-5', 'title' => 'Победы в овертайте'],
                    'value' => function (League $model) {
                        return $model->league_win_overtime;
                    }
                ],
                [
                    'contentOptions' => ['class' => 'text-center'],
                    'footer' => 'ВБ',
                    'footerOptions' => ['title' => 'Победы по буллитам'],
                    'header' => 'ВБ',
                    'headerOptions' => ['class' => 'col-5', 'title' => 'Победы по буллитам'],
                    'value' => function (League $model) {
                        return $model->league_win_shootout;
                    }
                ],
                [
                    'contentOptions' => ['class' => 'text-center'],
                    'footer' => 'ПБ',
                    'footerOptions' => ['title' => 'Поражения по буллитам'],
                    'header' => 'ПБ',
                    'headerOptions' => ['class' => 'col-5', 'title' => 'Поражения по буллитам'],
                    'value' => function (League $model) {
                        return $model->league_loose_shootout;
                    }
                ],
                [
                    'contentOptions' => ['class' => 'text-center'],
                    'footer' => 'ПО',
                    'footerOptions' => ['title' => 'Поражения в овертайте'],
                    'header' => 'ПО',
                    'headerOptions' => ['class' => 'col-5', 'title' => 'Поражения в овертайте'],
                    'value' => function (League $model) {
                        return $model->league_loose_overtime;
                    }
                ],
                [
                    'contentOptions' => ['class' => 'text-center'],
                    'footer' => 'П',
                    'footerOptions' => ['title' => 'Поражения'],
                    'header' => 'П',
                    'headerOptions' => ['class' => 'col-5', 'title' => 'Поражения'],
                    'value' => function (League $model) {
                        return $model->league_loose;
                    }
                ],
                [
                    'contentOptions' => ['class' => 'col-5 hidden-xs text-center'],
                    'footer' => 'ЗШ',
                    'footerOptions' => ['class' => 'hidden-xs', 'title' => 'Заброшенные шайбы'],
                    'headerOptions' => ['class' => 'hidden-xs', 'title' => 'Заброшенные шайбы'],
                    'label' => 'ЗШ',
                    'value' => function (League $model) {
                        return $model->league_score;
                    }
                ],
                [
                    'contentOptions' => ['class' => 'col-5 hidden-xs text-center'],
                    'footer' => 'ПШ',
                    'footerOptions' => ['class' => 'hidden-xs', 'title' => 'Пропущенные шайбы'],
                    'headerOptions' => ['class' => 'hidden-xs', 'title' => 'Пропущенные шайбы'],
                    'label' => 'ПШ',
                    'value' => function (League $model) {
                        return $model->league_pass;
                    }
                ],
                [
                    'contentOptions' => ['class' => 'text-center'],
                    'footer' => 'О',
                    'footerOptions' => ['title' => 'Очки'],
                    'header' => 'О',
                    'headerOptions' => ['class' => 'col-5', 'title' => 'Очки'],
                    'value' => function (League $model) {
                        return $model->league_point;
                    }
                ],
                [
                    'contentOptions' => ['class' => 'text-center'],
                    'footer' => 'Vs',
                    'footerOptions' => ['title' => 'Рейтинг силы команды'],
                    'header' => 'Vs',
                    'headerOptions' => ['class' => 'col-5', 'title' => 'Рейтинг силы команды'],
                    'value' => function (League $model) {
                        return $model->team->team_power_vs;
                    },
                    'visible' => $user && $user->isVip(),
                ],
            ];
            print GridView::widget([
                'columns' => $columns,
                'dataProvider' => $groupData['team'],
                'rowOptions' => function (League $model) {
                    $class = '';
                    $title = '';
                    if ($model->league_place <= 2) {
                        $class = 'tournament-table-up';
                        $title = 'Зона плей-офф';
                    }
                    return ['class' => $class, 'title' => $title];
                },
                'showFooter' => true,
                'summary' => false,
            ]);
        } catch (Exception $e) {
            ErrorHelper::log($e);
        }

        ?>
    </div>
    <?= $this->render('//site/_show-full-table'); ?>
<?php endforeach; ?>
<div class="row">
    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 text-center">
        <p>
            <?= Html::a(
                'Статистика',
                [
                    'champions-league/statistics',
                    'seasonId' => $seasonId,
                ],
                ['class' => 'btn margin']
            ); ?>
        </p>
    </div>
</div>
