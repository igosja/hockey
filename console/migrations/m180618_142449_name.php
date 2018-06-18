<?php

use yii\db\Migration;

/**
 * Class m180618_142449_name
 */
class m180618_142449_name extends Migration
{
    const TABLE = '{{%name}}';

    /**
     * @return bool|void
     */
    public function safeUp()
    {
        $this->createTable(self::TABLE, [
            'name_id' => $this->primaryKey(11),
            'name_name' => $this->string(255),
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
