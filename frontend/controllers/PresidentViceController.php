<?php

namespace frontend\controllers;

use common\models\Country;
use common\models\ElectionPresidentVice;
use common\models\ElectionPresidentViceApplication;
use common\models\ElectionPresidentViceVote;
use common\models\ElectionStatus;
use Exception;
use Throwable;
use Yii;
use yii\db\StaleObjectException;
use yii\filters\AccessControl;
use yii\web\Response;

/**
 * Class PresidentViceController
 * @package frontend\controllers
 */
class PresidentViceController extends AbstractController
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
     * @return string|Response
     * @throws Exception
     */
    public function actionApplication()
    {
        if (!$this->myTeam) {
            return $this->redirect(['team/view']);
        }

        $country = $this->myTeam->stadium->city->country;
        Yii::$app->request->setQueryParams(['id' => $country->country_id]);

        if ($country->country_president_vice_id || !$country->country_president_id) {
            return $this->redirect(['team/view']);
        }

        $electionPresidentVice = ElectionPresidentVice::find()
            ->where([
                'election_president_vice_country_id' => $country->country_id,
                'election_president_vice_election_status_id' => ElectionStatus::OPEN
            ])
            ->count();

        if ($electionPresidentVice) {
            return $this->redirect(['view']);
        }

        $position = Country::find()
            ->where([
                'or',
                ['country_president_id' => Yii::$app->user->id],
                ['country_president_vice_id' => Yii::$app->user->id],
            ])
            ->count();

        if ($position) {
            $this->setErrorFlash('?????????? ???????? ?????????????????????? ?????? ???????????????????????? ???????????????????? ???????????? ?? ?????????? ??????????????????.');
            return $this->redirect(['team/view']);
        }

        $electionPresidentVice = ElectionPresidentVice::find()
            ->where([
                'election_president_vice_country_id' => $country->country_id,
                'election_president_vice_election_status_id' => ElectionStatus::CANDIDATES,
            ])
            ->limit(1)
            ->one();
        if (!$electionPresidentVice) {
            $electionPresidentVice = new ElectionPresidentVice();
            $electionPresidentVice->election_president_vice_country_id = $country->country_id;
            $electionPresidentVice->save();
        }

        $model = ElectionPresidentViceApplication::find()
            ->where([
                'election_president_vice_application_election_id' => $electionPresidentVice->election_president_vice_id,
                'election_president_vice_application_user_id' => Yii::$app->user->id,
            ])
            ->limit(1)
            ->one();
        if (!$model) {
            $model = new ElectionPresidentViceApplication();
            $model->election_president_vice_application_election_id = $electionPresidentVice->election_president_vice_id;
            $model->election_president_vice_application_user_id = Yii::$app->user->id;
        }

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            $this->setSuccessFlash('?????????????????? ?????????????? ??????????????????.');
            return $this->refresh();
        }

        $this->setSeoTitle('???????????? ???????????? ???? ?????????????????? ?????????????????????? ???????????????????? ??????????????????');
        return $this->render('application', [
            'model' => $model,
        ]);
    }

    /**
     * @return Response
     * @throws Throwable
     * @throws StaleObjectException
     */
    public function actionDeleteApplication(): Response
    {
        if (!$this->myTeam) {
            return $this->redirect(['team/view']);
        }

        $country = $this->myTeam->stadium->city->country;
        Yii::$app->request->setQueryParams(['id' => $country->country_id]);

        if ($country->country_president_vice_id || !$country->country_president_id) {
            return $this->redirect(['team/view']);
        }

        $electionPresidentVice = ElectionPresidentVice::find()
            ->where([
                'election_president_vice_country_id' => $country->country_id,
                'election_president_vice_election_status_id' => ElectionStatus::OPEN
            ])
            ->count();

        if ($electionPresidentVice) {
            return $this->redirect(['view']);
        }

        $electionPresidentVice = ElectionPresidentVice::find()
            ->where([
                'election_president_vice_country_id' => $country->country_id,
                'election_president_vice_election_status_id' => ElectionStatus::CANDIDATES,
            ])
            ->limit(1)
            ->one();
        if (!$electionPresidentVice) {
            $electionPresidentVice = new ElectionPresidentVice();
            $electionPresidentVice->election_president_vice_country_id = $country->country_id;
            $electionPresidentVice->save();
        }

        $model = ElectionPresidentViceApplication::find()
            ->where([
                'election_president_vice_application_election_id' => $electionPresidentVice->election_president_vice_id,
                'election_president_vice_application_user_id' => Yii::$app->user->id,
            ])
            ->limit(1)
            ->one();
        if (!$model) {
            return $this->redirect(['president-vice/application']);
        }

        $model->delete();

        $this->setSuccessFlash('???????????? ?????????????? ??????????????.');
        return $this->redirect(['president-vice/application']);
    }

    /**
     * @return string|Response
     */
    public function actionView()
    {
        if (!$this->myTeam) {
            return $this->redirect(['team/view']);
        }

        $country = $this->myTeam->stadium->city->country;
        Yii::$app->request->setQueryParams(['id' => $country->country_id]);

        if ($country->country_president_vice_id || !$country->country_president_id) {
            return $this->redirect(['team/view']);
        }

        $electionPresidentVice = ElectionPresidentVice::find()
            ->where([
                'election_president_vice_country_id' => $country->country_id,
                'election_president_vice_election_status_id' => ElectionStatus::CANDIDATES
            ])
            ->count();

        if ($electionPresidentVice) {
            return $this->redirect(['application']);
        }

        $electionPresidentVice = ElectionPresidentVice::find()
            ->where([
                'election_president_vice_country_id' => $country->country_id,
                'election_president_vice_election_status_id' => ElectionStatus::OPEN,
            ])
            ->limit(1)
            ->one();

        if (!$electionPresidentVice) {
            return $this->redirect(['team/view']);
        }

        $voteUser = ElectionPresidentViceVote::find()
            ->where([
                'election_president_vice_vote_application_id' => ElectionPresidentViceApplication::find()
                    ->select(['election_president_vice_application_id'])
                    ->where(['election_president_vice_application_election_id' => $electionPresidentVice->election_president_vice_id]),
                'election_president_vice_vote_user_id' => Yii::$app->user->id,
            ])
            ->count();
        if (!$voteUser) {
            return $this->redirect(['poll']);
        }

        $this->setSeoTitle('?????????????????????? ???? ?????????????????????? ???????????????????? ??????????????????');

        return $this->render('view', [
            'electionPresidentVice' => $electionPresidentVice,
        ]);
    }

    /**
     * @return string|Response
     * @throws Exception
     */
    public function actionPoll()
    {
        if (!$this->myTeam) {
            return $this->redirect(['team/view']);
        }

        $country = $this->myTeam->stadium->city->country;
        Yii::$app->request->setQueryParams(['id' => $country->country_id]);

        if ($country->country_president_vice_id || !$country->country_president_id) {
            return $this->redirect(['team/view']);
        }

        $electionPresidentVice = ElectionPresidentVice::find()
            ->where([
                'election_president_vice_country_id' => $country->country_id,
                'election_president_vice_election_status_id' => ElectionStatus::CANDIDATES
            ])
            ->count();

        if ($electionPresidentVice) {
            return $this->redirect(['application']);
        }

        $electionPresidentVice = ElectionPresidentVice::find()
            ->where([
                'election_president_vice_country_id' => $country->country_id,
                'election_president_vice_election_status_id' => ElectionStatus::OPEN,
            ])
            ->limit(1)
            ->one();

        if (!$electionPresidentVice) {
            return $this->redirect(['team/view']);
        }

        $voteUser = ElectionPresidentViceVote::find()
            ->where([
                'election_president_vice_vote_application_id' => ElectionPresidentViceApplication::find()
                    ->select(['election_president_vice_application_id'])
                    ->where(['election_president_vice_application_election_id' => $electionPresidentVice->election_president_vice_id]),
                'election_president_vice_vote_user_id' => Yii::$app->user->id,
            ])
            ->count();
        if ($voteUser) {
            return $this->redirect(['view']);
        }

        $model = new ElectionPresidentViceVote();
        $model->election_president_vice_vote_user_id = Yii::$app->user->id;
        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            $this->setSuccessFlash('?????? ?????????? ?????????????? ????????????????.');
            return $this->refresh();
        }

        $this->setSeoTitle('?????????????????????? ???? ???????????????????? ??????????????????');

        return $this->render('poll', [
            'electionPresidentVice' => $electionPresidentVice,
            'model' => $model,
        ]);
    }
}
