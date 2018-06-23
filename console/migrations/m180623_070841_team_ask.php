<?php

use yii\db\Migration;

/**
 * Class m180623_070841_team_ask
 */
class m180623_070841_team_ask extends Migration
{
    const TABLE = '{{%team_ask}}';

    /**
     * @return bool|void
     */
    public function safeUp()
    {
        $this->createTable(self::TABLE, [
            'team_ask_id' => $this->primaryKey(1),
            'team_ask_date' => $this->integer(11)->defaultValue(0),
            'team_ask_leave_id' => $this->integer(11)->defaultValue(0),
            'team_ask_team_id' => $this->integer(11)->defaultValue(0),
            'team_ask_user_id' => $this->integer(11)->defaultValue(0),
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
