<?php

use yii\db\Migration;

/**
 * Class m180622_190611_swiss
 */
class m180622_190611_swiss extends Migration
{
    const TABLE = '{{%swiss}}';

    /**
     * @return bool|void
     */
    public function safeUp()
    {
        $this->createTable(self::TABLE, [
            'swiss_id' => $this->primaryKey(11),
            'swiss_guest' => $this->integer(2)->defaultValue(0),
            'swiss_home' => $this->integer(2)->defaultValue(0),
            'swiss_place' => $this->integer(11)->defaultValue(0),
            'swiss_team_id' => $this->integer(11)->defaultValue(0),
        ]);

        $this->createIndex('swiss_team_id', self::TABLE, 'swiss_team_id');
    }

    /**
     * @return bool|void
     */
    public function safeDown()
    {
        $this->dropTable(self::TABLE);
    }
}
