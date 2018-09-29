<?php

namespace console\models\start;

use common\models\Game;
use common\models\OffSeason;
use common\models\Schedule;
use common\models\Season;
use common\models\Stage;
use common\models\Team;
use common\models\TournamentType;
use Yii;
use yii\db\Exception;

/**
 * Class InsertOffSeason
 * @package console\models\start
 */
class InsertOffSeason
{
    /**
     * @throws Exception
     * @return void
     */
    public function execute(): void
    {
        $seasonId = Season::getCurrentSeason();

        $teamArray = Team::find()
            ->select(['team_id'])
            ->where(['!=', 'team_id', 0])
            ->orderBy(['team_id' => SORT_ASC])
            ->each();

        $data = [];
        foreach ($teamArray as $team) {
            /**
             * @var Team $team
             */
            $data[] = [$seasonId, $team->team_id];
        }

        Yii::$app->db
            ->createCommand()
            ->batchInsert(
                OffSeason::tableName(),
                ['off_season_season_id', 'off_season_team_id'],
                $data
            )
            ->execute();

        $scheduleId = Schedule::find()
            ->select(['schedule_id'])
            ->where([
                'schedule_tournament_type_id' => TournamentType::OFF_SEASON,
                'schedule_stage_id' => Stage::TOUR_1,
                'schedule_season_id' => $seasonId,
            ])
            ->limit(1)
            ->scalar();

        /** @var OffSeason[] $offSeasonArray */
        $offSeasonArray = OffSeason::find()
            ->with(['team.stadium'])
            ->where(['off_season_season_id' => $seasonId])
            ->orderBy('RAND()')
            ->all();
        $countOffSeason = count($offSeasonArray);

        $data = [];
        for ($i = 0; $i < $countOffSeason; $i = $i + 2) {
            $data[] = [
                $offSeasonArray[$i]->off_season_team_id,
                $offSeasonArray[$i + 1]->off_season_team_id,
                $scheduleId,
                $offSeasonArray[$i + 1]->team->team_stadium_id
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
