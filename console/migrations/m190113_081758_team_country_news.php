<?php

use yii\db\Migration;

/**
 * Class m190113_081758_team_country_news
 */
class m190113_081758_team_country_news extends Migration
{
    const TABLE = '{{%team}}';
    const TABLE_2 = '{{%user}}';

    /**
     * @return bool|void
     */
    public function safeUp()
    {
        $this->addColumn(self::TABLE, 'team_news_id', $this->integer()->defaultValue(0));
        $this->dropColumn(self::TABLE_2, 'user_country_news_id');
    }

    /**
     * @return bool|void
     */
    public function safeDown()
    {
        $this->addColumn(self::TABLE_2, 'user_country_news_id', $this->integer()->defaultValue(0));
        $this->dropColumn(self::TABLE, 'team_news_id');
    }
}
