<?php

use yii\db\Migration;

/**
 * Class m180621_174730_poll_user
 */
class m180621_174730_poll_user extends Migration
{
    const TABLE = '{{%poll_user}}';

    /**
     * @return bool|void
     */
    public function safeUp()
    {
        $this->createTable(self::TABLE, [
            'poll_user_id' => $this->primaryKey(11),
            'poll_user_answer_id' => $this->integer(11)->defaultValue(0),
            'poll_user_date' => $this->integer(11)->defaultValue(0),
            'poll_user_user_id' => $this->integer(11)->defaultValue(0),
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
