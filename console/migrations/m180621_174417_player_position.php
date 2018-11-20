<?php

use yii\db\Migration;

/**
 * Class m180621_174417_player_position
 */
class m180621_174417_player_position extends Migration
{
    const TABLE = '{{%player_position}}';

    /**
     * @return bool|void
     */
    public function safeUp()
    {
        $this->createTable(self::TABLE, [
            'player_position_player_id' => $this->integer(11)->defaultValue(0),
            'player_position_position_id' => $this->integer(1)->defaultValue(0),
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
