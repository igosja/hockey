<?php

class m161021_111344_style extends CDbMigration
{
    public function up()
    {
        $this->createTable('{{style}}', array(
            'style_id' => 'pk',
            'style_name' => 'VARCHAR(255) NOT NULL',
        ));
    }

    public function down()
    {
        $this->dropTable('{{style}}');
    }
}