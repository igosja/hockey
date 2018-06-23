<?php

use yii\db\Migration;

/**
 * Class m180623_093512_user_role
 */
class m180623_093512_user_role extends Migration
{
    const TABLE = '{{%user_role}}';

    /**
     * @return bool|void
     */
    public function safeUp()
    {
        $this->createTable(self::TABLE, [
            'userrole_id' => $this->primaryKey(1),
            'userrole_name' => $this->string(20),
        ]);

        $this->batchInsert(self::TABLE, ['userrole_name'], [
            'User',
            'Moderator',
            'Administrator',
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
