<?php

use yii\db\Migration;

/**
 * Class m180618_143046_surname
 */
class m180618_143046_surname extends Migration
{
    const TABLE = '{{%surname}}';

    /**
     * @return bool|void
     */
    public function safeUp()
    {
        $this->createTable(self::TABLE, [
            'surname_id' => $this->primaryKey(11),
            'surname_name' => $this->string(255),
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
