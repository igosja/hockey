<?php

class m161021_111307_userrole extends CDbMigration
{
    public function up()
    {
        $this->createTable('{{userrole}}', array(
            'userrole_id' => 'pk',
            'userrole_name' => 'VARCHAR(255) NOT NULL',
        ));
    }

    public function down()
    {
        $this->dropTable('{{userrole}}');
    }
}