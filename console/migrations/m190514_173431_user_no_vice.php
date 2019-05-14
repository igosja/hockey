<?php

use yii\db\Migration;

/**
 * Class m190514_173431_user_no_vice
 */
class m190514_173431_user_no_vice extends Migration
{
    const TABLE = '{{%user}}';

    /**
     * @return bool|void
     */
    public function safeUp()
    {
        $this->addColumn(self::TABLE, 'user_no_vice', $this->integer(1)->defaultValue(0)->after('user_news_id'));
    }

    /**
     * @return bool|void
     */
    public function safeDown()
    {
        $this->dropColumn(self::TABLE, 'user_no_vice');
    }
}
