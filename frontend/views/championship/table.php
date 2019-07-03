<?php

use common\components\ErrorHelper;
use common\components\HockeyHelper;
use common\models\Championship;
use common\models\Country;
use common\models\Game;
use common\models\Review;
use common\models\User;
use yii\data\ActiveDataProvider;
use yii\grid\GridView;
use yii\helpers\Html;

/**
 * @var Country $country
 * @var ActiveDataProvider $dataProvider
 * @var array $divisionArray
 * @var int $divisionId
 * @var Game[] $gameArray
 * @var Review[] $reviewArray
 * @var bool $reviewCreate
 * @var array $roundArray
 * @var array $scheduleId
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
            <?= Html::a(
                $country->country_name,
                ['country/news', 'id' => $country->country_id],
                ['class' => 'country-header-link']
            ); ?>
        </h1>
    </div>
</div>
<div class="row">
    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 text-center">
        <?= $this->render('//championship/_division-links', ['divisionArray' => $divisionArray]); ?>
    </div>
</div>
<?= Html::beginForm(['championship/index'], 'get'); ?>
<?= Html::hiddenInput('divisionId', $divisionId); ?>
<?= Html::hiddenInput('countryId', $country->country_id); ?>
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
            Чемпионаты стран - это основные турниры в Лиге.
            В каждой из стран, где зарегистрированы 16 или более клубов, проводятся национальные чемпионаты.
            Все команды, которые были созданы на момент старта очередных чемпионатов, принимают в них участие.
            Национальные чемпионаты проводятся один раз в сезон.
        </p>
        <p>
            В одном национальном чемпионате может быть несколько дивизионов, в зависимости от числа команд в стране.
            Победители низших дивизионов получают право в следующем сезоне играть в более высоком дивизионе.
            Проигравшие вылетают в более низкий дивизион.
        </p>
    </div>
</div>
<div class="row">
    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 text-center">
        <?= $this->render('//championship/_round-links', ['roundArray' => $roundArray]); ?>
    </div>
</div>
<?= Html::beginForm(
    ['championship/table', 'countryId' => $country->country_id, 'seasonId' => $seasonId, 'divisionId' => $divisionId],
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
                        <?= $item->teamHome->teamLink('string', true); ?>
                        <?= HockeyHelper::formatAuto($item->game_home_auto); ?>
                    </td>
                    <td class="text-center col-10">
                        <?= Html::a(
                            $item->formatScore(),
                            ['game/view', 'id' => $item->game_id]
                        ); ?>
                    </td>
                    <td>
                        <?= $item->teamGuest->teamLink('string', true); ?>
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
                'value' => function (Championship $model) {
                    return $model->championship_place;
                }
            ],
            [
                'footer' => 'Команда',
                'format' => 'raw',
                'header' => 'Команда',
                'value' => function (Championship $model) {
                    return $model->team->iconFreeTeam() . $model->team->teamLink('string', true);
                }
            ],
            [
                'contentOptions' => ['class' => 'hidden-xs text-center'],
                'footer' => 'И',
                'footerOptions' => ['class' => 'hidden-xs', 'title' => 'Игры'],
                'header' => 'И',
                'headerOptions' => ['class' => 'col-5 hidden-xs', 'title' => 'Игры'],
                'value' => function (Championship $model) {
                    return $model->championship_game;
                }
            ],
            [
                'contentOptions' => ['class' => 'text-center'],
                'footer' => 'B',
                'footerOptions' => ['title' => 'Победы'],
                'header' => 'B',
                'headerOptions' => ['class' => 'col-5', 'title' => 'Победы'],
                'value' => function (Championship $model) {
                    return $model->championship_win;
                }
            ],
            [
                'contentOptions' => ['class' => 'text-center'],
                'footer' => 'ВО',
                'footerOptions' => ['title' => 'Победы в овертайте'],
                'header' => 'ВО',
                'headerOptions' => ['class' => 'col-5', 'title' => 'Победы в овертайте'],
                'value' => function (Championship $model) {
                    return $model->championship_win_overtime;
                }
            ],
            [
                'contentOptions' => ['class' => 'text-center'],
                'footer' => 'ВБ',
                'footerOptions' => ['title' => 'Победы по буллитам'],
                'header' => 'ВБ',
                'headerOptions' => ['class' => 'col-5', 'title' => 'Победы по буллитам'],
                'value' => function (Championship $model) {
                    return $model->championship_win_shootout;
                }
            ],
            [
                'contentOptions' => ['class' => 'text-center'],
                'footer' => 'ПБ',
                'footerOptions' => ['title' => 'Поражения по буллитам'],
                'header' => 'ПБ',
                'headerOptions' => ['class' => 'col-5', 'title' => 'Поражения по буллитам'],
                'value' => function (Championship $model) {
                    return $model->championship_loose_shootout;
                }
            ],
            [
                'contentOptions' => ['class' => 'text-center'],
                'footer' => 'ПО',
                'footerOptions' => ['title' => 'Поражения в овертайте'],
                'header' => 'ПО',
                'headerOptions' => ['class' => 'col-5', 'title' => 'Поражения в овертайте'],
                'value' => function (Championship $model) {
                    return $model->championship_loose_overtime;
                }
            ],
            [
                'contentOptions' => ['class' => 'text-center'],
                'footer' => 'П',
                'footerOptions' => ['title' => 'Поражения'],
                'header' => 'П',
                'headerOptions' => ['class' => 'col-5', 'title' => 'Поражения'],
                'value' => function (Championship $model) {
                    return $model->championship_loose;
                }
            ],
            [
                'contentOptions' => ['class' => 'hidden-xs text-center'],
                'footer' => 'ЗШ',
                'footerOptions' => ['class' => 'hidden-xs', 'title' => 'Заброшенные шайбы'],
                'headerOptions' => ['class' => 'col-5 hidden-xs', 'title' => 'Заброшенные шайбы'],
                'label' => 'ЗШ',
                'value' => function (Championship $model) {
                    return $model->championship_score;
                }
            ],
            [
                'contentOptions' => ['class' => 'hidden-xs text-center'],
                'footer' => 'ПШ',
                'footerOptions' => ['class' => 'hidden-xs', 'title' => 'Пропущенные шайбы'],
                'headerOptions' => ['class' => 'col-5 hidden-xs', 'title' => 'Пропущенные шайбы'],
                'label' => 'ПШ',
                'value' => function (Championship $model) {
                    return $model->championship_pass;
                }
            ],
            [
                'contentOptions' => ['class' => 'text-center'],
                'footer' => 'О',
                'footerOptions' => ['title' => 'Очки'],
                'header' => 'О',
                'headerOptions' => ['class' => 'col-5', 'title' => 'Очки'],
                'value' => function (Championship $model) {
                    return $model->championship_point;
                }
            ],
            [
                'contentOptions' => ['class' => 'hidden-xs text-center'],
                'footer' => 'Ф',
                'footerOptions' => ['class' => 'hidden-xs', 'title' => 'Форма'],
                'format' => 'raw',
                'header' => 'Ф',
                'headerOptions' => ['class' => 'col-3 hidden-xs', 'title' => 'Форма'],
                'value' => function (Championship $model): string {
                    return $model->lastGamesShape();
                }
            ],
            [
                'contentOptions' => ['class' => 'text-center'],
                'footer' => 'Vs',
                'footerOptions' => ['title' => 'Рейтинг силы команды'],
                'header' => 'Vs',
                'headerOptions' => ['class' => 'col-5', 'title' => 'Рейтинг силы команды'],
                'value' => function (Championship $model) {
                    return $model->team->team_power_vs;
                },
                'visible' => $user && $user->isVip(),
            ],
        ];
        print GridView::widget([
            'columns' => $columns,
            'dataProvider' => $dataProvider,
            'rowOptions' => function (Championship $model) {
                $class = '';
                $title = '';
                if ($model->championship_place <= 8) {
                    $class = 'tournament-table-up';
                    $title = 'Зона плей-офф';
                } elseif ($model->championship_place >= 15) {
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
<?php if ($reviewArray) : ?>
    <div class="row">
        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 strong margin-top text-center">
            Обзоры:
        </div>
    </div>
    <?php foreach ($reviewArray as $review) : ?>
        <div class="row">
            <div class="col-lg-3 col-md-3 col-sm-2 col-xs-1"></div>
            <div class="col-lg-9 col-md-9 col-sm-10 col-xs-11">
                <?= $review->stage->stage_name; ?> -
                <?= Html::a($review->review_title, ['review/view', 'id' => $review->review_id]); ?>
                -
                <?= $review->user->userLink(); ?>
            </div>
        </div>
    <?php endforeach; ?>
<?php endif; ?>
<div class="row">
    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 text-center">
        <p>
            <?= Html::a(
                'Статистика',
                [
                    'championship/statistics',
                    'countryId' => $country->country_id,
                    'divisionId' => $divisionId,
                    'roundId' => 1,
                    'seasonId' => $seasonId,
                ],
                ['class' => 'btn margin']
            ); ?>
            <?php if ($reviewCreate) : ?>
                <?= Html::a(
                    'Написать обзор',
                    [
                        'review/create',
                        'countryId' => $country->country_id,
                        'divisionId' => $divisionId,
                        'scheduleId' => $scheduleId,
                        'seasonId' => $seasonId,
                    ],
                    ['class' => 'btn margin', 'target' => '_blank']
                ); ?>
            <?php endif; ?>
        </p>
    </div>
</div>
