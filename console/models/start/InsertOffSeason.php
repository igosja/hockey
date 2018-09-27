<?php

namespace console\models\start;

use common\components\ErrorHelper;
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
            ->all();

        foreach ($teamArray as $team) {
            $transaction = Yii::$app->db->beginTransaction();
            try {
                $model = new OffSeason();
                $model->off_season_season_id = $seasonId;
                $model->off_season_team_id = $team->team_id;
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
                'schedule_tournament_type_id' => TournamentType::OFF_SEASON,
                'schedule_stage_id' => Stage::TOUR_1,
                'schedule_season_id' => $seasonId,
            ])
            ->limit(1)
            ->scalar();

        /** @var OffSeason[] $offSeasonArray */
        $offSeasonArray = OffSeason::find()->select(['off_season_team_id'])->orderBy('RAND()')->all();
        $countOffSeason = count($offSeasonArray);

        for ($i = 0; $i < $countOffSeason; $i = $i + 2) {
            $transaction = Yii::$app->db->beginTransaction();
            try {
                $model = new Game();
                $model->game_guest_team_id = $offSeasonArray[$i]->off_season_team_id;
                $model->game_home_team_id = $offSeasonArray[$i + 1]->off_season_team_id;
                $model->game_schedule_id = $scheduleId;
                $model->game_stadium_id = $offSeasonArray[$i + 1]->team->stadium->stadium_id;
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
