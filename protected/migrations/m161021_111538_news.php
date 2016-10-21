<?php

class m161021_111538_news extends CDbMigration
{
    public function up()
    {
        $this->createTable('{{news}}', array(
            'news_id' => 'pk',
            'news_country_id' => 'INT(11) DEFAULT 0',
            'news_date' => 'INT(11) DEFAULT 0',
            'news_title' => 'VARCHAR(255) NOT NULL',
            'news_text' => 'TEXT NOT NULL',
            'news_user_id' => 'INT(11) DEFAULT 0',
        ));

        $this->createIndex('news_country_id', '{{news}}', 'news_country_id');
        $this->createIndex('news_user_id', '{{news}}', 'news_user_id');
    }

    public function down()
    {
        $this->dropTable('{{news}}');
    }
}