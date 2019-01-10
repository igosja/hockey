<?php

namespace frontend\controllers;

use common\models\Country;
use common\models\Finance;
use common\models\LeagueDistribution;
use common\models\News;
use common\models\Poll;
use common\models\PollStatus;
use common\models\Season;
use common\models\Team;
use Yii;
use yii\data\ActiveDataProvider;
use yii\db\ActiveQuery;

/**
 * Class CountryController
 * @package frontend\controllers
 */
class CountryController extends AbstractController
{
    /**
     * @param integer $id
     * @return string
     */
    public function actionTeam($id)
    {
        $query = Team::find()
            ->joinWith([
                'manager' => function (ActiveQuery $query) {
                    return $query->select(['user_date_login', 'user_date_vip', 'user_id', 'user_login']);
                },
                'stadium.city' => function (ActiveQuery $query) {
                    return $query->select(['city_country_id', 'city_id', 'city_name']);
                }
            ])
            ->with([
                'stadium' => function (ActiveQuery $query) {
                    return $query->select(['stadium_city_id', 'stadium_id']);
                },
            ])
            ->select(['team_id', 'team_name', 'team_stadium_id', 'team_user_id'])
            ->where(['city_country_id' => $id]);
        $dataProvider = new ActiveDataProvider([
            'pagination' => false,
            'query' => $query,
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
            ]
        ]);

        $this->setSeoTitle('Команды федерации');

        return $this->render('team', [
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * @param int $id
     * @return string|\yii\web\Response
     */
    public function actionNews($id = 0)
    {
        if (!$id) {
            if (Yii::$app->user->isGuest) {
                $id = Country::DEFAULT_ID;
            } else {
                if ($this->myTeam) {
                    $id = $this->myTeam->stadium->city->city_country_id;
                } else {
                    $id = Country::DEFAULT_ID;
                }
            }
            return $this->redirect(['country/news', 'id' => $id]);
        }

        $query = News::find()
            ->with([
                'newsComment' => function (ActiveQuery $query) {
                    return $query->select(['news_comment_news_id']);
                },
                'user' => function (ActiveQuery $query) {
                    return $query->select(['user_id', 'user_login']);
                },
            ])
            ->select(['news_id', 'news_date', 'news_text', 'news_title', 'news_user_id'])
            ->where(['news_country_id' => $id])
            ->orderBy(['news_id' => SORT_DESC]);

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'pagination' => [
                'pageSize' => Yii::$app->params['pageSizeNews'],
            ],
        ]);

        $this->setSeoTitle('Новости федерации');

        return $this->render('news', [
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * @param int $id
     * @return string|\yii\web\Response
     */
    public function actionPoll($id)
    {
        $query = Poll::find()
            ->where(['poll_poll_status_id' => [PollStatus::OPEN, PollStatus::CLOSE], 'poll_country_id' => $id])
            ->orderBy(['poll_id' => SORT_DESC]);

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'pagination' => [
                'pageSize' => Yii::$app->params['pageSizePoll'],
            ],
        ]);

        $this->setSeoTitle('Опросы федерации');

        return $this->render('poll', [
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * @return string
     */
    public function actionNational()
    {
        $this->setSeoTitle('Сборные');

        return $this->render('national');
    }

    /**
     * @param int $id
     * @return string
     */
    public function actionLeague($id)
    {
        $query = LeagueDistribution::find()
            ->where(['league_distribution_country_id' => $id])
            ->orderBy(['league_distribution_season_id' => SORT_DESC])
            ->limit(1);
        $dataProvider = new ActiveDataProvider([
            'pagination' => false,
            'query' => $query,
        ]);

        $this->setSeoTitle('Лига чемпионов');

        return $this->render('league', [
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * @param int $id
     * @return string
     */
    public function actionFinance($id)
    {
        $seasonId = Yii::$app->request->get('season_id', $this->seasonId);

        $dataProvider = new ActiveDataProvider([
            'pagination' => false,
            'query' => Finance::find()
                ->where(['finance_country_id' => $id])
                ->andWhere(['finance_season_id' => $seasonId])
                ->orderBy(['finance_id' => SORT_DESC]),
        ]);

        $this->setSeoTitle('Фонд федерации');

        return $this->render('finance', [
            'dataProvider' => $dataProvider,
            'seasonId' => $seasonId,
            'seasonArray' => Season::getSeasonArray(),
        ]);
    }
}
