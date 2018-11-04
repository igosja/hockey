<?php

namespace frontend\controllers;

use common\components\HockeyHelper;
use common\models\Championship;
use common\models\Country;
use common\models\Division;
use common\models\Game;
use common\models\Schedule;
use common\models\Stage;
use common\models\TournamentType;
use Yii;
use yii\data\ActiveDataProvider;
use yii\helpers\ArrayHelper;
use yii\web\Response;

/**
 * Class ChampionshipController
 * @package frontend\controllers
 */
class ChampionshipController extends BaseController
{
    /**
     * @return Response
     */
    public function actionIndex(): Response
    {
        $seasonId = Yii::$app->request->get('seasonId', $this->seasonId);

        $schedule = Schedule::find()
            ->where([
                'schedule_tournament_type_id' => TournamentType::CHAMPIONSHIP,
                'schedule_season_id' => $seasonId,
            ])
            ->andWhere(['<=', 'schedule_date', HockeyHelper::unixTimeStamp()])
            ->orderBy(['schedule_date' => SORT_DESC])
            ->limit(1)
            ->one();
        if (!$schedule) {
            $schedule = Schedule::find()
                ->where([
                    'schedule_tournament_type_id' => TournamentType::CHAMPIONSHIP,
                    'schedule_season_id' => $seasonId,
                ])
                ->andWhere(['>', 'schedule_date', HockeyHelper::unixTimeStamp()])
                ->orderBy(['schedule_date' => SORT_ASC])
                ->limit(1)
                ->one();
        }

        if ($schedule->schedule_stage_id > Stage::TOUR_30) {
            return $this->redirect([
                'championship/playoff',
                'countryId' => Yii::$app->request->get('countryId', Country::DEFAULT_ID),
                'divisionId' => Yii::$app->request->get('divisionId', Division::D1),
                'seasonId' => $seasonId,
            ]);
        }

        return $this->redirect([
            'championship/table',
            'countryId' => Yii::$app->request->get('countryId', Country::DEFAULT_ID),
            'divisionId' => Yii::$app->request->get('divisionId', Division::D1),
            'seasonId' => $seasonId,
        ]);
    }

    /**
     * @return string
     * @throws \yii\web\NotFoundHttpException
     */
    public function actionTable(): string
    {
        $seasonId = Yii::$app->request->get('season_id', $this->seasonId);
        $countryId = Yii::$app->request->get('countryId', Country::DEFAULT_ID);
        $divisionId = Yii::$app->request->get('divisionId', Division::D1);
        $stageId = Yii::$app->request->get('stageId');

        $country = Country::find()
            ->where(['country_id' => $countryId])
            ->limit(1)
            ->one();
        $this->notFound($country);

        if (!$stageId) {
            $schedule = Schedule::find()
                ->where([
                    'schedule_tournament_type_id' => TournamentType::CHAMPIONSHIP,
                    'schedule_season_id' => $seasonId,
                ])
                ->andWhere(['<=', 'schedule_date', HockeyHelper::unixTimeStamp()])
                ->orderBy(['schedule_date' => SORT_DESC])
                ->limit(1)
                ->one();
            if (!$schedule) {
                $schedule = Schedule::find()
                    ->where([
                        'schedule_tournament_type_id' => TournamentType::CHAMPIONSHIP,
                        'schedule_season_id' => $seasonId,
                    ])
                    ->andWhere(['>', 'schedule_date', HockeyHelper::unixTimeStamp()])
                    ->orderBy(['schedule_date' => SORT_ASC])
                    ->limit(1)
                    ->one();
            }
            $stageId = $schedule->schedule_stage_id;
        } else {
            $schedule = Schedule::find()
                ->where([
                    'schedule_tournament_type_id' => TournamentType::CHAMPIONSHIP,
                    'schedule_season_id' => $seasonId,
                    'schedule_stage_id' => $stageId,
                ])
                ->limit(1)
                ->one();
        }

        $this->notFound($schedule);

        $query = Championship::find()
            ->where([
                'championship_season_id' => $seasonId,
                'championship_country_id' => $countryId,
                'championship_division_id' => $divisionId,
            ])
            ->orderBy(['championship_place' => SORT_ASC]);

        $dataProvider = new ActiveDataProvider([
            'pagination' => false,
            'query' => $query,
            'sort' => false,
        ]);

        $stageArray = Schedule::find()
            ->where([
                'schedule_tournament_type_id' => TournamentType::CHAMPIONSHIP,
                'schedule_season_id' => $seasonId,
            ])
            ->andWhere(['<=', 'schedule_stage_id', Stage::TOUR_30])
            ->orderBy(['schedule_stage_id' => SORT_ASC])
            ->all();
        $stageArray = ArrayHelper::map($stageArray, 'stage.stage_id', 'stage.stage_name');

        $gameArray = Game::find()
            ->joinWith(['schedule'])
            ->where([
                'schedule_stage_id' => $stageId,
                'schedule.schedule_season_id' => $seasonId,
                'schedule.schedule_tournament_type_id' => TournamentType::CHAMPIONSHIP,
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

        $this->setSeoTitle($country->country_name . '. Национальный чемпионат');

        return $this->render('table', [
            'country' => $country,
            'dataProvider' => $dataProvider,
            'divisionId' => $divisionId,
            'gameArray' => $gameArray,
            'seasonArray' => $this->getSeasonArray($countryId, $divisionId),
            'seasonId' => $seasonId,
            'stageArray' => $stageArray,
            'stageId' => $stageId,
        ]);
    }

    /**
     * @return string
     */
    public function actionPlayoff(): string
    {
        $this->setSeoTitle('Национальный чемпионат');

        return $this->render('playoff', [
            'dataProvider' => new ActiveDataProvider(),
        ]);
    }

    /**
     * @param int $countryId
     * @param int $divisionId
     * @return array
     */
    private function getSeasonArray(int $countryId, int $divisionId): array
    {
        $season = Championship::find()
            ->select(['championship_season_id'])
            ->where(['championship_country_id' => $countryId, 'championship_division_id' => $divisionId])
            ->groupBy(['championship_season_id'])
            ->orderBy(['championship_season_id' => SORT_DESC])
            ->all();
        return ArrayHelper::map($season, 'championship_season_id', 'championship_season_id');
    }
}
