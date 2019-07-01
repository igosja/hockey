<?php

namespace frontend\controllers;

use common\models\DayType;
use common\models\Game;
use common\models\Planning;
use common\models\Player;
use common\models\Schedule;
use common\models\Season;
use common\models\TournamentType;
use Exception;
use Yii;
use yii\data\ActiveDataProvider;
use yii\filters\AccessControl;
use yii\web\Response;

/**
 * Class PlanningController
 * @package frontend\controllers
 */
class PlanningController extends AbstractController
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
     */
    public function actionIndex()
    {
        if (!$this->user->isVip()) {
            return $this->redirect(['team/view']);
        }

        if (!$this->myTeam) {
            return $this->redirect(['team/view']);
        }

        $team = $this->myTeam;

        $scheduleArray = Schedule::find()
            ->with(['stage', 'tournamentType'])
            ->where(['>', 'schedule_date', time()])
            ->andWhere(['!=', 'schedule_tournament_type_id', TournamentType::CONFERENCE])
            ->orderBy(['schedule_id' => SORT_ASC])
            ->all();
        $countSchedule = count($scheduleArray);

        $changeArray = [];
        $planningArray = Planning::find()
            ->where(['planning_team_id' => $team->team_id])
            ->all();
        foreach ($planningArray as $item) {
            $changeArray[$item->planning_player_id][$item->planning_schedule_id] = 1;
        }

        $query = Player::find()
            ->with(['playerPosition.position'])
            ->where(['player_team_id' => $team->team_id, 'player_loan_team_id' => 0]);
        $dataProvider = new ActiveDataProvider([
            'pagination' => false,
            'query' => $query,
            'sort' => [
                'attributes' => [
                    'age' => [
                        'asc' => ['player_age' => SORT_ASC],
                        'desc' => ['player_age' => SORT_DESC],
                    ],
                    'position' => [
                        'asc' => ['player_position_id' => SORT_ASC, 'player_id' => SORT_ASC],
                        'desc' => ['player_position_id' => SORT_DESC, 'player_id' => SORT_DESC],
                    ],
                    'power' => [
                        'asc' => ['player_power_nominal' => SORT_ASC],
                        'desc' => ['player_power_nominal' => SORT_DESC],
                    ],
                    'squad' => [
                        'asc' => ['player_squad_id' => SORT_ASC, 'player_position_id' => SORT_ASC],
                        'desc' => ['player_squad_id' => SORT_DESC, 'player_position_id' => SORT_ASC],
                    ],
                ],
                'defaultOrder' => ['position' => SORT_ASC],
            ],
        ]);

        $playerArray = $query->all();

        $tireNew = 0;
        $gameRow = 0;
        $gameRowOld = 0;
        $playerTireArray = [];

        for ($i = 0; $i < $query->count(); $i++) {
            $currentPlayerTireArray = [];

            for ($j = 0; $j < $countSchedule; $j++) {
                if (0 == $j) {
                    $tire = $playerArray[$i]->player_tire;
                    $tireNew = $tire;
                    $gameRow = $playerArray[$i]->player_game_row;
                    $gameRowOld = $playerArray[$i]->player_game_row_old;
                } else {
                    $tire = $tireNew;
                }

                if (DayType::A != $scheduleArray[$j]->tournamentType->tournament_type_day_type_id) {
                    $gameRowOld = $gameRow;

                    if (isset($changeArray[$playerArray[$i]->player_id][$scheduleArray[$j]->schedule_id])) {
                        if ($gameRow > 0) {
                            $gameRow++;
                        } else {
                            $gameRow = 1;
                        }
                    } else {
                        $gameRow = -1;
                    }

                    if ($gameRow > 0) {
                        if (DayType::B == $scheduleArray[$j]->tournamentType->tournament_type_day_type_id) {
                            $increase = ceil(($playerArray[$i]->player_age - 12) / 11) + $gameRow;

                            if ($increase < 0) {
                                $increase = 0;
                            }

                            $tireNew = $tire + $increase;
                        } elseif (DayType::C == $scheduleArray[$j]->tournamentType->tournament_type_day_type_id) {
                            $increase = floor(($playerArray[$i]->player_age - 12) / 11) + $gameRow / 2;

                            if ($increase < 0) {
                                $increase = 0;
                            }

                            $tireNew = $tire + $increase;
                        }
                    }

                    if ($gameRow < 0 && DayType::B == $scheduleArray[$j]->tournamentType->tournament_type_day_type_id) {
                        if ($gameRowOld <= -2) {
                            $decrease = 4;
                        } elseif (-1 == $gameRowOld) {
                            $decrease = 5;
                        } elseif (1 == $gameRowOld) {
                            $decrease = 15;
                        } elseif (2 == $gameRowOld) {
                            $decrease = 12;
                        } elseif (3 == $gameRowOld) {
                            $decrease = 10;
                        } elseif (4 == $gameRowOld) {
                            $decrease = 8;
                        } elseif (5 == $gameRowOld) {
                            $decrease = 6;
                        } else {
                            $decrease = 5;
                        }

                        $tireNew = $tire - $decrease + $this->myTeam->basePhysical->base_physical_tire_bonus;
                    }
                }

                $tireNew = (int)$tireNew;

                if ($tireNew < 0) {
                    $tireNew = 0;
                } elseif ($tireNew > Player::TIRE_MAX) {
                    $tireNew = Player::TIRE_MAX;
                }

                if (isset($changeArray[$playerArray[$i]->player_id][$scheduleArray[$j]->schedule_id])) {
                    $class = 'planning-change-cell planning-bordered';
                } else {
                    $class = 'planning-change-cell';
                }

                $currentPlayerTireArray[] = [
                    'class' => $class,
                    'id' => $playerArray[$i]->player_id . '-' . $scheduleArray[$j]->schedule_id,
                    'tire' => $tire,
                    'game_row' => $gameRow,
                    'game_row_old' => $gameRowOld,
                    'age' => $playerArray[$i]->player_age,
                    'player_id' => $playerArray[$i]->player_id,
                    'schedule_id' => $scheduleArray[$j]->schedule_id,
                ];
            }

            $playerTireArray[$playerArray[$i]->player_id] = $currentPlayerTireArray;
        }

        $playerId = [];

        foreach ($playerArray as $item) {
            $playerId[] = $item['player_id'];
        }

        $opponentArray = [];
        foreach ($scheduleArray as $key => $schedule) {
            $game = Game::find()
                ->where(['game_schedule_id' => $schedule->schedule_id])
                ->andWhere(['or', ['game_home_team_id' => $team->team_id], ['game_guest_team_id' => $team->team_id]])
                ->limit(1)
                ->one();
            if (!$game) {
                $opponentArray[$key] = '-';
            } elseif ($team->team_id == $game->game_guest_team_id) {
                $opponentArray[$key] = $game->teamHome->team_name;
            } else {
                $opponentArray[$key] = $game->teamGuest->team_name;
            }
        }

        $this->setSeoTitle($team->fullName() . '. Центр физической подготовки');

        return $this->render('index', [
            'countSchedule' => $countSchedule,
            'dataProvider' => $dataProvider,
            'opponentArray' => $opponentArray,
            'playerTireArray' => $playerTireArray,
            'scheduleArray' => $scheduleArray,
            'team' => $team,
        ]);
    }

    /**
     * @param string $tournament
     * @param string $stage
     * @param string $team
     */
    public function actionImage($tournament = null, $stage = null, $team = null)
    {
        if ($tournament && $stage) {
            $text = $tournament . ', ' . $stage;
        } elseif ($team) {
            $text = $team;
        } else {
            $text = '-';
        }

        header("Content-type: image/png");

        $image = imagecreate(20, 250);
        imagecolorallocate($image, 40, 96, 144);
        $text_color = imagecolorallocate($image, 255, 255, 255);

        imagettftext($image, 11, 90, 15, 241, $text_color, Yii::getAlias('@webroot') . '/fonts/HelveticaNeue.ttf', $text);
        imagepng($image);
        imagedestroy($image);
    }

    /**
     * @param $tire
     * @param $playerId
     * @param $scheduleId
     * @param $age
     * @param $gameRow
     * @param $gameRowOld
     * @return array|Response
     * @throws Exception
     */
    public function actionChange($tire, $playerId, $scheduleId, $age, $gameRow, $gameRowOld)
    {
        if (!$this->myTeam) {
            return $this->redirect(['team/view']);
        }

        $team = $this->myTeam;

        $result = ['list' => []];

        $player = Player::find()
            ->where(['player_id' => $playerId, 'player_team_id' => $team->team_id, 'player_loan_team_id' => 0])
            ->count();
        if ($player) {
            $planning = Planning::find()
                ->where([
                    'planning_player_id' => $playerId,
                    'planning_season_id' => Season::getCurrentSeason(),
                    'planning_schedule_id' => $scheduleId,
                ])
                ->count();

            if ($planning) {
                Planning::deleteAll([
                    'planning_player_id' => $playerId,
                    'planning_season_id' => Season::getCurrentSeason(),
                    'planning_schedule_id' => $scheduleId,
                ]);
            } else {
                $model = new Planning();
                $model->planning_schedule_id = $scheduleId;
                $model->planning_player_id = $playerId;
                $model->planning_season_id = Season::getCurrentSeason();
                $model->planning_team_id = $team->team_id;
                $model->save();
            }

            $changeArray = [];
            $planningArray = Planning::find()
                ->where(['planning_team_id' => $team->team_id, 'planning_player_id' => $playerId])
                ->all();
            foreach ($planningArray as $item) {
                $changeArray[$item->planning_player_id][$item->planning_schedule_id] = 1;
            }

            $scheduleArray = Schedule::find()
                ->where(['>=', 'schedule_id', $scheduleId])
                ->andWhere(['!=', 'schedule_tournament_type_id', TournamentType::CONFERENCE])
                ->orderBy(['schedule_id' => SORT_ASC])
                ->all();

            $tireNew = 0;

            for ($i = 0, $countSchedule = count($scheduleArray); $i < $countSchedule; $i++) {
                if (0 == $i) {
                    $tireNew = $tire;
                } else {
                    $tire = $tireNew;
                }

                if (DayType::A != $scheduleArray[$i]->tournamentType->tournament_type_day_type_id) {
                    $gameRowOld = $gameRow;

                    if (isset($changeArray[$playerId][$scheduleArray[$i]->schedule_id])) {
                        if ($gameRow > 0) {
                            $gameRow++;
                        } else {
                            $gameRow = 1;
                        }
                    } else {
                        $gameRow = -1;
                    }

                    if ($gameRow > 0) {
                        if (DayType::B == $scheduleArray[$i]->tournamentType->tournament_type_day_type_id) {
                            $increase = ceil(($age - 12) / 11) + $gameRow;

                            if ($increase < 0) {
                                $increase = 0;
                            }

                            $tireNew = $tire + $increase;
                        } elseif (DayType::C == $scheduleArray[$i]->tournamentType->tournament_type_day_type_id) {
                            $increase = floor(($age - 12) / 11) + $gameRow / 2;

                            if ($increase < 0) {
                                $increase = 0;
                            }

                            $tireNew = $tire + $increase;
                        }
                    }

                    if ($gameRow < 0 && DayType::B == $scheduleArray[$i]->tournamentType->tournament_type_day_type_id) {
                        if ($gameRowOld <= -2) {
                            $decrease = 4;
                        } elseif (-1 == $gameRowOld) {
                            $decrease = 5;
                        } elseif (1 == $gameRowOld) {
                            $decrease = 15;
                        } elseif (2 == $gameRowOld) {
                            $decrease = 12;
                        } elseif (3 == $gameRowOld) {
                            $decrease = 10;
                        } elseif (4 == $gameRowOld) {
                            $decrease = 8;
                        } elseif (5 == $gameRowOld) {
                            $decrease = 6;
                        } else {
                            $decrease = 5;
                        }

                        $tireNew = $tire - $decrease + $this->myTeam->basePhysical->base_physical_tire_bonus;
                    }
                }

                $tireNew = (int)$tireNew;

                if ($tireNew < 0) {
                    $tireNew = 0;
                } elseif ($tireNew > Player::TIRE_MAX) {
                    $tireNew = Player::TIRE_MAX;
                }

                if (isset($changeArray[$playerId][$scheduleArray[$i]->schedule_id])) {
                    $class = 'planning-change-cell planning-bordered';
                } else {
                    $class = 'planning-change-cell';
                }

                $result['list'][] = [
                    'remove_class_1' => 'planning-bordered',
                    'remove_class_2' => '',
                    'class' => $class,
                    'id' => $playerId . '-' . $scheduleArray[$i]['schedule_id'],
                    'tire' => $tire,
                    'game_row' => $gameRow,
                    'game_row_old' => $gameRowOld,
                ];
            }
        }

        Yii::$app->response->format = Response::FORMAT_JSON;
        return $result;
    }
}
