<?php

namespace console\models\start;

use common\components\ErrorHelper;
use common\models\Schedule;
use common\models\Season;
use common\models\Stage;
use common\models\TournamentType;
use Yii;
use yii\db\Exception;

/**
 * Class InsertSchedule
 * @package console\models\start
 */
class InsertSchedule
{
    /**
     * @throws \yii\db\Exception
     * @return void
     */
    public function execute(): void
    {
        $seasonId = Season::getCurrentSeason();
        $scheduleFriendlyArray = [6, 13, 20, 27, 34, 41, 48, 55, 61, 62];
        $scheduleOffSeasonArray = [0, 1, 2, 3, 4, 5, 7, 8, 9, 10, 11, 12];
        $scheduleStageArray = [
            Stage::TOUR_1,
            Stage::TOUR_2,
            Stage::TOUR_3,
            Stage::TOUR_4,
            Stage::TOUR_5,
            Stage::TOUR_6,
            Stage::FRIENDLY,
            Stage::TOUR_7,
            Stage::TOUR_8,
            Stage::TOUR_9,
            Stage::TOUR_10,
            Stage::TOUR_11,
            Stage::TOUR_12,
            Stage::FRIENDLY,
            Stage::TOUR_1,
            Stage::TOUR_2,
            Stage::TOUR_3,
            Stage::TOUR_4,
            Stage::TOUR_5,
            Stage::TOUR_6,
            Stage::FRIENDLY,
            Stage::TOUR_7,
            Stage::TOUR_8,
            Stage::TOUR_9,
            Stage::TOUR_10,
            Stage::TOUR_11,
            Stage::TOUR_12,
            Stage::FRIENDLY,
            Stage::TOUR_13,
            Stage::TOUR_14,
            Stage::TOUR_15,
            Stage::TOUR_16,
            Stage::TOUR_17,
            Stage::TOUR_18,
            Stage::FRIENDLY,
            Stage::TOUR_19,
            Stage::TOUR_20,
            Stage::TOUR_21,
            Stage::TOUR_22,
            Stage::TOUR_23,
            Stage::TOUR_24,
            Stage::FRIENDLY,
            Stage::TOUR_25,
            Stage::TOUR_26,
            Stage::TOUR_27,
            Stage::TOUR_28,
            Stage::TOUR_29,
            Stage::TOUR_30,
            Stage::FRIENDLY,
            Stage::QUARTER,
            Stage::QUARTER,
            Stage::QUARTER,
            Stage::SEMI,
            Stage::SEMI,
            Stage::SEMI,
            Stage::FRIENDLY,
            Stage::FINAL,
            Stage::FINAL,
            Stage::FINAL,
            Stage::FINAL,
            Stage::FINAL,
            Stage::FRIENDLY,
            Stage::FRIENDLY,
        ];
        $scheduleConferenceStageArray = [
            Stage::TOUR_1,
            Stage::TOUR_2,
            Stage::TOUR_3,
            Stage::TOUR_4,
            Stage::TOUR_5,
            Stage::TOUR_6,
            Stage::FRIENDLY,
            Stage::TOUR_7,
            Stage::TOUR_8,
            Stage::TOUR_9,
            Stage::TOUR_10,
            Stage::TOUR_11,
            Stage::TOUR_12,
            Stage::FRIENDLY,
            Stage::TOUR_1,
            Stage::TOUR_2,
            Stage::TOUR_3,
            Stage::TOUR_4,
            Stage::TOUR_5,
            Stage::TOUR_6,
            Stage::FRIENDLY,
            Stage::TOUR_7,
            Stage::TOUR_8,
            Stage::TOUR_9,
            Stage::TOUR_10,
            Stage::TOUR_11,
            Stage::TOUR_12,
            Stage::FRIENDLY,
            Stage::TOUR_13,
            Stage::TOUR_14,
            Stage::TOUR_15,
            Stage::TOUR_16,
            Stage::TOUR_17,
            Stage::TOUR_18,
            Stage::FRIENDLY,
            Stage::TOUR_19,
            Stage::TOUR_20,
            Stage::TOUR_21,
            Stage::TOUR_22,
            Stage::TOUR_23,
            Stage::TOUR_24,
            Stage::FRIENDLY,
            Stage::TOUR_25,
            Stage::TOUR_26,
            Stage::TOUR_27,
            Stage::TOUR_28,
            Stage::TOUR_29,
            Stage::TOUR_30,
            Stage::FRIENDLY,
            Stage::TOUR_31,
            Stage::TOUR_32,
            Stage::TOUR_33,
            Stage::TOUR_34,
            Stage::TOUR_35,
            Stage::TOUR_36,
            Stage::FRIENDLY,
            Stage::TOUR_37,
            Stage::TOUR_38,
            Stage::TOUR_39,
            Stage::TOUR_40,
            Stage::TOUR_41,
            Stage::FRIENDLY,
            Stage::FRIENDLY,
        ];

        $startDate = strtotime('Mon') + 12 * 60 * 60;

        for ($i = 0; $i < 63; $i++) {
            $date = $startDate + $i * 24 * 60 * 60;
            $conference = 0;

            if (in_array($i, $scheduleFriendlyArray)) {
                $tournament_type = TournamentType::FRIENDLY;
            } elseif (in_array($i, $scheduleOffSeasonArray)) {
                $tournament_type = TournamentType::OFF_SEASON;
            } else {
                $conference = true;
                $tournament_type = TournamentType::CHAMPIONSHIP;
            }

            $transaction = Yii::$app->db->beginTransaction();
            try {
                $model = new Schedule();
                $model->schedule_date = $date;
                $model->schedule_season_id = $seasonId;
                $model->schedule_stage_id = $scheduleStageArray[$i];
                $model->schedule_tournament_type_id = $tournament_type;
                if (!$model->save()) {
                    throw new Exception(ErrorHelper::modelErrorsToString($model));
                }
                $transaction->commit();
            } catch (Exception $e) {
                $transaction->rollBack();
                ErrorHelper::log($e);
            }

            if ($conference) {
                $transaction = Yii::$app->db->beginTransaction();
                try {
                    $model = new Schedule();
                    $model->schedule_date = $date;
                    $model->schedule_season_id = $seasonId;
                    $model->schedule_stage_id = $scheduleConferenceStageArray[$i];
                    $model->schedule_tournament_type_id = TournamentType::CONFERENCE;
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
}
