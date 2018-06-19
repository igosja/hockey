<?php

use yii\db\Migration;

/**
 * Class m180619_080227_block_reason
 */
class m180619_080227_block_reason extends Migration
{
    const TABLE = '{{%block_reason}}';

    /**
     * @return bool|void
     */
    public function safeUp()
    {
        $this->createTable(self::TABLE, [
            'block_reason_id' => $this->primaryKey(),
            'block_reason_text' => $this->string(255),
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
