<?php

use common\components\ErrorHelper;
use common\components\FormatHelper;
use common\models\RatingChapter;
use common\models\RatingCountry;
use common\models\RatingTeam;
use common\models\RatingType;
use common\models\RatingUser;
use common\models\Season;
use yii\data\ActiveDataProvider;
use yii\grid\GridView;
use yii\helpers\Html;

/**
 * @var array $countryArray
 * @var integer $countryId
 * @var ActiveDataProvider $dataProvider
 * @var RatingType $ratingType
 * @var array $ratingTypeArray
 */

?>
<div class="row">
    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
        <h1>Рейтинги</h1>
    </div>
</div>
<?= Html::beginForm(['rating/index'], 'get'); ?>
<div class="row">
    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
        <?= Html::dropDownList(
            'id',
            $ratingType->rating_type_id,
            $ratingTypeArray,
            ['class' => 'form-control submit-on-change', 'id' => 'ratingTypeId']
        ); ?>
    </div>
</div>
<?php if (RatingChapter::TEAM == $ratingType->rating_type_rating_chapter_id): ?>
    <div class="row">
        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
            <?= Html::dropDownList(
                'countryId',
                $countryId,
                $countryArray,
                ['class' => 'form-control submit-on-change', 'id' => 'countryId', 'prompt' => 'Все']
            ); ?>
        </div>
    </div>
<?php endif; ?>
<?= Html::endForm(); ?>
<div class="row">
    <?php

    try {
        $columns = [
            [
                'class' => 'yii\grid\SerialColumn',
                'contentOptions' => ['class' => 'col-5 text-center'],
                'footer' => '№',
                'header' => '№',
                'headerOptions' => ['class' => 'col-5'],
            ],
        ];

        if (RatingChapter::TEAM == $ratingType->rating_type_rating_chapter_id) {
            $columns[] = [
                'attribute' => 'team_name',
                'footer' => 'Команда',
                'format' => 'raw',
                'label' => 'Команда',
                'value' => function (RatingTeam $model) {
                    return $model->team->teamLink('img');
                }
            ];

            if (RatingType::TEAM_POWER == $ratingType->rating_type_id) {
                $columns[] = [
                    'attribute' => 's_21',
                    'contentOptions' => ['class' => 'text-center'],
                    'footer' => 's21',
                    'footerOptions' => ['title' => 'Сумма сил 21 лучшего игрока'],
                    'headerOptions' => ['class' => 'col-10', 'title' => 'Сумма сил 21 лучшего игрока'],
                    'label' => 's21',
                    'value' => function (RatingTeam $model) {
                        return $model->team->team_power_s_21;
                    }
                ];
                $columns[] = [
                    'attribute' => 's_26',
                    'contentOptions' => ['class' => 'text-center'],
                    'footer' => 's26',
                    'footerOptions' => ['title' => 'Сумма сил 26 лучших игроков'],
                    'headerOptions' => ['class' => 'col-10', 'title' => 'Сумма сил 26 лучших игроков'],
                    'label' => 's26',
                    'value' => function (RatingTeam $model) {
                        return $model->team->team_power_s_26;
                    }
                ];
                $columns[] = [
                    'attribute' => 's_32',
                    'contentOptions' => ['class' => 'text-center'],
                    'footer' => 's32',
                    'footerOptions' => ['title' => 'Сумма сил 32 лучших игроков'],
                    'headerOptions' => ['class' => 'col-10', 'title' => 'Сумма сил 32 лучших игроков'],
                    'label' => 's32',
                    'value' => function (RatingTeam $model) {
                        return $model->team->team_power_s_32;
                    }
                ];
                $columns[] = [
                    'attribute' => 'val',
                    'contentOptions' => ['class' => 'text-center'],
                    'footer' => 'Vs',
                    'footerOptions' => ['title' => 'Рейтинг силы команды в длительных соревнованиях'],
                    'headerOptions' => ['class' => 'col-10', 'title' => 'Рейтинг силы команды в длительных соревнованиях'],
                    'label' => 'Vs',
                    'value' => function (RatingTeam $model) {
                        return $model->team->team_power_vs;
                    }
                ];
            } elseif (RatingType::TEAM_AGE == $ratingType->rating_type_id) {
                $columns[] = [
                    'attribute' => 'val',
                    'contentOptions' => ['class' => 'text-center'],
                    'footer' => 'В',
                    'footerOptions' => ['title' => 'Средний возраст'],
                    'headerOptions' => ['class' => 'col-15', 'title' => 'Средний возраст'],
                    'label' => 'В',
                    'value' => function (RatingTeam $model) {
                        return $model->team->team_age;
                    }
                ];
            } elseif (RatingType::TEAM_STADIUM == $ratingType->rating_type_id) {
                $columns[] = [
                    'attribute' => 'val',
                    'contentOptions' => ['class' => 'text-center'],
                    'footer' => 'Вм',
                    'footerOptions' => ['title' => 'Вместимость'],
                    'headerOptions' => ['class' => 'col-15', 'title' => 'Вместимость'],
                    'label' => 'Вм',
                    'value' => function (RatingTeam $model) {
                        return $model->team->stadium->stadium_capacity;
                    }
                ];
            } elseif (RatingType::TEAM_VISITOR == $ratingType->rating_type_id) {
                $columns[] = [
                    'attribute' => 'val',
                    'contentOptions' => ['class' => 'text-center'],
                    'footer' => 'Пос',
                    'footerOptions' => ['title' => 'Посещаемость'],
                    'headerOptions' => ['class' => 'col-15', 'title' => 'Посещаемость'],
                    'label' => 'Пос',
                    'value' => function (RatingTeam $model) {
                        return Yii::$app->formatter->asDecimal($model->team->team_visitor / 100, 2);
                    }
                ];
            } elseif (RatingType::TEAM_BASE == $ratingType->rating_type_id) {
                $columns[] = [
                    'attribute' => 'base',
                    'contentOptions' => ['class' => 'text-center'],
                    'footer' => 'Б',
                    'footerOptions' => ['title' => 'База'],
                    'headerOptions' => ['class' => 'col-6', 'title' => 'База'],
                    'label' => 'Б',
                    'value' => function (RatingTeam $model) {
                        return $model->team->base->base_level;
                    }
                ];
                $columns[] = [
                    'attribute' => 'val',
                    'contentOptions' => ['class' => 'text-center'],
                    'footer' => 'П',
                    'footerOptions' => ['title' => 'Количество построек'],
                    'headerOptions' => ['class' => 'col-6', 'title' => 'Количество построек'],
                    'label' => 'П',
                    'value' => function (RatingTeam $model) {
                        return $model->team->baseUsed();
                    }
                ];
                $columns[] = [
                    'attribute' => 'training',
                    'contentOptions' => ['class' => 'text-center'],
                    'footer' => 'Т',
                    'footerOptions' => ['title' => 'Тренировочная база'],
                    'headerOptions' => ['class' => 'col-6', 'title' => 'Тренировочная база'],
                    'label' => 'Т',
                    'value' => function (RatingTeam $model) {
                        return $model->team->baseTraining->base_training_level;
                    }
                ];
                $columns[] = [
                    'attribute' => 'medical',
                    'contentOptions' => ['class' => 'text-center'],
                    'footer' => 'М',
                    'footerOptions' => ['title' => 'Медицинский центр'],
                    'headerOptions' => ['class' => 'col-6', 'title' => 'Медицинский центр'],
                    'label' => 'М',
                    'value' => function (RatingTeam $model) {
                        return $model->team->baseMedical->base_medical_level;
                    }
                ];
                $columns[] = [
                    'attribute' => 'physical',
                    'contentOptions' => ['class' => 'text-center'],
                    'footer' => 'Ф',
                    'footerOptions' => ['title' => 'Физцентр'],
                    'headerOptions' => ['class' => 'col-6', 'title' => 'Физцентр'],
                    'label' => 'Ф',
                    'value' => function (RatingTeam $model) {
                        return $model->team->basePhysical->base_physical_level;
                    }
                ];
                $columns[] = [
                    'attribute' => 'school',
                    'contentOptions' => ['class' => 'text-center'],
                    'footer' => 'Сп',
                    'footerOptions' => ['title' => 'Спротшкола'],
                    'headerOptions' => ['class' => 'col-6', 'title' => 'Спротшкола'],
                    'label' => 'Сп',
                    'value' => function (RatingTeam $model) {
                        return $model->team->baseSchool->base_school_level;
                    }
                ];
                $columns[] = [
                    'attribute' => 'scout',
                    'contentOptions' => ['class' => 'text-center'],
                    'footer' => 'Ск',
                    'footerOptions' => ['title' => 'Скаутцентр'],
                    'headerOptions' => ['class' => 'col-6', 'title' => 'Скаутцентр'],
                    'label' => 'Ск',
                    'value' => function (RatingTeam $model) {
                        return $model->team->baseScout->base_scout_level;
                    }
                ];
            } elseif (RatingType::TEAM_SALARY == $ratingType->rating_type_id) {
                $columns[] = [
                    'attribute' => 'val',
                    'contentOptions' => ['class' => 'text-center'],
                    'footer' => 'ЗП',
                    'headerOptions' => ['class' => 'col-15', 'title' => 'Зарплата игроков'],
                    'label' => 'ЗП',
                    'value' => function (RatingTeam $model) {
                        return FormatHelper::asCurrency($model->team->team_salary);
                    }
                ];
            } elseif (RatingType::TEAM_FINANCE == $ratingType->rating_type_id) {
                $columns[] = [
                    'attribute' => 'val',
                    'contentOptions' => ['class' => 'text-center'],
                    'footer' => '$',
                    'headerOptions' => ['class' => 'col-15', 'title' => 'Денег в кассе'],
                    'label' => '$',
                    'value' => function (RatingTeam $model) {
                        return FormatHelper::asCurrency($model->team->team_finance);
                    }
                ];
            } elseif (RatingType::TEAM_PRICE_BASE == $ratingType->rating_type_id) {
                $columns[] = [
                    'attribute' => 'val',
                    'contentOptions' => ['class' => 'text-center'],
                    'footer' => 'База',
                    'headerOptions' => ['class' => 'col-15'],
                    'label' => 'База',
                    'value' => function (RatingTeam $model) {
                        return FormatHelper::asCurrency($model->team->team_price_base);
                    }
                ];
            } elseif (RatingType::TEAM_PRICE_STADIUM == $ratingType->rating_type_id) {
                $columns[] = [
                    'attribute' => 'val',
                    'contentOptions' => ['class' => 'text-center'],
                    'footer' => 'Стадион',
                    'headerOptions' => ['class' => 'col-15'],
                    'label' => 'Стадион',
                    'value' => function (RatingTeam $model) {
                        return FormatHelper::asCurrency($model->team->team_price_stadium);
                    }
                ];
            } elseif (RatingType::TEAM_PLAYER == $ratingType->rating_type_id) {
                $columns[] = [
                    'attribute' => 'player_number',
                    'contentOptions' => ['class' => 'text-center'],
                    'footer' => 'Кол',
                    'headerOptions' => ['class' => 'col-10', 'title' => 'Количество'],
                    'label' => 'Кол',
                    'value' => function (RatingTeam $model) {
                        return $model->team->team_player;
                    }
                ];
                $columns[] = [
                    'attribute' => 'val',
                    'contentOptions' => ['class' => 'text-center'],
                    'footer' => '$',
                    'headerOptions' => ['class' => 'col-15', 'title' => 'Стоимость'],
                    'label' => '$',
                    'value' => function (RatingTeam $model) {
                        return FormatHelper::asCurrency($model->team->team_price_player);
                    }
                ];
            } elseif (RatingType::TEAM_PRICE_TOTAL == $ratingType->rating_type_id) {
                $columns[] = [
                    'attribute' => 'base_price',
                    'contentOptions' => ['class' => 'text-center'],
                    'footer' => 'База',
                    'headerOptions' => ['class' => 'col-15'],
                    'label' => 'База',
                    'value' => function (RatingTeam $model) {
                        return FormatHelper::asCurrency($model->team->team_price_base);
                    }
                ];
                $columns[] = [
                    'attribute' => 'stadium_price',
                    'contentOptions' => ['class' => 'text-center'],
                    'footer' => 'Стадион',
                    'headerOptions' => ['class' => 'col-15'],
                    'label' => 'Стадион',
                    'value' => function (RatingTeam $model) {
                        return FormatHelper::asCurrency($model->team->team_price_stadium);
                    }
                ];
                $columns[] = [
                    'attribute' => 'player_price',
                    'contentOptions' => ['class' => 'text-center'],
                    'footer' => 'Игроки',
                    'headerOptions' => ['class' => 'col-15'],
                    'label' => 'Игроки',
                    'value' => function (RatingTeam $model) {
                        return FormatHelper::asCurrency($model->team->team_price_player);
                    }
                ];
                $columns[] = [
                    'attribute' => 'val',
                    'contentOptions' => ['class' => 'text-center'],
                    'footer' => 'Стоимость',
                    'headerOptions' => ['class' => 'col-15'],
                    'label' => 'Стоимость',
                    'value' => function (RatingTeam $model) {
                        return FormatHelper::asCurrency($model->team->team_price_total);
                    }
                ];
            }
        } elseif (RatingType::USER_RATING == $ratingType->rating_type_id) {
            $columns[] = [
                'footer' => 'Менеджер',
                'format' => 'raw',
                'label' => 'Менеджер',
                'value' => function (RatingUser $model) {
                    return $model->user->userLink();
                }
            ];
            $columns[] = [
                'contentOptions' => ['class' => 'text-center'],
                'footer' => 'С',
                'footerOptions' => ['title' => 'Страна'],
                'format' => 'raw',
                'headerOptions' => ['class' => 'col-1', 'title' => 'Страна'],
                'label' => 'С',
                'value' => function (RatingUser $model) {
                    return $model->user->country ? $model->user->country->countryImage() : '';
                }
            ];
            $columns[] = [
                'attribute' => 'val',
                'contentOptions' => ['class' => 'text-center'],
                'footer' => 'Рейтинг',
                'headerOptions' => ['class' => 'col-15'],
                'label' => 'Рейтинг',
                'value' => function (RatingUser $model) {
                    return $model->user->user_rating;
                }
            ];
        } else {
            $columns[] = [
                'footer' => 'Страна',
                'format' => 'raw',
                'label' => 'Страна',
                'value' => function (RatingCountry $model) {
                    return $model->country->countryLink();
                }
            ];

            if (RatingType::COUNTRY_STADIUM == $ratingType->rating_type_id) {
                $columns[] = [
                    'attribute' => 'val',
                    'contentOptions' => ['class' => 'text-center'],
                    'footer' => '10 лучших',
                    'headerOptions' => ['class' => 'col-15'],
                    'label' => '10 лучших',
                    'value' => function (RatingCountry $model) {
                        return $model->country->country_stadium_capacity;
                    }
                ];
            } elseif (RatingType::COUNTRY_AUTO == $ratingType->rating_type_id) {
                $columns[] = [
                    'attribute' => 'game',
                    'contentOptions' => ['class' => 'text-center'],
                    'footer' => 'И',
                    'footerOptions' => ['title' => 'Игры'],
                    'headerOptions' => ['class' => 'col-10', 'title' => 'Игры'],
                    'label' => 'И',
                    'value' => function (RatingCountry $model) {
                        return $model->country->country_game;
                    }
                ];
                $columns[] = [
                    'attribute' => 'auto',
                    'contentOptions' => ['class' => 'text-center'],
                    'footer' => 'А',
                    'footerOptions' => ['title' => 'Автосоставы'],
                    'headerOptions' => ['class' => 'col-10', 'title' => 'Автосоставы'],
                    'label' => 'А',
                    'value' => function (RatingCountry $model) {
                        return $model->country->country_auto;
                    }
                ];
                $columns[] = [
                    'attribute' => 'val',
                    'contentOptions' => ['class' => 'text-center'],
                    'footer' => '%',
                    'headerOptions' => ['class' => 'col-10'],
                    'label' => '%',
                    'value' => function (RatingCountry $model) {
                        return Yii::$app->formatter->asDecimal(
                            round($model->country->country_auto / ($model->country->country_game ? $model->country->country_game : 1) * 100, 1)
                        );
                    }
                ];
            } elseif (RatingType::COUNTRY_LEAGUE == $ratingType->rating_type_id) {
                $season = Season::getCurrentSeason();
                for ($i = 4; $i >= 0; $i--) {
                    $columnSeason = $season - $i;

                    if ($columnSeason < 2) {
                        continue;
                    }

                    $columns[] = [
                        'contentOptions' => ['class' => 'text-center'],
                        'footer' => $columnSeason,
                        'footerOptions' => ['title' => 'Сезон ' . $columnSeason],
                        'headerOptions' => ['class' => 'col-10', 'title' => 'Сезон ' . $columnSeason],
                        'label' => $columnSeason,
                        'value' => function (RatingCountry $model) use ($columnSeason) {
                            $count = 0;
                            $result = 0;
                            foreach ($model->country->leagueCoefficient as $leagueCoefficient) {
                                if ($columnSeason == $leagueCoefficient->league_coefficient_season_id) {
                                    $count++;
                                    $result = $result + $leagueCoefficient->league_coefficient_point;
                                }
                            }
                            if (!$count) {
                                $count = 1;
                            }
                            return Yii::$app->formatter->asDecimal($result / $count, 4);
                        }
                    ];
                }
                $columns[] = [
                    'attribute' => 'val',
                    'contentOptions' => ['class' => 'text-center'],
                    'footer' => 'K',
                    'footerOptions' => ['title' => 'Коэффициент'],
                    'headerOptions' => ['class' => 'col-10', 'title' => 'Коэффициент'],
                    'label' => 'K',
                    'value' => function (RatingCountry $model) use ($season) {
                        $rating = 0;
                        for ($i = 0; $i < 5; $i++) {
                            $count = 0;
                            $result = 0;
                            foreach ($model->country->leagueCoefficient as $leagueCoefficient) {
                                if ($season - $i == $leagueCoefficient->league_coefficient_season_id) {
                                    $count++;
                                    $result = $result + $leagueCoefficient->league_coefficient_point;
                                }
                            }
                            if (!$count) {
                                $count = 1;
                            }
                            $rating = $rating + $result / $count;
                        }
                        return Yii::$app->formatter->asDecimal($rating, 4);
                    }
                ];
            }
        }
        print GridView::widget([
            'columns' => $columns,
            'dataProvider' => $dataProvider,
            'showFooter' => true,
            'summary' => false,
        ]);
    } catch (Exception $e) {
        ErrorHelper::log($e);
    }

    ?>
</div>