<?php

namespace console\models\generator;

use common\models\Game;
use common\models\League;
use common\models\ParticipantLeague;
use common\models\Schedule;
use common\models\Season;
use common\models\Stage;
use common\models\TournamentType;
use Yii;

/**
 * Class LeagueLot
 * @package console\models\generator
 */
class LeagueLot
{
    /**
     * @throws \Exception
     * @throws \yii\db\Exception
     * @return void
     */
    public function execute()
    {
        $schedule = Schedule::find()
            ->where('FROM_UNIXTIME(`schedule_date`, "%Y-%m-%d")=CURDATE()')
            ->andWhere(['schedule_tournament_type_id' => TournamentType::LEAGUE])
            ->limit(1)
            ->one();
        if (!$schedule) {
            return;
        }

        $seasonId = Season::getCurrentSeason();

        if (Stage::QUALIFY_1 == $schedule->schedule_stage_id) {
            $check = Schedule::find()
                ->select(['schedule_stage_id'])
                ->where(['schedule_tournament_type_id' => TournamentType::LEAGUE])
                ->andWhere(['>', 'schedule_id', $schedule->schedule_id])
                ->orderBy(['schedule_id' => SORT_ASC])
                ->limit(1)
                ->one();
            if ($check && Stage::QUALIFY_2 == $check->schedule_stage_id) {
                $teamArray = $this->lot(Stage::QUALIFY_2);

                $stageArray = Schedule::find()
                    ->where([
                        'schedule_season_id' => $seasonId,
                        'schedule_stage_id' => Stage::QUALIFY_2,
                        'schedule_tournament_type_id' => TournamentType::LEAGUE,
                    ])
                    ->orderBy(['schedule_id' => SORT_ASC])
                    ->limit(2)
                    ->all();

                foreach ($teamArray as $item) {
                    $model = new Game();
                    $model->game_guest_team_id = $item['guest'];
                    $model->game_home_team_id = $item['home'];
                    $model->game_schedule_id = $stageArray[0]->schedule_id;
                    $model->save();

                    $model = new Game();
                    $model->game_guest_team_id = $item['home'];
                    $model->game_home_team_id = $item['guest'];
                    $model->game_schedule_id = $stageArray[1]->schedule_id;
                    $model->save();
                }

                $sql = "UPDATE `game`
                        LEFT JOIN `team`
                        ON `game_home_team_id`=`team_id`
                        SET `game_stadium_id`=`team_stadium_id`
                        WHERE `game_schedule_id` IN (" . $stageArray[0]->schedule_id . ", " . $stageArray[1]->schedule_id . ")";
                Yii::$app->db->createCommand($sql)->execute();
            }
        } elseif (Stage::QUALIFY_2 == $schedule->schedule_stage_id) {
            $check = Schedule::find()
                ->select(['schedule_stage_id'])
                ->where(['schedule_tournament_type_id' => TournamentType::LEAGUE])
                ->andWhere(['>', 'schedule_id', $schedule->schedule_id])
                ->orderBy(['schedule_id' => SORT_ASC])
                ->limit(1)
                ->one();
            if ($check && Stage::QUALIFY_3 == $check->schedule_stage_id) {
                $teamArray = $this->lot(Stage::QUALIFY_3);

                $stageArray = Schedule::find()
                    ->where([
                        'schedule_season_id' => $seasonId,
                        'schedule_stage_id' => Stage::QUALIFY_3,
                        'schedule_tournament_type_id' => TournamentType::LEAGUE,
                    ])
                    ->orderBy(['schedule_id' => SORT_ASC])
                    ->limit(2)
                    ->all();

                foreach ($teamArray as $item) {
                    $model = new Game();
                    $model->game_guest_team_id = $item['guest'];
                    $model->game_home_team_id = $item['home'];
                    $model->game_schedule_id = $stageArray[0]->schedule_id;
                    $model->save();

                    $model = new Game();
                    $model->game_guest_team_id = $item['home'];
                    $model->game_home_team_id = $item['guest'];
                    $model->game_schedule_id = $stageArray[1]->schedule_id;
                    $model->save();
                }

                $sql = "UPDATE `game`
                        LEFT JOIN `team`
                        ON `game_home_team_id`=`team_id`
                        SET `game_stadium_id`=`team_stadium_id`
                        WHERE `game_schedule_id` IN (" . $stageArray[0]->schedule_id . ", " . $stageArray[1]->schedule_id . ")";
                Yii::$app->db->createCommand($sql)->execute();
            }
        } elseif (Stage::QUALIFY_3 == $schedule->schedule_stage_id) {
            $check = Schedule::find()
                ->select(['schedule_stage_id'])
                ->where(['schedule_tournament_type_id' => TournamentType::LEAGUE])
                ->andWhere(['>', 'schedule_id', $schedule->schedule_id])
                ->orderBy(['schedule_id' => SORT_ASC])
                ->limit(1)
                ->one();
            if ($check && Stage::TOUR_LEAGUE_1 == $check->schedule_stage_id) {
                $teamArray = $this->lot(Stage::TOUR_LEAGUE_1);

                foreach ($teamArray as $group => $team) {
                    foreach ($team as $place => $item) {
                        $model = new League();
                        $model->league_group = $group;
                        $model->league_place = $place + 1;
                        $model->league_season_id = $seasonId;
                        $model->league_team_id = $item;
                        $model->save();
                    }
                }

                $stageArray = Schedule::find()
                    ->where([
                        'schedule_season_id' => $seasonId,
                        'schedule_tournament_type_id' => TournamentType::LEAGUE
                    ])
                    ->andWhere(['between', 'schedule_stage_id', Stage::TOUR_LEAGUE_1, Stage::TOUR_LEAGUE_6])
                    ->orderBy(['schedule_id' => SORT_ASC])
                    ->limit(6)
                    ->all();
                $schedule_id_1 = $stageArray[0]->schedule_id;
                $schedule_id_2 = $stageArray[1]->schedule_id;
                $schedule_id_3 = $stageArray[2]->schedule_id;
                $schedule_id_4 = $stageArray[3]->schedule_id;
                $schedule_id_5 = $stageArray[4]->schedule_id;
                $schedule_id_6 = $stageArray[5]->schedule_id;

                $groupArray = League::find()
                    ->where(['league_season_id' => $seasonId])
                    ->groupBy(['league_group'])
                    ->orderBy(['league_group' => SORT_ASC])
                    ->all();
                foreach ($groupArray as $group) {
                    $teamArray = League::find()
                        ->where(['league_season_id' => $seasonId, 'league_group' => $group->league_group])
                        ->orderBy('RAND()')
                        ->all();

                    $team_id_1 = $teamArray[0]->league_team_id;
                    $team_id_2 = $teamArray[1]->league_team_id;
                    $team_id_3 = $teamArray[2]->league_team_id;
                    $team_id_4 = $teamArray[3]->league_team_id;

                    $stadium_id_1 = $teamArray[0]->team->team_stadium_id;
                    $stadium_id_2 = $teamArray[1]->team->team_stadium_id;
                    $stadium_id_3 = $teamArray[2]->team->team_stadium_id;
                    $stadium_id_4 = $teamArray[3]->team->team_stadium_id;

                    $data = [
                        [$team_id_2, $team_id_1, $schedule_id_1, $stadium_id_2],
                        [$team_id_4, $team_id_3, $schedule_id_1, $stadium_id_4],
                        [$team_id_1, $team_id_3, $schedule_id_2, $stadium_id_1],
                        [$team_id_2, $team_id_4, $schedule_id_2, $stadium_id_2],
                        [$team_id_3, $team_id_2, $schedule_id_3, $stadium_id_3],
                        [$team_id_4, $team_id_1, $schedule_id_3, $stadium_id_4],
                        [$team_id_1, $team_id_2, $schedule_id_4, $stadium_id_1],
                        [$team_id_3, $team_id_4, $schedule_id_4, $stadium_id_3],
                        [$team_id_3, $team_id_1, $schedule_id_5, $stadium_id_3],
                        [$team_id_4, $team_id_2, $schedule_id_5, $stadium_id_4],
                        [$team_id_2, $team_id_3, $schedule_id_6, $stadium_id_2],
                        [$team_id_1, $team_id_4, $schedule_id_6, $stadium_id_1],
                    ];

                    Yii::$app->db
                        ->createCommand()
                        ->batchInsert(
                            Game::tableName(),
                            ['game_home_team_id', 'game_guest_team_id', 'game_schedule_id', 'game_stadium_id'],
                            $data
                        )
                        ->execute();
                }
            }
        } elseif (Stage::TOUR_LEAGUE_6 == $schedule->schedule_stage_id) {
            $stageArray = Schedule::find()
                ->where([
                    'schedule_season_id' => $seasonId,
                    'schedule_stage_id' => Stage::ROUND_OF_16,
                    'schedule_tournament_type_id' => TournamentType::LEAGUE,
                ])
                ->orderBy(['schedule_id' => SORT_ASC])
                ->limit(2)
                ->all();
            for ($i = 1; $i <= 8; $i++) {
                $teamArray = ParticipantLeague::find()
                    ->where([
                        'participant_league_season_id' => $seasonId,
                        'participant_league_stage_8' => $i,
                        'participant_league_stage_id' => 0,
                    ])
                    ->orderBy(['participant_league_id' => SORT_ASC])
                    ->limit(2)
                    ->all();

                $model = new Game();
                $model->game_guest_team_id = $teamArray[1]->participant_league_team_id;
                $model->game_home_team_id = $teamArray[0]->participant_league_team_id;
                $model->game_schedule_id = $stageArray[0]->schedule_id;
                $model->game_stadium_id = $teamArray[0]->team->team_stadium_id;
                $model->save();

                $model = new Game();
                $model->game_guest_team_id = $teamArray[0]->participant_league_team_id;
                $model->game_home_team_id = $teamArray[1]->participant_league_team_id;
                $model->game_schedule_id = $stageArray[1]->schedule_id;
                $model->game_stadium_id = $teamArray[1]->team->team_stadium_id;
                $model->save();
            }
        } elseif (Stage::ROUND_OF_16 == $schedule->schedule_stage_id) {
            $check = Schedule::find()
                ->select(['schedule_stage_id'])
                ->where(['schedule_tournament_type_id' => TournamentType::LEAGUE])
                ->andWhere(['>', 'schedule_id', $schedule->schedule_id])
                ->orderBy(['schedule_id' => SORT_ASC])
                ->limit(1)
                ->one();
            if ($check && Stage::QUARTER == $check->schedule_stage_id) {
                $stageArray = Schedule::find()
                    ->where([
                        'schedule_season_id' => $seasonId,
                        'schedule_stage_id' => Stage::QUARTER,
                        'schedule_tournament_type_id' => TournamentType::LEAGUE,
                    ])
                    ->orderBy(['schedule_id' => SORT_ASC])
                    ->limit(2)
                    ->all();
                for ($i = 1; $i <= 4; $i++) {
                    $teamArray = ParticipantLeague::find()
                        ->where([
                            'participant_league_season_id' => $seasonId,
                            'participant_league_stage_4' => $i,
                            'participant_league_stage_id' => 0,
                        ])
                        ->orderBy(['participant_league_id' => SORT_ASC])
                        ->limit(2)
                        ->all();

                    $model = new Game();
                    $model->game_guest_team_id = $teamArray[1]->participant_league_team_id;
                    $model->game_home_team_id = $teamArray[0]->participant_league_team_id;
                    $model->game_schedule_id = $stageArray[0]->schedule_id;
                    $model->game_stadium_id = $teamArray[0]->team->team_stadium_id;
                    $model->save();

                    $model = new Game();
                    $model->game_guest_team_id = $teamArray[0]->participant_league_team_id;
                    $model->game_home_team_id = $teamArray[1]->participant_league_team_id;
                    $model->game_schedule_id = $stageArray[1]->schedule_id;
                    $model->game_stadium_id = $teamArray[1]->team->team_stadium_id;
                    $model->save();
                }
            }
        } elseif (Stage::QUARTER == $schedule->schedule_stage_id) {
            $check = Schedule::find()
                ->select(['schedule_stage_id'])
                ->where(['schedule_tournament_type_id' => TournamentType::LEAGUE])
                ->andWhere(['>', 'schedule_id', $schedule->schedule_id])
                ->orderBy(['schedule_id' => SORT_ASC])
                ->limit(1)
                ->one();
            if ($check && Stage::SEMI == $check->schedule_stage_id) {
                $stageArray = Schedule::find()
                    ->where([
                        'schedule_season_id' => $seasonId,
                        'schedule_stage_id' => Stage::SEMI,
                        'schedule_tournament_type_id' => TournamentType::LEAGUE,
                    ])
                    ->orderBy(['schedule_id' => SORT_ASC])
                    ->limit(2)
                    ->all();
                for ($i = 1; $i <= 2; $i++) {
                    $teamArray = ParticipantLeague::find()
                        ->where([
                            'participant_league_season_id' => $seasonId,
                            'participant_league_stage_2' => $i,
                            'participant_league_stage_id' => 0,
                        ])
                        ->orderBy(['participant_league_id' => SORT_ASC])
                        ->limit(2)
                        ->all();

                    $model = new Game();
                    $model->game_guest_team_id = $teamArray[1]->participant_league_team_id;
                    $model->game_home_team_id = $teamArray[0]->participant_league_team_id;
                    $model->game_schedule_id = $stageArray[0]->schedule_id;
                    $model->game_stadium_id = $teamArray[0]->team->team_stadium_id;
                    $model->save();

                    $model = new Game();
                    $model->game_guest_team_id = $teamArray[0]->participant_league_team_id;
                    $model->game_home_team_id = $teamArray[1]->participant_league_team_id;
                    $model->game_schedule_id = $stageArray[1]->schedule_id;
                    $model->game_stadium_id = $teamArray[1]->team->team_stadium_id;
                    $model->save();
                }
            }
        } elseif (Stage::SEMI == $schedule->schedule_stage_id) {
            $check = Schedule::find()
                ->select(['schedule_stage_id'])
                ->where(['schedule_tournament_type_id' => TournamentType::LEAGUE])
                ->andWhere(['>', 'schedule_id', $schedule->schedule_id])
                ->orderBy(['schedule_id' => SORT_ASC])
                ->limit(1)
                ->one();
            if ($check && Stage::FINAL_GAME == $check->schedule_stage_id) {
                $stageArray = Schedule::find()
                    ->where([
                        'schedule_season_id' => $seasonId,
                        'schedule_stage_id' => Stage::FINAL_GAME,
                        'schedule_tournament_type_id' => TournamentType::LEAGUE,
                    ])
                    ->orderBy(['schedule_id' => SORT_ASC])
                    ->limit(2)
                    ->all();
                $teamArray = ParticipantLeague::find()
                    ->where([
                        'participant_league_season_id' => $seasonId,
                        'participant_league_stage_1' => 1,
                        'participant_league_stage_id' => 0,
                    ])
                    ->orderBy(['participant_league_id' => SORT_ASC])
                    ->limit(2)
                    ->all();

                $model = new Game();
                $model->game_guest_team_id = $teamArray[1]->participant_league_team_id;
                $model->game_home_team_id = $teamArray[0]->participant_league_team_id;
                $model->game_schedule_id = $stageArray[0]->schedule_id;
                $model->game_stadium_id = $teamArray[0]->team->team_stadium_id;
                $model->save();

                $model = new Game();
                $model->game_guest_team_id = $teamArray[0]->participant_league_team_id;
                $model->game_home_team_id = $teamArray[1]->participant_league_team_id;
                $model->game_schedule_id = $stageArray[1]->schedule_id;
                $model->game_stadium_id = $teamArray[1]->team->team_stadium_id;
                $model->save();
            }
        }
    }

    /**
     * @param int $stageId
     * @return array
     */
    private function lot($stageId)
    {
        $teamArray = $this->prepare($stageId);
        $teamArray = $this->all($teamArray, $stageId);

        return $teamArray;
    }

    /**
     * @param int $stageId
     * @return array
     */
    private function prepare($stageId)
    {
        $seasonId = Season::getCurrentSeason();

        if (Stage::QUALIFY_2 == $stageId) {
            $participantLeagueArray = ParticipantLeague::find()
                ->joinwith(['team'])
                ->where([
                    'participant_league_season_id' => $seasonId,
                    'participant_league_stage_id' => 0,
                    'participant_league_stage_in' => [Stage::QUALIFY_1, Stage::QUALIFY_2],
                ])
                ->orderBy(['team_power_vs' => SORT_DESC])
                ->all();
        } elseif (Stage::QUALIFY_3 == $stageId) {
            $participantLeagueArray = ParticipantLeague::find()
                ->joinwith(['team'])
                ->where([
                    'participant_league_season_id' => $seasonId,
                    'participant_league_stage_id' => 0,
                    'participant_league_stage_in' => [Stage::QUALIFY_1, Stage::QUALIFY_2, Stage::QUALIFY_3],
                ])
                ->orderBy(['team_power_vs' => SORT_DESC])
                ->all();
        } else {
            $participantLeagueArray = ParticipantLeague::find()
                ->joinwith(['team'])
                ->where([
                    'participant_league_season_id' => $seasonId,
                    'participant_league_stage_id' => 0,
                ])
                ->orderBy(['team_power_vs' => SORT_DESC])
                ->limit(32)
                ->all();
        }

        $teamResultArray = [[], [], [], []];

        $countParticipantLeague = count($participantLeagueArray);
        $limitQuater = $countParticipantLeague / 4;
        $limitHalf = $countParticipantLeague / 2;
        $limitThree = $limitQuater * 3;

        for ($i = 0; $i < $countParticipantLeague; $i++) {
            if (in_array($stageId, [Stage::QUALIFY_2, Stage::QUALIFY_3])) {
                if ($i < $limitHalf) {
                    $teamResultArray[0][] = $participantLeagueArray[$i];
                } else {
                    $teamResultArray[1][] = $participantLeagueArray[$i];
                }
            } else {
                if ($i < $limitQuater) {
                    $teamResultArray[0][] = $participantLeagueArray[$i];
                } elseif ($i < $limitHalf) {
                    $teamResultArray[1][] = $participantLeagueArray[$i];
                } elseif ($i < $limitThree) {
                    $teamResultArray[2][] = $participantLeagueArray[$i];
                } else {
                    $teamResultArray[3][] = $participantLeagueArray[$i];
                }
            }
        }

        return $teamResultArray;
    }

    /**
     * @param array $teamArray
     * @param int $stageId
     * @return array
     */
    private function all(array $teamArray, $stageId)
    {
        if (in_array($stageId, [Stage::QUALIFY_2, Stage::QUALIFY_3])) {
            if (!$team_result_array = $this->one($teamArray)) {
                $team_result_array = $this->all($teamArray, $stageId);
            }
        } else {
            if (!$team_result_array = $this->group($teamArray)) {
                $team_result_array = $this->all($teamArray, $stageId);
            }
        }

        return $team_result_array;
    }

    /**
     * @param $teamArray
     * @param array $teamResultArray
     * @return array
     */
    private function one($teamArray, $teamResultArray = [])
    {
        $homeTeam = $this->teamHome($teamArray);
        $guestTeam = $this->teamGuest($teamArray, $homeTeam);

        if (!$guestTeam) {
            return [];
        }

        $teamResultArray[] = [
            'home' => $homeTeam['team_id'],
            'guest' => $guestTeam['team_id']
        ];

        unset($teamArray[0][$homeTeam['i']]);
        unset($teamArray[1][$guestTeam['i']]);

        $teamArray = array(
            array_values($teamArray[0]),
            array_values($teamArray[1]),
        );

        if (count($teamArray[0])) {
            $teamResultArray = $this->one($teamArray, $teamResultArray);
        }

        return $teamResultArray;
    }

    /**
     * @param array $teamArray
     * @return array
     */
    private function teamHome(array $teamArray)
    {
        $team = array_rand($teamArray[0]);

        return [
            'i' => $team,
            'team_id' => $teamArray[0][$team]->participant_league_team_id,
            'country_id' => $teamArray[0][$team]->team->stadium->city->city_country_id,
        ];
    }

    /**
     * @param array $teamArray
     * @param array $homeTeam
     * @return array
     */
    private function teamGuest(array $teamArray, array $homeTeam)
    {
        $shuffleArray = $teamArray[1];

        shuffle($shuffleArray);

        foreach ($shuffleArray as $item) {
            if ($item->team->stadium->city->city_country_id != $homeTeam['country_id']) {
                for ($i = 0, $countTeam = count($teamArray[1]); $i < $countTeam; $i++) {
                    if ($teamArray[1][$i]->participant_league_team_id == $item->participant_league_team_id) {
                        return [
                            'i' => $i,
                            'team_id' => $teamArray[1][$i]->participant_league_team_id,
                        ];
                    }
                }
            }
        }

        return [];
    }

    /**
     * @param $teamArray
     * @param array $teamResultArray
     * @param int $groupNumber
     * @return array
     */
    private function group($teamArray, $teamResultArray = [], $groupNumber = 1)
    {
        $team1 = $this->team1($teamArray);
        $team2 = $this->team2($teamArray, $team1);

        if (!$team2) {
            return [];
        }

        $team3 = $this->team3($teamArray, $team1, $team2);

        if (!$team3) {
            return [];
        }

        $team4 = $this->team4($teamArray, $team1, $team2, $team3);

        if (!$team4) {
            return [];
        }

        $teamResultArray[$groupNumber] = array(
            $team1['team_id'],
            $team2['team_id'],
            $team3['team_id'],
            $team4['team_id'],
        );

        unset($teamArray[0][$team1['i']]);
        unset($teamArray[1][$team2['i']]);
        unset($teamArray[2][$team3['i']]);
        unset($teamArray[3][$team4['i']]);

        $teamArray = array(
            array_values($teamArray[0]),
            array_values($teamArray[1]),
            array_values($teamArray[2]),
            array_values($teamArray[3]),
        );

        if (count($teamArray[0])) {
            $groupNumber++;
            $teamResultArray = $this->group($teamArray, $teamResultArray, $groupNumber);
        }

        return $teamResultArray;
    }

    /**
     * @param array $team_array
     * @return array
     */
    private function team1(array $team_array)
    {
        $team = array_rand($team_array[0]);

        return [
            'i' => $team,
            'team_id' => $team->participant_league_team_id,
            'country_id' => $team->team->stadium->city->city_country_id,
        ];
    }

    /**
     * @param $teamArray
     * @param $team_1
     * @return array
     */
    private function team2($teamArray, $team_1)
    {
        $shuffleArray = $teamArray[1];

        shuffle($shuffleArray);

        foreach ($shuffleArray as $item) {
            if ($item->team->stadium->city->city_country_id != $team_1['country_id']) {
                for ($i = 0, $count_team = count($teamArray[1]); $i < $count_team; $i++) {
                    if ($teamArray[1][$i]->participant_league_team_id == $item->participant_league_team_id) {
                        return [
                            'i' => $i,
                            'team_id' => $teamArray[1][$i]->participant_league_team_id,
                            'country_id' => $teamArray[1][$i]->team->stadium->city->city_country_id,
                        ];
                    }
                }
            }
        }

        return [];
    }

    /**
     * @param $teamArray
     * @param $team_1
     * @param $team_2
     * @return array
     */
    private function team3($teamArray, $team_1, $team_2)
    {
        $shuffleArray = $teamArray[1];

        shuffle($shuffleArray);

        foreach ($shuffleArray as $item) {
            if (!in_array($item['city_country_id'], [$team_1['country_id'], $team_2['country_id']])) {
                for ($i = 0, $count_team = count($teamArray[2]); $i < $count_team; $i++) {
                    if ($teamArray[2][$i]->participant_league_team_id == $item->participant_league_team_id) {
                        return [
                            'i' => $i,
                            'team_id' => $teamArray[2][$i]->participant_league_team_id,
                            'country_id' => $teamArray[2][$i]->team->stadium->city->city_country_id,
                        ];
                    }
                }
            }
        }

        return [];
    }

    /**
     * @param $teamArray
     * @param $team_1
     * @param $team_2
     * @param $team_3
     * @return array
     */
    private function team4($teamArray, $team_1, $team_2, $team_3)
    {
        $shuffleArray = $teamArray[1];

        shuffle($shuffleArray);

        foreach ($shuffleArray as $item) {
            if (!in_array($item['city_country_id'],
                [$team_1['country_id'], $team_2['country_id'], $team_3['country_id']])) {
                for ($i = 0, $count_team = count($teamArray[3]); $i < $count_team; $i++) {
                    if ($teamArray[3][$i]->participant_league_team_id == $item->participant_league_team_id) {
                        return [
                            'i' => $i,
                            'team_id' => $teamArray[3][$i]->participant_league_team_id,
                        ];
                    }
                }
            }
        }

        return [];
    }
}