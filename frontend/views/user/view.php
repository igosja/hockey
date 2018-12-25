<?php

use common\components\ErrorHelper;
use common\models\Country;
use common\models\History;
use common\models\National;
use common\models\Team;
use common\models\UserRating;
use yii\grid\GridView;
use yii\helpers\Html;

/**
 * @var \yii\data\ActiveDataProvider $countryDataProvider
 * @var \yii\data\ActiveDataProvider $historyDataProvider
 * @var \yii\data\ActiveDataProvider $nationalDataProvider
 * @var \yii\data\ActiveDataProvider $ratingDataProvider
 * @var \yii\data\ActiveDataProvider $teamDataProvider
 * @var UserRating $userRating
 */

print $this->render('_top');

?>
<div class="row margin-top">
    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
        <?= $this->render('_user-links'); ?>
    </div>
</div>
<div class="row">
    <?php

    try {
        $columns = [
            [
                'footer' => 'Роль в игре',
                'label' => 'Роль в игре',
                'value' => function (Country $model): string {
                    $result = $model->country_name . ' ';
                    if (Yii::$app->user->id == $model->country_president_id) {
                        $result = $result . '(Президент федерации)';
                    } else {
                        $result = $result . '(Заместитель президента федерации)';
                    }
                    return $result;
                }
            ],
        ];
        print GridView::widget([
            'columns' => $columns,
            'dataProvider' => $countryDataProvider,
            'showFooter' => true,
            'showOnEmpty' => false,
            'summary' => false,
        ]);
    } catch (Exception $e) {
        ErrorHelper::log($e);
    }

    ?>
</div>
<div class="row">
    <?php

    try {
        $columns = [
            [
                'footer' => 'Команда',
                'format' => 'raw',
                'label' => 'Команда',
                'value' => function (National $model): string {
                    $name = $model->country->country_name . ', ' . $model->nationalType->national_type_name;
                    if (Yii::$app->user->id == $model->national_vice_id) {
                        $name = $name . ' (заместитель)';
                    }
                    return Html::a(
                        $name,
                        ['national/view', 'id' => $model->national_id]
                    );
                }
            ],
            [
                'contentOptions' => ['class' => 'hidden-xs text-center'],
                'footer' => 'Дивизион',
                'footerOptions' => ['class' => 'hidden-xs'],
                'format' => 'raw',
                'headerOptions' => ['class' => 'col-20 hidden-xs'],
                'label' => 'Дивизион',
                'value' => function (National $model): string {
                    return $model->worldCup->division->division_name;
                }
            ],
            [
                'contentOptions' => ['class' => 'text-center'],
                'footer' => 'Vs',
                'footerOptions' => ['title' => 'Рейтинг силы команды в длительных соревнованиях'],
                'headerOptions' => ['class' => 'col-10', 'title' => 'Рейтинг силы команды в длительных соревнованиях'],
                'label' => 'Vs',
                'value' => function (National $model): string {
                    return $model->national_power_vs;
                }
            ],
        ];
        print GridView::widget([
            'columns' => $columns,
            'dataProvider' => $nationalDataProvider,
            'showFooter' => true,
            'showOnEmpty' => false,
            'summary' => false,
        ]);
    } catch (Exception $e) {
        ErrorHelper::log($e);
    }

    ?>
</div>
<div class="row">
    <?php

    try {
        $columns = [
            [
                'footer' => 'Команда',
                'format' => 'raw',
                'label' => 'Команда',
                'value' => function (Team $model): string {
                    return $model->teamLink('img');
                }
            ],
            [
                'contentOptions' => ['class' => 'hidden-xs text-center'],
                'footer' => 'Дивизион',
                'footerOptions' => ['class' => 'hidden-xs'],
                'format' => 'raw',
                'headerOptions' => ['class' => 'col-20 hidden-xs'],
                'label' => 'Дивизион',
                'value' => function (Team $model): string {
                    return $model->division();
                }
            ],
            [
                'contentOptions' => ['class' => 'text-center'],
                'footer' => 'Vs',
                'footerOptions' => ['title' => 'Рейтинг силы команды в длительных соревнованиях'],
                'headerOptions' => ['class' => 'col-10', 'title' => 'Рейтинг силы команды в длительных соревнованиях'],
                'label' => 'Vs',
                'value' => function (Team $model): string {
                    return $model->team_power_vs;
                }
            ],
            [
                'contentOptions' => ['class' => 'hidden-xs text-right'],
                'footer' => 'Стоимость',
                'footerOptions' => ['class' => 'hidden-xs'],
                'headerOptions' => ['class' => 'col-20 hidden-xs'],
                'label' => 'Стоимость',
                'value' => function (Team $model): string {
                    return Yii::$app->formatter->asCurrency($model->team_price_total, 'USD');
                }
            ],
        ];
        print GridView::widget([
            'columns' => $columns,
            'dataProvider' => $teamDataProvider,
            'showFooter' => true,
            'showOnEmpty' => false,
            'summary' => false,
        ]);
    } catch (Exception $e) {
        ErrorHelper::log($e);
    }

    ?>
</div>
<?php if (Yii::$app->user->id == Yii::$app->request->get('id')) : ?>
<div class="row">
    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
        <a href="javascript:">Перерегистрировать команду</a>
        |
        <a href="javascript:">Отказаться от команды</a>
    </div>
</div>
<?php endif; ?>
<div class="row margin-top-small">
    <?php

    try {
        $columns = [
            [
                'contentOptions' => ['class' => 'text-center'],
                'footer' => 'C',
                'footerOptions' => ['title' => 'Сезон'],
                'headerOptions' => ['class' => 'col-3', 'title' => 'Сезон'],
                'label' => 'C',
                'value' => function (UserRating $model): string {
                    return $model->user_rating_season_id;
                }
            ],
            [
                'contentOptions' => ['class' => 'text-center'],
                'footer' => $userRating->user_rating_rating,
                'label' => 'Рейтинг',
                'value' => function (UserRating $model): string {
                    return $model->user_rating_rating;
                }
            ],
            [
                'contentOptions' => ['class' => 'text-center'],
                'footer' => $userRating->user_rating_game,
                'footerOptions' => ['title' => 'Игры'],
                'headerOptions' => ['class' => 'col-3-5', 'title' => 'Игры'],
                'label' => 'И',
                'value' => function (UserRating $model): string {
                    return $model->user_rating_game;
                }
            ],
            [
                'contentOptions' => ['class' => 'text-center'],
                'footer' => $userRating->user_rating_win,
                'footerOptions' => ['title' => 'Победы'],
                'headerOptions' => ['class' => 'col-3-5', 'title' => 'Победы'],
                'label' => 'B',
                'value' => function (UserRating $model): string {
                    return $model->user_rating_win;
                }
            ],
            [
                'contentOptions' => ['class' => 'text-center'],
                'footer' => $userRating->user_rating_win_overtime,
                'footerOptions' => ['title' => 'Победы в овертайме/по буллитам'],
                'headerOptions' => ['class' => 'col-3-5', 'title' => 'Победы в овертайме/по буллитам'],
                'label' => 'BО',
                'value' => function (UserRating $model): string {
                    return $model->user_rating_win_overtime;
                }
            ],
            [
                'contentOptions' => ['class' => 'text-center'],
                'footer' => $userRating->user_rating_loose_overtime,
                'footerOptions' => ['title' => 'Поражения в овертайме/по буллитам/ничьи'],
                'headerOptions' => ['class' => 'col-3-5', 'title' => 'Поражения в овертайме/по буллитам/ничьи'],
                'label' => 'ПО',
                'value' => function (UserRating $model): string {
                    return $model->user_rating_loose_overtime;
                }
            ],
            [
                'contentOptions' => ['class' => 'text-center'],
                'footer' => $userRating->user_rating_loose,
                'footerOptions' => ['title' => 'Поражения'],
                'headerOptions' => ['class' => 'col-3-5', 'title' => 'Поражения'],
                'label' => 'П',
                'value' => function (UserRating $model): string {
                    return $model->user_rating_loose;
                }
            ],
            [
                'contentOptions' => ['class' => 'hidden-xs text-center'],
                'footer' => $userRating->user_rating_collision_win,
                'footerOptions' => ['class' => 'hidden-xs', 'title' => 'Выигранные коллизии'],
                'headerOptions' => ['class' => 'col-3-5 hidden-xs', 'title' => 'Выигранные коллизии'],
                'label' => 'К+',
                'value' => function (UserRating $model): string {
                    return $model->user_rating_collision_win;
                }
            ],
            [
                'contentOptions' => ['class' => 'hidden-xs text-center'],
                'footer' => $userRating->user_rating_collision_loose,
                'footerOptions' => ['class' => 'hidden-xs', 'title' => 'Проигранные коллизии'],
                'headerOptions' => ['class' => 'col-3-5 hidden-xs', 'title' => 'Проигранные коллизии'],
                'label' => 'К-',
                'value' => function (UserRating $model): string {
                    return $model->user_rating_collision_loose;
                }
            ],
            [
                'contentOptions' => ['class' => 'hidden-xs text-center'],
                'footer' => $userRating->user_rating_win_super,
                'footerOptions' => ['class' => 'hidden-xs', 'title' => 'Победы у команд с супернастроем'],
                'headerOptions' => ['class' => 'col-3-5 hidden-xs', 'title' => 'Победы у команд с супернастроем'],
                'label' => 'ВС',
                'value' => function (UserRating $model): string {
                    return $model->user_rating_win_super;
                }
            ],
            [
                'contentOptions' => ['class' => 'hidden-sm hidden-xs text-center'],
                'footer' => $userRating->user_rating_win_strong,
                'footerOptions' => ['class' => 'hidden-sm hidden-xs', 'title' => 'Победы у сильных соперников'],
                'headerOptions' => ['class' => 'col-3-5 hidden-sm hidden-xs', 'title' => 'Победы у сильных соперников'],
                'label' => 'В+',
                'value' => function (UserRating $model): string {
                    return $model->user_rating_win_strong;
                }
            ],
            [
                'contentOptions' => ['class' => 'hidden-sm hidden-xs text-center'],
                'footer' => $userRating->user_rating_win_equal,
                'footerOptions' => ['class' => 'hidden-sm hidden-xs', 'title' => 'Победы у равных соперников'],
                'headerOptions' => ['class' => 'col-3-5 hidden-sm hidden-xs', 'title' => 'Победы у равных соперников'],
                'label' => 'В=',
                'value' => function (UserRating $model): string {
                    return $model->user_rating_win_equal;
                }
            ],
            [
                'contentOptions' => ['class' => 'hidden-sm hidden-xs text-center'],
                'footer' => $userRating->user_rating_win_weak,
                'footerOptions' => ['class' => 'hidden-sm hidden-xs', 'title' => 'Победы у слабых соперников'],
                'headerOptions' => ['class' => 'col-3-5 hidden-sm hidden-xs', 'title' => 'Победы у слабых соперников'],
                'label' => 'В-',
                'value' => function (UserRating $model): string {
                    return $model->user_rating_win_weak;
                }
            ],
            [
                'contentOptions' => ['class' => 'hidden-sm hidden-xs text-center'],
                'footer' => $userRating->user_rating_win_overtime_strong,
                'footerOptions' => [
                    'class' => 'hidden-sm hidden-xs',
                    'title' => 'Победы в овертайме/по буллитам у сильных соперников',
                ],
                'headerOptions' => [
                    'class' => 'col-3-5 hidden-sm hidden-xs',
                    'title' => 'Победы в овертайме/по буллитам у сильных соперников',
                ],
                'label' => 'ВО+',
                'value' => function (UserRating $model): string {
                    return $model->user_rating_win_overtime_strong;
                }
            ],
            [
                'contentOptions' => ['class' => 'hidden-sm hidden-xs text-center'],
                'footer' => $userRating->user_rating_win_overtime_equal,
                'footerOptions' => [
                    'class' => 'hidden-sm hidden-xs',
                    'title' => 'Победы в овертайме/по буллитам у равных соперников',
                ],
                'headerOptions' => [
                    'class' => 'col-3-5 hidden-sm hidden-xs',
                    'title' => 'Победы в овертайме/по буллитам у равных соперников',
                ],
                'label' => 'ВО=',
                'value' => function (UserRating $model): string {
                    return $model->user_rating_win_overtime_equal;
                }
            ],
            [
                'contentOptions' => ['class' => 'hidden-sm hidden-xs text-center'],
                'footer' => $userRating->user_rating_win_overtime_weak,
                'footerOptions' => [
                    'class' => 'hidden-sm hidden-xs',
                    'title' => 'Победы в овертайме/по буллитам у слабых соперников',
                ],
                'headerOptions' => [
                    'class' => 'col-3-5 hidden-sm hidden-xs',
                    'title' => 'Победы в овертайме/по буллитам у слабых соперников',
                ],
                'label' => 'ВО-',
                'value' => function (UserRating $model): string {
                    return $model->user_rating_win_overtime_weak;
                }
            ],
            [
                'contentOptions' => ['class' => 'hidden-sm hidden-xs text-center'],
                'footer' => $userRating->user_rating_loose_overtime_strong,
                'footerOptions' => [
                    'class' => 'hidden-sm hidden-xs',
                    'title' => 'Поражения в овертайме/по буллитам/ничьи сильным соперникам',
                ],
                'headerOptions' => [
                    'class' => 'col-3-5 hidden-sm hidden-xs',
                    'title' => 'Поражения в овертайме/по буллитам/ничьи сильным соперникам',
                ],
                'label' => 'ПО+',
                'value' => function (UserRating $model): string {
                    return $model->user_rating_loose_overtime_strong;
                }
            ],
            [
                'contentOptions' => ['class' => 'hidden-sm hidden-xs text-center'],
                'footer' => $userRating->user_rating_loose_overtime_equal,
                'footerOptions' => [
                    'class' => 'hidden-sm hidden-xs',
                    'title' => 'Поражения в овертайме/по буллитам/ничьи равным соперникам',
                ],
                'headerOptions' => [
                    'class' => 'col-3-5 hidden-sm hidden-xs',
                    'title' => 'Поражения в овертайме/по буллитам/ничьи равным соперникам',
                ],
                'label' => 'ПО=',
                'value' => function (UserRating $model): string {
                    return $model->user_rating_loose_overtime_equal;
                }
            ],
            [
                'contentOptions' => ['class' => 'hidden-sm hidden-xs text-center'],
                'footer' => $userRating->user_rating_loose_overtime_weak,
                'footerOptions' => [
                    'class' => 'hidden-sm hidden-xs',
                    'title' => 'Поражения в овертайме/по буллитам/ничьи слабым соперникам',
                ],
                'headerOptions' => [
                    'class' => 'col-3-5 hidden-sm hidden-xs',
                    'title' => 'Поражения в овертайме/по буллитам/ничьи слабым соперникам',
                ],
                'label' => 'ПО-',
                'value' => function (UserRating $model): string {
                    return $model->user_rating_loose_overtime_weak;
                }
            ],
            [
                'contentOptions' => ['class' => 'hidden-sm hidden-xs text-center'],
                'footer' => $userRating->user_rating_loose_strong,
                'footerOptions' => ['class' => 'hidden-sm hidden-xs', 'title' => 'Поражения сильным соперникам'],
                'headerOptions' => [
                    'class' => 'col-3-5 hidden-sm hidden-xs',
                    'title' => 'Поражения сильным соперникам'
                ],
                'label' => 'П+',
                'value' => function (UserRating $model): string {
                    return $model->user_rating_loose_strong;
                }
            ],
            [
                'contentOptions' => ['class' => 'hidden-sm hidden-xs text-center'],
                'footer' => $userRating->user_rating_loose_equal,
                'footerOptions' => ['class' => 'hidden-sm hidden-xs', 'title' => 'Поражения равным соперникам'],
                'headerOptions' => ['class' => 'col-3-5 hidden-sm hidden-xs', 'title' => 'Поражения равным соперникам'],
                'label' => 'П=',
                'value' => function (UserRating $model): string {
                    return $model->user_rating_loose_equal;
                }
            ],
            [
                'contentOptions' => ['class' => 'hidden-sm hidden-xs text-center'],
                'footer' => $userRating->user_rating_loose_weak,
                'footerOptions' => ['class' => 'hidden-sm hidden-xs', 'title' => 'Поражения слабым соперникам'],
                'headerOptions' => ['class' => 'col-3-5 hidden-sm hidden-xs', 'title' => 'Поражения слабым соперникам'],
                'label' => 'П-',
                'value' => function (UserRating $model): string {
                    return $model->user_rating_loose_weak;
                }
            ],
            [
                'contentOptions' => ['class' => 'hidden-xs text-center'],
                'footer' => $userRating->user_rating_loose_super,
                'footerOptions' => ['class' => 'hidden-xs', 'title' => 'Поражения супернастроем'],
                'headerOptions' => ['class' => 'col-3-5 hidden-xs', 'title' => 'Поражения супернастроем'],
                'label' => 'ПС',
                'value' => function (UserRating $model): string {
                    return $model->user_rating_loose_super;
                }
            ],
            [
                'contentOptions' => ['class' => 'text-center'],
                'footer' => $userRating->user_rating_auto,
                'footerOptions' => ['title' => 'Автосоставы'],
                'headerOptions' => ['class' => 'col-3-5', 'title' => 'Автосоставы'],
                'label' => 'А',
                'value' => function (UserRating $model): string {
                    return $model->user_rating_auto;
                }
            ],
            [
                'contentOptions' => ['class' => 'hidden-xs text-center'],
                'footer' => $userRating->user_rating_vs_super,
                'footerOptions' => ['class' => 'hidden-xs', 'title' => 'Игры против супернастроя'],
                'headerOptions' => ['class' => 'col-3-5 hidden-xs', 'title' => 'Игры против супернастроя'],
                'label' => 'VС',
                'value' => function (UserRating $model): string {
                    return $model->user_rating_vs_super;
                }
            ],
            [
                'contentOptions' => ['class' => 'hidden-xs text-center'],
                'footer' => $userRating->user_rating_vs_rest,
                'footerOptions' => ['class' => 'hidden-xs', 'title' => 'Игры против отдыха'],
                'headerOptions' => ['class' => 'col-3-5 hidden-xs', 'title' => 'Игры против отдыха'],
                'label' => 'VО',
                'value' => function (UserRating $model): string {
                    return $model->user_rating_vs_rest;
                }
            ],
        ];
        print GridView::widget([
            'columns' => $columns,
            'dataProvider' => $ratingDataProvider,
            'showFooter' => true,
            'summary' => false,
        ]);
    } catch (Exception $e) {
        ErrorHelper::log($e);
    }

    ?>
</div>
<div class="row margin-top-small">
    <?php

    try {
        $columns = [
            [
                'contentOptions' => ['class' => 'text-center'],
                'footer' => 'С',
                'footerOptions' => ['title' => 'Сезон'],
                'headerOptions' => ['class' => 'col-1', 'title' => 'Сезон'],
                'label' => 'С',
                'value' => function (History $model): string {
                    return $model->history_season_id;
                }
            ],
            [
                'contentOptions' => ['class' => 'text-center'],
                'footer' => 'Дата',
                'headerOptions' => ['class' => 'col-15'],
                'label' => 'Дата',
                'value' => function (History $model): string {
                    return Yii::$app->formatter->asDate($model->history_date, 'short');
                }
            ],
            [
                'footer' => 'Событие',
                'format' => 'raw',
                'label' => 'Событие',
                'value' => function (History $model): string {
                    return $model->text();
                }
            ],
        ];
        print GridView::widget([
            'columns' => $columns,
            'dataProvider' => $historyDataProvider,
            'showFooter' => true,
            'showOnEmpty' => false,
            'summary' => false,
        ]);
    } catch (Exception $e) {
        ErrorHelper::log($e);
    }

    ?>
</div>
