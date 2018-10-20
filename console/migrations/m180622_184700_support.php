<?php

use yii\db\Migration;

/**
 * Class m180622_184700_support
 */
class m180622_184700_support extends Migration
{
    const TABLE = '{{%support}}';

    /**
     * @return bool|void
     */
    public function safeUp()
    {
        $this->createTable(self::TABLE, [
            'support_id' => $this->primaryKey(11),
            'support_date' => $this->integer(11)->defaultValue(0),
            'support_read' => $this->integer(11)->defaultValue(0),
            'support_text' => $this->text(),
            'support_user_id_from' => $this->integer(11)->defaultValue(0),
            'support_user_id_to' => $this->integer(11)->defaultValue(0),
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
