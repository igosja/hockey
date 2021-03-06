<?php

namespace frontend\controllers;

use common\models\Country;
use common\models\ElectionNational;
use common\models\ElectionNationalApplication;
use common\models\ElectionNationalVote;
use common\models\ElectionStatus;
use common\models\National;
use common\models\NationalType;
use common\models\Player;
use common\models\Position;
use Exception;
use Throwable;
use Yii;
use yii\db\ActiveRecord;
use yii\db\StaleObjectException;
use yii\filters\AccessControl;
use yii\helpers\ArrayHelper;
use yii\web\Response;

/**
 * Class NationalElectionController
 * @package frontend\controllers
 */
class NationalElectionController extends AbstractController
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

        $electionNational = ElectionNational::find()
            ->where([
                'election_national_country_id' => $country->country_id,
                'election_national_national_type_id' => $national->national_national_type_id,
                'election_national_election_status_id' => ElectionStatus::OPEN
            ])
            ->count();

        if ($electionNational) {
            return $this->redirect(['view']);
        }

        $position = National::find()
            ->where(['national_user_id' => $this->user->user_id])
            ->count();

        if ($position) {
            $this->setErrorFlash('?????????? ???????? ???????????????? ???????????? ?? ?????????? ??????????????.');
            return $this->redirect(['team/view']);
        }

        $electionNational = ElectionNational::find()
            ->where([
                'election_national_country_id' => $country->country_id,
                'election_national_national_type_id' => $national->national_national_type_id,
                'election_national_election_status_id' => ElectionStatus::CANDIDATES,
            ])
            ->limit(1)
            ->one();
        if (!$electionNational) {
            $electionNational = new ElectionNational();
            $electionNational->election_national_country_id = $country->country_id;
            $electionNational->election_national_national_type_id = $national->national_national_type_id;
            $electionNational->save();
        }

        $model = ElectionNationalApplication::find()
            ->where([
                'election_national_application_election_id' => $electionNational->election_national_id,
                'election_national_application_user_id' => $this->user->user_id,
            ])
            ->limit(1)
            ->one();
        if (!$model) {
            $model = new ElectionNationalApplication();
            $model->election_national_application_election_id = $electionNational->election_national_id;
            $model->election_national_application_user_id = $this->user->user_id;
        }

        if ($model->saveApplication()) {
            $this->setSuccessFlash('?????????????????? ?????????????? ??????????????????.');
            return $this->refresh();
        }

        $gkArray = Player::find()
            ->with([
                'name',
                'playerPosition.position',
                'playerSpecial.special',
                'surname',
                'team.stadium.city.country',
            ])
            ->where(['player_country_id' => $country->country_id, 'player_position_id' => Position::GK, 'player_national_id' => 0])
            ->andWhere(['!=', 'player_team_id', 0])
            ->andFilterWhere(['<=', 'player_age', $national->nationalType->getAgeLimit()])
            ->orderBy(['player_power_nominal_s' => SORT_DESC])
            ->limit(15)
            ->all();

        if (count($gkArray) < 2) {
            $gkArray = ArrayHelper::merge(
                $gkArray,
                Player::find()
                    ->with([
                        'name',
                        'playerPosition.position',
                        'playerSpecial.special',
                        'surname',
                        'team.stadium.city.country',
                    ])
                    ->where([
                        'player_country_id' => $country->country_id,
                        'player_position_id' => Position::GK,
                        'player_national_id' => 0,
                        'player_team_id' => 0,
                    ])
                    ->andFilterWhere(['<=', 'player_age', $national->nationalType->getAgeLimit()])
                    ->orderBy(['player_power_nominal_s' => SORT_DESC])
                    ->limit(2 - count($gkArray))
                    ->all()
            );
        }

        $ldArray = Player::find()
            ->with([
                'name',
                'playerPosition.position',
                'playerSpecial.special',
                'surname',
                'team.stadium.city.country',
            ])
            ->where(['player_country_id' => $country->country_id, 'player_position_id' => Position::LD, 'player_national_id' => 0])
            ->andWhere(['!=', 'player_team_id', 0])
            ->andFilterWhere(['<=', 'player_age', $national->nationalType->getAgeLimit()])
            ->orderBy(['player_power_nominal_s' => SORT_DESC])
            ->limit(45)
            ->all();

        if (count($ldArray) < 6) {
            $ldArray = ArrayHelper::merge(
                $ldArray,
                Player::find()
                    ->with([
                        'name',
                        'playerPosition.position',
                        'playerSpecial.special',
                        'surname',
                        'team.stadium.city.country',
                    ])
                    ->where([
                        'player_country_id' => $country->country_id,
                        'player_position_id' => Position::LD,
                        'player_national_id' => 0,
                        'player_team_id' => 0,
                    ])
                    ->andFilterWhere(['<=', 'player_age', $national->nationalType->getAgeLimit()])
                    ->orderBy(['player_power_nominal_s' => SORT_DESC])
                    ->limit(6 - count($ldArray))
                    ->all()
            );
        }

        $rdArray = Player::find()
            ->with([
                'name',
                'playerPosition.position',
                'playerSpecial.special',
                'surname',
                'team.stadium.city.country',
            ])
            ->where(['player_country_id' => $country->country_id, 'player_position_id' => Position::RD, 'player_national_id' => 0])
            ->andWhere(['!=', 'player_team_id', 0])
            ->andFilterWhere(['<=', 'player_age', $national->nationalType->getAgeLimit()])
            ->orderBy(['player_power_nominal_s' => SORT_DESC])
            ->limit(45)
            ->all();

        if (count($rdArray) < 6) {
            $rdArray = ArrayHelper::merge(
                $rdArray,
                Player::find()
                    ->with([
                        'name',
                        'playerPosition.position',
                        'playerSpecial.special',
                        'surname',
                        'team.stadium.city.country',
                    ])
                    ->where([
                        'player_country_id' => $country->country_id,
                        'player_position_id' => Position::RD,
                        'player_national_id' => 0,
                        'player_team_id' => 0,
                    ])
                    ->andFilterWhere(['<=', 'player_age', $national->nationalType->getAgeLimit()])
                    ->orderBy(['player_power_nominal_s' => SORT_DESC])
                    ->limit(6 - count($rdArray))
                    ->all()
            );
        }

        $lwArray = Player::find()
            ->with([
                'name',
                'playerPosition.position',
                'playerSpecial.special',
                'surname',
                'team.stadium.city.country',
            ])
            ->where(['player_country_id' => $country->country_id, 'player_position_id' => Position::LW, 'player_national_id' => 0])
            ->andWhere(['!=', 'player_team_id', 0])
            ->andFilterWhere(['<=', 'player_age', $national->nationalType->getAgeLimit()])
            ->orderBy(['player_power_nominal_s' => SORT_DESC])
            ->limit(45)
            ->all();

        if (count($lwArray) < 6) {
            $lwArray = ArrayHelper::merge(
                $lwArray,
                Player::find()
                    ->with([
                        'name',
                        'playerPosition.position',
                        'playerSpecial.special',
                        'surname',
                        'team.stadium.city.country',
                    ])
                    ->where([
                        'player_country_id' => $country->country_id,
                        'player_position_id' => Position::LW,
                        'player_national_id' => 0,
                        'player_team_id' => 0,
                    ])
                    ->andFilterWhere(['<=', 'player_age', $national->nationalType->getAgeLimit()])
                    ->orderBy(['player_power_nominal_s' => SORT_DESC])
                    ->limit(6 - count($lwArray))
                    ->all()
            );
        }

        $cfArray = Player::find()
            ->with([
                'name',
                'playerPosition.position',
                'playerSpecial.special',
                'surname',
                'team.stadium.city.country',
            ])
            ->where(['player_country_id' => $country->country_id, 'player_position_id' => Position::CF, 'player_national_id' => 0])
            ->andWhere(['!=', 'player_team_id', 0])
            ->andFilterWhere(['<=', 'player_age', $national->nationalType->getAgeLimit()])
            ->orderBy(['player_power_nominal_s' => SORT_DESC])
            ->limit(45)
            ->all();

        if (count($cfArray) < 6) {
            $cfArray = ArrayHelper::merge(
                $cfArray,
                Player::find()
                    ->with([
                        'name',
                        'playerPosition.position',
                        'playerSpecial.special',
                        'surname',
                        'team.stadium.city.country',
                    ])
                    ->where([
                        'player_country_id' => $country->country_id,
                        'player_position_id' => Position::CF,
                        'player_national_id' => 0,
                        'player_team_id' => 0,
                    ])
                    ->andFilterWhere(['<=', 'player_age', $national->nationalType->getAgeLimit()])
                    ->orderBy(['player_power_nominal_s' => SORT_DESC])
                    ->limit(6 - count($cfArray))
                    ->all()
            );
        }

        $rwArray = Player::find()
            ->with([
                'name',
                'playerPosition.position',
                'playerSpecial.special',
                'surname',
                'team.stadium.city.country',
            ])
            ->where(['player_country_id' => $country->country_id, 'player_position_id' => Position::RW, 'player_national_id' => 0])
            ->andWhere(['!=', 'player_team_id', 0])
            ->andFilterWhere(['<=', 'player_age', $national->nationalType->getAgeLimit()])
            ->orderBy(['player_power_nominal_s' => SORT_DESC])
            ->limit(45)
            ->all();

        if (count($rwArray) < 6) {
            $rwArray = ArrayHelper::merge(
                $rwArray,
                Player::find()
                    ->with([
                        'name',
                        'playerPosition.position',
                        'playerSpecial.special',
                        'surname',
                        'team.stadium.city.country',
                    ])
                    ->where([
                        'player_country_id' => $country->country_id,
                        'player_position_id' => Position::RW,
                        'player_national_id' => 0,
                        'player_team_id' => 0,
                    ])
                    ->andFilterWhere(['<=', 'player_age', $national->nationalType->getAgeLimit()])
                    ->orderBy(['player_power_nominal_s' => SORT_DESC])
                    ->limit(6 - count($rwArray))
                    ->all()
            );
        }

        $this->setSeoTitle('???????????? ???????????? ???? ?????????????????? ?????????????? ??????????????');
        return $this->render('application', [
            'cfArray' => $cfArray,
            'gkArray' => $gkArray,
            'ldArray' => $ldArray,
            'lwArray' => $lwArray,
            'model' => $model,
            'rdArray' => $rdArray,
            'rwArray' => $rwArray,
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

        $electionNational = ElectionNational::find()
            ->where([
                'election_national_country_id' => $country->country_id,
                'election_national_national_type_id' => $national->national_national_type_id,
                'election_national_election_status_id' => ElectionStatus::OPEN
            ])
            ->count();

        if ($electionNational) {
            return $this->redirect(['view']);
        }

        $electionNational = ElectionNational::find()
            ->where([
                'election_national_country_id' => $country->country_id,
                'election_national_national_type_id' => $national->national_national_type_id,
                'election_national_election_status_id' => ElectionStatus::CANDIDATES,
            ])
            ->limit(1)
            ->one();
        if (!$electionNational) {
            $electionNational = new ElectionNational();
            $electionNational->election_national_country_id = $country->country_id;
            $electionNational->election_national_national_type_id = $national->national_national_type_id;
            $electionNational->save();
        }

        $model = ElectionNationalApplication::find()
            ->where([
                'election_national_application_election_id' => $electionNational->election_national_id,
                'election_national_application_user_id' => $this->user->user_id,
            ])
            ->limit(1)
            ->one();
        if (!$model) {
            return $this->redirect(['national-election/application']);
        }

        $model->delete();

        $this->setSuccessFlash('???????????? ?????????????? ??????????????.');
        return $this->redirect(['national-election/application']);
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

        $electionNational = ElectionNational::find()
            ->where([
                'election_national_country_id' => $country->country_id,
                'election_national_national_type_id' => $national->national_national_type_id,
                'election_national_election_status_id' => ElectionStatus::CANDIDATES
            ])
            ->count();

        if ($electionNational) {
            return $this->redirect(['application']);
        }

        $electionNational = ElectionNational::find()
            ->where([
                'election_national_country_id' => $country->country_id,
                'election_national_national_type_id' => $national->national_national_type_id,
                'election_national_election_status_id' => ElectionStatus::OPEN,
            ])
            ->limit(1)
            ->one();

        if (!$electionNational) {
            return $this->redirect(['team/view']);
        }

        $voteUser = ElectionNationalVote::find()
            ->where([
                'election_national_vote_application_id' => ElectionNationalApplication::find()
                    ->select(['election_national_application_id'])
                    ->where(['election_national_application_election_id' => $electionNational->election_national_id]),
                'election_national_vote_user_id' => $this->user->user_id,
            ])
            ->count();
        if (!$voteUser) {
            return $this->redirect(['poll']);
        }

        $this->setSeoTitle('?????????????????????? ???? ?????????????? ??????????????');
        return $this->render('view', [
            'electionNational' => $electionNational,
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

        if ($national->national_user_id) {
            return $this->redirect(['team/view']);
        }

        $electionNational = ElectionNational::find()
            ->where([
                'election_national_country_id' => $country->country_id,
                'election_national_national_type_id' => $national->national_national_type_id,
                'election_national_election_status_id' => ElectionStatus::CANDIDATES
            ])
            ->count();

        if ($electionNational) {
            return $this->redirect(['application']);
        }

        $electionNational = ElectionNational::find()
            ->where([
                'election_national_country_id' => $country->country_id,
                'election_national_national_type_id' => $national->national_national_type_id,
                'election_national_election_status_id' => ElectionStatus::OPEN,
            ])
            ->limit(1)
            ->one();

        if (!$electionNational) {
            return $this->redirect(['team/view']);
        }

        $voteUser = ElectionNationalVote::find()
            ->where([
                'election_national_vote_application_id' => ElectionNationalApplication::find()
                    ->select(['election_national_application_id'])
                    ->where(['election_national_application_election_id' => $electionNational->election_national_id]),
                'election_national_vote_user_id' => $this->user->user_id,
            ])
            ->count();
        if ($voteUser) {
            return $this->redirect(['view']);
        }

        $model = new ElectionNationalVote();
        $model->election_national_vote_user_id = $this->user->user_id;
        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            $this->setSuccessFlash('?????? ?????????? ?????????????? ????????????????.');
            return $this->refresh();
        }

        $this->setSeoTitle('?????????????????????? ???? ?????????????? ??????????????');

        return $this->render('poll', [
            'electionNational' => $electionNational,
            'model' => $model,
        ]);
    }

    /**
     * @param $id
     * @return string|Response
     */
    public function actionPlayer($id)
    {
        if (!$this->myTeam) {
            return $this->redirect(['team/view']);
        }

        $country = $this->myTeam->stadium->city->country;
        Yii::$app->request->setQueryParams(['id' => $country->country_id]);

        $electionNationalApplication = ElectionNationalApplication::find()
            ->where(['election_national_application_id' => $id])
            ->limit(1)
            ->one();

        if (!$electionNationalApplication) {
            return $this->redirect(['team/view']);
        }

        $electionNational = ElectionNational::find()
            ->where(['election_national_id' => $electionNationalApplication->election_national_application_election_id])
            ->limit(1)
            ->one();

        if (!$electionNational) {
            return $this->redirect(['team/view']);
        }

        $this->setSeoTitle('???????????? ?????????????? ??????????????');

        return $this->render('player', [
            'electionNationalApplication' => $electionNationalApplication,
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

            if (!$national->national_user_id) {
                return $national;
            }
        }

        return null;
    }
}
