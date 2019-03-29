<?php

use yii\db\Migration;

/**
 * Class m190328_123754_user_block_count
 */
class m190328_123754_user_block_count extends Migration
{
    const TABLE = '{{%user}}';

    /**
     * @return bool|void
     */
    public function safeUp()
    {
        $this->addColumn(self::TABLE, 'user_block_count', $this->integer(3)->defaultValue(0)->after('user_block_comment_news_block_reason_id'));
        $this->addColumn(self::TABLE, 'user_block_count_date', $this->integer()->defaultValue(0)->after('user_block_count'));
    }

    /**
     * @return bool|void
     */
    public function safeDown()
    {
        $this->dropColumn(self::TABLE, 'user_block_count');
        $this->dropColumn(self::TABLE, 'user_block_count_date');
    }
}
