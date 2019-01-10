<?php

namespace console\models\generator;

use common\models\Season;
use common\models\StatisticPlayer;
use yii\db\Expression;

/**
 * Class UpdatePlayerStatistic
 * @package console\models\generator
 */
class UpdatePlayerStatistic
{
    /**
     * @return void
     */
    public function execute()
    {
        StatisticPlayer::updateAll(
            [
                'statistic_player_pass_per_game' => new Expression('statistic_player_pass/statistic_player_game'),
                'statistic_player_save_percent' => new Expression('statistic_player_save/statistic_player_shot_gk*100'),
            ],
            ['statistic_player_season_id' => Season::getCurrentSeason(), 'statistic_player_is_gk' => 1]
        );

        StatisticPlayer::updateAll(
            [
                'statistic_player_face_off_percent' => new Expression('statistic_player_face_off_win/statistic_player_face_off*100'),
                'statistic_player_score_shot_percent' => new Expression('statistic_player_score/statistic_player_shot*100'),
                'statistic_player_shot_per_game' => new Expression('statistic_player_shot/statistic_player_game'),
            ],
            ['statistic_player_season_id' => Season::getCurrentSeason(), 'statistic_player_is_gk' => 0]
        );
    }
}