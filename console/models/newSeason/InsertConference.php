<?php

namespace console\models\newSeason;

use common\models\Championship;
use common\models\Conference;
use common\models\Game;
use common\models\Schedule;
use common\models\Season;
use common\models\Stage;
use common\models\Team;
use common\models\TournamentType;
use Yii;

/**
 * Class InsertConference
 * @package console\models\newSeason
 */
class InsertConference
{
    /**
     * @throws \yii\db\Exception
     * @return void
     */
    public function execute()
    {
        $seasonId = Season::getCurrentSeason() + 1;
        $teamArray = Team::find()
            ->where(['not in', 'team_id', Championship::find()->select(['championship_team_id'])])
            ->andWhere(['!=', 'team_id', 0])
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
                Conference::tableName(),
                ['conference_season_id', 'conference_team_id'],
                $data
            )
            ->execute();

        $scheduleId = Schedule::find()
            ->select(['schedule_id'])
            ->where([
                'schedule_tournament_type_id' => TournamentType::CONFERENCE,
                'schedule_stage_id' => Stage::TOUR_1,
                'schedule_season_id' => $seasonId,
            ])
            ->limit(1)
            ->scalar();

        /** @var Conference[] $conferenceArray */
        $conferenceArray = Conference::find()
            ->with(['team'])
            ->where(['conference_season_id' => $seasonId])
            ->orderBy(['conference_team_id' => SORT_ASC])
            ->all();

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

        $data = [];
        foreach ($keyArray as $item) {
            if (!isset($conferenceArray[$item[0]]) || !isset($conferenceArray[$item[1]])) {
                continue;
            }

            $data[] = [
                $conferenceArray[$item[1]]->conference_team_id,
                $conferenceArray[$item[0]]->conference_team_id,
                $scheduleId,
                $conferenceArray[$item[0]]->team->team_stadium_id,
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
