<?php

namespace frontend\controllers;

use common\models\Championship;
use common\models\Conference;
use common\models\Country;
use common\models\Division;
use common\models\Game;
use common\models\ParticipantChampionship;
use common\models\Review;
use common\models\Schedule;
use common\models\Stage;
use common\models\StatisticChapter;
use common\models\StatisticPlayer;
use common\models\StatisticTeam;
use common\models\StatisticType;
use common\models\TournamentType;
use Yii;
use yii\data\ActiveDataProvider;
use yii\helpers\ArrayHelper;
use yii\helpers\Html;
use yii\web\NotFoundHttpException;
use yii\web\Response;

/**
 * Class ChampionshipController
 * @package frontend\controllers
 */
class ChampionshipController extends AbstractController
{
    /**
     * @return Response
     */
    public function actionIndex()
    {
        $seasonId = Yii::$app->request->get('seasonId', $this->seasonId);

        $schedule = Schedule::find()
            ->where([
                'schedule_tournament_type_id' => TournamentType::CHAMPIONSHIP,
                'schedule_season_id' => $seasonId,
            ])
            ->andWhere(['<=', 'schedule_date', time()])
            ->orderBy(['schedule_date' => SORT_DESC])
            ->limit(1)
            ->one();
        if (!$schedule) {
            $schedule = Schedule::find()
                ->where([
                    'schedule_tournament_type_id' => TournamentType::CHAMPIONSHIP,
                    'schedule_season_id' => $seasonId,
                ])
                ->andWhere(['>', 'schedule_date', time()])
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
     * @throws NotFoundHttpException
     */
    public function actionTable()
    {
        $seasonId = Yii::$app->request->get('seasonId', $this->seasonId);
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
                ->andWhere(['<=', 'schedule_date', time()])
                ->andWhere(['<=', 'schedule_stage_id', Stage::TOUR_30])
                ->orderBy(['schedule_date' => SORT_DESC])
                ->limit(1)
                ->one();
            if (!$schedule) {
                $schedule = Schedule::find()
                    ->where([
                        'schedule_tournament_type_id' => TournamentType::CHAMPIONSHIP,
                        'schedule_season_id' => $seasonId,
                    ])
                    ->andWhere(['>', 'schedule_date', time()])
                    ->andWhere(['<=', 'schedule_stage_id', Stage::TOUR_30])
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

        $reviewArray = Review::find()
            ->where([
                'review_country_id' => $countryId,
                'review_division_id' => $divisionId,
                'review_season_id' => $seasonId,
            ])
            ->orderBy(['review_schedule_id' => SORT_ASC])
            ->all();

        $this->setSeoTitle($country->country_name . '. Национальный чемпионат');

        return $this->render('table', [
            'country' => $country,
            'dataProvider' => $dataProvider,
            'divisionArray' => $this->getDivisionLinksArray($countryId, $seasonId),
            'divisionId' => $divisionId,
            'gameArray' => $gameArray,
            'reviewArray' => $reviewArray,
            'reviewCreate' => $this->canReviewCreate($gameArray, $countryId, $divisionId, $schedule->schedule_id),
            'roundArray' => $this->getRoundLinksArray($countryId, $divisionId, $seasonId),
            'scheduleId' => $schedule->schedule_id,
            'seasonArray' => $this->getSeasonArray($countryId, $divisionId),
            'seasonId' => $seasonId,
            'stageArray' => $stageArray,
            'stageId' => $stageId,
        ]);
    }

    /**
     * @return string
     * @throws NotFoundHttpException
     */
    public function actionPlayoff()
    {
        $seasonId = Yii::$app->request->get('seasonId', $this->seasonId);
        $countryId = Yii::$app->request->get('countryId', Country::DEFAULT_ID);
        $divisionId = Yii::$app->request->get('divisionId', Division::D1);

        $country = Country::find()
            ->where(['country_id' => $countryId])
            ->limit(1)
            ->one();
        $this->notFound($country);

        $playoffArray = [];

        $stageArray = Stage::find()
            ->where(['stage_id' => [Stage::QUARTER, Stage::SEMI, Stage::FINAL_GAME]])
            ->orderBy(['stage_id' => SORT_ASC])
            ->all();
        foreach ($stageArray as $stage) {
            $scheduleId = Schedule::find()
                ->select(['schedule_id'])
                ->where([
                    'schedule_season_id' => $seasonId,
                    'schedule_stage_id' => $stage->stage_id,
                    'schedule_tournament_type_id' => TournamentType::CHAMPIONSHIP,
                ])
                ->orderBy(['schedule_id' => SORT_ASC])
                ->column();
            if ($scheduleId) {
                $gameArray = Game::find()
                    ->where(['game_schedule_id' => $scheduleId])
                    ->andWhere([
                        'game_home_team_id' => ParticipantChampionship::find()
                            ->select(['participant_championship_team_id'])
                            ->where([
                                'participant_championship_country_id' => $countryId,
                                'participant_championship_division_id' => $divisionId,
                                'participant_championship_season_id' => $seasonId,
                            ])
                    ])
                    ->orderBy(['game_id' => SORT_ASC])
                    ->all();
                if ($gameArray) {
                    $participantArray = [];

                    foreach ($gameArray as $game) {
                        $inArray = false;

                        for ($i = 0, $countParticipant = count($participantArray); $i < $countParticipant; $i++) {
                            if (in_array($game->game_home_team_id, array($participantArray[$i]['home']->team_id, $participantArray[$i]['guest']->team_id))) {
                                $inArray = true;

                                if ($game->game_home_team_id == $participantArray[$i]['home']->team_id) {
                                    $formatScore = 'home';
                                } else {
                                    $formatScore = 'guest';
                                }

                                $participantArray[$i]['game'][] = Html::a(
                                    $game->formatScore($formatScore),
                                    ['game/view', 'id' => $game->game_id]
                                );
                            }
                        }

                        if (false == $inArray) {
                            $participantArray[] = [
                                'home' => $game->teamHome,
                                'guest' => $game->teamGuest,
                                'game' => [
                                    Html::a(
                                        $game->formatScore(),
                                        ['game/view', 'id' => $game->game_id]
                                    )
                                ],
                            ];
                        }
                    }

                    $playoffArray[] = array(
                        'stage' => $stage,
                        'participant' => $participantArray,
                    );
                }
            }
        }

        $schedule = Schedule::find()
            ->where([
                'schedule_tournament_type_id' => TournamentType::CHAMPIONSHIP,
                'schedule_season_id' => $seasonId,
            ])
            ->andWhere(['<=', 'schedule_date', time()])
            ->andWhere(['schedule_stage_id' => [Stage::QUARTER, Stage::SEMI, Stage::FINAL_GAME]])
            ->orderBy(['schedule_date' => SORT_DESC])
            ->limit(1)
            ->one();
        if (!$schedule) {
            $schedule = Schedule::find()
                ->where([
                    'schedule_tournament_type_id' => TournamentType::CHAMPIONSHIP,
                    'schedule_season_id' => $seasonId,
                ])
                ->andWhere(['>', 'schedule_date', time()])
                ->andWhere(['schedule_stage_id' => [Stage::QUARTER, Stage::SEMI, Stage::FINAL_GAME]])
                ->orderBy(['schedule_date' => SORT_ASC])
                ->limit(1)
                ->one();
        }

        $gameArray = Game::find()
            ->where([
                'game_schedule_id' => $schedule->schedule_id,
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

        $reviewArray = Review::find()
            ->where([
                'review_country_id' => $countryId,
                'review_division_id' => $divisionId,
                'review_season_id' => $seasonId,
            ])
            ->orderBy(['review_schedule_id' => SORT_ASC])
            ->all();

        $this->setSeoTitle($country->country_name . '. Национальный чемпионат');

        return $this->render('playoff', [
            'country' => $country,
            'divisionArray' => $this->getDivisionLinksArray($countryId, $seasonId),
            'divisionId' => $divisionId,
            'playoffArray' => $playoffArray,
            'reviewArray' => $reviewArray,
            'reviewCreate' => $this->canReviewCreate($gameArray, $countryId, $divisionId, $schedule->schedule_id),
            'roundArray' => $this->getRoundLinksArray($countryId, $divisionId, $seasonId),
            'scheduleId' => 0,
            'seasonArray' => $this->getSeasonArray($countryId, $divisionId),
            'seasonId' => $seasonId,
        ]);
    }

    /**
     * @param int $id
     * @return string
     * @throws NotFoundHttpException
     */
    public function actionStatistics($id = StatisticType::TEAM_NO_PASS)
    {
        $seasonId = Yii::$app->request->get('seasonId', $this->seasonId);
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
            'divisionArray' => $this->getDivisionStatisticsLinksArray($countryId, $roundId, $seasonId),
            'divisionId' => $divisionId,
            'myTeam' => $this->myTeam,
            'roundArray' => $this->getRoundStatisticsLinksArray($countryId, $divisionId, $seasonId),
            'roundId' => $roundId,
            'seasonId' => $seasonId,
            'statisticType' => $statisticType,
            'statisticTypeArray' => StatisticChapter::selectOptions(),
        ]);
    }

    /**
     * @param int $countryId
     * @param int $divisionId
     * @return array
     */
    private function getSeasonArray($countryId, $divisionId)
    {
        $season = Championship::find()
            ->select(['championship_season_id'])
            ->where(['championship_country_id' => $countryId, 'championship_division_id' => $divisionId])
            ->groupBy(['championship_season_id'])
            ->orderBy(['championship_season_id' => SORT_DESC])
            ->all();
        return ArrayHelper::map($season, 'championship_season_id', 'championship_season_id');
    }

    /**
     * @param $countryId
     * @param $seasonId
     * @return array
     */
    private function getDivisionLinksArray($countryId, $seasonId)
    {
        $result = [];

        $championshipArray = Championship::find()
            ->with(['division'])
            ->where([
                'championship_country_id' => $countryId,
                'championship_season_id' => $seasonId,
            ])
            ->groupBy(['championship_division_id'])
            ->orderBy(['championship_division_id' => SORT_ASC])
            ->all();
        foreach ($championshipArray as $championship) {
            $result[] = [
                'alias' => [
                    [
                        'championship/table',
                        'countryId' => $countryId,
                        'divisionId' => $championship->championship_division_id,
                        'seasonId' => $seasonId,
                    ],
                    [
                        'championship/playoff',
                        'countryId' => $countryId,
                        'divisionId' => $championship->championship_division_id,
                        'seasonId' => $seasonId,
                    ],
                ],
                'text' => $championship->division->division_name,
                'url' => [
                    'championship/index',
                    'countryId' => $countryId,
                    'divisionId' => $championship->championship_division_id,
                    'seasonId' => $seasonId,
                ]
            ];
        }

        $conference = Conference::find()
            ->joinWith(['team.stadium.city'])
            ->where([
                'city_country_id' => $countryId,
                'conference_season_id' => $seasonId,
            ])
            ->count();
        if ($conference) {
            $result[] = [
                'text' => 'КЛК',
                'url' => [
                    'conference/table',
                    'countryId' => $countryId,
                    'seasonId' => $seasonId,
                ]
            ];
        }
        return $result;
    }

    /**
     * @param $countryId
     * @param $roundId
     * @param $seasonId
     * @return array
     */
    private function getDivisionStatisticsLinksArray($countryId, $roundId, $seasonId)
    {
        $result = [];

        $championshipArray = Championship::find()
            ->with(['division'])
            ->where([
                'championship_country_id' => $countryId,
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
                    'countryId' => $countryId,
                    'divisionId' => $championship->division->division_id,
                    'roundId' => $roundId,
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
    private function getRoundLinksArray($countryId, $divisionId, $seasonId)
    {
        return [
            [
                'text' => 'Регулярный сезон',
                'url' => [
                    'championship/table',
                    'countryId' => $countryId,
                    'divisionId' => $divisionId,
                    'seasonId' => $seasonId,
                ]
            ],
            [
                'text' => 'Плей-офф',
                'url' => [
                    'championship/playoff',
                    'countryId' => $countryId,
                    'divisionId' => $divisionId,
                    'seasonId' => $seasonId,
                ]
            ],
        ];
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

    /**
     * @param Game[] $gameArray
     * @param $countryId
     * @param $divisionId
     * @param $scheduleId
     * @return bool
     */
    private function canReviewCreate($gameArray, $countryId, $divisionId, $scheduleId)
    {
        if (!$this->user) {
            return false;
        }

        if (!$this->user->user_date_confirm) {
            return false;
        }

        if (!$gameArray) {
            return false;
        }

        if (!$gameArray[0]->game_played) {
            return false;
        }

        $review = Review::find()
            ->where([
                'review_country_id' => $countryId,
                'review_division_id' => $divisionId,
                'review_schedule_id' => $scheduleId,
                'review_user_id' => $this->user->user_id,
            ])
            ->count();
        if ($review) {
            return false;
        }

        return true;
    }
}
