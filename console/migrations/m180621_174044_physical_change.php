<?php

use yii\db\Migration;

/**
 * Class m180621_174044_physical_change
 */
class m180621_174044_physical_change extends Migration
{
    const TABLE = '{{%physical_change}}';

    /**
     * @return bool|void
     */
    public function safeUp()
    {
        $this->createTable(self::TABLE, [
            'physical_change_id' => $this->primaryKey(11),
            'physical_change_player_id' => $this->integer(11)->defaultValue(0),
            'physical_change_season_id' => $this->integer(3)->defaultValue(0),
            'physical_change_schedule_id' => $this->integer(11)->defaultValue(0),
            'physical_change_team_id' => $this->integer(11)->defaultValue(0),
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
