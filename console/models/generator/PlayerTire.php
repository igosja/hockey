<?php

namespace console\models\generator;

use common\models\DayType;
use common\models\Mood;
use common\models\Player;
use common\models\Schedule;
use common\models\Special;
use common\models\TournamentType;
use Yii;
use yii\db\Exception;

/**
 * Class PlayerTire
 * @package console\models\generator
 */
class PlayerTire
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

        $this->updateMood();

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

        $this->updatePlayer();
    }

    /**
     * @return void
     * @throws Exception
     */
    private function updateMood()
    {
        $sql = "UPDATE `player`
                LEFT JOIN `lineup`
                ON `player_id`=`lineup_player_id`
                LEFT JOIN `game`
                ON `lineup_game_id`=`game_id`
                SET `player_mood_id`=IF(`lineup_team_id`=`game_home_team_id`, `game_home_mood_id`, `game_guest_mood_id`)
                WHERE `game_schedule_id` IN (" . implode(',', $this->scheduleIdsArray). ")";
        Yii::$app->db->createCommand($sql)->execute();
    }

    /**
     * @return void
     * @throws Exception
     */
    private function b()
    {
        $sql = "UPDATE `player`
                LEFT JOIN
                (
                    SELECT `player_special_level`,
                           `player_special_player_id`
                    FROM `player_special`
                    WHERE `player_special_special_id`=" . Special::ATHLETIC . "
                ) AS `t1`
                ON `player_special_player_id`=`player_id`
                LEFT JOIN `lineup`
                ON `player_id`=`lineup_player_id`
                LEFT JOIN `game`
                ON `lineup_game_id`=`game_id`
                LEFT JOIN `schedule`
                ON `game_schedule_id`=`schedule_id`
                LEFT JOIN `tournament_type`
                ON `schedule_tournament_type_id`=`tournament_type_id`
                SET `player_tire`=`player_tire`+IF((CEIL((`player_age`-12)/11)+`player_game_row`)*(" . Mood::REST . "-`player_mood_id`)-IF(`player_special_level` IS NULL, 0, `player_special_level`)>0, (CEIL((`player_age`-12)/11)+`player_game_row`)*(" . Mood::REST . "-`player_mood_id`)-IF(`player_special_level` IS NULL, 0, `player_special_level`), 0)
                WHERE `game_schedule_id` IN (" . implode(',', $this->scheduleIdsArray). ")
                AND `player_game_row`>0
                AND `player_age`<=" . Player::AGE_READY_FOR_PENSION . "
                AND `player_mood_id`>0
                AND `player_team_id`!=0
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

        $sql = "UPDATE `player`
                LEFT JOIN `team`
                ON `player_team_id`=`team_id`
                LEFT JOIN `base_physical`
                ON `team_base_physical_id`=`base_physical_id`
                SET `player_tire`=`player_tire`-IF(`player_game_row_old`<=-2, 4, IF(`player_game_row_old`=-1, 5, IF(`player_game_row_old`=1, 15, IF(`player_game_row_old`=2, 12, IF(`player_game_row_old`=3, 10, IF(`player_game_row_old`=4, 8, IF(`player_game_row_old`=5, 6, 5)))))))+`base_physical_tire_bonus`
                WHERE `player_game_row`<0
                AND `player_id`
                NOT IN
                (
                    SELECT `lineup_player_id`
                    FROM `lineup`
                    LEFT JOIN `game`
                    ON `lineup_game_id`=`game_id`
                    LEFT JOIN `schedule`
                    ON `game_schedule_id`=`schedule_id`
                    LEFT JOIN `tournament_type`
                    ON `schedule_tournament_type_id`=`tournament_type_id`
                    WHERE `game_schedule_id` IN (" . implode(',', $this->scheduleIdsArray). ")
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
                )
                AND `player_age`<=" . Player::AGE_READY_FOR_PENSION . "
                AND `player_team_id`!=0";
        Yii::$app->db->createCommand($sql)->execute();
    }

    /**
     * @return void
     * @throws Exception
     */
    private function c()
    {
        $sql = "UPDATE `player`
                LEFT JOIN
                (
                    SELECT `player_special_level`,
                           `player_special_player_id`
                    FROM `player_special`
                    WHERE `player_special_special_id`=" . Special::ATHLETIC . "
                ) AS `t1`
                ON `player_special_player_id`=`player_id`
                LEFT JOIN `lineup`
                ON `player_id`=`lineup_player_id`
                LEFT JOIN `game`
                ON `lineup_game_id`=`game_id`
                SET `player_tire`=`player_tire`+IF((FLOOR((`player_age`-12)/11)+CEIL(`player_game_row`/2))*(" . Mood::REST . "-`player_mood_id`)-IF(`player_special_level` IS NULL, 0, `player_special_level`)>0, (FLOOR((`player_age`-12)/11)+CEIL(`player_game_row`/2))*(" . Mood::REST . "-`player_mood_id`)-IF(`player_special_level` IS NULL, 0, `player_special_level`)>0, 0)
                WHERE `game_schedule_id` IN (" . implode(',', $this->scheduleIdsArray). ")
                AND `player_game_row`>0
                AND `player_age`<40
                AND `player_mood_id`>0
                AND `player_team_id`!=0
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
        Player::updateAll(['player_mood_id' => 0], ['<=', 'player_age', Player::AGE_READY_FOR_PENSION]);
        Player::updateAll(
            ['player_tire' => Player::TIRE_MAX],
            ['and', ['<=', 'player_age', Player::AGE_READY_FOR_PENSION], ['>', 'player_tire', Player::TIRE_MAX]]
        );
        Player::updateAll(
            ['player_tire' => 0],
            ['and', ['<=', 'player_age', Player::AGE_READY_FOR_PENSION], ['<', 'player_tire', 0]]
        );
        Player::updateAll(['player_tire' => 0], ['player_team_id' => 0]);
        Player::updateAll(
            ['player_tire' => Player::TIRE_DEFAULT],
            [
                'and',
                ['!=', 'player_team_id', 0],
                ['!=', 'player_injury', 0],
                ['<', 'player_tire', Player::TIRE_DEFAULT]
            ]
        );
    }
}