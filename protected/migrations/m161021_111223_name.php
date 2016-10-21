<?php

class m161021_111223_name extends CDbMigration
{
    public function up()
    {
        $this->createTable('{{name}}', array(
            'name_id' => 'pk',
            'name_name' => 'VARCHAR(255) NOT NULL',
        ));
    }

    public function down()
    {
        $this->dropTable('{{name}}');
    }
}