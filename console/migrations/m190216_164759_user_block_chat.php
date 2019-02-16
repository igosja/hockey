<?php

use yii\db\Migration;

/**
 * Class m190216_164759_user_block_chat
 */
class m190216_164759_user_block_chat extends Migration
{
    const TABLE = '{{%user}}';

    /**
     * @return bool|void
     */
    public function safeUp()
    {
        $this->addColumn(self::TABLE, 'user_block_chat_block_reason_id', $this->integer(2)->defaultValue(0)->after('user_block_block_reason_id'));
        $this->addColumn(self::TABLE, 'user_date_block_chat', $this->integer()->defaultValue(0)->after('user_date_block'));
    }

    /**
     * @return bool|void
     */
    public function safeDown()
    {
        $this->dropColumn(self::TABLE, 'user_block_chat_block_reason_id');
        $this->dropColumn(self::TABLE, 'user_date_block_chat');
    }
}
