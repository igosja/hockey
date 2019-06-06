<?php

namespace console\models\generator;

use common\models\Game;
use common\models\Schedule;
use common\models\Season;
use common\models\Swiss;
use common\models\Team;
use common\models\TournamentType;
use Yii;
use yii\db\Exception;

/**
 * Class InsertSwiss
 * @package console\models\generator
 */
class InsertSwiss
{
    /**
     * @return void
     * @throws Exception
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
     * @throws Exception
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
     * @throws Exception
     */
    private function swissPrepare($tournamentTypeId)
    {
        Yii::$app->db->createCommand()->truncateTable(Swiss::tableName())->execute();

        if (TournamentType::OFF_SEASON == $tournamentTypeId) {
            $sql = "INSERT INTO `swiss` (`swiss_guest`, `swiss_home`, `swiss_place`, `swiss_team_id`)
                    SELECT `off_season_guest`, `off_season_home`, `off_season_place`, `off_season_team_id`
                    FROM `off_season`
                    WHERE `off_season_season_id`=" . Season::getCurrentSeason() . "
                    ORDER BY `off_season_place`";
            Yii::$app->db->createCommand($sql)->execute();
        } else {
            $sql = "INSERT INTO `swiss` (`swiss_guest`, `swiss_home`, `swiss_place`, `swiss_team_id`)
                    SELECT `conference_guest`, `conference_home`, `conference_place`, `conference_team_id`
                    FROM `conference`
                    WHERE `conference_season_id`=" . Season::getCurrentSeason() . "
                    ORDER BY `conference_team_id`";
            Yii::$app->db->createCommand($sql)->execute();
        }

        $teamArray = Swiss::find()
            ->with(['team'])
            ->orderBy(['swiss_id' => SORT_ASC])
            ->all();
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

        return $teamArray;
    }

    /**
     * @param int $tournamentTypeId
     * @param int $positionDifference
     * @param Swiss[] $teamArray
     * @param int $stageId
     * @return array
     */
    private function swiss(int $tournamentTypeId, int $positionDifference, array $teamArray, int $stageId)
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
    private function swissOne(int $tournamentTypeId, int $difference, array $teamArray, array $gameArray = [])
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
        for ($k = 0; $k <= 10; $k++) {
            for ($i = 0, $countTeam = count($teamArray); $i < $countTeam; $i++) {
                if ($teamArray[$i]->swiss_home <= $teamArray[$i]->swiss_guest + $k) {
                    return [
                        'i' => $i,
                        'team_id' => $teamArray[$i]->swiss_team_id,
                        'place' => $teamArray[$i]->swiss_place,
                        'opponent' => $teamArray[$i]['opponent'],
                    ];
                }
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
    private function getSwissGuestTeam(array $teamArray, array $homeTeam, int $positionDifference)
    {
        for ($k = 0; $k <= 10; $k++) {
            for ($i = 0, $countTeam = count($teamArray); $i < $countTeam; $i++) {
                if (
                    $teamArray[$i]->swiss_home + $k >= $teamArray[$i]->swiss_guest
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
        }

        return [];
    }

    /**
     * @param Swiss[] $teamArray
     * @param int $stageId
     * @return array
     */
    private function swissConference(array $teamArray, int $stageId)
    {
        $stage = $stageId - 1;
        $countTeam = count($teamArray);

        $scheme = 1;
        if (0 == $stage % 2) {
            $scheme = 2;
        }

        $keyArray = [];

        if (1 == $scheme) {
            for ($one = 0, $two = $stage; $one < $two; $one++, $two--) {
                $keyArray[] = [$one, $two];
            }

            for ($one = $countTeam - 2, $two = $stage + 1; $one > $two + 1; $one--, $two++) {
                $keyArray[] = [$one, $two];
            }

            if ($countTeam / 2 + ($stage - 1) / 2 != $countTeam - 1) {
                $keyArray[] = [$countTeam / 2 + ($stage - 1) / 2, $countTeam - 1];
            }
        } else {
            for ($one = $stage, $two = 0; $one > $two + 1; $one--, $two++) {
                $keyArray[] = [$one, $two];
            }

            for ($one = $stage + 1, $two = $countTeam - 2; $one < $two; $one++, $two--) {
                $keyArray[] = [$one, $two];
            }

            if ($stage / 2 != $countTeam - 1) {
                $keyArray[] = [$stage / 2, $countTeam - 1];
            }
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
