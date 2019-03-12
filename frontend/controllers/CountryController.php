<?php

namespace frontend\controllers;

use common\components\ErrorHelper;
use common\models\Country;
use common\models\Finance;
use common\models\LeagueDistribution;
use common\models\National;
use common\models\News;
use common\models\NewsComment;
use common\models\ParticipantLeague;
use common\models\Poll;
use common\models\PollStatus;
use common\models\Season;
use common\models\Team;
use common\models\UserRole;
use Throwable;
use Yii;
use yii\data\ActiveDataProvider;
use yii\db\ActiveQuery;
use yii\filters\AccessControl;

/**
 * Class CountryController
 * @package frontend\controllers
 */
class CountryController extends AbstractController
{
    /**
     * @return array
     */
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::class,
                'only' => [
                    'attitude-president',
                    'fire',
                    'news-create',
                    'news-update',
                    'news-delete',
                    'poll-create',
                    'delete-news-comment',
                ],
                'rules' => [
                    [
                        'actions' => [
                            'attitude-president',
                            'fire',
                            'news-create',
                            'news-update',
                            'news-delete',
                            'poll-create',
                            'delete-news-comment',
                        ],
                        'allow' => true,
                        'roles' => ['@'],
                    ],
                ],
            ],
        ];
    }

    /**
     * @param $id
     * @return \yii\web\Response
     * @throws \Exception
     */
    public function actionAttitudePresident($id)
    {
        if (!$this->myTeam) {
            return $this->redirect(['country/news', 'id' => $id]);
        }

        if (!$this->myTeam->load(Yii::$app->request->post())) {
            return $this->redirect(['country/news', 'id' => $id]);
        }

        $this->myTeam->save(true, ['team_attitude_president']);
        return $this->redirect(['country/news', 'id' => $id]);
    }

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
     * @throws \Exception
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
            ->select(['news_id', 'news_country_id', 'news_date', 'news_text', 'news_title', 'news_user_id'])
            ->where(['news_country_id' => $id])
            ->orderBy(['news_id' => SORT_DESC]);

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'pagination' => [
                'pageSize' => Yii::$app->params['pageSizeNews'],
            ],
        ]);

        if ($this->myTeam && $this->myTeam->stadium->city->country->country_id == $id) {
            $lastNewsId = News::find()
                ->select(['news_id'])
                ->where(['news_country_id' => $id])
                ->orderBy(['news_id' => SORT_DESC])
                ->scalar();
            if ($lastNewsId) {
                $this->myTeam->team_news_id = $lastNewsId;
                $this->myTeam->save(true, ['team_news_id']);
            }
        }

        $this->setSeoTitle('Новости федерации');

        return $this->render('news', [
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * @param int $id
     * @param int $newsId
     * @return string|\yii\web\Response
     * @throws \yii\web\NotFoundHttpException
     */
    public function actionNewsView($id, $newsId)
    {
        $news = News::find()->where(['news_id' => $newsId, 'news_country_id' => $id])->limit(1)->one();
        $this->notFound($news);

        $model = new NewsComment();
        $model->news_comment_news_id = $newsId;
        if ($model->addComment()) {
            $this->setSuccessFlash('Комментарий успешно сохранён');
            return $this->refresh();
        }

        $query = NewsComment::find()
            ->with([
                'user' => function (ActiveQuery $query) {
                    return $query->select(['user_id', 'user_login']);
                }
            ])
            ->select([
                'news_comment_id',
                'news_comment_date',
                'news_comment_news_id',
                'news_comment_text',
                'news_comment_user_id',
            ])
            ->where(['news_comment_news_id' => $newsId])
            ->orderBy(['news_comment_id' => SORT_ASC]);
        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'pagination' => [
                'pageSize' => Yii::$app->params['pageSizeNewsComment'],
            ],
        ]);

        $this->setSeoTitle('Комментарии к новости');

        return $this->render('news-view', [
            'dataProvider' => $dataProvider,
            'model' => $model,
            'news' => $news,
        ]);
    }

    /**
     * @param int $id
     * @return string|\yii\web\Response
     */
    public function actionPoll($id)
    {
        $statusArray = [PollStatus::OPEN, PollStatus::CLOSE];

        $country = Country::find()
            ->where(['country_id' => $id])
            ->limit(1)
            ->one();
        if (in_array($this->user->user_id, [$country->country_president_id, $country->country_president_vice_id])) {
            $statusArray[] = PollStatus::NEW_ONE;
        }

        $query = Poll::find()
            ->where(['poll_poll_status_id' => $statusArray, 'poll_country_id' => $id])
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
    public function actionNational($id)
    {
        $query = National::find()
            ->where(['national_country_id' => $id])
            ->orderBy(['national_national_type_id' => SORT_ASC]);

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'pagination' => false,
        ]);

        $this->setSeoTitle('Сборные');

        return $this->render('national', [
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * @param int $id
     * @return string
     */
    public function actionLeague($id)
    {
        $leagueDistribution = LeagueDistribution::find()
            ->where(['league_distribution_country_id' => $id])
            ->orderBy(['league_distribution_season_id' => SORT_DESC])
            ->limit(1)
            ->one();

        $teamArray = [];
        $seasonArray = ParticipantLeague::find()
            ->joinWith(['team.stadium.city.country'])
            ->where(['country_id' => $id])
            ->groupBy(['participant_league_season_id'])
            ->orderBy(['participant_league_season_id' => SORT_DESC])
            ->all();
        foreach ($seasonArray as $season) {
            $teamArray[$season->participant_league_season_id] = ParticipantLeague::find()
                ->joinWith(['team.stadium.city.country', 'leagueCoefficient'])
                ->where(['country_id' => $id, 'participant_league_season_id' => $season->participant_league_season_id])
                ->orderBy(['league_coefficient_point' => SORT_DESC, 'participant_league_stage_in' => SORT_DESC])
                ->all();
        }

        $this->setSeoTitle('Лига чемпионов');

        return $this->render('league', [
            'leagueDistribution' => $leagueDistribution,
            'teamArray' => $teamArray,
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

    /**
     * @param $id
     * @return string|\yii\web\Response
     * @throws \Exception
     */
    public function actionNewsCreate($id)
    {
        $country = Country::find()
            ->where(['country_id' => $id])
            ->limit(1)
            ->one();
        if (!in_array($this->user->user_id, [$country->country_president_id, $country->country_president_vice_id])) {
            $this->setErrorFlash('Только президент федерации или его заместитель может создавать новости');
            return $this->redirect(['country/news', 'id' => $id]);
        }

        $model = new News();
        $model->news_country_id = $id;

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            $this->setSuccessFlash('Новость успешно сохранена');
            return $this->redirect(['country/news', 'id' => $id]);
        }

        $this->setSeoTitle('Создание новости');

        return $this->render('news-create', [
            'model' => $model,
        ]);
    }

    /**
     * @param $id
     * @param $newsId
     * @return string|\yii\web\Response
     * @throws \Exception
     */
    public function actionNewsUpdate($id, $newsId)
    {
        $model = News::find()
            ->where(['news_id' => $newsId, 'news_country_id' => $id, 'news_user_id' => $this->user->user_id])
            ->limit(1)
            ->one();
        $this->notFound($model);

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            $this->setSuccessFlash('Новость успешно сохранена');
            return $this->redirect(['country/news', 'id' => $id]);
        }

        $this->setSeoTitle('Редактирование новости');

        return $this->render('news-update', [
            'model' => $model,
        ]);
    }

    /**
     * @param $id
     * @param $newsId
     * @return \yii\web\Response
     * @throws \Throwable
     * @throws \yii\db\StaleObjectException
     * @throws \yii\web\NotFoundHttpException
     */
    public function actionNewsDelete($id, $newsId)
    {
        $model = News::find()
            ->where(['news_id' => $newsId, 'news_country_id' => $id, 'news_user_id' => $this->user->user_id])
            ->limit(1)
            ->one();
        $this->notFound($model);

        $model->delete();

        $this->setSuccessFlash('Новость успешно удалена');
        return $this->redirect(['country/news', 'id' => $id]);
    }

    /**
     * @param $id
     * @return string|\yii\web\Response
     * @throws \yii\db\Exception
     */
    public function actionFire($id)
    {
        $country = Country::find()
            ->where(['country_id' => $id])
            ->limit(1)
            ->one();
        if (!in_array($this->user->user_id, [$country->country_president_id, $country->country_president_vice_id])) {
            $this->setErrorFlash('Вы не занимаете руководящей должности в этой стране');
            return $this->redirect(['country/news', 'id' => $id]);
        }

        if (!$country->country_president_vice_id) {
            $this->setErrorFlash('Нельзя отказаться от должности если в федерации нет заместителя');
            return $this->redirect(['country/news', 'id' => $id]);
        }

        if (Yii::$app->request->get('ok')) {
            if ($this->user->user_id == $country->country_president_id) {
                $country->firePresident();
            } elseif ($this->user->user_id == $country->country_president_vice_id) {
                $country->fireVicePresident();
            }

            $this->setSuccessFlash('Вы успешно отказались от должности');
            return $this->redirect(['country/news', 'id' => $id]);
        }

        $this->setSeoTitle('Отказ от должности');

        return $this->render('fire', [
            'id' => $id,
        ]);
    }

    /**
     * @param $id
     * @return string|\yii\web\Response
     * @throws \Exception
     */
    public function actionPollCreate($id)
    {
        $country = Country::find()
            ->where(['country_id' => $id])
            ->limit(1)
            ->one();
        if (!in_array($this->user->user_id, [$country->country_president_id, $country->country_president_vice_id])) {
            $this->setErrorFlash('Только президент федерации или его заместитель может создавать опросы');
            return $this->redirect(['country/poll', 'id' => $id]);
        }

        $model = new Poll();
        $model->poll_country_id = $id;

        if ($model->savePoll()) {
            $this->setSuccessFlash('Опрос успешно сохранён');
            return $this->redirect(['country/poll', 'id' => $id]);
        }

        $this->setSeoTitle('Создание опроса');

        return $this->render('poll-create', [
            'model' => $model,
        ]);
    }

    /**
     * @param $id
     * @param $pollId
     * @return \yii\web\Response
     * @throws \Throwable
     * @throws \yii\db\StaleObjectException
     * @throws \yii\web\NotFoundHttpException
     */
    public function actionPollDelete($id, $pollId)
    {
        $model = Poll::find()
            ->where(['poll_id' => $pollId, 'poll_country_id' => $id, 'poll_user_id' => $this->user->user_id])
            ->limit(1)
            ->one();
        $this->notFound($model);

        $model->delete();

        $this->setSuccessFlash('Опрос успешно удалён');
        return $this->redirect(['country/poll', 'id' => $id]);
    }

    /**
     * @param $id
     * @param $newsId
     * @return \yii\web\Response
     * @throws \yii\web\ForbiddenHttpException
     * @throws \yii\web\NotFoundHttpException
     */
    public function actionDeleteNewsComment($id, $newsId)
    {
        if (UserRole::ADMIN != $this->user->user_user_role_id) {
            $this->forbiddenRole();
        }

        $model = NewsComment::find()
            ->where(['news_comment_id' => $id, 'news_comment_news_id' => $newsId])
            ->limit(1)
            ->one();
        $this->notFound($model);

        $news = $model->news;

        try {
            $model->delete();
            $this->setSuccessFlash('Комментарий успешно удалён.');
        } catch (Throwable $e) {
            ErrorHelper::log($e);
        }

        return $this->redirect(['country/news-view', 'id' => $news->news_country_id, 'newsId' => $newsId]);
    }
}
