<?php

namespace frontend\controllers;

use common\models\Championship;
use common\models\Country;
use common\models\Division;
use common\models\Game;
use common\models\Schedule;
use common\models\Stage;
use common\models\StatisticChapter;
use common\models\StatisticPlayer;
use common\models\StatisticTeam;
use common\models\StatisticType;
use common\models\TournamentType;
use common\models\WorldCup;
use Yii;
use yii\data\ActiveDataProvider;
use yii\helpers\ArrayHelper;

/**
 * Class WorldChampionshipController
 * @package frontend\controllers
 */
class WorldChampionshipController extends AbstractController
{
    /**
     * @return string
     * @throws \yii\web\NotFoundHttpException
     */
    public function actionIndex()
    {
        $seasonId = Yii::$app->request->get('season_id', $this->seasonId);
        $divisionId = Yii::$app->request->get('divisionId', Division::D1);
        $stageId = Yii::$app->request->get('stageId');

        if (!$stageId) {
            $schedule = Schedule::find()
                ->where([
                    'schedule_tournament_type_id' => TournamentType::NATIONAL,
                    'schedule_season_id' => $seasonId,
                ])
                ->andWhere(['<=', 'schedule_date', time()])
                ->orderBy(['schedule_date' => SORT_DESC])
                ->limit(1)
                ->one();
            if (!$schedule) {
                $schedule = Schedule::find()
                    ->where([
                        'schedule_tournament_type_id' => TournamentType::NATIONAL,
                        'schedule_season_id' => $seasonId,
                    ])
                    ->andWhere(['>', 'schedule_date', time()])
                    ->orderBy(['schedule_date' => SORT_ASC])
                    ->limit(1)
                    ->one();
            }
            $stageId = $schedule->schedule_stage_id;
        } else {
            $schedule = Schedule::find()
                ->where([
                    'schedule_tournament_type_id' => TournamentType::NATIONAL,
                    'schedule_season_id' => $seasonId,
                    'schedule_stage_id' => $stageId,
                ])
                ->limit(1)
                ->one();
        }

        $this->notFound($schedule);

        $query = WorldCup::find()
            ->where([
                'world_cup_season_id' => $seasonId,
                'world_cup_division_id' => $divisionId,
            ])
            ->orderBy(['world_cup_place' => SORT_ASC]);

        $dataProvider = new ActiveDataProvider([
            'pagination' => false,
            'query' => $query,
            'sort' => false,
        ]);

        $stageArray = Schedule::find()
            ->where([
                'schedule_tournament_type_id' => TournamentType::NATIONAL,
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
                'schedule.schedule_tournament_type_id' => TournamentType::NATIONAL,
                'game_home_national_id' => WorldCup::find()
                    ->select(['world_cup_national_id'])
                    ->where([
                        'world_cup_season_id' => $seasonId,
                        'world_cup_division_id' => $divisionId,
                    ])
            ])
            ->orderBy(['game_id' => SORT_ASC])
            ->all();

        $this->setSeoTitle('Чемпионат мира среди сборных');

        return $this->render('index', [
            'dataProvider' => $dataProvider,
            'divisionArray' => $this->getDivisionLinksArray($seasonId),
            'divisionId' => $divisionId,
            'gameArray' => $gameArray,
            'seasonArray' => $this->getSeasonArray($divisionId),
            'seasonId' => $seasonId,
            'stageArray' => $stageArray,
            'stageId' => $stageId,
        ]);
    }

    /**
     * @param $countryId
     * @param $seasonId
     * @return array
     */
    private function getDivisionLinksArray($seasonId)
    {
        $result = [];

        $worldCupArray = WorldCup::find()
            ->with(['division'])
            ->where([
                'world_cup_season_id' => $seasonId,
            ])
            ->groupBy(['world_cup_division_id'])
            ->orderBy(['world_cup_division_id' => SORT_ASC])
            ->all();
        foreach ($worldCupArray as $worldCup) {
            $result[] = [
                'alias' => [
                    [
                        'world-championship/index',
                        'divisionId' => $worldCup->division->division_id,
                        'seasonId' => $seasonId,
                    ],
                ],
                'text' => $worldCup->division->division_name,
                'url' => [
                    'world-championship/index',
                    'divisionId' => $worldCup->division->division_id,
                    'seasonId' => $seasonId,
                ]
            ];
        }

        return $result;
    }

    /**
     * @param int $divisionId
     * @return array
     */
    private function getSeasonArray($divisionId)
    {
        $season = WorldCup::find()
            ->select(['world_cup_season_id'])
            ->where(['world_cup_division_id' => $divisionId])
            ->groupBy(['world_cup_season_id'])
            ->orderBy(['world_cup_season_id' => SORT_DESC])
            ->all();
        return ArrayHelper::map($season, 'world_cup_season_id', 'world_cup_season_id');
    }

    /**
     * @param int $id
     * @return string
     * @throws \yii\web\NotFoundHttpException
     */
    public function actionStatistics($id = StatisticType::TEAM_NO_PASS)
    {
        $seasonId = Yii::$app->request->get('season_id', $this->seasonId);
        $countryId = Yii::$app->request->get('countryId', Country::DEFAULT_ID);
        $divisionId = Yii::$app->request->get('divisionId', Division::D1);
        $roundId = Yii::$app->request->get('roundId', 1);

        $country = Country::find()
            ->where(['country_id' => $countryId])
            ->limit(1)
            ->one();
        $this->notFound($country);

        $statisticType = StatisticType::find()
            ->where(['statistic_type_id' => $id])
            ->limit(1)
            ->one();
        if (!$statisticType) {
            $statisticType = StatisticType::find()
                ->where(['statistic_type_id' => StatisticType::TEAM_NO_PASS])
                ->limit(1)
                ->one();
        }

        if ($statisticType->isTeamChapter()) {
            $query = StatisticTeam::find()
                ->where([
                    'statistic_team_championship_playoff' => (1 == $roundId ? 0 : 1),
                    'statistic_team_country_id' => $countryId,
                    'statistic_team_division_id' => $divisionId,
                    'statistic_team_tournament_type_id' => TournamentType::CHAMPIONSHIP,
                    'statistic_team_season_id' => $seasonId,
                ])
                ->orderBy([$statisticType->statistic_type_select => $statisticType->statistic_type_sort]);
        } else {
            $isGk = null;
            if ($statisticType->isGkType()) {
                $isGk = 1;
            }

            $query = StatisticPlayer::find()
                ->where([
                    'statistic_player_championship_playoff' => (1 == $roundId ? 0 : 1),
                    'statistic_player_country_id' => $countryId,
                    'statistic_player_division_id' => $divisionId,
                    'statistic_player_tournament_type_id' => TournamentType::CHAMPIONSHIP,
                    'statistic_player_season_id' => $seasonId,
                ])
                ->andFilterWhere(['statistic_player_is_gk' => $isGk])
                ->orderBy([$statisticType->statistic_type_select => $statisticType->statistic_type_sort]);
        }

        $dataProvider = new ActiveDataProvider([
            'pagination' => [
                'pageSize' => Yii::$app->params['pageSizeTable'],
            ],
            'query' => $query,
            'sort' => false,
        ]);
        $this->setSeoTitle($country->country_name . '. Статистика национального чемпионата');

        return $this->render('statistics', [
            'country' => $country,
            'dataProvider' => $dataProvider,
            'divisionArray' => $this->getDivisionStatisticsLinksArray($seasonId),
            'divisionId' => $divisionId,
            'roundArray' => $this->getRoundStatisticsLinksArray($countryId, $divisionId, $seasonId),
            'roundId' => $roundId,
            'seasonId' => $seasonId,
            'statisticType' => $statisticType,
            'statisticTypeArray' => StatisticChapter::selectOptions(),
        ]);
    }

    /**
     * @param $countryId
     * @param $roundId
     * @param $seasonId
     * @return array
     */
    private function getDivisionStatisticsLinksArray($seasonId)
    {
        $result = [];

        $championshipArray = Championship::find()
            ->with(['division'])
            ->where([
                'championship_season_id' => $seasonId,
            ])
            ->groupBy(['championship_division_id'])
            ->orderBy(['championship_division_id' => SORT_ASC])
            ->all();
        foreach ($championshipArray as $championship) {
            $result[] = [
                'text' => $championship->division->division_name,
                'url' => [
                    'championship/statistics',
                    'divisionId' => $championship->division->division_id,
                    'seasonId' => $seasonId,
                ]
            ];
        }
        return $result;
    }

    /**
     * @param $countryId
     * @param $divisionId
     * @param $seasonId
     * @return array
     */
    private function getRoundStatisticsLinksArray($countryId, $divisionId, $seasonId)
    {
        return [
            [
                'text' => 'Регулярный сезон',
                'url' => [
                    'championship/statistics',
                    'countryId' => $countryId,
                    'divisionId' => $divisionId,
                    'roundId' => 1,
                    'seasonId' => $seasonId,
                ]
            ],
            [
                'text' => 'Плей-офф',
                'url' => [
                    'championship/statistics',
                    'countryId' => $countryId,
                    'divisionId' => $divisionId,
                    'roundId' => 2,
                    'seasonId' => $seasonId,
                ]
            ],
        ];
    }
}
