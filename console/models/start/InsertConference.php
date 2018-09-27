<?php

namespace console\models\start;

use common\components\ErrorHelper;
use common\models\Championship;
use common\models\Conference;
use common\models\Game;
use common\models\Schedule;
use common\models\Season;
use common\models\Stage;
use common\models\Team;
use common\models\TournamentType;
use Yii;
use yii\db\Exception;

/**
 * Class InsertConference
 * @package console\models\start
 */
class InsertConference
{
    /**
     * @throws \yii\db\Exception
     * @return void
     */
    public function execute(): void
    {
        $seasonId = Season::getCurrentSeason();
        $teamArray = Team::find()
            ->select(['team_id'])
            ->where(['not in', 'team_id', Championship::find()->select(['championship_team_id'])])
            ->andWhere(['!=', 'team_id', 0])
            ->orderBy(['team_id' => SORT_ASC])
            ->all();
        foreach ($teamArray as $team) {
            $transaction = Yii::$app->db->beginTransaction();
            try {
                $model = new Conference();
                $model->conference_season_id = $seasonId;
                $model->conference_team_id = $team->team_id;
                if (!$model->save()) {
                    throw new Exception(ErrorHelper::modelErrorsToString($model));
                }
                $transaction->commit();
            } catch (Exception $e) {
                $transaction->rollBack();
                ErrorHelper::log($e);
            }
        }

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
            ->select(['conference_team_id'])
            ->orderBy(['conference_team_id' => SORT_ASC])
            ->all();

        $key_array = [
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

        foreach ($key_array as $item) {
            $transaction = Yii::$app->db->beginTransaction();
            try {
                $model = new Game();
                $model->game_guest_team_id = $conferenceArray[$item[1]]->conference_team_id;
                $model->game_home_team_id = $conferenceArray[$item[0]]->conference_team_id;
                $model->game_schedule_id = $scheduleId;
                $model->game_stadium_id = $conferenceArray[$item[0]]->team->stadium->stadium_id;
                if (!$model->save()) {
                    throw new Exception(ErrorHelper::modelErrorsToString($model));
                }
                $transaction->commit();
            } catch (Exception $e) {
                $transaction->rollBack();
                ErrorHelper::log($e);
            }
        }
    }
}
