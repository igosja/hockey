<?php

use yii\db\Migration;

/**
 * Class m190315_161225_user_notes
 */
class m190315_161225_user_notes extends Migration
{
    const TABLE = '{{%user}}';

    /**
     * @return bool|void
     */
    public function safeUp()
    {
        $this->addColumn(self::TABLE, 'user_notes', $this->text()->after('user_news_id'));
    }

    /**
     * @return bool|void
     */
    public function safeDown()
    {
        $this->dropColumn(self::TABLE, 'user_notes');
    }
}
