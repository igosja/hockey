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
            'message_support' => $this->integer(1)->defaultValue(0),
            'message_text' => $this->text(),
            'message_user_id_from' => $this->integer(11)->defaultValue(0),
            'message_user_id_to' => $this->integer(11)->defaultValue(0),
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
