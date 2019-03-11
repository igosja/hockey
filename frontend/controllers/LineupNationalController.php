<?php

namespace frontend\controllers;

use common\models\Game;
use common\models\LineupTemplate;
use common\models\Mood;
use common\models\Player;
use common\models\Position;
use common\models\Rudeness;
use common\models\Style;
use common\models\Tactic;
use common\models\Teamwork;
use common\models\TournamentType;
use frontend\models\GameNationalSend;
use Yii;
use yii\data\ActiveDataProvider;
use yii\filters\AccessControl;
use yii\helpers\ArrayHelper;
use yii\web\Response;

/**
 * Class LineupNationalController
 * @package frontend\controllers
 */
class LineupNationalController extends AbstractController
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
     * @param int $id
     * @return string
     * @throws \Exception
     */
    public function actionView($id)
    {
        if (!$this->myNationalOrVice) {
            return $this->redirect(['national/view']);
        }

        $game = $this->getGame($id);

        $model = new GameNationalSend(['game' => $game, 'national' => $this->myNationalOrVice]);
        if ($model->saveLineup()) {
            $this->setSuccessFlash('Состав успешно отправлен.');
            return $this->refresh();
        }

        $query = Game::find()
            ->joinWith(['schedule'])
            ->with([
                'schedule.stage',
                'schedule.tournamentType',
                'nationalGuest.stadium.city',
                'nationalHome.stadium.city',
            ])
            ->where(['game_played' => 0])
            ->andWhere([
                'or',
                ['game_guest_national_id' => $this->myNationalOrVice->national_id],
                ['game_home_national_id' => $this->myNationalOrVice->national_id]
            ])
            ->orderBy(['schedule_date' => SORT_ASC])
            ->limit(5);
        $gameDataProvider = new ActiveDataProvider([
            'pagination' => false,
            'query' => $query,
        ]);

        $query = Player::find()
            ->with([
                'physical',
                'playerPosition.position',
                'playerSpecial.special',
                'squadNational',
            ])
            ->where(['player_national_id' => $this->myNationalOrVice->national_id]);
        $playerDataProvider = new ActiveDataProvider([
            'pagination' => false,
            'query' => $query,
            'sort' => [
                'attributes' => [
                    'age' => [
                        'asc' => ['player_age' => SORT_ASC],
                        'desc' => ['player_age' => SORT_DESC],
                    ],
                    'game_row' => [
                        'asc' => ['player_game_row' => SORT_ASC],
                        'desc' => ['player_game_row' => SORT_DESC],
                    ],
                    'position' => [
                        'asc' => ['player_position_id' => SORT_ASC, 'player_id' => SORT_ASC],
                        'desc' => ['player_position_id' => SORT_DESC, 'player_id' => SORT_DESC],
                    ],
                    'physical' => [
                        'asc' => ['player_physical_id' => SORT_ASC],
                        'desc' => ['player_physical_id' => SORT_DESC],
                    ],
                    'power_nominal' => [
                        'asc' => ['player_power_nominal' => SORT_ASC],
                        'desc' => ['player_power_nominal' => SORT_DESC],
                    ],
                    'power_real' => [
                        'asc' => ['player_power_real' => SORT_ASC],
                        'desc' => ['player_power_real' => SORT_DESC],
                    ],
                    'squad' => [
                        'asc' => ['player_national_line_id' => SORT_ASC, 'player_position_id' => SORT_ASC],
                        'desc' => ['player_national_line_id' => SORT_DESC, 'player_position_id' => SORT_ASC],
                    ],
                    'tire' => [
                        'asc' => ['player_tire' => SORT_ASC],
                        'desc' => ['player_tire' => SORT_DESC],
                    ],
                ],
                'defaultOrder' => ['position' => SORT_ASC],
            ],
        ]);

        $playerArray = Player::find()
            ->with([
                'playerPosition.position',
                'squadNational',
            ])
            ->where(['player_national_id' => $this->myNationalOrVice->national_id])
            ->andWhere(['player_position_id' => Position::GK])
            ->orderBy(['player_power_real' => SORT_DESC])
            ->all();
        $gkArray = [];
        foreach ($playerArray as $player) {
            if (TournamentType::FRIENDLY == $game->schedule->schedule_tournament_type_id) {
                $player->player_power_real = round($player->player_power_nominal * 0.75);
            }

            $gkArray[] = $player;
        }

        $ldArray = [];
        $rdArray = [];
        $lwArray = [];
        $cfArray = [];
        $rwArray = [];
        $playerArray = Player::find()
            ->with([
                'playerPosition.position',
                'squadNational',
            ])
            ->where(['player_national_id' => $this->myNationalOrVice->national_id])
            ->andWhere(['!=', 'player_position_id', Position::GK])
            ->orderBy(['player_power_real' => SORT_DESC])
            ->all();
        foreach ($playerArray as $player) {
            $ldPlayer = clone $player;
            $rdPlayer = clone $player;
            $lwPlayer = clone $player;
            $cfPlayer = clone $player;
            $rwPlayer = clone $player;
            $ldCoefficient = 0;
            $rdCoefficient = 0;
            $lwCoefficient = 0;
            $cfCoefficient = 0;
            $rwCoefficient = 0;
            foreach ($player->playerPosition as $playerPosition) {
                if (Position::LD == $playerPosition->player_position_position_id) {
                    if (1 > $ldCoefficient) {
                        $ldCoefficient = 1;
                    }
                    if (0.9 > $rdCoefficient) {
                        $rdCoefficient = 0.9;
                    }
                    if (0.9 > $lwCoefficient) {
                        $lwCoefficient = 0.9;
                    }
                    if (0.8 > $cfCoefficient) {
                        $cfCoefficient = 0.8;
                    }
                    if (0.8 > $rwCoefficient) {
                        $rwCoefficient = 0.8;
                    }
                }
                if (Position::RD == $playerPosition->player_position_position_id) {
                    if (0.9 > $ldCoefficient) {
                        $ldCoefficient = 0.9;
                    }
                    if (1 > $rdCoefficient) {
                        $rdCoefficient = 1;
                    }
                    if (0.8 > $lwCoefficient) {
                        $lwCoefficient = 0.8;
                    }
                    if (0.8 > $cfCoefficient) {
                        $cfCoefficient = 0.8;
                    }
                    if (0.9 > $rwCoefficient) {
                        $rwCoefficient = 0.9;
                    }
                }
                if (Position::LW == $playerPosition->player_position_position_id) {
                    if (0.9 > $ldCoefficient) {
                        $ldCoefficient = 0.9;
                    }
                    if (0.8 > $rdCoefficient) {
                        $rdCoefficient = 0.8;
                    }
                    if (1 > $lwCoefficient) {
                        $lwCoefficient = 1;
                    }
                    if (0.9 > $cfCoefficient) {
                        $cfCoefficient = 0.9;
                    }
                    if (0.8 > $rwCoefficient) {
                        $rwCoefficient = 0.8;
                    }
                }
                if (Position::CF == $playerPosition->player_position_position_id) {
                    if (0.8 > $ldCoefficient) {
                        $ldCoefficient = 0.8;
                    }
                    if (0.8 > $rdCoefficient) {
                        $rdCoefficient = 0.8;
                    }
                    if (0.9 > $lwCoefficient) {
                        $lwCoefficient = 0.9;
                    }
                    if (1 > $cfCoefficient) {
                        $cfCoefficient = 1;
                    }
                    if (0.9 > $rwCoefficient) {
                        $rwCoefficient = 0.9;
                    }
                }
                if (Position::RW == $playerPosition->player_position_position_id) {
                    if (0.8 > $ldCoefficient) {
                        $ldCoefficient = 0.8;
                    }
                    if (0.9 > $rdCoefficient) {
                        $rdCoefficient = 0.9;
                    }
                    if (0.8 > $lwCoefficient) {
                        $lwCoefficient = 0.8;
                    }
                    if (0.9 > $cfCoefficient) {
                        $cfCoefficient = 0.9;
                    }
                    if (1 > $rwCoefficient) {
                        $rwCoefficient = 1;
                    }
                }
            }

            if (TournamentType::FRIENDLY == $game->schedule->schedule_tournament_type_id) {
                $ldPlayer->player_power_real = round($ldPlayer->player_power_nominal * $ldCoefficient * 0.75);
                $rdPlayer->player_power_real = round($rdPlayer->player_power_nominal * $rdCoefficient * 0.75);
                $lwPlayer->player_power_real = round($lwPlayer->player_power_nominal * $lwCoefficient * 0.75);
                $cfPlayer->player_power_real = round($cfPlayer->player_power_nominal * $cfCoefficient * 0.75);
                $rwPlayer->player_power_real = round($rwPlayer->player_power_nominal * $rwCoefficient * 0.75);
            } else {
                $ldPlayer->player_power_real = round($ldPlayer->player_power_real * $ldCoefficient);
                $rdPlayer->player_power_real = round($rdPlayer->player_power_real * $rdCoefficient);
                $lwPlayer->player_power_real = round($lwPlayer->player_power_real * $lwCoefficient);
                $cfPlayer->player_power_real = round($cfPlayer->player_power_real * $cfCoefficient);
                $rwPlayer->player_power_real = round($rwPlayer->player_power_real * $rwCoefficient);
            }

            $ldArray[] = $ldPlayer;
            $rdArray[] = $rdPlayer;
            $lwArray[] = $lwPlayer;
            $cfArray[] = $cfPlayer;
            $rwArray[] = $rwPlayer;
        }

        $gk_1_id = isset($model->line[0][0]) ? $model->line[0][0] : 0;
        $gk_2_id = isset($model->line[1][0]) ? $model->line[1][0] : 0;
        $ld_1_id = isset($model->line[1][1]) ? $model->line[1][1] : 0;
        $rd_1_id = isset($model->line[1][2]) ? $model->line[1][2] : 0;
        $lw_1_id = isset($model->line[1][3]) ? $model->line[1][3] : 0;
        $cf_1_id = isset($model->line[1][4]) ? $model->line[1][4] : 0;
        $rw_1_id = isset($model->line[1][5]) ? $model->line[1][5] : 0;
        $ld_2_id = isset($model->line[2][1]) ? $model->line[2][1] : 0;
        $rd_2_id = isset($model->line[2][2]) ? $model->line[2][2] : 0;
        $lw_2_id = isset($model->line[2][3]) ? $model->line[2][3] : 0;
        $cf_2_id = isset($model->line[2][4]) ? $model->line[2][4] : 0;
        $rw_2_id = isset($model->line[2][5]) ? $model->line[2][5] : 0;
        $ld_3_id = isset($model->line[3][1]) ? $model->line[3][1] : 0;
        $rd_3_id = isset($model->line[3][2]) ? $model->line[3][2] : 0;
        $lw_3_id = isset($model->line[3][3]) ? $model->line[3][3] : 0;
        $cf_3_id = isset($model->line[3][4]) ? $model->line[3][4] : 0;
        $rw_3_id = isset($model->line[3][5]) ? $model->line[3][5] : 0;
        $ld_4_id = isset($model->line[4][1]) ? $model->line[4][1] : 0;
        $rd_4_id = isset($model->line[4][2]) ? $model->line[4][2] : 0;
        $lw_4_id = isset($model->line[4][3]) ? $model->line[4][3] : 0;
        $cf_4_id = isset($model->line[4][4]) ? $model->line[4][4] : 0;
        $rw_4_id = isset($model->line[4][5]) ? $model->line[4][5] : 0;

        $noRest = null;
        $noSuper = null;
        if (TournamentType::FRIENDLY == $game->schedule->schedule_tournament_type_id) {
            $noSuper = Mood::SUPER;
            $noRest = Mood::REST;
        } elseif ($this->myNationalOrVice->national_mood_rest <= 0) {
            $noRest = Mood::REST;
        } elseif ($this->myNationalOrVice->national_mood_super <= 0) {
            $noSuper = Mood::SUPER;
        }
        $moodArray = Mood::find()
            ->andFilterWhere(['!=', 'mood_id', $noSuper])
            ->andFilterWhere(['!=', 'mood_id', $noRest])
            ->orderBy(['mood_id' => SORT_ASC])
            ->all();
        $moodArray = ArrayHelper::map($moodArray, 'mood_id', 'mood_name');

        foreach ($moodArray as $moodId => $moodName) {
            if (Mood::SUPER == $moodId) {
                $moodArray[$moodId] = $moodName . ' (' . $this->myNationalOrVice->national_mood_super . ')';
            } elseif (Mood::REST == $moodId) {
                $moodArray[$moodId] = $moodName . ' (' . $this->myNationalOrVice->national_mood_rest . ')';
            }
        }

        $this->setSeoTitle('Отправка состава');

        return $this->render('view', [
            'gk_1_id' => $gk_1_id,
            'gk_2_id' => $gk_2_id,
            'ld_1_id' => $ld_1_id,
            'rd_1_id' => $rd_1_id,
            'lw_1_id' => $lw_1_id,
            'cf_1_id' => $cf_1_id,
            'rw_1_id' => $rw_1_id,
            'ld_2_id' => $ld_2_id,
            'rd_2_id' => $rd_2_id,
            'lw_2_id' => $lw_2_id,
            'cf_2_id' => $cf_2_id,
            'rw_2_id' => $rw_2_id,
            'ld_3_id' => $ld_3_id,
            'rd_3_id' => $rd_3_id,
            'lw_3_id' => $lw_3_id,
            'cf_3_id' => $cf_3_id,
            'rw_3_id' => $rw_3_id,
            'ld_4_id' => $ld_4_id,
            'rd_4_id' => $rd_4_id,
            'lw_4_id' => $lw_4_id,
            'cf_4_id' => $cf_4_id,
            'rw_4_id' => $rw_4_id,
            'cfArray' => $cfArray,
            'game' => $game,
            'gameDataProvider' => $gameDataProvider,
            'gkArray' => $gkArray,
            'ldArray' => $ldArray,
            'lwArray' => $lwArray,
            'model' => $model,
            'moodArray' => $moodArray,
            'isVip' => $this->user->isVip(),
            'playerDataProvider' => $playerDataProvider,
            'rdArray' => $rdArray,
            'rudenessArray' => ArrayHelper::map(Rudeness::find()->all(), 'rudeness_id', 'rudeness_name'),
            'rwArray' => $rwArray,
            'styleArray' => ArrayHelper::map(Style::find()->all(), 'style_id', 'style_name'),
            'tacticArray' => ArrayHelper::map(Tactic::find()->all(), 'tactic_id', 'tactic_name'),
            'national' => $this->myNationalOrVice,
        ]);
    }

    /**
     * @param int $id
     * @return Game
     * @throws \yii\web\NotFoundHttpException
     */
    public function getGame($id)
    {
        $game = Game::find()
            ->where(['game_id' => $id, 'game_played' => 0])
            ->andWhere([
                'or',
                ['game_guest_national_id' => $this->myNationalOrVice->national_id],
                ['game_home_national_id' => $this->myNationalOrVice->national_id]
            ])
            ->limit(1)
            ->one();
        $this->notFound($game);

        return $game;
    }

    /**
     * @return array
     */
    public function actionTeamwork()
    {
        $model = new GameNationalSend();
        $model->load(Yii::$app->request->post());

        $result = [
            'power' => 0,
            'position' => 0,
            'lineup' => 0,
            'teamwork_1' => 0,
            'teamwork_2' => 0,
            'teamwork_3' => 0,
            'teamwork_4' => 0,
        ];

        $data = $model->line;

        if ($data) {
            $power = 0;
            $position = 0;
            $teamwork_1 = 0;
            $teamwork_2 = 0;
            $teamwork_3 = 0;
            $teamwork_4 = 0;

            $gk = $data[0][0];
            $ld1 = $data[1][1];
            $rd1 = $data[1][2];
            $lw1 = $data[1][3];
            $cf1 = $data[1][4];
            $rw1 = $data[1][5];
            $ld2 = $data[2][1];
            $rd2 = $data[2][2];
            $lw2 = $data[2][3];
            $cf2 = $data[2][4];
            $rw2 = $data[2][5];
            $ld3 = $data[3][1];
            $rd3 = $data[3][2];
            $lw3 = $data[3][3];
            $cf3 = $data[3][4];
            $rw3 = $data[3][5];
            $ld4 = $data[4][1];
            $rd4 = $data[4][2];
            $lw4 = $data[4][3];
            $cf4 = $data[4][4];
            $rw4 = $data[4][5];

            if ($gk) {
                $player = Player::find()
                    ->where(['player_id' => $gk])
                    ->limit(1)
                    ->one();
                if ($player) {
                    $power = $power + $player->player_power_real;
                    $position = $position + $player->player_power_real;
                }
            }

            if ($ld1) {
                $player = Player::find()
                    ->where(['player_id' => $ld1])
                    ->limit(1)
                    ->one();
                if ($player) {
                    $coefficient = 0;
                    foreach ($player->playerPosition as $playerPosition) {
                        if (Position::LD == $playerPosition->player_position_position_id) {
                            if (1 > $coefficient) {
                                $coefficient = 1;
                            }
                        }
                        if (Position::RD == $playerPosition->player_position_position_id) {
                            if (0.9 > $coefficient) {
                                $coefficient = 0.9;
                            }
                        }
                        if (Position::LW == $playerPosition->player_position_position_id) {
                            if (0.9 > $coefficient) {
                                $coefficient = 0.9;
                            }
                        }
                        if (Position::CF == $playerPosition->player_position_position_id) {
                            if (0.8 > $coefficient) {
                                $coefficient = 0.8;
                            }
                        }
                        if (Position::RW == $playerPosition->player_position_position_id) {
                            if (0.8 > $coefficient) {
                                $coefficient = 0.8;
                            }
                        }
                    }
                    $power = $power + round($player->player_power_real * $coefficient);
                    $position = $position + $player->player_power_real;
                }
            }

            if ($rd1) {
                $player = Player::find()
                    ->where(['player_id' => $rd1])
                    ->limit(1)
                    ->one();
                if ($player) {
                    $coefficient = 0;
                    foreach ($player->playerPosition as $playerPosition) {
                        if (Position::LD == $playerPosition->player_position_position_id) {
                            if (0.9 > $coefficient) {
                                $coefficient = 0.9;
                            }
                        }
                        if (Position::RD == $playerPosition->player_position_position_id) {
                            if (1 > $coefficient) {
                                $coefficient = 1;
                            }
                        }
                        if (Position::LW == $playerPosition->player_position_position_id) {
                            if (0.8 > $coefficient) {
                                $coefficient = 0.8;
                            }
                        }
                        if (Position::CF == $playerPosition->player_position_position_id) {
                            if (0.8 > $coefficient) {
                                $coefficient = 0.8;
                            }
                        }
                        if (Position::RW == $playerPosition->player_position_position_id) {
                            if (0.9 > $coefficient) {
                                $coefficient = 0.9;
                            }
                        }
                    }
                    $power = $power + round($player->player_power_real * $coefficient);
                    $position = $position + $player->player_power_real;
                }
            }

            if ($lw1) {
                $player = Player::find()
                    ->where(['player_id' => $lw1])
                    ->limit(1)
                    ->one();
                if ($player) {
                    $coefficient = 0;
                    foreach ($player->playerPosition as $playerPosition) {
                        if (Position::LD == $playerPosition->player_position_position_id) {
                            if (0.9 > $coefficient) {
                                $coefficient = 0.9;
                            }
                        }
                        if (Position::RD == $playerPosition->player_position_position_id) {
                            if (0.8 > $coefficient) {
                                $coefficient = 0.8;
                            }
                        }
                        if (Position::LW == $playerPosition->player_position_position_id) {
                            if (1 > $coefficient) {
                                $coefficient = 1;
                            }
                        }
                        if (Position::CF == $playerPosition->player_position_position_id) {
                            if (0.9 > $coefficient) {
                                $coefficient = 0.9;
                            }
                        }
                        if (Position::RW == $playerPosition->player_position_position_id) {
                            if (1 > $coefficient) {
                                $coefficient = 1;
                            }
                        }
                    }
                    $power = $power + round($player->player_power_real * $coefficient);
                    $position = $position + $player->player_power_real;
                }
            }

            if ($cf1) {
                $player = Player::find()
                    ->where(['player_id' => $cf1])
                    ->limit(1)
                    ->one();
                if ($player) {
                    $coefficient = 0;
                    foreach ($player->playerPosition as $playerPosition) {
                        if (Position::LD == $playerPosition->player_position_position_id) {
                            if (0.8 > $coefficient) {
                                $coefficient = 0.8;
                            }
                        }
                        if (Position::RD == $playerPosition->player_position_position_id) {
                            if (0.8 > $coefficient) {
                                $coefficient = 0.8;
                            }
                        }
                        if (Position::LW == $playerPosition->player_position_position_id) {
                            if (0.9 > $coefficient) {
                                $coefficient = 0.9;
                            }
                        }
                        if (Position::CF == $playerPosition->player_position_position_id) {
                            if (1 > $coefficient) {
                                $coefficient = 1;
                            }
                        }
                        if (Position::RW == $playerPosition->player_position_position_id) {
                            if (0.9 > $coefficient) {
                                $coefficient = 0.9;
                            }
                        }
                    }
                    $power = $power + round($player->player_power_real * $coefficient);
                    $position = $position + $player->player_power_real;
                }
            }

            if ($rw1) {
                $player = Player::find()
                    ->where(['player_id' => $rw1])
                    ->limit(1)
                    ->one();
                if ($player) {
                    $coefficient = 0;
                    foreach ($player->playerPosition as $playerPosition) {
                        if (Position::LD == $playerPosition->player_position_position_id) {
                            if (0.8 > $coefficient) {
                                $coefficient = 0.8;
                            }
                        }
                        if (Position::RD == $playerPosition->player_position_position_id) {
                            if (0.9 > $coefficient) {
                                $coefficient = 0.9;
                            }
                        }
                        if (Position::LW == $playerPosition->player_position_position_id) {
                            if (0.8 > $coefficient) {
                                $coefficient = 0.8;
                            }
                        }
                        if (Position::CF == $playerPosition->player_position_position_id) {
                            if (0.9 > $coefficient) {
                                $coefficient = 0.9;
                            }
                        }
                        if (Position::RW == $playerPosition->player_position_position_id) {
                            if (1 > $coefficient) {
                                $coefficient = 1;
                            }
                        }
                    }
                    $power = $power + round($player->player_power_real * $coefficient);
                    $position = $position + $player->player_power_real;
                }
            }

            if ($ld2) {
                $player = Player::find()
                    ->where(['player_id' => $ld2])
                    ->limit(1)
                    ->one();
                if ($player) {
                    $coefficient = 0;
                    foreach ($player->playerPosition as $playerPosition) {
                        if (Position::LD == $playerPosition->player_position_position_id) {
                            if (1 > $coefficient) {
                                $coefficient = 1;
                            }
                        }
                        if (Position::RD == $playerPosition->player_position_position_id) {
                            if (0.9 > $coefficient) {
                                $coefficient = 0.9;
                            }
                        }
                        if (Position::LW == $playerPosition->player_position_position_id) {
                            if (0.9 > $coefficient) {
                                $coefficient = 0.9;
                            }
                        }
                        if (Position::CF == $playerPosition->player_position_position_id) {
                            if (0.8 > $coefficient) {
                                $coefficient = 0.8;
                            }
                        }
                        if (Position::RW == $playerPosition->player_position_position_id) {
                            if (0.8 > $coefficient) {
                                $coefficient = 0.8;
                            }
                        }
                    }
                    $power = $power + round($player->player_power_real * $coefficient);
                    $position = $position + $player->player_power_real;
                }
            }

            if ($rd2) {
                $player = Player::find()
                    ->where(['player_id' => $rd2])
                    ->limit(1)
                    ->one();
                if ($player) {
                    $coefficient = 0;
                    foreach ($player->playerPosition as $playerPosition) {
                        if (Position::LD == $playerPosition->player_position_position_id) {
                            if (0.9 > $coefficient) {
                                $coefficient = 0.9;
                            }
                        }
                        if (Position::RD == $playerPosition->player_position_position_id) {
                            if (1 > $coefficient) {
                                $coefficient = 1;
                            }
                        }
                        if (Position::LW == $playerPosition->player_position_position_id) {
                            if (0.8 > $coefficient) {
                                $coefficient = 0.8;
                            }
                        }
                        if (Position::CF == $playerPosition->player_position_position_id) {
                            if (0.8 > $coefficient) {
                                $coefficient = 0.8;
                            }
                        }
                        if (Position::RW == $playerPosition->player_position_position_id) {
                            if (0.9 > $coefficient) {
                                $coefficient = 0.9;
                            }
                        }
                    }
                    $power = $power + round($player->player_power_real * $coefficient);
                    $position = $position + $player->player_power_real;
                }
            }

            if ($lw2) {
                $player = Player::find()
                    ->where(['player_id' => $lw2])
                    ->limit(1)
                    ->one();
                if ($player) {
                    $coefficient = 0;
                    foreach ($player->playerPosition as $playerPosition) {
                        if (Position::LD == $playerPosition->player_position_position_id) {
                            if (0.9 > $coefficient) {
                                $coefficient = 0.9;
                            }
                        }
                        if (Position::RD == $playerPosition->player_position_position_id) {
                            if (0.8 > $coefficient) {
                                $coefficient = 0.8;
                            }
                        }
                        if (Position::LW == $playerPosition->player_position_position_id) {
                            if (1 > $coefficient) {
                                $coefficient = 1;
                            }
                        }
                        if (Position::CF == $playerPosition->player_position_position_id) {
                            if (0.9 > $coefficient) {
                                $coefficient = 0.9;
                            }
                        }
                        if (Position::RW == $playerPosition->player_position_position_id) {
                            if (1 > $coefficient) {
                                $coefficient = 1;
                            }
                        }
                    }
                    $power = $power + round($player->player_power_real * $coefficient);
                    $position = $position + $player->player_power_real;
                }
            }

            if ($cf2) {
                $player = Player::find()
                    ->where(['player_id' => $cf2])
                    ->limit(1)
                    ->one();
                if ($player) {
                    $coefficient = 0;
                    foreach ($player->playerPosition as $playerPosition) {
                        if (Position::LD == $playerPosition->player_position_position_id) {
                            if (0.8 > $coefficient) {
                                $coefficient = 0.8;
                            }
                        }
                        if (Position::RD == $playerPosition->player_position_position_id) {
                            if (0.8 > $coefficient) {
                                $coefficient = 0.8;
                            }
                        }
                        if (Position::LW == $playerPosition->player_position_position_id) {
                            if (0.9 > $coefficient) {
                                $coefficient = 0.9;
                            }
                        }
                        if (Position::CF == $playerPosition->player_position_position_id) {
                            if (1 > $coefficient) {
                                $coefficient = 1;
                            }
                        }
                        if (Position::RW == $playerPosition->player_position_position_id) {
                            if (0.9 > $coefficient) {
                                $coefficient = 0.9;
                            }
                        }
                    }
                    $power = $power + round($player->player_power_real * $coefficient);
                    $position = $position + $player->player_power_real;
                }
            }

            if ($rw2) {
                $player = Player::find()
                    ->where(['player_id' => $rw2])
                    ->limit(1)
                    ->one();
                if ($player) {
                    $coefficient = 0;
                    foreach ($player->playerPosition as $playerPosition) {
                        if (Position::LD == $playerPosition->player_position_position_id) {
                            if (0.8 > $coefficient) {
                                $coefficient = 0.8;
                            }
                        }
                        if (Position::RD == $playerPosition->player_position_position_id) {
                            if (0.9 > $coefficient) {
                                $coefficient = 0.9;
                            }
                        }
                        if (Position::LW == $playerPosition->player_position_position_id) {
                            if (0.8 > $coefficient) {
                                $coefficient = 0.8;
                            }
                        }
                        if (Position::CF == $playerPosition->player_position_position_id) {
                            if (0.9 > $coefficient) {
                                $coefficient = 0.9;
                            }
                        }
                        if (Position::RW == $playerPosition->player_position_position_id) {
                            if (1 > $coefficient) {
                                $coefficient = 1;
                            }
                        }
                    }
                    $power = $power + round($player->player_power_real * $coefficient);
                    $position = $position + $player->player_power_real;
                }
            }

            if ($ld3) {
                $player = Player::find()
                    ->where(['player_id' => $ld3])
                    ->limit(1)
                    ->one();
                if ($player) {
                    $coefficient = 0;
                    foreach ($player->playerPosition as $playerPosition) {
                        if (Position::LD == $playerPosition->player_position_position_id) {
                            if (1 > $coefficient) {
                                $coefficient = 1;
                            }
                        }
                        if (Position::RD == $playerPosition->player_position_position_id) {
                            if (0.9 > $coefficient) {
                                $coefficient = 0.9;
                            }
                        }
                        if (Position::LW == $playerPosition->player_position_position_id) {
                            if (0.9 > $coefficient) {
                                $coefficient = 0.9;
                            }
                        }
                        if (Position::CF == $playerPosition->player_position_position_id) {
                            if (0.8 > $coefficient) {
                                $coefficient = 0.8;
                            }
                        }
                        if (Position::RW == $playerPosition->player_position_position_id) {
                            if (0.8 > $coefficient) {
                                $coefficient = 0.8;
                            }
                        }
                    }
                    $power = $power + round($player->player_power_real * $coefficient);
                    $position = $position + $player->player_power_real;
                }
            }

            if ($rd3) {
                $player = Player::find()
                    ->where(['player_id' => $rd3])
                    ->limit(1)
                    ->one();
                if ($player) {
                    $coefficient = 0;
                    foreach ($player->playerPosition as $playerPosition) {
                        if (Position::LD == $playerPosition->player_position_position_id) {
                            if (0.9 > $coefficient) {
                                $coefficient = 0.9;
                            }
                        }
                        if (Position::RD == $playerPosition->player_position_position_id) {
                            if (1 > $coefficient) {
                                $coefficient = 1;
                            }
                        }
                        if (Position::LW == $playerPosition->player_position_position_id) {
                            if (0.8 > $coefficient) {
                                $coefficient = 0.8;
                            }
                        }
                        if (Position::CF == $playerPosition->player_position_position_id) {
                            if (0.8 > $coefficient) {
                                $coefficient = 0.8;
                            }
                        }
                        if (Position::RW == $playerPosition->player_position_position_id) {
                            if (0.9 > $coefficient) {
                                $coefficient = 0.9;
                            }
                        }
                    }
                    $power = $power + round($player->player_power_real * $coefficient);
                    $position = $position + $player->player_power_real;
                }
            }

            if ($lw3) {
                $player = Player::find()
                    ->where(['player_id' => $lw3])
                    ->limit(1)
                    ->one();
                if ($player) {
                    $coefficient = 0;
                    foreach ($player->playerPosition as $playerPosition) {
                        if (Position::LD == $playerPosition->player_position_position_id) {
                            if (0.9 > $coefficient) {
                                $coefficient = 0.9;
                            }
                        }
                        if (Position::RD == $playerPosition->player_position_position_id) {
                            if (0.8 > $coefficient) {
                                $coefficient = 0.8;
                            }
                        }
                        if (Position::LW == $playerPosition->player_position_position_id) {
                            if (1 > $coefficient) {
                                $coefficient = 1;
                            }
                        }
                        if (Position::CF == $playerPosition->player_position_position_id) {
                            if (0.9 > $coefficient) {
                                $coefficient = 0.9;
                            }
                        }
                        if (Position::RW == $playerPosition->player_position_position_id) {
                            if (1 > $coefficient) {
                                $coefficient = 1;
                            }
                        }
                    }
                    $power = $power + round($player->player_power_real * $coefficient);
                    $position = $position + $player->player_power_real;
                }
            }

            if ($cf3) {
                $player = Player::find()
                    ->where(['player_id' => $cf3])
                    ->limit(1)
                    ->one();
                if ($player) {
                    $coefficient = 0;
                    foreach ($player->playerPosition as $playerPosition) {
                        if (Position::LD == $playerPosition->player_position_position_id) {
                            if (0.8 > $coefficient) {
                                $coefficient = 0.8;
                            }
                        }
                        if (Position::RD == $playerPosition->player_position_position_id) {
                            if (0.8 > $coefficient) {
                                $coefficient = 0.8;
                            }
                        }
                        if (Position::LW == $playerPosition->player_position_position_id) {
                            if (0.9 > $coefficient) {
                                $coefficient = 0.9;
                            }
                        }
                        if (Position::CF == $playerPosition->player_position_position_id) {
                            if (1 > $coefficient) {
                                $coefficient = 1;
                            }
                        }
                        if (Position::RW == $playerPosition->player_position_position_id) {
                            if (0.9 > $coefficient) {
                                $coefficient = 0.9;
                            }
                        }
                    }
                    $power = $power + round($player->player_power_real * $coefficient);
                    $position = $position + $player->player_power_real;
                }
            }

            if ($rw3) {
                $player = Player::find()
                    ->where(['player_id' => $rw3])
                    ->limit(1)
                    ->one();
                if ($player) {
                    $coefficient = 0;
                    foreach ($player->playerPosition as $playerPosition) {
                        if (Position::LD == $playerPosition->player_position_position_id) {
                            if (0.8 > $coefficient) {
                                $coefficient = 0.8;
                            }
                        }
                        if (Position::RD == $playerPosition->player_position_position_id) {
                            if (0.9 > $coefficient) {
                                $coefficient = 0.9;
                            }
                        }
                        if (Position::LW == $playerPosition->player_position_position_id) {
                            if (0.8 > $coefficient) {
                                $coefficient = 0.8;
                            }
                        }
                        if (Position::CF == $playerPosition->player_position_position_id) {
                            if (0.9 > $coefficient) {
                                $coefficient = 0.9;
                            }
                        }
                        if (Position::RW == $playerPosition->player_position_position_id) {
                            if (1 > $coefficient) {
                                $coefficient = 1;
                            }
                        }
                    }
                    $power = $power + round($player->player_power_real * $coefficient);
                    $position = $position + $player->player_power_real;
                }
            }

            if ($ld4) {
                $player = Player::find()
                    ->where(['player_id' => $ld4])
                    ->limit(1)
                    ->one();
                if ($player) {
                    $coefficient = 0;
                    foreach ($player->playerPosition as $playerPosition) {
                        if (Position::LD == $playerPosition->player_position_position_id) {
                            if (1 > $coefficient) {
                                $coefficient = 1;
                            }
                        }
                        if (Position::RD == $playerPosition->player_position_position_id) {
                            if (0.9 > $coefficient) {
                                $coefficient = 0.9;
                            }
                        }
                        if (Position::LW == $playerPosition->player_position_position_id) {
                            if (0.9 > $coefficient) {
                                $coefficient = 0.9;
                            }
                        }
                        if (Position::CF == $playerPosition->player_position_position_id) {
                            if (0.8 > $coefficient) {
                                $coefficient = 0.8;
                            }
                        }
                        if (Position::RW == $playerPosition->player_position_position_id) {
                            if (0.8 > $coefficient) {
                                $coefficient = 0.8;
                            }
                        }
                    }
                    $power = $power + round($player->player_power_real * $coefficient);
                    $position = $position + $player->player_power_real;
                }
            }

            if ($rd4) {
                $player = Player::find()
                    ->where(['player_id' => $rd4])
                    ->limit(1)
                    ->one();
                if ($player) {
                    $coefficient = 0;
                    foreach ($player->playerPosition as $playerPosition) {
                        if (Position::LD == $playerPosition->player_position_position_id) {
                            if (0.9 > $coefficient) {
                                $coefficient = 0.9;
                            }
                        }
                        if (Position::RD == $playerPosition->player_position_position_id) {
                            if (1 > $coefficient) {
                                $coefficient = 1;
                            }
                        }
                        if (Position::LW == $playerPosition->player_position_position_id) {
                            if (0.8 > $coefficient) {
                                $coefficient = 0.8;
                            }
                        }
                        if (Position::CF == $playerPosition->player_position_position_id) {
                            if (0.8 > $coefficient) {
                                $coefficient = 0.8;
                            }
                        }
                        if (Position::RW == $playerPosition->player_position_position_id) {
                            if (0.9 > $coefficient) {
                                $coefficient = 0.9;
                            }
                        }
                    }
                    $power = $power + round($player->player_power_real * $coefficient);
                    $position = $position + $player->player_power_real;
                }
            }

            if ($lw4) {
                $player = Player::find()
                    ->where(['player_id' => $lw4])
                    ->limit(1)
                    ->one();
                if ($player) {
                    $coefficient = 0;
                    foreach ($player->playerPosition as $playerPosition) {
                        if (Position::LD == $playerPosition->player_position_position_id) {
                            if (0.9 > $coefficient) {
                                $coefficient = 0.9;
                            }
                        }
                        if (Position::RD == $playerPosition->player_position_position_id) {
                            if (0.8 > $coefficient) {
                                $coefficient = 0.8;
                            }
                        }
                        if (Position::LW == $playerPosition->player_position_position_id) {
                            if (1 > $coefficient) {
                                $coefficient = 1;
                            }
                        }
                        if (Position::CF == $playerPosition->player_position_position_id) {
                            if (0.9 > $coefficient) {
                                $coefficient = 0.9;
                            }
                        }
                        if (Position::RW == $playerPosition->player_position_position_id) {
                            if (1 > $coefficient) {
                                $coefficient = 1;
                            }
                        }
                    }
                    $power = $power + round($player->player_power_real * $coefficient);
                    $position = $position + $player->player_power_real;
                }
            }

            if ($cf4) {
                $player = Player::find()
                    ->where(['player_id' => $cf4])
                    ->limit(1)
                    ->one();
                if ($player) {
                    $coefficient = 0;
                    foreach ($player->playerPosition as $playerPosition) {
                        if (Position::LD == $playerPosition->player_position_position_id) {
                            if (0.8 > $coefficient) {
                                $coefficient = 0.8;
                            }
                        }
                        if (Position::RD == $playerPosition->player_position_position_id) {
                            if (0.8 > $coefficient) {
                                $coefficient = 0.8;
                            }
                        }
                        if (Position::LW == $playerPosition->player_position_position_id) {
                            if (0.9 > $coefficient) {
                                $coefficient = 0.9;
                            }
                        }
                        if (Position::CF == $playerPosition->player_position_position_id) {
                            if (1 > $coefficient) {
                                $coefficient = 1;
                            }
                        }
                        if (Position::RW == $playerPosition->player_position_position_id) {
                            if (0.9 > $coefficient) {
                                $coefficient = 0.9;
                            }
                        }
                    }
                    $power = $power + round($player->player_power_real * $coefficient);
                    $position = $position + $player->player_power_real;
                }
            }

            if ($rw4) {
                $player = Player::find()
                    ->where(['player_id' => $rw4])
                    ->limit(1)
                    ->one();
                if ($player) {
                    $coefficient = 0;
                    foreach ($player->playerPosition as $playerPosition) {
                        if (Position::LD == $playerPosition->player_position_position_id) {
                            if (0.8 > $coefficient) {
                                $coefficient = 0.8;
                            }
                        }
                        if (Position::RD == $playerPosition->player_position_position_id) {
                            if (0.9 > $coefficient) {
                                $coefficient = 0.9;
                            }
                        }
                        if (Position::LW == $playerPosition->player_position_position_id) {
                            if (0.8 > $coefficient) {
                                $coefficient = 0.8;
                            }
                        }
                        if (Position::CF == $playerPosition->player_position_position_id) {
                            if (0.9 > $coefficient) {
                                $coefficient = 0.9;
                            }
                        }
                        if (Position::RW == $playerPosition->player_position_position_id) {
                            if (1 > $coefficient) {
                                $coefficient = 1;
                            }
                        }
                    }
                    $power = $power + round($player->player_power_real * $coefficient);
                    $position = $position + $player->player_power_real;
                }
            }

            $teamwork = Teamwork::find()
                ->where([
                    'or',
                    ['teamwork_player_id_1' => $ld1, 'teamwork_player_id_2' => $rd1],
                    ['teamwork_player_id_1' => $rd1, 'teamwork_player_id_2' => $ld1]
                ])
                ->limit(1)
                ->one();
            if ($teamwork) {
                $teamwork_1 = $teamwork_1 + $teamwork->teamwork_value;
            }

            $teamwork = Teamwork::find()
                ->where([
                    'or',
                    ['teamwork_player_id_1' => $ld1, 'teamwork_player_id_2' => $lw1],
                    ['teamwork_player_id_1' => $lw1, 'teamwork_player_id_2' => $ld1]
                ])
                ->limit(1)
                ->one();
            if ($teamwork) {
                $teamwork_1 = $teamwork_1 + $teamwork->teamwork_value;
            }

            $teamwork = Teamwork::find()
                ->where([
                    'or',
                    ['teamwork_player_id_1' => $ld1, 'teamwork_player_id_2' => $cf1],
                    ['teamwork_player_id_1' => $cf1, 'teamwork_player_id_2' => $ld1]
                ])
                ->limit(1)
                ->one();
            if ($teamwork) {
                $teamwork_1 = $teamwork_1 + $teamwork->teamwork_value;
            }

            $teamwork = Teamwork::find()
                ->where([
                    'or',
                    ['teamwork_player_id_1' => $ld1, 'teamwork_player_id_2' => $rw1],
                    ['teamwork_player_id_1' => $rw1, 'teamwork_player_id_2' => $ld1]
                ])
                ->limit(1)
                ->one();
            if ($teamwork) {
                $teamwork_1 = $teamwork_1 + $teamwork->teamwork_value;
            }

            $teamwork = Teamwork::find()
                ->where([
                    'or',
                    ['teamwork_player_id_1' => $rd1, 'teamwork_player_id_2' => $lw1],
                    ['teamwork_player_id_1' => $lw1, 'teamwork_player_id_2' => $rd1]
                ])
                ->limit(1)
                ->one();
            if ($teamwork) {
                $teamwork_1 = $teamwork_1 + $teamwork->teamwork_value;
            }

            $teamwork = Teamwork::find()
                ->where([
                    'or',
                    ['teamwork_player_id_1' => $rd1, 'teamwork_player_id_2' => $cf1],
                    ['teamwork_player_id_1' => $cf1, 'teamwork_player_id_2' => $rd1]
                ])
                ->limit(1)
                ->one();
            if ($teamwork) {
                $teamwork_1 = $teamwork_1 + $teamwork->teamwork_value;
            }

            $teamwork = Teamwork::find()
                ->where([
                    'or',
                    ['teamwork_player_id_1' => $rd1, 'teamwork_player_id_2' => $rw1],
                    ['teamwork_player_id_1' => $rw1, 'teamwork_player_id_2' => $rd1]
                ])
                ->limit(1)
                ->one();
            if ($teamwork) {
                $teamwork_1 = $teamwork_1 + $teamwork->teamwork_value;
            }

            $teamwork = Teamwork::find()
                ->where([
                    'or',
                    ['teamwork_player_id_1' => $lw1, 'teamwork_player_id_2' => $cf1],
                    ['teamwork_player_id_1' => $cf1, 'teamwork_player_id_2' => $lw1]
                ])
                ->limit(1)
                ->one();
            if ($teamwork) {
                $teamwork_1 = $teamwork_1 + $teamwork->teamwork_value;
            }

            $teamwork = Teamwork::find()
                ->where([
                    'or',
                    ['teamwork_player_id_1' => $lw1, 'teamwork_player_id_2' => $rw1],
                    ['teamwork_player_id_1' => $rw1, 'teamwork_player_id_2' => $lw1]
                ])
                ->limit(1)
                ->one();
            if ($teamwork) {
                $teamwork_1 = $teamwork_1 + $teamwork->teamwork_value;
            }

            $teamwork = Teamwork::find()
                ->where([
                    'or',
                    ['teamwork_player_id_1' => $cf1, 'teamwork_player_id_2' => $rw1],
                    ['teamwork_player_id_1' => $rw1, 'teamwork_player_id_2' => $cf1]
                ])
                ->limit(1)
                ->one();
            if ($teamwork) {
                $teamwork_1 = $teamwork_1 + $teamwork->teamwork_value;
            }

            $teamwork = Teamwork::find()
                ->where([
                    'or',
                    ['teamwork_player_id_1' => $ld2, 'teamwork_player_id_2' => $rd2],
                    ['teamwork_player_id_1' => $rd2, 'teamwork_player_id_2' => $ld2]
                ])
                ->limit(1)
                ->one();
            if ($teamwork) {
                $teamwork_2 = $teamwork_2 + $teamwork->teamwork_value;
            }

            $teamwork = Teamwork::find()
                ->where([
                    'or',
                    ['teamwork_player_id_1' => $ld2, 'teamwork_player_id_2' => $lw2],
                    ['teamwork_player_id_1' => $lw2, 'teamwork_player_id_2' => $ld2]
                ])
                ->limit(1)
                ->one();
            if ($teamwork) {
                $teamwork_2 = $teamwork_2 + $teamwork->teamwork_value;
            }

            $teamwork = Teamwork::find()
                ->where([
                    'or',
                    ['teamwork_player_id_1' => $ld2, 'teamwork_player_id_2' => $cf2],
                    ['teamwork_player_id_1' => $cf2, 'teamwork_player_id_2' => $ld2]
                ])
                ->limit(1)
                ->one();
            if ($teamwork) {
                $teamwork_2 = $teamwork_2 + $teamwork->teamwork_value;
            }

            $teamwork = Teamwork::find()
                ->where([
                    'or',
                    ['teamwork_player_id_1' => $ld2, 'teamwork_player_id_2' => $rw2],
                    ['teamwork_player_id_1' => $rw2, 'teamwork_player_id_2' => $ld2]
                ])
                ->limit(1)
                ->one();
            if ($teamwork) {
                $teamwork_2 = $teamwork_2 + $teamwork->teamwork_value;
            }

            $teamwork = Teamwork::find()
                ->where([
                    'or',
                    ['teamwork_player_id_1' => $rd2, 'teamwork_player_id_2' => $lw2],
                    ['teamwork_player_id_1' => $lw2, 'teamwork_player_id_2' => $rd2]
                ])
                ->limit(1)
                ->one();
            if ($teamwork) {
                $teamwork_2 = $teamwork_2 + $teamwork->teamwork_value;
            }

            $teamwork = Teamwork::find()
                ->where([
                    'or',
                    ['teamwork_player_id_1' => $rd2, 'teamwork_player_id_2' => $cf2],
                    ['teamwork_player_id_1' => $cf2, 'teamwork_player_id_2' => $rd2]
                ])
                ->limit(1)
                ->one();
            if ($teamwork) {
                $teamwork_2 = $teamwork_2 + $teamwork->teamwork_value;
            }

            $teamwork = Teamwork::find()
                ->where([
                    'or',
                    ['teamwork_player_id_1' => $rd2, 'teamwork_player_id_2' => $rw2],
                    ['teamwork_player_id_1' => $rw2, 'teamwork_player_id_2' => $rd2]
                ])
                ->limit(1)
                ->one();
            if ($teamwork) {
                $teamwork_2 = $teamwork_2 + $teamwork->teamwork_value;
            }

            $teamwork = Teamwork::find()
                ->where([
                    'or',
                    ['teamwork_player_id_1' => $lw2, 'teamwork_player_id_2' => $cf2],
                    ['teamwork_player_id_1' => $cf2, 'teamwork_player_id_2' => $lw2]
                ])
                ->limit(1)
                ->one();
            if ($teamwork) {
                $teamwork_2 = $teamwork_2 + $teamwork->teamwork_value;
            }

            $teamwork = Teamwork::find()
                ->where([
                    'or',
                    ['teamwork_player_id_1' => $lw2, 'teamwork_player_id_2' => $rw2],
                    ['teamwork_player_id_1' => $rw2, 'teamwork_player_id_2' => $lw2]
                ])
                ->limit(1)
                ->one();
            if ($teamwork) {
                $teamwork_2 = $teamwork_2 + $teamwork->teamwork_value;
            }

            $teamwork = Teamwork::find()
                ->where([
                    'or',
                    ['teamwork_player_id_1' => $cf2, 'teamwork_player_id_2' => $rw2],
                    ['teamwork_player_id_1' => $rw2, 'teamwork_player_id_2' => $cf2]
                ])
                ->limit(1)
                ->one();
            if ($teamwork) {
                $teamwork_2 = $teamwork_2 + $teamwork->teamwork_value;
            }

            $teamwork = Teamwork::find()
                ->where([
                    'or',
                    ['teamwork_player_id_1' => $ld3, 'teamwork_player_id_2' => $rd3],
                    ['teamwork_player_id_1' => $rd3, 'teamwork_player_id_2' => $ld3]
                ])
                ->limit(1)
                ->one();
            if ($teamwork) {
                $teamwork_3 = $teamwork_3 + $teamwork->teamwork_value;
            }

            $teamwork = Teamwork::find()
                ->where([
                    'or',
                    ['teamwork_player_id_1' => $ld3, 'teamwork_player_id_2' => $lw3],
                    ['teamwork_player_id_1' => $lw3, 'teamwork_player_id_2' => $ld3]
                ])
                ->limit(1)
                ->one();
            if ($teamwork) {
                $teamwork_3 = $teamwork_3 + $teamwork->teamwork_value;
            }

            $teamwork = Teamwork::find()
                ->where([
                    'or',
                    ['teamwork_player_id_1' => $ld3, 'teamwork_player_id_2' => $cf3],
                    ['teamwork_player_id_1' => $cf3, 'teamwork_player_id_2' => $ld3]
                ])
                ->limit(1)
                ->one();
            if ($teamwork) {
                $teamwork_3 = $teamwork_3 + $teamwork->teamwork_value;
            }

            $teamwork = Teamwork::find()
                ->where([
                    'or',
                    ['teamwork_player_id_1' => $ld3, 'teamwork_player_id_2' => $rw3],
                    ['teamwork_player_id_1' => $rw3, 'teamwork_player_id_2' => $ld3]
                ])
                ->limit(1)
                ->one();
            if ($teamwork) {
                $teamwork_3 = $teamwork_3 + $teamwork->teamwork_value;
            }

            $teamwork = Teamwork::find()
                ->where([
                    'or',
                    ['teamwork_player_id_1' => $rd3, 'teamwork_player_id_2' => $lw3],
                    ['teamwork_player_id_1' => $lw3, 'teamwork_player_id_2' => $rd3]
                ])
                ->limit(1)
                ->one();
            if ($teamwork) {
                $teamwork_3 = $teamwork_3 + $teamwork->teamwork_value;
            }

            $teamwork = Teamwork::find()
                ->where([
                    'or',
                    ['teamwork_player_id_1' => $rd3, 'teamwork_player_id_2' => $cf3],
                    ['teamwork_player_id_1' => $cf3, 'teamwork_player_id_2' => $rd3]
                ])
                ->limit(1)
                ->one();
            if ($teamwork) {
                $teamwork_3 = $teamwork_3 + $teamwork->teamwork_value;
            }

            $teamwork = Teamwork::find()
                ->where([
                    'or',
                    ['teamwork_player_id_1' => $rd3, 'teamwork_player_id_2' => $rw3],
                    ['teamwork_player_id_1' => $rw3, 'teamwork_player_id_2' => $rd3]
                ])
                ->limit(1)
                ->one();
            if ($teamwork) {
                $teamwork_3 = $teamwork_3 + $teamwork->teamwork_value;
            }

            $teamwork = Teamwork::find()
                ->where([
                    'or',
                    ['teamwork_player_id_1' => $lw3, 'teamwork_player_id_2' => $cf3],
                    ['teamwork_player_id_1' => $cf3, 'teamwork_player_id_2' => $lw3]
                ])
                ->limit(1)
                ->one();
            if ($teamwork) {
                $teamwork_3 = $teamwork_3 + $teamwork->teamwork_value;
            }

            $teamwork = Teamwork::find()
                ->where([
                    'or',
                    ['teamwork_player_id_1' => $lw3, 'teamwork_player_id_2' => $rw3],
                    ['teamwork_player_id_1' => $rw3, 'teamwork_player_id_2' => $lw3]
                ])
                ->limit(1)
                ->one();
            if ($teamwork) {
                $teamwork_3 = $teamwork_3 + $teamwork->teamwork_value;
            }

            $teamwork = Teamwork::find()
                ->where([
                    'or',
                    ['teamwork_player_id_1' => $cf3, 'teamwork_player_id_2' => $rw3],
                    ['teamwork_player_id_1' => $rw3, 'teamwork_player_id_2' => $cf3]
                ])
                ->limit(1)
                ->one();
            if ($teamwork) {
                $teamwork_3 = $teamwork_3 + $teamwork->teamwork_value;
            }

            $teamwork = Teamwork::find()
                ->where([
                    'or',
                    ['teamwork_player_id_1' => $ld4, 'teamwork_player_id_2' => $rd4],
                    ['teamwork_player_id_1' => $rd4, 'teamwork_player_id_2' => $ld4]
                ])
                ->limit(1)
                ->one();
            if ($teamwork) {
                $teamwork_4 = $teamwork_4 + $teamwork->teamwork_value;
            }

            $teamwork = Teamwork::find()
                ->where([
                    'or',
                    ['teamwork_player_id_1' => $ld4, 'teamwork_player_id_2' => $lw4],
                    ['teamwork_player_id_1' => $lw4, 'teamwork_player_id_2' => $ld4]
                ])
                ->limit(1)
                ->one();
            if ($teamwork) {
                $teamwork_4 = $teamwork_4 + $teamwork->teamwork_value;
            }

            $teamwork = Teamwork::find()
                ->where([
                    'or',
                    ['teamwork_player_id_1' => $ld4, 'teamwork_player_id_2' => $cf4],
                    ['teamwork_player_id_1' => $cf4, 'teamwork_player_id_2' => $ld4]
                ])
                ->limit(1)
                ->one();
            if ($teamwork) {
                $teamwork_4 = $teamwork_4 + $teamwork->teamwork_value;
            }

            $teamwork = Teamwork::find()
                ->where([
                    'or',
                    ['teamwork_player_id_1' => $ld4, 'teamwork_player_id_2' => $rw4],
                    ['teamwork_player_id_1' => $rw4, 'teamwork_player_id_2' => $ld4]
                ])
                ->limit(1)
                ->one();
            if ($teamwork) {
                $teamwork_4 = $teamwork_4 + $teamwork->teamwork_value;
            }

            $teamwork = Teamwork::find()
                ->where([
                    'or',
                    ['teamwork_player_id_1' => $rd4, 'teamwork_player_id_2' => $lw4],
                    ['teamwork_player_id_1' => $lw4, 'teamwork_player_id_2' => $rd4]
                ])
                ->limit(1)
                ->one();
            if ($teamwork) {
                $teamwork_4 = $teamwork_4 + $teamwork->teamwork_value;
            }

            $teamwork = Teamwork::find()
                ->where([
                    'or',
                    ['teamwork_player_id_1' => $rd4, 'teamwork_player_id_2' => $cf4],
                    ['teamwork_player_id_1' => $cf4, 'teamwork_player_id_2' => $rd4]
                ])
                ->limit(1)
                ->one();
            if ($teamwork) {
                $teamwork_4 = $teamwork_4 + $teamwork->teamwork_value;
            }

            $teamwork = Teamwork::find()
                ->where([
                    'or',
                    ['teamwork_player_id_1' => $rd4, 'teamwork_player_id_2' => $rw4],
                    ['teamwork_player_id_1' => $rw4, 'teamwork_player_id_2' => $rd4]
                ])
                ->limit(1)
                ->one();
            if ($teamwork) {
                $teamwork_4 = $teamwork_4 + $teamwork->teamwork_value;
            }

            $teamwork = Teamwork::find()
                ->where([
                    'or',
                    ['teamwork_player_id_1' => $lw4, 'teamwork_player_id_2' => $cf4],
                    ['teamwork_player_id_1' => $cf4, 'teamwork_player_id_2' => $lw4]
                ])
                ->limit(1)
                ->one();
            if ($teamwork) {
                $teamwork_4 = $teamwork_4 + $teamwork->teamwork_value;
            }

            $teamwork = Teamwork::find()
                ->where([
                    'or',
                    ['teamwork_player_id_1' => $lw4, 'teamwork_player_id_2' => $rw4],
                    ['teamwork_player_id_1' => $rw4, 'teamwork_player_id_2' => $lw4]
                ])
                ->limit(1)
                ->one();
            if ($teamwork) {
                $teamwork_4 = $teamwork_4 + $teamwork->teamwork_value;
            }

            $teamwork = Teamwork::find()
                ->where([
                    'or',
                    ['teamwork_player_id_1' => $cf4, 'teamwork_player_id_2' => $rw4],
                    ['teamwork_player_id_1' => $rw4, 'teamwork_player_id_2' => $cf4]
                ])
                ->limit(1)
                ->one();
            if ($teamwork) {
                $teamwork_4 = $teamwork_4 + $teamwork->teamwork_value;
            }

            if (0 == $power) {
                $power = 1;
            }

            $position = $position ? $position : 1;

            $position = round($power / $position * 100);

            $lineup = round($power / ($this->myNationalOrVice->national_power_vs ?: 1) * 100);

            $teamwork_1 = round($teamwork_1 / 10);
            $teamwork_2 = round($teamwork_2 / 10);
            $teamwork_3 = round($teamwork_3 / 10);
            $teamwork_4 = round($teamwork_4 / 10);

            $result = [
                'power' => $power,
                'position' => $position,
                'lineup' => $lineup,
                'teamwork_1' => $teamwork_1,
                'teamwork_2' => $teamwork_2,
                'teamwork_3' => $teamwork_3,
                'teamwork_4' => $teamwork_4,
            ];
        }

        Yii::$app->response->format = Response::FORMAT_JSON;
        return $result;
    }

    /**
     * @return string
     */
    public function actionTemplate()
    {
        if (!$this->user->isVip()) {
            return '';
        }
        $lineupTemplateArray = LineupTemplate::find()
            ->where(['lineup_template_national_id' => $this->myNationalOrVice->national_id])
            ->orderBy(['lineup_template_name' => SORT_ASC])
            ->all();
        return $this->renderPartial('_template_table', [
            'lineupTemplateArray' => $lineupTemplateArray,
        ]);
    }

    /**
     * @throws \Exception
     */
    public function actionTemplateSave()
    {
        if (!$this->user->isVip()) {
            return;
        }
        $model = new GameNationalSend();
        $model->saveLineupTemplate();
    }

    /**
     * @param $id
     * @throws \Throwable
     * @throws \yii\db\StaleObjectException
     */
    public function actionTemplateDelete($id)
    {
        if (!$this->user->isVip()) {
            return;
        }
        $model = LineupTemplate::find()
            ->where(['lineup_template_id' => $id, 'lineup_template_national_id' => $this->myNationalOrVice->national_id])
            ->limit(1)
            ->one();
        if ($model) {
            $model->delete();
        }
    }

    /**
     * @param $id
     * @return array|LineupTemplate|\yii\db\ActiveRecord|null
     */
    public function actionTemplateLoad($id)
    {
        Yii::$app->response->format = Response::FORMAT_JSON;
        $model = LineupTemplate::find()
            ->where(['lineup_template_id' => $id, 'lineup_template_national_id' => $this->myNationalOrVice->national_id])
            ->limit(1)
            ->one();
        if (!$model) {
            return (new LineupTemplate())->attributes;
        }
        return $model->attributes;
    }
}
