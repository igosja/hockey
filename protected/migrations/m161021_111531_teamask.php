<?php

class m161021_111531_teamask extends CDbMigration
{
    public function up()
    {
        $this->createTable('{{teamask}}', array(
            'teamask_id' => 'pk',
            'teamask_date' => 'INT(11) DEFAULT 0',
            'teamask_team_id' => 'INT(11) DEFAULT 0',
            'teamask_user_id' => 'INT(11) DEFAULT 0',
        ));

        $this->createIndex('teamask_team_id', '{{teamask}}', 'teamask_team_id');
        $this->createIndex('teamask_user_id', '{{teamask}}', 'teamask_user_id');
    }

    public function down()
    {
        $this->dropTable('{{teamask}}');
    }
}