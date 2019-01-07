<?php

namespace frontend\controllers;

use common\models\Country;
use common\models\ElectionPresident;
use common\models\ElectionPresidentApplication;
use common\models\ElectionPresidentVote;
use common\models\ElectionStatus;
use Exception;
use Yii;
use yii\filters\AccessControl;

/**
 * Class PresidentController
 * @package frontend\controllers
 */
class PresidentController extends AbstractController
{
    /**
     * @return array
     */
    public function behaviors(): array
    {
        return [
            'access' => [
                'class' => AccessControl::class,
                'rules' => [
                    [
                        'allow' => true,
                        'roles' => ['@'],
                    ],
                ],
            ],
        ];
    }

    /**
     * @return string|\yii\web\Response
     * @throws Exception
     */
    public function actionApplication()
    {
        if (!$this->myTeam) {
            return $this->redirect(['team/ask']);
        }

        $country = $this->myTeam->stadium->city->country;
        Yii::$app->request->setQueryParams(['id' => $country->country_id]);

        if ($country->country_president_id) {
            return $this->redirect(['team/view']);
        }

        $electionPresident = ElectionPresident::find()
            ->where([
                'election_president_country_id' => $country->country_id,
                'election_president_election_status_id' => ElectionStatus::OPEN
            ])
            ->count();

        if ($electionPresident) {
            return $this->redirect(['president/view']);
        }

        $position = Country::find()
            ->where([
                'or',
                ['country_president_id' => Yii::$app->user->id],
                ['country_president_vice_id' => Yii::$app->user->id],
            ])
            ->count();

        if ($position) {
            $this->setErrorFlash('Можно быть президентом или заместителем президента только в одной федерации.');
            return $this->redirect(['team/view']);
        }

        $electionPresident = ElectionPresident::find()
            ->where([
                'election_president_country_id' => $country->country_id,
                'election_president_election_status_id' => ElectionStatus::CANDIDATES,
            ])
            ->limit(1)
            ->one();
        if (!$electionPresident) {
            $electionPresident = new ElectionPresident();
            $electionPresident->election_president_country_id = $country->country_id;
            $electionPresident->save();
        }

        $model = ElectionPresidentApplication::find()
            ->where([
                'election_president_application_election_id' => $electionPresident->election_president_id,
                'election_president_application_user_id' => Yii::$app->user->id,
            ])
            ->limit(1)
            ->one();
        if (!$model) {
            $model = new ElectionPresidentApplication();
            $model->election_president_application_election_id = $electionPresident->election_president_id;
            $model->election_president_application_user_id = Yii::$app->user->id;
        }

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            $this->setSuccessFlash('Изменения успшено сохранены.');
            return $this->refresh();
        }

        $this->setSeoTitle('Подача заявки на президента федерации');
        return $this->render('application', [
            'model' => $model,
        ]);
    }

    /**
     * @return string|\yii\web\Response
     */
    public function actionView()
    {
        if (!$this->myTeam) {
            return $this->redirect(['team/ask']);
        }

        $country = $this->myTeam->stadium->city->country;
        Yii::$app->request->setQueryParams(['id' => $country->country_id]);

        if ($country->country_president_id) {
            return $this->redirect(['team/view']);
        }

        $electionPresident = ElectionPresident::find()
            ->where([
                'election_president_country_id' => $country->country_id,
                'election_president_election_status_id' => ElectionStatus::CANDIDATES
            ])
            ->count();

        if ($electionPresident) {
            return $this->redirect(['president/application']);
        }

        $electionPresident = ElectionPresident::find()
            ->where([
                'election_president_country_id' => $country->country_id,
                'election_president_election_status_id' => ElectionStatus::OPEN,
            ])
            ->limit(1)
            ->one();

        if (!$electionPresident) {
            return $this->redirect(['team/view']);
        }

        $voteUser = ElectionPresidentVote::find()
            ->where([
                'election_president_vote_application_id' => ElectionPresidentApplication::find()
                    ->select(['election_president_application_id'])
                    ->where(['election_president_application_election_id' => $electionPresident->election_president_id]),
                'election_president_vote_user_id' => Yii::$app->user->id,
            ])
            ->count();
        if (!$voteUser) {
            return $this->redirect(['president/poll']);
        }

        $this->setSeoTitle('Голосование за президента федерации');

        return $this->render('view', [
            'electionPresident' => $electionPresident,
        ]);
    }

    /**
     * @return string|\yii\web\Response
     * @throws Exception
     */
    public function actionPoll()
    {
        if (!$this->myTeam) {
            return $this->redirect(['team/ask']);
        }

        $country = $this->myTeam->stadium->city->country;
        Yii::$app->request->setQueryParams(['id' => $country->country_id]);

        if ($country->country_president_id) {
            return $this->redirect(['team/view']);
        }

        $electionPresident = ElectionPresident::find()
            ->where([
                'election_president_country_id' => $country->country_id,
                'election_president_election_status_id' => ElectionStatus::CANDIDATES
            ])
            ->count();

        if ($electionPresident) {
            return $this->redirect(['president/application']);
        }

        $electionPresident = ElectionPresident::find()
            ->where([
                'election_president_country_id' => $country->country_id,
                'election_president_election_status_id' => ElectionStatus::OPEN,
            ])
            ->limit(1)
            ->one();

        if (!$electionPresident) {
            return $this->redirect(['team/view']);
        }

        $voteUser = ElectionPresidentVote::find()
            ->where([
                'election_president_vote_application_id' => ElectionPresidentApplication::find()
                    ->select(['election_president_application_id'])
                    ->where(['election_president_application_election_id' => $electionPresident->election_president_id]),
                'election_president_vote_user_id' => Yii::$app->user->id,
            ])
            ->count();
        if ($voteUser) {
            return $this->redirect(['president/view']);
        }

        $model = new ElectionPresidentVote();
        $model->election_president_vote_user_id = Yii::$app->user->id;
        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            $this->setSuccessFlash('Ваш голос успешно сохранён.');
            return $this->refresh();
        }

        $this->setSeoTitle('Голосование за президента федерации');

        return $this->render('poll', [
            'electionPresident' => $electionPresident,
            'model' => $model,
        ]);
    }
}
