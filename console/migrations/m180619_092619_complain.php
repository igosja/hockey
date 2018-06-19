<?php

use yii\db\Migration;

/**
 * Class m180619_092619_complain
 */
class m180619_092619_complain extends Migration
{
    const TABLE = '{{%complain}}';

    /**
     * @return bool|void
     */
    public function safeUp()
    {
        $this->createTable(self::TABLE, [
            'complain_id' => $this->primaryKey(11),
            'complain_date' => $this->integer(11)->defaultValue(0),
            'complain_forum_message_id' => $this->integer(11)->defaultValue(0),
            'complain_user_id' => $this->integer(11)->defaultValue(0),
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
