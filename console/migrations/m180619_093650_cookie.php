<?php

use yii\db\Migration;

/**
 * Class m180619_093650_cookie
 */
class m180619_093650_cookie extends Migration
{
    const TABLE = '{{%cookie}}';

    /**
     * @return bool|void
     */
    public function safeUp()
    {
        $this->createTable(self::TABLE, [
            'cookie_id' => $this->primaryKey(11),
            'cookie_count' => $this->integer(11)->defaultValue(0),
            'cookie_date' => $this->integer(11)->defaultValue(0),
            'cookie_user_1_id' => $this->integer(11)->defaultValue(0),
            'cookie_user_2_id' => $this->integer(11)->defaultValue(0),
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
