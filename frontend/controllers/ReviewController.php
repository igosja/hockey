<?php

namespace frontend\controllers;

use common\models\Championship;
use common\models\Country;
use common\models\Division;
use common\models\Game;
use common\models\Review;
use common\models\ReviewVote;
use common\models\Schedule;
use common\models\TournamentType;
use common\models\UserRole;
use Exception;
use frontend\models\CreateReview;
use Throwable;
use Yii;
use yii\db\StaleObjectException;
use yii\filters\AccessControl;
use yii\web\ForbiddenHttpException;
use yii\web\NotFoundHttpException;
use yii\web\Response;

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
     * @throws NotFoundHttpException
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
     * @return Response
     * @throws Throwable
     * @throws StaleObjectException
     * @throws ForbiddenHttpException
     * @throws NotFoundHttpException
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
     * @return string|Response
     * @throws \yii\db\Exception
     * @throws NotFoundHttpException
     */
    public function actionCreate($countryId, $divisionId, $scheduleId)
    {
        if (!$this->user->user_date_confirm || $this->user->user_date_block_forum > time() || $this->user->user_date_block_comment > time()) {
            return $this->redirect([
                'championship/index',
                'countryId' => $countryId,
                'divisionId' => $divisionId,
            ]);
        }

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

    /**
     * @param $id
     * @return Response
     * @throws Exception
     * @throws NotFoundHttpException
     */
    public function actionVote($id)
    {
        $game = Review::find()
            ->where(['review_id' => $id])
            ->limit(1)
            ->one();
        $this->notFound($game);

        $vote = Yii::$app->request->get('vote', 1);
        if (!in_array($vote, [-1, 1])) {
            $vote = 1;
        }

        $model = ReviewVote::find()
            ->where(['review_vote_review_id' => $id, 'review_vote_user_id' => $this->user->user_id])
            ->limit(1)
            ->one();
        if (!$model) {
            $model = new ReviewVote();
            $model->review_vote_review_id = $id;
            $model->review_vote_user_id = $this->user->user_id;
        }
        $model->review_vote_rating = $vote;
        $model->save();

        return $this->redirect(['review/view', 'id' => $id]);
    }
}
