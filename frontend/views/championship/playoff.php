<?php

use common\components\ErrorHelper;
use common\models\Championship;
use yii\grid\GridView;

/**
 * @var \yii\data\ActiveDataProvider $dataProvider
 * @var \common\models\User $user ;
 */

$user = Yii::$app->user->identity;

?>
<div class="row">
    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
        <h1>Национальный чемпионат</h1>
    </div>
</div>
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
    <?php

    try {
        $columns = [
            [
                'contentOptions' => ['class' => 'text-center'],
                'footer' => 'М',
                'footerOptions' => ['title' => 'Место'],
                'header' => 'М',
                'headerOptions' => ['class' => 'col-5', 'title' => 'Место'],
                'value' => function (Championship $model): string {
                    return $model->championship_place;
                }
            ],
            [
                'footer' => 'Команда',
                'format' => 'raw',
                'header' => 'Команда',
                'value' => function (Championship $model): string {
                    return $model->team->teamLink('string', true);
                }
            ],
            [
                'contentOptions' => ['class' => 'hidden-xs text-center'],
                'footer' => 'И',
                'footerOptions' => ['class' => 'hidden-xs', 'title' => 'Игры'],
                'header' => 'И',
                'headerOptions' => ['class' => 'col-5 hidden-xs', 'title' => 'Игры'],
                'value' => function (Championship $model): string {
                    return $model->championship_game;
                }
            ],
            [
                'contentOptions' => ['class' => 'text-center'],
                'footer' => 'B',
                'footerOptions' => ['title' => 'Победы'],
                'header' => 'B',
                'headerOptions' => ['class' => 'col-5', 'title' => 'Победы'],
                'value' => function (Championship $model): string {
                    return $model->championship_win;
                }
            ],
            [
                'contentOptions' => ['class' => 'text-center'],
                'footer' => 'ВО',
                'footerOptions' => ['title' => 'Победы в овертайте'],
                'header' => 'ВО',
                'headerOptions' => ['class' => 'col-5', 'title' => 'Победы в овертайте'],
                'value' => function (Championship $model): string {
                    return $model->championship_win_overtime;
                }
            ],
            [
                'contentOptions' => ['class' => 'text-center'],
                'footer' => 'ВБ',
                'footerOptions' => ['title' => 'Победы по буллитам'],
                'header' => 'ВБ',
                'headerOptions' => ['class' => 'col-5', 'title' => 'Победы по буллитам'],
                'value' => function (Championship $model): string {
                    return $model->championship_win_shootout;
                }
            ],
            [
                'contentOptions' => ['class' => 'text-center'],
                'footer' => 'ПБ',
                'footerOptions' => ['title' => 'Поражения по буллитам'],
                'header' => 'ПБ',
                'headerOptions' => ['class' => 'col-5', 'title' => 'Поражения по буллитам'],
                'value' => function (Championship $model): string {
                    return $model->championship_loose_shootout;
                }
            ],
            [
                'contentOptions' => ['class' => 'text-center'],
                'footer' => 'ПО',
                'footerOptions' => ['title' => 'Поражения в овертайте'],
                'header' => 'ПО',
                'headerOptions' => ['class' => 'col-5', 'title' => 'Поражения в овертайте'],
                'value' => function (Championship $model): string {
                    return $model->championship_loose_overtime;
                }
            ],
            [
                'contentOptions' => ['class' => 'text-center'],
                'footer' => 'П',
                'footerOptions' => ['title' => 'Поражения'],
                'header' => 'П',
                'headerOptions' => ['class' => 'col-5', 'title' => 'Поражения'],
                'value' => function (Championship $model): string {
                    return $model->championship_loose;
                }
            ],
            [
                'contentOptions' => ['class' => 'col-5 hidden-xs text-center'],
                'footer' => 'Ш',
                'footerOptions' => ['class' => 'hidden-xs', 'colspan' => 2, 'title' => 'Шайбы'],
                'header' => 'Ш',
                'headerOptions' => ['class' => 'hidden-xs', 'colspan' => 2, 'title' => 'Шайбы'],
                'value' => function (Championship $model): string {
                    return $model->championship_score;
                }
            ],
            [
                'contentOptions' => ['class' => 'col-5 hidden-xs text-center'],
                'footer' => 'Ш',
                'footerOptions' => ['style' => ['display' => 'none']],
                'header' => 'Ш',
                'headerOptions' => ['style' => ['display' => 'none']],
                'value' => function (Championship $model): string {
                    return $model->championship_pass;
                }
            ],
            [
                'contentOptions' => ['class' => 'text-center'],
                'footer' => 'О',
                'footerOptions' => ['title' => 'Очки'],
                'header' => 'О',
                'headerOptions' => ['class' => 'col-5', 'title' => 'Очки'],
                'value' => function (Championship $model): string {
                    return $model->championship_point;
                }
            ],
            [
                'contentOptions' => ['class' => 'text-center'],
                'footer' => 'Vs',
                'footerOptions' => ['title' => 'Рейтинг силы команды'],
                'header' => 'Vs',
                'headerOptions' => ['class' => 'col-5', 'title' => 'Рейтинг силы команды'],
                'value' => function (Championship $model): string {
                    return $model->team->team_power_vs;
                },
                'visible' => $user->isVip(),
            ],
        ];
        print GridView::widget([
            'columns' => $columns,
            'dataProvider' => $dataProvider,
            'showFooter' => true,
            'showOnEmpty' => false,
            'summary' => false,
        ]);
    } catch (Exception $e) {
        ErrorHelper::log($e);
    }

    ?>
</div>
<?= $this->render('/site/_show-full-table'); ?>
