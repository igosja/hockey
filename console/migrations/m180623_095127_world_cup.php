<?php

use yii\db\Migration;

/**
 * Class m180623_095127_world_cup
 */
class m180623_095127_world_cup extends Migration
{
    const TABLE = '{{%world_cup}}';

    /**
     * @return bool|void
     */
    public function safeUp()
    {
        $this->createTable(self::TABLE, [
            'world_cup_id' => $this->primaryKey(11),
            'world_cup_difference' => $this->integer(3)->defaultValue(0),
            'world_cup_division_id' => $this->integer(1)->defaultValue(0),
            'world_cup_game' => $this->integer(2)->defaultValue(0),
            'world_cup_loose' => $this->integer(2)->defaultValue(0),
            'world_cup_loose_overtime' => $this->integer(2)->defaultValue(0),
            'world_cup_loose_shootout' => $this->integer(2)->defaultValue(0),
            'world_cup_national_id' => $this->integer(3)->defaultValue(0),
            'world_cup_national_type_id' => $this->integer(1)->defaultValue(0),
            'world_cup_pass' => $this->integer(3)->defaultValue(0),
            'world_cup_place' => $this->integer(2)->defaultValue(0),
            'world_cup_point' => $this->integer(2)->defaultValue(0),
            'world_cup_score' => $this->integer(3)->defaultValue(0),
            'world_cup_season_id' => $this->integer(3)->defaultValue(0),
            'world_cup_win' => $this->integer(2)->defaultValue(0),
            'world_cup_win_overtime' => $this->integer(2)->defaultValue(0),
            'world_cup_win_shootout' => $this->integer(2)->defaultValue(0),
        ]);

        $this->createIndex('world_cup_division_id', self::TABLE, 'world_cup_division_id');
        $this->createIndex('world_cup_national_id', self::TABLE, 'world_cup_national_id');
        $this->createIndex('world_cup_national_type_id', self::TABLE, 'world_cup_national_type_id');
        $this->createIndex('world_cup_season_id', self::TABLE, 'world_cup_season_id');
    }

    /**
     * @return bool|void
     */
    public function safeDown()
    {
        $this->dropTable(self::TABLE);
    }
}
