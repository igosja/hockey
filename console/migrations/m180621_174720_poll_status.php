<?php

use yii\db\Migration;

/**
 * Class m180621_174720_poll_status
 */
class m180621_174720_poll_status extends Migration
{
    const TABLE = '{{%poll_status}}';

    /**
     * @return bool|void
     */
    public function safeUp()
    {
        $this->createTable(self::TABLE, [
            'poll_status_id' => $this->primaryKey(1),
            'poll_status_name' => $this->string(25),
        ]);

        $this->batchInsert(self::TABLE, ['poll_status_name'], [
            ['Ожидает проверки'],
            ['Открыто'],
            ['Закрыто'],
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
