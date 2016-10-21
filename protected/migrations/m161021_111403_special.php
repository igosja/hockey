<?php

class m161021_111403_special extends CDbMigration
{
    public function up()
    {
        $this->createTable('{{special}}', array(
            'special_id' => 'pk',
            'special_name' => 'VARCHAR(255) NOT NULL',
        ));
    }

    public function down()
    {
        $this->dropTable('{{special}}');
    }
}