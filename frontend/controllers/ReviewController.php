<?php

namespace frontend\controllers;

use common\models\Championship;
use common\models\Country;
use common\models\Division;
use common\models\Game;
use common\models\Review;
use common\models\Schedule;
use common\models\TournamentType;
use common\models\UserRole;
use frontend\models\CreateReview;
use yii\filters\AccessControl;

/**
 * Class ReviewController
 * @package frontend\controllers
 */
class ReviewController extends AbstractController
{
    /**
     * @return array
     */
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::class,
                'only' => ['create', 'delete'],
                'rules' => [
                    [
                        'actions' => ['create', 'delete'],
                        'allow' => true,
                        'roles' => ['@'],
                    ],
                ],
            ],
        ];
    }

    /**
     * @param $id
     * @return string
     * @throws \yii\web\NotFoundHttpException
     */
    public function actionView($id)
    {
        $review = Review::find()
            ->where(['review_id' => $id])
            ->limit(1)
            ->one();
        $this->notFound($review);

        $this->setSeoTitle('Обзор национального чемпионата');

        return $this->render('view', [
            'review' => $review,
        ]);
    }

    /**
     * @param $id
     * @return \yii\web\Response
     * @throws \Throwable
     * @throws \yii\db\StaleObjectException
     * @throws \yii\web\ForbiddenHttpException
     * @throws \yii\web\NotFoundHttpException
     */
    public function actionDelete($id)
    {
        if (UserRole::ADMIN != $this->user->user_user_role_id) {
            $this->forbiddenRole();
        }
        $review = Review::find()
            ->where(['review_id' => $id])
            ->limit(1)
            ->one();
        $this->notFound($review);

        $countryId = $review->review_country_id;
        $divisionId = $review->review_division_id;
        $seasonId = $review->review_season_id;

        $review->delete();
        $this->setSuccessFlash();

        return $this->redirect([
            'championship/index',
            'countryId' => $countryId,
            'divisionId' => $divisionId,
            'seasonId' => $seasonId,
        ]);
    }

    /**
     * @param $countryId
     * @param $divisionId
     * @param $scheduleId
     * @return string|\yii\web\Response
     * @throws \yii\db\Exception
     * @throws \yii\web\NotFoundHttpException
     */
    public function actionCreate($countryId, $divisionId, $scheduleId)
    {
        $country = Country::find()
            ->where(['country_id' => $countryId])
            ->limit(1)
            ->one();
        $this->notFound($country);

        $division = Division::find()
            ->where(['division_id' => $divisionId])
            ->limit(1)
            ->one();
        $this->notFound($division);

        $schedule = Schedule::find()
            ->where(['schedule_id' => $scheduleId])
            ->limit(1)
            ->one();
        $this->notFound($schedule);

        $gameArray = Game::find()
            ->joinWith(['schedule'])
            ->where([
                'schedule_id' => $scheduleId,
                'schedule_season_id' => $schedule->schedule_season_id,
                'schedule_tournament_type_id' => TournamentType::CHAMPIONSHIP,
                'game_home_team_id' => Championship::find()
                    ->select(['championship_team_id'])
                    ->where([
                        'championship_season_id' => $schedule->schedule_season_id,
                        'championship_country_id' => $countryId,
                        'championship_division_id' => $divisionId,
                    ])
            ])
            ->orderBy(['game_id' => SORT_ASC])
            ->all();

        $model = new CreateReview([
            'countryId' => $countryId,
            'divisionId' => $divisionId,
            'scheduleId' => $schedule->schedule_id,
            'seasonId' => $schedule->schedule_season_id,
            'stageId' => $schedule->schedule_stage_id,
        ]);
        if ($model->saveReview()) {
            $this->setSuccessFlash();
            return $this->redirect([
                'championship/index',
                'countryId' => $countryId,
                'divisionId' => $divisionId,
                'seasonId' => $schedule->schedule_season_id,
            ]);
        }

        $this->setSeoTitle('Создание обзора');

        return $this->render('create', [
            'country' => $country,
            'division' => $division,
            'gameArray' => $gameArray,
            'model' => $model,
            'schedule' => $schedule,
        ]);
    }
}