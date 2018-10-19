<?php

namespace frontend\controllers;

use common\models\Team;
use yii\data\ActiveDataProvider;
use yii\db\ActiveQuery;

/**
 * Class CountryController
 * @package frontend\controllers
 */
class CountryController extends BaseController
{
    /**
     * @param integer $id
     * @return string
     */
    public function actionTeam(int $id): string
    {
        $dataProvider = new ActiveDataProvider([
            'pagination' => false,
            'query' => Team::find()
                ->joinWith([
                    'manager' => function (ActiveQuery $query): ActiveQuery {
                        return $query->select(['user_date_login', 'user_date_vip', 'user_id', 'user_login']);
                    },
                    'stadium.city' => function (ActiveQuery $query): ActiveQuery {
                        return $query->select(['city_country_id', 'city_id', 'city_name']);
                    }
                ])
                ->with([
                    'stadium' => function (ActiveQuery $query): ActiveQuery {
                        return $query->select(['stadium_city_id', 'stadium_id']);
                    },
                ])
                ->select(['team_id', 'team_name', 'team_stadium_id', 'team_user_id'])
                ->where(['city_country_id' => $id]),
            'sort' => [
                'attributes' => [
                    'last_visit' => [
                        'asc' => ['user_date_login' => SORT_ASC],
                        'desc' => ['user_date_login' => SORT_DESC],
                    ],
                    'manager' => [
                        'asc' => ['user_login' => SORT_ASC],
                        'desc' => ['user_login' => SORT_DESC],
                    ],
                    'team' => [
                        'asc' => ['team_name' => SORT_ASC],
                        'desc' => ['team_name' => SORT_DESC],
                    ],
                ],
                'defaultOrder' => ['team' => SORT_ASC],
            ],
        ]);

        $this->view->title = 'Команды фередации';
        $this->setSeoDescription();

        return $this->render('team', [
            'dataProvider' => $dataProvider
        ]);
    }
}
