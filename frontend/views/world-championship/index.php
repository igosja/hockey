<?php

use common\components\ErrorHelper;
use common\components\HockeyHelper;
use common\models\Division;
use common\models\Game;
use common\models\TournamentType;
use common\models\User;
use common\models\WorldCup;
use yii\data\ActiveDataProvider;
use yii\grid\GridView;
use yii\helpers\Html;

/**
 * @var ActiveDataProvider $dataProvider
 * @var array $divisionArray
 * @var int $divisionId
 * @var Game[] $gameArray
 * @var array $nationalTypeArray
 * @var int $nationalTypeId
 * @var array $seasonArray
 * @var int $seasonId
 * @var array $stageArray
 * @var int $stageId
 * @var User $user
 */

$user = Yii::$app->user->identity;

?>
<div class="row">
    <div class="col-lg-3 col-md-3 col-sm-3 col-xs-3">
        <?= Html::img(
            '/img/tournament_type/' . TournamentType::NATIONAL . '.png',
            [
                'alt' => 'Чемпионат мира среди сборных',
                'title' => 'Чемпионат мира среди сборных',
            ]
        ); ?>
    </div>
    <div class="col-lg-9 col-md-9 col-sm-9 col-xs-12">
        <div class="row">
            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                <h1>
                    Чемпионат мира среди сборных
                </h1>
            </div>
        </div>
        <div class="row">
            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 text-center">
                <?= $this->render('//world-championship/_national-type-links', ['nationalTypeArray' => $nationalTypeArray]); ?>
            </div>
        </div>
        <div class="row">
            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 text-center">
                <?= $this->render('//world-championship/_division-links', ['divisionArray' => $divisionArray]); ?>
            </div>
        </div>
        <?= Html::beginForm(['world-championship/index'], 'get'); ?>
        <?= Html::hiddenInput('divisionId', $divisionId); ?>
        <?= Html::hiddenInput('nationalTypeId', $nationalTypeId); ?>
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
                    Чемпионат мира - это главный турнир для сборных в Лиге.
                    Чемпионат мира проводится один раз в сезон.
                </p>
                <p>
                    В чемпионате мира может быть несколько дивизионов, в зависимости от числа стран в Лиге.
                    Победители низших дивизионов получают право в следующем сезоне играть в более высоком дивизионе.
                    Проигравшие вылетают в более низкий дивизион.
                </p>
            </div>
        </div>
    </div>
</div>
<?= Html::beginForm(
    ['world-championship/index', 'seasonId' => $seasonId, 'divisionId' => $divisionId, 'nationalTypeId' => $nationalTypeId],
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
<div class="row margin-top-small">
    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 table-responsive">
        <table class="table">
            <?php foreach ($gameArray as $item) { ?>
                <tr>
                    <td class="text-right col-45">
                        <?= $item->nationalHome->nationalLink(); ?>
                        <?= HockeyHelper::formatAuto($item->game_home_auto); ?>
                    </td>
                    <td class="text-center col-10">
                        <?= Html::a(
                            $item->formatScore(),
                            ['game/view', 'id' => $item->game_id]
                        ); ?>
                    </td>
                    <td>
                        <?= $item->nationalGuest->nationalLink(); ?>
                        <?= HockeyHelper::formatAuto($item->game_guest_auto); ?>
                    </td>
                </tr>
            <?php } ?>
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
                'value' => function (WorldCup $model) {
                    return $model->world_cup_place;
                }
            ],
            [
                'footer' => 'Команда',
                'format' => 'raw',
                'header' => 'Команда',
                'value' => function (WorldCup $model) {
                    return $model->national->nationalLink(true);
                }
            ],
            [
                'contentOptions' => ['class' => 'hidden-xs text-center'],
                'footer' => 'И',
                'footerOptions' => ['class' => 'hidden-xs', 'title' => 'Игры'],
                'header' => 'И',
                'headerOptions' => ['class' => 'col-5 hidden-xs', 'title' => 'Игры'],
                'value' => function (WorldCup $model) {
                    return $model->world_cup_game;
                }
            ],
            [
                'contentOptions' => ['class' => 'text-center'],
                'footer' => 'B',
                'footerOptions' => ['title' => 'Победы'],
                'header' => 'B',
                'headerOptions' => ['class' => 'col-5', 'title' => 'Победы'],
                'value' => function (WorldCup $model) {
                    return $model->world_cup_win;
                }
            ],
            [
                'contentOptions' => ['class' => 'text-center'],
                'footer' => 'ВО',
                'footerOptions' => ['title' => 'Победы в овертайте'],
                'header' => 'ВО',
                'headerOptions' => ['class' => 'col-5', 'title' => 'Победы в овертайте'],
                'value' => function (WorldCup $model) {
                    return $model->world_cup_win_overtime;
                }
            ],
            [
                'contentOptions' => ['class' => 'text-center'],
                'footer' => 'ВБ',
                'footerOptions' => ['title' => 'Победы по буллитам'],
                'header' => 'ВБ',
                'headerOptions' => ['class' => 'col-5', 'title' => 'Победы по буллитам'],
                'value' => function (WorldCup $model) {
                    return $model->world_cup_win_shootout;
                }
            ],
            [
                'contentOptions' => ['class' => 'text-center'],
                'footer' => 'ПБ',
                'footerOptions' => ['title' => 'Поражения по буллитам'],
                'header' => 'ПБ',
                'headerOptions' => ['class' => 'col-5', 'title' => 'Поражения по буллитам'],
                'value' => function (WorldCup $model) {
                    return $model->world_cup_loose_shootout;
                }
            ],
            [
                'contentOptions' => ['class' => 'text-center'],
                'footer' => 'ПО',
                'footerOptions' => ['title' => 'Поражения в овертайте'],
                'header' => 'ПО',
                'headerOptions' => ['class' => 'col-5', 'title' => 'Поражения в овертайте'],
                'value' => function (WorldCup $model) {
                    return $model->world_cup_loose_overtime;
                }
            ],
            [
                'contentOptions' => ['class' => 'text-center'],
                'footer' => 'П',
                'footerOptions' => ['title' => 'Поражения'],
                'header' => 'П',
                'headerOptions' => ['class' => 'col-5', 'title' => 'Поражения'],
                'value' => function (WorldCup $model) {
                    return $model->world_cup_loose;
                }
            ],
            [
                'contentOptions' => ['class' => 'col-5 hidden-xs text-center'],
                'footer' => 'ЗШ',
                'footerOptions' => ['class' => 'hidden-xs', 'title' => 'Заброшенные шайбы'],
                'headerOptions' => ['class' => 'hidden-xs', 'title' => 'Заброшенные шайбы'],
                'label' => 'ЗШ',
                'value' => function (WorldCup $model) {
                    return $model->world_cup_score;
                }
            ],
            [
                'contentOptions' => ['class' => 'col-5 hidden-xs text-center'],
                'footer' => 'ПШ',
                'footerOptions' => ['class' => 'hidden-xs', 'title' => 'Пропущенные шайбы'],
                'headerOptions' => ['class' => 'hidden-xs', 'title' => 'Пропущенные шайбы'],
                'label' => 'ПШ',
                'value' => function (WorldCup $model) {
                    return $model->world_cup_pass;
                }
            ],
            [
                'contentOptions' => ['class' => 'text-center'],
                'footer' => 'О',
                'footerOptions' => ['title' => 'Очки'],
                'header' => 'О',
                'headerOptions' => ['class' => 'col-5', 'title' => 'Очки'],
                'value' => function (WorldCup $model) {
                    return $model->world_cup_point;
                }
            ],
            [
                'contentOptions' => ['class' => 'hidden-xs text-center'],
                'footer' => 'Ф',
                'footerOptions' => ['class' => 'hidden-xs', 'title' => 'Форма'],
                'format' => 'raw',
                'header' => 'Ф',
                'headerOptions' => ['class' => 'col-3 hidden-xs', 'title' => 'Форма'],
                'value' => function (WorldCup $model): string {
                    return $model->lastGamesShape();
                }
            ],
            [
                'contentOptions' => ['class' => 'text-center'],
                'footer' => 'Vs',
                'footerOptions' => ['title' => 'Рейтинг силы команды'],
                'header' => 'Vs',
                'headerOptions' => ['class' => 'col-5', 'title' => 'Рейтинг силы команды'],
                'value' => function (WorldCup $model) {
                    return $model->national->national_power_vs;
                },
                'visible' => $user && $user->isVip(),
            ],
        ];
        print GridView::widget([
            'columns' => $columns,
            'dataProvider' => $dataProvider,
            'rowOptions' => function (WorldCup $model) {
                $class = '';
                $title = '';
                if ($model->world_cup_place <= 2 && $model->world_cup_division_id > Division::D1) {
                    $class = 'tournament-table-up';
                    $title = 'Зона повышения';
                } elseif ($model->world_cup_place >= 11 && $model->world_cup_division_id < Division::D2) {
                    $class = 'tournament-table-down';
                    $title = 'Зона вылета';
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
<div class="row">
    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 text-center">
        <p>
            <?= Html::a(
                'Статистика',
                [
                    'world-championship/statistics',
                    'divisionId' => $divisionId,
                    'seasonId' => $seasonId,
                ],
                ['class' => 'btn margin']
            ); ?>
        </p>
    </div>
</div>
