<?php

use yii\db\Migration;

/**
 * Class m180620_135826_lineup
 */
class m180620_135826_lineup extends Migration
{
    const TABLE = '{{%lineup}}';

    /**
     * @return bool|void
     */
    public function safeUp()
    {
        $this->createTable(self::TABLE, [
            'lineup_id' => $this->primaryKey(11),
            'lineup_age' => $this->integer(2)->defaultValue(0),
            'lineup_assist' => $this->integer(3)->defaultValue(0),
            'lineup_game_id' => $this->integer(11)->defaultValue(0),
            'lineup_line_id' => $this->integer(1)->defaultValue(0),
            'lineup_national_id' => $this->integer(5)->defaultValue(0),
            'lineup_pass' => $this->integer(3)->defaultValue(0),
            'lineup_penalty' => $this->integer(3)->defaultValue(0),
            'lineup_player_id' => $this->integer(1)->defaultValue(0),
            'lineup_plus_minus' => $this->integer(3)->defaultValue(0),
            'lineup_position_id' => $this->integer(1)->defaultValue(0),
            'lineup_power_change' => $this->integer(1)->defaultValue(0),
            'lineup_power_nominal' => $this->integer(3)->defaultValue(0),
            'lineup_power_real' => $this->integer(3)->defaultValue(0),
            'lineup_score' => $this->integer(3)->defaultValue(0),
            'lineup_shot' => $this->integer(3)->defaultValue(0),
            'lineup_team_id' => $this->integer(5)->defaultValue(0),
        ]);

        $this->createIndex('lineup_game_id', self::TABLE, 'lineup_game_id');
        $this->createIndex('lineup_national_id', self::TABLE, 'lineup_national_id');
        $this->createIndex('lineup_player_id', self::TABLE, 'lineup_player_id');
        $this->createIndex('lineup_team_id', self::TABLE, 'lineup_team_id');
    }

    /**
     * @return bool|void
     */
    public function safeDown()
    {
        $this->dropTable(self::TABLE);
    }
}
