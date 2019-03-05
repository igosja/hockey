<?php

namespace console\models\generator;

use common\models\Game;
use common\models\Schedule;
use common\models\Season;
use common\models\Stage;
use common\models\Swiss;
use common\models\Team;
use common\models\TournamentType;
use Yii;

/**
 * Class InsertSwiss
 * @package console\models\generator
 */
class InsertSwiss
{
    /**
     * @throws \yii\db\Exception
     * @return void
     */
    public function execute()
    {
        $schedule = Schedule::find()
            ->where('FROM_UNIXTIME(`schedule_date`, "%Y-%m-%d")=CURDATE()')
            ->andWhere(['schedule_tournament_type_id' => [TournamentType::CONFERENCE, TournamentType::OFF_SEASON]])
            ->limit(1)
            ->one();
        if (!$schedule) {
            return;
        }

        $schedule = Schedule::find()
            ->where(['>', 'schedule_id', $schedule->schedule_id])
            ->andWhere(['schedule_tournament_type_id' => $schedule->schedule_tournament_type_id])
            ->orderBy(['schedule_id' => SORT_ASC])
            ->limit(1)
            ->one();

        if (!$schedule) {
            return;
        }

        $gameArray = $this->swissGame($schedule->schedule_tournament_type_id, $schedule->schedule_stage_id);

        $data = [];

        foreach ($gameArray as $item) {
            $data[] = [$item['guest'], $item['home'], $schedule->schedule_id];
        }

        Yii::$app->db
            ->createCommand()
            ->batchInsert(
                Game::tableName(),
                ['game_guest_team_id', 'game_home_team_id', 'game_schedule_id'],
                $data
            )
            ->execute();

        $sql = "UPDATE `game`
                LEFT JOIN `team`
                ON `game_home_team_id`=`team_id`
                SET `game_stadium_id`=`team_stadium_id`
                WHERE `game_schedule_id`=" . $schedule->schedule_id;
        Yii::$app->db->createCommand($sql)->execute();
    }

    /**
     * @param int $tournamentTypeId
     * @param int $stageId
     * @return array
     * @throws \yii\db\Exception
     */
    private function swissGame($tournamentTypeId, $stageId)
    {
        $positionDifference = 1;

        $teamArray = $this->swissPrepare($tournamentTypeId);
        $gameArray = $this->swiss($tournamentTypeId, $positionDifference, $teamArray, $stageId);

        return $gameArray;
    }

    /**
     * @param int $tournamentTypeId
     * @return Swiss[]
     * @throws \yii\db\Exception
     */
    private function swissPrepare($tournamentTypeId)
    {
        Yii::$app->db->createCommand()->truncateTable(Swiss::tableName())->execute();

        if (TournamentType::OFF_SEASON == $tournamentTypeId) {
            $sql = "INSERT INTO `swiss` (`swiss_guest`, `swiss_home`, `swiss_place`, `swiss_team_id`)
                    SELECT `off_season_guest`, `off_season_home`, `off_season_place`, `off_season_team_id`
                    FROM `off_season`
                    WHERE `off_season_season_id`=" . Season::getCurrentSeason() . "
                    ORDER BY `off_season_place` ASC";
            Yii::$app->db->createCommand($sql)->execute();
        } else {
            $sql = "INSERT INTO `swiss` (`swiss_guest`, `swiss_home`, `swiss_place`, `swiss_team_id`)
                    SELECT `conference_guest`, `conference_home`, `conference_place`, `conference_team_id`
                    FROM `conference`
                    WHERE `conference_season_id`=" . Season::getCurrentSeason() . "
                    ORDER BY `conference_team_id` ASC";
            Yii::$app->db->createCommand($sql)->execute();
        }

        $teamArray = Swiss::find()
            ->with(['team'])
            ->orderBy(['swiss_id' => SORT_ASC])
            ->all();
        if (TournamentType::OFF_SEASON == $tournamentTypeId) {
            $maxCount = 1;

            for ($i = 0, $countTeam = count($teamArray); $i < $countTeam; $i++) {
                $userTeamSubQuery = null;
                $subQuery = Game::find()
                    ->select('IF(`game_home_team_id`=' . $teamArray[$i]->swiss_team_id . ', `game_guest_team_id`, `game_home_team_id`) AS `game_home_team_id`')
                    ->joinWith(['schedule'])
                    ->where([
                        'or',
                        ['game_home_team_id' => $teamArray[$i]->swiss_team_id],
                        ['game_guest_team_id' => $teamArray[$i]->swiss_team_id]
                    ])
                    ->andWhere([
                        'schedule.schedule_tournament_type_id' => $tournamentTypeId,
                        'schedule.schedule_season_id' => Season::getCurrentSeason()
                    ])
                    ->groupBy(['game_home_team_id'])
                    ->having(['>=', 'COUNT(`game_id`)', $maxCount]);
                if ($teamArray[$i]->team->team_user_id) {
                    $userTeamSubQuery = Team::find()
                        ->select(['team_id'])
                        ->where(['team_user_id' => $teamArray[$i]->swiss_team_id]);
                }
                $free = Swiss::find()
                    ->select(['swiss_team_id'])
                    ->where(['!=', 'swiss_team_id', $teamArray[$i]->swiss_team_id])
                    ->andWhere(['not', ['swiss_team_id' => $subQuery]])
                    ->andFilterWhere(['not', ['swiss_team_id' => $userTeamSubQuery]])
                    ->orderBy(['swiss_id' => SORT_ASC])
                    ->column();

                $teamArray[$i]->opponent = $free;
            }
        }

        return $teamArray;
    }

    /**
     * @param int $tournamentTypeId
     * @param int $positionDifference
     * @param Swiss[] $teamArray
     * @param int $stageId
     * @return array
     */
    private function swiss($tournamentTypeId, $positionDifference, array $teamArray, $stageId)
    {
        if (TournamentType::OFF_SEASON == $tournamentTypeId) {
            if (!$gameArray = $this->swissOne($tournamentTypeId, $positionDifference, $teamArray)) {
                $positionDifference++;

                $gameArray = $this->swiss($tournamentTypeId, $positionDifference, $teamArray, $stageId);
            }
        } else {
            $gameArray = $this->swissConference($teamArray, $stageId);
        }

        return $gameArray;
    }

    /**
     * @param int $tournamentTypeId
     * @param int $difference
     * @param Swiss[] $teamArray
     * @param array $gameArray
     * @return array
     */
    private function swissOne($tournamentTypeId, $difference, array $teamArray, array $gameArray = [])
    {
        $homeTeam = $this->getSwissHomeTeam($teamArray);
        $guestTeam = $this->getSwissGuestTeam($teamArray, $homeTeam, $difference);

        if (!$homeTeam || !$guestTeam) {
            return [];
        }

        $gameArray[] = [
            'home' => $homeTeam['team_id'],
            'guest' => $guestTeam['team_id']
        ];

        unset($teamArray[$homeTeam['i']]);
        unset($teamArray[$guestTeam['i']]);

        $teamArray = array_values($teamArray);

        if (count($teamArray)) {
            $gameArray = $this->swissOne($tournamentTypeId, $difference, $teamArray, $gameArray);
        }

        return $gameArray;
    }

    /**
     * @param Swiss[] $teamArray
     * @return array
     */
    private function getSwissHomeTeam(array $teamArray)
    {
        for ($i = 0, $countTeam = count($teamArray); $i < $countTeam; $i++) {
            if ($teamArray[$i]->swiss_home <= $teamArray[$i]->swiss_guest) {
                return [
                    'i' => $i,
                    'team_id' => $teamArray[$i]->swiss_team_id,
                    'place' => $teamArray[$i]->swiss_place,
                    'opponent' => $teamArray[$i]['opponent'],
                ];
            }
        }

        return [];
    }

    /**
     * @param Swiss[] $teamArray
     * @param array $homeTeam
     * @param int $positionDifference
     * @return array
     */
    private function getSwissGuestTeam(array $teamArray, array $homeTeam, $positionDifference)
    {
        for ($i = 0, $countTeam = count($teamArray); $i < $countTeam; $i++) {
            if (
                $teamArray[$i]->swiss_home >= $teamArray[$i]->swiss_guest
                && $teamArray[$i]->swiss_place >= $homeTeam['place'] - $positionDifference
                && $teamArray[$i]->swiss_place <= $homeTeam['place'] + $positionDifference
                && $teamArray[$i]->swiss_team_id != $homeTeam['team_id']
                && in_array($homeTeam['team_id'], $teamArray[$i]['opponent'])
                && in_array($teamArray[$i]->swiss_team_id, $homeTeam['opponent'])
            ) {
                return [
                    'i' => $i,
                    'team_id' => $teamArray[$i]->swiss_team_id,
                ];
            }
        }

        return [];
    }

    /**
     * @param Swiss[] $teamArray
     * @param int $stageId
     * @return array
     */
    private function swissConference(array $teamArray, $stageId)
    {
        if (Stage::TOUR_1 == $stageId) {
            $keyArray = [
                [0, 1],
                [22, 2],
                [21, 3],
                [20, 4],
                [19, 5],
                [18, 6],
                [17, 7],
                [16, 8],
                [15, 9],
                [14, 10],
                [13, 11],
                [12, 23],
            ];
        } elseif (Stage::TOUR_2 == $stageId) {
            $keyArray = [
                [2, 0],
                [3, 22],
                [4, 21],
                [5, 20],
                [6, 19],
                [7, 18],
                [8, 17],
                [9, 16],
                [10, 15],
                [11, 14],
                [12, 13],
                [23, 1],
            ];
        } elseif (Stage::TOUR_3 == $stageId) {
            $keyArray = [
                [0, 3],
                [1, 2],
                [22, 4],
                [21, 5],
                [20, 6],
                [19, 7],
                [18, 8],
                [17, 9],
                [16, 10],
                [15, 11],
                [14, 12],
                [13, 23],
            ];
        } elseif (Stage::TOUR_4 == $stageId) {
            $keyArray = [
                [4, 0],
                [3, 1],
                [5, 22],
                [6, 21],
                [7, 20],
                [8, 19],
                [9, 18],
                [10, 17],
                [11, 16],
                [12, 15],
                [13, 14],
                [23, 2],
            ];
        } elseif (Stage::TOUR_5 == $stageId) {
            $keyArray = [
                [0, 5],
                [1, 4],
                [2, 3],
                [22, 6],
                [21, 7],
                [20, 8],
                [19, 9],
                [18, 10],
                [17, 11],
                [16, 12],
                [15, 13],
                [14, 23],
            ];
        } elseif (Stage::TOUR_6 == $stageId) {
            $keyArray = [
                [6, 0],
                [5, 1],
                [4, 2],
                [7, 22],
                [8, 21],
                [9, 20],
                [10, 19],
                [11, 18],
                [12, 17],
                [13, 16],
                [14, 15],
                [23, 3],
            ];
        } elseif (Stage::TOUR_7 == $stageId) {
            $keyArray = [
                [0, 7],
                [1, 6],
                [2, 5],
                [3, 4],
                [22, 8],
                [21, 9],
                [20, 10],
                [19, 11],
                [18, 12],
                [17, 13],
                [16, 14],
                [15, 23],
            ];
        } elseif (Stage::TOUR_8 == $stageId) {
            $keyArray = [
                [8, 0],
                [7, 1],
                [6, 2],
                [5, 3],
                [9, 22],
                [10, 21],
                [11, 20],
                [12, 19],
                [13, 18],
                [14, 17],
                [15, 16],
                [23, 4],
            ];
        } elseif (Stage::TOUR_9 == $stageId) {
            $keyArray = [
                [0, 9],
                [1, 8],
                [2, 7],
                [3, 6],
                [4, 5],
                [22, 10],
                [21, 11],
                [20, 12],
                [19, 13],
                [18, 14],
                [17, 15],
                [16, 23],
            ];
        } elseif (Stage::TOUR_10 == $stageId) {
            $keyArray = [
                [10, 0],
                [9, 1],
                [8, 2],
                [7, 3],
                [6, 4],
                [11, 22],
                [12, 21],
                [13, 20],
                [14, 19],
                [15, 18],
                [16, 17],
                [23, 5],
            ];
        } elseif (Stage::TOUR_11 == $stageId) {
            $keyArray = [
                [0, 11],
                [1, 10],
                [2, 9],
                [3, 8],
                [4, 7],
                [5, 6],
                [22, 12],
                [21, 13],
                [20, 14],
                [19, 15],
                [18, 16],
                [17, 23],
            ];
        } elseif (Stage::TOUR_12 == $stageId) {
            $keyArray = [
                [12, 0],
                [11, 1],
                [10, 2],
                [9, 3],
                [8, 4],
                [7, 5],
                [13, 22],
                [14, 21],
                [15, 20],
                [16, 19],
                [17, 18],
                [23, 6],
            ];
        } elseif (Stage::TOUR_13 == $stageId) {
            $keyArray = [
                [0, 13],
                [1, 12],
                [2, 11],
                [3, 10],
                [4, 9],
                [5, 8],
                [6, 7],
                [22, 14],
                [21, 15],
                [20, 16],
                [19, 17],
                [18, 23],
            ];
        } elseif (Stage::TOUR_14 == $stageId) {
            $keyArray = [
                [14, 0],
                [13, 1],
                [12, 2],
                [11, 3],
                [10, 4],
                [9, 5],
                [8, 6],
                [15, 22],
                [16, 21],
                [17, 20],
                [18, 19],
                [23, 7],
            ];
        } elseif (Stage::TOUR_15 == $stageId) {
            $keyArray = [
                [0, 15],
                [1, 14],
                [2, 13],
                [3, 12],
                [4, 11],
                [5, 10],
                [6, 9],
                [7, 8],
                [22, 16],
                [21, 17],
                [20, 18],
                [19, 23],
            ];
        } elseif (Stage::TOUR_16 == $stageId) {
            $keyArray = [
                [16, 0],
                [15, 1],
                [14, 2],
                [13, 3],
                [12, 4],
                [11, 5],
                [10, 6],
                [9, 7],
                [17, 22],
                [18, 21],
                [19, 20],
                [23, 8],
            ];
        } elseif (Stage::TOUR_17 == $stageId) {
            $keyArray = [
                [0, 17],
                [1, 16],
                [2, 15],
                [3, 14],
                [4, 13],
                [5, 12],
                [6, 11],
                [7, 10],
                [8, 9],
                [22, 18],
                [21, 19],
                [20, 23],
            ];
        } elseif (Stage::TOUR_18 == $stageId) {
            $keyArray = [
                [18, 0],
                [17, 1],
                [16, 2],
                [15, 3],
                [14, 4],
                [13, 5],
                [12, 6],
                [11, 7],
                [10, 8],
                [19, 22],
                [20, 21],
                [23, 9],
            ];
        } elseif (Stage::TOUR_19 == $stageId) {
            $keyArray = [
                [0, 19],
                [1, 18],
                [2, 17],
                [3, 16],
                [4, 15],
                [5, 14],
                [6, 13],
                [7, 12],
                [8, 11],
                [9, 10],
                [22, 20],
                [21, 23],
            ];
        } elseif (Stage::TOUR_20 == $stageId) {
            $keyArray = [
                [20, 0],
                [19, 1],
                [18, 2],
                [17, 3],
                [16, 4],
                [15, 5],
                [14, 6],
                [13, 7],
                [12, 8],
                [11, 9],
                [21, 22],
                [23, 10],
            ];
        } elseif (Stage::TOUR_21 == $stageId) {
            $keyArray = [
                [0, 21],
                [1, 20],
                [2, 19],
                [3, 18],
                [4, 17],
                [5, 16],
                [6, 15],
                [7, 14],
                [8, 13],
                [9, 12],
                [10, 11],
                [22, 23],
            ];
        } elseif (Stage::TOUR_22 == $stageId) {
            $keyArray = [
                [22, 0],
                [21, 1],
                [20, 2],
                [19, 3],
                [18, 4],
                [17, 5],
                [16, 6],
                [15, 7],
                [14, 8],
                [13, 9],
                [12, 10],
                [23, 11],
            ];
        } elseif (Stage::TOUR_23 == $stageId) {
            $keyArray = [
                [0, 23],
                [1, 22],
                [2, 21],
                [3, 20],
                [4, 19],
                [5, 18],
                [6, 17],
                [7, 16],
                [8, 15],
                [9, 14],
                [10, 13],
                [11, 12],
            ];
        } elseif (Stage::TOUR_24 == $stageId) {
            $keyArray = [
                [1, 0],
                [2, 22],
                [3, 21],
                [4, 20],
                [5, 19],
                [6, 18],
                [7, 17],
                [8, 16],
                [9, 15],
                [10, 14],
                [11, 13],
                [23, 12],
            ];
        } elseif (Stage::TOUR_25 == $stageId) {
            $keyArray = [
                [0, 2],
                [22, 3],
                [21, 4],
                [20, 5],
                [19, 6],
                [18, 7],
                [17, 8],
                [16, 9],
                [15, 10],
                [14, 11],
                [13, 12],
                [1, 23],
            ];
        } elseif (Stage::TOUR_26 == $stageId) {
            $keyArray = [
                [3, 0],
                [2, 1],
                [4, 22],
                [5, 21],
                [6, 20],
                [7, 19],
                [8, 18],
                [9, 17],
                [10, 16],
                [11, 15],
                [12, 14],
                [23, 13],
            ];
        } elseif (Stage::TOUR_27 == $stageId) {
            $keyArray = [
                [0, 4],
                [1, 3],
                [22, 5],
                [21, 6],
                [20, 7],
                [19, 8],
                [18, 9],
                [17, 10],
                [16, 11],
                [15, 12],
                [14, 13],
                [2, 23],
            ];
        } elseif (Stage::TOUR_28 == $stageId) {
            $keyArray = [
                [5, 0],
                [4, 1],
                [3, 2],
                [6, 22],
                [7, 21],
                [8, 20],
                [9, 19],
                [10, 18],
                [11, 17],
                [12, 16],
                [13, 15],
                [23, 14],
            ];
        } elseif (Stage::TOUR_29 == $stageId) {
            $keyArray = [
                [0, 6],
                [1, 5],
                [2, 4],
                [22, 7],
                [21, 8],
                [20, 9],
                [19, 10],
                [18, 11],
                [17, 12],
                [16, 13],
                [15, 14],
                [3, 23],
            ];
        } elseif (Stage::TOUR_30 == $stageId) {
            $keyArray = [
                [7, 0],
                [6, 1],
                [5, 2],
                [4, 3],
                [8, 22],
                [9, 21],
                [10, 20],
                [11, 19],
                [12, 18],
                [13, 17],
                [14, 16],
                [23, 15],
            ];
        } elseif (Stage::TOUR_31 == $stageId) {
            $keyArray = [
                [0, 8],
                [1, 7],
                [2, 6],
                [3, 5],
                [22, 9],
                [21, 10],
                [20, 11],
                [19, 12],
                [18, 13],
                [17, 14],
                [16, 15],
                [4, 23],
            ];
        } elseif (Stage::TOUR_32 == $stageId) {
            $keyArray = [
                [9, 0],
                [8, 1],
                [7, 2],
                [6, 3],
                [5, 4],
                [10, 22],
                [11, 21],
                [12, 20],
                [13, 19],
                [14, 18],
                [15, 17],
                [23, 16],
            ];
        } elseif (Stage::TOUR_33 == $stageId) {
            $keyArray = [
                [0, 10],
                [1, 9],
                [2, 8],
                [3, 7],
                [4, 6],
                [22, 11],
                [21, 12],
                [20, 13],
                [19, 14],
                [18, 15],
                [17, 16],
                [5, 23],
            ];
        } elseif (Stage::TOUR_34 == $stageId) {
            $keyArray = [
                [11, 0],
                [10, 1],
                [9, 2],
                [8, 3],
                [7, 4],
                [6, 5],
                [12, 22],
                [13, 21],
                [14, 20],
                [15, 19],
                [16, 18],
                [23, 17],
            ];
        } elseif (Stage::TOUR_35 == $stageId) {
            $keyArray = [
                [0, 12],
                [1, 11],
                [2, 10],
                [3, 9],
                [4, 8],
                [5, 7],
                [22, 13],
                [21, 14],
                [20, 15],
                [19, 16],
                [18, 17],
                [6, 23],
            ];
        } elseif (Stage::TOUR_36 == $stageId) {
            $keyArray = [
                [13, 0],
                [12, 1],
                [11, 2],
                [10, 3],
                [9, 4],
                [8, 5],
                [7, 6],
                [14, 22],
                [15, 21],
                [16, 20],
                [17, 19],
                [23, 18],
            ];
        } elseif (Stage::TOUR_37 == $stageId) {
            $keyArray = [
                [0, 14],
                [1, 13],
                [2, 12],
                [3, 11],
                [4, 10],
                [5, 9],
                [6, 8],
                [22, 15],
                [21, 16],
                [20, 17],
                [19, 18],
                [7, 23],
            ];
        } elseif (Stage::TOUR_38 == $stageId) {
            $keyArray = [
                [15, 0],
                [14, 1],
                [13, 2],
                [12, 3],
                [11, 4],
                [10, 5],
                [9, 6],
                [8, 7],
                [16, 22],
                [17, 21],
                [18, 20],
                [23, 19],
            ];
        } elseif (Stage::TOUR_39 == $stageId) {
            $keyArray = [
                [0, 16],
                [1, 15],
                [2, 14],
                [3, 13],
                [4, 12],
                [5, 11],
                [6, 10],
                [7, 9],
                [22, 17],
                [21, 18],
                [20, 19],
                [8, 23],
            ];
        } elseif (Stage::TOUR_40 == $stageId) {
            $keyArray = [
                [17, 0],
                [16, 1],
                [15, 2],
                [14, 3],
                [13, 4],
                [12, 5],
                [11, 6],
                [10, 7],
                [9, 8],
                [18, 22],
                [19, 21],
                [23, 20],
            ];
        } else {
            $keyArray = [
                [0, 18],
                [1, 17],
                [2, 16],
                [3, 15],
                [4, 14],
                [5, 13],
                [6, 12],
                [7, 11],
                [8, 10],
                [22, 19],
                [21, 20],
                [9, 23],
            ];
        }

        $gameArray = [];

        foreach ($keyArray as $item) {
            $gameArray[] = [
                'home' => $teamArray[$item[0]]->swiss_team_id,
                'guest' => $teamArray[$item[1]]->swiss_team_id,
            ];
        }

        return $gameArray;
    }
}
