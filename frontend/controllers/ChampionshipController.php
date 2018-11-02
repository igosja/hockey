<?php

namespace frontend\controllers;

use common\components\HockeyHelper;
use common\models\Championship;
use common\models\Country;
use common\models\Division;
use common\models\Schedule;
use common\models\Stage;
use common\models\TournamentType;
use Yii;
use yii\data\ActiveDataProvider;
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
     */
    public function actionTable(): string
    {
        $seasonId = Yii::$app->request->get('season_id', $this->seasonId);
        $countryId = Yii::$app->request->get('countryId', Country::DEFAULT_ID);
        $divisionId = Yii::$app->request->get('divisionId', Division::D1);
        $stageId = Yii::$app->request->get('stageId');

        $scheduleArray = Schedule::find()
            ->where([
                'schedule_tournament_type_id' => TournamentType::CHAMPIONSHIP,
                'schedule_season_id' => $seasonId,
            ])
            ->andWhere(['<=', 'schedule_stage_id', Stage::TOUR_30])
            ->orderBy(['schedule_stage_id' => SORT_ASC])
            ->all();

        if ($stageId) {
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
        }

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

        $this->setSeoTitle('Национальный чемпионат');

        return $this->render('table', [
            'dataProvider' => $dataProvider,
            'schedule' => $schedule,
        ]);
    }

    /**
     * @return string
     */
    public function actionPlayoff(): string
    {
        $seasonId = Yii::$app->request->get('season_id', $this->seasonId);
        $countryId = Yii::$app->request->get('countryId', Country::DEFAULT_ID);
        $divisionId = Yii::$app->request->get('divisionId', Division::D1);

        $this->setSeoTitle('Национальный чемпионат');

        return $this->render('playoff', [
            'seasonId' => $seasonId,
            'countryId' => $countryId,
            'divisionId' => $divisionId,
        ]);
    }
}
