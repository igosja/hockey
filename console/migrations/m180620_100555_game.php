<?php

use yii\db\Migration;

/**
 * Class m180620_100555_game
 */
class m180620_100555_game extends Migration
{
    const TABLE = '{{%game}}';

    /**
     * @return bool|void
     */
    public function safeUp()
    {
        $this->createTable(self::TABLE, [
            'game_id' => $this->primaryKey(11),
            'game_bonus_home' => $this->integer(1)->defaultValue(0),
            'game_guest_auto' => $this->integer(1)->defaultValue(0),
            'game_guest_collision_1' => $this->integer(1)->defaultValue(0),
            'game_guest_collision_2' => $this->integer(1)->defaultValue(0),
            'game_guest_collision_3' => $this->integer(1)->defaultValue(0),
            'game_guest_forecast' => $this->integer(4)->defaultValue(0),
            'game_guest_mood_id' => $this->integer(1)->defaultValue(0),
            'game_guest_national_id' => $this->integer(5)->defaultValue(0),
            'game_guest_optimality_1' => $this->integer(3)->defaultValue(0),
            'game_guest_optimality_2' => $this->integer(3)->defaultValue(0),
            'game_guest_penalty' => $this->integer(2)->defaultValue(0),
            'game_guest_penalty_1' => $this->integer(2)->defaultValue(0),
            'game_guest_penalty_2' => $this->integer(2)->defaultValue(0),
            'game_guest_penalty_3' => $this->integer(2)->defaultValue(0),
            'game_guest_penalty_overtime' => $this->integer(2)->defaultValue(0),
            'game_guest_plus_minus' => $this->integer(1)->defaultValue(0),
            'game_guest_plus_minus_competition' => $this->decimal(2, 1)->defaultValue(0),
            'game_guest_plus_minus_mood' => $this->decimal(2, 1)->defaultValue(0),
            'game_guest_plus_minus_optimality_1' => $this->decimal(2, 1)->defaultValue(0),
            'game_guest_plus_minus_optimality_2' => $this->decimal(3, 1)->defaultValue(0),
            'game_guest_plus_minus_power' => $this->decimal(2, 1)->defaultValue(0),
            'game_guest_plus_minus_score' => $this->decimal(2, 1)->defaultValue(0),
            'game_guest_power' => $this->integer(4)->defaultValue(0),
            'game_guest_power_percent' => $this->integer(3)->defaultValue(0),
            'game_guest_rude_1_id' => $this->integer(1)->defaultValue(0),
            'game_guest_rude_2_id' => $this->integer(1)->defaultValue(0),
            'game_guest_rude_3_id' => $this->integer(1)->defaultValue(0),
            'game_guest_score' => $this->integer(2)->defaultValue(0),
            'game_guest_score_1' => $this->integer(2)->defaultValue(0),
            'game_guest_score_2' => $this->integer(2)->defaultValue(0),
            'game_guest_score_3' => $this->integer(2)->defaultValue(0),
            'game_guest_score_overtime' => $this->integer(1)->defaultValue(0),
            'game_guest_score_shootout' => $this->integer(1)->defaultValue(0),
            'game_guest_shot' => $this->integer(2)->defaultValue(0),
            'game_guest_shot_1' => $this->integer(2)->defaultValue(0),
            'game_guest_shot_2' => $this->integer(2)->defaultValue(0),
            'game_guest_shot_3' => $this->integer(2)->defaultValue(0),
            'game_guest_shot_overtime' => $this->integer(2)->defaultValue(0),
            'game_guest_style_1_id' => $this->integer(1)->defaultValue(0),
            'game_guest_style_2_id' => $this->integer(1)->defaultValue(0),
            'game_guest_style_3_id' => $this->integer(1)->defaultValue(0),
            'game_guest_tactic_1_id' => $this->integer(1)->defaultValue(0),
            'game_guest_tactic_2_id' => $this->integer(1)->defaultValue(0),
            'game_guest_tactic_3_id' => $this->integer(1)->defaultValue(0),
            'game_guest_team_id' => $this->integer(5)->defaultValue(0),
            'game_guest_teamwork_1' => $this->double(2)->defaultValue(0),
            'game_guest_teamwork_2' => $this->double(2)->defaultValue(0),
            'game_guest_teamwork_3' => $this->double(2)->defaultValue(0),
            'game_home_auto' => $this->integer(1)->defaultValue(0),
            'game_home_collision_1' => $this->integer(1)->defaultValue(0),
            'game_home_collision_2' => $this->integer(1)->defaultValue(0),
            'game_home_collision_3' => $this->integer(1)->defaultValue(0),
            'game_home_forecast' => $this->integer(4)->defaultValue(0),
            'game_home_mood_id' => $this->integer(1)->defaultValue(0),
            'game_home_national_id' => $this->integer(5)->defaultValue(0),
            'game_home_optimality_1' => $this->integer(3)->defaultValue(0),
            'game_home_optimality_2' => $this->integer(3)->defaultValue(0),
            'game_home_penalty' => $this->integer(2)->defaultValue(0),
            'game_home_penalty_1' => $this->integer(2)->defaultValue(0),
            'game_home_penalty_2' => $this->integer(2)->defaultValue(0),
            'game_home_penalty_3' => $this->integer(2)->defaultValue(0),
            'game_home_penalty_overtime' => $this->integer(2)->defaultValue(0),
            'game_home_plus_minus' => $this->integer(1)->defaultValue(0),
            'game_home_plus_minus_competition' => $this->decimal(2, 1)->defaultValue(0),
            'game_home_plus_minus_mood' => $this->decimal(2, 1)->defaultValue(0),
            'game_home_plus_minus_optimality_1' => $this->decimal(2, 1)->defaultValue(0),
            'game_home_plus_minus_optimality_2' => $this->decimal(3, 1)->defaultValue(0),
            'game_home_plus_minus_power' => $this->decimal(2, 1)->defaultValue(0),
            'game_home_plus_minus_score' => $this->decimal(2, 1)->defaultValue(0),
            'game_home_power' => $this->integer(4)->defaultValue(0),
            'game_home_power_percent' => $this->integer(3)->defaultValue(0),
            'game_home_rude_1_id' => $this->integer(1)->defaultValue(0),
            'game_home_rude_2_id' => $this->integer(1)->defaultValue(0),
            'game_home_rude_3_id' => $this->integer(1)->defaultValue(0),
            'game_home_score' => $this->integer(2)->defaultValue(0),
            'game_home_score_1' => $this->integer(2)->defaultValue(0),
            'game_home_score_2' => $this->integer(2)->defaultValue(0),
            'game_home_score_3' => $this->integer(2)->defaultValue(0),
            'game_home_score_overtime' => $this->integer(1)->defaultValue(0),
            'game_home_score_shootout' => $this->integer(1)->defaultValue(0),
            'game_home_shot' => $this->integer(2)->defaultValue(0),
            'game_home_shot_1' => $this->integer(2)->defaultValue(0),
            'game_home_shot_2' => $this->integer(2)->defaultValue(0),
            'game_home_shot_3' => $this->integer(2)->defaultValue(0),
            'game_home_shot_overtime' => $this->integer(2)->defaultValue(0),
            'game_home_style_1_id' => $this->integer(1)->defaultValue(0),
            'game_home_style_2_id' => $this->integer(1)->defaultValue(0),
            'game_home_style_3_id' => $this->integer(1)->defaultValue(0),
            'game_home_tactic_1_id' => $this->integer(1)->defaultValue(0),
            'game_home_tactic_2_id' => $this->integer(1)->defaultValue(0),
            'game_home_tactic_3_id' => $this->integer(1)->defaultValue(0),
            'game_home_team_id' => $this->integer(5)->defaultValue(0),
            'game_home_teamwork_1' => $this->double(2)->defaultValue(0),
            'game_home_teamwork_2' => $this->double(2)->defaultValue(0),
            'game_home_teamwork_3' => $this->double(2)->defaultValue(0),
            'game_played' => $this->integer(1)->defaultValue(0),
            'game_ticket' => $this->integer(2)->defaultValue(0),
            'game_schedule_id' => $this->integer(11)->defaultValue(0),
            'game_stadium_capacity' => $this->integer(5)->defaultValue(0),
            'game_stadium_id' => $this->integer(5)->defaultValue(0),
            'game_visitor' => $this->integer(5)->defaultValue(0),
        ]);
    }

    /**
     * @return bool|void
     */
    public function safeDown()
    {
        $this->dropTable(self::TABLE);
    }
}
