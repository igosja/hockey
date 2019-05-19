<?php

namespace console\models\generator;

use common\models\Lineup;
use common\models\NationalPlayerDay;

/**
 * Class IncreaseNationalPlayerDay
 * @package console\models\generator
 */
class IncreaseNationalPlayerDay
{
    /**
     * @throws \Exception
     */
    public function execute()
    {
        $lineupArray = Lineup::find()
            ->joinWith(['game.schedule'])
            ->where(['!=', 'lineup_national_id', 0])
            ->andWhere(['!=', 'lineup_player_id', 0])
            ->andWhere('FROM_UNIXTIME(`schedule_date`, "%Y-%m-%d")=CURDATE()')
            ->orderBy(['lineup_id' => SORT_ASC])
            ->each(5);
        foreach ($lineupArray as $lineup) {
            /**
             * @var Lineup $lineup
             */
            if ($lineup->player->player_team_id) {
                $model = NationalPlayerDay::find()
                    ->where([
                        'national_player_day_national_id' => $lineup->lineup_national_id,
                        'national_player_day_player_id' => $lineup->lineup_player_id,
                        'national_player_day_team_id' => $lineup->player->player_team_id,
                    ])
                    ->limit(1)
                    ->one();
                if (!$model) {
                    $model = new NationalPlayerDay();
                    $model->national_player_day_national_id = $lineup->lineup_national_id;
                    $model->national_player_day_player_id = $lineup->lineup_player_id;
                    $model->national_player_day_team_id = $lineup->player->player_team_id;
                }

                $model->national_player_day_day = $model->national_player_day_day + 1;
                $model->save();
            }
        }
    }
}
