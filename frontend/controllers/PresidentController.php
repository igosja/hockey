<?php

namespace frontend\controllers;

use common\models\Country;
use common\models\ElectionPresident;
use common\models\ElectionPresidentApplication;
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
            return $this->redirect(['president/vote']);
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
}
