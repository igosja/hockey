<?php

namespace console\models\generator;

use common\models\DayType;
use common\models\Mood;
use common\models\Player;
use common\models\Schedule;
use common\models\Special;
use Yii;

/**
 * Class PlayerTire
 * @package console\models\generator
 */
class PlayerTire
{
    /**
     * @throws \yii\db\Exception
     * @return void
     */
    public function execute(): void
    {
        $this->updateMood();

        $schedule = Schedule::find()
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
     * @throws \yii\db\Exception
     * @return void
     */
    private function updateMood(): void
    {
        $sql = "UPDATE `player`
                LEFT JOIN `lineup`
                ON `player_id`=`lineup_player_id`
                LEFT JOIN `game`
                ON `lineup_game_id`=`game_id`
                LEFT JOIN `schedule`
                ON `game_schedule_id`=`schedule_id`
                SET `player_mood_id`=IF(`lineup_team_id`=`game_home_team_id`, `game_home_mood_id`, `game_guest_mood_id`)
                WHERE FROM_UNIXTIME(`schedule_date`, '%Y-%m-%d')=CURDATE()";
        Yii::$app->db->createCommand($sql)->execute();
    }

    /**
     * @throws \yii\db\Exception
     * @return void
     */
    private function b(): void
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
                SET `player_tire`=`player_tire`+IF((CEIL((`player_age`-12)/11)+`player_game_row`)*(" . Mood::REST . "-`player_mood_id`)-IF(`player_special_level` IS NULL, 0, `player_special_level`)>0, (CEIL((`player_age`-12)/11)+`player_game_row`)*(" . Mood::REST . "-`player_mood_id`)-IF(`player_special_level` IS NULL, 0, `player_special_level`), 0)
                WHERE FROM_UNIXTIME(`schedule_date`, '%Y-%m-%d')=CURDATE()
                AND `player_game_row`>0
                AND `player_age`<=" . Player::AGE_READY_FOR_PENSION . "
                AND `player_mood_id`>0
                AND `player_team_id`!=0";
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
                    WHERE FROM_UNIXTIME(`schedule_date`, '%Y-%m-%d')=CURDATE()
                )
                AND `player_age`<=" . Player::AGE_READY_FOR_PENSION . "
                AND `player_team_id`!=0";
        Yii::$app->db->createCommand($sql)->execute();
    }

    /**
     * @throws \yii\db\Exception
     * @return void
     */
    private function c(): void
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
                SET `player_tire`=`player_tire`+IF((FLOOR((`player_age`-12)/11)+CEIL(`player_game_row`/2))*(" . Mood::REST . "-`player_mood_id`)-IF(`player_special_level` IS NULL, 0, `player_special_level`)>0, (FLOOR((`player_age`-12)/11)+CEIL(`player_game_row`/2))*(" . Mood::REST . "-`player_mood_id`)-IF(`player_special_level` IS NULL, 0, `player_special_level`)>0, 0)
                WHERE FROM_UNIXTIME(`schedule_date`, '%Y-%m-%d')=CURDATE()
                AND `player_game_row`>0
                AND `player_age`<40
                AND `player_mood_id`>0
                AND `player_team_id`!=0";
        Yii::$app->db->createCommand($sql)->execute();
    }

    /**
     * @throws \yii\db\Exception
     * @return void
     */
    private function updatePlayer(): void
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
        Player::updateAll(['player_tire' => Player::TIRE_DEFAULT], ['player_team_id' => 0]);
        Player::updateAll(
            ['player_tire' => Player::TIRE_DEFAULT],
            [
                'and',
                ['!=', 'player_team_id', 0],
                ['!=', 'player_injury_day', 0],
                ['<', 'player_tire', Player::TIRE_DEFAULT]
            ]
        );
    }
}