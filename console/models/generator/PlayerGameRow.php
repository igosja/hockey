<?php

namespace console\models\generator;

use common\models\DayType;
use common\models\Player;
use common\models\Schedule;
use common\models\TournamentType;
use Yii;
use yii\db\Exception;
use yii\db\Expression;

/**
 * Class PlayerGameRow
 * @package console\models\generator
 */
class PlayerGameRow
{
    /**
     * @var int[] $scheduleIdsArray
     */
    private $scheduleIdsArray;

    /**
     * @return void
     * @throws Exception
     */
    public function execute()
    {
        $this->scheduleIdsArray = Schedule::find()
            ->select(['schedule_id'])
            ->where('FROM_UNIXTIME(`schedule_date`, "%Y-%m-%d")=CURDATE()')
            ->andWhere(['!=', 'schedule_tournament_type_id', TournamentType::OLYMPIAD])
            ->column();

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
     * @return void
     * @throws Exception
     */
    private function b()
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
                    ON `schedule_tournament_type_id`=`tournament_type_id`
                    WHERE `game_played`=0
                    AND `game_schedule_id` IN (" . implode(',', $this->scheduleIdsArray). ")
                    AND `tournament_type_day_type_id`=" . DayType::B . "
                    AND `lineup_id` NOT IN (
                        SELECT `lineup_id`
                        FROM `lineup`
                        LEFT JOIN `game`
                        ON `lineup_game_id`=`game_id`
                        WHERE `game_schedule_id` IN (" . implode(',', $this->scheduleIdsArray). ")
                        AND `lineup_line_id`=1
                        AND `lineup_position_id`=1
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
                ON `schedule_tournament_type_id`=`tournament_type_id`
                SET `player_game_row`=IF(`player_game_row`>0, `player_game_row`+1, 1)
                WHERE `game_played`=0
                AND `game_schedule_id` IN (" . implode(',', $this->scheduleIdsArray). ")
                AND `tournament_type_day_type_id`=" . DayType::B . "
                AND `lineup_id` NOT IN (
                    SELECT `lineup_id`
                    FROM `lineup`
                    LEFT JOIN `game`
                    ON `lineup_game_id`=`game_id`
                    WHERE `game_schedule_id` IN (" . implode(',', $this->scheduleIdsArray). ")
                    AND `lineup_line_id`=1
                    AND `lineup_position_id`=1
                )";
        Yii::$app->db->createCommand($sql)->execute();
    }

    /**
     * @return void
     * @throws Exception
     */
    private function c()
    {
        $sql = "UPDATE `player`
                LEFT JOIN `lineup`
                ON `player_id`=`lineup_player_id`
                LEFT JOIN `game`
                ON `lineup_game_id`=`game_id`
                SET `player_game_row`=IF(`player_game_row`>0, `player_game_row`+1, 1)
                WHERE `game_played`=0
                AND `game_schedule_id` IN (" . implode(',', $this->scheduleIdsArray). ")
                AND `lineup_id` NOT IN (
                    SELECT `lineup_id`
                    FROM `lineup`
                    LEFT JOIN `game`
                    ON `lineup_game_id`=`game_id`
                    WHERE `game_schedule_id` IN (" . implode(',', $this->scheduleIdsArray). ")
                    AND `lineup_line_id`=1
                    AND `lineup_position_id`=1
                )";
        Yii::$app->db->createCommand($sql)->execute();
    }

    /**
     * @return void
     */
    private function updatePlayer()
    {
        Player::updateAll(
            ['player_game_row_old' => new Expression('player_game_row')],
            ['and', 'player_game_row_old!=player_game_row', ['<=', 'player_age', Player::AGE_READY_FOR_PENSION]]
        );
    }
}