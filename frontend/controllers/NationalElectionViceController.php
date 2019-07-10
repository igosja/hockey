<?php

namespace frontend\controllers;

use common\models\Country;
use common\models\ElectionNationalVice;
use common\models\ElectionNationalViceApplication;
use common\models\ElectionNationalViceVote;
use common\models\ElectionStatus;
use common\models\National;
use common\models\NationalType;
use Exception;
use Throwable;
use Yii;
use yii\db\ActiveRecord;
use yii\db\StaleObjectException;
use yii\filters\AccessControl;
use yii\web\Response;

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

        $national = $this->getNational($country);

        if (!$national) {
            return $this->redirect(['team/view']);
        }

        $electionNationalVice = ElectionNationalVice::find()
            ->where([
                'election_national_vice_country_id' => $country->country_id,
                'election_national_vice_national_type_id' => $national->national_national_type_id,
                'election_national_vice_election_status_id' => ElectionStatus::OPEN
            ])
            ->count();

        if ($electionNationalVice) {
            return $this->redirect(['view']);
        }

        $position = National::find()
            ->where([
                'or',
                ['national_user_id' => $this->user->user_id],
                ['national_vice_id' => $this->user->user_id],
            ])
            ->count();

        if ($position) {
            $this->setErrorFlash('Можно быть тренером или заместителем тренера только в одной сборной.');
            return $this->redirect(['team/view']);
        }

        $electionNationalVice = ElectionNationalVice::find()
            ->where([
                'election_national_vice_country_id' => $country->country_id,
                'election_national_vice_national_type_id' => $national->national_national_type_id,
                'election_national_vice_election_status_id' => ElectionStatus::CANDIDATES,
            ])
            ->limit(1)
            ->one();
        if (!$electionNationalVice) {
            $electionNationalVice = new ElectionNationalVice();
            $electionNationalVice->election_national_vice_country_id = $country->country_id;
            $electionNationalVice->election_national_vice_national_type_id = $national->national_national_type_id;
            $electionNationalVice->save();
        }

        $model = ElectionNationalViceApplication::find()
            ->where([
                'election_national_vice_application_election_id' => $electionNationalVice->election_national_vice_id,
                'election_national_vice_application_user_id' => $this->user->user_id,
            ])
            ->limit(1)
            ->one();
        if (!$model) {
            $model = new ElectionNationalViceApplication();
            $model->election_national_vice_application_election_id = $electionNationalVice->election_national_vice_id;
            $model->election_national_vice_application_user_id = $this->user->user_id;
        }

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            $this->setSuccessFlash('Изменения успшено сохранены.');
            return $this->refresh();
        }

        $this->setSeoTitle('Подача заявки на должность заместителя тренера сборной');
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

        $national = $this->getNational($country);

        if (!$national) {
            return $this->redirect(['team/view']);
        }

        $electionNationalVice = ElectionNationalVice::find()
            ->where([
                'election_national_vice_country_id' => $country->country_id,
                'election_national_vice_national_type_id' => $national->national_national_type_id,
                'election_national_vice_election_status_id' => ElectionStatus::OPEN
            ])
            ->count();

        if ($electionNationalVice) {
            return $this->redirect(['view']);
        }

        $electionNationalVice = ElectionNationalVice::find()
            ->where([
                'election_national_vice_country_id' => $country->country_id,
                'election_national_vice_national_type_id' => $national->national_national_type_id,
                'election_national_vice_election_status_id' => ElectionStatus::CANDIDATES,
            ])
            ->limit(1)
            ->one();
        if (!$electionNationalVice) {
            $electionNationalVice = new ElectionNationalVice();
            $electionNationalVice->election_national_vice_country_id = $country->country_id;
            $electionNationalVice->election_national_vice_national_type_id = $national->national_national_type_id;
            $electionNationalVice->save();
        }

        $model = ElectionNationalViceApplication::find()
            ->where([
                'election_national_vice_application_election_id' => $electionNationalVice->election_national_vice_id,
                'election_national_vice_application_user_id' => $this->user->user_id,
            ])
            ->limit(1)
            ->one();
        if (!$model) {
            return $this->redirect(['national-election-vice/application']);
        }

        $model->delete();

        $this->setSuccessFlash('Заявка успешно удалена.');
        return $this->redirect(['national-election-vice/application']);
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

        $national = $this->getNational($country);

        if (!$national) {
            return $this->redirect(['team/view']);
        }

        $electionNationalVice = ElectionNationalVice::find()
            ->where([
                'election_national_vice_country_id' => $country->country_id,
                'election_national_vice_national_type_id' => $national->national_national_type_id,
                'election_national_vice_election_status_id' => ElectionStatus::CANDIDATES
            ])
            ->count();

        if ($electionNationalVice) {
            return $this->redirect(['application']);
        }

        $electionNationalVice = ElectionNationalVice::find()
            ->where([
                'election_national_vice_country_id' => $country->country_id,
                'election_national_vice_national_type_id' => $national->national_national_type_id,
                'election_national_vice_election_status_id' => ElectionStatus::OPEN,
            ])
            ->limit(1)
            ->one();

        if (!$electionNationalVice) {
            return $this->redirect(['team/view']);
        }

        $voteUser = ElectionNationalViceVote::find()
            ->where([
                'election_national_vice_vote_application_id' => ElectionNationalViceApplication::find()
                    ->select(['election_national_vice_application_id'])
                    ->where(['election_national_vice_application_election_id' => $electionNationalVice->election_national_vice_id]),
                'election_national_vice_vote_user_id' => $this->user->user_id,
            ])
            ->count();
        if (!$voteUser) {
            return $this->redirect(['poll']);
        }

        $this->setSeoTitle('Голосование за заместителя тренера сборной');

        return $this->render('view', [
            'electionNationalVice' => $electionNationalVice,
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

        $national = $this->getNational($country);

        if (!$national) {
            return $this->redirect(['team/view']);
        }

        $electionNationalVice = ElectionNationalVice::find()
            ->where([
                'election_national_vice_country_id' => $country->country_id,
                'election_national_vice_national_type_id' => $national->national_national_type_id,
                'election_national_vice_election_status_id' => ElectionStatus::CANDIDATES
            ])
            ->count();

        if ($electionNationalVice) {
            return $this->redirect(['application']);
        }

        $electionNationalVice = ElectionNationalVice::find()
            ->where([
                'election_national_vice_country_id' => $country->country_id,
                'election_national_vice_national_type_id' => $national->national_national_type_id,
                'election_national_vice_election_status_id' => ElectionStatus::OPEN,
            ])
            ->limit(1)
            ->one();

        if (!$electionNationalVice) {
            return $this->redirect(['team/view']);
        }

        $voteUser = ElectionNationalViceVote::find()
            ->where([
                'election_national_vice_vote_application_id' => ElectionNationalViceApplication::find()
                    ->select(['election_national_vice_application_id'])
                    ->where(['election_national_vice_application_election_id' => $electionNationalVice->election_national_vice_id]),
                'election_national_vice_vote_user_id' => $this->user->user_id,
            ])
            ->count();
        if ($voteUser) {
            return $this->redirect(['view']);
        }

        $model = new ElectionNationalViceVote();
        $model->election_national_vice_vote_user_id = $this->user->user_id;
        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            $this->setSuccessFlash('Ваш голос успешно сохранён.');
            return $this->refresh();
        }

        $this->setSeoTitle('Голосование за заместителя тренера сборной');

        return $this->render('poll', [
            'electionNationalVice' => $electionNationalVice,
            'model' => $model,
        ]);
    }

    /**
     * @param Country $country
     * @return array|National|ActiveRecord|null
     */
    private function getNational(Country $country)
    {
        for ($i = NationalType::MAIN; $i <= NationalType::U19; $i++) {
            $national = National::find()
                ->where(['national_national_type_id' => $i, 'national_country_id' => $country->country_id])
                ->limit(1)
                ->one();

            if (!$national->national_vice_id && $national->national_user_id) {
                return $national;
            }
        }

        return null;
    }
}
