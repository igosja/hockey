<?php

use yii\db\Migration;

/**
 * Class m180619_092619_complain
 */
class m180619_092619_complaint extends Migration
{
    const TABLE = '{{%complaint}}';

    /**
     * @return bool|void
     */
    public function safeUp()
    {
        $this->createTable(self::TABLE, [
            'complaint_id' => $this->primaryKey(11),
            'complaint_date' => $this->integer(11)->defaultValue(0),
            'complaint_forum_message_id' => $this->integer(11)->defaultValue(0),
            'complaint_ready' => $this->integer(11)->defaultValue(0),
            'complaint_user_id' => $this->integer(11)->defaultValue(0),
        ]);

        $this->createIndex('complaint_ready', self::TABLE, 'complaint_ready');
    }

    /**
     * @return bool|void
     */
    public function safeDown()
    {
        $this->dropTable(self::TABLE);
    }
}
