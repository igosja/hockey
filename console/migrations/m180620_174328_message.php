<?php

use yii\db\Migration;

/**
 * Class m180620_174328_message
 */
class m180620_174328_message extends Migration
{
    const TABLE = '{{%message}}';

    /**
     * @return bool|void
     */
    public function safeUp()
    {
        $this->createTable(self::TABLE, [
            'message_id' => $this->primaryKey(11),
            'message_date' => $this->integer(11)->defaultValue(0),
            'message_read' => $this->integer(11)->defaultValue(0),
            'message_text' => $this->text(),
            'message_user_id_from' => $this->integer(11)->defaultValue(0),
            'message_user_id_to' => $this->integer(11)->defaultValue(0),
        ]);

        $this->createIndex('message_read', self::TABLE, 'message_read');
        $this->createIndex('message_user_id_from', self::TABLE, 'message_user_id_from');
        $this->createIndex('message_user_id_to', self::TABLE, 'message_user_id_to');
    }

    /**
     * @return bool|void
     */
    public function safeDown()
    {
        $this->dropTable(self::TABLE);
    }
}
