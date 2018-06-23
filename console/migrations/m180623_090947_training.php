<?php

use yii\db\Migration;

/**
 * Class m180623_090947_training
 */
class m180623_090947_training extends Migration
{
    const TABLE = '{{%training}}';

    /**
     * @return bool|void
     */
    public function safeUp()
    {
        $this->createTable(self::TABLE, [
            'training_id' => $this->primaryKey(1),
            'training_percent' => $this->integer(3)->defaultValue(0),
            'training_player_id' => $this->integer(11)->defaultValue(0),
            'training_position_id' => $this->integer(1)->defaultValue(0),
            'training_power' => $this->integer(1)->defaultValue(0),
            'training_ready' => $this->integer(11)->defaultValue(0),
            'training_season_id' => $this->integer(3)->defaultValue(0),
            'training_special_id' => $this->integer(2)->defaultValue(0),
            'training_team_id' => $this->integer(11)->defaultValue(0),
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
