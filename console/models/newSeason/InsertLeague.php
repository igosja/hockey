<?php

namespace console\models\newSeason;

use common\models\Game;
use common\models\ParticipantLeague;
use common\models\Schedule;
use common\models\Season;
use common\models\Stage;
use common\models\TournamentType;
use Yii;
use yii\db\Exception;

/**
 * Class InsertLeague
 * @package console\models\newSeason
 */
class InsertLeague
{
    /**
     * @throws Exception
     * @return void
     */
    public function execute()
    {
        $seasonId = Season::getCurrentSeason() + 1;

        $data = [];

        $scheduleArray = Schedule::find()
            ->where([
                'schedule_season_id' => $seasonId,
                'schedule_stage_id' => Stage::QUALIFY_1,
                'schedule_tournament_type_id' => TournamentType::LEAGUE,
            ])
            ->orderBy(['schedule_id' => SORT_ASC])
            ->limit(2)
            ->all();

        $schedule_1_id = $scheduleArray[0]->schedule_id;
        $schedule_2_id = $scheduleArray[1]->schedule_id;

        $participantArray = ParticipantLeague::find()
            ->where([
                'participant_league_season_id' => $seasonId,
                'participant_league_stage_in' => Stage::QUALIFY_1,
            ])
            ->orderBy('RAND()')
            ->all();

        for ($i = 0, $countTeam = count($participantArray); $i < $countTeam; $i = $i + 2) {
            $data[] = [
                $participantArray[$i + 1]->team->team_id,
                $participantArray[$i]->team->team_id,
                $schedule_1_id,
                $participantArray[$i]->team->stadium->stadium_id,
            ];
            $data[] = [
                $participantArray[$i]->team->team_id,
                $participantArray[$i + 1]->team->team_id,
                $schedule_2_id,
                $participantArray[$i + 1]->team->stadium->stadium_id,
            ];
        }

        Yii::$app->db
            ->createCommand()
            ->batchInsert(
                Game::tableName(),
                ['game_guest_team_id', 'game_home_team_id', 'game_schedule_id', 'game_stadium_id'],
                $data
            )
            ->execute();
    }
}
