<?php

class m161021_111543_newscomment extends CDbMigration
{
    public function up()
    {
        $this->createTable('{{newscomment}}', array(
            'newscomment_id' => 'pk',
            'newscomment_date' => 'INT(11) DEFAULT 0',
            'newscomment_news_id' => 'INT(11) DEFAULT 0',
            'newscomment_text' => 'TEXT NOT NULL',
            'newscomment_user_id' => 'INT(11) DEFAULT 0',
        ));

        $this->createIndex('newscomment_news_id', '{{newscomment}}', 'newscomment_news_id');
        $this->createIndex('newscomment_user_id', '{{newscomment}}', 'newscomment_user_id');
    }

    public function down()
    {
        $this->dropTable('{{newscomment}}');
    }
}