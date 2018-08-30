<?php

use yii\db\Migration;

/**
 * Class m180620_181700_news
 */
class m180620_181700_news extends Migration
{
    const TABLE = '{{%news}}';

    /**
     * @return bool|void
     */
    public function safeUp()
    {
        $this->createTable(self::TABLE, [
            'news_id' => $this->primaryKey(11),
            'news_check' => $this->integer(11)->defaultValue(0),
            'news_country_id' => $this->integer(3)->defaultValue(0),
            'news_date' => $this->integer(11)->defaultValue(0),
            'news_text' => $this->text(),
            'news_title' => $this->string(255),
            'news_user_id' => $this->integer(11)->defaultValue(0),
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
