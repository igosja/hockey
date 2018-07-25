<?php

namespace frontend\controllers;

use common\models\Player;
use common\models\Team;
use yii\data\ActiveDataProvider;
use yii\db\ActiveQuery;

/**
 * Class TeamController
 * @package frontend\controllers
 */
class TeamController extends BaseController
{
    /**
     * @return string
     */
    public function actionIndex(): string
    {
        $countryArray = Team::find()
            ->select(['team_player' => 'COUNT(team_id)', 'team_stadium_id'])
            ->with([
                'stadium' => function (ActiveQuery $query): ActiveQuery {
                    return $query->select(['stadium_city_id', 'stadium_id']);
                },
                'stadium.city' => function (ActiveQuery $query): ActiveQuery {
                    return $query->select(['city_country_id', 'city_id']);
                },
                'stadium.city.country'
            ])
            ->joinWith([
                'stadium.city.country' => function (ActiveQuery $query): ActiveQuery {
                    return $query->select(['country_id', 'country_name']);
                },
            ])
            ->where(['!=', 'team_id', 0])
            ->orderBy(['country_id' => SORT_ASC])
            ->groupBy(['country_id'])
            ->all();

        $this->view->title = 'Teams';
        $this->view->registerMetaTag([
            'name' => 'description',
            'content' => 'Teams - Virtual Hockey Online League'
        ]);

        return $this->render('index', [
            'countryArray' => $countryArray,
        ]);
    }

    /**
     * @param integer $id
     * @return string
     */
    public function actionView(int $id): string
    {
        $dataProvider = new ActiveDataProvider([
            'pagination' => false,
            'query' => Player::find()
                ->joinWith([
                    'statisticPlayer' => function (ActiveQuery $query): ActiveQuery {
                        return $query->select([
                            'statistic_player_assist',
                            'statistic_player_game',
                            'statistic_player_plus_minus',
                            'statistic_player_score',
                        ]);
                    },
                ])
                ->with([
                    'country' => function (ActiveQuery $query): ActiveQuery {
                        return $query->select(['country_id', 'country_name']);
                    },
                    'name' => function (ActiveQuery $query): ActiveQuery {
                        return $query->select(['name_id', 'name_name']);
                    },
                    'physical' => function (ActiveQuery $query): ActiveQuery {
                        return $query->select(['physical_id', 'physical_name']);
                    },
                    'playerPosition' => function (ActiveQuery $query): ActiveQuery {
                        return $query->select(['player_position_player_id', 'player_position_position_id']);
                    },
                    'playerPosition.position' => function (ActiveQuery $query): ActiveQuery {
                        return $query->select(['position_id', 'position_name']);
                    },
                    'playerSpecial' => function (ActiveQuery $query): ActiveQuery {
                        return $query->select([
                            'player_special_level',
                            'player_special_player_id',
                            'player_special_special_id',
                        ]);
                    },
                    'playerSpecial.special' => function (ActiveQuery $query): ActiveQuery {
                        return $query->select(['special_id', 'special_name']);
                    },
                    'style' => function (ActiveQuery $query): ActiveQuery {
                        return $query->select(['style_id', 'style_name']);
                    },
                    'surname' => function (ActiveQuery $query): ActiveQuery {
                        return $query->select(['surname_id', 'surname_name']);
                    },
                ])
                ->select([
                    'player_age',
                    'player_country_id',
                    'player_game_row',
                    'player_name_id',
                    'player_id',
                    'player_physical_id',
                    'player_power_nominal',
                    'player_power_real',
                    'player_price',
                    'player_style_id',
                    'player_surname_id',
                    'player_tire',
                ])
                ->where(['player_team_id' => $id])
                ->orWhere(['player_loan_team_id' => $id]),
            'sort' => [
                'attributes' => [
                    'age' => [
                        'asc' => ['player_age' => SORT_ASC],
                        'desc' => ['player_age' => SORT_DESC],
                    ],
                    'assist' => [
                        'asc' => ['statistic_player.statistic_player_assist' => SORT_ASC],
                        'desc' => ['statistic_player.statistic_player_assist' => SORT_DESC],
                    ],
                    'game' => [
                        'asc' => ['statistic_player.statistic_player_game' => SORT_ASC],
                        'desc' => ['statistic_player.statistic_player_game' => SORT_DESC],
                    ],
                    'score' => [
                        'asc' => ['statistic_player.statistic_player_score' => SORT_ASC],
                        'desc' => ['statistic_player.statistic_player_score' => SORT_DESC],
                    ],
                    'plus_minus' => [
                        'asc' => ['statistic_player.statistic_player_plus_minus' => SORT_ASC],
                        'desc' => ['statistic_player.statistic_player_plus_minus' => SORT_DESC],
                    ],
                    'country' => [
                        'asc' => ['player_country_id' => SORT_ASC],
                        'desc' => ['player_country_id' => SORT_DESC],
                    ],
                    'game_row' => [
                        'asc' => ['player_game_row' => SORT_ASC],
                        'desc' => ['player_game_row' => SORT_DESC],
                    ],
                    'position' => [
                        'asc' => ['player_position_id' => SORT_ASC],
                        'desc' => ['player_position_id' => SORT_DESC],
                    ],
                    'physical' => [
                        'asc' => ['player_physical_id' => SORT_ASC],
                        'desc' => ['player_physical_id' => SORT_DESC],
                    ],
                    'power' => [
                        'asc' => ['player_power_nominal' => SORT_ASC],
                        'desc' => ['player_power_nominal' => SORT_DESC],
                    ],
                    'power_real' => [
                        'asc' => ['player_power_real' => SORT_ASC],
                        'desc' => ['player_power_real' => SORT_DESC],
                    ],
                    'price' => [
                        'asc' => ['player_price' => SORT_ASC],
                        'desc' => ['player_price' => SORT_DESC],
                    ],
                    'style' => [
                        'asc' => ['player_style_id' => SORT_ASC],
                        'desc' => ['player_style_id' => SORT_DESC],
                    ],
                    'tire' => [
                        'asc' => ['player_tire' => SORT_ASC],
                        'desc' => ['player_tire' => SORT_DESC],
                    ],
                ],
                'defaultOrder' => ['position' => SORT_ASC],
            ],
        ]);

        $this->view->title = 'Team profile';
        $this->view->registerMetaTag([
            'name' => 'description',
            'content' => 'Team profile - Virtual Hockey Online League'
        ]);

        return $this->render('view', [
            'dataProvider' => $dataProvider,
        ]);
    }
}
