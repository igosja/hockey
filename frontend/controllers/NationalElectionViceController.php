<?php

namespace frontend\controllers;

use common\models\ElectionNationalVice;
use common\models\ElectionNationalViceApplication;
use common\models\ElectionPresident;
use common\models\ElectionPresidentApplication;
use common\models\ElectionPresidentVote;
use common\models\ElectionStatus;
use common\models\National;
use common\models\NationalType;
use Exception;
use Yii;
use yii\filters\AccessControl;

/**
 * Class NationalElectionViceController
 * @package frontend\controllers
 */
class NationalElectionViceController extends AbstractController
{
    /**
     * @return array
     */
    public function behaviors()
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
            return $this->redirect(['team/view']);
        }

        $country = $this->myTeam->stadium->city->country;
        Yii::$app->request->setQueryParams(['id' => $country->country_id]);

        $national = National::find()
            ->where(['national_national_type_id' => NationalType::MAIN, 'national_country_id' => $country->country_id])
            ->limit(1)
            ->one();

        if ($national->national_vice_id || !$national->national_user_id) {
            return $this->redirect(['team/view']);
        }

        $electionNationalVice = ElectionNationalVice::find()
            ->where([
                'election_national_vice_country_id' => $country->country_id,
                'election_national_vice_national_type_id' => NationalType::MAIN,
                'election_national_vice_election_status_id' => ElectionStatus::OPEN
            ])
            ->count();

        if ($electionNationalVice) {
            return $this->redirect(['national-election-vice/view']);
        }

        $position = National::find()
            ->where([
                'or',
                ['national_user_id' => Yii::$app->user->id],
                ['national_vice_id' => Yii::$app->user->id],
            ])
            ->count();

        if ($position) {
            $this->setErrorFlash('Можно быть тренером или заместителем тренера только в одной сборной.');
            return $this->redirect(['team/view']);
        }

        $electionNationalVice = ElectionNationalVice::find()
            ->where([
                'election_national_vice_country_id' => $country->country_id,
                'election_national_vice_national_type_id' => NationalType::MAIN,
                'election_national_vice_election_status_id' => ElectionStatus::CANDIDATES,
            ])
            ->limit(1)
            ->one();
        if (!$electionNationalVice) {
            $electionNationalVice = new ElectionNationalVice();
            $electionNationalVice->election_national_vice_country_id = $country->country_id;
            $electionNationalVice->election_national_vice_national_type_id = NationalType::MAIN;
            $electionNationalVice->save();
        }

        $model = ElectionNationalViceApplication::find()
            ->where([
                'election_national_vice_application_election_id' => $electionNationalVice->election_national_vice_id,
                'election_national_vice_application_user_id' => Yii::$app->user->id,
            ])
            ->limit(1)
            ->one();
        if (!$model) {
            $model = new ElectionNationalViceApplication();
            $model->election_national_vice_application_election_id = $electionNationalVice->election_national_vice_id;
            $model->election_national_vice_application_user_id = Yii::$app->user->id;
        }

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            $this->setSuccessFlash('Изменения успшено сохранены.');
            return $this->refresh();
        }

        $this->setSeoTitle('Подача заявки на должность заместителя тренера национальной сборной');
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
            return $this->redirect(['team/view']);
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
            return $this->redirect(['team/view']);
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
