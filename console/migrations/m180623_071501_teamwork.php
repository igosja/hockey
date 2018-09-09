<?php

use yii\db\Migration;

/**
 * Class m180623_071501_teamwork
 */
class m180623_071501_teamwork extends Migration
{
    const TABLE = '{{%teamwork}}';

    /**
     * @return bool|void
     */
    public function safeUp()
    {
        $this->createTable(self::TABLE, [
            'teamwork_id' => $this->primaryKey(11),
            'teamwork_player_id_1' => $this->integer(11)->defaultValue(0),
            'teamwork_player_id_2' => $this->integer(11)->defaultValue(0),
            'teamwork_value' => $this->integer(3)->defaultValue(0),
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
