<?php

namespace frontend\controllers;

use common\models\Championship;
use common\models\Country;
use common\models\Division;
use common\models\Game;
use common\models\Schedule;
use common\models\TournamentType;
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
     * @param $countryId
     * @param $divisionId
     * @param $scheduleId
     * @param $seasonId
     * @return string
     * @throws \yii\web\NotFoundHttpException
     */
    public function actionCreate($countryId, $divisionId, $scheduleId, $seasonId)
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
                'schedule_season_id' => $seasonId,
                'schedule_tournament_type_id' => TournamentType::CHAMPIONSHIP,
                'game_home_team_id' => Championship::find()
                    ->select(['championship_team_id'])
                    ->where([
                        'championship_season_id' => $seasonId,
                        'championship_country_id' => $countryId,
                        'championship_division_id' => $divisionId,
                    ])
            ])
            ->orderBy(['game_id' => SORT_ASC])
            ->all();

        $this->setSeoTitle('Создание обзора');

        return $this->render('create', [
            'country' => $country,
            'division' => $division,
            'gameArray' => $gameArray,
            'schedule' => $schedule,
        ]);
    }
}
