<?php

namespace console\models\generator;

use common\models\Game;
use common\models\League;
use common\models\ParticipantLeague;
use common\models\Schedule;
use common\models\Season;
use common\models\Stage;
use common\models\TournamentType;

/**
 * Class LeagueLot
 * @package console\models\generator
 */
class LeagueLot
{
    /**
     * @return void
     */
    public function execute(): void
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
                $team_array = f_igosja_league_lot(STAGE_2_QUALIFY);

                $sql = "SELECT `schedule_id`
                        FROM `schedule`
                        WHERE `schedule_season_id`=$igosja_season_id
                        AND `schedule_stage_id`=" . STAGE_2_QUALIFY . "
                        AND `schedule_tournamenttype_id`=" . TOURNAMENTTYPE_LEAGUE . "
                        ORDER BY `schedule_id` ASC
                        LIMIT 2";
                $stage_sql = f_igosja_mysqli_query($sql);

                $stage_array = $stage_sql->fetch_all(MYSQLI_ASSOC);

                $schedule_1 = $stage_array[0]['schedule_id'];
                $schedule_2 = $stage_array[1]['schedule_id'];

                $values = array();

                foreach ($team_array as $item) {
                    $values[] = '(' . $item['guest'] . ', ' . $item['home'] . ', ' . $schedule_1 . ')';
                    $values[] = '(' . $item['home'] . ', ' . $item['guest'] . ', ' . $schedule_2 . ')';
                }

                $values = implode(',', $values);

                $sql = "INSERT INTO `game` (`game_guest_team_id`, `game_home_team_id`, `game_schedule_id`)
                        VALUES $values;";
                f_igosja_mysqli_query($sql);

                $sql = "UPDATE `game`
                        LEFT JOIN `team`
                        ON `game_home_team_id`=`team_id`
                        SET `game_stadium_id`=`team_stadium_id`
                        WHERE `game_schedule_id` IN ($schedule_1, $schedule_2)";
                f_igosja_mysqli_query($sql);
            }
        } elseif (TOURNAMENTTYPE_LEAGUE == $item['schedule_tournamenttype_id'] && STAGE_2_QUALIFY == $item['schedule_stage_id']) {
            $sql = "SELECT `schedule_stage_id`
                    FROM `schedule`
                    WHERE `schedule_tournamenttype_id`=" . TOURNAMENTTYPE_LEAGUE . "
                    AND `schedule_id`>$schedule_id
                    ORDER BY `schedule_id` ASC
                    LIMIT 1";
            $check_sql = f_igosja_mysqli_query($sql);

            $check_array = $check_sql->fetch_all(MYSQLI_ASSOC);

            if (STAGE_3_QUALIFY == $check_array[0]['schedule_stage_id']) {
                $team_array = f_igosja_league_lot(STAGE_3_QUALIFY);

                $sql = "SELECT `schedule_id`
                        FROM `schedule`
                        WHERE `schedule_season_id`=$igosja_season_id
                        AND `schedule_stage_id`=" . STAGE_3_QUALIFY . "
                        AND `schedule_tournamenttype_id`=" . TOURNAMENTTYPE_LEAGUE . "
                        ORDER BY `schedule_id` ASC
                        LIMIT 2";
                $stage_sql = f_igosja_mysqli_query($sql);

                $stage_array = $stage_sql->fetch_all(MYSQLI_ASSOC);

                $schedule_1 = $stage_array[0]['schedule_id'];
                $schedule_2 = $stage_array[1]['schedule_id'];

                $values = array();

                foreach ($team_array as $item) {
                    $values[] = '(' . $item['guest'] . ', ' . $item['home'] . ', ' . $schedule_1 . ')';
                    $values[] = '(' . $item['home'] . ', ' . $item['guest'] . ', ' . $schedule_2 . ')';
                }

                $values = implode(',', $values);

                $sql = "INSERT INTO `game` (`game_guest_team_id`, `game_home_team_id`, `game_schedule_id`)
                        VALUES $values;";
                f_igosja_mysqli_query($sql);

                $sql = "UPDATE `game`
                        LEFT JOIN `team`
                        ON `game_home_team_id`=`team_id`
                        SET `game_stadium_id`=`team_stadium_id`
                        WHERE `game_schedule_id` IN ($schedule_1, $schedule_2)";
                f_igosja_mysqli_query($sql);
            }
        } elseif (TOURNAMENTTYPE_LEAGUE == $item['schedule_tournamenttype_id'] && STAGE_3_QUALIFY == $item['schedule_stage_id']) {
            $sql = "SELECT `schedule_stage_id`
                    FROM `schedule`
                    WHERE `schedule_tournamenttype_id`=" . TOURNAMENTTYPE_LEAGUE . "
                    AND `schedule_id`>$schedule_id
                    ORDER BY `schedule_id` ASC
                    LIMIT 1";
            $check_sql = f_igosja_mysqli_query($sql);

            $check_array = $check_sql->fetch_all(MYSQLI_ASSOC);

            if (STAGE_1_TOUR == $check_array[0]['schedule_stage_id']) {
                $team_array = f_igosja_league_lot(STAGE_1_TOUR);

                $values = array();

                foreach ($team_array as $group => $team) {
                    foreach ($team as $place => $item) {
                        $values[] = '(' . $igosja_season_id . ', ' . $item . ', ' . $group . ', ' . ($place + 1) . ')';
                    }
                }

                $values = implode(',', $values);

                $sql = "INSERT INTO `league` (`league_season_id`, `league_team_id`, `league_group`, `league_place`)
                        VALUES $values;";
                f_igosja_mysqli_query($sql);

                $sql = "SELECT `schedule_id`
                        FROM `schedule`
                        WHERE `schedule_season_id`=$igosja_season_id
                        AND `schedule_stage_id`<=" . STAGE_6_TOUR . "
                        AND `schedule_tournamenttype_id`=" . TOURNAMENTTYPE_LEAGUE . "
                        ORDER BY `schedule_id` ASC
                        LIMIT 6";
                $stage_sql = f_igosja_mysqli_query($sql);

                $stage_array = $stage_sql->fetch_all(MYSQLI_ASSOC);

                $schedule_id_1 = $stage_array[0]['schedule_id'];
                $schedule_id_2 = $stage_array[1]['schedule_id'];
                $schedule_id_3 = $stage_array[2]['schedule_id'];
                $schedule_id_4 = $stage_array[3]['schedule_id'];
                $schedule_id_5 = $stage_array[4]['schedule_id'];
                $schedule_id_6 = $stage_array[5]['schedule_id'];

                $sql = "SELECT `league_group`
                        FROM `league`
                        WHERE `league_season_id`=$igosja_season_id
                        GROUP BY `league_group`
                        ORDER BY `league_group` ASC";
                $group_sql = f_igosja_mysqli_query($sql);

                $group_array = $group_sql->fetch_all(MYSQLI_ASSOC);

                foreach ($group_array as $group) {
                    $group_id = $group['league_group'];

                    $sql = "SELECT `team_id`,
                                   `stadium_id`
                            FROM `league`
                            LEFT JOIN `team`
                            ON `league_team_id`=`team_id`
                            LEFT JOIN `stadium`
                            ON `team_stadium_id`=`stadium_id`
                            WHERE `league_season_id`=$igosja_season_id
                            AND `league_group`=$group_id
                            ORDER BY RAND()";
                    $team_sql = f_igosja_mysqli_query($sql);

                    $team_array = $team_sql->fetch_all(MYSQLI_ASSOC);

                    $team_id_1 = $team_array[0]['team_id'];
                    $team_id_2 = $team_array[1]['team_id'];
                    $team_id_3 = $team_array[2]['team_id'];
                    $team_id_4 = $team_array[3]['team_id'];

                    $stadium_id_1 = $team_array[0]['stadium_id'];
                    $stadium_id_2 = $team_array[1]['stadium_id'];
                    $stadium_id_3 = $team_array[2]['stadium_id'];
                    $stadium_id_4 = $team_array[3]['stadium_id'];

                    $sql = "INSERT INTO `game` (`game_home_team_id`, `game_guest_team_id`, `game_schedule_id`, `game_stadium_id`)
                            VALUES ($team_id_2, $team_id_1, $schedule_id_1, $stadium_id_2),
                                   ($team_id_4, $team_id_3, $schedule_id_1, $stadium_id_4),
                                   ($team_id_1, $team_id_3, $schedule_id_2, $stadium_id_1),
                                   ($team_id_2, $team_id_4, $schedule_id_2, $stadium_id_2),
                                   ($team_id_3, $team_id_2, $schedule_id_3, $stadium_id_3),
                                   ($team_id_4, $team_id_1, $schedule_id_3, $stadium_id_4),
                                   ($team_id_1, $team_id_2, $schedule_id_4, $stadium_id_1),
                                   ($team_id_3, $team_id_4, $schedule_id_4, $stadium_id_3),
                                   ($team_id_3, $team_id_1, $schedule_id_5, $stadium_id_3),
                                   ($team_id_4, $team_id_2, $schedule_id_5, $stadium_id_4),
                                   ($team_id_2, $team_id_3, $schedule_id_6, $stadium_id_2),
                                   ($team_id_1, $team_id_4, $schedule_id_6, $stadium_id_1);";
                    f_igosja_mysqli_query($sql);
                }
            }
        } elseif (TOURNAMENTTYPE_LEAGUE == $item['schedule_tournamenttype_id'] && STAGE_6_TOUR == $item['schedule_stage_id']) {
            $sql = "SELECT `schedule_id`
                    FROM `schedule`
                    WHERE `schedule_season_id`=$igosja_season_id
                    AND `schedule_stage_id`=" . STAGE_1_8_FINAL . "
                    AND `schedule_tournamenttype_id`=" . TOURNAMENTTYPE_LEAGUE . "
                    ORDER BY `schedule_id` ASC
                    LIMIT 2";
            $stage_sql = f_igosja_mysqli_query($sql);

            $stage_array = $stage_sql->fetch_all(MYSQLI_ASSOC);

            $schedule_1 = $stage_array[0]['schedule_id'];
            $schedule_2 = $stage_array[1]['schedule_id'];

            for ($i = 1; $i <= 8; $i++) {
                $sql = "SELECT `team_id`,
                               `team_stadium_id`
                        FROM `participantleague`
                        LEFT JOIN `team`
                        ON `participantleague_team_id`=`team_id`
                        WHERE `participantleague_season_id`=$igosja_season_id
                        AND `participantleague_stage_8`=$i
                        AND `participantleague_stage_id`=0
                        ORDER BY `participantleague_id` ASC
                        LIMIT 2";
                $team_sql = f_igosja_mysqli_query($sql);

                $team_array = $team_sql->fetch_all(MYSQLI_ASSOC);

                $team_1 = $team_array[0]['team_id'];
                $stadium_1 = $team_array[0]['team_stadium_id'];
                $team_2 = $team_array[1]['team_id'];
                $stadium_2 = $team_array[1]['team_stadium_id'];

                $sql = "INSERT INTO `game` (`game_guest_team_id`, `game_home_team_id`, `game_schedule_id`, `game_stadium_id`)
                        VALUES ($team_2, $team_1, $schedule_1, $stadium_1),
                               ($team_1, $team_2, $schedule_2, $stadium_2);";
                f_igosja_mysqli_query($sql);
            }
        } elseif (TOURNAMENTTYPE_LEAGUE == $item['schedule_tournamenttype_id'] && STAGE_1_8_FINAL == $item['schedule_stage_id']) {
            $sql = "SELECT `schedule_stage_id`
                    FROM `schedule`
                    WHERE `schedule_tournamenttype_id`=" . TOURNAMENTTYPE_LEAGUE . "
                    AND `schedule_id`>$schedule_id
                    ORDER BY `schedule_id` ASC
                    LIMIT 1";
            $check_sql = f_igosja_mysqli_query($sql);

            $check_array = $check_sql->fetch_all(MYSQLI_ASSOC);

            if (STAGE_QUATER == $check_array[0]['schedule_stage_id']) {
                $sql = "SELECT `schedule_id`
                        FROM `schedule`
                        WHERE `schedule_season_id`=$igosja_season_id
                        AND `schedule_stage_id`=" . STAGE_QUATER . "
                        AND `schedule_tournamenttype_id`=" . TOURNAMENTTYPE_LEAGUE . "
                        ORDER BY `schedule_id` ASC
                        LIMIT 2";
                $stage_sql = f_igosja_mysqli_query($sql);

                $stage_array = $stage_sql->fetch_all(MYSQLI_ASSOC);

                $schedule_1 = $stage_array[0]['schedule_id'];
                $schedule_2 = $stage_array[1]['schedule_id'];

                for ($i = 1; $i <= 4; $i++) {
                    $sql = "SELECT `team_id`,
                                   `team_stadium_id`
                            FROM `participantleague`
                            LEFT JOIN `team`
                            ON `participantleague_team_id`=`team_id`
                            WHERE `participantleague_season_id`=$igosja_season_id
                            AND `participantleague_stage_4`=$i
                            AND `participantleague_stage_id`=0
                            ORDER BY `participantleague_id` ASC
                            LIMIT 2";
                    $team_sql = f_igosja_mysqli_query($sql);

                    $team_array = $team_sql->fetch_all(MYSQLI_ASSOC);

                    $team_1 = $team_array[0]['team_id'];
                    $stadium_1 = $team_array[0]['team_stadium_id'];
                    $team_2 = $team_array[1]['team_id'];
                    $stadium_2 = $team_array[1]['team_stadium_id'];

                    $sql = "INSERT INTO `game` (`game_guest_team_id`, `game_home_team_id`, `game_schedule_id`, `game_stadium_id`)
                            VALUES ($team_2, $team_1, $schedule_1, $stadium_1),
                                   ($team_1, $team_2, $schedule_2, $stadium_2);";
                    f_igosja_mysqli_query($sql);
                }
            }
        } elseif (TOURNAMENTTYPE_LEAGUE == $item['schedule_tournamenttype_id'] && STAGE_QUATER == $item['schedule_stage_id']) {
            $sql = "SELECT `schedule_stage_id`
                    FROM `schedule`
                    WHERE `schedule_tournamenttype_id`=" . TOURNAMENTTYPE_LEAGUE . "
                    AND `schedule_id`>$schedule_id
                    ORDER BY `schedule_id` ASC
                    LIMIT 1";
            $check_sql = f_igosja_mysqli_query($sql);

            $check_array = $check_sql->fetch_all(MYSQLI_ASSOC);

            if (STAGE_SEMI == $check_array[0]['schedule_stage_id']) {
                $sql = "SELECT `schedule_id`
                        FROM `schedule`
                        WHERE `schedule_season_id`=$igosja_season_id
                        AND `schedule_stage_id`=" . STAGE_SEMI . "
                        AND `schedule_tournamenttype_id`=" . TOURNAMENTTYPE_LEAGUE . "
                        ORDER BY `schedule_id` ASC
                        LIMIT 2";
                $stage_sql = f_igosja_mysqli_query($sql);

                $stage_array = $stage_sql->fetch_all(MYSQLI_ASSOC);

                $schedule_1 = $stage_array[0]['schedule_id'];
                $schedule_2 = $stage_array[1]['schedule_id'];

                for ($i = 1; $i <= 2; $i++) {
                    $sql = "SELECT `team_id`,
                                   `team_stadium_id`
                            FROM `participantleague`
                            LEFT JOIN `team`
                            ON `participantleague_team_id`=`team_id`
                            WHERE `participantleague_season_id`=$igosja_season_id
                            AND `participantleague_stage_2`=$i
                            AND `participantleague_stage_id`=0
                            ORDER BY `participantleague_id` ASC
                            LIMIT 2";
                    $team_sql = f_igosja_mysqli_query($sql);

                    $team_array = $team_sql->fetch_all(MYSQLI_ASSOC);

                    $team_1 = $team_array[0]['team_id'];
                    $stadium_1 = $team_array[0]['team_stadium_id'];
                    $team_2 = $team_array[1]['team_id'];
                    $stadium_2 = $team_array[1]['team_stadium_id'];

                    $sql = "INSERT INTO `game` (`game_guest_team_id`, `game_home_team_id`, `game_schedule_id`, `game_stadium_id`)
                            VALUES ($team_2, $team_1, $schedule_1, $stadium_1),
                                   ($team_1, $team_2, $schedule_2, $stadium_2);";
                    f_igosja_mysqli_query($sql);
                }
            }
        } elseif (TOURNAMENTTYPE_LEAGUE == $item['schedule_tournamenttype_id'] && STAGE_SEMI == $item['schedule_stage_id']) {
            $sql = "SELECT `schedule_stage_id`
                    FROM `schedule`
                    WHERE `schedule_tournamenttype_id`=" . TOURNAMENTTYPE_LEAGUE . "
                    AND `schedule_id`>$schedule_id
                    ORDER BY `schedule_id` ASC
                    LIMIT 1";
            $check_sql = f_igosja_mysqli_query($sql);

            $check_array = $check_sql->fetch_all(MYSQLI_ASSOC);

            if (STAGE_FINAL == $check_array[0]['schedule_stage_id']) {
                $sql = "SELECT `schedule_id`
                        FROM `schedule`
                        WHERE `schedule_season_id`=$igosja_season_id
                        AND `schedule_stage_id`=" . STAGE_FINAL . "
                        AND `schedule_tournamenttype_id`=" . TOURNAMENTTYPE_LEAGUE . "
                        ORDER BY `schedule_id` ASC
                        LIMIT 2";
                $stage_sql = f_igosja_mysqli_query($sql);

                $stage_array = $stage_sql->fetch_all(MYSQLI_ASSOC);

                $schedule_1 = $stage_array[0]['schedule_id'];
                $schedule_2 = $stage_array[1]['schedule_id'];

                $sql = "SELECT `team_id`,
                               `team_stadium_id`
                        FROM `participantleague`
                        LEFT JOIN `team`
                        ON `participantleague_team_id`=`team_id`
                        WHERE `participantleague_season_id`=$igosja_season_id
                        AND `participantleague_stage_1`=1
                        AND `participantleague_stage_id`=0
                        ORDER BY `participantleague_id` ASC
                        LIMIT 2";
                $team_sql = f_igosja_mysqli_query($sql);

                $team_array = $team_sql->fetch_all(MYSQLI_ASSOC);

                $team_1 = $team_array[0]['team_id'];
                $stadium_1 = $team_array[0]['team_stadium_id'];
                $team_2 = $team_array[1]['team_id'];
                $stadium_2 = $team_array[1]['team_stadium_id'];

                $sql = "INSERT INTO `game` (`game_guest_team_id`, `game_home_team_id`, `game_schedule_id`, `game_stadium_id`)
                        VALUES ($team_2, $team_1, $schedule_1, $stadium_1),
                               ($team_1, $team_2, $schedule_2, $stadium_2);";
                f_igosja_mysqli_query($sql);
            }
        }
    }

    /**
     * @param int $stageId
     * @return array
     */
    private function lot(int $stageId): array
    {
        $teamArray = $this->prepare($stageId);
        $teamArray = $this->all($teamArray, $stageId);

        return $teamArray;
    }

    /**
     * @param int $stageId
     * @return array
     */
    private function prepare(int $stageId): array
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
    private function all(array $teamArray, int $stageId): array
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
     * @return array|bool
     */
    private function one($teamArray, $teamResultArray = [])
    {
        $homeTeam = $this->teamHome($teamArray);
        $guestTeam = $this->teamGuest($teamArray, $homeTeam);

        if (!$guestTeam) {
            return false;
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
    private function teamHome(array $teamArray): array
    {
        $team = array_rand($teamArray[0]);

        return [
            'i' => $team,
            'team_id' => $team->participant_league_team_id,
            'country_id' => $team->team->stadium->city->city_country_id,
        ];
    }

    /**
     * @param array $teamArray
     * @param array $homeTeam
     * @return array|bool
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

    private function team1(array $team_array): array
    {
        $team = array_rand($team_array[0]);

        return [
            'i' => $team,
            'team_id' => $team->participant_league_team_id,
            'country_id' => $team->team->stadium->city->city_country_id,
        ];
    }

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

    private function team4($teamArray, $team_1, $team_2, $team_3)
    {
        $shuffleArray = $teamArray[1];

        shuffle($shuffleArray);

        foreach ($shuffleArray as $item) {
            if (!in_array($item['city_country_id'], [$team_1['country_id'], $team_2['country_id'], $team_3['country_id']])) {
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