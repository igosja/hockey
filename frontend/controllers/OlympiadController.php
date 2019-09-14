<?php

namespace frontend\controllers;

use common\models\Game;
use common\models\Olympiad;
use common\models\ParticipantOlympiad;
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
 * Class OlympiadController
 * @package frontend\controllers
 */
class OlympiadController extends AbstractController
{
    /**
     * @return Response
     */
    public function actionIndex()
    {
        $seasonId = Yii::$app->request->get('seasonId', $this->seasonId);

        $schedule = Schedule::find()
            ->where([
                'schedule_tournament_type_id' => TournamentType::OLYMPIAD,
                'schedule_season_id' => $seasonId,
            ])
            ->andWhere(['<=', 'schedule_date', time()])
            ->orderBy(['schedule_date' => SORT_DESC])
            ->limit(1)
            ->one();
        if (!$schedule) {
            $schedule = Schedule::find()
                ->where([
                    'schedule_tournament_type_id' => TournamentType::OLYMPIAD,
                    'schedule_season_id' => $seasonId,
                ])
                ->andWhere(['>', 'schedule_date', time()])
                ->orderBy(['schedule_date' => SORT_ASC])
                ->limit(1)
                ->one();
        }

        if ($schedule->schedule_stage_id >= Stage::TOUR_OLYMPIAD_1) {
            return $this->redirect([
                'olympiad/table',
                'seasonId' => $seasonId,
            ]);
        }

        return $this->redirect([
            'olympiad/playoff',
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
        $stageId = Yii::$app->request->get('stageId');

        if (!$stageId) {
            $schedule = Schedule::find()
                ->where([
                    'schedule_tournament_type_id' => TournamentType::OLYMPIAD,
                    'schedule_season_id' => $seasonId,
                ])
                ->andWhere(['<=', 'schedule_date', time()])
                ->andWhere(['>=', 'schedule_stage_id', Stage::TOUR_OLYMPIAD_1])
                ->andWhere(['<=', 'schedule_stage_id', Stage::TOUR_OLYMPIAD_5])
                ->orderBy(['schedule_date' => SORT_DESC])
                ->limit(1)
                ->one();
            if (!$schedule) {
                $schedule = Schedule::find()
                    ->where([
                        'schedule_tournament_type_id' => TournamentType::OLYMPIAD,
                        'schedule_season_id' => $seasonId,
                    ])
                    ->andWhere(['>', 'schedule_date', time()])
                    ->andWhere(['>=', 'schedule_stage_id', Stage::TOUR_OLYMPIAD_1])
                    ->andWhere(['<=', 'schedule_stage_id', Stage::TOUR_OLYMPIAD_5])
                    ->orderBy(['schedule_date' => SORT_ASC])
                    ->limit(1)
                    ->one();
            }
            $stageId = $schedule->schedule_stage_id;
        } else {
            $schedule = Schedule::find()
                ->where([
                    'schedule_tournament_type_id' => TournamentType::OLYMPIAD,
                    'schedule_season_id' => $seasonId,
                    'schedule_stage_id' => $stageId,
                ])
                ->limit(1)
                ->one();
        }

        $this->notFound($schedule);

        $groupArray = [
            1 => ['name' => 'A'],
            2 => ['name' => 'B'],
            3 => ['name' => 'C'],
            4 => ['name' => 'D'],
        ];

        for ($group = 1; $group <= 4; $group++) {
            $gameArray = Game::find()
                ->joinWith(['schedule'])
                ->where([
                    'schedule_stage_id' => $stageId,
                    'schedule.schedule_season_id' => $seasonId,
                    'schedule.schedule_tournament_type_id' => TournamentType::OLYMPIAD,
                    'game_home_national_id' => Olympiad::find()
                        ->select(['olympiad_national_id'])
                        ->where([
                            'olympiad_group' => $group,
                            'olympiad_season_id' => $seasonId,
                        ])
                ])
                ->orderBy(['game_id' => SORT_ASC])
                ->all();
            $groupArray[$group]['game'] = $gameArray;

            $query = Olympiad::find()
                ->where([
                    'olympiad_group' => $group,
                    'olympiad_season_id' => $seasonId,
                ])
                ->orderBy(['olympiad_place' => SORT_ASC]);

            $dataProvider = new ActiveDataProvider([
                'pagination' => false,
                'query' => $query,
                'sort' => false,
            ]);

            $groupArray[$group]['team'] = $dataProvider;
        }

        $stageArray = Schedule::find()
            ->where([
                'schedule_tournament_type_id' => TournamentType::OLYMPIAD,
                'schedule_season_id' => $seasonId,
            ])
            ->andWhere(['>=', 'schedule_stage_id', Stage::TOUR_OLYMPIAD_1])
            ->andWhere(['<=', 'schedule_stage_id', Stage::TOUR_OLYMPIAD_5])
            ->orderBy(['schedule_stage_id' => SORT_ASC])
            ->all();
        $stageArray = ArrayHelper::map($stageArray, 'stage.stage_id', 'stage.stage_name');

        $this->setSeoTitle('Олимпиада');

        return $this->render('table', [
            'groupArray' => $groupArray,
            'roundArray' => $this->getRoundLinksArray($seasonId),
            'seasonArray' => $this->getSeasonArray(),
            'seasonId' => $seasonId,
            'stageArray' => $stageArray,
            'stageId' => $stageId,
        ]);
    }

    /**
     * @param $seasonId
     * @return array
     */
    private function getRoundLinksArray($seasonId)
    {
        return [
            [
                'text' => 'Групповой этап',
                'url' => [
                    'olympiad/table',
                    'seasonId' => $seasonId,
                ]
            ],
            [
                'text' => 'Плей-офф',
                'url' => [
                    'olympiad/playoff',
                    'seasonId' => $seasonId,
                ]
            ],
        ];
    }

    /**
     * @return array
     */
    private function getSeasonArray()
    {
        $season = Schedule::find()
            ->select(['schedule_season_id'])
            ->where(['schedule_tournament_type_id' => TournamentType::OLYMPIAD])
            ->groupBy(['schedule_season_id'])
            ->orderBy(['schedule_season_id' => SORT_DESC])
            ->all();
        return ArrayHelper::map($season, 'schedule_season_id', 'schedule_season_id');
    }

    /**
     * @return string
     * @throws NotFoundHttpException
     */
    public function actionPlayoff()
    {
        $seasonId = Yii::$app->request->get('seasonId', $this->seasonId);

        $qualificationArray = [];

        $stageArray = Stage::find()
            ->where(['stage_id' => [Stage::ROUND_OF_16, Stage::QUARTER, Stage::SEMI, Stage::FINAL_GAME]])
            ->orderBy(['stage_id' => SORT_ASC])
            ->all();
        foreach ($stageArray as $stage) {
            $scheduleId = Schedule::find()
                ->select(['schedule_id'])
                ->where([
                    'schedule_season_id' => $seasonId,
                    'schedule_stage_id' => $stage->stage_id,
                    'schedule_tournament_type_id' => TournamentType::OLYMPIAD,
                ])
                ->orderBy(['schedule_id' => SORT_ASC])
                ->column();
            if ($scheduleId) {
                $gameArray = Game::find()
                    ->where(['game_schedule_id' => $scheduleId])
                    ->andWhere([
                        'game_home_national_id' => ParticipantOlympiad::find()
                            ->select(['participant_olympiad_national_id'])
                            ->where(['participant_olympiad_season_id' => $seasonId])
                    ])
                    ->orderBy(['game_id' => SORT_ASC])
                    ->all();
                if ($gameArray) {
                    $participantArray = [];

                    foreach ($gameArray as $game) {
                        $inArray = false;

                        for ($i = 0, $countParticipant = count($participantArray); $i < $countParticipant; $i++) {
                            if (in_array($game->game_home_national_id, [$participantArray[$i]['home']->national_id, $participantArray[$i]['guest']->national_id])) {
                                $inArray = true;

                                if ($game->game_home_national_id == $participantArray[$i]['home']->national_id) {
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
                                'home' => $game->nationalHome,
                                'guest' => $game->nationalGuest,
                                'game' => [
                                    Html::a(
                                        $game->formatScore(),
                                        ['game/view', 'id' => $game->game_id]
                                    )
                                ],
                            ];
                        }
                    }

                    $qualificationArray[] = [
                        'stage' => $stage,
                        'participant' => $participantArray,
                    ];
                }
            }
        }

        $this->setSeoTitle('Олимпиада');

        return $this->render('playoff', [
            'qualificationArray' => $qualificationArray,
            'roundArray' => $this->getRoundLinksArray($seasonId),
            'seasonArray' => $this->getSeasonArray(),
            'seasonId' => $seasonId,
        ]);
    }

    /**
     * @param int $id
     * @return string
     */
    public function actionStatistics($id = StatisticType::TEAM_NO_PASS)
    {
        $seasonId = Yii::$app->request->get('seasonId', $this->seasonId);

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
                ->where(['statistic_team_tournament_type_id' => TournamentType::OLYMPIAD])
                ->orderBy([$statisticType->statistic_type_select => $statisticType->statistic_type_sort]);
        } else {
            $isGk = null;
            if ($statisticType->isGkType()) {
                $isGk = 1;
            }

            $query = StatisticPlayer::find()
                ->where([
                    'statistic_player_tournament_type_id' => TournamentType::OLYMPIAD,
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
        $this->setSeoTitle('Статистика Лиги Чемпионов');

        return $this->render('statistics', [
            'dataProvider' => $dataProvider,
            'myNational' => $this->myNationalOrVice,
            'seasonId' => $seasonId,
            'statisticType' => $statisticType,
            'statisticTypeArray' => StatisticChapter::selectOptions(),
        ]);
    }
}
