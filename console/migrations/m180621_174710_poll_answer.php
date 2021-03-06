<?php

use yii\db\Migration;

/**
 * Class m180621_174710_poll_answer
 */
class m180621_174710_poll_answer extends Migration
{
    const TABLE = '{{%poll_answer}}';

    /**
     * @return bool|void
     */
    public function safeUp()
    {
        $this->createTable(self::TABLE, [
            'poll_answer_id' => $this->primaryKey(11),
            'poll_answer_text' => $this->text(),
            'poll_answer_poll_id' => $this->integer(11)->defaultValue(0),
        ]);

        $this->createIndex('poll_answer_poll_id', self::TABLE, 'poll_answer_poll_id');
    }

    /**
     * @return bool|void
     */
    public function safeDown()
    {
        $this->dropTable(self::TABLE);
    }
}
