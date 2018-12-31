<?php

namespace console\models\generator;

use common\models\DayType;
use common\models\Player;
use common\models\Schedule;
use Yii;
use yii\db\Expression;

/**
 * Class PlayerGameRow
 * @package console\models\generator
 */
class PlayerGameRow
{
    /**
     * @throws \yii\db\Exception
     * @return void
     */
    public function execute(): void
    {
        $this->updatePlayer();

        $schedule = Schedule::find()
            ->with(['tournamentType'])
            ->where('FROM_UNIXTIME(`schedule_date`, "%Y-%m-%d")=CURDATE()')
            ->orderBy(['schedule_id' => SORT_ASC])
            ->limit(1)
            ->one();
        if (DayType::B == $schedule->tournamentType->tournament_type_day_type_id) {
            $this->b();
        } elseif (DayType::C == $schedule->tournamentType->tournament_type_day_type_id) {
            $this->c();
        }
    }

    /**
     * @throws \yii\db\Exception
     * @return void
     */
    private function b(): void
    {
        $sql = "UPDATE `player`
                SET `player_game_row`=IF(`player_game_row`<0, `player_game_row`-1, -1)
                WHERE `player_id` NOT IN
                (
                    SELECT `lineup_player_id` 
                    FROM `lineup`
                    LEFT JOIN `game`
                    ON `lineup_game_id`=`game_id`
                    LEFT JOIN `schedule`
                    ON `game_schedule_id`=`schedule_id`
                    LEFT JOIN `tournament_type`
                    ON `schedule_tournament_type_id`
                    WHERE `game_played`=0
                    AND FROM_UNIXTIME(`schedule_date`, '%Y-%m-%d')=CURDATE()
                    AND `lineup_id` NOT IN (
                        SELECT `lineup_id`
                        FROM `lineup`
                        LEFT JOIN `game`
                        ON `lineup_game_id`=`game_id`
                        LEFT JOIN `schedule`
                        ON `game_schedule_id`=`schedule_id`
                        WHERE FROM_UNIXTIME(`schedule_date`, '%Y-%m-%d')=CURDATE()
                        AND `lineup_line_id`=1
                        AND lineup_position_id=1
                    )
                )";
        Yii::$app->db->createCommand($sql)->execute();

        $sql = "UPDATE `player`
                LEFT JOIN `lineup`
                ON `player_id`=`lineup_player_id`
                LEFT JOIN `game`
                ON `lineup_game_id`=`game_id`
                LEFT JOIN `schedule`
                ON `game_schedule_id`=`schedule_id`
                LEFT JOIN `tournament_type`
                ON `schedule_tournament_type_id`
                SET `player_game_row`=IF(`player_game_row`>0, `player_game_row`+1, 1)
                WHERE `game_played`=0
                AND FROM_UNIXTIME(`schedule_date`, '%Y-%m-%d')=CURDATE()
                AND `lineup_id` NOT IN (
                    SELECT `lineup_id`
                    FROM `lineup`
                    LEFT JOIN `game`
                    ON `lineup_game_id`=`game_id`
                    LEFT JOIN `schedule`
                    ON `game_schedule_id`=`schedule_id`
                    WHERE FROM_UNIXTIME(`schedule_date`, '%Y-%m-%d')=CURDATE()
                    AND `lineup_line_id`=1
                    AND lineup_position_id=1
                )";
        Yii::$app->db->createCommand($sql)->execute();
    }

    /**
     * @throws \yii\db\Exception
     * @return void
     */
    private function c(): void
    {
        $sql = "UPDATE `player`
                LEFT JOIN `lineup`
                ON `player_id`=`lineup_player_id`
                LEFT JOIN `game`
                ON `lineup_game_id`=`game_id`
                LEFT JOIN `schedule`
                ON `game_schedule_id`=`schedule_id`
                LEFT JOIN `tournament_type`
                ON `schedule_tournament_type_id`
                SET `player_game_row`=IF(`player_game_row`>0, `player_game_row`+1, 1)
                WHERE `game_played`=0
                AND FROM_UNIXTIME(`schedule_date`, '%Y-%m-%d')=CURDATE()
                AND `lineup_id` NOT IN (
                    SELECT `lineup_id`
                    FROM `lineup`
                    LEFT JOIN `game`
                    ON `lineup_game_id`=`game_id`
                    LEFT JOIN `schedule`
                    ON `game_schedule_id`=`schedule_id`
                    WHERE FROM_UNIXTIME(`schedule_date`, '%Y-%m-%d')=CURDATE()
                    AND `lineup_line_id`=1
                    AND lineup_position_id=1
                )";
        Yii::$app->db->createCommand($sql)->execute();
    }

    /**
     * @return void
     */
    private function updatePlayer(): void
    {
        Player::updateAll(
            ['player_game_row_old' => new Expression('player_game_row')],
            ['and', 'player_game_row_old!=player_game_row', ['<=', 'player_age', Player::AGE_READY_FOR_PENSION]]
        );
    }
}