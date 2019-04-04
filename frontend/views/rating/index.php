<?php

use common\components\ErrorHelper;
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
            ],
        ];

        if (RatingChapter::TEAM == $ratingType->rating_type_rating_chapter_id) {
            $columns[] = [
                'footer' => 'Команда',
                'format' => 'raw',
                'label' => 'Команда',
                'value' => function (RatingTeam $model) {
                    return $model->team->teamLink('img');
                }
            ];

            if (RatingType::TEAM_POWER == $ratingType->rating_type_id) {
                $columns[] = [
                    'contentOptions' => ['class' => 'text-center'],
                    'footer' => 's21',
                    'footerOptions' => ['title' => 'Сумма сил 21 лучшего игрока'],
                    'headerOptions' => ['title' => 'Сумма сил 21 лучшего игрока'],
                    'label' => 's21',
                    'value' => function (RatingTeam $model) {
                        return $model->team->team_power_s_21;
                    }
                ];
                $columns[] = [
                    'contentOptions' => ['class' => 'text-center'],
                    'footer' => 's26',
                    'label' => 's26',
                    'headerOptions' => ['title' => 'Сумма сил 26 лучших игроков'],
                    'footerOptions' => ['title' => 'Сумма сил 26 лучших игроков'],
                    'value' => function (RatingTeam $model) {
                        return $model->team->team_power_s_26;
                    }
                ];
                $columns[] = [
                    'contentOptions' => ['class' => 'text-center'],
                    'footer' => 's32',
                    'footerOptions' => ['title' => 'Сумма сил 32 лучших игроков'],
                    'headerOptions' => ['title' => 'Сумма сил 32 лучших игроков'],
                    'label' => 's32',
                    'value' => function (RatingTeam $model) {
                        return $model->team->team_power_s_32;
                    }
                ];
                $columns[] = [
                    'contentOptions' => ['class' => 'text-center'],
                    'footer' => 'Vs',
                    'footerOptions' => ['title' => 'Рейтинг силы команды в длительных соревнованиях'],
                    'headerOptions' => ['title' => 'Рейтинг силы команды в длительных соревнованиях'],
                    'label' => 'Vs',
                    'value' => function (RatingTeam $model) {
                        return $model->team->team_power_vs;
                    }
                ];
            } elseif (RatingType::TEAM_AGE == $ratingType->rating_type_id) {
                $columns[] = [
                    'contentOptions' => ['class' => 'text-center'],
                    'footer' => 'В',
                    'footerOptions' => ['title' => 'Средний возраст'],
                    'headerOptions' => ['title' => 'Средний возраст'],
                    'label' => 'В',
                    'value' => function (RatingTeam $model) {
                        return $model->team->team_age;
                    }
                ];
            } elseif (RatingType::TEAM_STADIUM == $ratingType->rating_type_id) {
                $columns[] = [
                    'contentOptions' => ['class' => 'text-center'],
                    'footer' => 'Вместимость',
                    'label' => 'Вместимость',
                    'value' => function (RatingTeam $model) {
                        return $model->team->stadium->stadium_capacity;
                    }
                ];
            } elseif (RatingType::TEAM_VISITOR == $ratingType->rating_type_id) {
                $columns[] = [
                    'contentOptions' => ['class' => 'text-center'],
                    'footer' => 'Посещаемость',
                    'label' => 'Посещаемость',
                    'value' => function (RatingTeam $model) {
                        return Yii::$app->formatter->asDecimal($model->team->team_visitor / 100);
                    }
                ];
            } elseif (RatingType::TEAM_BASE == $ratingType->rating_type_id) {
                $columns[] = [
                    'contentOptions' => ['class' => 'text-center'],
                    'footer' => 'Б',
                    'footerOptions' => ['title' => 'База'],
                    'headerOptions' => ['title' => 'База'],
                    'label' => 'Б',
                    'value' => function (RatingTeam $model) {
                        return $model->team->base->base_level;
                    }
                ];
                $columns[] = [
                    'contentOptions' => ['class' => 'text-center'],
                    'footer' => 'П',
                    'footerOptions' => ['title' => 'Количество построек'],
                    'headerOptions' => ['title' => 'Количество построек'],
                    'label' => 'П',
                    'value' => function (RatingTeam $model) {
                        return $model->team->baseUsed();
                    }
                ];
                $columns[] = [
                    'contentOptions' => ['class' => 'text-center'],
                    'footer' => 'Т',
                    'footerOptions' => ['title' => 'Тренировочная база'],
                    'headerOptions' => ['title' => 'Тренировочная база'],
                    'label' => 'Т',
                    'value' => function (RatingTeam $model) {
                        return $model->team->baseTraining->base_training_level;
                    }
                ];
                $columns[] = [
                    'contentOptions' => ['class' => 'text-center'],
                    'footer' => 'М',
                    'footerOptions' => ['title' => 'Медицинский центр'],
                    'headerOptions' => ['title' => 'Медицинский центр'],
                    'label' => 'М',
                    'value' => function (RatingTeam $model) {
                        return $model->team->baseMedical->base_medical_level;
                    }
                ];
                $columns[] = [
                    'contentOptions' => ['class' => 'text-center'],
                    'footer' => 'Ф',
                    'footerOptions' => ['title' => 'Физцентр'],
                    'headerOptions' => ['title' => 'Физцентр'],
                    'label' => 'Ф',
                    'value' => function (RatingTeam $model) {
                        return $model->team->basePhysical->base_physical_level;
                    }
                ];
                $columns[] = [
                    'contentOptions' => ['class' => 'text-center'],
                    'footer' => 'Сп',
                    'footerOptions' => ['title' => 'Спротшкола'],
                    'headerOptions' => ['title' => 'Спротшкола'],
                    'label' => 'Сп',
                    'value' => function (RatingTeam $model) {
                        return $model->team->baseSchool->base_school_level;
                    }
                ];
                $columns[] = [
                    'contentOptions' => ['class' => 'text-center'],
                    'footer' => 'Ск',
                    'footerOptions' => ['title' => 'Скаутцентр'],
                    'headerOptions' => ['title' => 'Скаутцентр'],
                    'label' => 'Ск',
                    'value' => function (RatingTeam $model) {
                        return $model->team->baseScout->base_scout_level;
                    }
                ];
            } elseif (RatingType::TEAM_PRICE_BASE == $ratingType->rating_type_id) {
                $columns[] = [
                    'contentOptions' => ['class' => 'text-center'],
                    'footer' => 'База',
                    'label' => 'База',
                    'value' => function (RatingTeam $model) {
                        return Yii::$app->formatter->asCurrency($model->team->team_price_base, 'USD');
                    }
                ];
            } elseif (RatingType::TEAM_PRICE_STADIUM == $ratingType->rating_type_id) {
                $columns[] = [
                    'contentOptions' => ['class' => 'text-center'],
                    'footer' => 'Стадион',
                    'label' => 'Стадион',
                    'value' => function (RatingTeam $model) {
                        return Yii::$app->formatter->asCurrency($model->team->team_price_stadium, 'USD');
                    }
                ];
            } elseif (RatingType::TEAM_PLAYER == $ratingType->rating_type_id) {
                $columns[] = [
                    'contentOptions' => ['class' => 'text-center'],
                    'footer' => 'Количество',
                    'label' => 'Количество',
                    'value' => function (RatingTeam $model) {
                        return $model->team->team_player;
                    }
                ];
                $columns[] = [
                    'contentOptions' => ['class' => 'text-center'],
                    'footer' => 'Стоимость',
                    'label' => 'Стоимость',
                    'value' => function (RatingTeam $model) {
                        return Yii::$app->formatter->asCurrency($model->team->team_price_player, 'USD');
                    }
                ];
                $columns[] = [
                    'contentOptions' => ['class' => 'text-center'],
                    'footer' => 'Зарплата',
                    'label' => 'Зарплата',
                    'value' => function (RatingTeam $model) {
                        return Yii::$app->formatter->asCurrency($model->team->team_salary, 'USD');
                    }
                ];
            } elseif (RatingType::TEAM_PRICE_TOTAL == $ratingType->rating_type_id) {
                $columns[] = [
                    'contentOptions' => ['class' => 'text-center'],
                    'footer' => 'База',
                    'label' => 'База',
                    'value' => function (RatingTeam $model) {
                        return Yii::$app->formatter->asCurrency($model->team->team_price_base, 'USD');
                    }
                ];
                $columns[] = [
                    'contentOptions' => ['class' => 'text-center'],
                    'footer' => 'Стадион',
                    'label' => 'Стадион',
                    'value' => function (RatingTeam $model) {
                        return Yii::$app->formatter->asCurrency($model->team->team_price_stadium, 'USD');
                    }
                ];
                $columns[] = [
                    'contentOptions' => ['class' => 'text-center'],
                    'footer' => 'Игроки',
                    'label' => 'Игроки',
                    'value' => function (RatingTeam $model) {
                        return Yii::$app->formatter->asCurrency($model->team->team_price_player, 'USD');
                    }
                ];
                $columns[] = [
                    'contentOptions' => ['class' => 'text-center'],
                    'footer' => 'В кассе',
                    'label' => 'В кассе',
                    'value' => function (RatingTeam $model) {
                        return Yii::$app->formatter->asCurrency($model->team->team_finance, 'USD');
                    }
                ];
                $columns[] = [
                    'contentOptions' => ['class' => 'text-center'],
                    'footer' => 'В кассе',
                    'label' => 'В кассе',
                    'value' => function (RatingTeam $model) {
                        return Yii::$app->formatter->asCurrency($model->team->team_finance, 'USD');
                    }
                ];
                $columns[] = [
                    'contentOptions' => ['class' => 'text-center'],
                    'footer' => 'Стоимость',
                    'label' => 'Стоимость',
                    'value' => function (RatingTeam $model) {
                        return Yii::$app->formatter->asCurrency($model->team->team_price_total, 'USD');
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
                'contentOptions' => ['class' => 'text-center'],
                'footer' => 'Рейтинг',
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
                    'contentOptions' => ['class' => 'text-center'],
                    'footer' => '10 лучших',
                    'label' => '10 лучших',
                    'value' => function (RatingCountry $model) {
                        return $model->country->country_stadium_capacity;
                    }
                ];
            } elseif (RatingType::COUNTRY_AUTO == $ratingType->rating_type_id) {
                $columns[] = [
                    'contentOptions' => ['class' => 'text-center'],
                    'footer' => 'И',
                    'footerOptions' => ['title' => 'Игры'],
                    'headerOptions' => ['title' => 'Игры'],
                    'label' => 'И',
                    'value' => function (RatingCountry $model) {
                        return $model->country->country_game;
                    }
                ];
                $columns[] = [
                    'contentOptions' => ['class' => 'text-center'],
                    'footer' => 'А',
                    'footerOptions' => ['title' => 'Автосоставы'],
                    'headerOptions' => ['title' => 'Автосоставы'],
                    'label' => 'А',
                    'value' => function (RatingCountry $model) {
                        return $model->country->country_auto;
                    }
                ];
                $columns[] = [
                    'contentOptions' => ['class' => 'text-center'],
                    'footer' => '%',
                    'label' => '%',
                    'value' => function (RatingCountry $model) {
                        return Yii::$app->formatter->asDecimal(
                            round($model->country->country_auto / ($model->country->country_game ? $model->country->country_game : 1) * 100, 1)
                        );
                    }
                ];
            } elseif (RatingType::COUNTRY_LEAGUE == $ratingType->rating_type_id) {
                $season = Season::getCurrentSeason();
                $columns[] = [
                    'contentOptions' => ['class' => 'text-center'],
                    'footer' => $season,
                    'footerOptions' => ['title' => 'Сезон ' . $season],
                    'headerOptions' => ['class' => 'col-10', 'title' => 'Сезон ' . $season],
                    'label' => $season,
                    'value' => function (RatingCountry $model) use ($season) {
                        $count = 0;
                        $result = 0;
                        foreach ($model->country->leagueCoefficient as $leagueCoefficient) {
                            if ($season == $leagueCoefficient->league_coefficient_season_id) {
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
                $columns[] = [
                    'contentOptions' => ['class' => 'text-center'],
                    'footer' => 'K',
                    'footerOptions' => ['title' => 'Коэффициент'],
                    'headerOptions' => ['class' => 'col-10', 'title' => 'Коэффициент'],
                    'label' => 'K',
                    'value' => function (RatingCountry $model) use ($season) {
                        $count = 0;
                        $result = 0;
                        foreach ($model->country->leagueCoefficient as $leagueCoefficient) {
                            if ($season == $leagueCoefficient->league_coefficient_season_id) {
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